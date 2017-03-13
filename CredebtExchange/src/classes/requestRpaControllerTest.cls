@isTest
public class requestRpaControllerTest {
    
    @isTest static void testMethod1(){
        
        Id originatorAccRecType = [SELECT Id FROM RecordType WHERE sObjectType = 'Account' AND Name = 'Originator'][0].Id;                    
        Account a = new Account(
            Name = 'originator',
            billingStreet = 'maain',
            billingCity = 'Dublin',
            billingState = 'Dublin',
            billingPostalCode = '00000',
            billingCountry = 'Ireland',
            recordTypeId = originatorAccRecType
        );
        insert a;
        
        Contact c = new Contact(
            
            lastName = 'originatorContact',
            accountId = a.Id,
            director__c = true,
            phone = '123456'
        );
        insert c;
        
        Id originatorOppRecType = [SELECT Id FROM RecordType WHERE sObjectType = 'Opportunity' AND Name = '2. Convertibill® Sales Finance'][0].Id;                    
        Opportunity o = new Opportunity(
            recordTypeId = originatorOppRecType,
            Name = 'Test Opp',
            AccountId = a.Id,
            closeDate = System.today().addDays(30),
            stageName = 'Apply'
        );
        insert o;
        
        opportunityContactRole ocr = new opportunityContactRole(
            OpportunityId = o.id,
            ContactId = c.id,
            isPrimary = true
        );
        insert ocr;
        
        Debtor__c d = new Debtor__c(
            Originator__c = a.Id,
            Opportunity__c = o.Id
        );
        insert d;
        
        PageReference pageRef = Page.approveRpaLightning;
        Test.setCurrentPage(pageref);
        
        Apexpages.StandardController stdCon = new Apexpages.StandardController(o);
        requestRpaController con = new requestRpaController(stdCon);
        
        
        con.requestRPA();
        con.con.firstName = 'test';
        con.con.email = 'test@test.com';
        con.opp.d_ETR_Required__c = 10000;
        con.opp.Turnover_Expected_this_year__c = 10000;
        con.acc.IDF_Provider__c = 'None';
        con.acc.NACE_Section__c = 'A - Agriculture, Forestry and Fishing';
        con.acc.NACE_Code__c = '0112 - Growing of rice';
        con.acc.company_registration_number__c = '123456';
        con.acc.country_of_registration__c = 'Ireland';
        con.save();
        con.addCredit();
        con.requestRPA();
        
       
    }

}