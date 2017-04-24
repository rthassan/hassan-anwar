public class CreditorController {
    
    Account originator;
    Application__c app;
    Application_Bank_Account__c bank;
    Application_Creditor__c creditor {get;set;}
    
    public List<Application_Creditor__c> creditorsList; 
    String origid;
    
    public CreditorController(ApplicationProcess obj)
    {
        this.originator=obj.originator;
        this.app=obj.app;
        
        creditorsList=[SELECT Id, Name, First_Name__c, Last_Name__c, Company_Number__c, 
                       CurrencyIsoCode, Amount__c, Company_Name__c, Trading_Name__c,
                       Previous_Name__c, Originator__c, State_Province__c, State_Province_Bill__c, 
                       Agreed_Early_Payment_Discount__c,
                       Street__c, Street_Bill__c, Zip_Postal_Code__c, Zip_Postal_Code_Bill__c,
                       Phone__c, Mobile__c, City__c, City_Bill__c, 
                       Country__c, Country_Bill__c,
                       Direct_Dial_Phone__c, Email__c, Counterparty_Since__c, Total_Historic_Value__c,
                       Average_Cycle_Payment__c, 
                       Credit_Notes_Issued__c, Invoices_Predicted_Per_Annum__c,
                       Predicted_Annual_Revenue__c, isFilled__c,Billing_Country__c,Primary_Country__c
                       from Application_Creditor__c where Originator__c=:originator.Id and Mandatory__c=true ORDER BY CreatedDate ASC];
        
        if(creditorsList.size()>0 && originator.Current_Creditor__c < originator.Number_of_App_Creditors__c)
        {
            creditor = creditorsList[(Integer)originator.Current_Creditor__c];
        }
        origid = apexpages.currentpage().getparameters().get('origid');
        
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
            if(bank==null)
            bank=new Application_Bank_Account__c();
            
        }
        
        return bank;
    }
    
    
    public PageReference saveAndcontinue() {
        
        try
        {
             bank.Application_Creditor__c=creditor.Id;
             upsert bank;
        }
        catch(Exception e)
        { 
           return null;
        }
        
        
        if(creditor.Primary_Country__c != null)
        {
            creditor.Country__c = creditor.Primary_Country__c;
        }
        if(creditor.Billing_Country__c != null)
        {
            creditor.Country_Bill__c = creditor.Billing_Country__c;
        }
        
        PageReference p;
        
                
        //creditor.isFilled__c=true;
        
        
		
        originator.Current_Creditor__c++;
        update originator;
        
       
        update creditor;
        
        //creditorsList=[SELECT Id, Name from Application_Creditor__c where Originator__c=:originator.Id AND isFilled__c=false];
        
        if( !(originator.Current_Creditor__c+1>originator.Number_of_App_Creditors__c) )
        {
            p = new PageReference('/apex/Creditor');
            if( origid != null)
            {
                p.getParameters().put('origid',origid);
            }
            p.setRedirect(true);
            return p;
        }
        else
        {
            this.app.Creditors_Received__c = true;
            this.app.Stage__c='Missing Uploads';
            update app;
            
            p = new PageReference('/apex/UploadAttachments');
            if( origid != null)
            {
                p.getParameters().put('origid',origid);
            }
            return p;
            
        }
        
    }
    
    public PageReference isCreditorsFilled()
    {
        PageReference p;
        //creditorsList=[SELECT Id, Name from Application_Creditor__c where Originator__c=:originator.Id AND isFilled__c=false];
        if( (originator.Current_Creditor__c+1>originator.Number_of_App_Creditors__c && app.Creditors_Received__c==true ) || originator.Number_of_App_Creditors__c==0 )
        {
            this.app.Creditors_Received__c = true;
            this.app.Stage__c='Missing Uploads';
            update app;
            p = new PageReference('/apex/UploadAttachments');
            if( origid != null)
            {
                p.getParameters().put('origid',origid);
            }
            return p;
        }
        return null;
    }
}