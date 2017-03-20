@isTest
public class Test_ApplicationTrigger {
    @isTest static void TestAppTrigger() {
        Account a = new Account(Name='test_acct');
        insert a;
        
        //insert App Debtor
        Application__c app = new Application__c(Originator__c = a.Id);
        insert app;
        
        Application_Debtor__c d = new Application_Debtor__c(Name = 'testappdebtor', Originator__c=a.Id, Last_Name__c = 'testln',
                                                           Email__c = 'test@mailinator.com', Mandatory__c = true);
        insert d;
        
        Application_Creditor__c c = new Application_Creditor__c(Name = 'testappcreditor', Originator__c=a.Id, Last_Name__c = 'testln',
                                                           Email__c = 'test@mailinator.com', Mandatory__c = true);
        insert c;
        
        app.Credebtors__c = true;
        update app;
        
        
        
        app.Upload_Stage__c = true;
        update app;
        
    }
}