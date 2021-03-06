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

namespace CentreonConfiguration\Controllers;

use Centreon\Internal\Di;
use CentreonConfiguration\Repository\CustomMacroRepository;
use CentreonConfiguration\Repository\ServiceRepository;
use CentreonConfiguration\Models\Service;
use CentreonConfiguration\Models\Host;
use CentreonConfiguration\Models\Relation\Host\Service as HostService;
use Centreon\Controllers\FormController;
use CentreonAdministration\Repository\TagsRepository;

class ServiceController extends FormController
{
    protected $objectDisplayName = 'Service';
    public static $objectName = 'service';
    public static $enableDisableFieldName = 'service_activate'; 
    protected $objectBaseUrl = '/centreon-configuration/service';
    protected $datatableObject = '\CentreonConfiguration\Internal\ServiceDatatable';
    protected $objectClass = '\CentreonConfiguration\Models\Service';
    protected $repository = '\CentreonConfiguration\Repository\ServiceRepository';
    public static $relationMap = array(
        'service_hosts' => '\CentreonConfiguration\Models\Relation\Service\Host',
        'service_parents' => '\CentreonConfiguration\Models\Relation\Service\Serviceparent',
        'service_childs' => '\CentreonConfiguration\Models\Relation\Service\Servicechild',
        'service_servicetemplates' => '\CentreonConfiguration\Models\Relation\Service\Servicetemplate',
        'service_traps' => '\CentreonConfiguration\Models\Relation\Trap\Service',
        'service_icon' => '\CentreonConfiguration\Models\Relation\Service\Icon'
    );
    
    public static $isDisableable = true;

    protected $inheritanceUrl = '/centreon-configuration/servicetemplate/[i:id]/inheritance';
    protected $inheritanceTmplUrl = '/centreon-configuration/servicetemplate/inheritance';
    protected $tmplField = '#service_template_model_stm_id';
    protected $inheritanceTagsUrl = '/centreon-administration/tag/[i:id]/service/herited';

    /**
     * List services
     *
     * @method get
     * @route /service
     */
    public function listAction()
    {
        $router = Di::getDefault()->get('router');
        $this->tpl->addJs('jquery.qtip.min.js')
        //addJs('centreon.overlay.js')
            ->addJs('hogan-3.0.0.min.js')
            ->addJs('centreon.tag.js', 'bottom', 'centreon-administration')
            ->addJs('moment-with-locales.js')
            ->addJs('moment-timezone-with-data.min.js')
            ->addJs('centreon-clone.js')
            ->addJs('component/custommacro.js')
            ->addCss('centreon.qtip.css')
            ->addCss('centreon.tag.css', 'centreon-administration');
        $urls = array(
            'tag' => array(
                'add' => $router->getPathFor('/centreon-administration/tag/add'),
                'del' => $router->getPathFor('/centreon-administration/tag/delete'),
                'getallGlobal' => $router->getPathFor('/centreon-administration/tag/all'),
                'getallPerso' => $router->getPathFor('/centreon-administration/tag/allPerso'),
                'addMassive' => $router->getPathFor('/centreon-administration/tag/addMassive')
            )
        );

        $this->tpl->addCustomJs('$(function () {
                $("#modal").on("loaded.bs.modal", function() {
                    initCustomMacro();
                });
            });');
                
