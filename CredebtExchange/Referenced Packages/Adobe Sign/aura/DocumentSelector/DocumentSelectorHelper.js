({
    initAllDocuments : function(component) {
        var self = this;
        
        var settingsWrapper = component.get("v.settingsWrapper");
        
        if( !settingsWrapper.customSettings.echosign_dev1__Disable_Content_Agreement_Attachments__c ) {
            self.initContents(component);
        }
        
        if( !settingsWrapper.customSettings.echosign_dev1__Disable_Attach_Agreement_Attachments__c ) {
            self.initDocuments(component);
        }
        
        if( settingsWrapper.customSettings.echosign_dev1__Enable_Library_Agreement_Attachments__c ) {
            self.initLibraryDocuments(component);
        }
        
        if( settingsWrapper.customSettings.echosign_dev1__Disable_Content_Agreement_Attachments__c &&
        	settingsWrapper.customSettings.echosign_dev1__Disable_Attach_Agreement_Attachments__c &&
           !settingsWrapper.customSettings.echosign_dev1__Enable_Library_Agreement_Attachments__c ) {
            component.set("v.isLoading", false);
        }
    },
    
    initContents : function(component) {
        var action = component.get("c.queryContentDocuments");
        
		action.setCallback(this, function(a) {
			var contentWrappers = a.getReturnValue();
            
            component.set("v.isContentEnabled", contentWrappers != null);
            component.set("v.contentWrappers", contentWrappers);
            component.set("v.isLoading", false);
        });
        
		$A.enqueueAction(action);
    },
    
    initDocuments : function(component) {
        var action = component.get("c.queryDocuments");
        
		action.setCallback(this, function(a) {
			var documentWrappers = a.getReturnValue();
            
            component.set("v.documentWrappers", documentWrappers);
            component.set("v.isLoading", false);
        });
        
		$A.enqueueAction(action);
    },
    
    initLibraryDocuments: function(component) {
        var action = component.get("c.queryLibraryDocuments");
        
		action.setCallback(this, function(a) {
			var libraryDocumentWrappers = a.getReturnValue();
            
            component.set("v.libraryDocumentWrappers", libraryDocumentWrappers);
            component.set("v.isLoading", false);
        });
        
		$A.enqueueAction(action);
    },
    
   	storeFilesUploaded : function(component) {
        var self = this;
        
        var files = document.getElementById("files").files;
        
        var reader = new FileReader();

        for (var i = 0, f; f = files[i]; i++) {
            reader.onload = (function(theFile) {
        		return function(e) {
                    var uploadedFileWrapper = new Object();
                    
                    uploadedFileWrapper.name = theFile.name;
                    uploadedFileWrapper.type = self.getDocType( theFile.type );
                    uploadedFileWrapper.contentType = theFile.type;
                    uploadedFileWrapper.content = window.btoa( reader.result );
                    
                    if( uploadedFileWrapper.content.length > 990000 ) {
                        component.set("v.errorMessage", $A.get("$Label.echosign_dev1.Agreement_Editor_Large_File_Upload_Error"));
                        component.set("v.isLoading", false);
                        return;
                    }
                    
                    var uploadedFileWrappers = component.get("v.uploadedFileWrappers");
                    
                    uploadedFileWrappers.push(uploadedFileWrapper);
                    
                    component.set("v.uploadedFileWrappers", uploadedFileWrappers);
                    //component.set("v.isLoading", false);
                    self.addFiles(component);
        		};
      		})(f);
            
            reader.onloadstart = function(e) {
      			component.set("v.isLoading", true);
    		};
            
          	reader.onabort = function(e) {
      			component.set("v.isLoading", false);
    		};
            
            reader.onerror  = function(e) {
      			component.set("v.isLoading", false);
    		};
            
            reader.readAsBinaryString(f);
        }
	},
    
    cancelAddFiles : function(component) {
        component.set("v.isLoading", true);
        
        var compEvent = component.getEvent("notifyDocumentsSelected");
        compEvent.setParams({"isCanceled" : true });
		compEvent.fire();
    },
    
    addFiles : function(component) {
        component.set("v.isLoading", true);
        
        var uploadedFileWrappers = component.get("v.uploadedFileWrappers");
        var contentWrappers = component.get("v.contentWrappers");
        var documentWrappers = component.get("v.documentWrappers");
        var libraryDocumentWrappers = component.get("v.libraryDocumentWrappers");
        
        var selectedContentWrappers = new Array();
        var selectedDocumentWrappers = new Array();
        var selectedLibraryDocumentWrappers = new Array();
        
        for(var i = 0; i < contentWrappers.length; i++) {
            var contentWrapper = contentWrappers[i];
            if( !contentWrapper.isSelected ) {
                continue;
            }
            
            selectedContentWrappers.push(contentWrapper);
        }
        
        for(var i = 0; i < documentWrappers.length; i++) {
            var documentWrapper = documentWrappers[i];
            if( !documentWrapper.isSelected ) {
                continue;
            }
            
            selectedDocumentWrappers.push(documentWrapper);
        }

        
        for(var i = 0; libraryDocumentWrappers && i < libraryDocumentWrappers.length; i++) {
            var libraryDocumentWrapper = libraryDocumentWrappers[i];
            if( !libraryDocumentWrapper.isSelected ) {
                continue;
            }
            
            selectedLibraryDocumentWrappers.push(libraryDocumentWrapper);
        }
        
        var compEvent = component.getEvent("notifyDocumentsSelected");
        
		compEvent.setParams({"uploadedFileWrappers" : uploadedFileWrappers });
		compEvent.setParams({"selectedContentWrappers" : selectedContentWrappers });
		compEvent.setParams({"selectedDocumentWrappers" : selectedDocumentWrappers });
		compEvent.setParams({"selectedLibraryDocumentWrappers" : selectedLibraryDocumentWrappers });
        
		compEvent.fire();
    },
    
    searchContent : function(component, searchTerm) {
        var action = component.get("c.queryContentDocuments");
        action.setParams({
            "name" : searchTerm
        });
        
		action.setCallback(this, function(a) {
			var contentWrappers = a.getReturnValue();
            
            component.set("v.contentWrappers", contentWrappers);
        });
        
		$A.enqueueAction(action);
    },
    
    searchDocument : function(component, searchTerm) {
        var action = component.get("c.queryDocuments");
        action.setParams({
            "name" : searchTerm
        });
        
		action.setCallback(this, function(a) {
			var documentWrappers = a.getReturnValue();
            
            component.set("v.documentWrappers", documentWrappers);
        });
        
		$A.enqueueAction(action);
    },
    
    searchLibraryDocument : function(component, searchTerm) {
        var action = component.get("c.queryLibraryDocuments");
        action.setParams({
            "name" : searchTerm
        });
        
		action.setCallback(this, function(a) {
			var libraryDocumentWrappers = a.getReturnValue();
            
            component.set("v.libraryDocumentWrappers", libraryDocumentWrappers);
        });
        
		$A.enqueueAction(action);
    },
    
    openDocument : function(documentId) {
        var self = this;
   
        self.navToUrl( "/" + documentId );
    },
    
    openTab : function(tabIndex) {
        var self = this;
        
        self.removeClassElem("tab-content-item-link", "esign-tab-selected-link");
        
        var tabIndexInt = parseInt(tabIndex);
        
        if( tabIndexInt == 1 ) {
            self.showElemVisibility("tab-content");
            self.hideElemVisibility("tab-document");
            self.hideElemVisibility("tab-library");
            
            self.activateElem("tab-content-item");
            self.deactivateElem("tab-document-item");
            self.deactivateElem("tab-library-item");
        } else if( tabIndexInt == 2 ) {
            self.hideElemVisibility("tab-content");
            self.showElemVisibility("tab-document");
            self.hideElemVisibility("tab-library");
            
            self.deactivateElem("tab-content-item");
            self.activateElem("tab-document-item");
            self.deactivateElem("tab-library-item");
        } else if( tabIndexInt == 3 ) {
            self.hideElemVisibility("tab-content");
            self.hideElemVisibility("tab-document");
            self.showElemVisibility("tab-library");
            
            self.deactivateElem("tab-content-item");
            self.deactivateElem("tab-document-item");
            self.activateElem("tab-library-item");
        }
    },
    
    removeClassElem : function(elemId, className) {
        var elem = document.getElementById(elemId);
        if( !elem ) {
            return;
        }
        
        var elemClass = elem.getAttribute("class");
        
        if( elemClass.indexOf(className) != -1 ) {
            elemClass = elemClass.replace(className, "");
            elem.setAttribute("class", elemClass);
        }
    },
    
    deactivateElem : function(elemId) {
        var elem = document.getElementById(elemId);
        if( !elem ) {
            return;
        }
        
        var elemClass = elem.getAttribute("class");
        
        if( elemClass.indexOf("slds-active") != -1 ) {
            elemClass = elemClass.replace("slds-active", "");
            elem.setAttribute("class", elemClass);
        }
    },
    
    activateElem : function(elemId) {
        var elem = document.getElementById(elemId);
        var elemClass = elem.getAttribute("class");
        
        if( elemClass.indexOf("slds-active") == -1 ) {
            elemClass = elemClass + " slds-active";
            elem.setAttribute("class", elemClass);
        }
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
    
    toggleElemVisibility : function(elemId) {
        var elem = document.getElementById(elemId);
        var elemClass = elem.getAttribute("class");
        
        if( elemClass.indexOf("slds-show") != -1 ) {
            elemClass = elemClass.replace("slds-show", "slds-hide");
        } else {
            elemClass = elemClass.replace("slds-hide", "slds-show");
        }
        
        elem.setAttribute("class", elemClass);
    },
    
    navToUrl : function(url) {
        var self = this;
        
        window.open(url);
    },
    
    getDocType : function(contentType) {
        var docType = null;
    	
        if( !contentType ) {
        	docType = 'unknown';
        } else if( contentType.includes ('pdf') ) {
        	docType	= 'pdf';
        } else if( contentType.includes('doc') || contentType.includes('docx') || contentType.includes('word') ) {
        	docType = 'word';
        } else if( contentType.includes('txt') || contentType.includes('log') ) {
            docType = 'txt';
        } else if( contentType.includes('xls') || contentType.includes('xlsx') ) {
            docType = 'excel';
        } else if( contentType.includes('ppt') || contentType.includes('pptx') ) {
            docType = 'ppt';
        } else if( contentType.includes('xml') ) {
           	docType = 'xml';
        } else if( contentType.includes('img') || contentType.includes('jpeg') || contentType.includes('jpg') || contentType.includes('gif') || contentType.includes('image') ) {
            docType = 'image';
        } else {
            docType = contentType;
        }
        
        return docType;
    }
})