public class CreditorController {
    
    Account originator;
    Application__c app;
    Application_Bank_Account__c bank;
    Application_Creditor__c creditor {get;set;}
    
    public List<Application_Creditor__c> creditorsList; 
   
    public CreditorController(ApplicationProcess obj)
    {
        this.originator=obj.originator;
        this.app=obj.app;
       
        creditorsList=[SELECT Id, Name, First_Name__c, Last_Name__c, Company_Number__c, 
                       CurrencyIsoCode, Amount__c, Company_Name__c, Trading_Name__c,
                       Previous_Name__c, Originator__c, Agreed_Early_Payment_Discount__c,
                       Street__c, Street_Bill__c, Zip_Postal_Code__c, Zip_Postal_Code_Bill__c,
                       Phone__c, Phone_Bill__c, City__c, City_Bill__c, Fax__c, Fax_Bill__c,
                       Country__c, Country_Bill__c, Email_Address__c, Email_Address_Bill__c,
                       	Direct_Dial_Phone__c, Email__c, Counterparty_Since__c, Total_Historic_Value__c,
                       Average_Cycle_Payment__c, Credit_Notes_Issued__c, Invoices_Predicted_Per_Annum__c,
                       Predicted_Annual_Revenue__c, isFilled__c
                       from Application_Creditor__c where Originator__c=:originator.Id AND isFilled__c=false And Mandatory__c=true];
        
        if(creditorsList.size()>0)
        {
            creditor = creditorsList[0];
        }
        
    }
    
   
    public Application_Creditor__c getAppCreditor()
    {
        return creditor;
    }
    
    public Application_Bank_Account__c getAppBankAccount()
    {
        List<Application_Bank_Account__c> bankList= [Select Name, IBAN_Number__c, Bank_Account_Number__c, Swift_Code__c, 
                                                     Sort_Code__c, Bank_Name__c, CurrencyISOCode from Application_Bank_Account__c WHERE Application_Creditor__c=:creditor.Id];
        if(bankList.size()>0)
        {
            bank=bankList[0];
        }
        else
        {
            bank=new Application_Bank_Account__c();
        	bank.Application_Creditor__c=creditor.Id;
        }
       
        return bank;
    }
    
    
    public PageReference saveAndcontinue() {
        
        upsert bank;
        
        creditor.isFilled__c=true;
        update creditor;
        
        creditorsList=[SELECT Id, Name from Application_Creditor__c where Originator__c=:originator.Id AND isFilled__c=false AND Mandatory__c=true];
        if(creditorsList.size()>0)
        {
            PageReference p = new PageReference('/apex/Creditor');
            p.setRedirect(true);
            return p;
        }
        else
        {
            this.app.Creditors_Received__c = true;
            this.app.Stage__c='Creditors';
            update app;
            return Page.UploadAttachments;
           
        }
        
    }
    
    public PageReference isCreditorsFilled()
    {
        creditorsList=[SELECT Id, Name from Application_Creditor__c where Originator__c=:originator.Id AND isFilled__c=false AND Mandatory__c=true];
        if(!(creditorsList.size()>0))
        {
            this.app.Creditors_Received__c = true;
            this.app.Stage__c='Creditors';
            update app;
            return Page.UploadAttachments;
        }
        return null;
    }
}