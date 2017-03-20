@isTest
public class oppRpaTriggerTest {
    
    @isTest public static void testMethod1(){
        // Set up records
        Id originatorAccRecType = [SELECT Id FROM RecordType WHERE sObjectType = 'Account' AND Name = 'Originator'][0].Id;                    
        Account a = new Account(
            Name = 'originator',
            billingStreet = 'maain',
            billingCity = 'Dublin',
            billingState = 'Dublin',
            billingPostalCode = '00000',
            billingCountry = 'Ireland',
            idf_provider__c = 'None',
            recordTypeId = originatorAccRecType
            
        );
        insert a;
        
        Contact c = new Contact(            
            lastName = 'originatorContact',
            accountId = a.Id,
            director__c = true,
            phone = '123456',
            email = 'test@test.com'
        );
        insert c;
        
        Id originatorOppRecType = [SELECT Id FROM RecordType WHERE sObjectType = 'Opportunity' AND Name = '2. Convertibill® Sales Finance'][0].Id;                    
        Opportunity o = new Opportunity(
            recordTypeId = originatorOppRecType,
            Name = 'Test Opp',
            AccountId = a.Id,
            closeDate = System.today().addDays(30),
            stageName = 'Pre-Approval'  ,
            Approver__c = [SELECT Id FROM User WHERE Alias = 'PRenolds'].Id
            
        );
        insert o;
        
        opportunityContactRole ocr = new opportunityContactRole(
            OpportunityId = o.id,
            ContactId = c.id,
            isPrimary = true
        );
        insert ocr;
        
        // Try update to request with missing details
        try{
            o.StageName = 'RPA Request';
            update o;
        }catch(Exception ex){
            system.debug(ex);
        }        
        o = [SELECT Id, stageName FROM Opportunity WHERE id = :o.Id];
        //system.assertEquals('Pre-Approval', o.stageName);
        
        // Try update to request all details
        Credit_History__c ch = new Credit_history__c(
            Aged_debtors_total__c = 1000,
            As_at_Date__c = system.today(),
            credit_Data_Provider__c = 'CreditSafe',
            Credit_Limit__c = 55000,
            CreditSafe_Rating__c = 5,
            Opportunity__c = o.Id,
            Originator__c = a.Id,
            Y_E_Trade_Creditors__c = 5000,
            Y_E_Trade_Debtors__c = 5000
        );
        insert ch;
        try{
            a.NACE_Section__c = 'A - Agriculture, Forestry and Fishing';
            a.NACE_code__c = '0112 - Growing of rice';
            a.Company_registration_number__c = 'IE12345546';
            a.Country_of_Registration__c = 'Ireland';
            update a;
            o.Turnover_Expected_this_year__c = 100000;
            o.Turnover_last_year__c = 1500000;
            o.d_ETR_Required__c = 50000;
            o.Average_DSO__c = 30;
            o.StageName = 'RPA Request';
            update o;
        }catch(Exception ex){
            system.debug(ex);
        }        
        o = [SELECT Id, stageName FROM Opportunity WHERE id = :o.Id];
        //system.assertEquals('RPA Request', o.stageName);
        
        system.debug([SELECT Id, Subject FROM Task]);
        //Task requestTask = [SELECT Id, Subject FROM Task WHERE WhatId = :o.Id][0];
        //system.assertEquals('RPA Approval - originator',  requestTask.Subject);
        
        
        // Reject RPA Request
        try{
            o.StageName = 'Pre-Approval';
            update o;
        }catch(Exception ex){
            system.debug(ex);
        }
        //system.assertEquals('Pre-Approval', o.stageName);
        //Task rejectTask = [SELECT ID, subject FROM Task ORDER BY createdDate DESC LIMIT 1][0];
        //system.assertEquals('RPA Rejection - originator',  rejectTask.Subject);
        
        // RPA Issue
        
        /*
        try{
            o.StageName = 'RPA Request';
            update o;
            
            o.StageName = 'RPA Issued';
            update o;
        }catch(Exception ex){
            system.debug(ex);
        }
        */
    } 
    
