@isTest
public class Test_ReferAFriendController {
    @isTest static void ReferTest() {
        //insert account
        Account a = new Account(Name='test_acct');
        insert a;
        
        Contact c = new Contact(LastName = 'testname', AccountId = a.Id);
        insert c;
        
        //Lead l = new Lead(LastName = 'lastname', Company = 'company');
        //insert l;
        
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
        
        app.Refer_a_Friend__c=true;
        update app;
        
        ApplicationProcess applprocess = new ApplicationProcess();
        //appprocess.cancel();
        //appprocess.LandingPage();
        Test.setCurrentPage(new PageReference('/apex/ReferAFriend?origid='+a.id));
        ReferAFriendController rr = new ReferAFriendController(applprocess);
        rr.getLead();
        rr.getOriginator();
        rr.skip();
        rr.lead.Company = 'company';
        rr.lead.LastName = 'lastname';
        rr.step2();
        rr.isReferFriend();
        
    }
}