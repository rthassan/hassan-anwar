<?php
// WARNING: The contents of this file are auto-generated.

//Merged from custom/Extension/modules/Rt_Schools/Ext/Dependencies/custom_city.php


/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$dependencies['Rt_Schools']['city_show'] = array(
        'hooks' => array('edit'),
        'trigger' => 'true', 
        'triggerFields' => array('country'),
        'onload' => true,
        //Actions is a list of actions to fire when the trigger is true
        'actions' => array(
            array(
                'name' => 'SetOptions',
                'params' => array(
                    'target' => 'city',
                    'keys' => 'getCity($country)',
                    'labels' => 'getCity($country)',
                ),
            ),
        ),

);

