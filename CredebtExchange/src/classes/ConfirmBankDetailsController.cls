public class ConfirmBankDetailsController {

    Contact Debtor;
    List<Bank_Account__c> BankAccount;  
    List<Account> DebtorAccount;  
    public ConfirmBankDetailsController(ApexPages.StandardController sc)
    {
        Debtor = (Contact)sc.getRecord();
    }
    
    public Bank_Account__c GetBankDetails()
    {
    	List<Contact> con = [Select id,Account.id,name from Contact where id=: Debtor.id];
    	DebtorAccount = [Select id,name from Account where id =: con[0].Account.Id];
    	if(DebtorAccount.size() > 0)
    	{
    		 Account da = DebtorAccount[0];
    		 BankAccount = [Select Name,Sort_Code__c,Bank_Account_Number__c,IBAN_Number__c,Swift_Code__c from Bank_Account__c where Account__c =: da.id];
    		 if(BankAccount.size() > 0)
    		 {
    		 	return BankAccount[0];
    		 }
             else return null;
    	}
        return null;
    }
    
    public PageReference Confirm()
    {
        DebtorAccount[0].Bank_Details_Changed__c = true;
        update DebtorAccount;
        update BankAccount;
        return new PageReference('/apex/ThankuPage');
	}
  
}