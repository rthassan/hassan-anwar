@isTest
public class applicationProcessTest {

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
            accountId = a.Id
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
        
        PageReference pageRef = Page.applicationProcess;
        Test.setCurrentPage(pageref);
        
        Apexpages.StandardController stdCon = new Apexpages.StandardController(o);
        applicationProcessController con = new applicationProcessController(stdCon);
        
        opportunityProgressController con2 = new opportunityProgressController(stdCon);
        
        con.addBankAcc();
        con.newBankAcc.Name = 'test bank acc';
        con.newBankAcc.Bank__c = 'AIB';
        con.newBankAcc.Bank_Account_Number__c = '12345678';
        con.newBankAcc.CurrencyIsoCode = 'EUR';
        con.newBankAcc.IBAN_Number__c = '12345678';
        con.newBankAcc.Sort_Code__c = '123456';
        con.newBankAcc.Swift_Code__c = '123456';
        con.addBankAcc();
        
        con.newDirector.lastName = 'test';
        con.newDirector.Email = 'test@test.com';
        con.addDirector();
        
        con.newDebtor.Name = 'test Debtor';
        con.newDebtor.last_Name__c = 'test Debtor Contact';
        con.addDebtor();
        
        con.newCreditor.Name = 'test Creditor';
        con.newCreditor.last_Name__c = 'test Creditor Contact';
        con.addCreditor();
        
        con.save();
        
        Attachment att = new Attachment();
        att.Name = 'foo';
        att.ContentType = 'text';
        att.Description = 'Test attachment';
        
        con.supportFile = att;
        con.uploadSupportFile();
        
    }
}