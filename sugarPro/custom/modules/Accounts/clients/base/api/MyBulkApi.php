<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MyBulkApi
 *
 * @author hassan.anwar
 */
class MyBulkApi extends BulkApi {
    
    public function registerApiRest()
    {
        return array(
            'bulkCall' => array(
                'reqType' => 'POST',
                'path' => array('bulk'),
                'pathVars' => array(''),
                'method' => 'bulkCall',
                'shortHelp' => 'Run several API call in a sequence',
                'longHelp' => 'include/api/help/bulk_post_help.html',
            ),
        );
    }

    /**
     * Bulk API call
     * @param ServiceBase $api
     * @param array $args
     * @throws SugarApiExceptionMissingParameter
     * @return array
     */
    public function bulkCall($api, $args)
    {
        $this->requireArgs($args,array('requests'));
        $restResp = new BulkRestResponse($_SERVER);
        // reset vars so they won't confuse the child service
        $_GET = array(); $_POST = array();
        foreach($args['requests'] as $name => $request) {
            if(empty($request['url'])) {
                $GLOBALS['log']->fatal("Bulk Api: URL missing for request $name");
                throw new SugarApiExceptionMissingParameter("Invalid request - URL is missing");
            }
        }
        // check all reqs first so that we don't execute any reqs if one of them is broken
        foreach($args['requests'] as $name => $request) {
            $restReq = new BulkRestRequest($request);
            $restResp->setRequest($name);
            /**
             * @var $rest RestService
             */
            
            $rest = new BulkRestService($api);
            $rest->setRequest($restReq);
            $rest->setResponse($restResp);
            $rest->execute();

        }
        
        $result= $restResp->getResponses();
        $arr=array();
        foreach($result as $key => $subPanel)
        {
            if( !strcmp( $subPanel['contents']['records'][0][_module], 'Contacts' ) )
            {
               $arr=$subPanel['contents']['records'];
                
            }
            
        }
        
        $newArray = array();
        foreach($result as $key => &$subPanel)
        {
            if( !strcmp( $subPanel['contents']['records'][0][_module], 'Opportunities' ) )
            {
                foreach($arr as $key)
                {
                      
                      $key['name']=$key['full_name'];
                      //$row['id']=$key['id'];
                      //$row['_module']=$key['_module'];
                      $GLOBALS['log']->fatal("Opp" . print_r($key, true));
                      
                      array_push($subPanel['contents']['records'],$key);
                      $newArray[] = $subPanel;
                      $GLOBALS['log']->fatal("Con" . print_r($subPanel['contents']['records'], true));
                }
              
            }
            
        }
        
        $GLOBALS['log']->fatal( $result );
        return $result;
        
    }
    
}
