@isTest
public class Test_TreasuryApproval {
	@isTest static void TestTreasuryApproval() {
        //insert account
        Account a = new Account(Name='test_acct');
        insert a;
        
        //insert Application
        Application__c app = new Application__c(Originator__c = a.Id);
        insert app;
        
        ApexPages.StandardController sc = new ApexPages.StandardController(app);
        TreasuryApproval ctrl = new TreasuryApproval(sc);
        ctrl.isSubmitted = false;
        ctrl.isValidated = false;
        ctrl.SubmitApproval();
    }
}