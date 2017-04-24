trigger ApplicationDebtorTrigger on Application_Debtor__c (after update) {
    Application_Debtor__c d = Trigger.new[0];
    
    if (d.Submit_Treasury_Approval__c == true && Trigger.old[0].Submit_Treasury_Approval__c == false) {
        Approval.ProcessSubmitRequest req1 = new Approval.ProcessSubmitRequest();
        req1.setComments('Submitting request for approval..');
        req1.setObjectId(d.Id);
        
        Application_Debtor__c TDeb = [select id,name,createdby.id from  Application_Debtor__c where id =:d.id];
        req1.setSubmitterId(TDeb.createdby.id);
        
        req1.setProcessDefinitionNameOrId('Application_Debtor_Treasury_Approved');
        //Group[] g = [select Id, Name from Group where Type = 'Queue' and Name = 'Treasury Managers Queue'];
        //req1.setNextApproverIds(new Id[] {g[0].id});
        req1.setSkipEntryCriteria(true);
        Approval.ProcessResult result = Approval.process(req1);
    }
    
    if ( d.Treasury_Approved__c == true && Trigger.old[0].Treasury_Approved__c == false &&  d.Manual_Approval__c==false) {
        
        RecordType rec =  [Select Id,SobjectType,Name From RecordType where Name ='Master Credebtor' and 
                           SobjectType ='Account' limit 1];
        
        Account[] existingMasterCreds = [SELECT Id, Name, CurrencyIsoCode, 
                                         Average_Cycle_Payment__c, 
                                         BillingCity, BillingCountry,
                                         BillingPostalCode, BillingState, BillingStreet, Company_Registration_Number__c,
                                         Counterparty_Since__c, Credit_Notes_Issued__c, Invoices_Predicted_Per_Annum__c,
                                         Phone, Predicted_Annual_Revenue__c, Previous_Name__c, Total_Historic_Value__c, 
                                         Trading_Name__c, Originator__c, RecordTypeId from Account 
                                         where Name=:d.Name and Company_Registration_Number__c=:d.Company_Number__c 
                                         and RecordTypeId=:rec.Id];
        
      
        String accId;
        
        try{
            //Create Account
            Account a = new Account();
            a.Name = d.Name;
            a.CurrencyIsoCode = d.CurrencyIsoCode;
            a.Average_Cycle_Payment__c = d.Average_Cycle_Payment__c;
            
            a.ShippingStreet = d.Street__c;
            a.ShippingCity = d.City__c;
            a.ShippingCountry = d.Country__c;
            a.ShippingState=d.State_Province__c;
            a.ShippingPostalCode = d.Zip_Postal_Code__c;
            a.ShippingState = d.State_Province__c;
            
            a.BillingStreet = d.Street_Bill__c;
            a.BillingCity = d.City_Bill__c;
            a.BillingCountry = d.Country_Bill__c;
            a.BillingState=d.State_Province_Bill__c;
            a.BillingPostalCode = d.Zip_Postal_Code_Bill__c;
            
            a.Company_Registration_Number__c = d.Company_Number__c;
            a.Counterparty_Since__c = d.Counterparty_Since__c;
            a.Credit_Notes_Issued__c = d.Credit_Notes_Issued__c;
            a.Invoices_Predicted_Per_Annum__c = d.Invoices_Predicted_Per_Annum__c;
            a.Phone = d.Phone__c;
            a.Predicted_Annual_Revenue__c = d.Predicted_Annual_Revenue__c;
            a.Previous_Name__c = d.Previous_Name__c;
            a.Total_Historic_Value__c = d.Total_Historic_Value__c;
            a.Trading_Name__c = d.Trading_Name__c;
            a.Originator__c = d.Originator__c;
            a.RecordTypeId = [Select Id,SobjectType,Name From RecordType where Name ='Debtor' and SobjectType ='Account' limit 1].Id;
            
            
            if(existingMasterCreds.size() > 0) {
                a.ParentId = existingMasterCreds[0].Id;
            } else {
                Account master = new Account();
                master.Name = d.Name;
                /*master.BillingCity = d.City__c;
master.BillingCountry = d.Country__c;
master.BillingPostalCode = d.Zip_Postal_Code__c;
master.BillingState = d.State_Province__c;
master.BillingStreet = d.Street__c;*/
                master.Company_Registration_Number__c = d.Company_Number__c;
                master.RecordTypeId = [Select Id,SobjectType,Name From RecordType 
                                       where Name ='Master Credebtor' and SobjectType ='Account' limit 1].Id;
                
                insert master;
                
                a.ParentId = master.Id;
            }
            insert a;
            
            accId=a.id;
           
        }
        catch(Exception e)
        {
            d.addError('Unable to create Debtor Account. Duplicate exists.');
        }
        
        try{
            //Create Contact
            Contact cont = new Contact();
            cont.FirstName = d.First_Name__c;
            cont.LastName = d.Last_Name__c;
            cont.Email = d.Email__c;
            cont.phone=d.Direct_Dial_Phone__c;
            cont.AccountId = accId;
            cont.MobilePhone=d.Mobile__c;
            cont.ETR_Delivery__c=true;
            
            cont.MailingStreet=d.Street__c;
            cont.MailingPostalCode=d.Zip_Postal_Code__c;
            cont.MailingCity=d.City__c;
            cont.MailingCountry=d.Country__c;
            
            if (!Test.isRunningTest()) {
                cont.RecordTypeId = [Select Id,SobjectType,Name From RecordType where Name ='Debtor' 
                                     and SobjectType ='Contact' limit 1].Id;
            }
            insert cont;
            
        }
        catch(Exception e)
        {
            d.addError('Unable to create Debtor Contact. Duplicate exists.');
        }
        
        
        //Commented due to error
        //List<Application_Debtor__c> debtorstodelete = [Select Id From Application_Debtor__c Where Id IN :Trigger.new];
        //delete debtorstodelete; 
        
    }    
    
}