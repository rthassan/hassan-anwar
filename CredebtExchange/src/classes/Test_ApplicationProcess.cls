@isTest
public class Test_ApplicationProcess {
    @isTest static void TestAppProcess() {
        //insert account
        Account a = new Account(Name='test_acct');
        insert a;
        
        Contact c = new Contact(LastName = 'testname', AccountId = a.Id);
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
             //UserRoleId = [SELECT Id FROM UserRole where Name = 'MyOrg Partner User'].Id
        );
        insert u;
        
        User u1 = [Select LastName, Originator_Id__c from User where Id=:u.Id];
        system.debug('u1');
        system.debug(u1);
        Account a1 = [Select Name, Id from Account where Id=:a.Id];
        system.debug(a1);
        Application__c app = new Application__c(Originator__c = u1.Originator_Id__c, Upload_Stage__c = true);
        insert app;
        
        ApplicationProcess appprocess = new ApplicationProcess();
        appprocess.cancel();
        appprocess.LandingPage();
        
        //stage Creditors_Received__c
        app.Upload_Stage__c = false;
        app.Creditors_Received__c = true;
        update app;
        ApplicationProcess appprocess1 = new ApplicationProcess();
        appprocess1.LandingPage();
        
        app.Creditors_Received__c = false;
        app.Debtors_Received__c = true;
        update app;
        ApplicationProcess appprocess2 = new ApplicationProcess();
        appprocess2.LandingPage();
        
        app.Debtors_Received__c = false;
        app.Bank_Accounts__c = true;
        update app;
        ApplicationProcess appprocess3 = new ApplicationProcess();
        appprocess3.LandingPage();
        
        app.Bank_Accounts__c = false;
        app.Directors__c = true;
        update app;
        ApplicationProcess appprocess4 = new ApplicationProcess();
        appprocess4.LandingPage();
        
        app.Directors__c = false;
        app.Director_Information__c = true;
        update app;
        ApplicationProcess appprocess5 = new ApplicationProcess();
        appprocess5.LandingPage();
        
        app.Director_Information__c = false;
        app.Organisation_Details__c = true;
        update app;
        ApplicationProcess appprocess6 = new ApplicationProcess();
        appprocess6.LandingPage();
        
        app.Organisation_Details__c = false;
        app.Fast_Trading__c = true;
        update app;
        ApplicationProcess appprocess7 = new ApplicationProcess();
        appprocess7.LandingPage();
        
        app.Fast_Trading__c = false;
        //app.Verification_Approved__c = true;
        update app;
        ApplicationProcess appprocess8 = new ApplicationProcess();
        appprocess8.LandingPage();
        
        //app.Verification_Approved__c = false;
        app.Credebtors__c = true;
        update app;
        ApplicationProcess appprocess9 = new ApplicationProcess();
        appprocess9.LandingPage();
        
        app.Credebtors__c = false;
        app.Refer_a_Friend__c = true;
        update app;
        ApplicationProcess appprocess10 = new ApplicationProcess();
        appprocess10.LandingPage();
        
        app.Refer_a_Friend__c = false;
        update app;
        ApplicationProcess appprocess11 = new ApplicationProcess();
        appprocess11.LandingPage();
    }
}