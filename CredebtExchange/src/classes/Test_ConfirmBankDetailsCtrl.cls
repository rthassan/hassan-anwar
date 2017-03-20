@isTest
public class Test_ConfirmBankDetailsCtrl {
	@isTest static void TestConfirmBank() {
        //insert account
        Account a = new Account(Name='test_acct');
        insert a;
        
        Contact c = new Contact(LastName = 'testname', AccountId = a.Id);
        insert c;
        
        Bank_Account__c b = new Bank_Account__c(Bank__c = 'ACC', Swift_Code__c='6325', IBAN_Number__c='737',
                                               Account__c=a.Id);
        insert b;
        
        ApexPages.StandardController sc = new ApexPages.StandardController(c);
        ConfirmBankDetailsController cbdc = new ConfirmBankDetailsController(sc);
        cbdc.GetBankDetails();
        cbdc.Confirm();
        
        delete b;
        ConfirmBankDetailsController cbdc1 = new ConfirmBankDetailsController(sc);
        cbdc1.GetBankDetails();
    }
}