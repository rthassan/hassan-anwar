<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$hook_version=1;

$hook_array['after_save'][]=array(
    1,
    'Add Staff members',
    'custom/modules/Rt_Schools/AddStaffMembers.php',
    'AddStaffMembers',
    'AddMembers',
)


?>