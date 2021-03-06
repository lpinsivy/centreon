<?php
/*
 * Copyright 2005-2015 CENTREON
 * Centreon is developped by : Julien Mathis and Romain Le Merlus under
 * GPL Licence 2.0.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License as published by the Free Software
 * Foundation ; either version 2 of the License.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
 * PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * this program; if not, see <http://www.gnu.org/licenses>.
 *
 * Linking this program statically or dynamically with other modules is making a
 * combined work based on this program. Thus, the terms and conditions of the GNU
 * General Public License cover the whole combination.
 *
 * As a special exception, the copyright holders of this program give CENTREON
 * permission to link this program with independent modules to produce an executable,
 * regardless of the license terms of these independent modules, and to copy and
 * distribute the resulting executable under terms of CENTREON choice, provided that
 * CENTREON also meet, for each linked independent module, the terms  and conditions
 * of the license of that module. An independent module is a module which is not
 * derived from this program. If you modify this program, you may extend this
 * exception to your version of the program, but you are not obliged to do so. If you
 * do not wish to do so, delete this exception statement from your version.
 *
 * For more information : contact@centreon.com
 *
 */

namespace CentreonConfiguration\Repository;

use Centreon\Internal\Di;
use Centreon\Internal\Exception;
use CentreonConfiguration\Forms\Validators\TemplateField as TemplateFieldValidator;
use CentreonConfiguration\Internal\Poller\Template\Manager as TemplateManager;
use CentreonConfiguration\Events\EngineFormSave;
use CentreonConfiguration\Events\BrokerFormSave;
use CentreonConfiguration\Models\Poller;
use CentreonConfiguration\Models\Node;
use CentreonConfiguration\Repository\Repository;

/**
 * @author Lionel Assepo <lassepo@centreon.com>
 * @package Centreon
 * @subpackage Repository
 */
class PollerRepository extends Repository
{
    /**
     *
     * @var string
     */
    public static $objectName = 'Poller';
    
    public static $objectClass = '\CentreonConfiguration\Models\Poller';
        
    /**
     *
     * @var type 
     */

    public static $unicityFields = array(
        'fields' => array(
            'poller' => 'cfg_pollers, poller_id, cfg_pollers.name'
            ),
        'joint' => 'cfg_nodes',
        'jointCondition' => 'cfg_nodes.node_id = cfg_pollers.node_id '
    );
    
    /**
     *
     * Check if a service or an host has been
     * changed for a specific poller.
     *
     * @param int $pollerId
     * @param int $lastRestart
     * @return int
     */
    public static function checkChangeState($pollerId, $lastRestart)
    {
        if (!isset($lastRestart) || !$lastRestart) {
            return 0;
        }

        // Get centreon DB and centreon storage DB connection
        $di = Di::getDefault();
        $db = $di->get('db_centreon');

        $request = "SELECT *
            FROM log_action
            WHERE
                action_log_date > ? AND
                ((object_type = 'host' AND
                object_id IN (
                    SELECT host_id
                        FROM cfg_hosts
                        WHERE poller_id = ?
                )) OR
                    (object_type = 'service') AND
                        object_id IN (
                    SELECT service_service_id
                    FROM cfg_hosts_services_relations hsr, cfg_hosts h
                    WHERE h.poller_id = ? AND hsr.host_host_id = h.host_id
        ))";
        $stmt = $db->prepare($request);
        $stmt->execute(array($lastRestart, $pollerId, $pollerId));
        if ($stmt->rowCount()) {
            return 1;
        }
        return 0;
    }
    
    /**
     * 
     * @return array
     */
    public static function getPollerTemplates()
    {
        $di = Di::getDefault();
        
        $templatesList = array_map(
            function($t) {
                return serialize($t);
            },
            TemplateManager::buildTemplatesList()
        );
        
        $di->set(
            'pollerTemplate',
            function() use ($templatesList) {
                return $templatesList;
            }
        );
    }

