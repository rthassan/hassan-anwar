@isTest
public class Test_ApplicationCreditorTrigger {
    @isTest static void TestAppCreditorTrigger() {
        //insert account
        Account a = new Account(Name='test_acct');
        insert a;
        
        //insert App Creditor
        Application_Creditor__c d = new Application_Creditor__c(Name = 'testappCreditor', Originator__c=a.Id, Last_Name__c = 'testln',
                                                           Email__c = 'test@mailinator.com');
        insert d;
        
        //insert app bank account
        Application_Bank_Account__c b = new Application_Bank_Account__c(Name = 'testappbank', Application_Creditor__c = d.Id,
                                                                       Bank_Name__c = 'ACC', Swift_Code__c = 'ABCDEF12',
                                                                       IBAN_Number__c = 'IE02BOFI90008413113207');
        insert b;
        
        //update debtor
        d.Submit_Treasury_Approval__c = true;
        update d;
        
        //approve approval process
        Id retVal = null;
        for(ProcessInstanceWorkitem workItem  : [Select p.Id from ProcessInstanceWorkitem p
            where p.ProcessInstance.TargetObjectId =: d.Id]) {
            retVal  =  workItem.Id;
        }
        system.debug(retVal);
        Approval.ProcessWorkitemRequest req2 = new Approval.ProcessWorkitemRequest();
        req2.setComments('Approving request.');
        req2.setAction('Approve');
        req2.setNextApproverIds(new Id[] {UserInfo.getUserId()});
        req2.setWorkitemId(retVal);
        Approval.ProcessResult result2 =  Approval.process(req2);
       
    }
}