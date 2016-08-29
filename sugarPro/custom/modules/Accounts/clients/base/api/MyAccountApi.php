<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AccountsApi
 *
 * @author hassan.anwar
 */
class MyAccountApi extends SugarApi {
     public function registerApiRest(){
        return array(
            'getStockData'=>array(
                'reqType'=>'GET',
                'path' =>array('AccountsInfo', '?'),
                'pathVars'=>array('', 'id'),
                'noLoginRequired' => true,
                'method'=>'getAccountData',
                'shortHelp'=>'This method retrieves accounts details from accounts',
                'longHelp'=>'',
            )
        );
    }
    
    public function getAccountData($api, $args) {
        $id = $args['id'];
        $seed = BeanFactory::newBean('Accounts');
        $q = new SugarQuery();
        // Set from to the bean first so SugarQuery can figure out joins and fields on the first try
        $q->from($seed);
        // Adding the ID field so we can validate the results from the select
        $q->select('*');
        $q->where()->equals('id',$id);
        //$q->limit(5);
        
        // Return the raw SQL results through the API
        return $q->execute();
       
    }
    
    
}
