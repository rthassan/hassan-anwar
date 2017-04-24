@isTest
public class Test_ConvertDebtorController {
    @isTest static void TestConvertDebt() {
        //insert account
        Account a = new Account(Name='test_acctd');
        insert a;
        
        Application_Debtor__c ac = new Application_Debtor__c(Name = 'testappCreditor', Originator__c=a.Id, Last_Name__c = 'testln',
                                                           Email__c = 'test@mailinator.com',Company_Number__c='99');
        insert ac;
        
        Application_Bank_Account__c b = new Application_Bank_Account__c(Bank_Name__c = 'ACC', Swift_Code__c = 'ABCDEF12',
                                                                        IBAN_Number__c = 'IE02BOFI90008413113207', 
                                                                        Application_Debtor__c = ac.Id);
        insert b; 
        
        Account a2 = new Account(Name='testappCreditor',Company_Registration_Number__c='99');
        insert a2;
        
        Contact c = new Contact(LastName = 'testname', AccountId = a.Id, Director__c=true);
        insert c;
        
        User u = new User(
             ProfileId = [SELECT Id FROM Profile WHERE Name = 'Credebt Community User'].Id,
             LastName = 'lastname',
             Email = 'lastname400@company7.com',
             Username = 'lastname400@company7.com' + System.currentTimeMillis(),
             CompanyName = 'testcompany',
             Title = 'testtitle',
             Alias = 'testal',
             TimeZoneSidKey = 'America/Los_Angeles',
             EmailEncodingKey = 'UTF-8',
             LanguageLocaleKey = 'en_US',
             LocaleSidKey = 'en_US',
             ContactId = c.Id
        );
        insert u;
        
        User u1 = [Select LastName, Originator_Id__c from User where Id=:u.Id];
        Account a1 = [Select Name, Id from Account where Id=:a.Id];
        Application__c app = new Application__c(Originator__c = a1.Id, Upload_Stage__c = true);
        insert app;
        
        ApplicationProcess applprocess = new ApplicationProcess();
        ConvertDebtorController ccc = new ConvertDebtorController();
        ccc.accIdChosen = a.Id;
        ccc.getDebtor();
        ccc.getExistingDebtor();
        ccc.convertDebtor();
    }
}