@isTest
public class Test_DirectorsController {
    @isTest static void TestDirectorsCtrl() {
        //insert account
        Account a = new Account(Name='test_acct',Number_of_Directors__c='1');
        insert a;
        
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
        DirectorsController dc = new DirectorsController(applprocess);
        dc.name = 'test';
        dc.upload = new List<UploadWrapper>();
        dc.getDirectorsList();
        dc.step8();
        dc.saveAndReturn();
        
        a.Number_of_Directors__c = '2';
        update a;
        ApplicationProcess applprocess1 = new ApplicationProcess();
        DirectorsController dc1 = new DirectorsController(applprocess1);
        dc1.getDirectorsList();
        
        c.FirstName = 'first';
        c.LastName = 'ln';
        c.MailingStreet = 'ms';
        c.OtherStreet = 'os';
        c.Email = 'test@test.com';
        c.MailingCity = 'mc';
        c.MobilePhone = 'mp';
        c.MailingPostalCode = 'mpc';
        c.MailingCountry = 'mc';
        update c;
        a.Number_of_Directors__c = '1';
        update a;
        ApplicationProcess applprocess2 = new ApplicationProcess();
        DirectorsController dc2 = new DirectorsController(applprocess2);
        dc2.getDirectorsList();
        dc2.step8();
        dc2.saveAndReturn();
    }
}