        $this->tpl->append('jsUrl', $urls, true);
        $this->tpl->assign('configuration', true);
        parent::listAction();
    }

    /**
     * 
     * @method get
     * @route /service/formlist
     */
    public function formListAction()
    {
        $di = Di::getDefault();
        $router = $di->get('router');
        
        $requestParams = $this->getParams('get');
        $serviceId = Service::getPrimaryKey();
        $serviceDescription = Service::getUniqueLabelField();
        $hostId = Host::getPrimaryKey();
        $hostName = Host::getUniqueLabelField();
        $filters = array(
            $serviceDescription => '%'.$requestParams['q'].'%',
            $hostName => '%'.$requestParams['q'].'%',
        );
        $list = HostService::getMergedParameters(
            array($hostId, $hostName),
            array($serviceId, $serviceDescription),
            -1,
            0,
            null,
            "ASC",
            $filters,
            "OR"
        );
        $finalList = array();
        foreach ($list as $obj) {
            $finalList[] = array(
                "id" => $obj[$serviceId],
                "text" => $obj[$hostName] . ' ' . $obj[$serviceDescription]
            );
        }
        $router->response()->json($finalList);
    }
    
    /**
     * 
     * @method get
     * @route /service/formlistcomplete
     */
    public function formListCompleteAction()
    {
        $di = Di::getDefault();
        $router = $di->get('router');
        
        $requestParams = $this->getParams('get');
        $serviceId = Service::getPrimaryKey();
        $serviceDescription = Service::getUniqueLabelField();
        $hostId = Host::getPrimaryKey();
        $hostName = Host::getUniqueLabelField();
        $filters = array(
            $serviceDescription => '%'.$requestParams['q'].'%',
            $hostName => '%'.$requestParams['q'].'%',
        );
        $list = HostService::getMergedParameters(
            array($hostId, $hostName),
            array($serviceId, $serviceDescription),
            -1,
            0,
            null,
            "ASC",
            $filters,
            "OR"
        );
        $finalList = array();
        foreach ($list as $obj) {
            $finalList[] = array(
                "id" => $obj[$serviceId] . '_' . $obj[$hostId],
                "text" => $obj[$hostName] . ' ' . $obj[$serviceDescription]
            );
        }
        $router->response()->json($finalList);
    }

    /**
     * Update a service
     *
     * @method post
     * @route /service/update
     */
    public function updateAction()
    {
        $macroList = array();
        $aTagList = array();
        $aTags = array();
        $aTagsInTpl = array();
        $aTagsIdTpl = array();
        $aTagsTemplate = array();

        $givenParameters = $this->getParams('post');
        
        if (isset($givenParameters['macro_name']) && isset($givenParameters['macro_value'])) {
            
            $macroName = $givenParameters['macro_name'];
            $macroValue = $givenParameters['macro_value'];
            
            $macroHidden = $givenParameters['macro_hidden'];
            
            foreach ($macroName as $key => $name) {
                if (!empty($name)) {
                    if (isset($macroHidden[$key])) {
                        $isPassword = '1';
                    } else {
                        $isPassword = '0';
                    }

                    $macroList[$name] = array(
                        'value' => $macroValue[$key],
                        'ispassword' => $isPassword
                    );
                }
            }
        }
        
        if (count($macroList) > 0) {
            try{
                CustomMacroRepository::saveServiceCustomMacro(self::$objectName, $givenParameters['object_id'], $macroList);
            } catch (\Exception $ex) {
                $errorMessage = $ex->getMessage();
                $this->router->response()->json(array('success' => false,'error' => $errorMessage));
            }
        }
        
        //Delete all tags
        TagsRepository::deleteTagsForResource(self::$objectName, $givenParameters['object_id'], 0);
        
        //Insert tags affected to the service
        if (isset($givenParameters['service_tags'])) {
            $aTagList = explode(",", $givenParameters['service_tags']);
            foreach ($aTagList as $var) {
                $var = trim($var);
                if (!empty($var)) {
                    array_push($aTags, $var);
                }
            }
            
            if (count($aTags) > 0) {
                TagsRepository::saveTagsForResource(self::$objectName, $givenParameters['object_id'], $aTags, '', false, 1);
            }
        }
  
        parent::updateAction();
    }
    
    /**
     * Add a service
     *
     * @method post
     * @route /service/add
     */
    public function createAction()
    {
        $macroList = array();
        $aTagList = array();
        $aTags = array();
        
        $givenParameters = $this->getParams('post');
        
        if (isset($givenParameters['macro_name']) && isset($givenParameters['macro_value'])) {
            
            $macroName = $givenParameters['macro_name'];
            $macroValue = $givenParameters['macro_value'];
            
            $macroHidden = $givenParameters['macro_hidden'];

            foreach ($macroName as $key => $name) {
                if (!empty($name)) {
                    if (isset($macroHidden[$key])) {
                        $isPassword = '1';
                    } else {
                        $isPassword = '0';
                    }

                    $macroList[$name] = array(
                        'value' => $macroValue[$key],
                        'ispassword' => $isPassword
                    );
                }
            }            
        }

        $id = parent::createAction(false);
        
        if (count($macroList) > 0) {
            try{
                CustomMacroRepository::saveServiceCustomMacro(self::$objectName, $id, $macroList);
            } catch (\Exception $ex) {
                $errorMessage = $ex->getMessage();
                $this->router->response()->json(array('success' => false,'error' => $errorMessage));
            }
            
        }
        
        if (isset($givenParameters['service_tags'])) {
            $aTagList = explode(",", $givenParameters['service_tags']);
            foreach ($aTagList as $var) {
                $var = trim($var);
                if (!empty($var)) {
                    array_push($aTags, $var);
                }
            }
            if (count($aTags) > 0) {
                TagsRepository::saveTagsForResource(self::$objectName, $id, $aTags, '', false, 1);
            }
        }
        
        $this->router->response()->json(array('success' => true));
    }

    /**
     * Get list of Environment for a specific host
     * 
     * @method get
     * @route /service/[i:id]/environment
     */
    public function environmentForServiceAction()
    {
        parent::getSimpleRelation('environment_id', '\CentreonAdministration\Models\Environment');
    }
    
    /**
     * Get list of Environment for a specific host
     * 
     * @method get
     * @route /service/[i:id]/domain
     */
    public function domainForServiceAction()
    {
        parent::getSimpleRelation('domain_id', '\CentreonAdministration\Models\Domain');
    }
    
    /**
     * Get list of Timeperiods for a specific service
     * 
     * @method get
     * @route /service/[i:id]/checkperiod
     */
    public function checkPeriodForServiceAction()
    {
        parent::getSimpleRelation('timeperiod_tp_id', '\CentreonConfiguration\Models\Timeperiod');
    }
    
    /**
     * Get check command for a specific service
     *
     * @method get
     * @route /service/[i:id]/checkcommand
     */
    public function checkCommandForServiceAction()
    {
        parent::getSimpleRelation('command_command_id', '\CentreonConfiguration\Models\Command');
    }

    /**
     * Get list of Commands for a specific service
     * 
     * @method get
     * @route /service/[i:id]/eventhandler
     */
    public function eventHandlerForServiceAction()
    {
        parent::getSimpleRelation('command_command_id2', '\CentreonConfiguration\Models\Command');
    }
    
    /**
     * Get list of contact hosts for a specific service
     * 
     * @method get
     * @route /service/[i:id]/host
     */
    public function hostForServiceAction()
    {
        parent::getRelations(static::$relationMap['service_hosts']);
    }
    
    /**
     * Get list of service for a specific service
     *
     *
     * @method get
     * @route /service/[i:id]/servicetemplate
     */
    public function serviceTemplateForServiceAction()
    {
        parent::getSimpleRelation('service_template_model_stm_id', '\CentreonConfiguration\Models\Servicetemplate');
    }

    /**
     * Trap for a specific service
     *
     * @method get
     * @route /service/[i:id]/trap
     */
    public function trapForServiceAction()
    {
        parent::getRelations(static::$relationMap['service_traps']);
    }
    
    /**
     * Get list of icons for a specific service
     *
     *
     * @method get
     * @route /service/[i:id]/icon
     */
    public function iconForServiceAction()
    {
        $di = Di::getDefault();
        $router = $di->get('router');
        
        $requestParam = $this->getParams('named');
        
        $objCall = static::$relationMap['service_icon'];
        $icon = $objCall::getIconForService($requestParam['id']);
        $finalIconList = array();
        if (count($icon) > 0) {
            $filenameExploded = explode('.', $icon['filename']);
            $nbOfOccurence = count($filenameExploded);
            $fileFormat = $filenameExploded[$nbOfOccurence-1];
            $filenameLength = strlen($icon['filename']);
            $routeAttr = array(
                'image' => substr($icon['filename'], 0, ($filenameLength - (strlen($fileFormat) + 1))),
                'format' => '.'.$fileFormat
            );
            $imgSrc = $router->getPathFor('/uploads/[*:image][png|jpg|gif|jpeg:format]', $routeAttr);
            $finalIconList = array(
                "id" => $icon['binary_id'],
                "text" => $icon['filename'],
                "theming" => '<img src="'.$imgSrc.'" style="width:20px;height:20px;"> '.$icon['filename']
            );
        }
        
        $router->response()->json($finalIconList);
    }

    /**
     * Display the configuration snapshot of a service
     * with template inheritance
     *
     * @method get
     * @route /service/snapshot/[i:id]
     */
    public function snapshotAction()
    {
        $params = $this->getParams();
        $data = ServiceRepository::getConfigurationData($params['id']);
        $checkdata = ServiceRepository::formatDataForTooltip($data);
        $this->tpl->assign('checkdata', $checkdata);
        $this->tpl->display('file:[CentreonConfigurationModule]service_conf_tooltip.tpl');
    }

    /**
     * Get services for a specific acl resource
     *
     * @method get
     * @route /aclresource/[i:id]/service
     */
    public function servicesForAclResourceAction()
    {
        $di = Di::getDefault();
        $router = $di->get('router');

        $requestParam = $this->getParams('named');
        $finalServiceList = ServiceRepository::getServicesByAclResourceId($requestParam['id']);

        $router->response()->json($finalServiceList);
    }

     /**
     * Get service tag list
     *
     * @method get
     * @route /service/tag/formlist
     */
     public function serviceTagsAction()
    {
        $di = Di::getDefault();
        $router = $di->get('router');

        $list = TagsRepository::getGlobalList('service');

        $router->response()->json($list);
    } 
}
