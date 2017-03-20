@isTest
public class accountDetailControllerTest {
    
    @isTest static void testMethod1(){
        
        Id originatorAccRecType = [SELECT Id FROM RecordType WHERE sObjectType = 'Account' AND Name = 'Originator'][0].Id;                    
        Account a = new Account(
            Name = 'originator',
            idf_provider__c = 'None',
            recordTypeId = originatorAccRecType
        );
        insert a;
        
        Contact c = new Contact(
            lastName = 'originatorContact',
            accountId = a.Id,
            director__c = true
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
        
        Debtor__c d = new Debtor__c(
            Originator__c = a.Id,
            Opportunity__c = o.Id
        );
        insert d;
        
        PageReference pageRef = Page.accountDetail;
        Test.setCurrentPage(pageref);
        
        Apexpages.StandardController stdCon = new Apexpages.StandardController(a);
        accountDetailController con = new accountDetailController(stdCon);
    }

}