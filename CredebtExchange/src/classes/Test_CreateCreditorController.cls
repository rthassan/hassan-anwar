@isTest
public class Test_CreateCreditorController {
    
    @TestSetup
    public static void createData()
    {
        Account acc = new Account(Name='Test');
        insert acc;
        
        Application__c app = new Application__c(originator__c = acc.id);
        insert app;
    }
    
    
    @isTest
    public static void Test1()
    {
        Account orig = [Select id,name from Account Limit 1];
        CreateCreditorController c = new CreateCreditorController(new ApplicationProcess(new ApexPages.StandardController(orig)));
        c.getAppCreditor();
        c.getAppBankAccount();
        c.saveAndcontinue();
    }
    
    @isTest
    public static void Test2()
    {
        Account orig = [Select id,name from Account Limit 1];
        CreateDebtorController c = new CreateDebtorController(new ApplicationProcess(new ApexPages.StandardController(orig)));
        
        Blob b =Blob.valueOf('123');
        c.GetEAttachment().body = b;
        c.GetEAttachment().name = 'Test';
        
        c.getAppDEbtor();
        c.saveAndcontinue();
        
        c.GetEAttachment().body = null;
        c.GetEAttachment();
    }

}