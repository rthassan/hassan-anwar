public class rpaIssueClass {
    
    public string rpaIssueClass(Id oppId){
        string result  = '';
        try{
            Opportunity opp = [SELECT Id, Name, AccountId, currencyISOcode, c_ETR_Required__c, o_ETR__c, d_ETR_Required__c, a_ETR__c, c_ETR_Discount_Value__C,c_ETR_Discount__c, c_ETR_Deposit__c, d_ETR_Sell_Rate__c, 
                               Monthly_Fee__c, Arrangement_Fee__c, Processing_Commission__c,  Revolving_Purchase__c, Purchase_Payment__c, specific_conditions__c, 
                               posting_fee__c, debtors_rating_fee__c, digi_access_fee__c,  first_repayment__c, repayment_every__c, settled_within__c, ATR_Calculated__c, no_ATR__c, average_DSO__c
                               FROM Opportunity WHERE Id = :oppId];
            Account acc = [SELECT Id, BillingStreet, BillingCity, BillingState, BillingPostalCode, BillingCountry, Name FROM Account WHERE Id = :opp.AccountID];
            OpportunityContactRole ocr = [SELECT Id, ContactId FROM OpportunityContactRole WHERE OpportunityId = :opp.Id and IsPrimary = true];
            Contact con = [SELECT Id, Email, Salutation, Name, FirstName, lastName FROM Contact WHERE Id = :ocr.ContactId]; 
            List<opportunityContactRole> ccRoles = [SELECT Id, ContactId, Contact.email FROM opportunityContactRole WHERE opportunityId = :oppId AND role = 'RPA Approver'];
            List<credit_history__c> creditHistories = [SELECT Id, credit_data_provider__c, credit_limit__c, Creditsafe_Rating__c, Y_E_Trade_Creditors__c, Y_E_Trade_debtors__c, createdDate, As_at_date__c FROM Credit_History__c WHERE Originator__c = :acc.Id ORDER BY As_At_date__c DESC ];
            
            
            //Select contacts
            List<contact> toContacts = new List<contact>();
            List<contact> ccContacts = new List<contact>();
            
            
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
            
            emailServicesAddress esa = [SELECT Id, localpart, emailDomainName FROM emailServicesAddress WHERE function.functionName = 'rpaConfirmation'];
            String replyTo = esa.LocalPart + '@' + esa.EmailDomainName;
            system.debug(replyTo);
            
            List<messaging.SingleEmailMessage> emails = new List<messaging.SingleEmailMessage>();
            Messaging.SingleEmailMessage mail = new Messaging.SingleEmailMessage();
            
            mail = new Messaging.SingleEmailMessage();
            mail.setTargetObjectId(con.Id);
            List<string> ccEmail = new List<string>();
            for(opportunityContactRole ccRole : ccRoles ){
                ccEmail.add(ccRole.contact.email);
            }
            mail.setCcAddresses(ccEmail);
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
            
            
            
            
            
            if(!test.isRunningTest()){
                Messaging.sendEmail(emails);
                
                /*
                Opportunity oppor = [SELECT (SELECT Id, createdDate, IsVisibleInSelfService FROM ActivityHistories ORDER BY ActivityDate DESC NULLS LAST, LastModifiedDate DESC LIMIT 1) FROM opportunity WHERE Id = :opp.Id LIMIT 1];
                ActivityHistory ah = oppor.ActivityHistories[0];
                system.debug(ah);
                */
                emailMessage email = [SELECT Id, RelatedToId, parentID, activityid FROM EmailMessage WHERE RelatedToId = :opp.Id ORDER BY createdDate DESC LIMIT 1];
                Attachment a = new Attachment(ParentId = email.Id, OwnerId = UserInfo.getUserId(), Name = attachmentName, Body = b, Description = 'RPA Offer sent to originator');
                insert a;
                
            }
            result = 'success';
        }
        catch(Exception ex){
            //Apexpages.addMessages(ex);
            result = 'fail';
            system.debug(ex);
        }
        
        /*
        try{
        insert tasks;
        result = 'sucess';
        }
        catch(Exception ex){
        system.debug(ex);
        result = 'fail' + ex;
        }
        */
        
        return result;
    }
    
}