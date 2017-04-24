@isTest
public class Test_ApplicationBankDetailsCtrl {
    @isTest static void SelectOrgTest() {
        //insert account
        Account a = new Account(Name='test_acct');
        insert a;
        
        Contact c = new Contact(LastName = 'testname', AccountId = a.Id);
        insert c;
        
        Bank_Account__c b = new Bank_Account__c(Bank__c = 'ACC', Swift_Code__c = 'ABCDEF12',
                                                                       IBAN_Number__c = 'IE02BOFI90008413113207', Account__c = a.Id);
        insert b; 
        
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
             //UserRoleId = [SELECT Id FROM UserRole where Name = 'MyOrg Partner User'].Id
        );
        insert u;
        
        User u1 = [Select LastName, Originator_Id__c from User where Id=:u.Id];
        system.debug('u1');
        system.debug(u1);
        Account a1 = [Select Name, Id from Account where Id=:a.Id];
        system.debug(a1);
        Application__c app = new Application__c(Originator__c = u1.Originator_Id__c, Bank_Accounts__c = true);
        insert app;
        
        Test.setCurrentPage(new pagereference('/apex/ApplicationBankDetails?origid='+a.id));
        ApplicationProcess applprocess = new ApplicationProcess();
        //appprocess.cancel();
        //appprocess.LandingPage();
        ApplicationBankDetailsController abdc = new ApplicationBankDetailsController(applprocess);
        abdc.GetBankAccountInformation();
        abdc.attachment.body = Blob.valueOf('123');
        abdc.save();
        
        delete b;
        ApplicationBankDetailsController abdc1 = new ApplicationBankDetailsController(applprocess);
        abdc1.GetBankAccountInformation();
        abdc1.isBankDetails();
    }
}