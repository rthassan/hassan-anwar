global class ConvertDebtorController {
    
    public Application_Debtor__c debtor{get; set;}
    public List<Account> existingDebtors{get; set;}
    public Boolean isDebtorExist{get; set;}
    public Boolean createNew{get; set;}
    public String debtorId;
    public Id accIdChosen {get; set;}
    public String accId;
    public Boolean linkDebtorwithMaster {get; set;}
    
    public ConvertDebtorController()
    {
        linkDebtorwithMaster=false;
        createNew=false;
        if (!Test.isRunningTest()) {
            debtorId=ApexPages.currentPage().getParameters().get('debtorId');
        } else {
            debtorId = [Select Id from Application_Debtor__c limit 1].Id;
        }
        
        debtor=[SELECT Id, Name, First_Name__c, Last_Name__c, Company_Number__c, 
                CurrencyIsoCode, Amount__c, Company_Name__c, Trading_Name__c,
                Previous_Name__c, Originator__c, State_Province__c, State_Province_Bill__c,
                Street__c, Street_Bill__c, Zip_Postal_Code__c, Zip_Postal_Code_Bill__c,
                Phone__c, Mobile__c, City__c, City_Bill__c, 
                Country__c, Country_Bill__c, 
                Direct_Dial_Phone__c, Email__c, No_Previous_Trade_History__c, Counterparty_Since__c, Total_Historic_Value__c,
                Average_Cycle_Payment__c, 
                Credit_Notes_Issued__c, Invoices_Predicted_Per_Annum__c,
                Predicted_Annual_Revenue__c
                from Application_Debtor__c where ID=:debtorId];
        
        RecordType rec =  [Select Id,SobjectType,Name From RecordType where Name ='Master Credebtor' and SobjectType ='Account' limit 1];
        existingDebtors=[SELECT Id, Name, CurrencyIsoCode, Average_Cycle_Payment__c, 
        BillingCity, BillingCountry, BillingPostalCode, BillingState,
                         BillingStreet, Company_Registration_Number__c, Counterparty_Since__c, Credit_Notes_Issued__c, Invoices_Predicted_Per_Annum__c,
                         Phone, Predicted_Annual_Revenue__c, Previous_Name__c, Total_Historic_Value__c, Trading_Name__c, Originator__c, RecordTypeId
                         from Account where Name=:debtor.Name and Company_Registration_Number__c=:debtor.Company_Number__c and RecordTypeId=:rec.Id];
        
        
        if(existingDebtors.size()>0)
        {
            isDebtorExist=true;
        }
        else
        {
            isDebtorExist=false;
        }
        
    }
    
    public Application_Debtor__c getDebtor()
    {
        return debtor;
    }
    
    public List<Account> getExistingDebtor()
    {
        return existingDebtors;
    }
    
    public PageReference convertDebtor()
    {
        try{
            //Create Account
            Account a = new Account();
            a.Name = debtor.Name;
            a.CurrencyIsoCode = debtor.CurrencyIsoCode;
            a.Average_Cycle_Payment__c = debtor.Average_Cycle_Payment__c;
            
            a.ShippingStreet = debtor.Street__c;
            a.ShippingCity = debtor.City__c;
            a.ShippingCountry = debtor.Country__c;
            a.ShippingState=debtor.State_Province__c;
            a.ShippingPostalCode = debtor.Zip_Postal_Code__c;
            a.ShippingState = debtor.State_Province__c;
            
            a.BillingStreet = debtor.Street_Bill__c;
            a.BillingCity = debtor.City_Bill__c;
            a.BillingCountry = debtor.Country_Bill__c;
            a.BillingState=debtor.State_Province_Bill__c;
            a.BillingPostalCode = debtor.Zip_Postal_Code_Bill__c;
           
            a.Company_Registration_Number__c = debtor.Company_Number__c;
            a.Counterparty_Since__c = debtor.Counterparty_Since__c;
            a.Credit_Notes_Issued__c = debtor.Credit_Notes_Issued__c;
            a.Invoices_Predicted_Per_Annum__c = debtor.Invoices_Predicted_Per_Annum__c;
            a.Phone = debtor.Phone__c;
            a.Predicted_Annual_Revenue__c = debtor.Predicted_Annual_Revenue__c;
            a.Previous_Name__c = debtor.Previous_Name__c;
            a.Total_Historic_Value__c = debtor.Total_Historic_Value__c;
            a.Trading_Name__c = debtor.Trading_Name__c;
            a.Originator__c = debtor.Originator__c;
            a.RecordTypeId = [Select Id,SobjectType,Name From RecordType where Name ='Debtor' and SobjectType ='Account' limit 1].Id;
            
            if(linkDebtorwithMaster)
            {
                a.ParentId=accIdChosen;
            }
            else if(!createNew)
            {
                Account master = new Account();
                master.Name = debtor.Name;
                /*master.BillingCity = debtor.City__c;
                master.BillingCountry = debtor.Country__c;
                master.BillingPostalCode = debtor.Zip_Postal_Code__c;
                master.BillingState = debtor.State_Province__c;
                master.BillingStreet = debtor.Street__c;*/
                master.Company_Registration_Number__c = debtor.Company_Number__c;
                master.RecordTypeId = [Select Id,SobjectType,Name From RecordType where Name ='Master Credebtor' and SobjectType ='Account' limit 1].Id;
                
                insert master;
                
                a.ParentId=master.Id;
            }
            
            
            insert a;
            
            accId=a.Id;
           
            
        }
        catch(Exception e)
        {
            ApexPages.addMessage(new ApexPages.message(ApexPages.severity.ERROR,'Unable to create Debtor Account. Duplicate exists.'));
            return null;
        }
        
        try{
            //Create Contact
            Contact cont = new Contact();
            cont.FirstName = debtor.First_Name__c;
            cont.LastName = debtor.Last_Name__c;
            cont.Email = debtor.Email__c;
            cont.phone=debtor.Direct_Dial_Phone__c;
            cont.MobilePhone=debtor.Mobile__c;
            cont.AccountId = accId;
            cont.ETR_Delivery__c=true;

            cont.MailingStreet=debtor.Street__c;
            cont.MailingPostalCode=debtor.Zip_Postal_Code__c;
            cont.MailingState=debtor.State_Province__c;
            cont.MailingCity=debtor.City__c;
            cont.MailingCountry=debtor.Country__c;
            
            cont.RecordTypeId = [Select Id,SobjectType,Name From RecordType where Name ='Debtor' and SobjectType ='Contact' limit 1].Id;
            insert cont;
        }
        catch(Exception e)
        {
            ApexPages.addMessage(new ApexPages.message(ApexPages.severity.ERROR,'Unable to create Debtor Contact. Duplicate exists.'));
            return null;
        }
        
        
        delete debtor;
        
        if(createNew)
        {
             return new PageReference('/apex/NewMasterCredebtor?credebtorid='+accId);
        }
        
        return new PageReference('/'+accId);
       
    }
    
   
}