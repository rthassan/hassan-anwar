@isTest
public class Test_UploadController {
    
     @isTest static void TestUpload1() {
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
        
        Application__c app = new Application__c(Originator__c = u1.Originator_Id__c, Upload_Stage__c = true
                                               );
        insert app;
        
        ApplicationProcess applprocess = new ApplicationProcess();
        applprocess.app = app;
        //appprocess.cancel();
        //appprocess.LandingPage();
         
        Blob b = Blob.valueOf('test123');
        UploadController uc = new UploadController(applprocess);
        uc.no_directors = [Select id,BankAttachment__c,PasswordAttachment__c,SignatureAttachment__c,Check_DUpload__c,name from Contact 
                        where Director__c = true Limit 1];
         
        //uc.upload = new List<UploadWrapper>();              
        uc.upload.add(new UploadWrapper(c));//'name',true,true,true));
         uc.upload[0].passport_attachment.name ='t1';
         uc.upload[0].passport_attachment.body = b;
        uc.upload[0].bill_bankattachment.body = b;
         uc.upload[0].bill_bankattachment.name ='t1';
        uc.upload[0].company_bankattachment.body = b;
         uc.upload[0].company_bankattachment.name ='t1';

         
        
        uc.app = app;
        uc.num = 1;
        uc.LogoAttachment.body = Blob.valueOf('test123');
         uc.LogoAttachment.name = 't1';
        uc.BankStatementAttachment.body = Blob.valueOf('test123');
        uc.BankStatementAttachment.name = 'att2';
               
        uc.app.BankStatement__c = true;
        uc.app.CompanyLogo__c = true;
        uc.count = -1;
        update uc.app;
       // uc.save();
        system.debug('save!!!!');
        system.debug(uc.LogoAttachment.name);
        uc.SkipUploadPage();
        
        c.BankAttachment__c = true;
        c.PasswordAttachment__c = true;
        c.SignatureAttachment__c = true;
        update c;
        
        uc.SkipUploadPage();
        system.debug('12');
        app.CompanyLogo__c = false;
        update app;
        
        ApplicationProcess applprocess1 = new ApplicationProcess();
        UploadController uc1 = new UploadController(applprocess1);
        uc1.SkipUploadPage();
        
        uc.getUAttachments();
        uc.upload.add(new UploadWrapper(c));//'name',true,true,true));
        uc.save();
    }
    
    
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
        
        Application__c app = new Application__c(Originator__c = u1.Originator_Id__c, Upload_Stage__c = true
                                               );
        insert app;
        
        ApplicationProcess applprocess = new ApplicationProcess();
        applprocess.app = app;
       
        Blob b = Blob.valueOf('test123');
        UploadController uc = new UploadController(applprocess);
        uc.no_directors = [Select id,BankAttachment__c,PasswordAttachment__c,SignatureAttachment__c,Check_DUpload__c,name from Contact 
                        where Director__c = true
                        ];
        
        uc.app = app;
        uc.num = 1;
        uc.GetLogoAttachmentG();
        uc.GetBankStatementAttachmentG();
        uc.LogoAttachment.body = Blob.valueOf('test123');
      
        uc.BankStatementAttachment.body = Blob.valueOf('test123');
        uc.BankStatementAttachment.name = 'att2';
        
       
        uc.app.BankStatement__c = true;
        uc.app.CompanyLogo__c = true;
        uc.count = -1;
        update uc.app;
       // uc.save();
        system.debug('save!!!!');
        system.debug(uc.LogoAttachment.name);
        uc.SkipUploadPage();
        
        c.BankAttachment__c = true;
        c.PasswordAttachment__c = true;
        c.SignatureAttachment__c = true;
        update c;
        
        uc.SkipUploadPage();
        system.debug('12');
        app.CompanyLogo__c = false;
        update app;
        
        ApplicationProcess applprocess1 = new ApplicationProcess();
        UploadController uc1 = new UploadController(applprocess1);
        uc1.SkipUploadPage();
        
        uc.getUAttachments();
        uc.upload.add(new UploadWrapper(c));//'name',true,true,true));
        uc.save();
    }
    
    
}