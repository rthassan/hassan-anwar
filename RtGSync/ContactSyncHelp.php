<?php

    class ContactSyncHelp {
        public static function updateFromGoogle($client, $userdata){
            global $db;
             //Get Contacts by Group -------------------------------------------------------------------
             // Now we request the users contacts based on group. For now, we will retreive 'My Contacts'
            $lastSync = $userdata['GSyncRt__LastSyncGsf__c'];
            $user_email = $userdata['GSyncRt__UserEmail__c'];
            //$group="http%3A%2F%2Fwww.google.com%2Fm8%2Ffeeds%2Fgroups%2F".$user_email;
            $group="http%3A%2F%2Fwww.google.com%2Fm8%2Ffeeds%2Fgroups%2F".$user_email."%2Fbase%2F6";
            $max_results =100000;
            if ($lastSync != null) {
                 if (substr($lastSync, -5) == '+0000') {
                      $lastSync = substr($lastSync, 0, -5);
                  }
                  $lastUpdated = str_replace(' ', 'T', $lastSync) . "Z";
                  // file_put_contents('lastUpdated.txt', $lastUpdated);            
                  $req = new Google_HttpRequest("https://www.google.com/m8/feeds/contacts/".$user_email."/full?alt=json&max-results=".$max_results."&v=3.0&showdeleted=true&updated-min=".$lastUpdated); 
            } else {
                  $req = new Google_HttpRequest("https://www.google.com/m8/feeds/contacts/".$user_email."/full?alt=json&max-results=".$max_results."&v=3.0");
            }
                      
            $req->setRequestHeaders(array('GData-Version'=> '3.0','content-type'=>'application/atom+xml; charset=UTF-8; type=feed'));   
            $val = $client->getIo()->authenticatedRequest($req);
            $response =$val->getResponseBody();
            $feeds = json_decode($response,1);
            
            print_r($response);
            $newresponsearray =  array();

            foreach ($feeds['feed']['entry'] as $feed) {
                  if (isset($feed['gContact$groupMembershipInfo'])) {
                        $arr1 = array();

                        $arr1['OwnerId'] = $userdata['Name'];
                        $arr1['CurrentUserEmail'] = $user_email;
                        $arr1['GSyncRt__DuplicationPref__c'] = $userdata['GSyncRt__DuplicationPref__c'];
                        $arr1['syncStatus'] = $userdata['GSyncRt__syncStatus__c'];

                        $arr1['GSyncRt__gcontactid__c'] = $feed['id']['$t'];
                        if ($feed['gContact$groupMembershipInfo'][0]['deleted'] == 'false' || !(isset($feed['gd$deleted'])) ){
                              $arr1['IsDeleted'] = 'false';
                              if (isset($feed['gd$name']['gd$givenName']['$t'])) { 
                                    $arr1['FirstName'] = $feed['gd$name']['gd$givenName']['$t'];                              
                              }
                              if (isset($feed['gd$name']['gd$familyName']['$t'])) { 
                                    $arr1['LastName'] = $feed['gd$name']['gd$familyName']['$t'];                              
                              }
                              // if (isset($feed['gd$name']['gd$namePrefix']['$t'])) {
                              //       $arr1['Salutation'] = $feed['gd$name']['gd$namePrefix']['$t'];
                              // }
                              if (isset($feed['gd$email'][0]['address'])) { 
                                    // $arr1['Email'] = "bungie@example%2Ecom"; 
                                    $arr1['Email'] = $feed['gd$email'][0]['address'];  
                              }
                              if (isset($feed['content']['$t'])) { 
                                    $arr1['Description'] = $feed['content']['$t'];                             
                              }
                              if (isset($feed['gd$organization'][0]['gd$orgTitle'])) {
                                    $arr1['Title'] = $feed['gd$organization'][0]['gd$orgTitle']['$t'];
                              }
                              if (isset($feed['gd$phoneNumber'])) { 
                                    foreach ($feed['gd$phoneNumber'] as $number) {
                                          if ($number['rel'] == 'http://schemas.google.com/g/2005#mobile') {
                                                $arr1['MobilePhone'] = $number['$t'];
                                          } else if ($number['rel'] == 'http://schemas.google.com/g/2005#work_fax') {
                                                $arr1['Fax'] = $number['$t'];
                                          } else if ($number['rel'] == 'http://schemas.google.com/g/2005#work') {
                                                $arr1['Phone'] = $number['$t'];
                                          } else if ($number['rel'] == 'http://schemas.google.com/g/2005#other') {
                                                $arr1['OtherPhone'] = $number['$t'];
                                          }                                                                      
                                    }                            
                              }
                              $primary_address_google_found = false;
                              $alt_address_google_found = false;
                              if (isset($feed['gd$structuredPostalAddress'])) {
                                    foreach ($feed['gd$structuredPostalAddress'] as $address_array) {
                                          if ($address_array['rel'] == 'http://schemas.google.com/g/2005#work') {
                                                if (isset($address_array['gd$postcode'])) {
                                                      $arr1['MailingPostalCode'] = $address_array['gd$postcode']['$t'];
                                                }
                                                if (isset($address_array['gd$street'])) {
                                                      $arr1['MailingStreet'] = $address_array['gd$street']['$t'];
                                                }
                                                if (isset($address_array['gd$city'])) {
                                                      $arr1['MailingCity'] = $address_array['gd$city']['$t'];
                                                }
                                                if (isset($address_array['gd$region'])) {
                                                      $arr1['MailingState'] = $address_array['gd$region']['$t'];
                                                }
                                                if (isset($address_array['gd$country'])) {
                                                      $arr1['MailingCountry'] = $address_array['gd$country']['$t'];
                                                }
                                                $primary_address_google_found = true;
                                          }

                                          if ($address_array['rel'] == 'http://schemas.google.com/g/2005#home') {
                                                if (isset($address_array['gd$postcode'])) {
                                                      $arr1['OtherPostalCode'] = $address_array['gd$postcode']['$t'];
                                                }
                                                if (isset($address_array['gd$street'])) {
                                                      $arr1['OtherStreet'] = $address_array['gd$street']['$t'];
                                                }
                                                if (isset($address_array['gd$city'])) {
                                                      $arr1['OtherCity'] = $address_array['gd$city']['$t'];
                                                }
                                                if (isset($address_array['gd$region'])) {
                                                      $arr1['OtherState'] = $address_array['gd$region']['$t'];
                                                }
                                                if (isset($address_array['gd$country'])) {
                                                      $arr1['OtherCountry'] = $address_array['gd$country']['$t'];
                                                }
                                                $alt_address_google_found = true;
                                          }
                                    }
                                    if ($primary_address_google_found == false && $alt_address_google_found == false) {
                                          if (isset($feed['gd$structuredPostalAddress'][0])) {
                                                if (isset($feed['gd$structuredPostalAddress'][0]['gd$postcode'])) {
                                                      $arr1['MailingPostalCode'] = $feed['gd$structuredPostalAddress'][0]['gd$postcode']['$t'];
                                                }
                                                if (isset($feed['gd$structuredPostalAddress'][0]['gd$street'])) {
                                                      $arr1['MailingStreet'] = $feed['gd$structuredPostalAddress'][0]['gd$street']['$t'];
                                                }
                                                if (isset($feed['gd$structuredPostalAddress'][0]['gd$city'])) {
                                                      $arr1['MailingCity'] = $feed['gd$structuredPostalAddress'][0]['gd$city']['$t'];
                                                }
                                                if (isset($feed['gd$structuredPostalAddress'][0]['gd$region'])) {
                                                      $arr1['MailingState'] = $feed['gd$structuredPostalAddress'][0]['gd$region']['$t'];
                                                }
                                                if (isset($feed['gd$structuredPostalAddress'][0]['gd$country'])) {
                                                      $arr1['MailingCountry'] = $feed['gd$structuredPostalAddress'][0]['gd$country']['$t'];
                                                }   
                                          }
                                          if (isset($feed['gd$structuredPostalAddress'][1])) {
                                                if (isset($feed['gd$structuredPostalAddress'][1]['gd$postcode'])) {
                                                      $arr1['OtherPostalCode'] = $feed['gd$structuredPostalAddress'][1]['gd$postcode']['$t'];
                                                }
                                                if (isset($feed['gd$structuredPostalAddress'][1]['gd$street'])) {
                                                      $arr1['OtherStreet'] = $feed['gd$structuredPostalAddress'][1]['gd$street']['$t'];
                                                }
                                                if (isset($feed['gd$structuredPostalAddress'][1]['gd$city'])) {
                                                      $arr1['OtherCity'] = $feed['gd$structuredPostalAddress'][1]['gd$city']['$t'];
                                                }
                                                if (isset($feed['gd$structuredPostalAddress'][1]['gd$region'])) {
                                                      $arr1['OtherState'] = $feed['gd$structuredPostalAddress'][1]['gd$region']['$t'];
                                                }
                                                if (isset($feed['gd$structuredPostalAddress'][1]['gd$country'])) {
                                                      $arr1['OtherCountry'] = $feed['gd$structuredPostalAddress'][1]['gd$country']['$t'];
                                                }   
                                          }
                                    }
                                    if ($primary_address_google_found == true && $alt_address_google_found == false) {
                                          foreach ($feed['gd$structuredPostalAddress'] as $address_array) {
                                                if ($address_array['rel'] != 'http://schemas.google.com/g/2005#work') {
                                                      if (isset($address_array['gd$postcode'])) {
                                                            $arr1['OtherPostalCode'] = $address_array['gd$postcode']['$t'];
                                                      }
                                                      if (isset($address_array['gd$street'])) {
                                                            $arr1['OtherStreet'] = $address_array['gd$street']['$t'];
                                                      }
                                                      if (isset($address_array['gd$city'])) {
                                                            $arr1['OtherCity'] = $address_array['gd$city']['$t'];
                                                      }
                                                      if (isset($address_array['gd$region'])) {
                                                            $arr1['OtherState'] = $address_array['gd$region']['$t'];
                                                      }
                                                      if (isset($address_array['gd$country'])) {
                                                            $arr1['OtherCountry'] = $address_array['gd$country']['$t'];
                                                      }
                                                      break;
                                                }
                                          }
                                    }
                                    if ($primary_address_google_found == false && $alt_address_google_found == true) {
                                          foreach ($feed['gd$structuredPostalAddress'] as $address_array) {
                                                if ($address_array['rel'] != 'http://schemas.google.com/g/2005#home') {
                                                      if (isset($address_array['gd$postcode'])) {
                                                            $arr1['OtherPostalCode'] = $address_array['gd$postcode']['$t'];
                                                      }
                                                      if (isset($address_array['gd$street'])) {
                                                            $arr1['OtherStreet'] = $address_array['gd$street']['$t'];
                                                      }
                                                      if (isset($address_array['gd$city'])) {
                                                            $arr1['OtherCity'] = $address_array['gd$city']['$t'];
                                                      }
                                                      if (isset($address_array['gd$region'])) {
                                                            $arr1['OtherState'] = $address_array['gd$region']['$t'];
                                                      }
                                                      if (isset($address_array['gd$country'])) {
                                                            $arr1['OtherCountry'] = $address_array['gd$country']['$t'];
                                                      }
                                                      break;
                                                }
                                          }
                                    }
                              }
                        } elseif($feed['gContact$groupMembershipInfo'][0]['deleted']=='true' || (isset($feed['gd$deleted']))) {
                              $arr1['IsDeleted'] = 'true';
                        } 
                                                
                        $newresponsearray[] = $arr1;
                  }
                       
            }//loop

            
            return $newresponsearray;

        }


        public static function sendUpdatedToGoogle($email_id,$googleClient,$data_arr,$insturl,$accesstoken){
            $newgcontid_arr = array();
            $count = 0;
            foreach ((array) $data_arr['records'] as $data) {
                  
                try {
            //         // create new entry
                    $doc = new DOMDocument();
                    $doc->formatOutput = true;
                    $entry = $doc->createElement('atom:entry');

                    $entry->setAttributeNS('http://www.w3.org/2000/xmlns/','xmlns:atom', 'http://www.w3.org/2005/Atom');
                    $entry->setAttributeNS('http://www.w3.org/2000/xmlns/','xmlns:gd', 'http://schemas.google.com/g/2005');
                    $entry->setAttributeNS('http://www.w3.org/2000/xmlns/','xmlns:gd', 'http://schemas.google.com/g/2005');
                    $entry->setAttributeNS('http://www.w3.org/2000/xmlns/','xmlns:openSearch', 'http://a9.com/-/spec/opensearchrss/1.0/');
                    $entry->setAttributeNS('http://www.w3.org/2000/xmlns/','xmlns:gContact', 'http://schemas.google.com/contact/2008');
                
                    $doc->appendChild($entry);
                    // add name element
                    $name = $doc->createElement('gd:name');
                    $entry->appendChild($name);
                    //$contact.=" <gd:name>";
                     
                    if(!empty($data['FirstName'])){
                        $firstName = $doc->createElement('gd:givenName', $data['FirstName']);
                        $name->appendChild($firstName);
                    }
                    
                    if(!empty($data['LastName'])){
                        $lastName = $doc->createElement('gd:familyName', $data['LastName']);
                        $name->appendChild($lastName);
                    }
            //         //handling namePrefix
            //         if(!empty($bean->salutation)){
            //             // add salutation dome value instead of key
            //             $namePrefix = $doc->createElement('gd:namePrefix', $GLOBALS['app_list_strings'][$bean->field_defs['salutation']['options']][$bean->salutation]);
            //             $name->appendChild($namePrefix);
            //             $contact.="<gd:namePrefix>".$GLOBALS['app_list_strings'][$bean->field_defs['salutation']['options']][$bean->salutation]."/<gd:namePrefix>";
            //         }
            //         // add Notes element
                    $content = $doc->createElement('atom:content', $data['Description']);
                    $content->setAttribute('type' ,'text');
                    $entry->appendChild($content);

            //         // add email element
                    if(!empty($data['Email'])){
                        $email = $doc->createElement('gd:email');
                        $email->setAttribute('address' ,$data['Email']);
                        $email->setAttribute('primary' ,'true');
                        $email->setAttribute('rel' ,'http://schemas.google.com/g/2005#work');
                        $entry->appendChild($email);
                    }
                    
            //         if(!empty($bean->email2)){
            //             $email2 = $doc->createElement('gd:email');
            //             $email2->setAttribute('address' ,$bean->email2);
            //             $email2->setAttribute('rel' ,'http://schemas.google.com/g/2005#home');
            //             $entry->appendChild($email2);
            //         }
                
                    // add Phone work element
                    if(!empty($data['Phone'])){
                        
                        $phone_Number = $doc->createElement('gd:phoneNumber' ,$data['Phone']);
                        $phone_Number->setAttribute('rel' ,'http://schemas.google.com/g/2005#work');
                        $phone_Number->setAttribute('primary' ,'true');
                        $entry->appendChild($phone_Number);
                    }
                    
                    //add Phone mobile element
                    if(!empty($data['MobilePhone'])){
                        $phone_mobile = $doc->createElement('gd:phoneNumber' , $data['MobilePhone']);
                        $phone_mobile->setAttribute('rel' ,'http://schemas.google.com/g/2005#mobile');
                        $entry->appendChild($phone_mobile);
                    }
                    //add work fax element
                    if(!empty($data['Fax'])){
                        $phone_fax = $doc->createElement('gd:phoneNumber' , $data['Fax']);
                        $phone_fax->setAttribute('rel' ,'http://schemas.google.com/g/2005#work_fax');
                        $entry->appendChild($phone_fax);
                    }
                    
                    //add primary address element
                    $address = $doc->createElement('gd:structuredPostalAddress');
                    $address->setAttribute('rel' ,'http://schemas.google.com/g/2005#work');
                    $address->setAttribute('primary' ,'true');
                    $entry->appendChild($address);
                    
                    if(!empty($data['MailingStreet'])){
                        // file_put_contents('inmailingaddress', $data['MailingStreet']);
                        $street = $doc->createElement('gd:street' , $data['MailingStreet']);
                        $address->appendChild($street);
                    }
                    
                    if(!empty($data['MailingCity'])){
                        $city = $doc->createElement('gd:city' , $data['MailingCity']);
                        $address->appendChild($city);
                    }
                    
                    if(!empty($data['MailingState'])){
                        $region = $doc->createElement('gd:region' , $data['MailingState']);
                        $address->appendChild($region);
                    }
                    
                    if(!empty($data['MailingPostalCode'])){
                        $postcode = $doc->createElement('gd:postcode' , $data['MailingPostalCode']);
                        $address->appendChild($postcode);
                    }
                    
                    if(!empty($data['MailingCountry'])){
                        $country = $doc->createElement('gd:country' , $data['MailingCountry']);
                        $address->appendChild($country);
                    }
                    
                    //add alternate address element
                    $address = $doc->createElement('gd:structuredPostalAddress');
                    $address->setAttribute('rel' ,'http://schemas.google.com/g/2005#home');
                    $entry->appendChild($address);
                    
                    if(!empty($data['OtherStreet'])){
                        $street = $doc->createElement('gd:street' , $data['OtherStreet']);
                        $address->appendChild($street);
                    }
                    
                    if(!empty($data['OtherCity'])){
                        $city = $doc->createElement('gd:city' , $data['OtherCity']);
                        $address->appendChild($city);
                    }
                    
                    if(!empty($data['OtherState'])){
                        $region = $doc->createElement('gd:region' , $data['OtherState']);
                        $address->appendChild($region);
                    }
                    
                    if(!empty($data['OtherPostalCode'])){
                        $postcode = $doc->createElement('gd:postcode' , $data['OtherPostalCode']);
                        $address->appendChild($postcode);
                    }
                    
                    if(!empty($data['OtherCountry'])){
                        $country = $doc->createElement('gd:country' , $data['OtherCountry']);
                        $address->appendChild($country);
                    }
                    
                    // add organization element
                    $org = $doc->createElement('gd:organization');
                    $org->setAttribute('rel' ,'http://schemas.google.com/g/2005#work');
                    $entry->appendChild($org);

                    if(!empty($data['Account']['Name'])){
                          $orgName = $doc->createElement('gd:orgName', $data['Account']['Name']);
                          $org->appendChild($orgName);
                    }

                    if(!empty($data['Title'])){
                          $orgTitle = $doc->createElement('gd:orgTitle', $data['Title']);
                          $org->appendChild($orgTitle);
                    }           
            //         // insert entry

                    if($data['GSyncRt__gcontactid__c'] != ''){
                        // DELETE FROM GOOGLE
                        if ($data['IsDeleted'] == true) {
                              try{
                                            
                                  $group = $doc->createElement('gContact:groupMembershipInfo');
                                  $group->setAttribute('deleted' ,'true');
                                  $group->setAttribute('href' ,'https://www.google.com/m8/feeds/groups/'.urlencode($email_id) .'/base/6');//6 only for "My Contacts"
                                  $entry->appendChild($group);

                                  $len = strlen($doc->saveXML());
                                  $client_id = explode("base/",$data['GSyncRt__gcontactid__c']);
                                  $add = new Google_HttpRequest("https://www.google.com/m8/feeds/contacts/".$email_id."/full/".$client_id[1]."?&v=3.0&alt=json");
                                  $add->setRequestMethod("Delete");
                                  //$add->setPostBody($contact);
                                  $add->setPostBody($doc->saveXML());
                                  $add->setRequestHeaders(array('content-length' => $len, 'GData-Version'=> '3.0','content-type'=>'application/atom+xml; charset=UTF-8; type=feed','If-Match'=>'*'));

                                  $submit = $googleClient->getIo()->authenticatedRequest($add);
                                  $sub_response = $submit->getResponseBody();
                                  $sub_response_prev = $sub_response;
                                  $sub_response = json_decode($sub_response,1);
                                  if (!(isset($sub_response['entry']['id']['$t'])))
                                  {
                                      // file_put_contents('errorindelete.txt', $sub_response_prev);
                                      // $GLOBALS['log']->fatal("response: ".print_r($sub_response,1));
                                      // $GLOBALS['log']->fatal(print_r($sub_response_prev,1));
                                  } else {
                                      // file_put_contents('deletesuccess.txt', $sub_response['entry']['id']['$t']);
                                  }
                                  // $GLOBALS['log']->fatal($bean->object_name . ": " . $bean->name . " with id " . $bean->id . " updated in Google.");
                                  
                                  $newgcontid_arr[$data['Id']] = $sub_response['entry']['id']['$t'];
                              }catch(Exception $e){
                                  
                                  if($e->getCode()==404 || $e->getCode()==403){
                                        // not found or forbidden
                                      
                                  }else{
                                      $GLOBALS['log']->fatal('ERROR:' . $e->getMessage());
                                  }
                              }

                        } else {
                              //UPDATE IN GOOGLE
                              try{
                                            
                                  $group = $doc->createElement('gContact:groupMembershipInfo');
                                  $group->setAttribute('deleted' ,'false');
                                  $group->setAttribute('href' ,'https://www.google.com/m8/feeds/groups/'.urlencode($email_id) .'/base/6');//6 only for "My Contacts"
                                  $entry->appendChild($group);

                                  $len = strlen($doc->saveXML());
                                  $client_id = explode("base/",$data['GSyncRt__gcontactid__c']);

                                  $add = new Google_HttpRequest("https://www.google.com/m8/feeds/contacts/".$email_id."/full/".$client_id[1]."?&v=3.0&alt=json");
                                  
                                  $add->setRequestMethod("Put");
                                  //$add->setPostBody($contact);
                                  $add->setPostBody($doc->saveXML());
                                  $add->setRequestHeaders(array('content-length' => $len, 'GData-Version'=> '3.0','content-type'=>'application/atom+xml; charset=UTF-8; type=feed','If-Match'=>'*'));
                                  
                                  $submit = $googleClient->getIo()->authenticatedRequest($add);
                                  $sub_response = $submit->getResponseBody();
                                  $sub_response_prev = $sub_response;
                                  $sub_response = json_decode($sub_response,1);
                                  if (!(isset($sub_response['entry']['id']['$t'])))
                                  {
                                      // $GLOBALS['log']->fatal("response: ".print_r($sub_response,1));
                                      // $GLOBALS['log']->fatal(print_r($sub_response_prev,1));
                                  } else {
                                      // file_put_contents('updatesuccess.txt', $sub_response['entry']['id']['$t']);
                                  }
                                  // $GLOBALS['log']->fatal($bean->object_name . ": " . $bean->name . " with id " . $bean->id . " updated in Google.");
                                  
                                  $newgcontid_arr[$data['Id']] = $sub_response['entry']['id']['$t'];
                              }catch(Exception $e){
                                  
                                  if($e->getCode()==404 || $e->getCode()==403){// not found or forbidden
                                      
                                      //$GLOBALS['log']->fatal('Creating as a new entry...');
                                      //$bean->gcontact_id='';
                                      
                                  }else{
                                      $GLOBALS['log']->fatal('ERROR:' . $e->getMessage());
                                      //deleted from google or id changed in user settings but exist in sugar , delete it and unlink
                                      // $sql = "UPDATE contacts SET gcontact_id='' WHERE id='".$bean->id."';";
                                      // $db->query($sql);
                                  }
                              }
                        }
                        
                    }else{
                        //INSERT IN GOOGLE
                        if ($data['IsDeleted'] == false) {

                              $group = $doc->createElement('gContact:groupMembershipInfo');
                              $group->setAttribute('deleted' ,'false');
                              $group->setAttribute('href' ,'https://www.google.com/m8/feeds/groups/'.urlencode($email_id) .'/base/6');//6 only for "My Contacts"
                              $entry->appendChild($group);
                              // file_put_contents('nocontidfromsf', $doc->saveXML());
                              
                              $len = strlen($doc->saveXML());
                              $add = new Google_HttpRequest("https://www.google.com/m8/feeds/contacts/".$email_id."/full?&v=3.0&alt=json");
                              $add->setRequestMethod("Post");
                              $add->setPostBody($doc->saveXML());
                              $add->setRequestHeaders(array('content-length' => $len, 'GData-Version'=> '3.0','content-type'=>'application/atom+xml; charset=UTF-8; type=feed'));
                              $submit = $googleClient->getIo()->authenticatedRequest($add);
                              $sub_response = $submit->getResponseBody();

                              $sub_response_prev = $sub_response;
                              $sub_response = json_decode($sub_response,1);
                              if (!(isset($sub_response['entry']['id']['$t'])))
                              {
                  //             $GLOBALS['log']->fatal("response: ".print_r($sub_response,1));
                              }

                              $newgcontid_arr[$data['Id']] = $sub_response['entry']['id']['$t'];
                              //inserted send back on sf for update
                              $id = $data['Id'];
                              $newgcontid = $sub_response['entry']['id']['$t'];
                              print_r($newgcontid);

                              $content = json_encode(array("GSyncRt__gcontactid__c" => $newgcontid, "GSyncRt__SyncDirection__c" => "From Sf"));
                              $url = $insturl . "/services/data/v20.0/sobjects/Contact/$id";
                              $curl = curl_init($url);
                              curl_setopt($curl, CURLOPT_HEADER, false);
                              curl_setopt($curl, CURLOPT_HTTPHEADER,
                                      array("Authorization: Bearer " . $accesstoken,
                                          "Content-type: application/json"));
                              curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PATCH");
                              curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
                              curl_setopt($curl, CURLOPT_SSLVERSION, 6);
                              curl_exec($curl); 
                              curl_close($curl);

                        }
                        //return $sub_response['entry']['id']['$t'];
                    }     
                } catch (Exception $e) {
                    $GLOBALS['log']->fatal('ERROR:' . $e->getMessage());
                }
                
            }
            // file_put_contents("newgcontid_arr.txt", count($newgcontid_arr));
            return $newgcontid_arr;
        }

        public static function deleteAllInGoogle($email_id,$googleClient,$data_arr,$insturl,$accesstoken){
            $newgcontid_arr = array();
            $count = 0;
            foreach ((array) $data_arr['records'] as $data) {
                try {
            //         // create new entry
                    $doc = new DOMDocument();
                    $doc->formatOutput = true;
                    $entry = $doc->createElement('atom:entry');

                    $entry->setAttributeNS('http://www.w3.org/2000/xmlns/','xmlns:atom', 'http://www.w3.org/2005/Atom');
                    $entry->setAttributeNS('http://www.w3.org/2000/xmlns/','xmlns:gd', 'http://schemas.google.com/g/2005');
                    $entry->setAttributeNS('http://www.w3.org/2000/xmlns/','xmlns:gd', 'http://schemas.google.com/g/2005');
                    $entry->setAttributeNS('http://www.w3.org/2000/xmlns/','xmlns:openSearch', 'http://a9.com/-/spec/opensearchrss/1.0/');
                    $entry->setAttributeNS('http://www.w3.org/2000/xmlns/','xmlns:gContact', 'http://schemas.google.com/contact/2008');
                
                    $doc->appendChild($entry);
                    // add name element
                    $name = $doc->createElement('gd:name');
                    $entry->appendChild($name);
                    //$contact.=" <gd:name>";
                     
                    if(!empty($data['FirstName'])){
                        $firstName = $doc->createElement('gd:givenName', $data['FirstName']);
                        $name->appendChild($firstName);
                    }
                    
                    if(!empty($data['LastName'])){
                        $lastName = $doc->createElement('gd:familyName', $data['LastName']);
                        $name->appendChild($lastName);
                    }

                    $content = $doc->createElement('atom:content', 'i am a description');
                    $content->setAttribute('type' ,'text');
                    $entry->appendChild($content);

            //         // add email element
                    if(!empty($data['Email'])){
                        $email = $doc->createElement('gd:email');
                        $email->setAttribute('address' ,$data['Email']);
                        $email->setAttribute('primary' ,'true');
                        $email->setAttribute('rel' ,'http://schemas.google.com/g/2005#work');
                        $entry->appendChild($email);
                    }

                        try{
                                      
                            $group = $doc->createElement('gContact:groupMembershipInfo');
                            $group->setAttribute('deleted' ,'true');
                            $group->setAttribute('href' ,'https://www.google.com/m8/feeds/groups/'.urlencode($email_id) .'/base/6');//6 only for "My Contacts"
                            $entry->appendChild($group);

                            $len = strlen($doc->saveXML());
                            $client_id = explode("base/",$data['GSyncRt__gcontactid__c']);
                            $add = new Google_HttpRequest("https://www.google.com/m8/feeds/contacts/".$email_id."/full/".$client_id[1]."?&v=3.0&alt=json");
                            $add->setRequestMethod("Delete");
                            //$add->setPostBody($contact);
                            $add->setPostBody($doc->saveXML());
                            $add->setRequestHeaders(array('content-length' => $len, 'GData-Version'=> '3.0','content-type'=>'application/atom+xml; charset=UTF-8; type=feed','If-Match'=>'*'));

                            $submit = $googleClient->getIo()->authenticatedRequest($add);
                            $sub_response = $submit->getResponseBody();
                            $sub_response_prev = $sub_response;
                            $sub_response = json_decode($sub_response,1);
                            if (!(isset($sub_response['entry']['id']['$t']))) {
                                // file_put_contents('errorindelete.txt', $sub_response_prev);
                            } else {
                                // file_put_contents('deletesuccess.txt', $sub_response['entry']['id']['$t']);
                            }

                            $newgcontid_arr[$data['Id']] = $sub_response['entry']['id']['$t'];
                        }catch(Exception $e){
                            
                            if($e->getCode()==404 || $e->getCode()==403){
                                  // not found or forbidden
                                
                            }else{
                                $GLOBALS['log']->fatal('ERROR:' . $e->getMessage());
                            }
                        }

                } catch (Exception $e) {
                    $GLOBALS['log']->fatal('ERROR:' . $e->getMessage());
                }
                
            }
            return $newgcontid_arr;
        }

        public static function delChangedOwnerContact($email_id,$googleClient,$contidd,$insturl,$accesstoken){
            $newgcontid_arr = array();
            $count = 0;
            //foreach ((array) $data_arr['records'] as $data) {
                try {
            //         // create new entry
                    $doc = new DOMDocument();
                    $doc->formatOutput = true;
                    $entry = $doc->createElement('atom:entry');

                    $entry->setAttributeNS('http://www.w3.org/2000/xmlns/','xmlns:atom', 'http://www.w3.org/2005/Atom');
                    $entry->setAttributeNS('http://www.w3.org/2000/xmlns/','xmlns:gd', 'http://schemas.google.com/g/2005');
                    $entry->setAttributeNS('http://www.w3.org/2000/xmlns/','xmlns:gd', 'http://schemas.google.com/g/2005');
                    $entry->setAttributeNS('http://www.w3.org/2000/xmlns/','xmlns:openSearch', 'http://a9.com/-/spec/opensearchrss/1.0/');
                    $entry->setAttributeNS('http://www.w3.org/2000/xmlns/','xmlns:gContact', 'http://schemas.google.com/contact/2008');
                
                    $doc->appendChild($entry);
                    // add name element
                    $name = $doc->createElement('gd:name');
                    $entry->appendChild($name);
                    //$contact.=" <gd:name>";
                     
                    //if(!empty($data['FirstName'])){
                        $firstName = $doc->createElement('gd:givenName', 'FirstName');
                        $name->appendChild($firstName);
                    //}
                    
                    //if(!empty($data['LastName'])){
                        $lastName = $doc->createElement('gd:familyName', 'LastName');
                        $name->appendChild($lastName);
                    //}

                    $content = $doc->createElement('atom:content', 'i am a description');
                    $content->setAttribute('type' ,'text');
                    $entry->appendChild($content);

            //         // add email element
                    //if(!empty($data['Email'])){
                        $email = $doc->createElement('gd:email');
                        $email->setAttribute('address' ,'email@email.com');
                        $email->setAttribute('primary' ,'true');
                        $email->setAttribute('rel' ,'http://schemas.google.com/g/2005#work');
                        $entry->appendChild($email);
                   // }

                        try{
                                      
                            $group = $doc->createElement('gContact:groupMembershipInfo');
                            $group->setAttribute('deleted' ,'true');
                            $group->setAttribute('href' ,'https://www.google.com/m8/feeds/groups/'.urlencode($email_id) .'/base/6');//6 only for "My Contacts"
                            $entry->appendChild($group);

                            $len = strlen($doc->saveXML());
                            $client_id = explode("base/",$contidd);
                            $add = new Google_HttpRequest("https://www.google.com/m8/feeds/contacts/".$email_id."/full/".$client_id[1]."?&v=3.0&alt=json");
                            $add->setRequestMethod("Delete");
                            //$add->setPostBody($contact);
                            $add->setPostBody($doc->saveXML());
                            $add->setRequestHeaders(array('content-length' => $len, 'GData-Version'=> '3.0','content-type'=>'application/atom+xml; charset=UTF-8; type=feed','If-Match'=>'*'));

                            $submit = $googleClient->getIo()->authenticatedRequest($add);
                            $sub_response = $submit->getResponseBody();
                            $sub_response_prev = $sub_response;
                            $sub_response = json_decode($sub_response,1);
                            if (!(isset($sub_response['entry']['id']['$t']))) {
                                // file_put_contents('errorindelete.txt', $sub_response_prev);
                            } else {
                                // file_put_contents('deletesuccess.txt', $sub_response['entry']['id']['$t']);
                            }

                            //$newgcontid_arr[$data['Id']] = $sub_response['entry']['id']['$t'];
                        }catch(Exception $e){
                            
                            if($e->getCode()==404 || $e->getCode()==403){
                                  // not found or forbidden
                                
                            }else{
                                $GLOBALS['log']->fatal('ERROR:' . $e->getMessage());
                            }
                        }

                } catch (Exception $e) {
                    $GLOBALS['log']->fatal('ERROR:' . $e->getMessage());
                }
                
            //}
            return $newgcontid_arr;
        }


    }
    
    
    
?>