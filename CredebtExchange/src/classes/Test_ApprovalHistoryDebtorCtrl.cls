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
        
        ApexPages.StandardController sc = new ApexPages.StandardController(ac);
        ApprovalHistoryDebtorController ctrl = new ApprovalHistoryDebtorController(sc);
        ApprovalHistoryDebtorController.ApprovalStepWrapper ctrl2 = new ApprovalHistoryDebtorController.ApprovalStepWrapper();
        ctrl2.workItemApproveOrRejectLink = 'test';
        ctrl2.workItemReassignLink = 'test';
    }
}