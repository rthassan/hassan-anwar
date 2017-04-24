public class ConfirmBankDetailsController {
    
    Contact Debtor;
    List<Bank_Account__c> BankAccount;  
    List<Account> DebtorAccount;  
    List<Application__c> app;
    List<Account> originatorAccounts;
    
    public ConfirmBankDetailsController(ApexPages.StandardController sc)
    {
        Debtor = (Contact)sc.getRecord();
        List<Contact> con = [Select id,Account.id,name from Contact where id=: Debtor.id];
        
        if(con.size() > 0)
        {
            DebtorAccount = [Select id,name,Originator__c,Bank_Details_Changed__c,Bank_Details_Changed_Time__c from Account where id =: con[0].Account.Id];
            if(DebtorAccount.size()>0)
            {
                originatorAccounts=[Select Id, Name, Originator__c from Account where Id=:DebtorAccount[0].Originator__c];
                if(originatorAccounts.size()>0)
                {
                    app = [Select id,Bank_Changed__c from Application__c where Originator__c =: originatorAccounts[0].id Limit 1];
                }
            }
        }
    }
    
    public Bank_Account__c GetBankDetails()
    {
        List<Contact> con = [Select id,Account.id,name from Contact where id=: Debtor.id];
        DebtorAccount = [Select id,name,Bank_Details_Changed__c,Bank_Details_Changed_Time__c from Account where id =: con[0].Account.Id];
        if(DebtorAccount.size() > 0)
        {
            Account da = DebtorAccount[0];
            BankAccount = [Select Name,Sort_Code__c,Bank_Account_Number__c,IBAN_Number__c,Swift_Code__c 
                           from Bank_Account__c where Account__c =: da.id];
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
        DebtorAccount[0].Bank_Details_Changed_Time__c = System.now();
        update DebtorAccount;
        
        if( app.size() > 0)
        {
             app[0].Bank_Changed__c=true;
        update app;    
        }
       
        
        //update BankAccount;
        return new PageReference('/apex/ThankuPage');
    }
    
}