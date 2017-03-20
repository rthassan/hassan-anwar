({
    initSetupWizard : function(component) {
        var self = this;
        
	    var wizardStep = component.get("v.wizardStep");
        var action = component.get("c.loadSetupWizard");
        action.setParams({
        	"wizardStep": wizardStep
        });
            
        action.setCallback(this, function(a) {
        	var isSuccess = self.checkResult(component, a);
            if( !isSuccess ) {
            	return;
            }
                
            var setupWizardResult = a.getReturnValue();
    
            component.set("v.setupWizardResult", setupWizardResult);

			var partnerUrl = component.get("v.partnerUrl");  
            var updatesFrameUrl = setupWizardResult.baseServerUrl + "/salesforce-web/salesforceCredentials?session=" + setupWizardResult.sessionId + "&server=" + encodeURIComponent(partnerUrl) + "&namespace=" + setupWizardResult.namespace + "&Version=" + setupWizardResult.version + "&locale=" + setupWizardResult.language;
            
            component.set("v.updatesFrameUrl", updatesFrameUrl);
            
            self.initState(component);
        });
    	$A.enqueueAction(action);
    },
    
    initState : function(component) {
    	var self = this;
    
        var result = component.get("v.setupWizardResult");
        
        var oauthStep = result.step;
        var oauthState = component.get("v.oauthState");
        var oauthCode = component.get("v.oauthCode");
        var oauthError = component.get("v.oauthError");
        var oauthErrorDescription = component.get("v.oauthErrorDescription");
        var apiAccessPoint = component.get("v.apiAccessPoint");
              
        if( oauthError != null && oauthError != "" ) {
             if( oauthErrorDescription.includes("Your product edition does not support account scopes ") != -1 ) {
                oauthErrorDescription = "Please contact Adobe Sign support to make sure your account is ready to use Adobe Sign for Salesforce. Your account tier may not be at the proper level to proceed.";
            }
            
            var errorMessage = "Adobe Sign Authentication Error: " + oauthError + " : " + oauthErrorDescription;
            
            component.set("v.isLoading", false);
            component.set("v.isError", true);
            component.set("v.errorMessage", errorMessage); 
        } else if( oauthCode != null && oauthCode != "" ) {
            if( oauthState != result.state ) {
                var errorMessage = "Invalid state token, rejecting authentication redirect";
                
                component.set("v.isLoading", false);
                component.set("v.isError", true);
                component.set("v.errorMessage", errorMessage);
                
                return;
        	}
            
        	var setupWizardResult = component.get("v.setupWizardResult");
            if( setupWizardResult.isNetworkRangesAdded ) {
                self.storeAuthToken(component);
                    
            	return;
            }
            
            self.ensureRemoteSite(component);
            self.ensureSecurityRanges(component);
        } else {
            component.set("v.isLoading", false);
        }
	},
    
    storeAuthToken : function(component) {
        var self = this;
        
        var oauthCode = component.get("v.oauthCode");
        var apiAccessPoint = component.get("v.apiAccessPoint");
        
  		var action = component.get("c.storeOauth");
        action.setParams({
        	"oauthCode": oauthCode,
            "apiAccessPoint": apiAccessPoint
        });
            
        action.setCallback(this, function(a) {
        	var isSuccess = self.checkResult(component, a);
            if( !isSuccess ) {
            	return;
            }
                
            self.storeEmail(component);
       	});
        $A.enqueueAction(action);
    },
    
    storeEmail : function(component) {
        var self = this;
        
        var result = component.get("v.setupWizardResult");
        
        var oauthStep = result.step;
        
    	var action = component.get("c.storeOauthEmail");
            
        action.setCallback(this, function(a) {
       		var isSuccess = self.checkResult(component, a);
            if( !isSuccess ) {
            	return;
            } 
            
            if( oauthStep == "admin" ) {
                var url = "/apex/EchoSignAdmin";
                window.location.href = url;
        	}
                
        	component.set("v.isLoading", false);
        });
        $A.enqueueAction(action);
    },
    
    ensureSecurityRanges : function(component) {
        var self = this;
          
        self.processGetMetadata(component);
    },
    
    processDeployMetadata : function(component, metadata) {
        var self = this;
        
        var action = component.get("c.submitDeployMatadata");
        action.setParams({
        	"metadata": metadata
        });
                
        action.setCallback(this, function(a) {
        	var isSuccess = self.checkResult(component, a);
            if( !isSuccess ) {
            	return;
            } 
                    
            var jobId = a.getReturnValue().result;
                
        	self.processPollDeployMetadata(component, jobId);
        });
       	$A.enqueueAction(action);
    },    
    
    processGetMetadata : function(component) {
        var self = this;
        
        var action = component.get("c.submitGetMatadata");
                
        action.setCallback(this, function(a) {
        	var isSuccess = self.checkResult(component, a);
            if( !isSuccess ) {
            	return;
            } 
                    
            var jobId = a.getReturnValue().result;
                
        	self.processPollGetMetadata(component, jobId);
        });
       	$A.enqueueAction(action);
    },

    processPollDeployMetadata : function(component, jobId) {
    	var self = this;
        
        var action = component.get("c.pollDeployMatadata");
        action.setParams({
        	"jobId": jobId
        });
                
        action.setCallback(this, function(a) {
        	var isSuccess = self.checkResult(component, a);
            if( !isSuccess ) {
            	return;
            }
                    
           	var isDeployed = a.getReturnValue().result;
                    
           	if( isDeployed ) {
                self.storeAuthToken(component);
            } else {
                self.processPollDeployMetadata(component, jobId);
            }
      	});
        $A.enqueueAction(action); 
    },
    
    processPollGetMetadata : function(component, jobId) {
    	var self = this;
        
        var action = component.get("c.pollGetMatadata");
        action.setParams({
        	"jobId": jobId
        });
                
        action.setCallback(this, function(a) {
        	var isSuccess = self.checkResult(component, a);
            if( !isSuccess ) {
            	return;
            }
                    
           	var metadata = a.getReturnValue().result;
                    
           	if( metadata != null ) {
            	self.processAddMetadata(component, metadata);
            } else {
                self.processPollGetMetadata(component, jobId);
            }
      	});
        $A.enqueueAction(action); 
    },
        
    processAddMetadata : function(component, zipMetadata) {
        var self = this;
        
        var metadata = self.unzip(zipMetadata, 'settings/Security.settings');
        
        var action = component.get("c.ensureNetworkRangesExists");
        action.setParams({
        	"metadata": metadata
        });
                
        action.setCallback(this, function(a) {
        	var isSuccess = self.checkResult(component, a);
            if( !isSuccess ) {
            	return;
            }
                    
           	var metadataFileData = a.getReturnValue().result;
                    
           	if( metadataFileData != null ) {
            	self.zipMatadata(component, metadataFileData);
            } else { //Network ranges already exist
                //move to update screen
                //self.proceedToUpdateStep(component);
                self.storeAuthToken(component);
            }
      	});
        $A.enqueueAction(action);
    },
    
    proceedToLogin : function(component) {
        var result = component.get("v.setupWizardResult");
        var url = result.oauthLoginUrl;
		window.location.href = url;
    },
    
    proceedToFinal : function (component) {
       	var self = this;
        
       	var action = component.get("c.setSetupCompleted");
                
        action.setCallback(this, function(a) {
            var isSuccess = self.checkResult(component, a);
            if( !isSuccess ) {
            	return;
            }
            
            component.set("v.isLoading", true);
            component.set("v.completeStep", true);
            component.set("v.updateStep", false);
            component.set("v.isLoading", false);
        });
        $A.enqueueAction(action);
    },
    
    proceedToComplete : function (component) {
       	var self = this;
        
       	self.proceedToExit(component);
    },
    
    proceedToExit : function (component) {
        var result = component.get("v.setupWizardResult");
        
        if( result.uiThemeDisplayed == 'Theme4d' || result.uiThemeDisplayed == 'Theme4t' ) {
           	window.close(); 
            return;
        }
        
       	var url = component.get("v.returnUrl");
        if( url == null || url == "" ) {
            url = "/";
        }
		window.location.href = url;
    },
    
    proceedToUpdateStep : function (component) {
        component.set("v.oauthStep", false);
        component.set("v.updateStep", true);
        component.set("v.isLoading", false);
    },
    
    zipMatadata : function (component, metadataFileData) {
        var self = this;
        
    	var fileName = 'settings/Security.settings';
    	var metadataDeployZip = self.zip(metadataFileData, fileName);
    		
	    self.processDeployMetadata(component, metadataDeployZip);
    },
    
    ensureRemoteSite : function(component) {
        var self = this;
        
    	var setupWizardResult = component.get("v.setupWizardResult");
        
    	/*if( setupWizardResult.isMetatadataRemoteSiteExists ) {
    		return true;
    	}*/
        
    	var isSuccess = self.createRemoteSite(component, setupWizardResult.host, setupWizardResult.sessionId);
        
        return isSuccess;
    },
    
	unzip : function(zipData, fileName) {
		    var zip = new JSZip(zipData, {base64:true});
		    var zipFileNames = [];
		    for(var zipfileName in zip.files) {
		    	if( fileName == '' || fileName == null || fileName == zipfileName ) {
		        	zipFileNames.push(zipfileName);
		        	break;
		        }  
		    }
		              
	        var fileName = null;
	        var file = null;
	        while(true)
	        {
	        	// Pop the next file
	            file = null;
	            fileName = zipFileNames.pop();
	            if(fileName == null)
	                break;
	            file = zip.files[fileName];
	            // Only break for files, skip over folder entries
	            if(file.data!=null && file.data.length>0)
	                break;
	        }
	        // File to send or done?
	        var more = file!=null ? true : false;
	        var path = more ? fileName : null;
	        var data = more ? file.data : null;
        
	        return data;
	},
		
	zip : function(data, path) {
        var packageXml = '<?xml version="1.0" encoding="UTF-8"?><Package xmlns="http://soap.sforce.com/2006/04/metadata"><types><members>Security</members><name>Settings</name></types><version>33.0</version></Package>';
		var zipFile = new JSZip();		
		zipFile.file('package.xml', packageXml);
		zipFile.file(path, data);	
		var zipData = zipFile.generate();
			
		return zipData;
	},

    createRemoteSite : function(component, host, sessionId) {
        var self = this;
        
			// Calls the Metdata API from JavaScript to create the Remote Site Setting to permit Apex callouts
			var binding = new XMLHttpRequest();
			var request = 
				'<?xml version="1.0" encoding="utf-8"?>' + 
				'<env:Envelope xmlns:env="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">'+
					'<env:Header>' + 
						'<urn:SessionHeader xmlns:urn="http://soap.sforce.com/2006/04/metadata">' + 
							'<urn:sessionId>' + sessionId + '</urn:sessionId>' + 
						'</urn:SessionHeader>' + 
						'<urn:CallOptions xmlns:urn="http://soap.sforce.com/2006/04/metadata">' + 
							'<urn:client>Adobe/Echosign/</urn:client>' + 
						'</urn:CallOptions>' + 
					'</env:Header>' + 
					'<env:Body>' +
						'<createMetadata xmlns="http://soap.sforce.com/2006/04/metadata">' + 
							'<metadata xsi:type="RemoteSiteSetting">' + 
								'<fullName>adobeesign_mdapi_v18</fullName>' + 
								'<description>Metadata API Remote Site Setting for the Adobe Sign for Salesforce v18</description>' + 
								'<disableProtocolSecurity>false</disableProtocolSecurity>' + 
								'<isActive>true</isActive>' + 
								'<url>' + host + '</url>' +
							'</metadata>' +
                			'<metadata xsi:type="RemoteSiteSetting">' + 
								'<fullName>adobeesign_api</fullName>' + 
								'<description>API Remote Site Setting for Adobe Sign for Salesforce</description>' + 
								'<disableProtocolSecurity>false</disableProtocolSecurity>' + 
								'<isActive>true</isActive>' + 
								'<url>' + component.get("v.apiAccessPoint") + '</url>' +
							'</metadata>' +
						'</createMetadata>' +
					'</env:Body>' + 
				'</env:Envelope>';
			
			binding.open('POST', host + '/services/Soap/m/33.0');
			binding.setRequestHeader('SOAPAction','""');
			binding.setRequestHeader('Content-Type', 'text/xml');
			binding.onreadystatechange = 
				function() { 
					if(this.readyState==4) {
						var parser = new DOMParser();
						var doc  = parser.parseFromString(this.response, 'application/xml');
                        var errors = doc.getElementsByTagName('errors');
						var messageText = '';
                        for(var errorIdx = 0; errorIdx < errors.length; errorIdx++) {
							messageText+= errors.item(errorIdx).getElementsByTagName('message').item(0).innerHTML + '\n';
                        } 
                        
                        if( messageText == null ||
                           messageText == '' ||
                           messageText.indexOf('This Remote Site Name already exists or has been previously used') != -1 ) {
     						return;
                        }
                        
                        component.set("v.isLoading", false);
                		component.set("v.isError", true);
                		component.set("v.errorMessage", messageText); 
                    }
				}
			binding.send(request);
		},
            
    checkResult : function(component, response) {
        var self = this;
        
    	var state = response.getState();
        if (state !== "ERROR") {
            if( response.getReturnValue() != null && response.getReturnValue().error != null ) {
            	self.handleError(component, response.getReturnValue().error);
                return false;
        	}
        	return true;
        }

        
                var errorMessage = "";
                var errors = response.getError();
                if (errors) {
                	for(var i = 0; errors && i < errors.length; i++) {
                        var error = errors[i];

                        if( error.message ) {
                        	errorMessage += ( " " + error.message );  
                        }
                        
                        for(var j = 0; error && error.fieldErrors && j < error.fieldErrors.length; j++) {
                            var fieldError = error.fieldErrors[j]; 
                            if( fieldError && fieldError.message ) {
                                errorMessage += ( " " + fieldError.message );
                            }
                        }
                        
                        for(var j = 0; error && error.pageErrors && j < error.pageErrors.length; j++) {
                            var pageError = error.pageErrors[j]; 
                            if( pageError && pageError.message ) {
                                errorMessage += ( " " + pageError.message );
                            }
                        }
                    }
                } else {
                    errorMessage += " Unknown error";
                }

        		self.handleError(component, errorMessage);
                
                return false;
    },
        
    handleError : function(component, errorMessage) {
    	component.set("v.isLoading", false);
        component.set("v.isError", true);
       	component.set("v.errorMessage", errorMessage);
    }
})