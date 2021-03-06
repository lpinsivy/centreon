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


namespace CentreonBam\Commands;

use Centreon\Api\Internal\BasicCrudCommand;
use CentreonBam\Repository\IndicatorRepository;
use CentreonBam\Repository\BooleanIndicatorRepository;
use CentreonBam\Models\Indicator;
/**
 * Description of KpiCommand
 *
 * @author bsauveton
 */
class IndicatorCommand extends BasicCrudCommand
{
    /**
     *
     * @var type 
     */
    public $objectName = 'indicator';
    
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * 
     * @cmdForm /centreon-bam/indicator/update required 
     * @cmdParam boolean|false disable required disable 
     */
    public function createAction($params){
        IndicatorRepository::transco($params);
        $id = IndicatorRepository::createIndicator($this->parseObjectParams($params), 'api', '/centreon-bam/indicator/update');

        // show slug of boolean indicator only
        if(!is_null($id)){
            $slug = BooleanIndicatorRepository::getSlugNameById($id);
            \Centreon\Internal\Utils\CommandLine\InputOutput::display($slug, true, 'green');
        }
        \Centreon\Internal\Utils\CommandLine\InputOutput::display("Object successfully created", true, 'green');
    }
    
    /**
     * 
     * @cmdForm /centreon-bam/indicator/update optional 
     * @cmdObject string ba the ba
     * @cmdObject string indicator-ba the indicator-ba kpi
     * @cmdObject string service the service kpi
     * @cmdObject string boolean the boolean kpi 
     * @cmdParam none service-tags optional
     * @cmdParam boolean|false disable optional disable 
     * @cmdParam boolean|true enable optional enable 
     */
    public function updateAction($object,$params){
        IndicatorRepository::transco($params);
        IndicatorRepository::transco($object);
        IndicatorRepository::updateIndicator($this->parseObjectParams($params), 'api', '/centreon-bam/indicator/update',false,$this->parseObjectParams($object));
        \Centreon\Internal\Utils\CommandLine\InputOutput::display("Object successfully updated", true, 'green');
    }
    
    /**
     * @cmdObject string ba the ba
     * @cmdObject string indicator-ba the indicator-ba kpi
     * @cmdObject string service the service kpi
     * @cmdObject string boolean the boolean kpi 
     */
    public function deleteAction($object){
        IndicatorRepository::transco($object);
        $kpi = Indicator::getKpi($this->parseObjectParams($object));
        IndicatorRepository::delete(array($kpi['kpi_id']));
        \Centreon\Internal\Utils\CommandLine\InputOutput::display("Object successfully deleted", true, 'green');
    }
    
    /**
     * @cmdForm /centreon-bam/indicator/update map
     * @cmdObject string ba the ba
     * @cmdObject string indicator-ba the indicator-ba kpi
     * @cmdObject string service the service kpi
     * @cmdObject string boolean the boolean kpi 
     */
    public function showAction($object){
        IndicatorRepository::transco($object);
        $kpi = Indicator::getKpi($this->parseObjectParams($object));
        $this->normalizeSingleSet($kpi);
        $result = '';
        foreach ($kpi as $key => $value) {
            $result .= $key . ': ' . $value . "\n";
        }
        
        echo $result;
    }
    
    
}

