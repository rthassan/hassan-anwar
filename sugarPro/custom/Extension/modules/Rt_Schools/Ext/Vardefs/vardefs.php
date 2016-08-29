<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


//For Custom Text Field
$dictionary['Rt_Schools']['fields']['principal_c']['name'] = 'principal_c';
$dictionary['Rt_Schools']['fields']['principal_c']['vname'] = 'Principal Name';
$dictionary['Rt_Schools']['fields']['principal_c']['type'] = 'varchar';
$dictionary['Rt_Schools']['fields']['principal_c']['enforced'] = '';
$dictionary['Rt_Schools']['fields']['principal_c']['dependency'] = '';
$dictionary['Rt_Schools']['fields']['principal_c']['required'] = false;
$dictionary['Rt_Schools']['fields']['principal_c']['massupdate'] = '0';
$dictionary['Rt_Schools']['fields']['principal_c']['default'] = '';
$dictionary['Rt_Schools']['fields']['principal_c']['no_default'] = false;
$dictionary['Rt_Schools']['fields']['principal_c']['comments'] = 'Example Varchar Vardef';
$dictionary['Rt_Schools']['fields']['principal_c']['help'] = '';
$dictionary['Rt_Schools']['fields']['principal_c']['importable'] = 'true';
$dictionary['Rt_Schools']['fields']['principal_c']['duplicate_merge'] = 'disabled';
$dictionary['Rt_Schools']['fields']['principal_c']['duplicate_merge_dom_value'] = '0';
$dictionary['Rt_Schools']['fields']['principal_c']['audited'] = false;
$dictionary['Rt_Schools']['fields']['principal_c']['reportable'] = true;
$dictionary['Rt_Schools']['fields']['principal_c']['unified_search'] = false;
$dictionary['Rt_Schools']['fields']['principal_c']['merge_filter'] = 'disabled';
$dictionary['Rt_Schools']['fields']['principal_c']['calculated'] = false;
$dictionary['Rt_Schools']['fields']['principal_c']['len'] = '255';
$dictionary['Rt_Schools']['fields']['principal_c']['size'] = '20';
$dictionary['Rt_Schools']['fields']['principal_c']['id'] = 'principal_c';
$dictionary['Rt_Schools']['fields']['principal_c']['custom_module'] = '';
//required to create the field in the _cstm table
//$dictionary['Rt_Schools']['fields']['principal_c']['source'] = 'custom_fields';

$dictionary['Rt_Schools']['fields']['country']['name'] = 'country';
$dictionary['Rt_Schools']['fields']['country']['vname'] = 'Country';
$dictionary['Rt_Schools']['fields']['country']['type'] = 'enum';
//$dictionary['Rt_Schools']['fields']['country']['massupdate'] = '0';
$dictionary['Rt_Schools']['fields']['country']['options'] = 'country_dom';
$dictionary['Rt_Schools']['fields']['country']['comments'] = 'Dropdown';
$dictionary['Rt_Schools']['fields']['country']['audited'] = false;
$dictionary['Rt_Schools']['fields']['country']['duplicate_merge'] = false; 

$dictionary['Rt_Schools']['fields']['city']['name'] = 'city';
$dictionary['Rt_Schools']['fields']['city']['vname'] = 'City';
$dictionary['Rt_Schools']['fields']['city']['type'] = 'enum';
//$dictionary['Rt_Schools']['fields']['city']['massupdate'] = '0';
$dictionary['Rt_Schools']['fields']['city']['options'] = 'pk_dom';
$dictionary['Rt_Schools']['fields']['city']['comments'] = 'Dropdown';
$dictionary['Rt_Schools']['fields']['city']['audited'] = false;;
$dictionary['Rt_Schools']['fields']['city']['duplicate_merge'] = false;

//$dictionary['Rt_Schools']['fields']['city']['visibility_grid'] = array(
//    'trigger' => 'country',
//    'values' => array(
//        0 => array(
//           0=>'Lahore',
//           1=>'Islamabad',
//           2=>'Karachi',
//            
//        ),
//        1 => array(
//           0=>'Mumbai',
//           1=>'Kolkata',
//           2=>'New Delhi',
//        ),
//    ),
//);

$dictionary["Rt_Schools"]["fields"]["students"] = array (
    'name' => 'students',
            'type' => 'link',
            'relationship' => 'school_students',
            'module' => 'Rt_Students',
            'bean_name' => 'Rt_Students',
            'source' => 'non-db',
            'vname' => 'Students',
            
      
  );

$dictionary["Rt_Schools"]["fields"]["staffs"] = array (
    'name' => 'staffs',
            'type' => 'link',
            'relationship' => 'school_staffs',
            'module' => 'Rt_Staffs',
            'bean_name' => 'Rt_Staffs',
            'source' => 'non-db',
            'vname' => 'Staffs',
            
      
  );

$dictionary["Rt_Schools"]["fields"]["teachers"] = array (
    'name' => 'teachers',
            'type' => 'link',
            'relationship' => 'schools_teachers',
            'module' => 'Rt_Teachers',
            'bean_name' => 'Rt_Teachers',
            'source' => 'non-db',
            'vname' => 'Teachers',
            
      
  );



?>