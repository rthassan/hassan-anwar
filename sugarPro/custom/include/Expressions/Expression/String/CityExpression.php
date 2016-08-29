<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CityExpression
 *
 * @author hassan.anwar
 */
require_once('include/Expressions/Expression/String/StringExpression.php');

class CityExpression extends StringExpression {

    function evaluate() {
        
    }
 
    static function getJSEvaluate() {
        return <<<EOQ
        var params = this.getParameters();
        var number = params.evaluate();
        if(number == 0)
        {
            return ['Lahore', 'Karachi', 'Multan'];
        }
        else
        {
            return ['Mumbai', 'New Delhi', 'Chandigarh'];
        }
EOQ;
    }

    function getParameterCount() {
        return 1; // we only accept a single parameter
    }

    static function getOperationName() {
        return "getCity";
        // our function can be called by 'getCity'
    }

}

?>