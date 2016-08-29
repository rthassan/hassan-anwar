<?php
// WARNING: The contents of this file are auto-generated.



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
       



//auto-generated file DO NOT EDIT
$viewdefs['Accounts']['base']['layout']['subpanels']['components'][]['override_subpanel_list_view'] = array (
  'link' => 'account_branches',
  'view' => 'subpanel-for-accounts-account_branches',
);
