({
	doInit : function(component, event, helper) {
		var action = component.get("c.loadAdmin");
        
		action.setCallback(this, function(a) {
            var isSuccess = helper.checkResult(component, a);
            if( !isSuccess ) {
                component.set("v.loadResult", a.getReturnValue().result);
                return;
            }
            
            var result = a.getReturnValue().result;
            
            if( !result.isSetupCompleted ) {
                var retUrl = encodeURIComponent( window.location.href );
        		var openUrl = '/apex/EchoSignSetupWizard?retUrl=' + retUrl;
                
        		if( result.uiThemeDisplayed == 'Theme4d' || result.uiThemeDisplayed == 'Theme4t' ) {
           			window.open(openUrl);
                    window.parent.location.href = '/';
        		} else {
            		window.location.href = openUrl;
        		}
                
                return;
            }

			component.set("v.loadResult", result);
			component.set("v.isLoading", false);
		});
		$A.enqueueAction(action);
	},
    
    toggleNetworkRangesDialog : function(component, event, helper) {
        helper.toggleElemVisibility("networkRangesDialog");
    },
    
    toggleSignatureComponentsDialog : function(component, event, helper) {
        helper.toggleElemVisibility("signatureComponentsDialog");
    },
    
    addNetworkRangeOne : function(component, event, helper) {
        window.open("/05G/e?IpEndAddress=166.78.79.127&IpStartAddress=166.78.79.112");
    }, 
    
    addNetworkRangeTwo : function(component, event, helper) {
        window.open("/05G/e?IpEndAddress=52.71.63.255&IpStartAddress=52.71.63.224");
    },  
    
    addNetworkRangeThree : function(component, event, helper) {
        window.open("/05G/e?IpEndAddress=52.35.253.95&IpStartAddress=52.35.253.64");
    },  
    
    addNetworkRangeFour : function(component, event, helper) {
        window.open("/05G/e?IpEndAddress=52.48.127.191&IpStartAddress=52.48.127.160");
    },  
    
    addNetworkRangeFive : function(component, event, helper) {
        window.open("/05G/e?IpEndAddress=52.58.63.223&IpStartAddress=52.58.63.192");
    },  
    
    addNetworkRangeSix : function(component, event, helper) {
        window.open("/05G/e?IpEndAddress=207.97.227.127&IpStartAddress=207.97.227.112");
    },  
    
    addNetworkRangeSeven : function(component, event, helper) {
        window.open("/05G/e?IpEndAddress=52.65.255.222&IpStartAddress=52.65.255.192");
    },  
    
    addNetworkRangeEight : function(component, event, helper) {
        window.open("/05G/e?IpEndAddress=52.196.191.254&IpStartAddress=52.196.191.224");
    },
    
    addAccountLayout : function(component, event, helper) {
        helper.goToSignatureLayout(component, "Account");
    },
    
    addOpportunityLayout : function(component, event, helper) {
        helper.goToSignatureLayout(component, "Opportunity");
    },
    
    addLeadLayout : function(component, event, helper) {
        helper.goToSignatureLayout(component, "Lead");
    },
    
    addContractLayout : function(component, event, helper) {
        helper.goToSignatureLayout(component, "Contract");
    },
    
    addContactLayout : function(component, event, helper) {
        helper.goToSignatureLayout(component, "Contact");
    },
    
    doUnlinkAccount : function(component, event, helper) {
		component.set("v.isLoading", true);
        
        var result = component.get("v.loadResult");        
		var action = component.get("c.unlinkAccount");
        
		action.setCallback(this, function(a) {
            var isSuccess = helper.checkResult(component, a);
            if( !isSuccess ) {
                return;
            }
            
            result.authEmail = null;
            
            component.set("v.loadResult", result);
			component.set("v.isLoading", false);
		});
		$A.enqueueAction(action);
	},

    navToAuth : function(component, event, helper) {
        var result = component.get("v.loadResult");
        
        var returnUrl = encodeURIComponent("/apex/EchoSignAdmin");
        var openUrl = '/apex/EchoSignSetupWizard?stepName=admin&retUrl=' + returnUrl;
        
        if( result.uiThemeDisplayed == 'Theme4d' || result.uiThemeDisplayed == 'Theme4t' ) {
           	window.open(openUrl); 
        } else {
            window.location.href = openUrl;
        }
	},
	
    navToWizard : function(component, event, helper) {
        var result = component.get("v.loadResult");
        
        var returnUrl = encodeURIComponent("/apex/EchoSignAdmin");
        var openUrl = '/apex/EchoSignSetupWizard?retUrl=' + returnUrl;
        
        if( result.uiThemeDisplayed == 'Theme4d' || result.uiThemeDisplayed == 'Theme4t' ) {
           	window.open(openUrl); 
        } else {
            window.location.href = openUrl;
        }
	},
    
    navToLayout : function(component, event, helper) {
        var action = component.get("c.setLayoutCompleted");
        
		action.setCallback(this, function(a) {
            var isSuccess = helper.checkResult(component, a);
            if( !isSuccess ) {
                return;
            }
        
        	window.location.href = '/ui/setup/layout/PageLayouts?type=Account&setupid=AccountLayouts';
		});
		$A.enqueueAction(action);
	},
    
    navToMerge : function(component, event, helper) {
        var result = component.get("v.loadResult");
        
        if( result.uiThemeDisplayed == 'Theme4d' || result.uiThemeDisplayed == 'Theme4t' ) {
            window.parent.location.href = '/' + result.mergeMappingPrefix + '/e';  
        } else {
        	window.location.href = '/' + result.mergeMappingPrefix + '/e';    
        }
	},
    
    navToData : function(component, event, helper) {
        var result = component.get("v.loadResult");
        
        if( result.uiThemeDisplayed == 'Theme4d' || result.uiThemeDisplayed == 'Theme4t' ) {
            window.parent.location.href = '/' + result.dataMappingPrefix + '/e';  
        } else {
        	window.location.href = '/' + result.dataMappingPrefix + '/e';    
        }
	},

    navToTemplates : function(component, event, helper) {
        var result = component.get("v.loadResult");
        
        if( result.uiThemeDisplayed == 'Theme4d' || result.uiThemeDisplayed == 'Theme4t' ) {
        	window.parent.location.href = '/one/one.app#/sObject/' + result.agreementTemplatePrefix + '/home';
        } else {
        	window.location.href = '/' + result.agreementTemplatePrefix + '/e';     
        }
	},
    
    navToGroup : function(component, event, helper) {
        window.location.href = '/apex/GroupMapping';
	},
    
    navToCustomSettings : function(component, event, helper) {
        var result = component.get("v.loadResult");
        
        if( result.uiThemeDisplayed == 'Theme4d' || result.uiThemeDisplayed == 'Theme4t' ) {
           	window.open('/one/one.app#/setup/CustomSettings/home');
        } else {
            window.open('/setup/ui/listCustomSettings.apexp');
        } 	
	},

    navToUpdate : function(component, event, helper) {
        var result = component.get("v.loadResult");
        var partnerUrl = component.get("v.partnerUrl");
        var url = result.baseServerUrl + '/salesforce-web/salesforceCredentials?session=' + result.sessionId + '&server=' + encodeURIComponent(partnerUrl) + '&namespace=' + result.namespace + '&Version=' + result.version + "&locale=" + result.language;
        
        window.open(url);
	}, 
    
    navToAdmin : function(component, event, helper) {
        component.set("v.isLoading", true);
        
        var action = component.get("c.getAccountMgmtUrl");
        
		action.setCallback(this, function(a) {
            var isSuccess = helper.checkResult(component, a);
            if( !isSuccess ) {
                component.set("v.loadResult", a.getReturnValue().result);
                return;
            }
            
            window.open( a.getReturnValue().result );

			component.set("v.isLoading", false);
		});
		$A.enqueueAction(action);
	}, 

    navToUserGuide : function(component, event, helper) {
        window.open("http://www.adobe.com/go/echosign_salesforce_installguide");
	},    

    navToForum : function(component, event, helper) {
        window.open("https://forums.adobe.com/community/document-cloud-esign-services/salesforce_integration?view=overview");
	},     

    navToTextTag : function(component, event, helper) {
        window.open("http://www.adobe.com/go/echosign_createforms_texttags");
	},    

    navToSmartForm : function(component, event, helper) {
        window.open("https://helpx.adobe.com/acrobat/using/creating-distributing-pdf-forms.html");
	},    

    navToPortal : function(component, event, helper) {
        window.open("https://www.echosign.adobe.com/en/support.html");
	},
    
    dismissAlert : function(component, event, helper) {
        component.set("v.errorMessage", null);
    }
})