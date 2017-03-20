public class ApplicationBankDetailsController {
    
    public Account originator;
    public Bank_Account__c BankAccount;
    public Application__c App;
    public Attachment attachment {
        get {
            if (attachment == null)
                attachment = new Attachment();
            return attachment;
        }
        set;
    }
    
    public ApplicationBankDetailsController(ApplicationProcess ap)
    {
        this.originator = ap.originator;
        this.App = ap.app;
    }
    
    public Bank_Account__c GetBankAccountInformation()
    {
        if(BankAccount == null)
        {
            List<Bank_Account__c> BAccs = [Select id,Name,Account__c,Bank__c,Bank_Account_Number__c,CurrencyIsoCode,IBAN_Number__c,Sort_Code__c,Swift_Code__c
                                           from Bank_Account__c where Account__c =: this.originator.id];
            
            if(BAccs.size() > 0)
            {
                BankAccount = BAccs[0];
                system.debug(BankAccount);
            }
            else
            {
                BankAccount = new Bank_Account__c();
                BankAccount.Account__c = this.originator.id;
                system.debug(BankAccount);
            }
            
        }
        return BankAccount;
    }
    
    
    public PageReference save()
    {
        attachment.Name='BankLogo';
        attachment.OwnerId = UserInfo.getUserId();
        attachment.ParentId = this.App.Id;// the record the file is attached to
       // attachment.IsPrivate = true;
        
        if(attachment.body != null)
        {
            try {
                upsert attachment;
                app.BankStatement__c = true;
            } catch (DMLException e) {
                ApexPages.addMessage(new ApexPages.message(ApexPages.severity.ERROR,'Error uploading attachment'));
                return null;
            }
            
            ApexPages.addMessage(new ApexPages.message(ApexPages.severity.INFO,'Attachment uploaded successfully'));
        }
        
        upsert BankAccount;
       
        app.Bank_Accounts__c=true;
        app.Stage__c='Bank';
        update app;
        
        return Page.Debtor;
        
    }
    
}