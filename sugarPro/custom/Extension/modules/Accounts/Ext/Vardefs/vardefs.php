<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$dictionary['Account']['activity_enabled']=false;

//For Custom Text Field
$dictionary['Account']['fields']['ceo_c']['name'] = 'ceo_c';
$dictionary['Account']['fields']['ceo_c']['vname'] = 'LBL_CEO_C';
$dictionary['Account']['fields']['ceo_c']['type'] = 'varchar';
$dictionary['Account']['fields']['ceo_c']['enforced'] = '';
$dictionary['Account']['fields']['ceo_c']['dependency'] = '';
$dictionary['Account']['fields']['ceo_c']['required'] = false;
$dictionary['Account']['fields']['ceo_c']['massupdate'] = '0';
$dictionary['Account']['fields']['ceo_c']['default'] = '';
$dictionary['Account']['fields']['ceo_c']['no_default'] = false;
$dictionary['Account']['fields']['ceo_c']['comments'] = 'Example Varchar Vardef';
$dictionary['Account']['fields']['ceo_c']['help'] = '';
$dictionary['Account']['fields']['ceo_c']['importable'] = 'true';
$dictionary['Account']['fields']['ceo_c']['duplicate_merge'] = 'disabled';
$dictionary['Account']['fields']['ceo_c']['duplicate_merge_dom_value'] = '0';
$dictionary['Account']['fields']['ceo_c']['audited'] = false;
$dictionary['Account']['fields']['ceo_c']['reportable'] = true;
$dictionary['Account']['fields']['ceo_c']['unified_search'] = false;
$dictionary['Account']['fields']['ceo_c']['merge_filter'] = 'disabled';
$dictionary['Account']['fields']['ceo_c']['calculated'] = false;
$dictionary['Account']['fields']['ceo_c']['len'] = '255';
$dictionary['Account']['fields']['ceo_c']['size'] = '20';
$dictionary['Account']['fields']['ceo_c']['id'] = 'ceo_c';
$dictionary['Account']['fields']['ceo_c']['custom_module'] = '';
//required to create the field in the _cstm table
//$dictionary['Account']['fields']['ceo_c']['source'] = 'custom_fields';


//For custom dropdown
$dictionary['Account']['fields']['ceo_field']['name'] = 'ceo_field';
$dictionary['Account']['fields']['ceo_field']['vname'] = 'CEO Field';
$dictionary['Account']['fields']['ceo_field']['type'] = 'enum';
$dictionary['Account']['fields']['ceo_field']['required'] = false;
$dictionary['Account']['fields']['ceo_field']['massupdate'] = '0';
$dictionary['Account']['fields']['ceo_field']['default_value'] = 'Business';
$dictionary['Account']['fields']['ceo_field']['options'] = 'ceo_field_dom';
$dictionary['Account']['fields']['ceo_field']['comments'] = 'Dropdown';
$dictionary['Account']['fields']['ceo_field']['duplicate_merge'] = 'disabled';
$dictionary['Account']['fields']['ceo_field']['audited'] = false;
$dictionary['Account']['fields']['ceo_field']['reportable'] = true;
$dictionary['Account']['fields']['ceo_field']['importable'] = true;
$dictionary['Account']['fields']['ceo_field']['duplicate_merge'] = false;


$dictionary["Account"]["fields"]["branches"] = array (
    'name' => 'branches',
            'type' => 'link',
            'relationship' => 'account_branches',
            'module' => 'Brnch_Branches',
            'bean_name' => 'Brnch_Branches',
            'source' => 'non-db',
            'vname' => 'Branches',
            
      
  );



?>