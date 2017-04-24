@isTest
public class Test_ApplicationDataController {
    
    @TestSetup 
    public static void createData()
    {
        Account acc = new Account(Name='Test');
        insert acc;
        
        Application__c app = new Application__c(originator__c = acc.id);
        insert app;
        
        Opportunity opp = new Opportunity(name='TestOpp',accountid= acc.id,CloseDate = System.today(), stageName='Application Started');
        insert opp;
        
        Application_Creditor__c creditor = new Application_Creditor__c(name='test', originator__c=acc.id);
        insert creditor;
        
        Application_Debtor__c debtor = new Application_Debtor__c(name='test', originator__c=acc.id);
        insert debtor;

        Bank_Account__c bank = new Bank_Account__c(name='Test', Bank__c='ACC', IBAN_Number__c='IE02BOFI90008413113207', Swift_Code__c='ABCDEF12', Account__c=acc.Id);
        insert bank;
        
        Contact c=new Contact(LastName='test', AccountId=acc.id);
        insert c;
       
    }
    
    @isTest
    public static void Test1()
    {
        Application__c app = [Select id,originator__c from Application__C Limit 1];
        ApplicationDataController ad = new ApplicationDataController(new ApexPages.StandardController(
            		app));
        ad.GetOriginator();
        ad.GetAppCredebtors();
        ad.getDirectorList();
        ad.getBankAccountInformation();
        
        Approval.ProcessSubmitRequest req = new Approval.ProcessSubmitRequest();
        req.setComments('Approve.');
        req.setNextApproverIds(new Id[] {UserInfo.getUserId()});
        req.setObjectId(app.originator__c);

            //Submit the approval request
         Approval.ProcessResult result = Approval.process(req);
        ad.reject();
        ad.Approve();
        
    }
    

}