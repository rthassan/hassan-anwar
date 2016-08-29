<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$dictionary["schools_teachers"] = array (
  'true_relationship_type' => 'many-to-many',
  'from_studio' => false,
  'relationships' =>
    array (
      'schools_teachers' =>

      array (

        'lhs_module' => 'Rt_Schools',
        'lhs_table' => 'rt_schools',
        'lhs_key' => 'id',
        'rhs_module' => 'Rt_Teachers',
        'rhs_table' => 'rt_teachers',
        'rhs_key' => 'id',
        'relationship_type' => 'many-to-many',
        'join_table' => 'schools_teachers_c',
        'join_key_lhs' => 'schools_teachers_schools_ids',
        'join_key_rhs' => 'schools_teachers_teachers_idt',

      ),

    ),

    'table' => 'schools_teachers_c',
    'fields' =>

    array (

      0 =>

      array (

        'name' => 'id',
        'type' => 'varchar',
        'len' => 36,

      ),

      1 =>

      array (

        'name' => 'date_modified',
        'type' => 'datetime',

      ),

      2 =>

      array (

        'name' => 'deleted',
        'type' => 'bool',
        'len' => '1',
        'default' => '0',
        'required' => true,

      ),

    3 =>

    array (

      'name' => 'schools_teachers_schools_ids',
      'type' => 'varchar',
      'len' => 36,

    ),

    4 =>

    array (

      'name' => 'schools_teachers_teachers_idt',
      'type' => 'varchar',
      'len' => 36,

    ),

  ),

  'indices' =>

  array (

    0 =>

    array (

      'name' => 'schools_teachers_spk',
      'type' => 'primary',
      'fields' =>

      array (

        0 => 'id',

      ),

    ),

    1 =>

    array (

      'name' => 'schools_teachers_ida1',
      'type' => 'index',
      'fields' =>

      array (

        0 => 'schools_teachers_schools_ids',

      ),

    ),

    2 =>

    array (

      'name' => 'accounts_contacts_1_alt',
      'type' => 'alternate_key',
      'fields' =>

      array (

        0 => 'schools_teachers_teachers_idt',

      ),

    ),

  ),

);




?>