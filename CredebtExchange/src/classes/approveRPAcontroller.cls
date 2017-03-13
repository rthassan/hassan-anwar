public with sharing class approveRPAcontroller {
    
    public Opportunity opp {get; set;}
    public Account acc {get; set;}
    public contact con {get; set;}
    public List<credit_history__c> creditHistories {get; set;}
    
    public List<selectOption> oppContacts {get; set;}
    public String selectedTo {get; set;}
    public String selectedCC {get; set;}
    
    public approveRPAcontroller(apexpages.StandardController control){
        
        opp = [SELECT Id, Name, AccountId, currencyISOcode, c_ETR_Required__c, o_ETR__c, d_ETR_Required__c, a_ETR__c, c_ETR_Discount_Value__C,c_ETR_Discount__c, c_ETR_Deposit__c, d_ETR_Sell_Rate__c, 
               Monthly_Fee__c, Arrangement_Fee__c, Processing_Commission__c,  Revolving_Purchase__c, Purchase_Payment__c, specific_conditions__c, 
               posting_fee__c, debtors_rating_fee__c, digi_access_fee__c,  first_repayment__c, repayment_every__c, settled_within__c, ATR_Calculated__c, no_ATR__c, average_DSO__c
               FROM Opportunity WHERE Id = :control.getId()];
        acc = [SELECT Id, BillingStreet, BillingCity, BillingState, BillingPostalCode, BillingCountry, Name FROM Account WHERE Id = :opp.AccountID];
        OpportunityContactRole c = [SELECT Id, ContactId FROM OpportunityContactRole WHERE OpportunityId = :opp.Id and IsPrimary = true];
        con = [SELECT Id, Email, Salutation, Name, FirstName, lastName FROM Contact WHERE Id = :c.ContactId];        
        creditHistories = [SELECT Id, credit_data_provider__c, credit_limit__c, Creditsafe_Rating__c, Y_E_Trade_Creditors__c, Y_E_Trade_debtors__c, createdDate, As_at_date__c FROM Credit_History__c WHERE Originator__c = :acc.Id ORDER BY As_At_date__c DESC ];
        
        oppContacts = new List<selectOption>();
        for(opportunityContactRole ocr : [SELECT Id, ContactId, contact.Name, Role FROM OpportunityContactRole WHERE OpportunityId = :opp.Id]){
            oppContacts.add(new selectOption(ocr.contactId, ocr.contact.Name));
        }
    }
    
    
    public pageReference sendOffer(){
        //Select contacts
        List<contact> toContacts = new List<contact>();
        List<contact> ccContacts = new List<contact>();
        if(selectedTo != '' && selectedTo != null){
            toContacts = [SELECT Id, Name FROM Contact WHERE Id IN :selectedTo.mid(1,selectedTo.length()-2).deleteWhitespace().split(',')];
        }
        if(selectedCC != '' && selectedCC != null){
            ccContacts = [SELECT Id, Name FROM Contact WHERE Id IN :selectedCC.mid(1,selectedCC.length()-2).deleteWhitespace().split(',')];
        }
        
        //pdf attachment        
        PageReference pdf = Page.provisionalRpaOfferPDF;
        pdf.getParameters().clear();
        pdf.getParameters().put('id', (string)opp.Id);        
        pdf.setRedirect(true);        
        //system.debug(pdf);        
        Blob b;
        try{
            system.debug(pdf);
            b = pdf.getContent();
            system.debug(pdf);
        }catch(VisualforceException e){
            b = Blob.valueOf('catch');
        }
        system.debug(b);
        Messaging.EmailFileAttachment efa = new Messaging.EmailFileAttachment();
        user currentUser = [SELECT ContactId, AccountId FROM User WHERE Id = :UserInfo.getUserId()];
        
        string attachmentName =  'RPA Offer.pdf';        
        efa.setFileName(attachmentName);
        efa.setContentType('application/pdf');
        efa.setBody(b);
        efa.setInline(false);
        
        String userAccountName;
        User u = [select firstname, lastname, ContactId, AccountId, title, department, Phone, mobilePhone, Email, street, city, state from user where id=:userinfo.getuserid()];
        
        string username = u.firstname + ' ' +u.lastname;
        String subject = acc.Name + ' RPA Offer ';    
        
        Id templateId;
        if(opp.Specific_Conditions__c){
            templateId = [SELECT Id FROM emailTemplate WHERE Name = 'RPA Offer Specific' LIMIT 1][0].Id;
        }else if(!opp.Specific_Conditions__c){
            templateId = [SELECT Id FROM emailTemplate WHERE Name = 'RPA Offer' LIMIT 1][0].Id;
        }
        
        List<emailServicesAddress> esa = new List<emailServicesAddress>();
        esa = [SELECT Id, localpart, emailDomainName FROM emailServicesAddress WHERE function.functionName = 'rpaConfirmation'];
        String replyTo = '';
        if(esa.size() > 0){
            replyTo = esa[0].LocalPart + '@' + esa[0].EmailDomainName;
        }
        system.debug(replyTo);
        
        List<messaging.SingleEmailMessage> emails = new List<messaging.SingleEmailMessage>();
        Messaging.SingleEmailMessage mail = new Messaging.SingleEmailMessage();
        for(contact c : toContacts){
            mail = new Messaging.SingleEmailMessage();
            mail.setTargetObjectId(c.Id);
            //mail.setCcAddresses(new List<string>{'stephen.gillen+test1@trinsic.co','gillo.100+test1@gmail.com'});
            //mail.setToAddresses(new List<string>{'stephen.gillen@trinsic.co'});
            mail.setWhatId(opp.Id);                
            //mail.setHtmlBody(emailBody);
            //mail.setSubject(subject);
            mail.setTemplateId(templateId); // RPA Offer template
            //mail.setReplyTo(u.email);
            //mail.setReplyTo('rpaconfirmation@w-1ifd3vxqryxhzxecewgbfiho90bbk5qhm4shgvro5yldowgysn.9e-cngpuas.cs88.apex.sandbox.salesforce.com');
            mail.setReplyTo(replyTo);
            mail.setSenderDisplayName(username);            
            
            mail.setFileAttachments(new Messaging.EmailFileAttachment[]{efa});        
            emails.add(mail);            
        }
        
        
        
        if(!test.isRunningTest()){
            Messaging.sendEmail(emails);
            
            try{
                /*
                Opportunity oppor = [SELECT (SELECT Id, createdDate, IsVisibleInSelfService FROM ActivityHistories ORDER BY ActivityDate DESC NULLS LAST, LastModifiedDate DESC LIMIT 1) FROM opportunity WHERE Id = :opp.Id LIMIT 1];
                ActivityHistory ah = oppor.ActivityHistories[0];
                system.debug(ah);
                */
                emailMessage email = [SELECT Id, RelatedToId, parentID, activityid FROM EmailMessage WHERE RelatedToId = :opp.Id ORDER BY createdDate DESC LIMIT 1];
                Attachment a = new Attachment();
                //a.ParentId = opp.Id;
                a.ParentId = email.Id;
                a.OwnerId = UserInfo.getUserId();
                a.Name = attachmentName;
                a.Body = b;
                a.Description = 'RPA Offer sent to originator';
                insert a;
            }
            catch(Exception ex){
                Apexpages.addMessages(ex);
            }
            
        }
        
        opp.RPA_Status__c = 'Approved';
        update opp;
        
        pageReference home = new pageReference('/'+opp.Id);
        home.setRedirect(true);
        return home;
    }
    
    public void save(){
        update opp;
    }
    
    

}