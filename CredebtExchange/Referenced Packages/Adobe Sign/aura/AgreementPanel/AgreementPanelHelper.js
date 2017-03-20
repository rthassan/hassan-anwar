({
    initAgreementData : function(component, masterObjectRecordId, recordFieldName) {
        var masterObjectRecordId = component.get("v.recordId");
        var recordFieldName = component.get("v.recordFieldName");
        var agreementTemplateRecordIds = component.get("v.agreementTemplateRecordIds");
        var resultSize = 2;
        
        var action = component.get("c.getRecentAgreementData");
        action.setParams({
            "masterObjectRecordId" : masterObjectRecordId,
            "recordFieldName" : recordFieldName,
            "orderFieldName" : "LastModifiedDate",
            "resultSize" : resultSize,
            "agreementTemplateRecordIds" : agreementTemplateRecordIds
        });
        
		action.setCallback(this, function(a) {
			var recordAgreementDataResult = a.getReturnValue();
            
            component.set("v.recentResult", recordAgreementDataResult);
            component.set("v.isLoading", false);
        });
		$A.enqueueAction(action);
	},
    
    initSettings: function(component) {
        var action = component.get("c.getSettings");
		action.setCallback(this, function(a) {
			var settingsWrapper = a.getReturnValue();
            component.set("v.settingsWrapper", settingsWrapper);
        });
		$A.enqueueAction(action);
    },
    
    getNamespacePrefix : function(component) {
        return component.getDef().getDescriptor().getNamespace() + "__";
    },
    
    createNewAgreement : function(component, agreementTemplateId) {
        var self = this;
        
        self.toggleElemVisibility(component, "newAgreementDropdown");
        
        var masterObjectRecordId = component.get("v.recordId");
        var agreementUrl = "/apex/" + self.getNamespacePrefix(component) + "AgreementEditor";
        
        if( agreementTemplateId != null ) {
            agreementUrl += ( "?templateId=" + agreementTemplateId + "&masterId=" + masterObjectRecordId );
        }
        
        self.navToUrl(agreementUrl);
        
        component.set("v.isLoading", false);
    },
    
    invokeAgreementAction : function(component, agreementId, actionName) {
        var self = this;
        
        self.hideElemVisibility("agreementActionDropdown" + agreementId);
        
        var agreementUrl = "/apex/" + self.getNamespacePrefix(component) + "AgreementEditor?id=" + agreementId;
        
        if( actionName != "edit" ) {
            agreementUrl += ( "&onloadAction=" + actionName );
        }
        
        self.navToUrl(agreementUrl);
    },
    
    hideElemVisibility : function(elemId) {
        var elem = document.getElementById(elemId);
        if( !elem ) {
            return;
        }
        
        var elemClass = elem.getAttribute("class");
        
        if( elemClass.indexOf("slds-show") != -1 ) {
            elemClass = elemClass.replace("slds-show", "slds-hide");
        	elem.setAttribute("class", elemClass);
        }
    },
     
    showElemVisibility : function(elemId) {
        var elem = document.getElementById(elemId);
        var elemClass = elem.getAttribute("class");
        
        if( elemClass.indexOf("slds-hide") != -1 ) {
            elemClass = elemClass.replace("slds-hide", "slds-show");
        	elem.setAttribute("class", elemClass);
        }
    },
    
    toggleElemVisibility : function(component, elemId) {
        var elem;
        if( component.find(elemId) ) {
            elem = component.find(elemId).getElement();
        } else {
            elem = document.getElementById(elemId);
        }

        var elemClass = elem.getAttribute("class");
            
        if( elemClass.indexOf("slds-show") != -1 ) {
        	elemClass = elemClass.replace("slds-show", "slds-hide");
        } else {
            elemClass = elemClass.replace("slds-hide", "slds-show");
        }
            
        elem.setAttribute("class", elemClass);
    },
    
    toggleIterElemVisibility : function(component, topElemId, className, elemId) {
        var elem = component.find(topElemId).getElement();
        var elems = elem.getElementsByClassName(className);
        var elem;
        for( var i = 0; i < elems.length; i++ ) {
            if( elems[i].id == elemId ) {
                elem = elems[i];
                break;
            }
        }
        
        if( elem == null ) {
            return;
        }
        
        var elemClass = elem.getAttribute("class");
            
        if( elemClass.indexOf("slds-show") != -1 ) {
        	elemClass = elemClass.replace("slds-show", "slds-hide");
        } else {
            elemClass = elemClass.replace("slds-hide", "slds-show");
        }
            
        elem.setAttribute("class", elemClass);
    },
    
    navToUrl : function(url) {
        var urlEvent = $A.get("e.force:navigateToURL");

    	urlEvent.setParams({
      		"url": url
    	});
    	urlEvent.fire();
    },
    
    initListeners : function(component) {
        var self = this;
        
        var dropdownElements = new Array();
        var containerElements = new Array();
        
        dropdownElements.push( $jquery( document.getElementById('newAgreementDropdown') ) );
        containerElements.push( $jquery( document.getElementById('newAgreementButton') ) );
        
        $jquery("div[id^='agreementActionDropdown']").each(function (i, el) {
        	var agreementActionElement = $jquery(el);
            dropdownElements.push(agreementActionElement);
        });
                                                               
        $jquery("button[id^='agreementActionButton']").each(function (i, el) {
        	var agreementActionInputElement = $jquery(el);
            containerElements.push(agreementActionInputElement);
        });
        
        $jquery(document).mouseup(function (e) {
            for( var i = 0; i < dropdownElements.length; i++ ) {
                var dropdownContainer = dropdownElements[i];
                var dropdownInputContainer = containerElements[i];
                
                if ( !dropdownContainer.is(e.target) // if the target of the click isn't the container...
                    && dropdownContainer.has(e.target).length === 0
                    && !dropdownInputContainer.is(e.target)
                    && dropdownInputContainer.has(e.target).length === 0) { // ... nor a descendant of the container
                    
                    self.hideElemVisibility( dropdownContainer.attr('id') );
                }
            }
       	});
    }
})