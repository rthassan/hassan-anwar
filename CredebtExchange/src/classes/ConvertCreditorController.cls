public class ConvertCreditorController {
    
    public Application_Creditor__c creditor{get; set;}
    public List<Account> existingCreditors{get; set;}
    public Boolean isCreditorExist{get; set;}
    public Boolean createNew{get; set;}
    public String creditorId;
    public Id accIdChosen {get; set;}
    public Boolean linkCreditorwithMaster {get; set;}
    
    public List<Application_Bank_Account__c> appBanks;
    
    public ConvertCreditorController()
    {
        linkCreditorwithMaster=false;
        createNew=false;
        if (!Test.isRunningTest()) {
            creditorId=ApexPages.currentPage().getParameters().get('creditorId');
        } else {
            creditorId = [Select Id from Application_Creditor__c limit 1].Id;
        }
        
        
        creditor=[SELECT Id, Name, First_Name__c, Last_Name__c, Company_Number__c, 
                  CurrencyIsoCode, Amount__c, Company_Name__c, Trading_Name__c,
                  Previous_Name__c, Originator__c, State_Province__c, State_Province_Bill__c,
                  Street__c, Street_Bill__c, Zip_Postal_Code__c, Zip_Postal_Code_Bill__c,
                  Phone__c, Mobile__c, City__c, City_Bill__c, 
                  Country__c, Country_Bill__c, 
                  Direct_Dial_Phone__c, Email__c, Counterparty_Since__c, Total_Historic_Value__c,
                  Average_Cycle_Payment__c,
                  Credit_Notes_Issued__c, Invoices_Predicted_Per_Annum__c,
                  Predicted_Annual_Revenue__c
                  from Application_Creditor__c where ID=:creditorId];
        
        RecordType rec =  [Select Id,SobjectType,Name From RecordType where Name ='Master Credebtor' and SobjectType ='Account' limit 1];
        existingCreditors=[SELECT Id, Name, CurrencyIsoCode, 
                           Average_Cycle_Payment__c,
                            BillingCity, BillingCountry, BillingPostalCode, BillingState,
                           BillingStreet, Company_Registration_Number__c, Counterparty_Since__c, Credit_Notes_Issued__c, Invoices_Predicted_Per_Annum__c,
                           Phone, Predicted_Annual_Revenue__c, Previous_Name__c, Total_Historic_Value__c, Trading_Name__c, Originator__c, RecordTypeId
                           from Account where Name=:creditor.Name and Company_Registration_Number__c=:creditor.Company_Number__c and RecordTypeId=:rec.Id];
        
        
        appBanks=[Select Name, Bank_Name__c, IBAN_Number__c, Bank_Account_Number__c, Swift_Code__c, CurrencyIsoCode,
                  Sort_Code__c from Application_Bank_Account__c where Application_Creditor__c=:creditorId];
        
        if(existingCreditors.size()>0)
        {
            isCreditorExist=true;
        }
        else
        {
            isCreditorExist=false;
        }
        
    }
    
    public Application_Creditor__c getCreditor()
    {
        return creditor;
    }
    
    public List<Account> getExistingCreditor()
    {
        return existingCreditors;
    }
    
    
    public PageReference convertCreditor()
    {
        //Create Account
        Account a = new Account();
        a.Name = creditor.Name;
        a.CurrencyIsoCode = creditor.CurrencyIsoCode;
        a.Average_Cycle_Payment__c = creditor.Average_Cycle_Payment__c;
        
        
        a.ShippingStreet = creditor.Street__c;
        a.ShippingCity = creditor.City__c;
        a.ShippingCountry = creditor.Country__c;
        a.ShippingState=creditor.State_Province__c;
        a.ShippingPostalCode = creditor.Zip_Postal_Code__c;
        a.ShippingState = creditor.State_Province__c;
            
        a.BillingStreet = creditor.Street_Bill__c;
        a.BillingCity = creditor.City_Bill__c;
        a.BillingCountry = creditor.Country_Bill__c;
        a.BillingState=creditor.State_Province_Bill__c;
        a.BillingPostalCode = creditor.Zip_Postal_Code_Bill__c;
        
       
        a.Company_Registration_Number__c = creditor.Company_Number__c;
        a.Counterparty_Since__c = creditor.Counterparty_Since__c;
        a.Credit_Notes_Issued__c = creditor.Credit_Notes_Issued__c;
        a.Invoices_Predicted_Per_Annum__c = creditor.Invoices_Predicted_Per_Annum__c;
        a.Phone = creditor.Phone__c;
        a.Predicted_Annual_Revenue__c = creditor.Predicted_Annual_Revenue__c;
        a.Previous_Name__c = creditor.Previous_Name__c;
        a.Total_Historic_Value__c = creditor.Total_Historic_Value__c;
        a.Trading_Name__c = creditor.Trading_Name__c;
        a.Originator__c = creditor.Originator__c;
        a.RecordTypeId = [Select Id,SobjectType,Name From RecordType where Name ='Creditor' and SobjectType ='Account' limit 1].Id;
        
        if(linkCreditorwithMaster)
        {
            a.ParentId=accIdChosen;
        }
        else if(!createNew)
        {
            Account master = new Account();
            master.Name = creditor.Name;
            master.Company_Registration_Number__c = creditor.Company_Number__c;
            master.RecordTypeId = [Select Id,SobjectType,Name From RecordType where Name ='Master Credebtor' and SobjectType ='Account' limit 1].Id;
            
            insert master;
            
            a.ParentId=master.Id;
        }
        
        insert a;
        
        //Create Contact
        Contact cont = new Contact();
        cont.FirstName = creditor.First_Name__c;
        cont.LastName = creditor.Last_Name__c;
        cont.Email = creditor.Email__c;
        cont.phone=creditor.Direct_Dial_Phone__c;
        cont.MobilePhone=creditor.Mobile__c;
        cont.ETR_Delivery__c=true;
        cont.AccountId = a.Id;
        
        cont.MailingStreet=creditor.Street__c;
        cont.MailingPostalCode=creditor.Zip_Postal_Code__c;
        cont.MailingCity=creditor.City__c;
        cont.MailingState=creditor.State_Province__c;
        cont.MailingCountry=creditor.Country__c;
        
        cont.RecordTypeId = [Select Id,SobjectType,Name From RecordType where Name ='Creditor' and SobjectType ='Contact' limit 1].Id;
        insert cont;
        
        //Create Bank Account
        
        if(appBanks.size()>0)
        {
            Bank_Account__c bank=new Bank_Account__c();
            bank.Name=appBanks[0].Name;
            bank.Bank__c=appBanks[0].Bank_Name__c;
            bank.IBAN_Number__c=appBanks[0].IBAN_Number__c;
            bank.Bank_Account_Number__c=appBanks[0].Bank_Account_Number__c;
            bank.Swift_Code__c=appBanks[0].Swift_Code__c;
            bank.Sort_Code__c=appBanks[0].Sort_Code__c;
            bank.CurrencyIsoCode=appBanks[0].CurrencyIsoCode;
            bank.Account__c=a.Id;
            
            insert bank;
        }
        
        //Delete Temporary Creditors
        delete creditor;
        if(appBanks.size()>0)
        {
            delete appBanks[0];
        }
        
        if(createNew)
        {
              return new PageReference('/apex/NewMasterCredebtor?credebtorid='+a.Id);
        }
        
        return new PageReference('/'+a.Id);
        
     
    }
    
}