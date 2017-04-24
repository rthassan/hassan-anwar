@isTest
public class Test_ApprovalHistoryDebtorCtrl {
  @isTest static void TestApprovalHistoryDebt() {
        //insert account
        Account a = new Account(Name='test_acct');
        insert a;
        
        Application_Debtor__c ac = new Application_Debtor__c(Name = 'testappCreditor', Originator__c=a.Id, Last_Name__c = 'testln',
                                                           Email__c = 'test@mailinator.com',Company_Number__c='99');
        insert ac;
        
        Contact c = new Contact(LastName = 'testname', AccountId = a.Id);
        insert c;
       
        Approval.ProcessSubmitRequest req1 = new Approval.ProcessSubmitRequest();
        req1.setComments('Submitting request for approval..');
        req1.setObjectId(ac.Id);
       
        req1.setSubmitterId(ac.createdby.id);
      	req1.setProcessDefinitionNameOrId('Application_Debtor_Treasury_Approved');
      	req1.setSkipEntryCriteria(true);
        Approval.ProcessResult result = Approval.process(req1);
      
        System.assertEquals('Pending', result.getInstanceStatus(), 'Instance Status'+result.getInstanceStatus());
        
        
        ApexPages.StandardController sc = new ApexPages.StandardController(ac);
        ApprovalHistoryDebtorController ctrl = new ApprovalHistoryDebtorController(sc);
        ApprovalHistoryDebtorController.ApprovalStepWrapper ctrl2 = new ApprovalHistoryDebtorController.ApprovalStepWrapper();
        ctrl2.workItemApproveOrRejectLink = 'test';
        ctrl2.workItemReassignLink = 'test';
    }
}