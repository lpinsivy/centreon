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

namespace CentreonConfiguration\Internal;

use Centreon\Internal\Di;
use Centreon\Internal\Utils\HumanReadable;
use Centreon\Internal\Datatable\Datasource\CentreonDb;
use CentreonConfiguration\Repository\ServiceRepository;
use CentreonConfiguration\Repository\ServicetemplateRepository;
use CentreonAdministration\Repository\TagsRepository;
use Centreon\Internal\Datatable;

/**
 * Description of ServiceTemplateDatatable
 *
 * @author lionel
 */
class ServiceTemplateDatatable extends Datatable
{
    /**
     *
     * @var array 
     */
    protected static $configuration = array(
        'autowidth' => true,
        'order' => array(
            array('service_description', 'asc')
        ),
        'stateSave' => false,
        'paging' => true,
    );
    
    protected static $dataprovider = '\Centreon\Internal\Datatable\Dataprovider\CentreonDb';
    
    /**
     *
     * @var type 
     */
    protected static $datasource = '\CentreonConfiguration\Models\Servicetemplate';
    

    
    /**
     *
     * @var type 
     */
    protected static $rowIdColumn = array('id' => 'service_id', 'name' => 'service_description');
    
    /**
     *
     * @var array 
     */
    protected static  $aFieldNotAuthorized = array();
    
    protected static $extraParams = array(
        'addToHook' => array(
            'objectType' => 'service'
        )
    );

    protected static $hookParams = array(
        'resourceType' => 'service'
    );
    /**
     *
     * @var array 
     */
    public static $columns = array(
        array (
            'title' => "Id",
            'name' => 'service_id',
            'data' => 'service_id',
            'orderable' => false,
            'searchable' => false,
            'type' => 'string',
            'visible' => false,
            'className' => 'cell_center',
            'width' => "20px"
        ),
        array (
            'title' => 'Name',
            'name' => 'service_description',
            'data' => 'service_description',
            'orderable' => true,
            'searchable' => true,
            'searchLabel' => 'servicetemplate',
            'type' => 'string',
            'visible' => true,
            'cast' => array(
                'type' => 'url',
                'parameters' => array(
                    'route' => '/centreon-configuration/servicetemplate/[i:id]',
                    'routeParams' => array(
                        'id' => '::service_id::',
                        'advanced' => '0'
                    ),
                    'linkName' => '::service_description::'
                )
            ),
        ),
        array (
            'title' => 'Interval',
            'name' => 'service_normal_check_interval',
            'data' => 'service_normal_check_interval',
            'orderable' => false,
            'searchable' => false,
            'type' => 'string',
            'visible' => true,
            "className" => 'cell_center',
            "width" => '40px'
        ),
        array (
            'title' => 'Retry',
            'name' => 'service_retry_check_interval',
            'data' => 'service_retry_check_interval',
            'orderable' => false,
            'searchable' => false,
            'type' => 'string',
            'visible' => true,
            "className" => 'cell_center',
            "width" => '40px'
        ),
        array (
            'title' => 'Attempts',
            'name' => 'service_max_check_attempts',
            'data' => 'service_max_check_attempts',
            'orderable' => false,
            'searchable' => false,
            'type' => 'string',
            'visible' => true,
            "className" => 'cell_center',
            "width" => '40px'
        ),
        array (
            'title' => 'Parent Template',
            'name' => 'service_template_model_stm_id',
            'data' => 'service_template_model_stm_id',
            'orderable' => false,
            'searchable' => false,
            'type' => 'string',
            'visible' => true,
        ),
        array (
            'title' => 'Status',
            'name' => 'service_activate',
            'data' => 'service_activate',
            'orderable' => true,
            'searchable' => true,
            'type' => 'string',
            'visible' => true,
            'cast' => array(
                'type' => 'select',
                'parameters' =>array(
                    '0' => '<span class="label label-danger">Disabled</span>',
                    '1' => '<span class="label label-success">Enabled</span>',
                    '2' => '<span class="label label-warning">Trash</span>',
                )
            ),
            'searchParam' => array(
                'type' => 'select',
                'additionnalParams' => array(
                    'Enabled' => '1',
                    'Disabled' => '0'
                )
            ),
            "className" => 'cell_center'
        ),
        array (
            'title' => 'Tags',
            'name' => 'tagname',
            'data' => 'tagname',
            'orderable' => false,
            'searchable' => true,
            'type' => 'string',
            'visible' => true,
            'width' => '40px',
            'source' => 'relation'
        )
    );
    
    /**
     * 
     * @param array $params
     */
    public function __construct($params, $objectModelClass = '')
    {
        parent::__construct($params, $objectModelClass);
    }

    /**
     * 
     * @param array $resultSet
     */
    protected function formatDatas(&$resultSet)
    {
        $router = Di::getDefault()->get('router');

        foreach ($resultSet as &$myServiceSet) {
            $myServiceSet['service_description'] = '<span class="icoListing">'.
            ServiceRepository::getIconImage($myServiceSet['service_id']).'</span>'.
            $myServiceSet['service_description'];


            // Set Tpl Chain
            $tplStr = null;
            if (isset($myServiceSet["service_template_model_stm_id"])) {
                $tplArr = ServicetemplateRepository::getMyServiceTemplateModels($myServiceSet["service_template_model_stm_id"]);
                $tplRoute = str_replace(
                                        "//",
                                        "/",
                                        Di::getDefault()
                                        ->get('router')
                                        ->getPathFor(
                                                     '/centreon-configuration/servicetemplate/[i:id]',
                                                     array('id' => $tplArr['id'])
                                                     )
                                        );
                if (isset($tplArr['description'])) {
                    $tplStr .= '<span><a href="'.
                        $tplRoute.
                        '">'.
                        $tplArr['description'].
                        '</a></span>';
                }
            }
            $myServiceSet['service_template_model_stm_id'] = $tplStr;

            /* Display human readable the check/retry interval */
            $myServiceSet['service_normal_check_interval'] = HumanReadable::convert($myServiceSet['service_normal_check_interval'], 's', $units, null, true);
            $myServiceSet['service_retry_check_interval'] = HumanReadable::convert($myServiceSet['service_retry_check_interval'], 's', $units, null, true);

            /* Get personal tags */
            $myServiceSet['tagname'] = '';
            $aTagUsed = array();

            $aTags = TagsRepository::getList('service', $myServiceSet['service_id'], 0, 0);

            foreach ($aTags as $oTags) {
                if (!in_array($oTags['id'], $aTagUsed)) {
                    $aTagUsed[] = $oTags['id'];
                    $myServiceSet['tagname'] .= TagsRepository::getTag('service',$myServiceSet['service_id'], $oTags['id'], $oTags['text'], $oTags['user_id'], 1);
                }
            }

            $myServiceSet['tagname'] .= TagsRepository::getAddTag('service', $myServiceSet['service_id']);
        }
    }
}
