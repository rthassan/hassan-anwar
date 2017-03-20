({
    doInit : function(component, event, helper) {
        //alert("doInit");
        "use strict";
        
        var isIe11 = ( navigator.userAgent.match(/rv:11.0/i) !== null );   
        component.set("v.isIe11", isIe11);
        
        var isSafari = /^((?!chrome|android).)*safari/i.test(navigator.userAgent);
        component.set("v.isSafari", isSafari);
        
        var isMacOs = ( navigator.userAgent.match(/Mac OS/i) !== null );
        component.set("v.isMacOs", isMacOs);
        
        var isFirefox = ( navigator.userAgent.match(/Firefox/i) !== null );
        component.set("v.isFirefox", isFirefox);
		
        helper.initSettings(component);
		helper.initAgreement(component);
		helper.initSchema(component);
	},
    
    afterScriptsLoaded : function(component, event, helper) {
        //alert("afterScriptsLoaded: ");
        $jquery = jQuery.noConflict();
        //try { helper.initPageCustom(component); } catch(err) { alert("error afterScriptsLoaded: " + err); }
        //component.set("v.jquery", jquery);
        //svg4everybody();
        // add meta-http-equiv to the <head>
		//$jquery('head').append('<meta http-equiv="x-ua-compatible" content="ie=edge">');
		// start the svg4everybody helper
		//$jquery('body').append('<script>svg4everybody();</script>');
	},
    
    afterPageLoaded : function(component, event, helper) {
        //alert("afterPageLoaded");
        helper.initPageCustom(component);
	},
    
    initPageCustom : function(component, event, helper) {
        //alert("initPageCustom");
        helper.initSortable(component, helper);
        helper.initListeners(component, helper);
        helper.initComponents(component, helper);
	},
    
    dismissAlert : function(component, event, helper) {
        component.set("v.errorMessage", null);
    },
    
    dismissErrorMessage : function(component, event, helper) {  
        var agreementWrapper = component.get("v.agreementWrapper");      
        var agreement = agreementWrapper.agreement;
        
        helper.setFieldValue(component, agreement, "ErrorMessage__c", null);
        component.set("v.agreementWrapper", agreementWrapper);
    },
    
    onSelectESignatureType : function(component, event, helper) {
        helper.selectSignatureType(component, "e-Signature");
    },

    onSelectFaxSignatureType : function(component, event, helper) {
        helper.selectSignatureType(component, "Written Signature");
    },
    
	onTemplateSelected : function(component, event, helper) {
        var selectedTemplateWrappers = event.getParam("selectedTemplateWrappers");
        var isCanceled = event.getParam("isCanceled");
        
        if( isCanceled ) {
            component.set("v.isShowAddTemplatesDialog", false);
            return;
        }
        
        helper.addSelectedTemplates(component, selectedTemplateWrappers);
	},
    
	onDocumentSelected : function(component, event, helper) {
        var uploadedFileWrappers = event.getParam("uploadedFileWrappers");
        var selectedContentWrappers = event.getParam("selectedContentWrappers");
        var selectedDocumentWrappers = event.getParam("selectedDocumentWrappers");
        var selectedLibraryDocumentWrappers = event.getParam("selectedLibraryDocumentWrappers");
        var isCanceled = event.getParam("isCanceled");
        
        if( isCanceled ) {
            component.set("v.isShowAddDocumentsDialog", false);
            return;
        }
        
        helper.addSelectedFiles(component, uploadedFileWrappers, selectedContentWrappers, selectedDocumentWrappers, selectedLibraryDocumentWrappers);
	},
    
	addRecipient : function(component, event, helper) {
        helper.addRecipient(component);
	},
    
    addRecipientMe : function(component, event, helper) {
        helper.addRecipientMe(component);
	},
    
	sendAgreement : function(component, event, helper) {
        helper.saveSendForSignature(component);
	},
      
	hostAgreement : function(component, event, helper) {
        helper.hostAgreement(component);
	},
    
	sendReminder : function(component, event, helper) {
        helper.sendReminder(component);
	},
     
	updateAgreement : function(component, event, helper) {
        helper.updateAgreement(component);
	},
    
    viewAgreement : function(component, event, helper) {
        helper.viewAgreement(component);
	},
    
    cancelAgreement : function(component, event, helper) {
        helper.cancelAgreement(component);
	},
    
    deleteAgreement : function(component, event, helper) {
        helper.deleteAgreement(component);
	},
    
	saveAgreement : function(component, event, helper) {
        helper.saveAgreement(component);
    },
    
	viewDocument : function(component, event, helper) {
        var documentIndex = event.target.dataset.order;
        helper.viewDocument(component, documentIndex);
    },
        
    viewUploadedDocument : function(component, event, helper) {
        var documentIndex = event.target.dataset.order;
        helper.viewUploadedDocument(component, documentIndex);
    },
    
	deleteTemplate : function(component, event, helper) {
        var templateIndex = event.target.dataset.order;
        helper.deleteTemplate(component, templateIndex);
    },
    
	deleteDocument : function(component, event, helper) {
        var documentIndex = event.target.dataset.order;
        helper.deleteDocument(component, documentIndex);
    },
    
    deleteRecipient : function(component, event, helper) {
        var recipientIndex = event.target.dataset.order;
        helper.deleteRecipient(component, recipientIndex);
    },
    
    reorderRecipient : function(component, event, helper) {
        var recipientIndex = event.target.dataset.order;
        var recipientNewOrder = event.target.value;
        helper.reorderRecipient(component, recipientIndex, recipientNewOrder);
    },
    
    onSelectSignerRole : function(component, event, helper) {
        var recipientIndex = helper.getNestedOrderValue(event);
		helper.selectSignerRole(component, recipientIndex, "Signer");
    },
    
    onSelectApproverRole : function(component, event, helper) {
        var recipientIndex = helper.getNestedOrderValue(event);
		helper.selectSignerRole(component, recipientIndex, "Approver");
    },
    
    onSelectDelegateSignerRole : function(component, event, helper) {
        var recipientIndex = helper.getNestedOrderValue(event);
		helper.selectSignerRole(component, recipientIndex, "Delegate to Signer");
    },
    
    onSelectDelegateApproverRole : function(component, event, helper) {
        var recipientIndex = helper.getNestedOrderValue(event);
		helper.selectSignerRole(component, recipientIndex, "Delegate to Approver");
    },
    
    onSignDeadlinePrevMonth : function(component, event, helper) {
		helper.moveDeadlineDate(component, "Previous");
    },
    
    onSignDeadlineNextMonth : function(component, event, helper) {
		helper.moveDeadlineDate(component, "Next");
    },
    
    selectAgreementDeadline : function(component, event, helper) {
        var month = component.get("v.expirePickerSelectedMonthValue");
        var year = component.get("v.expirePickerSelectedYearValue");
        var day = event.target.dataset.order;
        
        helper.setAgreementDeadline(component, year, month, day);
    },
     
    editAgreementDeadline : function(component, event, helper) {
        var deadlineValue = component.get("v.agreementWrapper.signingDeadlineFormatted")
        //alert("deadlineValue: " + deadlineValue);
        
        if( !deadlineValue ) {
        	helper.setAgreementDeadline(component, null, null, null); 
        } else {
        	var deadlineDate = new Date(deadlineValue);
        	helper.setAgreementDeadline(component, deadlineDate.getFullYear(), deadlineDate.getMonth(), deadlineDate.getDate());     
        }
    },
    
    onTooltipOver : function(component, event, helper) {
        //var tooltipElemId = helper.getNestedOrderValue(event);
        //helper.showElemVisibility(tooltipElemId);
    },
    
    onTooltipOut : function(component, event, helper) {
        //var tooltipElemId = helper.getNestedOrderValue(event);
        //helper.hideElemVisibility(tooltipElemId);
    },
    
    selectSignInOrder : function(component, event, helper) {
		helper.selectSignOrder(component, "Sign in Order");
    }, 
    
    selectSignInAnyOrder : function(component, event, helper) {
		helper.selectSignOrder(component, "Sign in Any Order");
    },
    
    selectOnlyISign : function(component, event, helper) {
		helper.selectSignOrder(component, "Only I Sign");
    },
    
    onSelectContactRecipientType : function(component, event, helper) {
        var recipientIndex = helper.getNestedOrderValue(event);
        helper.selectRecipientType(component, recipientIndex, "Contact");
    },
    
    onSelectLeadRecipientType : function(component, event, helper) {
        var recipientIndex = helper.getNestedOrderValue(event);
        helper.selectRecipientType(component, recipientIndex, "Lead");
    },
    
    onSelectUserRecipientType : function(component, event, helper) {
        var recipientIndex = helper.getNestedOrderValue(event);
        helper.selectRecipientType(component, recipientIndex, "User");
    },
    
    onSelectGroupRecipientType : function(component, event, helper) {
        var recipientIndex = helper.getNestedOrderValue(event);
        helper.selectRecipientType(component, recipientIndex, "Group");
    },
    
    onSelectEmailRecipientType : function(component, event, helper) {
        var recipientIndex = helper.getNestedOrderValue(event);
        helper.selectRecipientType(component, recipientIndex, "Email");
    },
    
    onReplaceRecipientMessageChange : function(component, event, helper) {
        helper.changeReplaceRecipient(component);
    },

    onSelectContactReplaceRecipientType : function(component, event, helper) {
        helper.selectRecipientType(component, "Contact");
    },
    
    onSelectLeadReplaceRecipientType : function(component, event, helper) {
        helper.selectReplaceRecipientType(component, "Lead");
    },
    
    onSelectUserReplaceRecipientType : function(component, event, helper) {
        helper.selectReplaceRecipientType(component, "User");
    },
    
    onSelectEmailReplaceRecipientType : function(component, event, helper) {
        helper.selectReplaceRecipientType(component, "Email");
    },
    
    onReplaceRecipientSubmit : function(component, event, helper) {
        helper.replaceRecipientSubmit(component);
    },
    
    onOpenRecipientMessage : function(component, event, helper) {
        var isSent = component.get("v.isSent");
        if( isSent ) {
            return;
        }
        
        var recipientIndex = event.target.dataset.order;
        helper.openRecipientMessage(component, recipientIndex);
    },
    
    onSetRecipientMessage : function(component, event, helper) {
        helper.setRecipientMessage(component);
    },
    
    toggleRecipientMessageDialog : function(component, event, helper) {
        helper.toggleElemVisibility("recipientMessageDialog");
    },
    
    toggleReminder : function(component, event, helper) {
        var isSent = component.get("v.isSent");
        var settingsWrapper = component.get("v.settingsWrapper");
        if( isSent || helper.getFieldValue(component, settingsWrapper.customSettings, "Read_Only_Sign_Reminder__c") ) {
            return;
        }
        
        helper.toggleInputComponent(component, "reminderDropdown");
    },
    
    toggleLanguage : function(component, event, helper) {
        var isSent = component.get("v.isSent");
        var settingsWrapper = component.get("v.settingsWrapper");
        if( isSent || helper.getFieldValue(component, settingsWrapper.customSettings, "Read_Only_Language__c") ) {
            return;
        }
        
        helper.toggleInputComponent(component, "languageDropdown");
    },
    
    togglePostSignUrlProtocol : function(component, event, helper) {
        var isSent = component.get("v.isSent");
        var settingsWrapper = component.get("v.settingsWrapper");
        if( isSent || helper.getFieldValue(component, settingsWrapper.customSettings, "Read_Only_Post_Sign_Options__c") ) {
            return;
        }
        
        helper.toggleInputComponent(component, "postSignUrlProtocolDropdown");
    },
    
    toggleRecipientType : function(component, event, helper) {
        var isSent = component.get("v.isSent");
        var settingsWrapper = component.get("v.settingsWrapper");
        if( isSent || helper.getFieldValue(component, settingsWrapper.customSettings, "Read_Only_Recipient__c") ) {
            return;
        }
        
        var recipientIndex = helper.getNestedOrderValue(event);
        helper.toggleElemVisibility( "recipientTypeDropdown" + recipientIndex );
    },
    
    toggleReplaceRecipientType : function(component, event, helper) {
        helper.toggleElemVisibility( "replaceRecipientTypeDropdown");
    },
    
    toggleRecipientRole : function(component, event, helper) {
        var recipientIndex = helper.getNestedOrderValue(event);
        helper.toggleInputComponent(component, "recipientRoleDropdown" + recipientIndex);
    },
    
    toggleDeadline : function(component, event, helper) {
        var isSent = component.get("v.isSent");
        var settingsWrapper = component.get("v.settingsWrapper");
        if( isSent || helper.getFieldValue(component, settingsWrapper.customSettings, "Read_Only_Sign_Expiration__c") ) {
            return;
        }
        
        helper.toggleInputComponent(component, "deadlineDate");
    },
    
    toggleRecipientVerificationType : function(component, event, helper) {
        helper.toggleElemVisibility("recipientVerificationTypeDropdown");
    },
    
    toggleRecipientAddress : function(component, event, helper) {
        helper.toggleInputComponent(component, "recipientAddressDropdown");
    },
    
    hideReplaceRecipientDialog : function(component, event, helper) {
        helper.hideElemVisibility("replaceRecipientDialog");
    }, 
    
    toggleReplaceRecipientDialog : function(component, event, helper) {
        var recipientIndex = helper.getNestedOrderValue(event);
        helper.createReplaceRecipient(component, recipientIndex);
        helper.toggleElemVisibility("replaceRecipientDialog");
    }, 
    
    selectRecipientEmailAddress : function(component, event, helper) {
        var recipientIndex = helper.getNestedOrderValue(event);
        helper.selectRecipientAddress(component, recipientIndex, "email");
    },
    
    selectRecipientFaxAddress : function(component, event, helper) {
        var recipientIndex = helper.getNestedOrderValue(event);
        helper.selectRecipientAddress(component, recipientIndex, "fax");
    },
    
    addCc : function(component, event, helper) {
        var agreementWrapper = component.get("v.agreementWrapper");
        agreementWrapper.isCcSet = true;
        
        component.set("v.agreementWrapper", agreementWrapper);
    },
    
    toggleSignOrder : function(component, event, helper) {
        var settingsWrapper = component.get("v.settingsWrapper");
        if( helper.getFieldValue(component, settingsWrapper.customSettings, "Read_Only_Sender_Signs_Only__c") ||
          	helper.getFieldValue(component, settingsWrapper.customSettings, "Read_Only_Recipient_Signing_Order_Field__c") ) {
            return;
        }
        
        helper.toggleInputComponent(component, "signOrderDropdown");
    },
    
    toggleInProgressActions : function(component, event, helper) {
        helper.toggleElemVisibility("inProgressActionsDropdown");
    },
    
    toggleInAuthoringActions : function(component, event, helper) {
        helper.toggleElemVisibility("inAuthoringActionsDropdown");
    },
    
    toggleCancelAgreementDialog : function(component, event, helper) {
        helper.toggleElemVisibility("cancelAgreementDialog");
    },
     
    toggleDeleteAgreementDialog : function(component, event, helper) {
        helper.toggleElemVisibility("deleteAgreementDialog");
    },
    
    toggleAddDocumentsDialog : function(component, event, helper) {
        //helper.toggleElemVisibility("addDocumentsDialog");
        component.set("v.isShowAddDocumentsDialog", true);
    },
    
    toggleAddTemplatesDialog : function(component, event, helper) {
        component.set("v.isShowAddTemplatesDialog", true);
    },
    
    onSelectRecipientCountryCode : function(component, event, helper) {
        var countryCode = event.target.dataset.order;
        var recipientIndex = event.target.parentElement.dataset.order;
		helper.selectRecipientCountryCode(component, countryCode, recipientIndex);
    },
    
    storeRecipientVerification : function(component, event, helper) {
        var recipientIndex = event.target.dataset.order;
		helper.storeRecipientVerification(component, recipientIndex);
    },
    
    openRecipientVerificationDialog : function(component, event, helper) {
        var recipientIndex = event.target.dataset.order;
		helper.openRecipientVerificationDialog(component, recipientIndex);
    },
  
    closeRecipientVerificationDialog : function(component, event, helper) {
        helper.hideElemVisibility("recipientVerificationDialog");
    },
    
    toggleRecipientVerificationSelection : function(component, event, helper) {
        helper.toggleInputComponent(component, "recipientVerificationDropdown");
    },
    
    onRecipientEmailVerificationSelection : function(component, event, helper) {
        var recipientIndex = event.target.dataset.order;
        helper.selectRecipientVerification(component, recipientIndex, "recipientVerificationDropdown", "Email");
    },
    
    onRecipientKbaVerificationSelection : function(component, event, helper) {
        var recipientIndex = event.target.dataset.order;
        helper.selectRecipientVerification(component, recipientIndex, "recipientVerificationDropdown", "KBA");
    },
    
    onRecipientSocialVerificationSelection : function(component, event, helper) {
        var recipientIndex = event.target.dataset.order;
        helper.selectRecipientVerification(component, recipientIndex, "recipientVerificationDropdown", "Social");
    },
    
    onRecipientPasswordVerificationSelection : function(component, event, helper) {
        var recipientIndex = event.target.dataset.order;
        helper.selectRecipientVerification(component, recipientIndex, "recipientVerificationDropdown", "Password");
    },
    
    onRecipientPhoneVerificationSelection : function(component, event, helper) {
        var recipientIndex = event.target.dataset.order;
        helper.selectRecipientVerification(component, recipientIndex, "recipientVerificationDropdown", "Phone");
    },
    
    toggleRecipientVerificationCountry : function(component, event, helper) {
        helper.toggleInputComponent(component, "recipientVerificationCountryDropdown");
    },
    
    toggleAgreementVerificationSelection : function(component, event, helper) {
        var isSent = component.get("v.isSent");
        var settingsWrapper = component.get("v.settingsWrapper");
        if( isSent || helper.getFieldValue(component, settingsWrapper.customSettings, "Read_Only_Security_Options__c") ) {
            return;
        }
        
        helper.toggleInputComponent(component, "agreementVerificationDropdown");
    },
    
    toggleAgreementInternalVerificationSelection : function(component, event, helper) {
        var isSent = component.get("v.isSent");
        var settingsWrapper = component.get("v.settingsWrapper");
        if( isSent || helper.getFieldValue(component, settingsWrapper.customSettings, "Read_Only_Security_Options__c") ) {
            return;
        }
        
        helper.toggleInputComponent(component, "agreementInternalVerificationDropdown");
    },
    
    toggleAgreementExternalVerificationSelection : function(component, event, helper) {
        var isSent = component.get("v.isSent");
        var settingsWrapper = component.get("v.settingsWrapper");
        if( isSent || helper.getFieldValue(component, settingsWrapper.customSettings, "Read_Only_Security_Options__c") ) {
            return;
        }
        
        helper.toggleInputComponent(component, "agreementExternalVerificationDropdown");
    },
    onAgreementEmailVerificationSelection : function(component, event, helper) {
        helper.selectAgreementVerification(component, "Email", null);
    },
    
    onAgreementKbaVerificationSelection : function(component, event, helper) {
        helper.selectAgreementVerification(component, "KBA", null);
    },
    
    onAgreementSocialVerificationSelection : function(component, event, helper) {
        helper.selectAgreementVerification(component, "Social", null);
    },
    
    onAgreementPasswordVerificationSelection : function(component, event, helper) {
        helper.selectAgreementVerification(component, "Password", null);
    },
    
    onAgreementEmailInternalVerificationSelection : function(component, event, helper) {
        helper.selectAgreementVerification(component, "Email", "Internal");
    },
    
    onAgreementKbaInternalVerificationSelection : function(component, event, helper) {
        helper.selectAgreementVerification(component, "KBA", "Internal");
    },
    
    onAgreementSocialInternalVerificationSelection : function(component, event, helper) {
        helper.selectAgreementVerification(component, "Social", "Internal");
    },
    
    onAgreementPasswordInternalVerificationSelection : function(component, event, helper) {
        helper.selectAgreementVerification(component, "Password", "Internal");
    },
    
    onAgreementEmailExternalVerificationSelection : function(component, event, helper) {
        helper.selectAgreementVerification(component, "Email", "External");
    },
    
    onAgreementKbaExternalVerificationSelection : function(component, event, helper) {
        helper.selectAgreementVerification(component, "KBA", "External");
    },
    
    onAgreementSocialExternalVerificationSelection : function(component, event, helper) {
        helper.selectAgreementVerification(component, "Social", "External");
    },
    
    onAgreementPasswordExternalVerificationSelection : function(component, event, helper) {
        helper.selectAgreementVerification(component, "Password", "External");
    },
    
    setAgreementViewPasswordToggleEnable : function(component, event, helper) {
        helper.setAgreementViewPasswordProcess(component, event, false);
    },
    
    setAgreementViewPassword : function(component, event, helper) {
        helper.setAgreementViewPasswordProcess(component, event, true);
    },
    
    setAgreementSignPasswordToggleEnable : function(component, event, helper) {
        helper.setAgreementSignPasswordProcess(component, event, false);
    },
    
    setAgreementSignPassword : function(component, event, helper) {
        helper.setAgreementSignPasswordProcess(component, event, true);
    },
   
    setRecipientSignPasswordProcess : function(component, event, helper) {
        helper.setRecipientSignPasswordProcess(component, event, true);
    },
    
    onSenderSignsClick : function(component, event, helper) {
        var isSent = component.get("v.isSent");
        var settingsWrapper = component.get("v.settingsWrapper");
        if( isSent || helper.getFieldValue(component, settingsWrapper.customSettings, "Read_Only_Sender_Signs__c") ) {
            return;
        }
        
        var agreementWrapper = component.get("v.agreementWrapper");
        
        if( component.get("v.agreementSenderSigns") ) {
            agreementWrapper.agreementSenderSigns = "Sign Last";
		} else {
            agreementWrapper.agreementSenderSigns = null;   
       	}
          
        component.set("v.agreementWrapper", agreementWrapper);
    },
    
    toggleSenderSigns : function(component, event, helper) {
        var isSent = component.get("v.isSent");
        if( isSent ) {
            return;
        }
        
		helper.toggleElemVisibility("senderSignsDropdown");
    },
    
    selectSenderSignsOrder : function(component, event, helper) {
        var signingOrder = event.target.dataset.order;
        
        var agreementWrapper = component.get("v.agreementWrapper");
        
        agreementWrapper.agreementSenderSigns = signingOrder;
        
        if( agreementWrapper.agreementSenderSigns == "Sign First" ) {
            agreementWrapper.agreementSenderSignsLabel = $A.get("$Label.echosign_dev1.Agreement_Editor_Sign_First_Label ");
        } else if( agreementWrapper.agreementSenderSigns == "Sign Last" ) {
            agreementWrapper.agreementSenderSignsLabel = $A.get("$Label.echosign_dev1.Agreement_Editor_Sign_Last_Label ");
        }
        
        component.set("v.agreementWrapper", agreementWrapper);
        
		helper.toggleElemVisibility("senderSignsDropdown");
    },
    
    deleteSenderSigns : function(component, event, helper) {
        var agreementWrapper = component.get("v.agreementWrapper");
        
        agreementWrapper.agreementSenderSigns = null;
        
        component.set("v.agreementSenderSigns", false);
        component.set("v.agreementWrapper", agreementWrapper);
    },
    
    searchRecipient : function(component, event, helper) {
        var recipientIndex = helper.getNestedOrderValue(event);  
                
       	if( !recipientIndex ) {
            return;
        }
        
        var targetId = "recipientInputLookup";
        var searchResultsRecordId = "recipientSearchResults" + recipientIndex;
        
        var agreementWrapper = component.get("v.agreementWrapper");
        var recipientWrapper = agreementWrapper.recipientWrappers[recipientIndex];
        var recipientType = helper.getFieldValue(component, recipientWrapper.recipient, "Recipient_Type__c");
        
        helper.searchSObjects(component, helper, targetId, recipientType, searchResultsRecordId);
    },
    
    searchReplaceRecipient : function(component, event, helper) {
        var targetId = "replaceRecipientInputLookup";
        var searchResultsRecordId = "replaceRecipientSearchResults";
        
        var recipientWrapper = component.get("v.replacementRecipientWrapper");
        var recipientType = helper.getFieldValue(component, recipientWrapper.recipient, "Recipient_Type__c");
        
        helper.searchSObjects(component, helper, targetId, recipientType, searchResultsRecordId);
    },
    
    selectPostSignUrlProtocol  : function(component, event, helper) {
        var selectedProtocol = event.target.dataset.order;
        
        var agreementWrapper = component.get("v.agreementWrapper");
        agreementWrapper.agreementPostSignUrlProtocol = selectedProtocol;
        component.set("v.agreementWrapper", agreementWrapper);
        
        helper.toggleElemVisibility("postSignUrlProtocolDropdown");
    },
    
    selectAgreementReminder : function(component, event, helper) {
        var selectedReminder = event.target.dataset.order;
        
        component.set("v.agreementReminder", selectedReminder);
        if( selectedReminder == "Every Day, Until Signed" ) {
        	component.set("v.agreementReminderLabel", $A.get("$Label.echosign_dev1.Agreement_Editor_Reminder_Every_Day_Label"));         
        } else if( selectedReminder == "Every Week, Until Signed" ) {
        	component.set("v.agreementReminderLabel", $A.get("$Label.echosign_dev1.Agreement_Editor_Reminder_Every_Week_Label"));
        } else {
        	component.set("v.agreementReminderLabel", $A.get("$Label.echosign_dev1.Agreement_Editor_Reminder_Never_Label"));
        }
        
        helper.toggleElemVisibility("reminderDropdown");
    },
    
    selectAgreementLanguage : function(component, event, helper) {
        var selectedLanguage = event.target.dataset.order;
        
     	component.set("v.agreementLanguage", selectedLanguage);
        
        var schemaWrapper = component.get("v.schemaWrapper");
        
        for( var i = 0; i < schemaWrapper.agreementLanguageOptions.length; i++ ) {
            if( schemaWrapper.agreementLanguageOptions[i].value == selectedLanguage ) {
                component.set("v.agreementLanguageLabel", schemaWrapper.agreementLanguageOptions[i].label);
                break;
            }
        }
        
        helper.toggleElemVisibility("languageDropdown");
    },
    
    selectAccountSearchResult : function(component, event, helper) {
        var selectedResultRecordId = event.target.dataset.order;
        
        helper.setAgreementParentSearchResult(component, selectedResultRecordId, "account");
    },
    
    selectOppSearchResult : function(component, event, helper) {
        var selectedResultRecordId = event.target.dataset.order;
        
        helper.setAgreementParentSearchResult(component, selectedResultRecordId, "opportunity");
    },
    
    selectContractSearchResult : function(component, event, helper) {
        var selectedResultRecordId = event.target.dataset.order;
        
        helper.setAgreementParentSearchResult(component, selectedResultRecordId, "contract");
    },
    
    searchAccount : function(component, event, helper) {
        var targetId = "accountInputLookup";
        var searchResultsRecordId = "accountSearchResults";
        
        helper.searchSObjects(component, helper, targetId, "account", searchResultsRecordId);
    },
    
    searchOpp : function(component, event, helper) {
        var targetId = "oppInputLookup";
        var searchResultsRecordId = "opportunitySearchResults";
        
        helper.searchSObjects(component, helper, targetId, "opportunity", searchResultsRecordId);
    },
    
    searchContract : function(component, event, helper) {
        var targetId = "contractInputLookup";
        var searchResultsRecordId = "contractSearchResults";
        
        helper.searchSObjects(component, helper, targetId, "contract", searchResultsRecordId);
    },
    
    selectDayReminderOption : function(component, event, helper) {
        helper.selectDayReminderOption(component);
    },
    
    navToMyself : function(component, event, helper) {
        var agreementWrapper = component.get("v.agreementWrapper");
        helper.navigateToSObject( agreementWrapper.contextUserId );
    },
    
    navToRecipient : function(component, event, helper) {
        var recipientIndex = event.target.dataset.order;
		helper.navToRecipientRefRecord(component, recipientIndex);
    },
    
    navToReplaceRecipient : function(component, event, helper) {
		helper.navToReplaceRecipientRefRecord(component);
    },
    
    navToAccount : function(component, event, helper) {
        var agreementWrapper = component.get("v.agreementWrapper");
        helper.navigateToSObject( helper.getFieldValue(component, agreementWrapper.agreement, "Account__c") );
    },
    
    navToOpp : function(component, event, helper) {
        var agreementWrapper = component.get("v.agreementWrapper");
        
        helper.navigateToSObject( helper.getFieldValue(component, agreementWrapper.agreement, "Opportunity__c") );
    },
    
    navToContract : function(component, event, helper) {
        var agreementWrapper = component.get("v.agreementWrapper");
        
        helper.navigateToSObject( helper.getFieldValue(component, agreementWrapper.agreement, "Contract__c") );
    },
    
    viewSignedDocumentLink : function(component, event, helper) {
        var agreementWrapper = component.get("v.agreementWrapper");
        
        helper.navToUrl( helper.getFieldValue(component, agreementWrapper.agreement, "SignedPDF__c") );
    },
    
    selectRecipientSearchResult : function(component, event, helper) {
        var selectedResultRecordId = event.target.dataset.order;
        var recipientIndex = event.target.parentElement.parentElement.dataset.order;
        
        helper.setRecipientSearchResult(component, recipientIndex, selectedResultRecordId);
    },
    
    selectReplaceRecipientSearchResult : function(component, event, helper) {
        var selectedResultRecordId = event.target.dataset.order;
        helper.setReplaceRecipientSearchResult(component, selectedResultRecordId);
    },
    
    selectUnsetRecipient : function(component, event, helper) {
        var recipientIndex = helper.getNestedOrderValue(event);
        helper.unsetRecipient(component, recipientIndex);
    },
    
    selectUnsetReplaceRecipient : function(component, event, helper) {
        helper.unsetReplaceRecipient(component);
    },
    
    selectUnsetAccount : function(component, event, helper) {
        helper.unsetAccount(component);
    },
    
    selectUnsetOpp : function(component, event, helper) {
        helper.unsetOpp(component);
    },
    
    selectUnsetContract : function(component, event, helper) {
        helper.unsetContract(component);
    }
    
    /*,
    
    dismissAlert : function(component, evt, helper){      
       	component.set("v.isSaved", false);
        component.set("v.isError", false);
        component.set("v.isNotProcessing", true);
    }*/
})