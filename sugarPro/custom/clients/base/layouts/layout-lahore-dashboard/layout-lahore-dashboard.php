<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$viewdefs['base']['layout']['layout-lahore-dashboard'] = array(
    'components'=>array(
        array(
            'layout'=>array(
                
                
                'components'=>array(
                    
                    array(
                        'layout'=>array(
                            'components'=>array(
                                array(
                                   'view' => 'view-hello-lahore',
                                   'primary' => true,
                                )
                            ),
                            'type' => 'simple',
                            'name' => 'main-pane',
                            'span' => 8,
                        
                        ),
                        
                    ),
                    array(
                        'layout'=>array(
                            'components'=>array(
                                array(
                                   'layout' => 'sidebar',
                                )
                            ),
                            'type' => 'simple',
                            'name' => 'side-pane',
                            'span' => 4,
                        
                        ),
                        
                    ),
                    array(
                        'layout'=>array(
                            'components'=>array(
                                array(
                                    'layout'=>array(
                                        'type'=>'dashboard',
                                        'last_state'=>array(
                                            'id' =>'last-visit' 
                                        )
                                        
                                    ),
                                    //to display Create options
                                    'context'=>array(
                                        'forceNew'=>true,
                                        'module' => 'Home'
                                    ),
                                )
                                
                            ),
                            'type' => 'simple',
                            'name' => 'dashboard-pane',
                            'span' => 4,
                        
                        ),
                        
                    ),
                    array(
                        'layout'=>array(
                            'components'=>array(
                                array(
                                   'layout' => 'preview',
                                )
                            ),
                            'type' => 'simple',
                            'name' => 'preview-pane',
                            'span' => 8,
                        
                        ),
                        
                    ),
                       
                ),
                'type' => 'default',
                'name' => 'sidebar',
                'span' => 12,
                
            ),
       
        ),
        
    ),
    'type' => 'record',
    'name' => 'base',
    'span' => 12,
  
);


?>