@isTest
public class Test_DirectorsController {
    
    @TestSetup static void createData()
    {
        Account a = new Account(Name='test_acct',Number_of_Directors__c='2');
        insert a;
        
        Application__c app = new Application__c(Originator__c = a.Id, Directors__c = true);
        insert app;
        
        Opportunity opp = new Opportunity(name='TestOpp',accountid= a.id,CloseDate = System.today(), stageName='Application Started');
        insert opp;
         
    }
    
    @isTest static void Test1()
    {
        Account a = [Select id,name from Account Limit 1];
        Contact c = new Contact(LastName = 'testname', AccountId = a.Id, Director__c=true);
        insert c; 
        
        Contact c1 = new Contact(LastName = 'testname', AccountId = a.Id, Director__c=true);
        insert c1;
        
        Test.setCurrentPage(new pageReference('/apex/Directors?origid='+a.id));
        ApplicationProcess applprocess = new ApplicationProcess(new ApexPages.StandardController(a));
        DirectorsController dc = new DirectorsController(applprocess);
        dc.isDirectors();
        
        
        dc.name = 'test';
        dc.upload = new List<UploadWrapper>();
        dc.getDirectorsList(); 
        dc.save();
        
        a.Number_of_Directors__c = '2';
    }
    
    @isTest static void Test2()
    {
        Account a = [Select id,name from Account Limit 1];
       
        Test.setCurrentPage(new pageReference('/apex/Directors?origid='+a.id));
        ApplicationProcess applprocess = new ApplicationProcess(new ApexPages.StandardController(a));
        DirectorsController dc = new DirectorsController(applprocess);
        dc.isDirectors();
        
        
        dc.name = 'test';
        dc.upload = new List<UploadWrapper>();
        dc.getDirectorsList(); 
        for(integer i=0; i < dc.upload.size(); i++)
        {
            dc.upload[i].d.firstname = 'Test';
            dc.upload[i].d.lastname = '1';
            dc.upload[i].d.MailingStreet = 'ms';
            dc.upload[i].d.Email = 'test@test.com';
            dc.upload[i].d.MailingCity = 'mc';
            dc.upload[i].d.MobilePhone = 'mp';
            dc.upload[i].d.MailingState = 'we';
            dc.upload[i].d.MailingPostalCode = 'mpc';
            dc.upload[i].d.MailingCountry = 'mc';     
            dc.upload[i].d.Mailing_Country__c = 'Pakistan';
            dc.upload[i].passport_attachment.body = blob.valueof('123');
            dc.upload[i].bill_bankattachment.body = blob.valueof('123');
            dc.upload[i].company_bankattachment.body = blob.valueof('123');
        }
        dc.save();
        
        a.Number_of_Directors__c = '2';
    }
    
    
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
        Application__c app = new Application__c(Originator__c = a1.Id, Director_Information__c = true);
        insert app;
        
        ApplicationProcess applprocess = new ApplicationProcess();
        DirectorsController dc = new DirectorsController(applprocess);
        dc.name = 'test';
        dc.upload = new List<UploadWrapper>();
        dc.getDirectorsList();
        dc.save();
        
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
        dc2.save();
        dc2.isDirectors();
    }
}