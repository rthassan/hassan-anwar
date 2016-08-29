<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$viewdefs['Accounts']['base']['layout']['subpanels'] = array (
  'components' => array (
      array (
          'layout' => 'subpanel',
          'label' => 'Branches',
          'context' => array (
              'link' => 'branches',
           ),
        ),
      
    ),
    
  'type' => 'subpanels',
  'span' => 12,
    
);
       

?>