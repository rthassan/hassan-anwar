<?php
// WARNING: The contents of this file are auto-generated.

//Merged from custom/Extension/modules/Rt_Students/Ext/Vardefs/vardefs.php


/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

        $dictionary['Rt_Students']['fields']['school_name']=array(
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


        $dictionary['Rt_Students']['fields']['school_id'] = array(
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
        
        $dictionary['Rt_Students']['fields']['schools'] = array(
            'name' => 'schools',
            'type' => 'link',
            'relationship' => 'school_students',
            'module' => 'Rt_Schools',
            'bean_name'=>'Rt_Schools',
            'source' => 'non-db',
            'vname' => 'School',
           
        );
        
        
        // Relationship Definition
        $dictionary["Rt_Students"]["relationships"]['school_students'] = array(
        'lhs_module'=> 'Rt_Schools',
        'lhs_table'=> 'rt_schools',
        'lhs_key' => 'id', 'rhs_module'=> 'Rt_Students',
        'rhs_table'=> 'rt_students',
        'rhs_key' => 'school_id',
        'relationship_type'=>'one-to-many',
        );
        
        