     @isTest public static void testMethod2(){
         //Testing two issues at smae time
        // Set up records
        Id originatorAccRecType = [SELECT Id FROM RecordType WHERE sObjectType = 'Account' AND Name = 'Originator'][0].Id;                    
        Account a = new Account(
            Name = 'originator',
            billingStreet = 'maain',
            billingCity = 'Dublin',
            billingState = 'Dublin',
            billingPostalCode = '00000',
            billingCountry = 'Ireland',
            idf_provider__c = 'None',
            NACE_Section__c = 'A - Agriculture, Forestry and Fishing',
            NACE_code__c = '0112 - Growing of rice',
            Company_registration_number__c = 'IE12345546',
            Country_of_Registration__c = 'Ireland',
            recordTypeId = originatorAccRecType
            
        );
        insert a;
        
        Contact c = new Contact(            
            lastName = 'originatorContact',
            accountId = a.Id,
            director__c = true,
            phone = '123456',
            email = 'test@test.com'
        );
        insert c;
        
        Id originatorOppRecType = [SELECT Id FROM RecordType WHERE sObjectType = 'Opportunity' AND Name = '1. Convertibill® Trade Finance'][0].Id;                    
        Opportunity o = new Opportunity(
            recordTypeId = originatorOppRecType,
            Name = 'Test Opp',
            AccountId = a.Id,
            closeDate = System.today().addDays(30),
            stageName = 'Pre-Approval'  ,
            Approver__c = [SELECT Id FROM User WHERE Alias = 'PRenolds'].Id,
            Turnover_Expected_this_year__c = 100000,
            Turnover_last_year__c = 1500000,
            d_ETR_Required__c = 50000,
            Average_DSO__c = 30            
        );
        insert o;
        
        opportunityContactRole ocr = new opportunityContactRole(
            OpportunityId = o.id,
            ContactId = c.id,
            isPrimary = true
        );
        insert ocr;
         
        Opportunity o2 = new Opportunity(
            recordTypeId = originatorOppRecType,
            Name = 'Test Opp',
            AccountId = a.Id,
            closeDate = System.today().addDays(30),
            stageName = 'Pre-Approval'  ,
            Approver__c = [SELECT Id FROM User WHERE Alias = 'PRenolds'].Id,
            Turnover_Expected_this_year__c = 100000,
            Turnover_last_year__c = 1500000,
            d_ETR_Required__c = 50000,
            Average_DSO__c = 30            
        );
        insert o2;
        
        opportunityContactRole ocr2 = new opportunityContactRole(
            OpportunityId = o2.id,
            ContactId = c.id,
            isPrimary = true
        );
        insert ocr2;
        
        // Try update to request with missing details
        try{
            o.StageName = 'RPA Request';
            update o;
        }catch(Exception ex){
            system.debug(ex);
        }        
        o = [SELECT Id, stageName FROM Opportunity WHERE id = :o.Id];
        system.assertEquals('Pre-Approval', o.stageName);
        
        // Try update to request all details
        Credit_History__c ch = new Credit_history__c(
            Aged_debtors_total__c = 1000,
            As_at_Date__c = system.today(),
            credit_Data_Provider__c = 'CreditSafe',
            Credit_Limit__c = 55000,
            CreditSafe_Rating__c = 5,
            Opportunity__c = o.Id,
            Originator__c = a.Id,
            Y_E_Trade_Creditors__c = 5000,
            Y_E_Trade_Debtors__c = 5000
        );
        insert ch;
         Credit_History__c ch2 = new Credit_history__c(
            Aged_debtors_total__c = 1000,
            As_at_Date__c = system.today(),
            credit_Data_Provider__c = 'CreditSafe',
            Credit_Limit__c = 55000,
            CreditSafe_Rating__c = 5,
            Opportunity__c = o2.Id,
            Originator__c = a.Id,
            Y_E_Trade_Creditors__c = 5000,
            Y_E_Trade_Debtors__c = 5000
        );
        insert ch2;
        try{           
            o.StageName = 'RPA Request';
            o2.StageName = 'RPA Request';
            update o;
            update o2;
        }catch(Exception ex){
            system.debug(ex);
        }        
        o = [SELECT Id, stageName FROM Opportunity WHERE id = :o.Id];
        system.assertEquals('RPA Request', o.stageName);
        
        
        // RPA Issue
        
        
        try{            
            o.StageName = 'RPA Issued';
            o2.StageName = 'RPA Issued';
            List<opportunity> opps = new List<opportunity>{o, o2};
            update opps;
        }catch(Exception ex){
            system.debug(ex);
        }
        system.debug([SELECT Id, Name, opportunity_code__c FROM Opportunity]);
    } 
    
    
}