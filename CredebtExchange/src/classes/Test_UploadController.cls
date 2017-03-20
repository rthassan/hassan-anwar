@isTest
public class Test_UploadController {
    @isTest static void TestUpload() {
        //insert account
        Account a = new Account(Name='test_acct',Number_of_Directors__c='1');
        insert a;
        
        Contact c = new Contact(LastName = 'testname', AccountId = a.Id, Director__c = true);
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
        
        Application__c app = new Application__c(Originator__c = u1.Originator_Id__c, Upload_Stage__c = true,
                                               CompanyLogo__c = true, BankStatement__c = true);
        insert app;
        
        ApplicationProcess applprocess = new ApplicationProcess();
        //appprocess.cancel();
        //appprocess.LandingPage();
        UploadController uc = new UploadController(applprocess);
        uc.save();
        uc.SkipUploadPage();
        
        c.BankAttachment__c = true;
        c.PasswordAttachment__c = true;
        c.SignatureAttachment__c = true;
        update c;
        
        uc.SkipUploadPage();
        
        app.CompanyLogo__c = false;
        update app;
        
        ApplicationProcess applprocess1 = new ApplicationProcess();
        UploadController uc1 = new UploadController(applprocess1);
        uc1.SkipUploadPage();
        
        uc.getUAttachments();
        uc.upload.add(new UploadWrapper('name',true,true,true));
        uc.save();
        
        
        
        
    }
}