@isTest
public class Test_DirectorsDocumentsCtrl {
    @isTest static void TestDirectorsDocCtrl() {
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
        
        ApplicationProcess applprocess1 = new ApplicationProcess();
        DirectorsDocumentsController ctrl = new DirectorsDocumentsController(applprocess1);
        ctrl.name = 'test';
        ctrl.getOriginator();
        ctrl.getUAttachments();
        ctrl.skip();
        
        UploadWrapper uw3 = new UploadWrapper('test');
        Blob b = Blob.valueOf('test');
        
        uw3.passport_attachment.body = b;
        uw3.bill_bankattachment.body = b;
        uw3.company_bankattachment.body = b;
        ctrl.upload.clear();
        ctrl.upload.add(uw3);
        ctrl.save();
    }
}