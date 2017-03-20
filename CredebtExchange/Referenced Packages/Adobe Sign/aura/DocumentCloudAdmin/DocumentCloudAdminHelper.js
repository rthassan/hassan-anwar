({
	toggleElemVisibility: function(elemId) {
   		var elem = document.getElementById(elemId);
        var elemClass = elem.getAttribute("class");
        
        if( elemClass.indexOf("slds-show") != -1 ) {
            elemClass = elemClass.replace("slds-show", "slds-hide");
        } else {
            elemClass = elemClass.replace("slds-hide", "slds-show");
        }
        
        elem.setAttribute("class", elemClass);
    },
    
    goToSignatureLayout : function(component, type) {
        var self = this;
        
        var result = component.get("v.loadResult");
        var action = component.get("c.setLayoutCompleted");
        
		action.setCallback(this, function(a) {
            var isSuccess = self.checkResult(component, a);
            if( !isSuccess ) {
                return;
            } 
            
            if( result.uiThemeDisplayed == 'Theme4d' || result.uiThemeDisplayed == 'Theme4t' ) {
            	window.open('/one/one.app?source=aloha#/setup/object/' + type);
            } else {
                window.open('/ui/setup/layout/PageLayouts?type=' + type + '&setupid=' + type + 'Layouts');
            }
            
            self.toggleElemVisibility("signatureComponentsDialog");
		});
		$A.enqueueAction(action);
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