<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of StockApi
 *
 * @author hassan.anwar
 */
class StockApi extends SugarApi {
    //put your code here
    
    public function registerApiRest(){
        return array(
            'getStockData'=>array(
                'reqType'=>'GET',
                'path' =>array('ticker', '?'),
                'pathVars'=>array('', 'symbol'),
                'method'=>'getStockData',
                'shortHelp'=>'This method retrieves data',
                'longHelp'=>'',
            )
        );
    }
    
    public function getStockData($api, $args)
    {
        $symbol=$args['symbol'];
        $url='http://dev.markitondemand.com/MODApis/Api/v2/Quote/json?symbol='.$symbol;
        
        $cu=  curl_init();
        
        curl_setopt($cu, CURLOPT_URL, $url);
        curl_setopt($cu, CURLOPT_HEADER, 0);
        curl_setopt($cu, CURLOPT_RETURNTRANSFER, 1);
        
        $result=curl_exec($cu);
        
        return $result;
    }
}
