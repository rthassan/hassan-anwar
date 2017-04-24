@isTest
public class Test_DebtorController {
    
    @isTest static void DebtorCtrl1() {
        //insert account
        Account a = new Account(Name='test_acct');
        insert a;
        
        Contact c = new Contact(LastName = 'testname', AccountId = a.Id);
        insert c;
        
        //insert App Debtor
        Application_Debtor__c d = new Application_Debtor__c(Name = 'testappdebtor', Originator__c=a.Id, Last_Name__c = 'testln',
                                                           Email__c = 'test@mailinator.com', isFilled__c=false, Mandatory__c = true,
                                                           No_Previous_Trade_History__c = false);
        insert d;
        
        Application__c app = new Application__c(originator__c=a.id, Debtors_received__c = true,Upload_Stage__c = true);
        insert app;
        
         
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
        Account a1 = [Select Name, Id from Account where Id=:a.Id];
       // Application__c app = new Application__c(Originator__c = u1.Originator_Id__c, Upload_Stage__c = true);
        //insert app;
        
        Test.setCurrentPage(new pageReference('/apex/Debtor?origid='+a.id));
        ApplicationProcess applprocess = new ApplicationProcess();
        DebtorController ctrl = new DebtorController(applprocess);
        ctrl.GetEAttachment();
        ctrl.attachment.name = 'test';
        ctrl.attachment.body = blob.valueof('123');
        ctrl.getAppDebtor();
        //.saveAndcontinue();
        
        ctrl.originator.current_debtor__c = 0;
        ctrl.saveAndcontinue();
        
        ctrl.originator.current_debtor__c = 1;
        ctrl.isDebtorsFilled();
        
        Blob bb = Blob.valueOf('body1');
        ctrl.attachment.body = bb;
        ctrl.saveAndcontinue();
        //attachment.body = bb;
    }
    
    
    @isTest static void DebtorCtrl() {
        //insert account
        Account a = new Account(Name='test_acct');
        insert a;
        
        Contact c = new Contact(LastName = 'testname', AccountId = a.Id);
        insert c;
        
        //insert App Debtor
        Application_Debtor__c d = new Application_Debtor__c(Name = 'testappdebtor', Originator__c=a.Id, Last_Name__c = 'testln',
                                                           Email__c = 'test@mailinator.com', isFilled__c=false, Mandatory__c = true);
        insert d;
        
        Application__c app = new Application__c(originator__c=a.id, Debtors_received__c = true,Upload_Stage__c = true);
        insert app;
        
         
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
        Account a1 = [Select Name, Id from Account where Id=:a.Id];
       // Application__c app = new Application__c(Originator__c = u1.Originator_Id__c, Upload_Stage__c = true);
        //insert app;
        
        Test.setCurrentPage(new pageReference('/apex/Debtor?origid='+a.id));
        ApplicationProcess applprocess = new ApplicationProcess();
        DebtorController ctrl = new DebtorController(applprocess);
        ctrl.GetEAttachment();
        ctrl.attachment.name = 'test';
        ctrl.attachment.body = blob.valueof('123');
        ctrl.getAppDebtor();
        ctrl.saveAndcontinue();
        
        //ctrl.originator.current_debtor__c = 0;
        //ctrl.saveAndcontinue();
        
       ctrl.originator.current_debtor__c = 1;
        ctrl.isDebtorsFilled();
        
        Blob bb = Blob.valueOf('body1');
        ctrl.attachment.body = bb;
        ctrl.saveAndcontinue();
        //attachment.body = bb;
    }
}