    /**
     *
     * @param type $givenParameters
     * @param type $origin
     * @param type $route
     */
    protected static function validateForm($givenParameters, $origin = "", $route = "", $validateMandatory = true)
    {
        if (is_a($givenParameters, '\Klein\DataCollection\DataCollection')) {
            $givenParameters = $givenParameters->all();
        }

        self::getPollerTemplates();
        $di = Di::getDefault();
        $pollerTemplateList = $di->get('pollerTemplate');

        /* Check if poller template exists */
        if (isset($givenParameters['tmpl_name']) && !isset($pollerTemplateList[$givenParameters['tmpl_name']])) {
            $sTpl = "";
            if (isset($givenParameters['tmpl_name'])) {
                $sTpl = $givenParameters['tmpl_name'];
            }
            throw new Exception(_("Poller template '" . $sTpl . "' does not exist"), 255);
        }

        if (isset($givenParameters['tmpl_name'])) {
            $myLiteTemplate = unserialize($pollerTemplateList[$givenParameters['tmpl_name']]);
            $myTemplate = $myLiteTemplate->toFullTemplate();
            $setups = $myTemplate->getBrokerPart()->getSetup();
            $customFields = array();
            foreach ($setups as $setup) {
                $customFields = $setup->getFields();
                $value = null;
                foreach ($customFields as $customField) {
                    if (isset($givenParameters[$customField['name']])) {
                        $value = $givenParameters[$customField['name']];
                    }
                    TemplateFieldValidator::validate($value, $customField);
                }
            }
        }

        parent::validateForm($givenParameters, $origin, $route, $validateMandatory);
    }

    /**
     * Create a poller
     *
     * @param array $params The parameters for create a poller
     * @return int The id of poller created
     */
    public static function create($params, $origin = "", $route = "", $validate = true, $validateMandatory = true)
    {
        try {
            if ($validate) {
                self::validateForm($params, $origin, $route, $validateMandatory);
            }

            $di = Di::getDefault();
            $orgId = $di->get('organization');

            $nodeId = NodeRepository::create($params);

            $params['node_id'] = $nodeId;
            $params['organization_id'] = $orgId;
            $params['port'] = 0;

            $pollerId = parent::create($params, $origin, $route, true, false);

            return $pollerId;
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 255);
        }
    }


    /**
     * Poller update function
     *
     * @param array $givenParameters The parameters for update a poller
     */
    public static function update($params, $origin = "", $route = "", $validate = true, $validateMandatory = true)
    {    
        if ($validate) {
            self::validateForm($params, "form", $route, $validateMandatory);
        }
        
        $di = Di::getDefault();

        NodeRepository::update($params);
        
        parent::update($params, $origin, $route, true, false);
    }


    /**
     * Delete a poller
     *
     * @param array $ids | array of ids to delete
     */
    public static function delete($ids)
    {
        foreach ($ids as $id) {
            if ($id) {
                $node = static::getNode($id);
                Node::delete($node['node_id']);
            }
        }
        /* Poller will also get deleted due to delete cascade */
    }

    /**
     * Get the node information
     *
     * @return array
     */
    public static function getNode($pollerId)
    {
        $poller = Poller::get($pollerId);
        return Node::get($poller['node_id']);
    }
    
    /**
     * 
     * @param integer $pollerId
     * @return type
     * @throws Exception
     */
    public static function getTemplate($pollerId)
    {
        $paramsPoller = Poller::get($pollerId, 'tmpl_name');
        if (!isset($paramsPoller['tmpl_name']) || is_null($paramsPoller['tmpl_name'])) {
            throw new Exception('Not template defined');
        }
        $tmplName = $paramsPoller['tmpl_name'];

        /* Load template information for poller */
        $listTpl = TemplateManager::buildTemplatesList();
        if (!isset($listTpl[$tmplName])) {
            throw new Exception('The template is not found on list of templates', 255);
        }
        
        return $listTpl[$tmplName];
    }

    /**
     *
     * @param integer $pollerId
     * @return type
     * @throws Exception
     */
    public static function addCommandTemplateInfos($templateName = null)
    {
        self::getPollerTemplates();
        $di = Di::getDefault();
        $pollerTemplateList = $di->get('pollerTemplate');

        /* Check if poller template exists */
        if (!isset($templateName) || !isset($pollerTemplateList[$templateName])) {
            $sTpl = "";
            if (isset($templateName)) {
                $sTpl = $templateName;
            }
            throw new Exception(_("Poller template '" . $sTpl . "' does not exist"), 255);
        }

        $myLiteTemplate = unserialize($pollerTemplateList[$templateName]);
        $myTemplate = $myLiteTemplate->toFullTemplate();
        $setups = $myTemplate->getBrokerPart()->getSetup();
        $customFields = array();
        foreach ($setups as $setup) {
            $TempCustomFields = $setup->getFields();
            foreach ($TempCustomFields as $TempCustomField) {
                $customFields[] = $TempCustomField;
            }
        }
        return $customFields;
    }
}
