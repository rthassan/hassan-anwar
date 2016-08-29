<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
        //For custom dropdown
        $dictionary['Rt_Teachers']['fields']['type']['name'] = 'type';
        $dictionary['Rt_Teachers']['fields']['type']['vname'] = 'Type';
        $dictionary['Rt_Teachers']['fields']['type']['type'] = 'enum';
        $dictionary['Rt_Teachers']['fields']['type']['required'] = false;
        $dictionary['Rt_Teachers']['fields']['type']['massupdate'] = '0';
        $dictionary['Rt_Teachers']['fields']['type']['default_value'] = 'General';
        $dictionary['Rt_Teachers']['fields']['type']['options'] = 'type_dom';
        $dictionary['Rt_Teachers']['fields']['type']['comments'] = 'Dropdown';
        $dictionary['Rt_Teachers']['fields']['type']['duplicate_merge'] = 'disabled';
        $dictionary['Rt_Teachers']['fields']['type']['audited'] = false;
        $dictionary['Rt_Teachers']['fields']['type']['reportable'] = true;
        $dictionary['Rt_Teachers']['fields']['type']['importable'] = true;
        $dictionary['Rt_Teachers']['fields']['type']['duplicate_merge'] = false;
       
       
        $dictionary['Rt_Teachers']['fields']['subject']['name'] = 'subject';
        $dictionary['Rt_Teachers']['fields']['subject']['vname'] = 'Subject';
        $dictionary['Rt_Teachers']['fields']['subject']['type'] = 'enum';
        $dictionary['Rt_Teachers']['fields']['subject']['required'] = true;
        $dictionary['Rt_Teachers']['fields']['subject']['massupdate'] = '0';
        $dictionary['Rt_Teachers']['fields']['subject']['options'] = 'subject_dom';
        $dictionary['Rt_Teachers']['fields']['subject']['comments'] = 'Dropdown';
        $dictionary['Rt_Teachers']['fields']['subject']['duplicate_merge'] = 'disabled';
        $dictionary['Rt_Teachers']['fields']['subject']['audited'] = false;
        $dictionary['Rt_Teachers']['fields']['subject']['reportable'] = true;
        $dictionary['Rt_Teachers']['fields']['subject']['importable'] = true;
        $dictionary['Rt_Teachers']['fields']['subject']['duplicate_merge'] = false;
        
        
        //$dictionary['Rt_Teachers']['fields']['subject']['dependency']='equal($type,1)';
        
        
        $dictionary['Rt_Teachers']['fields']['schools'] = array(
            'name' => 'schools',
            'type' => 'link',
            'relationship' => 'schools_teachers',
            'module' => 'Rt_Schools',
            'bean_name'=>'Rt_Schools',
            'source' => 'non-db',
            'vname' => 'Schools',
           
        );
        
        
   
        
?>