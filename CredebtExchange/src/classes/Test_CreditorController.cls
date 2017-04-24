@isTest
public class Test_CreditorController {
    @isTest static void CreditorCtrl() {
        //insert account
        Account a = new Account(Name='test_acct');
        insert a;
        
        Contact c = new Contact(LastName = 'testname', AccountId = a.Id);
        insert c;
        
        //insert App Debtor
        Application_Creditor__c d = new Application_Creditor__c(Name = 'testappdebtor', Originator__c=a.Id, Last_Name__c = 'testln',
                                                           Email__c = 'test@mailinator.com', isFilled__c=false, Mandatory__c = true);
        insert d;
        
        
        //insert app bank account
        Application_Bank_Account__c b = new Application_Bank_Account__c(Name = 'testappbank', Application_Creditor__c = d.Id,
                                                                       Bank_Name__c = 'ACC', Swift_Code__c = 'ABCDEF12',
                                                                       IBAN_Number__c = 'IE02BOFI90008413113207');
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
        Test.setCurrentPage(new pageReference('/apex/Creditor?origid='+a.id));
        User u1 = [Select LastName, Originator_Id__c from User where Id=:u.Id];
        Account a1 = [Select Name, Id from Account where Id=:a.Id];
        Application__c app = new Application__c(Originator__c = u1.Originator_Id__c, Upload_Stage__c = true);
        insert app;
        
        ApplicationProcess applprocess = new ApplicationProcess();
        CreditorController ctrl = new CreditorController(applprocess);
        ctrl.getAppCreditor();
        ctrl.getAppBankAccount();
        ctrl.saveAndcontinue();
        ctrl.isCreditorsFilled();
        
        delete b;
        ctrl.getAppBankAccount();
    }
}