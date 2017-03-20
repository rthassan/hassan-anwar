@isTest
public class Test_ApprovalHistoryCreditorCtrl {
	@isTest static void TestApprovalHistoryCred() {
        //insert account
        Account a = new Account(Name='test_acct');
        insert a;
        
        Application_Creditor__c ac = new Application_Creditor__c(Name = 'testappCreditor', Originator__c=a.Id, Last_Name__c = 'testln',
                                                           Email__c = 'test@mailinator.com',Company_Number__c='99');
        insert ac;
        
        Contact c = new Contact(LastName = 'testname', AccountId = a.Id);
        insert c;
        
        ApexPages.StandardController sc = new ApexPages.StandardController(ac);
        ApprovalHistoryCreditorController ctrl = new ApprovalHistoryCreditorController(sc);
        ApprovalHistoryCreditorController.ApprovalStepWrapper ctrl2 = new ApprovalHistoryCreditorController.ApprovalStepWrapper();
        ctrl2.workItemApproveOrRejectLink = 'test';
        ctrl2.workItemReassignLink = 'test';
    }
}