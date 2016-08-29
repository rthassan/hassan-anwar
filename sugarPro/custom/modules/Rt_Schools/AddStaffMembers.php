<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AddStaffMembers
 *
 * @author hassan.anwar
 */
class AddStaffMembers {
    
    function AddMembers($bean, $event, $args)
    {
        if(!$bean->fetched_row['id'])
        {
            $role=0;
            $default_staff=array('Principal', 'Vice Principal', 'Accountant', 'Clerk');
            foreach($default_staff as $staff)
            {
                $st=  BeanFactory::getBean('Rt_Staffs');
                $st->last_name=$staff;
                $st->school_id=$bean->id;
                $st->role_field=$role;
                $st->save();
                $role++;
            }
            
        }
    }
    
}

?>