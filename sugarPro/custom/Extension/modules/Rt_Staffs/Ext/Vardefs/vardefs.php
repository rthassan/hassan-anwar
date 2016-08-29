<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
        //For custom dropdown
        $dictionary['Rt_Staffs']['fields']['role_field']['name'] = 'role_field';
        $dictionary['Rt_Staffs']['fields']['role_field']['vname'] = 'Role Field';
        $dictionary['Rt_Staffs']['fields']['role_field']['type'] = 'enum';
        $dictionary['Rt_Staffs']['fields']['role_field']['required'] = false;
        $dictionary['Rt_Staffs']['fields']['role_field']['massupdate'] = '0';
        $dictionary['Rt_Staffs']['fields']['role_field']['default_value'] = 'Principal';
        $dictionary['Rt_Staffs']['fields']['role_field']['options'] = 'role_field_dom';
        $dictionary['Rt_Staffs']['fields']['role_field']['comments'] = 'Dropdown';
        $dictionary['Rt_Staffs']['fields']['role_field']['duplicate_merge'] = 'disabled';
        $dictionary['Rt_Staffs']['fields']['role_field']['audited'] = false;
        $dictionary['Rt_Staffs']['fields']['role_field']['reportable'] = true;
        $dictionary['Rt_Staffs']['fields']['role_field']['importable'] = true;
        $dictionary['Rt_Staffs']['fields']['role_field']['duplicate_merge'] = false;




        $dictionary['Rt_Staffs']['fields']['school_name']=array(
            'required'  => false,
            'source'    => 'non-db',
            'name'      => 'school_name',
            'vname'     => 'Associated School',
            'type'      => 'relate',
            'rname'     => 'name',
            'id_name'   => 'school_id',
            'join_name' => 'rt_schools',
            'link'      => 'schools',
            'table'     => 'rt_schools',
            'isnull'    => 'true',
            'module'    => 'Rt_Schools',
          
        );


        $dictionary['Rt_Staffs']['fields']['school_id'] = array(
            'name' => 'school_id',
            'rname' => 'id',
            'id_name' => 'school_id',
            'vname' => 'School Id',
            'type' => 'id',
            'table' => 'rt_schools',
            'isnull' => 'true',
            'module' => 'Rt_Schools',
            'dbType' => 'id',
            'reportable' => false,
            'massupdate' => false,
            'duplicate_merge' => 'disabled',
            
        );
        
        $dictionary['Rt_Staffs']['fields']['schools'] = array(
            'name' => 'schools',
            'type' => 'link',
            'relationship' => 'school_staffs',
            'module' => 'Rt_Schools',
            'bean_name'=>'Rt_Schools',
            'source' => 'non-db',
            'vname' => 'School',
           
        );
        
        
        // Relationship Definition
        $dictionary["Rt_Staffs"]["relationships"]['school_staffs'] = array(
        'lhs_module'=> 'Rt_Schools',
        'lhs_table'=> 'rt_schools',
        'lhs_key' => 'id', 'rhs_module'=> 'Rt_Staffs',
        'rhs_table'=> 'rt_staffs',
        'rhs_key' => 'school_id',
        'relationship_type'=>'one-to-many',
        );
        
        
?>