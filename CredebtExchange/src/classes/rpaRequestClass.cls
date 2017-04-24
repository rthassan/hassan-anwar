public with sharing class rpaRequestClass {
    
    public Map<Id, string> rpaRequestClass(List<Opportunity> opps){
        Map<Id, string> result = new Map<id, string>();
        
        List<Id> accountIds = new List<Id>();
        List<Id> oppIds = new List<Id>();
        Map<Id, List<credit_history__c>> chMap = new Map<Id, List<credit_history__c>>();
        for(opportunity o : opps){
            accountIds.add(o.AccountId);
            oppIds.add(o.Id);
            chMap.put(o.Id, new List<credit_history__c>());
        }
        
        Map<id, Account> accountMap = new Map<id, Account>();
        for( Account a : [SELECT Id, Name, IDF_Provider__c, BillingStreet, BillingCity, NACE_Code__c, Company_Registration_number__c, country_of_registration__c FROM Account WHERE Id IN :accountIds ]){
            accountMap.put(a.Id, a);
        }    
        
        Map<id, Contact> contactMap = new Map<id, Contact>();
        Map<id, id> oppContactMap = new Map<id, Id>();
        List<Id> contactIDs = new List<Id>();
        for(opportunityContactRole ocr : [SELECT Id, ContactId, opportunityId FROM OpportunityContactRole WHERE opportunityId IN :oppIds AND IsPrimary = true]){
            contactIds.add(ocr.contactId);
            oppContactMap.put(ocr.OpportunityId, ocr.ContactId);
        }
        for(Contact c : [SELECT Id, Name, lastName, Phone, Email FROM Contact WHERE Id IN :contactIds]){
            contactMap.put(c.Id, c);
        }
        
        
        for(Credit_History__c ch : [SELECT Id, Originator__c, Opportunity__c FROM Credit_History__c WHERE opportunity__c IN : oppIds]){
            if(chMap.get(ch.opportunity__c) == null){
                chMap.put(ch.opportunity__c, new List<credit_history__c>());
            }
            chMap.get(ch.opportunity__c).add(ch);
        }
        
        Account acc = new Account();
        Contact con = new Contact();
        List<credit_history__c> creditHistories = new List<credit_history__c>();    
        Map<id, string> triggerErrors = new Map<Id, string>();
        String errorString = '';
        for(opportunity opp : opps){
            errorString = '';
            acc = accountMap.get(opp.AccountId);
            
            if(!chMap.get(opp.Id).isEmpty()){
                creditHistories = chMap.get(opp.Id);
            }
            // Check everything is filled in
            List<string> errorList = new List<string>();
            
            if(opp.Turnover_Last_year__c == null || (opp.d_ETR_Required__c == null && opp.Working_Capital_Requirement__c == null) || opp.Average_DSO__c == null){
                errorList.add('\nOpportunity Information Missing.');            
                
                if( opp.Turnover_Last_year__c == null){
                    errorList.add('Opportunity: Turnover Last Year  Required.');           
                }
                if((opp.d_ETR_Required__c == null && opp.Working_Capital_Requirement__c == null)){
                    errorList.add('Opportunity: d-ETR or Working Capital Requirement Required.');
                }
                if(opp.Average_DSO__c == null){
                    errorList.add('Opportunity: Average DSO Required.');
                }                
            }
            system.debug(acc);
            if(acc.IDF_Provider__c == null || acc.BillingStreet == null || acc.BillingCity == null || acc.NACE_Code__c == null  || acc.Company_Registration_number__c == null || acc.country_of_registration__c == null){
                errorList.add('\nAccount Information is Missing.');
                if(acc.IDF_Provider__c == null ){
                    errorList.add('Account: IDF Provider is Missing.');              
                }
                if(acc.BillingStreet == null  || acc.BillingCity == null){
                    errorList.add('Account: Address Information is Missing.');                
                }
                if(acc.NACE_Code__c == null ){
                    errorList.add('Account: NACE Code is Missing.');
                }            
                if(acc.company_registration_number__c == null ){
                    errorList.add('Account: Company Registration Number is Missing.');
                }
                if(acc.Country_of_registration__c == null ){
                    errorList.add('Account: Country of Registration is Missing.');
                }
            }
            
            if(oppContactMap.get(opp.Id) != null){
                con = contactMap.get(oppContactMap.get(opp.Id));
                if(con.lastName == null || con.Phone == null || con.email == null){
                    if(con.Email == null)
                    errorList.add('Contact Information is Missing: Email is Required.');
                    if(con.Phone == null)
                    errorList.add('Contact Information is Missing: Phone is Required.');            
                }
            }else{
                errorList.add('Contact Information is Missing: Opportunity Requires a Primary Contact.');    
            }
            
            
            
            
            if(creditHistories.isEmpty()){
                errorList.add('Credit Information is Missing: At least one Credit History is required.');
            }
            
            if(errorList.isEmpty()){
                id approverId;
                if(opp.Approver__c != null){
                    approverId = opp.Approver__c;
                }else{
                    approverId = [SELECT Id FROM User WHERE alias = 'PRenolds'].Id;
                }
                    
                
                Task t = new Task(
                    Subject = 'RPA Approval - ' + acc.Name,
                    //OwnerId = approver.Id,
                    WhatId = opp.Id,
                    
                    OwnerId = approverId,
                    ActivityDate = system.today(),
                    Type = 'RPA Request Task',
                    Description = opp.Name + ' opportunity has been submitted for RPA approval. ' // +URL.getSalesforceBaseUrl().toExternalForm() +'/' +opp.id
                    //Task_Category__c = 'Internal'            
                );
                if(!test.isRunningTest()){
                    insert t;
                }
            }else{
                errorString = 'Not submitted for RPA : ';
            }
            
            system.debug(errorList);
            system.debug(errorString);
            for(string e : errorList){
                errorString += e + '\n';
            }
            triggerErrors.put(opp.Id, errorString);
        }   
        
        result = triggerErrors;
        return result;
    }
    
}