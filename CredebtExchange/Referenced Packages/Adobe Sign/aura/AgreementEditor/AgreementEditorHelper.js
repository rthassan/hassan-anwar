({

 
    // these are labels for the days of the week
    cal_days_labels: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],

	// these are human-readable month name labels, in order
    cal_months_labels: ['January', 'February', 'March', 'April',
                     'May', 'June', 'July', 'August', 'September',
                     'October', 'November', 'December'],

	// these are the days of the week for each month, in order
    cal_days_in_month: [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31],

    setFieldValue : function(component, record, fieldName, value) {
        var self = this;
        record[self.getNamespacePrefix(component) + fieldName] = value;
    },
    
    getFieldValue : function(component, record, fieldName) {
        var self = this;
        return record[self.getNamespacePrefix(component) + fieldName];
    },
    
   	getNamespace : function(component) {
        //return component.getDef().getDescriptor().getNamespace();
        return "echosign_dev1";
    },
    
    getNamespacePrefix : function(component) {
        var self = this;
        return self.getNamespace(component) + "__";
    },
     
    addSelectedTemplates : function(component, selectedTemplateWrappers) {
        var agreementWrapper = component.get("v.agreementWrapper");
       	var templateWrappers = agreementWrapper.templateWrappers;

        for(var i = 0; i < selectedTemplateWrappers.length; i++) {
            var selectedTemplateWrapper = selectedTemplateWrappers[i];
            var templateWrapper = {};
            
            templateWrapper.index = templateWrappers.length;
            templateWrapper.title = selectedTemplateWrapper.title;
            templateWrapper.libraryId = selectedTemplateWrapper.documentKey;
            
            templateWrappers.push(templateWrapper);
        }
        
        //component.set("v.templateWrappers", templateWrappers);
        component.set("v.agreementWrapper", agreementWrapper);
        component.set("v.isShowAddTemplatesDialog", false);
    },
    
    addSelectedFiles : function(component, uploadedFileWrappers, selectedContentWrappers, selectedDocumentWrappers, selectedLibraryDocumentWrappers) {
       	var self = this;
        
        var attachmentWrappers = component.get("v.attachmentWrappers");
        var isFileAdded = uploadedFileWrappers.length > 0 ||
            selectedContentWrappers.length > 0 || 
            selectedDocumentWrappers.length > 0 ||
            selectedLibraryDocumentWrappers.length > 0;
        
       	for(var i = 0; i < uploadedFileWrappers.length; i++) {
            var uploadedFileWrapper = uploadedFileWrappers[i];
            
        	var attachmentWrapper = {};
            
            attachmentWrapper.index = attachmentWrappers.length;
            attachmentWrapper.title = uploadedFileWrapper.name;
            attachmentWrapper.docType = uploadedFileWrapper.type;
            attachmentWrapper.contentType = uploadedFileWrapper.contentType;
            attachmentWrapper.uploadedContent = uploadedFileWrapper.content;
            attachmentWrapper.fileRepositoryLabel = $A.get("$Label.echosign_dev1.Agreement_Editor_Uploaded_Document_Label");
            
            attachmentWrappers.push(attachmentWrapper);
        }
        
        for(var i = 0; i < selectedContentWrappers.length; i++) {
            var contentWrapper = selectedContentWrappers[i];
            
        	var attachmentWrapper = {};
            
            attachmentWrapper.index = attachmentWrappers.length;
            attachmentWrapper.title = contentWrapper.title;
            attachmentWrapper.docType = contentWrapper.docType;
            attachmentWrapper.fileRepositoryLabel = $A.get("$Label.echosign_dev1.Agreement_Editor_Salesforce_Document_Label");
            attachmentWrapper.contentId = contentWrapper.content.Id;
            
            attachmentWrappers.push(attachmentWrapper);
        }
        
        for(var i = 0; i < selectedDocumentWrappers.length; i++) {
            var documentWrapper = selectedDocumentWrappers[i];
            
        	var attachmentWrapper = {};
            
            attachmentWrapper.index = attachmentWrappers.length;
            attachmentWrapper.title = documentWrapper.title;
            attachmentWrapper.docType = documentWrapper.docType;
            attachmentWrapper.fileRepositoryLabel = $A.get("$Label.echosign_dev1.Agreement_Editor_Salesforce_Document_Label");
            attachmentWrapper.documentId = documentWrapper.document["Id"];
            
            attachmentWrappers.push(attachmentWrapper);
        }

        for(var i = 0; i < selectedLibraryDocumentWrappers.length; i++) {
            var libraryDocumentWrapper = selectedLibraryDocumentWrappers[i];
            var attachmentWrapper = {};
            
            attachmentWrapper.index = attachmentWrappers.length;
            attachmentWrapper.title = libraryDocumentWrapper.title;
            attachmentWrapper.docType = libraryDocumentWrapper.docType;
            attachmentWrapper.fileRepositoryLabel = $A.get("$Label.echosign_dev1.Agreement_Editor_Document_Cloud_Document_Label");
            attachmentWrapper.libraryId = libraryDocumentWrapper.documentKey;
            
            attachmentWrappers.push(attachmentWrapper);
        }
        
        var settingsWrapper = component.get("v.settingsWrapper");
        var isRename = self.getFieldValue(component, settingsWrapper.customSettings, "Rename_Agreement_Attachment__c");
        
        if( isRename ) {
            component.set("v.agreementName", attachmentWrappers[0].title);
        }   
        
        component.set("v.attachmentWrappers", attachmentWrappers);
        component.set("v.isNoDocumentsError", !isFileAdded);
        component.set("v.isShowAddDocumentsDialog", false);
    },
    
    setAgreementViewPasswordProcess : function(component, event, isSetState) {
        var self = this;
        
        var viewPassword = component.get("v.viewPassword");
        var viewPasswordConfirm = component.get("v.viewPasswordConfirm");
        var isViewPasswordSetStarted = component.get("v.isViewPasswordSetStarted");
        var agreementViewPassword = component.get("v.agreementViewPassword");
        
        if( !isViewPasswordSetStarted && isSetState ) {
            component.set("v.isViewPasswordSetStarted", true);
        }
        
        if( ( viewPassword !== viewPasswordConfirm || ( viewPassword != null && viewPassword.length < 3 ) ) && isViewPasswordSetStarted && agreementViewPassword ) {
            //Show error and halt
            if( viewPassword !== viewPasswordConfirm ) {
            	component.set("v.viewPasswordError", $A.get("$Label.echosign_dev1.Agreement_Confirm_Password_Error"));    
            } else if( viewPassword.length < 3 ) {
            	component.set("v.viewPasswordError", $A.get("$Label.echosign_dev1.Agreement_Min_Password_Error"));    
            }
            component.set("v.isViewPasswordError", true);
        } else {
            component.set("v.isViewPasswordError", false);
        }
    },
    
    setAgreementSignPasswordProcess : function(component, event, isSetState) {
        var self = this;
        
        var agreementWrapper = component.get("v.agreementWrapper");
        
        var signPassword = component.get("v.signPassword");
        var signPasswordConfirm = component.get("v.signPasswordConfirm");
        var signPasswordExternal = component.get("v.signPasswordExternal");
        var signPasswordExternalConfirm = component.get("v.signPasswordExternalConfirm");
        var signPasswordInternal = component.get("v.signPasswordInternal");
        var signPasswordInternalConfirm = component.get("v.signPasswordInternalConfirm");
        
        var isSignPasswordSetStarted = component.get("v.isSignPasswordSetStarted");
        var isSignInternalPasswordSetStarted = component.get("v.isSignInternalPasswordSetStarted");
        var isSignExternalPasswordSetStarted = component.get("v.isSignExternalPasswordSetStarted");
        
        var agreementSignPassword = agreementWrapper.agreementSignerVerificationMethod === "Password";
        var agreementSignInternalPassword = agreementWrapper.agreementSignerInternalVerificationMethod === "Password";
        var agreementSignExternalPassword = agreementWrapper.agreementSignerExternalVerificationMethod === "Password";
        
        if( !isSignPasswordSetStarted && isSetState ) {
            component.set("v.isSignPasswordSetStarted", true);
        }
        
       	if( !isSignInternalPasswordSetStarted && isSetState ) {
            component.set("v.isSignInternalPasswordSetStarted", true);
        }
        
       	if( !isSignExternalPasswordSetStarted && isSetState ) {
            component.set("v.isSignExternalPasswordSetStarted", true);
        }
        
        if( signPassword && ( signPassword !== signPasswordConfirm || ( signPassword.length < 3 ) )
        	&& isSignPasswordSetStarted && agreementSignPassword ) {
            //Show error and halt
            if( signPassword !== signPasswordConfirm ) {
            	component.set("v.signPasswordError", $A.get("$Label.echosign_dev1.Agreement_Confirm_Password_Error"));    
            } else if( signPassword != null && signPassword.length < 3 ) {
            	component.set("v.signPasswordError", $A.get("$Label.echosign_dev1.Agreement_Min_Password_Error"));    
            }
            component.set("v.isSignPasswordError", true);
        } else {
            component.set("v.isSignPasswordError", false);
        }
        
                
        if( signPasswordExternal && ( signPasswordExternal !== signPasswordExternalConfirm || ( signPasswordExternal.length < 3 ) )
        	&& isSignExternalPasswordSetStarted && agreementSignExternalPassword ) {
            //Show error and halt
            if( signPasswordExternal !== signPasswordExternalConfirm ) {
            	component.set("v.signExternalPasswordError", $A.get("$Label.echosign_dev1.Agreement_Confirm_Password_Error"));    
            } else if( signPasswordExternal != null && signPasswordExternal.length < 3 ) {
            	component.set("v.signExternalPasswordError", $A.get("$Label.echosign_dev1.Agreement_Min_Password_Error"));    
            }
            component.set("v.isSignExternalPasswordError", true);
        } else {
            component.set("v.isSignExternalPasswordError", false);
        }
        
                
        if( signPasswordInternal && ( signPasswordInternal !== signPasswordInternalConfirm || ( signPasswordInternal.length < 3 ) )
        	&& isSignInternalPasswordSetStarted && agreementSignInternalPassword ) {
            //Show error and halt
           	if( signPasswordInternal !== signPasswordInternalConfirm ) {
            	component.set("v.signInternalPasswordError", $A.get("$Label.echosign_dev1.Agreement_Confirm_Password_Error"));    
            } else if( signPasswordInternal != null && signPasswordInternal.length < 3 ) {
            	component.set("v.signInternalPasswordError", $A.get("$Label.echosign_dev1.Agreement_Min_Password_Error"));    
            }
            component.set("v.isSignInternalPasswordError", true);
        } else {
            component.set("v.isSignInternalPasswordError", false);
        }
    },
    
    setRecipientSignPasswordProcess : function(component, event, isSetState) {
        var self = this;
        
        var recipientWrapper = component.get("v.selectedRecipientWrapper");
        
        var recipientVerificationPassword = component.get("v.recipientPassword");
        var recipientVerificationPasswordConfirm = component.get("v.recipientConfirmPassword");
        
        var isRecipientVerificationPasswordStarted = component.get("v.isRecipientVerificationPasswordStarted");
        
        var isRecipientVerificationPassword = recipientWrapper && recipientWrapper.tempSignerVerification === "Password";
        
       	if( !isRecipientVerificationPasswordStarted && isSetState ) {
            component.set("v.isRecipientVerificationPasswordStarted", true);
        }
        
        if( recipientVerificationPassword && ( recipientVerificationPassword !== recipientVerificationPasswordConfirm || ( recipientVerificationPassword.length < 3 ) )
        	&& isRecipientVerificationPasswordStarted && isRecipientVerificationPassword ) {
            //Show error and halt
            if( recipientVerificationPassword !== recipientVerificationPasswordConfirm ) {
            	component.set("v.signPasswordError", $A.get("$Label.echosign_dev1.Agreement_Confirm_Password_Error"));    
            } else if( recipientVerificationPassword != null && recipientVerificationPassword.length < 3 ) {
            	component.set("v.signPasswordError", $A.get("$Label.echosign_dev1.Agreement_Min_Password_Error"));    
            }
            component.set("v.isSignPasswordError", true);
            component.set("v.storeRecipientVerificationDisabled", true);
        } else {
            component.set("v.isSignPasswordError", false);
            component.set("v.storeRecipientVerificationDisabled", false);
        }
    },
    
    createReplaceRecipient : function(component, recipientIndex) {
        var self = this;
        
        if( !recipientIndex ) {
            return;
        }
        
        var agreementWrapper = component.get("v.agreementWrapper");
        var replacedRecipientWrapper = agreementWrapper.recipientWrappers[recipientIndex];
        
       	var recipient = {};
        self.setFieldValue(component, recipient, "Recipient_Type__c", "Contact");
        self.setFieldValue(component, recipient, "Recipient_Role__c", "Signer");
        self.setFieldValue(component, recipient, "Order_Number__c", self.getFieldValue(component, replacedRecipientWrapper.recipient, "Order_Number__c") );
        self.setFieldValue(component, recipient, "Status__c", self.getFieldValue(component, replacedRecipientWrapper.recipient, "Status__c") );
        self.setFieldValue(component, recipient, "Source_Recipient__c", replacedRecipientWrapper.recipient.Id);
        
        var recipientWrapper = {};
        recipientWrapper.styleType = 'contact';
        recipientWrapper.recipient = recipient;
        recipientWrapper.isRecipientSet = false;
        recipientWrapper.isReplaced = true;
        recipientWrapper.index = replacedRecipientWrapper.index;
        recipientWrapper.searchRecipientWrapper = $A.get("$Label.echosign_dev1.Agreement_Editor_Search_Contacts_Placeholder"); 
        
        component.set("v.replacementRecipientWrapper", recipientWrapper);
    },
    
	addRecipient : function(component) {
        var self = this;
        
        component.set("v.isLoading", true);
                
        var settingsWrapper = component.get("v.settingsWrapper");
        var agreementWrapper = component.get("v.agreementWrapper");
        var recipientWrappers = agreementWrapper.recipientWrappers;
        var maxRecipientOrder;
        if( recipientWrappers.length === 0 ) {
        	maxRecipientOrder = 0;
        } else {
        	maxRecipientOrder = parseInt( self.getFieldValue(component, recipientWrappers[ recipientWrappers.length - 1 ].recipient, "Order_Number__c") ); 
        }
        
        var recipient = {};
        var recipientWrapper = {};
        
        if( !self.getFieldValue(component, settingsWrapper.customSettings, "Disable_Contact_Recipient_Type__c") ) {
        	self.setFieldValue(component, recipient, "Recipient_Type__c", "Contact");  
        	recipientWrapper.styleType = 'contact'; 
            recipientWrapper.searchRecipientWrapper = $A.get("$Label.echosign_dev1.Agreement_Editor_Search_Contacts_Placeholder");
        } else if( !self.getFieldValue(component, settingsWrapper.customSettings, "Disable_Lead_Recipient_Type__c") ) {
        	self.setFieldValue(component, recipient, "Recipient_Type__c", "Lead");
        	recipientWrapper.styleType = 'lead';    
            recipientWrapper.searchRecipientWrapper = $A.get("$Label.echosign_dev1.Agreement_Editor_Search_Lead_Placeholder");
        } else if( !self.getFieldValue(component, settingsWrapper.customSettings, "Disable_User_Recipient_Type__c") ) {
        	self.setFieldValue(component, recipient, "Recipient_Type__c", "User");
        	recipientWrapper.styleType = 'user';    
            recipientWrapper.searchRecipientWrapper = $A.get("$Label.echosign_dev1.Agreement_Editor_Search_Users_Placeholder");
        } else if( !self.getFieldValue(component, settingsWrapper.customSettings, "Disable_Group_Recipient_Type__c") ) {
        	self.setFieldValue(component, recipient, "Recipient_Type__c", "Group");
        	recipientWrapper.styleType = 'group';    
            recipientWrapper.searchRecipientWrapper = $A.get("$Label.echosign_dev1.Agreement_Editor_Search_Groups_Placeholder");
        } else if( !self.getFieldValue(component, settingsWrapper.customSettings, "Disable_Email_Recipient_Type__c") ) {
        	self.setFieldValue(component, recipient, "Recipient_Type__c", "Email");
        	recipientWrapper.styleType = 'email';    
        }
        
        var recipientOrder = maxRecipientOrder + 1;
        
        self.setFieldValue(component, recipient, "Recipient_Role__c", "Signer");
        self.setFieldValue(component, recipient, "Order_Number__c", recipientOrder);  
        
        recipientWrapper.recipient = recipient;
        recipientWrapper.isRecipientSet = false;
        recipientWrapper.index = recipientWrappers.length;
        
        agreementWrapper.recipientWrappers.push(recipientWrapper);
        
        component.set("v.recipientWrappers", agreementWrapper.recipientWrappers);
        component.set("v.isNoRecipientsError", false);
        component.set("v.isLoading", false);
        
        self.reinitPageCustom(component);
    },

    addRecipientMe: function(component) {
        var self = this;
        
        component.set("v.isLoading", true);
                
        var agreementWrapper = component.get("v.agreementWrapper");
        var recipientWrappers = agreementWrapper.recipientWrappers;
        var maxRecipientOrder;
        
        if( recipientWrappers.length == 0 ) {
            maxRecipientOrder = 0;
        } else {
        	maxRecipientOrder = parseInt( self.getFieldValue(component, recipientWrappers[ recipientWrappers.length - 1 ].recipient, "Order_Number__c") );   
        }
        
        var recipientOrder = maxRecipientOrder + 1;
        
        var recipient = {};
        self.setFieldValue(component, recipient, "Recipient_Type__c", "User");
        self.setFieldValue(component, recipient, "Recipient_Role__c", "Signer");
        self.setFieldValue(component, recipient, "User__c", agreementWrapper.contextUserId);
        self.setFieldValue(component, recipient, "Order_Number__c", recipientOrder);
        
        var recipientWrapper = {};
        recipientWrapper.styleType = 'user';
        recipientWrapper.recipient = recipient;
        recipientWrapper.email = agreementWrapper.contextUserEmail;
        recipientWrapper.isRecipientSet = true;
        recipientWrapper.index = recipientWrappers.length; 
		
        recipientWrapper.name = agreementWrapper.contextUserName;
        
        self.setRecipientNameLabel(component, recipientWrapper, agreementWrapper);
        
        
        agreementWrapper.recipientWrappers.push(recipientWrapper);
        
        component.set("v.isNoRecipientsError", false);
        component.set("v.isLoading", false);
        
        self.reinitPageCustom(component);
    },
    
    getMeRecipientIndex : function(agreementWrapper, recipientWrappers) {
    	for(var i = 0; i < recipientWrappers.length; i++) {
            var recipientWrapper = recipientWrappers[i];
            
            if( recipientWrapper.email == agreementWrapper.contextUserEmail ) {
                return recipientWrapper.index;
            }
        }
        
        return -1;
    },
    
    addRecipientOnlyISign : function(agreementWrapper, component) {
        var self = this;
        
        var agreementWrapper = component.get("v.agreementWrapper");
        var recipientWrappers = agreementWrapper.recipientWrappers;
        
        var signOrderValue = component.get("v.agreementSignOrder");
        if( signOrderValue !== "Only I Sign" ) {
            return;
        }
        
        var recipientIndex = self.getMeRecipientIndex(agreementWrapper, recipientWrappers);
        while( recipientIndex != -1 ) {
            self.deleteRecipient(component, recipientIndex);
            
            recipientWrappers = component.get("v.recipientWrappers");
            
            recipientIndex = self.getMeRecipientIndex(agreementWrapper, recipientWrappers);
        }
        
        /*recipientWrappers = new Array();
        
        var recipient = {};
        self.setFieldValue(component, recipient, "Recipient_Type__c", "User");
        self.setFieldValue(component, recipient, "Recipient_Role__c", "Signer");
        self.setFieldValue(component, recipient, "User__c", agreementWrapper.contextUserId);
        self.setFieldValue(component, recipient, "Order_Number__c", 1);
        
        var recipientWrapper = {};
        recipientWrapper.styleType = 'user';
        recipientWrapper.recipient = recipient;
        recipientWrapper.email = agreementWrapper.contextUserEmail;
        recipientWrapper.isRecipientSet = true;
        recipientWrapper.index = 0; 

        recipientWrapper.name = agreementWrapper.contextUserName;
        self.setRecipientNameLabel(component, recipientWrapper, agreementWrapper);
        
        recipientWrappers.push(recipientWrapper); */ 
        
        component.set("v.recipientWrappers", recipientWrappers);
    },
        
	handleAction: function(component) {
        var self = this;
        
        var actionName = component.get("v.actionName");
        if( actionName === null ) {

            component.set("v.isLoading", false);
            //alert("agrement loaded and isLoading set to false");
        	return;    
        }
        
        actionName = actionName.toLowerCase();
        
        if( actionName === 'host' ) {
            self.hostAgreement(component);
        } else if( actionName === 'view' ) {
            self.viewAgreement(component);
        } else if( actionName === 'remind' ) {
            self.sendReminder(component);
        } else if( actionName === 'delete' ) {
            self.deleteAgreement(component);
        } else if( actionName === 'cancel' ) {
            self.cancelAgreement(component);
        } else if( actionName === 'update' ) {
            self.updateAgreement(component);
        }
    },
    
    reinitPageCustom : function(component) {
        var self = this;
        
    	component.set("v.listenersInit", false);
        setTimeout(function(){ self.initPageCustom(component); }, 1000);
    },
    
    initPageCustom : function(component) {
        var isListenersInit  = component.get("v.listenersInit");    
        if( isListenersInit ) {
            return;
        }
        component.set("v.listenersInit", true);
        
        var self = this;
        
        self.initSortable(component, self);
        self.initListeners(component, self);
        self.initComponents(component, self);
	},
    
	initSettings: function(component) {
        var self = this;
        
        var action = component.get("c.getSettings");
		action.setCallback(this, function(a) {
			var settingsWrapper = a.getReturnValue();
            var isSetupCompleted = self.getFieldValue(component, settingsWrapper.privateSettings, "Setup_Completed__c")
            
            if( !isSetupCompleted ) {
                if( settingsWrapper.uiThemeDisplayed === 'Theme4d' || settingsWrapper.uiThemeDisplayed === 'Theme4t' ) {
                    var openUrl = '/apex/EchoSignSetupWizard';
					window.open(openUrl); 
                    window.parent.location.href = '/';
                } else {
                	var retUrl = encodeURIComponent( window.location.href );
                	window.location.href = '/apex/EchoSignSetupWizard?retUrl=' + retUrl;
                }
                return;
            }
            
            component.set("v.settingsWrapper", settingsWrapper);
        });
		$A.enqueueAction(action);
    },
    
	initSchema: function(component) {
        //alert("initSchema started");
        
        var self = this;
        
        var action = component.get("c.getSchema");
		action.setCallback(this, function(a) {
            //alert("initSchema finished");
			var schemaWrapper = a.getReturnValue();
            component.set("v.schemaWrapper", schemaWrapper);
        });
		$A.enqueueAction(action);
    },
    
	initAgreement: function(component) {
        //alert("initAgreement started");
        
        var self = this;
        
        var agreementId = component.get("v.agreementId");
        
        if( agreementId !== null ) {
            self.loadAgreement(component);
        } else {
            self.loadTemplateAgreement(component);
        }
    },
    
    getUrlVars : function () {
        var vars = {};
        var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi,    
        function(m,key,value) {
          vars[key] = value;
        });
        return vars;
  	},
    
	loadTemplateAgreement: function(component) {
        //component.set("v.isLoading", false);
        //return;
		var self = this;
        
        var templateId = component.get("v.templateId");
        var masterId = component.get("v.masterId");
    
    	var pageParams = this.getUrlVars();

		var action = component.get("c.loadTemplateAgreement");
        action.setParams({
            "templateId": templateId,
            "masterId": masterId,
    		"pageParams" : pageParams
        });
        
		action.setCallback(this, function(a) {
            var isSuccess = self.checkResult(component, a);
            if( !isSuccess ) {
                return;
            }
            
            var agreementWrapper = a.getReturnValue().result;
			self.pullAgreementData(component, agreementWrapper);
            self.addRecipientOnlyISign( agreementWrapper, component );
            self.handleAction(component);
		});
		$A.enqueueAction(action);
	},
    
	loadAgreement: function(component) {
        var agreementId = component.get("v.agreementId");

		var action = component.get("c.loadAgreement");
        action.setParams({
            "agreementId": agreementId
        });
        
		var self = this;
		action.setCallback(this, function(a) {
			self.pullAgreementData(component, a.getReturnValue());
            self.addRecipientOnlyISign( a.getReturnValue(), component );
            
            var settingsWrapper = component.get("v.settingsWrapper");
	        if( settingsWrapper && settingsWrapper.uiThemeDisplayed === 'Theme4t' &&
	        	( (typeof sforce != 'undefined') && (sforce != null) && (sforce.one != null) ) ) {   	
	        	sforce.one.navigateToURL('/apex/echosign_dev1__AgreementMobile?id=' + agreementId);
	        	return;
	        }
	        
            self.handleAction(component);
		});
		$A.enqueueAction(action);
	},
    
    initReminderPicklist: function(component) {
        var self = this;
        
        var reminderOptions = ["Never", "Every Day, Until Signed", "Every Week, Until Signed"];
        
        for(var i = 0; i < reminderOptions.length; i++) {
            var liNode = document.createElement("li");
            liNode.setAttribute("role", "menuitem option");
            liNode.setAttribute("id", "menu-" + i + "-0");
            liNode.setAttribute("tabindex", i === 0 ? "0" : "-1");
            liNode.setAttribute("onclick", "{!c.selectDayReminderOption}");
            
            var aNode = document.createElement("a");
            aNode.setAttribute("class", "slds-truncate");
            aNode.setAttribute("tabindex", "-1");
            
            
            var textNode = document.createTextNode( reminderOptions[i] );
			aNode.appendChild(textNode);
            
            liNode.appendChild(aNode);
            
			document.getElementById("reminderDropdownList").appendChild(liNode);
        }        
	},
    
    getReturnUrl : function(component, agreement) {
        var self = this;
        
        var returnUrlParam = self.getFieldValue(component, agreement, "ReturnURL__c");
        if( !returnUrlParam ) {
            var returnUrl = "/" + ( agreement.Id == null ? "" : agreement.Id );
        	if( sforce.console.isInConsole() ) {
                sforce.console.getEnclosingPrimaryTabId( function openInTab(result) {
        			var primaryTabId = result.id;
        			sforce.console.openPrimaryTab(primaryTabId, returnUrl, true);
    			} );
                return;
            } else {
               return returnUrl;
            }
        }
        
        if( ( returnUrlParam.indexOf("http") < 0 ) &&
            ( returnUrlParam.indexOf("https") < 0 ) && 
            ( !returnUrlParam.trim().startsWith("/") ) ) {
            return "http://" + returnUrlParam;
        } else {
			return returnUrlParam;                 
        }
    },
    
	hostAgreement : function(component) {
        var self = this;
        
        component.set("v.isLoading", true);
                
        var agreementWrapper = component.get("v.agreementWrapper");
        
        self.pollSigningUrl(component, agreementWrapper.agreement);
    },
    
	sendReminder: function(component) {
		var self = this;
        
        component.set("v.isLoading", true);
                
        var agreementWrapper = component.get("v.agreementWrapper");

        var action = component.get("c.sendReminderData");
        action.setParams({
            //"agreementStr": $A.util.json.encode(agreementWrapper.agreement)
            "agreementStr": JSON.stringify(agreementWrapper.agreement)
        });
       
		action.setCallback(this, function(a) {
            var isSuccess = self.checkResult(component, a);
            if( !isSuccess ) {
                return;
            }
            
            var agreementUrl = self.getReturnUrl(component, agreementWrapper.agreement);
            if( agreementUrl ) {
           		window.parent.location.href = agreementUrl;      
            }
		});
		$A.enqueueAction(action);
	},
    
	updateAgreement: function(component) {
		var self = this;
        
        component.set("v.isLoading", true);
                
        var agreementWrapper = component.get("v.agreementWrapper");

        var action = component.get("c.updateAgreementData");
        action.setParams({
            //"agreementStr": $A.util.json.encode(agreementWrapper.agreement)
            "agreementStr": JSON.stringify(agreementWrapper.agreement)
        });
       
		action.setCallback(this, function(a) {
            var isSuccess = self.checkResult(component, a);
            if( !isSuccess ) {
                return;
            }
            
            var agreementUrl = self.getReturnUrl(component, agreementWrapper.agreement);
            if( agreementUrl ) {
           		window.parent.location.href = agreementUrl;      
            }
		});
		$A.enqueueAction(action);
	},   
    
	viewAgreement: function(component) {
        var self = this;
        
        component.set("v.isLoading", true);
                
        var agreementWrapper = component.get("v.agreementWrapper");

        var action = component.get("c.viewAgreementData");
        action.setParams({
            //"agreementStr": $A.util.json.encode(agreementWrapper.agreement)
            "agreementStr": JSON.stringify(agreementWrapper.agreement)
        });
       
		action.setCallback(this, function(a) {
            var isSuccess = self.checkResult(component, a);
            if( !isSuccess ) {
                return;
            }
            
            var viewAgreementUrl = a.getReturnValue().result;
            self.navToUrl(viewAgreementUrl);
            component.set("v.isLoading", false);
		});
		$A.enqueueAction(action);
	},
    
	cancelAgreement: function(component) {
        var self = this;
        
        component.set("v.isLoading", true);
        self.toggleElemVisibility("cancelAgreementDialog");
                
        var agreementWrapper = component.get("v.agreementWrapper");
        var cancelAgreementReason = component.find("cancelAgreementReason").get("v.value");
        var isCancelAgreementNotifySigner = component.find("cancelAgreementNotifySigner").get("v.value");

        var action = component.get("c.cancelAgreementData");
        action.setParams({
            //"agreementStr": $A.util.json.encode(agreementWrapper.agreement),
            "agreementStr": JSON.stringify(agreementWrapper.agreement),
            "cancelAgreementReason": cancelAgreementReason,
            "isCancelAgreementNotifySigner": isCancelAgreementNotifySigner
        });
       
		action.setCallback(this, function(a) {
            var isSuccess = self.checkResult(component, a);
            if( !isSuccess ) {
                return;
            }
            
            var agreementUrl = self.getReturnUrl(component, agreementWrapper.agreement);
            if( agreementUrl ) {
           		window.parent.location.href = agreementUrl;      
            }
		});
		$A.enqueueAction(action);
	},
    
	deleteAgreement: function(component) {
        var self = this;
        
        component.set("v.isLoading", true);
        self.hideElemVisibility("deleteAgreementDialog");
                
        var agreementWrapper = component.get("v.agreementWrapper");
        var deleteAgreementReason = component.find("deleteAgreementReason").get("v.value");
        var isDeleteAgreementNotifySigner = component.find("deleteAgreementNotifySigner").get("v.value");
        
        var action = component.get("c.deleteAgreementData");
        action.setParams({
            //"agreementStr": $A.util.json.encode(agreementWrapper.agreement),
            "agreementStr": JSON.stringify(agreementWrapper.agreement),
            "deleteAgreementReason": deleteAgreementReason,
            "isDeleteAgreementNotifySigner": isDeleteAgreementNotifySigner
        });
       
		action.setCallback(this, function(a) {
            var isSuccess = self.checkResult(component, a);
            if( !isSuccess ) {
                return;
            }
            
            agreementWrapper.agreement.Id = null;
            
            var agreementUrl = self.getReturnUrl(component, agreementWrapper.agreement);
            if( agreementUrl ) {
           		window.parent.location.href = agreementUrl;      
            }
		});
		$A.enqueueAction(action);        
    },
        
	resetErrorStates : function(component) {
        component.set("v.isNoRecipientsError", false);
        component.set("v.isNoDocumentsError", false);
        component.set("v.errorMessage", null);
    },
    
	validateAgreement : function(component, agreementWrapper) {
        var self = this;
        
        self.resetErrorStates(component);
        
        var isError = false;
        
        if( agreementWrapper.agreement.Name == null || agreementWrapper.agreement.Name == "" ) {
            component.set("v.errorMessage", $A.get("$Label.echosign_dev1.Agreement_Editor_No_Name_Error"));
            isError = true;
        }
        
        var signOrderValue = component.get("v.agreementSignOrder");
        
        if( ( agreementWrapper.recipientWrappers === null ||
        	agreementWrapper.recipientWrappers.length === 0 ) &&
        	signOrderValue !== "Only I Sign" ) {
            component.set("v.isNoRecipientsError", true);
            isError = true;
        }
        
        if( agreementWrapper.attachmentWrappers === null ||
        	agreementWrapper.attachmentWrappers.length === 0 ) {
            component.set("v.isNoDocumentsError", true);
            isError = true;
        }
        
        if( isError ) {
            component.set("v.errorMessage", $A.get("$Label.echosign_dev1.Agreement_Editor_Send_Error"));
        }
        
        return isError;
    },
    
    checkResult : function(component, response) {
        var self = this;
        
    	var state = response.getState();
        if (state !== "ERROR") {
            if( ( response.getReturnValue() !== undefined && response.getReturnValue() !== null ) &&
              ( response.getReturnValue().error !== undefined && response.getReturnValue().error !== null ) ) {
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
        var self = this;
        
    	component.set("v.isLoading", false);
        component.set("v.isError", true);
       	component.set("v.errorMessage", errorMessage);
                
        self.reinitPageCustom(component);
    },
    
    isErrorExisting : function(component) {
        return component.get("v.isViewPasswordError") ||
            component.get("v.isSignPasswordError") || 
            component.get("v.isSignInternalPasswordError") || 
            component.get("v.isSignExternalPasswordError");
    },
    
	saveAgreement: function(component) {
		var self = this;
        
        component.set("v.isLoading", true);
        
       	var isError = self.isErrorExisting(component);
        if( isError ) {
            component.set("v.isLoading", false);
            return;
        }
        
        self.resetErrorStates(component);
                
        var agreementWrapper = component.get("v.agreementWrapper");
        var isSaveSuccess = self.pushAgreementData(component, agreementWrapper);
        if( !isSaveSuccess ) {
        	return;
       	}
        
        var recipients = new Array();
        for(var i = 0; i < agreementWrapper.recipientWrappers.length; i++) {
            recipients[i] = agreementWrapper.recipientWrappers[i].recipient;
        }
        
        var deletedRecipients = new Array();
        for(var i = 0; agreementWrapper.deletedRecipientWrappers && i < agreementWrapper.deletedRecipientWrappers.length; i++) {
            deletedRecipients[i] = agreementWrapper.deletedRecipientWrappers[i].recipient;
        }
        
        var action = component.get("c.saveAgreementData");
        action.setParams({
            /*"agreementStr": $A.util.json.encode(agreementWrapper.agreement),
            "recipientsStr": $A.util.json.encode(recipients),
            "deletedRecipientsStr": $A.util.json.encode(deletedRecipients),
            "documentsStr": $A.util.json.encode(agreementWrapper.attachmentWrappers),
            "deletedDocumentsStr": $A.util.json.encode(agreementWrapper.deletedAttachmentWrappers)*/
            
            "agreementStr": JSON.stringify(agreementWrapper.agreement),
            "recipientsStr": JSON.stringify(recipients),
            "deletedRecipientsStr": JSON.stringify(deletedRecipients),
            "documentsStr": JSON.stringify(agreementWrapper.attachmentWrappers),
            "deletedDocumentsStr": JSON.stringify(agreementWrapper.deletedAttachmentWrappers),
            "templatesStr": JSON.stringify(agreementWrapper.templateWrappers),
            "deletedTemplatesStr": JSON.stringify(agreementWrapper.deletedTemplateWrappers)
        });
       
		action.setCallback(this, function(a) {
            var isSuccess = self.checkResult(component, a);
            if( !isSuccess ) {
                return;
            }
            
            var agreementWrapper = a.getReturnValue();
            var agreement = agreementWrapper.agreement;
            
            self.pullAgreementData(component, agreementWrapper);
            
            component.set("v.agreementWrapper", agreementWrapper);
            component.set("v.isLoading", false);
            self.reinitPageCustom(component);
		});
		$A.enqueueAction(action);
	},
    
	saveSendForSignature: function(component) {
		var self = this;
        
        component.set("v.isLoading", true);
                
        var isError = self.isErrorExisting(component);
        if( isError ) {
            component.set("v.isLoading", false);
            return;
        }
        
        var agreementWrapper = component.get("v.agreementWrapper");
        var isSaveSuccess = self.pushAgreementData(component, agreementWrapper);
        if( !isSaveSuccess ) {
        	return;
       	}
        
        var isError = self.validateAgreement(component, agreementWrapper);
        if( isError ) {
            component.set("v.isLoading", false);
            
			self.reinitPageCustom(component);
            
            return;
        }
        
        var recipients = new Array();
        for(var i = 0; i < agreementWrapper.recipientWrappers.length; i++) {
            recipients[i] = agreementWrapper.recipientWrappers[i].recipient;
        }
        
        var deletedRecipients = new Array();
        for(var i = 0; agreementWrapper.deletedRecipientWrappers && i < agreementWrapper.deletedRecipientWrappers.length; i++) {
            deletedRecipients[i] = agreementWrapper.deletedRecipientWrappers[i].recipient;
        }
        
        var action = component.get("c.saveAgreementData");
        action.setParams({
            /*"agreementStr": $A.util.json.encode(agreementWrapper.agreement),
            "recipientsStr": $A.util.json.encode(recipients),
            "deletedRecipientsStr": $A.util.json.encode(deletedRecipients),
            "documentsStr": $A.util.json.encode(agreementWrapper.attachmentWrappers),
            "deletedDocumentsStr": $A.util.json.encode(agreementWrapper.deletedAttachmentWrappers)*/
            
            "agreementStr": JSON.stringify(agreementWrapper.agreement),
            "recipientsStr": JSON.stringify(recipients),
            "deletedRecipientsStr": JSON.stringify(deletedRecipients),
            "documentsStr": JSON.stringify(agreementWrapper.attachmentWrappers),
            "deletedDocumentsStr": JSON.stringify(agreementWrapper.deletedAttachmentWrappers),
            "templatesStr": JSON.stringify(agreementWrapper.templateWrappers),
            "deletedTemplatesStr": JSON.stringify(agreementWrapper.deletedTemplateWrappers)
        });
        
		action.setCallback(this, function(a) {
            var isSuccess = self.checkResult(component, a);
            if( !isSuccess ) {
                return;
            }
            
            var agreementWrapper = a.getReturnValue();
            var agreement = agreementWrapper.agreement;
            self.sendForSignature(component, agreement);
		});
		$A.enqueueAction(action);
	},

	sendForSignature: function(component, agreement) {
		var self = this;
        
        var isHosted = self.getFieldValue(component, agreement, "Enable_Hosted_Signing__c");
        var isSenderSignsOnly = self.getFieldValue(component, agreement, "Sender_Signs_Only__c");
       	var isAuthoring = self.getFieldValue(component, agreement, "Authoring__c");
        var isSenderSignsFirst = self.getFieldValue(component, agreement, "SenderSigns__c") && self.getFieldValue(component, agreement, "SignatureOrder__c") === 'I sign, then the Recipient signs';
        
        var action = component.get("c.sendAgreementData");
        action.setParams({
            //"agreementStr": $A.util.json.encode(agreement)
            
            "agreementStr": JSON.stringify(agreement)
        });
        
		action.setCallback(this, function(a) {
            var isSuccess = self.checkResult(component, a);
            if( !isSuccess ) {
                return;
            }
            
            var sendDocumentResult = a.getReturnValue();
            var errorMessage = sendDocumentResult.errorMessage;
            
            if( errorMessage ) {
        		component.set("v.isLoading", false);
                component.set("v.isError", true);
                component.set("v.isLogout", true);
                component.set("v.errorMessage", errorMessage); 
                component.set("v.agreementActionError", errorMessage);
            } else {
                self.setFieldValue(component, agreement, "Document_Key__c", sendDocumentResult.documentKey);
                
                if( ( !isHosted && !isSenderSignsOnly ) || isAuthoring ) {
                    
                    var sendWindow = self.navToUrl( sendDocumentResult.url );
                    if( !sendWindow ) {
                        var errorMessage = $A.get("$Label.echosign_dev1.Agreement_Editor_No_Window_Error");
                            
                        component.set("v.isSent", true);
                        component.set("v.isLoading", false);
                        component.set("v.isError", true);
                        component.set("v.isLogout", true);
                        component.set("v.errorMessage", errorMessage); 
                        component.set("v.agreementActionError", errorMessage);
                        
                        self.reinitPageCustom(component);
                        
                        return;
                    }
                    sendWindow.focus();
                    
                    self.checkPopup(component, sendWindow, agreement);
                } else {
                    self.pollSigningUrl(component, agreement);
                	return false;
                }
            }
		});
		$A.enqueueAction(action);
    },

	pollSigningUrl: function(component, agreement) {
        var action = component.get("c.retrieveSigningUrl");
        action.setParams({
            //"agreementStr": $A.util.json.encode(agreement)
            
            "agreementStr": JSON.stringify(agreement)
        });
        
		var self = this;
		action.setCallback(this, function(a) {
            //var isSforceOne = self.getIsSforceOne();
            
            var signingUrl = a.getReturnValue();
            if( signingUrl === null ) {
                self.pollSigningUrl(component, agreement);
            } else {
                var sendWindow;
                sendWindow = window.open(signingUrl);
                
                self.checkPopup(component, sendWindow, agreement);
            }
		});
		$A.enqueueAction(action);
    },
    
    pullAgreementTemplates: function(component, agreementTemplates) {
    	component.set("v.agreementTemplates", agreementTemplates);
    },
    
    pullAgreementData: function(component, agreementWrapper) {
        var self = this;
        
        self.setRecipientHybridStatus(component, agreementWrapper.recipientWrappers);
        
    	component.set("v.agreementWrapper", agreementWrapper);
		component.set("v.agreementName", agreementWrapper.agreement.Name);
		component.set("v.agreementId", agreementWrapper.agreement.Id);
		component.set("v.agreementStatus", self.getFieldValue(component, agreementWrapper.agreement, "Status__c"));
		component.set("v.isSent", !agreementWrapper.isNotSentStatus );
		component.set("v.agreementMessage", self.getFieldValue(component, agreementWrapper.agreement, "Message__c"));
		component.set("v.agreementCc", self.getFieldValue(component, agreementWrapper.agreement, "Cc__c"));
		component.set("v.agreementLanguage", self.getFieldValue(component, agreementWrapper.agreement, "AgreementLocale__c"));
		component.set("v.agreementLanguageLabel", agreementWrapper.agreementLanguageLabel);
        component.set("v.agreementHosted", self.getFieldValue(component, agreementWrapper.agreement, "Enable_Hosted_Signing__c"));
        component.set("v.agreementSenderSigns", self.getFieldValue(component, agreementWrapper.agreement, "SenderSigns__c"));
        component.set("v.agreementAuthoring", self.getFieldValue(component, agreementWrapper.agreement, "Authoring__c"));
        component.set("v.agreementViewPassword", self.getFieldValue(component, agreementWrapper.agreement, "PasswordProtectPDF__c"));
        component.set("v.viewPassword", self.getFieldValue(component, agreementWrapper.agreement, "Password__c"));
        component.set("v.viewPasswordConfirm", self.getFieldValue(component, agreementWrapper.agreement, "Password__c"));
        component.set("v.signPassword", self.getFieldValue(component, agreementWrapper.agreement, "Internal_Password__c"));
        component.set("v.signPasswordConfirm", self.getFieldValue(component, agreementWrapper.agreement, "Internal_Password__c"));
        component.set("v.signPasswordInternal", self.getFieldValue(component, agreementWrapper.agreement, "Internal_Password__c"));
        component.set("v.signPasswordInternalConfirm", self.getFieldValue(component, agreementWrapper.agreement, "Internal_Password__c"));
        component.set("v.signPasswordExternal", self.getFieldValue(component, agreementWrapper.agreement, "External_Password__c"));
        component.set("v.signPasswordExternalConfirm", self.getFieldValue(component, agreementWrapper.agreement, "External_Password__c"));
        component.set("v.agreementReminder", agreementWrapper.agreementReminder);
        component.set("v.agreementSignOrder", agreementWrapper.signOrder);
		//component.set("v.agreementSigningDeadline", agreementWrapper.agreement.__Signing_Deadline__c);
		component.set("v.recipientWrappers", agreementWrapper.recipientWrappers);
		component.set("v.attachmentWrappers", agreementWrapper.attachmentWrappers);
		//component.set("v.templateWrappers", agreementWrapper.templateWrappers);
		
        if( agreementWrapper.signOrder == 'Sign in Order' ) {
        	component.set("v.agreementSignOrderLabel", $A.get("$Label.echosign_dev1.Agreement_Editor_Sign_In_Order_Label"));     
        } else if( agreementWrapper.signOrder == 'Sign in Any Order' ) {
        	component.set("v.agreementSignOrderLabel", $A.get("$Label.echosign_dev1.Agreement_Editor_Sign_In_Any_Order_Label"));     
        } else if( agreementWrapper.signOrder == 'Only I Sign' ) {
        	component.set("v.agreementSignOrderLabel", $A.get("$Label.echosign_dev1.Agreement_Editor_Only_I_Sign_Order_Label"));     
        }
        
         if( agreementWrapper.agreementReminder == "Every Day, Until Signed" ) {
        	component.set("v.agreementReminderLabel", $A.get("$Label.echosign_dev1.Agreement_Editor_Reminder_Every_Day_Label"));         
        } else if( agreementWrapper.agreementReminder == "Every Week, Until Signed" ) {
        	component.set("v.agreementReminderLabel", $A.get("$Label.echosign_dev1.Agreement_Editor_Reminder_Every_Week_Label"));
        } else {
        	component.set("v.agreementReminderLabel", $A.get("$Label.echosign_dev1.Agreement_Editor_Reminder_Never_Label"));
        }
        
        for(var i = 0; i < agreementWrapper.recipientWrappers.length; i++) {
            var recipientWrapper = agreementWrapper.recipientWrappers[i];
            var signerVerification = self.getFieldValue(component, recipientWrapper.recipient, "Signer_Verification_Method__c")
            
            recipientWrapper.tempSignerVerificationLabel = $A.get("$Label.echosign_dev1.Agreement_Editor_Identity_Email_Label");
            
            if( signerVerification == 'Email' ) {
               recipientWrapper.tempSignerVerificationLabel = $A.get("$Label.echosign_dev1.Agreement_Editor_Identity_Email_Label");
            } else if( signerVerification == 'Password' ) {
               recipientWrapper.tempSignerVerificationLabel = $A.get("$Label.echosign_dev1.Agreement_Editor_Identity_Password_Label");
            } else if( signerVerification == 'KBA' ) {
               recipientWrapper.tempSignerVerificationLabel = $A.get("$Label.echosign_dev1.Agreement_Editor_Identity_KBA_Label");
            } else if( signerVerification == 'Social' ) {
               recipientWrapper.tempSignerVerificationLabel = $A.get("$Label.echosign_dev1.Agreement_Editor_Identity_Social_Label");
            } else if( signerVerification == 'Phone' ) {
               recipientWrapper.tempSignerVerificationLabel = $A.get("$Label.echosign_dev1.Agreement_Editor_Identity_Phone_Label");
            }
        }
    },
    
    getComponentElementValue : function(component, componentId) {
    	if( !component || component === undefined ) {
    		return undefined;
    	}
        
        var componentItem = component.find(componentId);
        if( componentItem == null || typeof componentItem.getElement !== "function" || componentItem.getElement() == null ) {
            return undefined;
        } else {
            return componentItem.getElement().value;
        }
    },
    
    pushAgreementData: function(component, agreementWrapper) {
        var self = this;
        
    	var agreement = agreementWrapper.agreement;

        //agreement.Name = self.getComponentElementValue(component, "agreementName");
       	agreement.Name = component.get("v.agreementName");
        
        if( agreement.Name == null || agreement.Name == "" ) {
            self.handleError(component, $A.get("$Label.echosign_dev1.Agreement_Editor_No_Name_Error"));
            return false;
        }
        
        //var agreementMessage = self.getComponentElementValue(component, "agreementMessage");
        var agreementMessage = component.get("v.agreementMessage");
        if( agreementMessage !== undefined ) {
           self.setFieldValue(component, agreement, "Message__c", agreementMessage); 
        }
        
        //var agreementCc = self.getComponentElementValue(component, "agreementCc");
        var agreementCc = component.get("v.agreementCc");
        if( agreementCc !== undefined ) {
        	self.setFieldValue(component, agreement, "Cc__c", agreementCc);
        }
        
        var agreementPostSignDelay = self.getComponentElementValue(component, "postSignDelay");
        if( agreementPostSignDelay !== undefined ) {
        	self.setFieldValue(component, agreement, "Post_Sign_Redirect_Delay__c", agreementPostSignDelay);
        }
        
        self.setFieldValue(component, agreement, "Authoring__c", component.get("v.agreementAuthoring"));
        self.setFieldValue(component, agreement, "Enable_Hosted_Signing__c", component.get("v.agreementHosted"));
        self.setFieldValue(component, agreement, "RemindRecipient__c", component.get("v.agreementReminder"));
        self.setFieldValue(component, agreement, "AgreementLocale__c", component.get("v.agreementLanguage"));    
		
        self.setFieldValue(component, agreement, "PasswordProtectPDF__c", component.get("v.agreementViewPassword"));
        
        if( self.getFieldValue(component, agreement, "PasswordProtectPDF__c") ) {
            self.setFieldValue(component, agreement, "Password__c", component.get("v.viewPassword"));
        }
        
        self.pushAgreementVerification(component, agreementWrapper);
        
        if( agreementWrapper.agreementPostSignUrl !== undefined && agreementWrapper.agreementPostSignUrl !== null ) {
        	var agreementPostSignUrl = agreementWrapper.agreementPostSignUrlProtocol + agreementWrapper.agreementPostSignUrl;
            self.setFieldValue(component, agreement, "Post_Sign_Redirect_URL__c", agreementPostSignUrl);
        }
        
        if( ( ( agreementWrapper.agreementPostSignUrl !== undefined && agreementWrapper.agreementPostSignUrl !== null ) || ( agreementWrapper.agreementPostSignDelay !== undefined && agreementWrapper.agreementPostSignDelay !== null ) ) &&
        	( agreementWrapper.agreementPostSignDelay < 0 || isNaN(agreementWrapper.agreementPostSignDelay) ) ) {
            self.handleError(component, "The post sign delay must be a positive number.");
            return false;
        }
        self.setFieldValue(component, agreement, "Post_Sign_Redirect_Delay__c", agreementWrapper.agreementPostSignDelay);
        
        self.setFieldValue(component, agreement, "SenderSigns__c", component.get("v.agreementSenderSigns"));
        
        if( agreementWrapper.agreementSenderSigns === 'Sign First' ) {
            self.setFieldValue(component, agreement, "SignatureOrder__c", 'I sign, then the Recipient signs');
        } else if( agreementWrapper.agreementSenderSigns === 'Sign Last' ) {
            self.setFieldValue(component, agreement, "SignatureOrder__c", 'Recipient signs, then I sign');
        } else {
            self.setFieldValue(component, agreement, "SignatureOrder__c", 'Recipient signs, then I sign');
        }
                
        var signOrderValue = component.get("v.agreementSignOrder");
        if( signOrderValue === "Only I Sign" ) {
            self.setFieldValue(component, agreement, "Sender_Signs_Only__c", true);
            self.setFieldValue(component, agreement, "Signature_Flow__c", null);
        } else if( signOrderValue === "Sign in Any Order" ) {
            self.setFieldValue(component, agreement, "Sender_Signs_Only__c", false);
            self.setFieldValue(component, agreement, "Signature_Flow__c", "Any Order");
        } else if( signOrderValue === "Sign in Order" ) {
            self.setFieldValue(component, agreement, "Sender_Signs_Only__c", false);
            self.setFieldValue(component, agreement, "Signature_Flow__c", "");
        } else {
            self.setFieldValue(component, agreement, "Sender_Signs_Only__c", false);
            self.setFieldValue(component, agreement, "Signature_Flow__c", null);
        }
        
        self.packRecipientOrder(component, agreementWrapper.recipientWrappers);
        
        for(var i = 0; i < agreementWrapper.recipientWrappers.length; i++) {
            var recipientWrapper = agreementWrapper.recipientWrappers[i];
           	
            if( self.getFieldValue(component, recipientWrapper.recipient, "Recipient_Type__c") === "Group" &&
            	self.getFieldValue(component, recipientWrapper.recipient, "Group__c") == null ) {
            	self.handleError(component, $A.get("$Label.echosign_dev1.Agreement_Editor_Recipient_Group_Value "));
            	return false;
            }
            
            if( self.getFieldValue(component, recipientWrapper.recipient, "Recipient_Type__c") === "Email" ) {
                self.setFieldValue(component, recipientWrapper.recipient, "Email_Address__c", recipientWrapper.email);
            }
        }

        return true;
    },
    
    pushAgreementVerification : function(component, agreementWrapper) {
        var self = this;
        
        var agreement = agreementWrapper.agreement;
        var settingsWrapper = component.get("v.settingsWrapper");
        
        self.setFieldValue(component, agreement, "External_Signers_Verification_Method__c", null);
        self.setFieldValue(component, agreement, "Internal_Signers_Verification_Method__c", null);
    	
    	if( self.getFieldValue(component, settingsWrapper.customSettings, "Enable_Recipient_Security_Options__c") ) {
    		return;
    	}
        
        if( ( agreementWrapper.agreementSignerVerificationMethod !== undefined && agreementWrapper.agreementSignerVerificationMethod !== null ) &&
          	agreementWrapper.agreementSignerVerificationMethod !== "Email" ) {
          	self.setFieldValue(component, agreement, "External_Signers_Verification_Method__c", self.mapAgreementVerification( agreementWrapper.agreementSignerVerificationMethod ) );
        	self.setFieldValue(component, agreement, "Internal_Signers_Verification_Method__c", self.mapAgreementVerification( agreementWrapper.agreementSignerVerificationMethod ) );
        	
            if( agreementWrapper.agreementSignerVerificationMethod === "Password" ) {
                self.setFieldValue(component, agreement, "Internal_Password__c", component.get("v.signPassword"));
                self.setFieldValue(component, agreement, "External_Password__c", component.get("v.signPassword"));
            }
        }
        
        if( ( agreementWrapper.agreementSignerInternalVerificationMethod !== undefined && agreementWrapper.agreementSignerInternalVerificationMethod !== null ) &&
        	agreementWrapper.agreementSignerInternalVerificationMethod !== "Email" ) {
        	self.setFieldValue(component, agreement, "Internal_Signers_Verification_Method__c", self.mapAgreementVerification( agreementWrapper.agreementSignerInternalVerificationMethod ) );
                    	
            if( agreementWrapper.agreementSignerInternalVerificationMethod === "Password" ) {
                self.setFieldValue(component, agreement, "Internal_Password__c", component.get("v.signPasswordInternal"));
            }
        }
        
       	if( ( agreementWrapper.agreementSignerExternalVerificationMethod !== undefined && agreementWrapper.agreementSignerExternalVerificationMethod !== null ) &&
        	agreementWrapper.agreementSignerExternalVerificationMethod !== "Email" ) {
            self.setFieldValue(component, agreement, "External_Signers_Verification_Method__c", self.mapAgreementVerification( agreementWrapper.agreementSignerExternalVerificationMethod ) );
                            	
            if( agreementWrapper.agreementSignerExternalVerificationMethod === "Password" ) {
                self.setFieldValue(component, agreement, "External_Password__c", component.get("v.signPasswordExternal"));
            }
        }
    },

    mapAgreementVerification : function(agreementVerification) {
        if( agreementVerification === "Password" ) {
			return "Password to sign agreement";            
        } else if( agreementVerification === "KBA" ) {
			return "Knowledge based authentication";            
        } else if( agreementVerification === "Social" ) {
			return "Web identity authentication";            
        } else {
            return agreementVerification;
        }
    },
    
    viewUploadedDocument: function(component, documentIndex) {
        var self = this;
        
        var agreementWrapper = component.get("v.agreementWrapper");
        var startIndex = parseInt(documentIndex);
        
        var attachmentWrapper = agreementWrapper.attachmentWrappers[startIndex];

     	var element = document.createElement('a');
		element.setAttribute( 'href', 'data:application/pdf;base64,' + attachmentWrapper.uploadedContent );
		element.setAttribute( 'download', attachmentWrapper.title );
		element.click();
    },

    
    viewDocument: function(component, documentIndex) {
        var self = this;
        
        var agreementWrapper = component.get("v.agreementWrapper");
        var startIndex = parseInt(documentIndex);
        
        var viewUrl;
        
        var attachmentWrapper = agreementWrapper.attachmentWrappers[startIndex];
        if( attachmentWrapper.attachmentRecordId !== undefined ) {
            viewUrl = "/servlet/servlet.FileDownload?file=" + attachmentWrapper.attachmentRecordId;
        } else if( attachmentWrapper.libraryRecordId !== undefined ) { //Do nothing for now, no way to open DC doc   
        } else if( attachmentWrapper.attachmentId !== undefined ) {
            viewUrl = "/servlet/servlet.FileDownload?file=" + attachmentWrapper.attachmentId;
        } else if( attachmentWrapper.documentId !== undefined ) {
            viewUrl = "/" + attachmentWrapper.documentId;
        } else if( attachmentWrapper.contentId !== undefined ) {
            viewUrl = "/" + attachmentWrapper.contentId;
        } else if( attachmentWrapper.libraryId !== undefined ) { //Do nothing for now, no way to open DC doc 
        }
        
        self.navToUrl(viewUrl);
    },

    deleteTemplate: function(component, templateIndex) {
        var agreementWrapper = component.get("v.agreementWrapper");
        var startIndex = parseInt(templateIndex);

        var deletedTemplateWrappers = agreementWrapper.templateWrappers.splice( startIndex, 1 );
        var deletedTemplateWrapper = deletedTemplateWrappers[0];
        if( deletedTemplateWrapper.libraryRecordId !== undefined ) {
        	agreementWrapper.deletedTemplateWrappers.push( deletedTemplateWrapper );  
        }
        
        for( var i = startIndex; i < agreementWrapper.templateWrappers.length; i++ ) {
            agreementWrapper.templateWrappers[i].index -= 1;
        }

        component.set("v.agreementWrapper", agreementWrapper);
    },
    
    deleteDocument: function(component, documentIndex) {
        var agreementWrapper = component.get("v.agreementWrapper");
        var startIndex = parseInt(documentIndex);

        var deletedAttachmentWrappers = agreementWrapper.attachmentWrappers.splice( startIndex, 1 );
        var deletedAttachmentWrapper = deletedAttachmentWrappers[0];
        if( deletedAttachmentWrapper.attachmentRecordId !== undefined ||
          	deletedAttachmentWrapper.libraryRecordId !== undefined ) {
        	agreementWrapper.deletedAttachmentWrappers.push( deletedAttachmentWrapper );  
        }
        
        for( var i = startIndex; i < agreementWrapper.attachmentWrappers.length; i++ ) {
            agreementWrapper.attachmentWrappers[i].index -= 1;
        }

        component.set("v.attachmentWrappers", agreementWrapper.attachmentWrappers);
    },
     
    setRecipientMessage : function(component) {
        var self = this;
        
        var agreementWrapper = component.get("v.agreementWrapper");
        var recipientIndex = component.get("v.selectedRecipientIndex");
        var recipientMessage = component.find("recipientMessage").get("v.value");
        if( recipientMessage === '' ) {
            recipientMessage = null;
        }
        
        self.setFieldValue(component, agreementWrapper.recipientWrappers[recipientIndex].recipient, "Recipient_Message__c", recipientMessage);
        
        component.set("v.recipientWrappers", agreementWrapper.recipientWrappers);
        
        self.toggleElemVisibility("recipientMessageDialog");
    },
    
    openRecipientMessage : function(component, recipientIndex) {
        var self = this;
        
        if( !recipientIndex ) {
            return;
        }
        
        var agreementWrapper = component.get("v.agreementWrapper");
        
        var recipientMessage = self.getFieldValue(component, agreementWrapper.recipientWrappers[recipientIndex].recipient, "Recipient_Message__c");
    	
        self.toggleElemVisibility("recipientMessageDialog");
        
        component.set("v.selectedRecipientIndex", recipientIndex);
        component.find("recipientMessage").set("v.value", recipientMessage);
   	},
    
    deleteRecipient: function(component, recipientIndex) {
        if( !recipientIndex ) {
            return;
        }
        
        var agreementWrapper = component.get("v.agreementWrapper");
        var deletedAgreementWrapper = agreementWrapper.recipientWrappers[recipientIndex];
        var startIndex = parseInt(recipientIndex);
        
        var deletedRecipientWrapper = agreementWrapper.recipientWrappers.splice(startIndex, 1 );
        if( deletedRecipientWrapper[0].recipient.Id !== undefined &&
          	deletedRecipientWrapper[0].recipient.Id !== null ) {
        	agreementWrapper.deletedRecipientWrappers.push( deletedRecipientWrapper[0] );    
        }
        
        var self = this;
        
        if( deletedAgreementWrapper.isHybridMember ) {
            for( var i = startIndex; i < agreementWrapper.recipientWrappers.length; i++ ) {
            	agreementWrapper.recipientWrappers[i].index -= 1;
        	}
        } else {
            for( var i = startIndex; i < agreementWrapper.recipientWrappers.length; i++ ) {
            	agreementWrapper.recipientWrappers[i].index -= 1;
                var newOrderNumber = self.getFieldValue(component, agreementWrapper.recipientWrappers[i].recipient, "Order_Number__c") - 1;
                self.setFieldValue(component, agreementWrapper.recipientWrappers[i].recipient, "Order_Number__c", newOrderNumber);
        	}
        }
        
        self.setRecipientHybridStatus(component, agreementWrapper.recipientWrappers);
        
        component.set("v.recipientWrappers", agreementWrapper.recipientWrappers);
    },

    unsetRecipient: function(component, recipientIndex) {
        if( !recipientIndex ) {
            return;
        }
        
   		var self = this;
        
        var agreementWrapper = component.get("v.agreementWrapper");
        var recipient = agreementWrapper.recipientWrappers[recipientIndex].recipient;
        
        self.setFieldValue(component, recipient, "Contact__c", null); 
        self.setFieldValue(component, recipient, "Lead__c", null); 
        self.setFieldValue(component, recipient, "User__c", null);
        self.setFieldValue(component, recipient, "Group__c", null);
        self.setFieldValue(component, recipient, "Email_Address__c", null);
        
        agreementWrapper.recipientWrappers[recipientIndex].isRecipientSet = false;
        
        component.set("v.recipientWrappers", agreementWrapper.recipientWrappers);
    },

    unsetReplaceRecipient: function(component) {
       	var self = this;
        
        var recipientWrapper = component.get("v.replacementRecipientWrapper");
        
        self.setFieldValue(component, recipientWrapper.recipient, "Contact__c", null); 
        self.setFieldValue(component, recipientWrapper.recipient, "Lead__c", null); 
        self.setFieldValue(component, recipientWrapper.recipient, "User__c", null);
        self.setFieldValue(component, recipientWrapper.recipient, "Group__c", null);
        
        recipientWrapper.isRecipientSet = false;
        recipientWrapper.email = null;
        
        component.set("v.storeReplaceRecipientDisabled", true);
        component.set("v.replacementRecipientWrapper", recipientWrapper);
    },
    
    selectRecipientAddress : function(component, recipientIndex, addressType) {
        if( !recipientIndex ) {
            return;
        }
        
   		var self = this;
        
        var agreementWrapper = component.get("v.agreementWrapper");
        
        self.setFieldValue(component, agreementWrapper.recipientWrappers[recipientIndex].recipient, "useEmailAddress__c", ( addressType === "email" ? true : false ) );
        
        component.set("v.recipientWrappers", agreementWrapper.recipientWrappers);
        
        self.toggleElemVisibility("recipientAddressDropdown");
    },
    
    navToRecipientRefRecord : function(component, recipientIndex) {
        if( !recipientIndex ) {
            return;
        }
        
        var self = this;
        
        var agreementWrapper = component.get("v.agreementWrapper"); 
        
        var agreementSignOrder = component.get("v.agreementSignOrder");        
        if( agreementSignOrder === "Only I Sign" ) { 
            self.navigateToSObject( self.getFieldValue(component, agreementWrapper.recipientWrappers[0].recipient, "User__c") );
            return;
        }
           
        var recipientWrapper = agreementWrapper.recipientWrappers[recipientIndex];
        var recipientType = self.getFieldValue(component, recipientWrapper.recipient, "Recipient_Type__c");
        
        if( recipientType === "Contact" ) {
        	self.navigateToSObject( self.getFieldValue(component, recipientWrapper.recipient, "Contact__c") );
        } else if( recipientType === "Lead" ) {
        	self.navigateToSObject( self.getFieldValue(component, recipientWrapper.recipient, "Lead__c") );
        } else if( recipientType === "User" ) {
        	self.navigateToSObject( self.getFieldValue(component, recipientWrapper.recipient, "User__c") );
        } else if( recipientType === "Group" ) {
            var groupId = self.getFieldValue(component, recipientWrapper.recipient, "Group__c");
            if( groupId.startsWith('00G')  ) {
        		self.navToUrl("/_ui/common/ownership/group/GroupFullMembershipUi/d?id=" + groupId);    
            } else if( groupId.startsWith('00E')  ) {
        		self.navigateToSObject(groupId);    
            }
        }
    },    

    navToReplaceRecipientRefRecord : function(component, recipientIndex) {
        if( !recipientIndex ) {
            return;
        }
        
        var self = this;
        
        var recipientWrapper = component.get("v.replacementRecipientWrapper");
        var recipientType = self.getFieldValue(component, recipientWrapper.recipient, "Recipient_Type__c");
        
        if( recipientType === "Contact" ) {
        	self.navigateToSObject( self.getFieldValue(component, recipientWrapper.recipient, "Contact__c") );
        } else if( recipientType === "Lead" ) {
        	self.navigateToSObject( self.getFieldValue(component, recipientWrapper.recipient, "Lead__c") );
        } else if( recipientType === "User" ) {
        	self.navigateToSObject( self.getFieldValue(component, recipientWrapper.recipient, "User__c") );
        }
    }, 
    
    setAgreementParentSearchResult : function(component, selectedResultRecordId, resultType) {
        var self = this;
        
        var agreementWrapper = component.get("v.agreementWrapper");
        var searchItemWrappers = component.get("v.searchItemWrappers");
        
        var selectedItemWrapper;
        for( var i = 0; i < searchItemWrappers.length; i++ ) {
            if( searchItemWrappers[i].recordId === selectedResultRecordId ) {
                selectedItemWrapper = searchItemWrappers[i];
                break;
            }
        }
        
        if( resultType === "account" ) {
        	self.setFieldValue(component, agreementWrapper.agreement, "Account__c", selectedItemWrapper.recordId);
            agreementWrapper.accountName = selectedItemWrapper.name;
            agreementWrapper.isAccountSet = true;
        } else if( resultType === "opportunity" ) {
        	self.setFieldValue(component, agreementWrapper.agreement, "Opportunity__c", selectedItemWrapper.recordId);
            agreementWrapper.oppName = selectedItemWrapper.name;
            agreementWrapper.isOppSet = true;
        } else if( resultType === "contract" ) {
        	self.setFieldValue(component, agreementWrapper.agreement, "Contract__c", selectedItemWrapper.recordId);
            agreementWrapper.contractName = selectedItemWrapper.name;
            agreementWrapper.isContractSet = true;
        }
        
        component.set("v.agreementWrapper", agreementWrapper);
        
        self.toggleInputComponent(component, resultType + "SearchResults");
    },
    
    setRecipientSearchResult : function(component, recipientIndex, selectedResultRecordId) {
    	var self = this;
        
        if( !recipientIndex ) {
            return;
        }
        
        var agreementWrapper = component.get("v.agreementWrapper");
        var searchItemWrappers = component.get("v.searchItemWrappers");
        
        var selectedItemWrapper;
        for( var i = 0; i < searchItemWrappers.length; i++ ) {
            if( searchItemWrappers[i].recordId === selectedResultRecordId ) {
                selectedItemWrapper = searchItemWrappers[i];
                break;
            }
        }
        
        var recipientWrapper = agreementWrapper.recipientWrappers[recipientIndex];
        var recipientType = self.getFieldValue(component, recipientWrapper.recipient, "Recipient_Type__c");
        
        if( recipientType === "Contact" ) {
        	self.setFieldValue(component, recipientWrapper.recipient, "Contact__c", selectedItemWrapper.recordId);
        } else if( recipientType === "Lead" ) {
        	self.setFieldValue(component, recipientWrapper.recipient, "Lead__c", selectedItemWrapper.recordId);
        } else if( recipientType === "User" ) {
        	self.setFieldValue(component, recipientWrapper.recipient, "User__c", selectedItemWrapper.recordId);
        } else if( recipientType === "Group" ) {
        	self.setFieldValue(component, recipientWrapper.recipient, "Group__c", selectedItemWrapper.recordId);
        }
        
        recipientWrapper.name = selectedItemWrapper.name;
        self.setRecipientNameLabel(component, recipientWrapper, agreementWrapper);
        
        recipientWrapper.email = selectedItemWrapper.email;
        recipientWrapper.mobilePhoneNumber = selectedItemWrapper.mobilePhoneNumber;
        recipientWrapper.mobilePhoneCountryCode = selectedItemWrapper.mobilePhoneCountryCode;
        recipientWrapper.fax = selectedItemWrapper.fax;
        recipientWrapper.isFaxExists = recipientWrapper.fax != null;
        recipientWrapper.recipientType = recipientType.toLowerCase();
        recipientWrapper.isRecipientSet = true;
        
        if( !recipientWrapper.isFaxExists ) {
            self.setFieldValue(component, recipientWrapper.recipient, "useEmailAddress__c", true);
        }
        
        component.set("v.recipientWrappers", agreementWrapper.recipientWrappers);
        
        self.toggleInputComponent(component, "recipientSearchResults" + recipientIndex);
	},
    
    setRecipientNameLabel : function(component, recipientWrapper, agreementWrapper) {
        var self = this;
        
        var recipientType = self.getFieldValue(component, recipientWrapper.recipient, "Recipient_Type__c");
        var recipientValue = self.getFieldValue(component, recipientWrapper.recipient, "User__c");
        
        if( recipientType === "User" &&
        	recipientValue === agreementWrapper.contextUserId ) {
           	recipientWrapper.name = $A.get("$Label.echosign_dev1.Agreement_Editor_Myself_Label") 
           		+ ' (' + recipientWrapper.name + ')';  
        }
    },
    
    setReplaceRecipientSearchResult : function(component, selectedResultRecordId) {
    	var self = this;
        
        var searchItemWrappers = component.get("v.searchItemWrappers");
        
        var selectedItemWrapper;
        for( var i = 0; i < searchItemWrappers.length; i++ ) {
            if( searchItemWrappers[i].recordId === selectedResultRecordId ) {
                selectedItemWrapper = searchItemWrappers[i];
                break;
            }
        }
        
        var agreementWrapper = component.get("v.agreementWrapper");
        var recipientWrapper = component.get("v.replacementRecipientWrapper");
        var recipientType = self.getFieldValue(component, recipientWrapper.recipient, "Recipient_Type__c");
        
        if( recipientType === "Contact" ) {
        	self.setFieldValue(component, recipientWrapper.recipient, "Contact__c", selectedItemWrapper.recordId);
        } else if( recipientType === "Lead" ) {
        	self.setFieldValue(component, recipientWrapper.recipient, "Lead__c", selectedItemWrapper.recordId);
        } else if( recipientType === "User" ) {
        	self.setFieldValue(component, recipientWrapper.recipient, "User__c", selectedItemWrapper.recordId);
        }
        
        recipientWrapper.name = selectedItemWrapper.name;
        self.setRecipientNameLabel(component, recipientWrapper, agreementWrapper);
        
        recipientWrapper.email = selectedItemWrapper.email;
        recipientWrapper.recipientType = recipientType.toLowerCase();
        recipientWrapper.isRecipientSet = true;
        
        component.set("v.replacementRecipientWrapper", recipientWrapper);
        
        self.changeReplaceRecipient(component);
        
        self.toggleElemVisibility("replaceRecipientSearchResults");
	},
    
    packRecipientOrder : function(component, recipientWrappers) {
        var self = this;
        
        var lastOrder;
        var lastOldOrder;
        for( var i = 0; i < recipientWrappers.length; i++ ) {
            if( i === 0 ) {
                if( parseInt( self.getFieldValue(component, recipientWrappers[i].recipient, "Order_Number__c") ) > 1 ) {
                    self.setFieldValue(component, recipientWrappers[i].recipient, "Order_Number__c", 1);
                }
                lastOrder = parseInt( self.getFieldValue(component, recipientWrappers[i].recipient, "Order_Number__c") );
                continue;
            }
            
            var order = parseInt( self.getFieldValue(component, recipientWrappers[i].recipient, "Order_Number__c") );
            if( order == lastOldOrder ) {
                self.setFieldValue(component, recipientWrappers[i].recipient, "Order_Number__c", lastOrder);
            } else if( order > ( lastOrder + 1 ) ) {
                lastOldOrder = order;
                self.setFieldValue(component, recipientWrappers[i].recipient, "Order_Number__c", lastOrder + 1);
            }
            
            lastOrder = parseInt( self.getFieldValue(component, recipientWrappers[i].recipient, "Order_Number__c") );
        }
    },
    
    setRecipientHybridStatus : function(component, recipientWrappers) {
        var self = this;
        
        var lastRecipientWrapper;
        for( var i = 0; i < recipientWrappers.length; i++ ) {
            var recipientWrapper = recipientWrappers[i];
            var recipient = recipientWrapper.recipient;
            
            recipientWrapper.isHybridMember = false; 
            recipientWrapper.isHybridLastMember = false;
            recipientWrapper.isHybridFirstMember = false;
            
            if( lastRecipientWrapper == null ) {
                lastRecipientWrapper = recipientWrapper;
                continue;
            }
            
            if( self.getFieldValue(component, lastRecipientWrapper.recipient, "Order_Number__c") == self.getFieldValue(component, recipient, "Order_Number__c") ) {
                recipientWrapper.isHybridMember = true;
                lastRecipientWrapper.isHybridFirstMember = !lastRecipientWrapper.isHybridMember;
                lastRecipientWrapper.isHybridMember = true;
            } else if( self.getFieldValue(component, lastRecipientWrapper.recipient, "Order_Number__c") != self.getFieldValue(component, recipient, "Order_Number__c") &&
            	lastRecipientWrapper.isHybridMember ) {
            	lastRecipientWrapper.isHybridLastMember = true;
           	} else {
               recipientWrapper.isHybridMember = false;     
            }
            
            lastRecipientWrapper = recipientWrapper;
        }
        
        if( lastRecipientWrapper != null &&
           lastRecipientWrapper.isHybridMember ) {
        	lastRecipientWrapper.isHybridLastMember = true;
        }
    },
    
    reorderRecipient: function(component, recipientOldIndex, recipientNewOrder) {
        var self = this;
        
        var agreementWrapper = component.get("v.agreementWrapper");
        var recipientWrappers = agreementWrapper.recipientWrappers;
        var recipientReoderedWrapper = recipientWrappers[recipientOldIndex];
        
        var maxRecipientOrder = parseInt( self.getFieldValue(component, recipientWrappers[ recipientWrappers.length - 1 ].recipient, "Order_Number__c") );
        
        if( recipientNewOrder < 1 ) {
            recipientNewOrder = 1;
        }
        
        recipientWrappers.splice( recipientOldIndex, 1 );
        
        self.setFieldValue(component, recipientReoderedWrapper.recipient, "Order_Number__c", recipientNewOrder);      
        
        if( recipientNewOrder > maxRecipientOrder ) {
            recipientWrappers.push(recipientReoderedWrapper);
        } else {
            var isMatched = false;
            for( var i = 0; i < recipientWrappers.length; i++ ) {
                if( self.getFieldValue(component, recipientWrappers[i].recipient, "Order_Number__c") <= recipientNewOrder ) {
                    continue;
                }
                
                isMatched = true;
                recipientWrappers.splice( i, 0, recipientReoderedWrapper );
                break;
            }
            
            if( !isMatched ) {
               recipientWrappers.push(recipientReoderedWrapper); 
            }
        }
        
        for( var i = 0; i < recipientWrappers.length; i++ ) {
            recipientWrappers[i].index = i;
		}
        
        self.setRecipientHybridStatus(component, recipientWrappers);
        
        component.set("v.recipientWrappers", agreementWrapper.recipientWrappers);
    },
    
    moveOrderRecipient : function(component, recipientIndexesStr) {
        var self = this;
        
        var agreementWrapper = component.get("v.agreementWrapper");
        var oldRecipientWrappers = agreementWrapper.recipientWrappers;
        
        var oldRecipientOrderNumbers = new Array();
        for( var i = 0; i < agreementWrapper.recipientWrappers.length; i++ ) {
            oldRecipientOrderNumbers[i] = self.getFieldValue(component, agreementWrapper.recipientWrappers[i].recipient, "Order_Number__c");
        }
        
        agreementWrapper.recipientWrappers = new Array();
        
        var recipientIndexes = recipientIndexesStr.split(",");
        
       	for( var i = 0; i < recipientIndexes.length; i++ ) {
        	var recipientIndex = recipientIndexes[i];
        	var selectedWrapper = oldRecipientWrappers[recipientIndex];
            
            self.setFieldValue(component, selectedWrapper.recipient, "Order_Number__c", oldRecipientOrderNumbers[i]);
        	agreementWrapper.recipientWrappers[i] = selectedWrapper;
        }
        
       	for( var i = 0; i < agreementWrapper.recipientWrappers.length; i++ ) {
            agreementWrapper.recipientWrappers[i].index = i;
        }
        
        self.setRecipientHybridStatus( component, agreementWrapper.recipientWrappers );
        
        component.set("v.recipientWrappers", agreementWrapper.recipientWrappers);
    },
    
    reoderAttachments : function(component, documentIndexesStr) {
        var agreementWrapper = component.get("v.agreementWrapper");
        var oldAttachmentWrappers = agreementWrapper.attachmentWrappers;
        
        agreementWrapper.attachmentWrappers = new Array();
        
        var attachmentElementIds = documentIndexesStr.split(",");
        
        var index = 0;
       	for( var i = 0; i < attachmentElementIds.length; i++ ) {
            var attachmentElementId = attachmentElementIds[i];
        	var attachmentIndex = parseInt(attachmentElementId);
        	var selectedWrapper = oldAttachmentWrappers[attachmentIndex];
            
        	selectedWrapper.index = index;
        	agreementWrapper.attachmentWrappers[index] = selectedWrapper;
            index++;
        }
        
        component.set("v.attachmentWrappers", agreementWrapper.attachmentWrappers);
    },

    unsetAccount: function(component) {
   		var self = this;
        
        var agreementWrapper = component.get("v.agreementWrapper");
        
        self.setFieldValue(component, agreementWrapper.agreement, "Account__c", null);
        
        agreementWrapper.isAccountSet = false;
        
        component.set("v.agreementWrapper", agreementWrapper);
    },

    unsetOpp: function(component) {
   		var self = this;
        
        var agreementWrapper = component.get("v.agreementWrapper");
        
        self.setFieldValue(component, agreementWrapper.agreement, "Opportunity__c", null);
        
        agreementWrapper.isOppSet = false;
        
        component.set("v.agreementWrapper", agreementWrapper);
    },

    unsetContract: function(component) {
   		var self = this;
        
        var agreementWrapper = component.get("v.agreementWrapper");
        
        self.setFieldValue(component, agreementWrapper.agreement, "Contract__c", null);
        
        agreementWrapper.isContractSet = false;
        
        component.set("v.agreementWrapper", agreementWrapper);
    },
    
    selectDayReminderOption: function(component) {
        component.set("v.agreementReminder", "Every Day, Until Signed");
        
        var self = this;
        self.toggleElemVisibility("reminderDropdown");
    },
    
    selectRecipientCountryCode : function(component, countryCode, recipientIndex) {
        var self = this;
        
        if( !recipientIndex ) {
            return;
        }
        
        var schemaWrapper = component.get("v.schemaWrapper");
        //var agreementWrapper = component.get("v.agreementWrapper");
        //var recipientWrapper = agreementWrapper.recipientWrappers[recipientIndex];
        var recipientWrapper = component.get("v.selectedRecipientWrapper");
        
        recipientWrapper.countryCode = countryCode;
        recipientWrapper.countryCodeLabel = self.getCountryCodeLabel( countryCode, schemaWrapper.recipientCountryCodes );
        
       	//component.set("v.recipientWrappers", agreementWrapper.recipientWrappers);
       	component.set("v.selectedRecipientWrapper", recipientWrapper);
        
        self.hideElemVisibility("recipientVerificationCountryDropdown");
    },
     
    storeRecipientVerification : function(component, recipientIndex, elemId, verificationType) {
        var self = this;
        
       	if( !recipientIndex ) {
            return;
        }
        
        var agreementWrapper = component.get("v.agreementWrapper");
        var recipientWrapper = agreementWrapper.recipientWrappers[recipientIndex];
        
        self.setFieldValue(component, recipientWrapper.recipient, "Signer_Verification_Method__c", recipientWrapper.tempSignerVerification);
        
        if( self.getFieldValue(component, recipientWrapper.recipient, "Signer_Verification_Method__c") === "Password" ) {
           self.setFieldValue(component, recipientWrapper.recipient, "Password__c", component.get("v.recipientPassword"));
        } else if( self.getFieldValue(component, recipientWrapper.recipient, "Signer_Verification_Method__c") === "Phone" ) {
           self.setFieldValue(component, recipientWrapper.recipient, "Phone_Verification_Country_Code__c", recipientWrapper.countryCode);
           self.setFieldValue(component, recipientWrapper.recipient, "Phone_Verification_Phone_Number__c", document.getElementById("recipientVerificationPhone").value);
        }
        
        component.set("v.recipientWrappers", agreementWrapper.recipientWrappers);
        
        self.hideElemVisibility("recipientVerificationDialog");
    },
    
    selectRecipientVerification : function(component, recipientIndex, elemId, verificationType) {
        var self = this;
        
       	if( !recipientIndex ) {
            return;
        }
        
        var agreementWrapper = component.get("v.agreementWrapper");
        var recipientWrapper = agreementWrapper.recipientWrappers[recipientIndex];
        
        recipientWrapper.tempSignerVerification = verificationType;
        if( recipientWrapper.tempSignerVerification == 'Email' ) {
           recipientWrapper.tempSignerVerificationLabel = $A.get("$Label.echosign_dev1.Agreement_Editor_Identity_Email_Label");
        } else if( recipientWrapper.tempSignerVerification == 'Password' ) {
           recipientWrapper.tempSignerVerificationLabel = $A.get("$Label.echosign_dev1.Agreement_Editor_Identity_Password_Label");
        } else if( recipientWrapper.tempSignerVerification == 'KBA' ) {
           recipientWrapper.tempSignerVerificationLabel = $A.get("$Label.echosign_dev1.Agreement_Editor_Identity_KBA_Label");
        } else if( recipientWrapper.tempSignerVerification == 'Social' ) {
           recipientWrapper.tempSignerVerificationLabel = $A.get("$Label.echosign_dev1.Agreement_Editor_Identity_Social_Label");
        } else if( recipientWrapper.tempSignerVerification == 'Phone' ) {
           recipientWrapper.tempSignerVerificationLabel = $A.get("$Label.echosign_dev1.Agreement_Editor_Identity_Phone_Label");
        }
        
        if( verificationType == "Phone" ) {
            if( recipientWrapper.mobilePhoneNumber != null ) {
                recipientWrapper.recipient.echosign_dev1__Phone_Verification_Phone_Number__c = recipientWrapper.mobilePhoneNumber;
            }
            
            if( recipientWrapper.mobilePhoneCountryCode != null ) {
                recipientWrapper.countryCodeLabel = "+" + recipientWrapper.mobilePhoneCountryCode;
                recipientWrapper.countryCode = recipientWrapper.mobilePhoneCountryCode;
            }            
        }
        
        //component.set("v.recipientWrappers", agreementWrapper.recipientWrappers);
        component.set("v.selectedRecipientWrapper", recipientWrapper);
        
        self.hideElemVisibility("recipientVerificationDropdown");
    },
    
    selectAgreementVerification : function(component, verificationType, applyTo) {
        var self = this;
        
        var VERIFICATION_METHODS_LABEL_MAP = { "Email" : $A.get("$Label.echosign_dev1.Agreement_Editor_Identity_Email_Label"),
            "KBA" : $A.get("$Label.echosign_dev1.Agreement_Editor_Identity_KBA_Label"),
            "Password" : $A.get("$Label.echosign_dev1.Agreement_Editor_Identity_Password_Label"),
            "Social" : $A.get("$Label.echosign_dev1.Agreement_Editor_Identity_Social_Label") };
        
        var agreementWrapper = component.get("v.agreementWrapper");

        if( applyTo == null ) {
            agreementWrapper.agreementSignerVerificationMethod = verificationType;
            agreementWrapper.agreementSignerVerificationMethodLabel = VERIFICATION_METHODS_LABEL_MAP[verificationType];
            component.set("v.agreementWrapper", agreementWrapper);
            self.hideElemVisibility("agreementVerificationDropdown");
        } else if( applyTo == "Internal" ) {
            agreementWrapper.agreementSignerInternalVerificationMethod = verificationType;
            agreementWrapper.agreementSignerInternalVerificationMethodLabel = VERIFICATION_METHODS_LABEL_MAP[verificationType];
            component.set("v.agreementWrapper", agreementWrapper);
            self.hideElemVisibility("agreementInternalVerificationDropdown");
        } else if( applyTo == "External" ) {
            agreementWrapper.agreementSignerExternalVerificationMethod = verificationType;
            agreementWrapper.agreementSignerExternalVerificationMethodLabel = VERIFICATION_METHODS_LABEL_MAP[verificationType];
            component.set("v.agreementWrapper", agreementWrapper);
            self.hideElemVisibility("agreementExternalVerificationDropdown");
        }
    },
    
    openRecipientVerificationDialog : function(component, recipientIndex) {
        var self = this;
        
       	if( !recipientIndex ) {
            return;
        }
        
        var schemaWrapper = component.get("v.schemaWrapper");
        var agreementWrapper = component.get("v.agreementWrapper");
        var recipientWrapper = agreementWrapper.recipientWrappers[recipientIndex];
        
        recipientWrapper.tempSignerVerification = self.getFieldValue(component, recipientWrapper.recipient, "Signer_Verification_Method__c") === undefined ? "Email" : self.getFieldValue(component, recipientWrapper.recipient, "Signer_Verification_Method__c");
        if( recipientWrapper.tempSignerVerification == 'Email' ) {
           recipientWrapper.tempSignerVerificationLabel = $A.get("$Label.echosign_dev1.Agreement_Editor_Identity_Email_Label");
        } else if( recipientWrapper.tempSignerVerification == 'Password' ) {
           recipientWrapper.tempSignerVerificationLabel = $A.get("$Label.echosign_dev1.Agreement_Editor_Identity_Password_Label");
        } else if( recipientWrapper.tempSignerVerification == 'KBA' ) {
           recipientWrapper.tempSignerVerificationLabel = $A.get("$Label.echosign_dev1.Agreement_Editor_Identity_KBA_Label");
        } else if( recipientWrapper.tempSignerVerification == 'Social' ) {
           recipientWrapper.tempSignerVerificationLabel = $A.get("$Label.echosign_dev1.Agreement_Editor_Identity_Social_Label");
        } else if( recipientWrapper.tempSignerVerification == 'Phone' ) {
           recipientWrapper.tempSignerVerificationLabel = $A.get("$Label.echosign_dev1.Agreement_Editor_Identity_Phone_Label");
        }
        
        recipientWrapper.countryCode = self.getFieldValue(component, recipientWrapper.recipient, "Phone_Verification_Country_Code__c") === undefined ? "1" : self.getFieldValue(component, recipientWrapper.recipient, "Phone_Verification_Country_Code__c");
		recipientWrapper.countryCodeLabel = self.getCountryCodeLabel( recipientWrapper.countryCode, schemaWrapper.recipientCountryCodes ); 
            
        component.set("v.recipientPassword", self.getFieldValue(component, recipientWrapper.recipient, "Password__c"));
        component.set("v.recipientConfirmPassword", self.getFieldValue(component, recipientWrapper.recipient, "Password__c"));
        component.set("v.selectedRecipientWrapper", recipientWrapper);
        //component.set("v.recipientWrappers", agreementWrapper.recipientWrappers);
        
        self.toggleElemVisibility("recipientVerificationDialog");
    },
    
    selectRecipientType : function(component, recipientIndex, recipientType) {
        var self = this;
        
       	if( !recipientIndex ) {
            return;
        }
        
        var agreementWrapper = component.get("v.agreementWrapper");
        var recipientWrapper = agreementWrapper.recipientWrappers[recipientIndex];
        
        self.setFieldValue(component, recipientWrapper.recipient, "Recipient_Type__c", recipientType);
        self.setFieldValue(component, recipientWrapper.recipient, "Contact__c", null);
        self.setFieldValue(component, recipientWrapper.recipient, "Lead__c", null);
        self.setFieldValue(component, recipientWrapper.recipient, "User__c", null);
        self.setFieldValue(component, recipientWrapper.recipient, "Group__c", null);
        self.setFieldValue(component, recipientWrapper.recipient, "Email_Address__c", null);
        
        if( recipientType == "Contact" ) {
            recipientWrapper.searchRecipientWrapper = $A.get("$Label.echosign_dev1.Agreement_Editor_Search_Contacts_Placeholder"); 
        } else if( recipientType == "Lead" ) {
            recipientWrapper.searchRecipientWrapper = $A.get("$Label.echosign_dev1.Agreement_Editor_Search_Lead_Placeholder"); 
        } else if( recipientType == "User" ) {
            recipientWrapper.searchRecipientWrapper = $A.get("$Label.echosign_dev1.Agreement_Editor_Search_Users_Placeholder"); 
        } else if( recipientType == "Group" ) {
            recipientWrapper.searchRecipientWrapper = $A.get("$Label.echosign_dev1.Agreement_Editor_Search_Groups_Placeholder"); 
        }
        
        if( recipientType === 'Group' ) {
            recipientWrapper.styleType = 'groups';
        } else {
        	recipientWrapper.styleType = recipientType.toLowerCase();
            
        }
        
        recipientWrapper.email = null;
        recipientWrapper.name = null;
        recipientWrapper.isRecipientSet = false;

        component.set("v.recipientWrappers", agreementWrapper.recipientWrappers);
        
        self.hideElemVisibility("recipientTypeDropdown" + recipientIndex);
    },

    selectReplaceRecipientType : function(component, recipientType) {
        var self = this;
        
        var recipientWrapper = component.get("v.replacementRecipientWrapper");
        
        self.setFieldValue(component, recipientWrapper.recipient, "Recipient_Type__c", recipientType);
        self.setFieldValue(component, recipientWrapper.recipient, "Contact__c", null);
        self.setFieldValue(component, recipientWrapper.recipient, "Lead__c", null);
        self.setFieldValue(component, recipientWrapper.recipient, "User__c", null);
        self.setFieldValue(component, recipientWrapper.recipient, "Email_Address__c", null);
        
        if( recipientType == "Contact" ) {
            recipientWrapper.searchRecipientWrapper = $A.get("$Label.echosign_dev1.Agreement_Editor_Search_Contacts_Placeholder"); 
        } else if( recipientType == "Lead" ) {
            recipientWrapper.searchRecipientWrapper = $A.get("$Label.echosign_dev1.Agreement_Editor_Search_Lead_Placeholder"); 
        } else if( recipientType == "User" ) {
            recipientWrapper.searchRecipientWrapper = $A.get("$Label.echosign_dev1.Agreement_Editor_Search_Users_Placeholder"); 
        } else if( recipientType == "Group" ) {
            recipientWrapper.searchRecipientWrapper = $A.get("$Label.echosign_dev1.Agreement_Editor_Search_Groups_Placeholder"); 
        }
        
        recipientWrapper.styleType = recipientType.toLowerCase();
        recipientWrapper.name = null;
        recipientWrapper.isRecipientSet = false;

        component.set("v.replacementRecipientWrapper", recipientWrapper);
        
        self.hideElemVisibility("replaceRecipientTypeDropdown");
    },

    changeReplaceRecipient : function(component) {
        var self = this;
        
        var replacementRecipientWrapper = component.get("v.replacementRecipientWrapper");
        var replaceRecipientMessage = component.find("replaceRecipientMessage").get("v.value");
        
        if( replaceRecipientMessage == null || 
           replaceRecipientMessage.trim() == "" || 
           replacementRecipientWrapper.email == null || 
           replacementRecipientWrapper.email.trim() == "" ) {
            component.set("v.storeReplaceRecipientDisabled", true);
        } else {
            component.set("v.storeReplaceRecipientDisabled", false);
        }
    },
    
    replaceRecipientSubmit : function(component, recipientType) {
        var self = this;
        
        var replaceMessage = component.find("replaceRecipientMessage").get("v.value");
        var agreementWrapper = component.get("v.agreementWrapper");
        var replacementRecipientWrapper = component.get("v.replacementRecipientWrapper");
        self.setFieldValue(component, replacementRecipientWrapper.recipient, "Agreement__c", agreementWrapper.agreement.Id);
        var recipientIndex = replacementRecipientWrapper.index;
        var replacedRecipientWrapper = agreementWrapper.recipientWrappers[ recipientIndex ];
        
        if( self.getFieldValue(component, replacementRecipientWrapper.recipient, "Recipient_Type__c") === "Email" ) {
        	self.setFieldValue(component, replacementRecipientWrapper.recipient, "Email_Address__c", replacementRecipientWrapper.email);
        }
		
        self.setFieldValue(component, replacedRecipientWrapper.recipient, "Replaced__c", true);

		agreementWrapper.recipientWrappers[ recipientIndex ] = replacementRecipientWrapper;
        
        agreementWrapper.replacedRecipientWrappers.push(replacedRecipientWrapper);
        
        var action = component.get("c.replaceRecipient");
        action.setParams({
            /*"agreementStr" : $A.util.json.encode(agreementWrapper.agreement),
            "replacementRecipientStr" : $A.util.json.encode(replacementRecipientWrapper.recipient),
            "replacedRecipientStr" : $A.util.json.encode(replacedRecipientWrapper.recipient),*/
            
            "agreementStr": JSON.stringify(agreementWrapper.agreement),
            "replacementRecipientStr" : JSON.stringify(replacementRecipientWrapper.recipient),
            "replacedRecipientStr" : JSON.stringify(replacedRecipientWrapper.recipient),
            "replacementRecipientEmail" : replacementRecipientWrapper.email,
            "replaceMessage" : replaceMessage
        });
        
		action.setCallback(this, function(a) {
            var isSuccess = self.checkResult(component, a);
            if( !isSuccess ) {
                self.hideElemVisibility("replaceRecipientDialog");
                return;
            }
            
            var result = a.getReturnValue().result;
            
            replacementRecipientWrapper.recipient.Id = result;
            
        	component.set("v.recipientWrappers", agreementWrapper.recipientWrappers);
        
        	self.hideElemVisibility("replaceRecipientDialog");
            self.reinitPageCustom(component);
            
		});
        
		$A.enqueueAction(action);
    },
    
    selectSignerRole : function(component, recipientIndex, signRoleValue) {
        var self = this;    
        
       	if( !recipientIndex ) {
            return;
        }
        
        var agreementWrapper = component.get("v.agreementWrapper");
        
        self.setFieldValue(component, agreementWrapper.recipientWrappers[recipientIndex].recipient, "Recipient_Role__c", signRoleValue);
        
        component.set("v.recipientWrappers", agreementWrapper.recipientWrappers);
        
        
        self.hideElemVisibility("recipientRoleDropdown" + recipientIndex);
    },
    
    selectSignOrder : function(component, signOrderValue) {
        var self = this;
        
        var agreementWrapper = component.get("v.agreementWrapper");
        
        component.set("v.agreementSignOrder", signOrderValue);
        
        if( signOrderValue == 'Sign in Order' ) {
        	component.set("v.agreementSignOrderLabel", $A.get("$Label.echosign_dev1.Agreement_Editor_Sign_In_Order_Label"));     
        } else if( signOrderValue == 'Sign in Any Order' ) {
        	component.set("v.agreementSignOrderLabel", $A.get("$Label.echosign_dev1.Agreement_Editor_Sign_In_Any_Order_Label"));     
        } else if( signOrderValue == 'Only I Sign' ) {
        	component.set("v.agreementSignOrderLabel", $A.get("$Label.echosign_dev1.Agreement_Editor_Only_I_Sign_Order_Label"));     
        }
        
        self.addRecipientOnlyISign(agreementWrapper, component);
        
        self.hideElemVisibility("signOrderDropdown");
    },
    
    selectSignatureType : function(component, signatureType) {
        var self = this;
        
        var agreementWrapper = component.get("v.agreementWrapper");
        self.setFieldValue(component, agreementWrapper.agreement, "SignatureType__c", signatureType);
        
        self.initSignatureTypeComponent(component, agreementWrapper);
        
        component.set("v.agreementWrapper", agreementWrapper);
    },
 
    /*getIsSforceOne: function() {
   		return (typeof sforce !== 'undefined') && (sforce !== undefined) && (sforce.one !== undefined);
    },*/
     
    hideElemVisibility: function(elemId) {
        var elem = document.getElementById(elemId);
        if( !elem ) {
            return;
        }
        
        var elemClass = elem.getAttribute("class");
        
        if( elemClass.indexOf("slds-show") !== -1 ) {
            elemClass = elemClass.replace("slds-show", "slds-hide");
        	elem.setAttribute("class", elemClass);
        }
    },
     
    showElemVisibility: function(elemId) {
        var elem = document.getElementById(elemId);
        if( !elem ) {
            return;
        }
        
        var elemClass = elem.getAttribute("class");
        
        if( elemClass.indexOf("slds-hide") !== -1 ) {
            elemClass = elemClass.replace("slds-hide", "slds-show");
        	elem.setAttribute("class", elemClass);
        }
    },
    
    toggleElemVisibility: function(elemId) {
   		var elem = document.getElementById(elemId);
        
         if( !elem ) {
            return;
        }
        
        var elemClass = elem.getAttribute("class");
        
        if( elemClass.indexOf("slds-show") !== -1 ) {
            elemClass = elemClass.replace("slds-show", "slds-hide");
        } else {
            elemClass = elemClass.replace("slds-hide", "slds-show");
        }
        
        elem.setAttribute("class", elemClass);
    },
    
    toggleInputComponent: function(component, elemId) {
        var isSent = component.get("v.isSent");
        if( isSent ) {
            return;
        }
        
        var self = this;
        
        self.toggleElemVisibility(elemId);
    },
    
    setAgreementDeadline : function(component, year, month, day) {
        var self = this;
        
        var agreementWrapper = component.get("v.agreementWrapper");
        
        if( year == null && month == null && day == null ) {
        	self.setFieldValue(component, agreementWrapper.agreement, "Signing_Deadline__c", null);
        	agreementWrapper.signingDeadlineFormatted = null;      
        } else {
        	self.setFieldValue(component, agreementWrapper.agreement, "Signing_Deadline__c", new Date(Date.UTC(year, month, day, 0, 0, 0)));
        	agreementWrapper.signingDeadlineFormatted = (month + 1) + "/" + day + "/" + year;     
        }
        
        component.set("v.agreementWrapper", agreementWrapper);
        
        if( year == null && month == null && day == null ) {
            var current = new Date();
            var cmonth = current.getMonth();
        	var cyear = current.getFullYear();
            self.calendar(component, cmonth, cyear, self.getFieldValue(component, agreementWrapper.agreement, "Signing_Deadline__c"));
        } else {
            self.calendar(component, month, year, self.getFieldValue(component, agreementWrapper.agreement, "Signing_Deadline__c"));
            
            self.toggleElemVisibility("deadlineDate");
        }
    },

    
    getMonthLabel : function(monthValue) {
        if( monthValue == "January" ) {
            return $A.get("$Label.echosign_dev1.Calendar_January_Label");
        } else if( monthValue == "February" ) {
            return $A.get("$Label.echosign_dev1.Calendar_February_Label");
        } else if( monthValue == "March" ) {
            return $A.get("$Label.echosign_dev1.Calendar_March_Label");
        } else if( monthValue == "April" ) {
            return $A.get("$Label.echosign_dev1.Calendar_April_Label");
        } else if( monthValue == "May" ) {
            return $A.get("$Label.echosign_dev1.Calendar_May_Label");
        } else if( monthValue == "June" ) {
            return $A.get("$Label.echosign_dev1.Calendar_June_Label");
        } else if( monthValue == "July" ) {
            return $A.get("$Label.echosign_dev1.Calendar_July_Label");
        } else if( monthValue == "August" ) {
            return $A.get("$Label.echosign_dev1.Calendar_August_Label");
        } else if( monthValue == "September" ) {
            return $A.get("$Label.echosign_dev1.Calendar_September_Label");
        } else if( monthValue == "October" ) {
            return $A.get("$Label.echosign_dev1.Calendar_October_Label");
        } else if( monthValue == "November" ) {
            return $A.get("$Label.echosign_dev1.Calendar_November_Label");
        } else if( monthValue == "December" ) {
            return $A.get("$Label.echosign_dev1.Calendar_December_Label");
        }
    },
    
    moveDeadlineDate : function(component, monthMove) {
        var self = this;
        
        var current = new Date();
        var cmonth = current.getMonth();
        var cday = current.getDate();
        var cyear = current.getFullYear();
        
       	var agreementWrapper = component.get("v.agreementWrapper");
        var month = component.get("v.expirePickerSelectedMonthValue");
        var year = component.get("v.expirePickerSelectedYearValue");
        
        var deadlineDate;
        if( self.getFieldValue(component, agreementWrapper.agreement, "Signing_Deadline__c") !== undefined &&
          self.getFieldValue(component, agreementWrapper.agreement, "Signing_Deadline__c") !== null ) {
        	deadlineDate = new Date( self.getFieldValue(component, agreementWrapper.agreement, "Signing_Deadline__c") );
        }
        
        if( monthMove === "Previous" ) {
            if( month === 0 ) {
                month = 11;
                year -= 1;
            } else {
            	month -= 1;
            }
        } else if( monthMove === "Next" ) {
            if( month === 11 ) {
                month = 0;
                year += 1;
            } else {
            	month += 1;
        	}
        }
        
       	self.calendar(component, month, year, deadlineDate);
        
        component.set("v.expirePickerSelectedMonth", self.getMonthLabel( self.cal_months_labels[month] ) );
        component.set("v.expirePickerSelectedMonthValue", month);
        component.set("v.expirePickerSelectedYearValue", year);
        
       	if( month === cmonth && year === cyear ) {
            component.set("v.isCurrentMonth", true);
        } else {
            component.set("v.isCurrentMonth", false);
        }
    },
 
    searchSObjects: function(component, helper, elemId, type, searchResultsRecordId) {
        type = type.toLowerCase();
   		var elem = document.getElementById(elemId);
        var targetValue = elem.value;
        
        component.set("v.searchTerm", targetValue);
        
        var action;
        if( type === 'contact' ) {
        	action = component.get("c.queryContacts");
        } else if( type === 'lead' ) {
        	action = component.get("c.queryLeads");
        } else if( type === 'user' ) {
        	action = component.get("c.queryUsers");
        } else if( type === 'group' ) {
        	action = component.get("c.queryGroups");
        } else if( type === 'account' ) {
        	action = component.get("c.queryAccounts");
        } else if( type === 'opportunity' ) {
        	action = component.get("c.queryOpps");
        } else if( type === 'contract' ) {
        	action = component.get("c.queryContracts");
        }
        
        action.setParams({
            "name": targetValue
        });
        
		var self = this;
		action.setCallback(this, function(a) {
            var resultRecords = a.getReturnValue();
            
            if( !resultRecords ) {
                return;
            }
            
            var searchItemWrappers = new Array();
            for( var i = 0; i < resultRecords.length; i++ ) {
                var resultRecord = resultRecords[i].record;
                var searchItemWrapper = {};
                
                searchItemWrapper.name = resultRecord["Name"] === undefined ? resultRecord["DeveloperName"] : resultRecord["Name"] ;
                
                if( searchItemWrapper.name == null && resultRecord["ContractNumber"] !== undefined ) {
                    searchItemWrapper.name = resultRecord["ContractNumber"];
                }
                
                searchItemWrapper.email = resultRecord["Email"];
                searchItemWrapper.fax = resultRecord["Fax"];
                searchItemWrapper.recordId = resultRecord["Id"];
				searchItemWrapper.mobilePhoneNumber =  resultRecords[i]["mobilePhoneNumber"]; 
				searchItemWrapper.mobilePhoneCountryCode =  resultRecords[i]["mobilePhoneCountryCode"];                
                
                searchItemWrappers.push(searchItemWrapper);
            }
            
            self.showElemVisibility(searchResultsRecordId);
            
            component.set("v.searchItemWrappers", searchItemWrappers);
		});
		$A.enqueueAction(action);
    },
    
    initSignatureTypeComponent : function(component, agreementWrapper) {
        var self = this;
        
        if( document.getElementById("esigType") === null ||
        	document.getElementById("writtenType") === null ) {
            return;
        }
        
        if( self.getFieldValue(component, agreementWrapper.agreement, "SignatureType__c") === null ||
           	self.getFieldValue(component, agreementWrapper.agreement, "SignatureType__c") === "e-Signature"  ) {
        	document.getElementById("esigType").checked = true;
            document.getElementById("writtenType").checked = false;
        } else if( self.getFieldValue(component, agreementWrapper.agreement, "SignatureType__c") === "Written Signature" ) {
            document.getElementById("writtenType").checked = true;
            document.getElementById("esigType").checked = false;
        }
    },
    
    initComponents : function(component, helper) {
        var self = this;
        
        //var jquery = $jquery.noConflict();
        
        var current = new Date();
        var cmonth = current.getMonth();
        var cday = current.getDate();
        var cyear = current.getFullYear();
        
        var agreementWrapper = component.get("v.agreementWrapper");
        var settingsWrapper = component.get("v.settingsWrapper");
            
        var deadlineDate;
        var month = cmonth;
        var year = cyear;
        
        var signingDeadlineValue = self.getFieldValue(component, agreementWrapper.agreement, "Signing_Deadline__c");
        if( signingDeadlineValue !== undefined && signingDeadlineValue !== null ) {
            if( signingDeadlineValue instanceof String ) {
            	var parts = self.getFieldValue(component, agreementWrapper.agreement, "Signing_Deadline__c").split('-');
                deadlineDate = new Date( parts[0], parts[1]-1, parts[2] );
            } else if( signingDeadlineValue instanceof Date ) {
                deadlineDate = signingDeadlineValue;
            } else {
                deadlineDate = new Date();
            }
        	
            month = deadlineDate.getMonth();
            year = deadlineDate.getFullYear();
        }
        
       	helper.calendar(component, month, year, deadlineDate);
        
        if( month === cmonth && year === cyear ) {
            component.set("v.isCurrentMonth", true);
        } else {
            component.set("v.isCurrentMonth", false);
        }
        
        component.set("v.expirePickerSelectedMonth", self.getMonthLabel( self.cal_months_labels[month] ) );
        component.set("v.expirePickerSelectedMonthValue", month);
        component.set("v.expirePickerSelectedYearValue", year);
        
		helper.initSignatureTypeComponent(component, agreementWrapper);
        
        var isSent = component.get("v.isSent");
        //if( isSent ) {     
        
        if( isSent || self.getFieldValue(component, settingsWrapper.customSettings, "Read_Only_Signature_Type__c") ) {
        	$jquery("#esigType").attr("disabled", "disabled");        
        	$jquery("#writtenType").attr("disabled", "disabled");
        }
        
        var readonlyElementIds = [];
        var readonlyElement2Ids = [];
        
        if( self.getFieldValue(component, settingsWrapper.customSettings, "Read_Only_Recipient__c") ) {
            readonlyElementIds.push("recipientEmailInput");
            readonlyElementIds.push("recipientVerificationTypeButton");
            //readonlyElementIds.push("recipientLookupInputPanel");
            readonlyElementIds.push("emailRecipientPanel");
            
            $jquery("input[type|='email']").each(function (i, el) {
                $jquery(el).attr("readonly", "readonly");
                $jquery(el).addClass("esign-input-readonly-lighter");
     		});
            
            $jquery("div[id^='recipientLookupInputPanel']").each(function (i, el) {
                $jquery(el).attr("readonly", "readonly");
                $jquery(el).addClass("esign-input-readonly");
     		});
            
            $jquery("input[id|='recipientInputLookup']").each(function (i, el) {
                $jquery(el).attr("readonly", "readonly");
     		});
            
            $jquery("input[id|='recipientVerification']").each(function (i, el) {
                $jquery(el).attr("readonly", "readonly");
                $jquery(el).addClass("esign-input-readonly");
     		});
        }
        
        if( isSent ) {
            readonlyElementIds.push("recipientEmailInput");
            readonlyElementIds.push("recipientVerificationTypeButton");
            //readonlyElementIds.push("recipientLookupInputPanel");
            readonlyElementIds.push("emailRecipientPanel");
            readonlyElementIds.push("recipientRole");
            
            $jquery("div[id^='recipientLookupInputPanel']").each(function (i, el) {
                $jquery(el).attr("readonly", "readonly");
                $jquery(el).addClass("esign-input-readonly");
     		});

           	$jquery("input[id^='recipientOrder']").each(function (i, el) {
                $jquery(el).attr("readonly", "readonly");
                $jquery(el).addClass("esign-input-readonly");
     		});
            
            $jquery("input[type|='email']").each(function (i, el) {
                $jquery(el).attr("readonly", "readonly");
                $jquery(el).addClass("esign-input-readonly-lighter");
     		});
            
            $jquery("button[id^='recipientRoleButton']").each(function (i, el) {
                $jquery(el).attr("readonly", "readonly");
                $jquery(el).addClass("esign-input-readonly-lighter");
     		});
            
            $jquery("input[id|='recipientVerification']").each(function (i, el) {
                $jquery(el).attr("readonly", "readonly");
                $jquery(el).addClass("esign-input-readonly");
     		});
        }
        
        if( isSent || self.getFieldValue(component, settingsWrapper.customSettings, "Read_Only_Post_Sign_Options__c") ) {
            readonlyElementIds.push("postSignUrlProtocolButton");
            readonlyElementIds.push("postSignUrlProtocolButton");
          
            var postSignUrlTarget = component.find('postSignUrl');
            if( postSignUrlTarget ) {
				$A.util.addClass(postSignUrlTarget, 'esign-input-readonly');
            	$jquery( postSignUrlTarget.getElement() ).attr("readonly", "readonly");      
            }
            
            var postSignDelayTarget = component.find('postSignDelay');
            if( postSignDelayTarget ) {
				$A.util.addClass(postSignDelayTarget, 'esign-input-readonly');
            	$jquery( postSignDelayTarget.getElement() ).attr("readonly", "readonly");      
            }
        }
        
        if( isSent || self.getFieldValue(component, settingsWrapper.customSettings, "Read_Only_Sign_Expiration__c") ) {
        	//readonlyElementIds.push("agreementExpireDateInput");
        	var agreementExpireDateInputTarget = component.find('agreementExpireDateInput');
            if( agreementExpireDateInputTarget ) {
				$A.util.addClass(agreementExpireDateInputTarget, 'esign-input-readonly');
            	$jquery( agreementExpireDateInputTarget.getElement() ).attr("readonly", "readonly");      
            }
        }
        
        if( isSent || self.getFieldValue(component, settingsWrapper.customSettings, "Read_Only_Language__c") ) {
        	readonlyElementIds.push("agreementLanguageButton");
        }
        
        if( isSent || self.getFieldValue(component, settingsWrapper.customSettings, "Read_Only_Sign_Reminder__c") ) {
        	readonlyElementIds.push("agreementReminderButton");
        }
        
       	if( isSent || self.getFieldValue(component, settingsWrapper.customSettings, "Read_Only_Security_Options__c") ) {
        	readonlyElementIds.push("agreementVerificationPasswordInput");
            readonlyElementIds.push("agreementVerificationInput");
            readonlyElementIds.push("agreementInternalVerificationPasswordInput");
            readonlyElementIds.push("agreementExternalVerificationPasswordInput");
            readonlyElementIds.push("agreementInternalVerificationInput");
            readonlyElementIds.push("agreementExternalVerificationInput");
        }
          
        
    	if( isSent || self.getFieldValue(component, settingsWrapper.customSettings, "Read_Only_Account__c") ) {
			readonlyElementIds.push("accountLookupPanel");
            readonlyElement2Ids.push("accountInputLookup");
		}
 
     	if( isSent || self.getFieldValue(component, settingsWrapper.customSettings, "Read_Only_Opportunity__c") ) {
            readonlyElementIds.push("oppLookupPanel");
			readonlyElement2Ids.push("oppInputLookup");
		}

     	if( isSent || self.getFieldValue(component, settingsWrapper.customSettings, "Read_Only_Contract__c") ) {
			readonlyElementIds.push("contractLookupPanel");
            readonlyElement2Ids.push("contractInputLookup");
		}
        
     	if( isSent || self.getFieldValue(component, settingsWrapper.customSettings, "Read_Only_Recipient_Signing_Order_Field__c") ) {
			readonlyElementIds.push("senderSignsButton");
            readonlyElementIds.push("signOrderButton");
		}
            
        var index = 0;
       	for( var i = 0; i < readonlyElementIds.length; i++ ) {
        	var readonlyElementId = readonlyElementIds[i];
                
        	$jquery("#" + readonlyElementId).attr("readonly", "readonly");
        	$jquery("#" + readonlyElementId).addClass("esign-input-readonly");      
       	}
          
            
       	for( var i = 0; i < readonlyElement2Ids.length; i++ ) {
       		var readonlyElementId = readonlyElement2Ids[i];
                
        	$jquery("#" + readonlyElementId).attr("readonly", "readonly");    
        }

		if( isSent || self.getFieldValue(component, settingsWrapper.customSettings, "Read_Only_Agreement_Name__c") ) {
            var nameTarget = component.find('agreementName');
            if( nameTarget ) {
				$A.util.addClass(nameTarget, 'esign-input-readonly');
            	$jquery( nameTarget.getElement() ).attr("readonly", "readonly");       
            }
        }
		
		if( isSent || self.getFieldValue(component, settingsWrapper.customSettings, "Read_Only_Message__c") ) {
            var messageTarget = component.find('agreementMessage');
            if( messageTarget ) {
				$A.util.addClass(messageTarget, 'esign-input-readonly');
            	$jquery( messageTarget.getElement() ).attr("readonly", "readonly");  
            }
        }
		
		if( isSent || self.getFieldValue(component, settingsWrapper.customSettings, "Read_Only_Cc__c") ) {
            var ccTarget = component.find('agreementCc');
            if( ccTarget ) {
				$A.util.addClass(ccTarget, 'esign-input-readonly');
            	$jquery( ccTarget.getElement() ).attr("readonly", "readonly");     
            }
        }
        
        
            
        //}
    },
    
    initListeners : function(component, helper) {
        //var jquery = $jquery.noConflict();
        
        try {
            var $window = $jquery(window), $stickyEl = $jquery('#page-header-sticky-div'), elTop = $stickyEl.offset().top;
    
            $window.scroll(function() {
                $stickyEl.toggleClass('sticky-panel', $window.scrollTop() > elTop);
            });
        } catch(err) {
            //ignore
        }
        
        
        var recipientTypeDropdownElement = $jquery( document.getElementById('recipientTypeDropdown') );
        var recipientTypeInputElement = $jquery( document.getElementById('recipientTypeInput') );
        var accountSearchResultsElement = $jquery( document.getElementById('accountSearchResults') );
        var oppSearchResultsElement = $jquery( document.getElementById('opportunitySearchResults') );
        var contractSearchResultsElement = $jquery( document.getElementById('contractSearchResults') );
        
        var agreementVerificationElement = $jquery( document.getElementById('agreementVerificationDropdown') );
        var agreementVerificationInputElement = $jquery( document.getElementById('agreementVerificationInput') );
        
        var agreementInternalVerificationElement = $jquery( document.getElementById('agreementInternalVerificationDropdown') );
        var agreementInternalVerificationInputElement = $jquery( document.getElementById('agreementInternalVerificationInput') );
        
        var agreementExternalVerificationElement = $jquery( document.getElementById('agreementExternalVerificationDropdown') );
        var agreementExternalVerificationInputElement = $jquery( document.getElementById('agreementExternalVerificationInput') );
        
        var inProgressActionsElement = $jquery( document.getElementById('inProgressActionsDropdown') );
        var inProgressActionsInputElement = $jquery( document.getElementById('inProgressActionsInput') );
        
        var signOrderElement = $jquery( document.getElementById('signOrderDropdown') );
        var signOrderInputElement = $jquery( document.getElementById('signOrderButton') );
        
        $jquery(document).mouseup(function (e) {
        	var container = recipientTypeDropdownElement;
        	var containerInput = recipientTypeInputElement;
            var accountContainer = accountSearchResultsElement;
            var oppContainer = oppSearchResultsElement;
            var contractContainer = contractSearchResultsElement;
            
            var agreementVerificationContainer = agreementVerificationElement;
            var agreementVerificationInputContainer = agreementVerificationInputElement;
            
            var agreementInternalVerificationContainer = agreementInternalVerificationElement;
            var agreementInternalVerificationInputContainer = agreementInternalVerificationInputElement;
            
            var agreementExternalVerificationContainer = agreementExternalVerificationElement;
            var agreementExternalVerificationInputContainer = agreementExternalVerificationInputElement;
            
            var inProgressActionsContainer = inProgressActionsElement;
            var inProgressActionsInputContainer = inProgressActionsInputElement;
            
            var signOrderContainer = signOrderElement;
            var signOrderInputContainer = signOrderInputElement;
                        
            if ( !container.is(e.target) // if the target of the click isn't the container...
                && container.has(e.target).length === 0
                && !containerInput.is(e.target)
                && containerInput.has(e.target).length === 0) { // ... nor a descendant of the container
            	helper.hideElemVisibility( container.attr('id') );
        	}
            
            if( accountContainer
               && !accountContainer.is(e.target)
               && accountContainer.has(e.target).length === 0 ) {
                helper.hideElemVisibility( accountContainer.attr('id') );
            }
            
            if( oppContainer
               && !oppContainer.is(e.target)
               && oppContainer.has(e.target).length === 0 ) {
                helper.hideElemVisibility( oppContainer.attr('id') );
            }
            
            if( contractContainer
               && !contractContainer.is(e.target)
               && contractContainer.has(e.target).length === 0 ) {
                helper.hideElemVisibility( contractContainer.attr('id') );
            }
            
            if( agreementVerificationContainer
               && !agreementVerificationContainer.is(e.target)
               && agreementVerificationContainer.has(e.target).length === 0
               && !agreementVerificationInputContainer.is(e.target)
               && agreementVerificationInputContainer.has(e.target).length === 0 ) {
                helper.hideElemVisibility( agreementVerificationContainer.attr('id') );
            }
            
            if( agreementInternalVerificationContainer
               && !agreementInternalVerificationContainer.is(e.target)
               && agreementInternalVerificationContainer.has(e.target).length === 0
               && !agreementInternalVerificationInputContainer.is(e.target)
               && agreementInternalVerificationInputContainer.has(e.target).length === 0 ) {
                helper.hideElemVisibility( agreementInternalVerificationContainer.attr('id') );
            }
            
            if( agreementExternalVerificationContainer
               && !agreementExternalVerificationContainer.is(e.target)
               && agreementExternalVerificationContainer.has(e.target).length === 0
               && !agreementExternalVerificationInputContainer.is(e.target)
               && agreementExternalVerificationInputContainer.has(e.target).length === 0 ) {
                helper.hideElemVisibility( agreementExternalVerificationContainer.attr('id') );
            }
            
            if( inProgressActionsContainer
               && !inProgressActionsContainer.is(e.target)
               && inProgressActionsContainer.has(e.target).length === 0
               && !inProgressActionsInputContainer.is(e.target)
               && inProgressActionsInputContainer.has(e.target).length === 0 ) {
                helper.hideElemVisibility( inProgressActionsContainer.attr('id') );
            }
            
            if( signOrderContainer
               && !signOrderContainer.is(e.target)
               && signOrderContainer.has(e.target).length === 0
               && !signOrderInputContainer.is(e.target)
               && signOrderInputContainer.has(e.target).length === 0 ) {
                helper.hideElemVisibility( signOrderContainer.attr('id') );
            }
            
        	var agreementReminderContainer = $jquery( document.getElementById('reminderDropdown') );
        	var agreementReminderInputContainer = $jquery( document.getElementById('agreementReminderButton') );
            
           	if( agreementReminderContainer
               && !agreementReminderContainer.is(e.target)
               && agreementReminderContainer.has(e.target).length === 0
               && !agreementReminderInputContainer.is(e.target)
               && agreementReminderInputContainer.has(e.target).length === 0 ) {
                helper.hideElemVisibility( agreementReminderContainer.attr('id') );
            }

        	var agreementLanguageContainer = $jquery( document.getElementById('languageDropdown') );
        	var agreementLanguageInputContainer = $jquery( document.getElementById('agreementLanguageButton') );
            
           	if( agreementLanguageContainer
               && !agreementLanguageContainer.is(e.target)
               && agreementLanguageContainer.has(e.target).length === 0
               && !agreementLanguageInputContainer.is(e.target)
               && agreementLanguageInputContainer.has(e.target).length === 0 ) {
                helper.hideElemVisibility( agreementLanguageContainer.attr('id') );
            }
            
        	var recipientAddressContainer = $jquery( document.getElementById('recipientAddressDropdown') );
        	var recipientAddressInputContainer = $jquery( document.getElementById('recipientAddressButton') );
            
           	if( recipientAddressContainer
               && !recipientAddressContainer.is(e.target)
               && recipientAddressContainer.has(e.target).length === 0
               && !recipientAddressInputContainer.is(e.target)
               && recipientAddressInputContainer.has(e.target).length === 0 ) {
                helper.hideElemVisibility( recipientAddressContainer.attr('id') );
            }
            
            var agreementDeadlineContainer = $jquery( document.getElementById('deadlineDate') );
        	var agreementDeadlineInputContainer = $jquery( document.getElementById('deadlineDateButton') );
            
           	if( agreementDeadlineContainer
               && !agreementDeadlineContainer.is(e.target)
               && agreementDeadlineContainer.has(e.target).length === 0
               && !agreementDeadlineInputContainer.is(e.target)
               && agreementDeadlineInputContainer.has(e.target).length === 0 ) {
                helper.hideElemVisibility( agreementDeadlineContainer.attr('id') );
            }
            
            var signerRoleElements = new Array();
            var signerRoleInputElements = new Array();
            
           	$jquery("div[id^='recipientRoleDropdown']").each(function (i, el) {
                var signerRoleElement = $jquery(el);
                signerRoleElements.push(signerRoleElement);
            });
                                                               
           	$jquery("button[id^='recipientRoleButton']").each(function (i, el) {
                var signerRoleInputElement = $jquery(el);
                signerRoleInputElements.push(signerRoleInputElement);
            });
            
            for( var i = 0; i < signerRoleElements.length; i++ ) {
                var signerRoleContainer = signerRoleElements[i];
                var signerRoleInputContainer = signerRoleInputElements[i];
                
                if( signerRoleContainer
                   && !signerRoleContainer.is(e.target)
                   && signerRoleContainer.has(e.target).length === 0
                   && !signerRoleInputContainer.is(e.target)
                   && signerRoleInputContainer.has(e.target).length === 0 ) {
                	helper.hideElemVisibility( signerRoleContainer.attr('id') );
                }
            }
            
            
            var signerTypeElements = new Array();
            var signerTypeInputElements = new Array();
            
           	$jquery("div[id^='recipientTypeDropdown']").each(function (i, el) {
                var signerTypeElement = $jquery(el);
                signerTypeElements.push(signerTypeElement);
            });
                                                               
           	$jquery("button[id^='recipientTypeButton']").each(function (i, el) {
                var signerTypeInputElement = $jquery(el);
                signerTypeInputElements.push(signerTypeInputElement);
            });
            
            for( var i = 0; i < signerTypeElements.length; i++ ) {
                var signerTypeContainer = signerTypeElements[i];
                var signerTypeInputContainer = signerTypeInputElements[i];
                
                if( signerTypeContainer
                   && !signerTypeContainer.is(e.target)
                   && signerTypeContainer.has(e.target).length === 0
                   && signerTypeInputContainer
                   && !signerTypeInputContainer.is(e.target)
                   && signerTypeInputContainer.has(e.target).length === 0 ) {
                	helper.hideElemVisibility( signerTypeContainer.attr('id') );
                }
            }
            
            var signerSearchElements = new Array();
            
           	$jquery("div[id^='recipientSearchResults']").each(function (i, el) {
                var signerSearchElement = $jquery(el);
                signerSearchElements.push(signerSearchElement);
            });
            
            for( var i = 0; i < signerSearchElements.length; i++ ) {
                var signerSearchContainer = signerSearchElements[i];
                
                if( signerSearchContainer
                   && !signerSearchContainer.is(e.target)
                   && signerSearchContainer.has(e.target).length === 0 ) {
                	helper.hideElemVisibility( signerSearchContainer.attr('id') );
                }
            }  
            
            
            var replaceSignerTypeElements = new Array();
            var replaceSignerTypeInputElements = new Array();
            
           	$jquery("div[id^='replaceRecipientTypeDropdown']").each(function (i, el) {
                var signerTypeElement = $jquery(el);
                replaceSignerTypeElements.push(signerTypeElement);
            });
                                                               
           	$jquery("button[id^='replaceRecipientTypeButton']").each(function (i, el) {
                var signerTypeInputElement = $jquery(el);
                replaceSignerTypeInputElements.push(signerTypeInputElement);
            });
            
            for( var i = 0; i < replaceSignerTypeElements.length; i++ ) {
                var signerTypeContainer = replaceSignerTypeElements[i];
                var signerTypeInputContainer = replaceSignerTypeElements[i];
                
                if( signerTypeContainer
                   && !signerTypeContainer.is(e.target)
                   && signerTypeContainer.has(e.target).length === 0
                   && !signerTypeInputContainer.is(e.target)
                   && signerTypeInputContainer.has(e.target).length === 0 ) {
                	helper.hideElemVisibility( signerTypeContainer.attr('id') );
                }
            }
            
            var replaceSignerSearchElements = new Array();
            
           	$jquery("div[id^='replaceRecipientSearchResults']").each(function (i, el) {
                var signerSearchElement = $jquery(el);
                replaceSignerSearchElements.push(signerSearchElement);
            });
            
            for( var i = 0; i < replaceSignerSearchElements.length; i++ ) {
                var signerSearchContainer = replaceSignerSearchElements[i];
                
                if( signerSearchContainer
                   && !signerSearchContainer.is(e.target)
                   && signerSearchContainer.has(e.target).length === 0 ) {
                	helper.hideElemVisibility( signerSearchContainer.attr('id') );
                }
            } 
            
       	});
    },
    
    initElementListener : function(elementId, elementContainerId) {
        var listenerElement = $jquery( document.getElementById(elementId) );
        var listenerContainerElement = $jquery( document.getElementById(elementContainerId) );
                
        if( listenerElement
        	&& !listenerElement.is(e.target)
           	&& listenerElement.has(e.target).length === 0
            && !listenerContainerElement.is(e.target)
            && listenerContainerElement.has(e.target).length === 0 ) {
        	helper.hideElemVisibility(elementId);
    	}
    },
        
    initSortable : function(component, helper) {
        var isSent = component.get("v.isSent");
        if( isSent ) {
            return;
        }
        
        var settingsWrapper = component.get("v.settingsWrapper");
        
        //var jquery = $jquery.noConflict();
        
        if( !helper.getFieldValue(component, settingsWrapper.customSettings, "Disable_Sort_Attachments__c") ) {
            $jquery( "#sortableDocuments" ).sortable({
                placeholder: "ui-state-highlight",
                update: function( event, ui ) {
                    var liIds = $jquery('#sortableDocuments li').map(function(i,n) {
                        return $jquery(n).attr('data-order');
                    }).get();
                                            
                    var documentIndexes = new Array();
                    
                    for( var i = 0; i < liIds.length; i++ ) {
                        documentIndexes.push( liIds[i] );
                    }
                                            
                    var documentIndexesStr = documentIndexes.join(',');
                    helper.reoderAttachments(component, documentIndexesStr);
                }
            });
        }
        
        if( !helper.getFieldValue(component, settingsWrapper.customSettings, "Disable_Sort_Recipients__c") ) {
            $jquery( "#sortableRecipients" ).sortable({
                placeholder: "ui-state-highlight",
                update: function( event, ui ) {
                    var liIds = $jquery("li[id^='recipientRowItem']").map(function(i,n) {
                        return $jquery(n).attr('data-order');
                    }).get();
                                            
                    var recipientIndexes = new Array();
                    for( var i = 0; i < liIds.length; i++ ) {
                        var recipientIndex = liIds[i];
                        if( !recipientIndex ) {
                            continue;
                        }
                        recipientIndexes.push(recipientIndex);
                    }
                                            
                    var recipientIndexesStr = recipientIndexes.join(',');
                    helper.moveOrderRecipient(component, recipientIndexesStr);
                }
            });
        }
	},
    
    navigateToSObject : function (recordId) {
        var self = this;
        
        self.navToUrl("/" + recordId);
	},
    
    navToUrl : function(url) {
        return window.open(url);
    },
    
    checkPopup : function(component, popup, agreement) {
        var self = this;

        var intervalRef = setInterval( function() {             
        		if( !popup || popup.closed ) {
                    clearInterval(intervalRef);

                    var agreementUrl = self.getReturnUrl(component, agreement);
                    window.parent.location.href = agreementUrl;
                }
			}, 
        	500 );
    },
    
    getNestedOrderValue : function(event) {
        var recipientIndex;
    	if( event.target.dataset !== undefined && event.target.dataset.order !== undefined ) {
            recipientIndex = event.target.dataset.order;
        } else if( event.target.parentElement.dataset !== undefined && event.target.parentElement.dataset.order !== undefined ) {
           	recipientIndex = event.target.parentElement.dataset.order; 
        } else if( event.target.parentElement.parentElement.dataset !== undefined && event.target.parentElement.parentElement.dataset.order !== undefined ) {
			recipientIndex = event.target.parentElement.parentElement.dataset.order; 
        }
        
        return recipientIndex;
	},
    
    getCountryCodeLabel : function(countryCode, recipientCountryCodes) {
        for( var i = 0; i < recipientCountryCodes.length; i++ ) {
            var recipientCountryCode = recipientCountryCodes[i];
            if( recipientCountryCode.value === countryCode ) {
                return recipientCountryCode.label;
            }
        }
        return null;
    },
    
    calendar : function(component, month, year, selectedDate) {
        var self = this;
        
        var current = new Date();
        
        var cmonth = current.getMonth();
        var cday = current.getDate();
        var cyear = current.getFullYear();
        
        var selectedDateMonth;
        var selectedDateDay;
        var selectedDateYear;
        
        if( selectedDate != undefined && selectedDate != null ) {
            selectedDateMonth = selectedDate.getMonth();
            selectedDateDay = selectedDate.getDate();
            selectedDateYear = selectedDate.getFullYear();
        }
        
        //Variables to be used later.  Place holders right now.
        var calendarWeeks = new Array();
        var padding = "";
        var totalFeb = "";
        var i = 1;
        var testing = "";

        var tempMonth = month + 1; //Used to match up the current month with the correct start date.
        var prevMonth = month - 1;

        //Determing if Feb has 28 or 29 days in it.  
        if (month == 1) {
            if ((year % 100 != 0) && (year % 4 == 0) || (year % 400 == 0)) {
                totalFeb = 29;
            } else {
                totalFeb = 28;
            }
        }

        //////////////////////////////////////////
        // Setting up arrays for the name of    //
        // the	months, days, and the number of	//
        // days in the month.                   //
        //////////////////////////////////////////

        //var monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        //var dayNames = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thrusday", "Friday", "Saturday"];
        var totalDays = ["31", "" + totalFeb + "", "31", "30", "31", "30", "31", "31", "30", "31", "30", "31"];

        //////////////////////////////////////////
        // Temp values to get the number of days//
        // in current month, and previous month.//
        // Also getting the day of the week.	//
        //////////////////////////////////////////

        //var tempDate = new Date(year, tempMonth, 1);
        //var tempDate = new Date(tempMonth + ' 1 ,' + year);
        var tempDate = moment(year + '-' + tempMonth + '-01 00:00', 'YYYY-MM-DD HH:mm').toDate();
        
        //alert("tempDate: " + tempDate);
        var tempweekday = tempDate.getDay();
        var tempweekday2 = tempweekday;
        var dayAmount = totalDays[month];
        //var preAmount = totalDays[prevMonth] - tempweekday + 1;	

        //////////////////////////////////////////////////
        // After getting the first day of the week for	//
        // the month, padding the other days for that	//
        // week with the previous months days.  IE, if	//
        // the first day of the week is on a Thursday,	//
        // then this fills in Sun - Wed with the last	//
        // months dates, counting down from the last	//
        // day on Wed, until Sunday.                    //
        //////////////////////////////////////////////////

        var calendarWeek = {};
        calendarWeek.days = new Array();
        while (tempweekday > 0) {
            padding += "<td class=\"slds-disabled-text\" headers=\"\" role=\"gridcell\" aria-disabled=\"true\"></td>";
            
            var calendarDay = {};
            calendarDay.label = "";
            calendarDay.classes = "slds-disabled-text";
            calendarDay.isAriaDisabled = "true";
            
            calendarWeek.days.push(calendarDay);

            tempweekday--;
        }

        //////////////////////////////////////////////////
        // Filling in the calendar with the current     //
        // month days in the correct location along.    //
        //////////////////////////////////////////////////
        
        while (i <= dayAmount) {

            //////////////////////////////////////////
            // Determining when to start a new row	//
            //////////////////////////////////////////

            if (tempweekday2 > 6) {
                tempweekday2 = 0;
                padding += "</tr><tr>";

                calendarWeeks.push(calendarWeek);
                calendarWeek = {};
            	calendarWeek.days = new Array();
            }

            //////////////////////////////////////////////////////////////////////////////////////////////////
            // checking to see if i is equal to the current day, if so then we are making the color of //
            //that cell a different color using CSS. Also adding a rollover effect to highlight the  //
            //day the user rolls over. This loop creates the acutal calendar that is displayed.		//
            //////////////////////////////////////////////////////////////////////////////////////////////////
			
            var tdClasses = "";
            var isAriaSelected = "false";
            var isAriaDisabled = "false";
            if (i == cday && month == cmonth) {
                tdClasses += " slds-is-today slds-disabled-text";
                isAriaDisabled = "true";
            } else if (i == (selectedDateDay) && month == selectedDateMonth) {
                tdClasses += " slds-is-selected";
                isAriaSelected = "true";
            } else if( i < cday && month <= cmonth && year <= cyear ) {
            	tdClasses += " slds-disabled-text";
                isAriaDisabled = "true";
            }
            
            padding += "<td class=\"" + tdClasses + "\" headers=\"Sunday\" role=\"gridcell\" aria-disabled=\"" + isAriaDisabled + "\" aria-selected=\"" + isAriaSelected + "\"><span class=\"slds-day\">" + i + "</span></td>";
			var calendarDay = {};
            calendarDay.label = i;
            calendarDay.classes = tdClasses;
            calendarDay.isAriaSelected = isAriaSelected;
            calendarDay.isAriaDisabled = isAriaDisabled;
            
            calendarWeek.days.push(calendarDay);
            
            tempweekday2++;
            i++;
        }
        
        calendarWeeks.push(calendarWeek);


        /////////////////////////////////////////
        // Ouptputing the calendar onto the	//
        // site.  Also, putting in the month	//
        // name and days of the week.		//
        /////////////////////////////////////////

        var calendarTable = padding;
        
        /*if( document.getElementById("expireCalBody") !== null ) {
        	document.getElementById("expireCalBody").innerHTML = calendarTable;
        }*/
        
        component.set("v.calendarWeeks", calendarWeeks);
    }
    
    /*,
    
    reloadComponent: function() {
   		window.location.reload();
    }*/
})