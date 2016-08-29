<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$viewdefs['base']['view']['ticker']=array(
    'dashlets'=>array(
        array(
            'label' => 'Ticker',
            'description' => 'Ticker Details',
            'config'=> array(
                'limit'=>'3',
            ),
            'preview'=> array(
                'limit'=>'3',
            ),
            'filter'=>array(
                'module'=>array(
                  'Accounts',   
                ),
                'view' => 'record'
            ),
            
        ),
        
    ),
    
);

?>