@isTest
public class Test_ApprovalHistoryCreditorCtrl {
  @isTest static void TestApprovalHistoryCred() {
        //insert account
         
        Recordtype r=[Select Id from Recordtype where name='Originator' And sobjecttype='Account'];
      
     
        Account a = new Account(Name='test_acct', recordtypeid=r.id);
        insert a;
        
        Application_Creditor__c ac = new Application_Creditor__c(Name = 'testappCreditor', Originator__c=a.Id, Last_Name__c = 'testln',
                                                           Email__c = 'test@mailinator.com',Company_Number__c='99');
        insert ac;
        
        Contact c = new Contact(LastName = 'testname', AccountId = a.Id);
        insert c;
      
       	Approval.ProcessSubmitRequest req1 = new Approval.ProcessSubmitRequest();
        req1.setComments('Submitting request for approval..');
        req1.setObjectId(ac.Id);
       
        req1.setSubmitterId(ac.createdby.id);
      	req1.setProcessDefinitionNameOrId('Application_Creditor_Treasury_Approved');
      	req1.setSkipEntryCriteria(true);
        Approval.ProcessResult result = Approval.process(req1);
      
        System.assertEquals('Pending', result.getInstanceStatus(), 'Instance Status'+result.getInstanceStatus());
      
        ApexPages.StandardController sc = new ApexPages.StandardController(ac);
        ApprovalHistoryCreditorController ctrl = new ApprovalHistoryCreditorController(sc);
        ApprovalHistoryCreditorController.ApprovalStepWrapper ctrl2 = new ApprovalHistoryCreditorController.ApprovalStepWrapper();
    
        ctrl2.workItemApproveOrRejectLink = 'test';
        ctrl2.workItemReassignLink = 'test';
    }
}