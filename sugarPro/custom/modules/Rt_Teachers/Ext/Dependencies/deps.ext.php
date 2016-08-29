<?php
// WARNING: The contents of this file are auto-generated.

//Merged from custom/Extension/modules/Rt_Teachers/Ext/Dependencies/custom_subject.php


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




//Merged from custom/Extension/modules/Rt_Teachers/Ext/Dependencies/custom_phone.php


/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$dependencies['Rt_Teachers']['work_required'] = array(
	'hooks' => array("edit"),
	'trigger' => 'true', //Optional, the trigger for the dependency. Defaults to 'true'.
	'triggerFields' => array('phone_home'),
	'onload' => true,
	//Actions is a list of actions to fire when the trigger is true
	'actions' => array(
		array(
			'name' => 'SetRequired',
			//The parameters passed in will depend on the action type set in 'name'
			'params' => array(
				'target' => 'phone_work',
				'value' => 'not(equal($phone_home, ""))',
			),
		),
	),
);



