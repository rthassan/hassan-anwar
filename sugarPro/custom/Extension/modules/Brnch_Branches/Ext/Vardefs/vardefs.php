<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

        $dictionary['Brnch_Branches']['fields']['account_name']=array(
            'required'  => false,
            'source'    => 'non-db',
            'name'      => 'account_name',
            'vname'     => 'Associated Account',
            'type'      => 'relate',
            'rname'     => 'name',
            'id_name'   => 'account_id',
            'join_name' => 'accounts',
            'link'      => 'accounts',
            'table'     => 'accounts',
            'isnull'    => 'true',
            'module'    => 'Accounts',
            
            
        );


        $dictionary['Brnch_Branches']['fields']['account_id'] = array(
            'name' => 'account_id',
            'rname' => 'id',
            'id_name' => 'account_id',
            'vname' => 'LBL_ACCOUNT_ID',
            'type' => 'id',
            'table' => 'accounts',
            'isnull' => 'true',
            'module' => 'Accounts',
            'dbType' => 'id',
            'reportable' => false,
            'massupdate' => false,
            'duplicate_merge' => 'disabled',
            
        );
        
        $dictionary['Brnch_Branches']['fields']['accounts'] = array(
            'name' => 'accounts',
            'type' => 'link',
            'relationship' => 'account_branches',
            'module' => 'Accounts',
            'bean_name'=>'Account',
            'source' => 'non-db',
            'vname' => 'LBL_ACCOUNT',
           
        );
        
        
        // Relationship Definition
        $dictionary["Brnch_Branches"]["relationships"]['account_branches'] = array(
        'lhs_module'=> 'Accounts',
        'lhs_table'=> 'accounts',
        'lhs_key' => 'id', 'rhs_module'=> 'Brnch_Branches',
        'rhs_table'=> 'brnch_branches',
        'rhs_key' => 'account_id',
        'relationship_type'=>'one-to-many',
        );
        
        
?>