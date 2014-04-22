<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   2013-10-10
 * Last update:     $Date$
 * @author          Pablo Llinás Arnaiz <pebs74@gmail.com>, URJC JuxtaLearn Team
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */

/**
 * Description for global variable
 *
 * @global_var type $globalVar
 */
$global_var  = null;

/**
 * Description for function
 *
 * @param   type    $arg    Description
 * @var     type    $var    Description
 * @throws  ExceptionName   Description
 * @see     <elementName>
 * @uses    <element>       Description
 * @return  type            Description
 */
function non_class_function($arg){
    $var = $arg;
    return $var;
}

/**
 * Description for class
 */
class sampleClass{
    /**
     * @class_var <type> $var [description]
     */
    public $class_var;
    
    /**
     * Description for class function
     * 
     * @param   type    $arg    Description
     * @var     type    $var    Description
     * @throws  ExceptionName   Description
     * @see     <elementName>
     * @uses    <element>       Description
     * @return  type            Description
     */
    public function classFunction($arg){
        $var = $arg;
        return $var;
    }
}





