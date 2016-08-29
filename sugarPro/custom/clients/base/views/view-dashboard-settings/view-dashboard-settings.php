<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$viewdefs['base']['view']['view-dashboard-settings'] = array(
    'dashlets' => array(
        array(
            'label' => 'Hello Cities',
            'description' => 'City Details',
            'config'=> array(
                'city'=>'Lorr'
            ),
            'preview'=> array(
                'city'=>'Lahore'
            ),
            'filter'=>array(
//                'module'=>array(
//                  'Accounts',   
//                ),
//                'view' => 'record'
            ),
        )
    ),
    'panels' => array(
        array(
            'name'=>'settings',
            'columns'=>2,
            'labelsOnTop'=>true,
            'placeholder'=>true,
            'fields' => array(
                array(
                    'name'=>'city',
                    'label'=>'Cities',
                    'type'=>enum,
                    'options'=>array(
                        'Monterey'=>'Monterey',
                        'Sydney'=>'Sydney',
                        'Lahore'=>'Lahore',
                    )
                )
            )
        )
    )
 
);


?>