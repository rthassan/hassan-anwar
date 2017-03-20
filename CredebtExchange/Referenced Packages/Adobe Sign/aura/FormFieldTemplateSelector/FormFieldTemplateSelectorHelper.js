({
    initAllTemplates : function(component) {
        var self = this;
        
        self.initTemplates(component);
    },
    
    initTemplates : function(component) {
        var action = component.get("c.queryFormFieldTemplates");
        
		action.setCallback(this, function(a) {
			var libraryDocumentWrappers = a.getReturnValue();
            
            component.set("v.libraryDocumentWrappers", libraryDocumentWrappers);
            component.set("v.isLoading", false);
        });
        
		$A.enqueueAction(action);
    },
    
    selectTemplates : function(component) {
        component.set("v.isLoading", true);
        
        var libraryDocumentWrappers = component.get("v.libraryDocumentWrappers");
        var selectedDocumentId = component.get("v.selectedDocumentId");
        var newSelectedDocumentId;
        
        for(var i = 0; i < libraryDocumentWrappers.length; i++) {
            var libraryDocumentWrapper = libraryDocumentWrappers[i];
            
            if( libraryDocumentWrapper.isSelected && !selectedDocumentId ) {
                newSelectedDocumentId = libraryDocumentWrapper.documentKey;
                break;
            }
            
            if( libraryDocumentWrapper.isSelected && selectedDocumentId == libraryDocumentWrapper.documentKey ) {
                libraryDocumentWrapper.isSelected = false;
            } else if( libraryDocumentWrapper.isSelected && selectedDocumentId != libraryDocumentWrapper.documentKey ) {
                newSelectedDocumentId = libraryDocumentWrapper.documentKey;
            }
        }
        
        component.set("v.libraryDocumentWrappers", libraryDocumentWrappers);
        component.set("v.selectedDocumentId", newSelectedDocumentId);
        component.set("v.isLoading", false);
    },
    
    cancelAddFiles : function(component) {
        component.set("v.isLoading", true);
        
        var compEvent = component.getEvent("notifyTemplatesSelected");
        compEvent.setParams({"isCanceled" : true });
		compEvent.fire();
    },
    
    addTemplates : function(component) {
        component.set("v.isLoading", true);

        var libraryDocumentWrappers = component.get("v.libraryDocumentWrappers");
        
        var selectedTemplateWrappers = new Array();
        
        for(var i = 0; i < libraryDocumentWrappers.length; i++) {
            var libraryDocumentWrapper = libraryDocumentWrappers[i];
            if( !libraryDocumentWrapper.isSelected ) {
                continue;
            }
            
            selectedTemplateWrappers.push(libraryDocumentWrapper);
        }
        
        var compEvent = component.getEvent("notifyTemplatesSelected");
        
		compEvent.setParams({"selectedTemplateWrappers" : selectedTemplateWrappers });
        
		compEvent.fire();
    },
    
    searchTemplate : function(component, searchTerm) {
        var action = component.get("c.queryFormFieldTemplates");
        action.setParams({
            "name" : searchTerm
        });
        
		action.setCallback(this, function(a) {
			var libraryDocumentWrappers = a.getReturnValue();
            
            component.set("v.libraryDocumentWrappers", libraryDocumentWrappers);
        });
        
		$A.enqueueAction(action);
    }
})