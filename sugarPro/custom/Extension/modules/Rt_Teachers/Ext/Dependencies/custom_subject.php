<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$dependencies['Rt_Teachers']['subject_hide'] = array(
        'hooks' => array('edit'),
        'trigger' => 'true', 
        'triggerFields' => array('type'),
        'onload' => true,
        //Actions is a list of actions to fire when the trigger is true
        'actions' => array(
            array(
                'name' => 'SetVisibility',
                'params' => array(
                    'target' => 'subject',
                    'value' => 'equal($type,1)',
                ),
            ),
        ),
    );



?>