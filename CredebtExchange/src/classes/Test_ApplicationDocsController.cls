@isTest
public class Test_ApplicationDocsController {
    
    @TestSetup public static void createData()
    {
        Account a = new Account(name='Test1');
        insert a;
        
        Application__c app = new Application__c(originator__c = a.id);
        insert app;
        
        Contact c = new Contact(lastname='t1', accountid = a.id, Director__c=true);
        insert c;
        
        Application_Debtor__c ad = new Application_Debtor__c(Mandatory__c = true,originator__c = a.id);
        insert ad;
    }
    @isTest public static void Test1()
    {
        Application__c app =[Select originator__c from Application__c Limit 1];
        ApplicationDocsController adc = new ApplicationDocsController(new ApexPages.StandardController(app));
        adc.getDirectorsList();
        adc.getApplicationDebtor();
        
    }
    
    

}