public class DebtorController {
    
    Account originator;
    Application__c app;
    Application_Bank_Account__c bank;
    Application_Debtor__c debtor {get;set;}
    
    public List<Application_Debtor__c> debtorsList;
    public Attachment attachment{
        get {
            if (attachment == null)
                attachment = new Attachment();
            return attachment;
        }
        set;
    }
  
    public DebtorController(ApplicationProcess obj)
    {
        this.originator=obj.originator;
        this.app=obj.app;
        
        debtorsList=[SELECT Id, Name, First_Name__c, Last_Name__c, Company_Number__c, 
                       CurrencyIsoCode, Amount__c, Company_Name__c, Trading_Name__c,
                       Previous_Name__c, Originator__c, 
                       Street__c, Street_Bill__c, Zip_Postal_Code__c, Zip_Postal_Code_Bill__c,
                       Phone__c, Phone_Bill__c, City__c, City_Bill__c, Fax__c, Fax_Bill__c,
                       Country__c, Country_Bill__c, Email_Address__c, Email_Address_Bill__c,
                       	Direct_Dial_Phone__c, Email__c, Counterparty_Since__c, Total_Historic_Value__c,
                       Average_Cycle_Payment__c, Credit_Notes_Issued__c, Invoices_Predicted_Per_Annum__c,
                       Predicted_Annual_Revenue__c, isFilled__c
                       from Application_Debtor__c where Originator__c=:originator.Id AND isFilled__c=false];
        
        if(debtorsList.size()>0)
        {
            debtor = debtorsList[0];
        }
        
    }
    
   
    public Application_Debtor__c getAppDebtor()
    {
        return debtor;
    }
    
    public Application_Bank_Account__c getAppBankAccount()
    {
        List<Application_Bank_Account__c> bankList= [Select Name, IBAN_Number__c, Bank_Account_Number__c, Swift_Code__c, 
                                                     Sort_Code__c from Application_Bank_Account__c WHERE Application_Debtor__c=:debtor.Id];
        if(bankList.size()>0)
        {
            bank=bankList[0];
        }
        else
        {
            bank=new Application_Bank_Account__c();
        	bank.Application_Debtor__c=debtor.Id;
        }
       
        return bank;
    }
    
    
    public PageReference saveAndcontinue() {
        
        if(attachment.body != null)
        {
            attachment.ParentId = this.app.Id;
            attachment.ownerId = UserInfo.getUserId();
            insert attachment;
        }
        upsert bank;
        
        debtor.isFilled__c=true;
        update debtor;
        
        debtorsList=[SELECT Id, Name from Application_Debtor__c where Originator__c=:originator.Id AND isFilled__c=false];
        if(debtorsList.size()>0)
        {
            PageReference p = new PageReference('/apex/Creditor');
            p.setRedirect(true);
            return p;
        }
        else
        {
            this.app.Debtors_Received__c = true;
            update app;
            return Page.UploadAttachments;
        }
        
    }
    
    public PageReference isDebtorsFilled()
    {
        debtorsList=[SELECT Id, Name from Application_Debtor__c where Originator__c=:originator.Id AND isFilled__c=false];
        if(!(debtorsList.size()>0))
        {
             return Page.UploadAttachments;
        }
        return null;
    }
    
    //credContact.RecordTypeId= [Select Id,SobjectType,Name From RecordType where Name ='Creditor' and SobjectType ='Contact' limit 1].Id;
    
}