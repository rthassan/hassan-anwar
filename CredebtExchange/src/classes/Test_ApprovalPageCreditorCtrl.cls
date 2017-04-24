@isTest
public class Test_ApprovalPageCreditorCtrl {
    @isTest static void TestApprovalPageDebt() {
        //insert account
        Account a = new Account(Name='test_acct');
        insert a;
        
        Application_Creditor__c d = new Application_Creditor__c(Name = 'testappCreditor', Originator__c=a.Id, Last_Name__c = 'testln',
                                                           Email__c = 'test@mailinator.com',Company_Number__c='99');
        insert d;
        
        Application_Bank_Account__c b = new Application_Bank_Account__c(Bank_Name__c = 'ACC', Swift_Code__c = 'ABCDEF12', 
                                                                        IBAN_Number__c = 'IE02BOFI90008413113207', Application_Creditor__c = d.Id);
        insert b; 
        
        ApprovalPageCreditorController ctrl = new ApprovalPageCreditorController();
        ctrl.Approve();
        ctrl.Reject();
        ctrl.Cancel();
    }
}