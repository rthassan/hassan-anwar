trigger ApplicationDebtorTrigger on Application_Debtor__c (after update) {
    Application_Debtor__c d = Trigger.new[0];
    
    if (d.Submit_Treasury_Approval__c == true && Trigger.old[0].Submit_Treasury_Approval__c == false) {
        Approval.ProcessSubmitRequest req1 = new Approval.ProcessSubmitRequest();
        req1.setComments('Submitting request for approval..');
        req1.setObjectId(d.Id);
        
        Application_Debtor__c TDeb = [select id,name,createdby.id from  Application_Debtor__c where id =:d.id];
        req1.setSubmitterId(TDeb.createdby.id);
        
        /*List<User> u=[SELECT Id from User where Originator_Id__c=:d.Originator__c];
if(u.size()>0)
{
req1.setSubmitterId(u[0].id);
}
else
{
req1.setSubmitterId('0059E000000Jbdz'); //UserInfo.getUserId());
}*/
        
        req1.setProcessDefinitionNameOrId('Application_Debtor_Treasury_Approved');
        //Group[] g = [select Id, Name from Group where Type = 'Queue' and Name = 'Treasury Managers Queue'];
        //req1.setNextApproverIds(new Id[] {g[0].id});
        req1.setSkipEntryCriteria(true);
        Approval.ProcessResult result = Approval.process(req1);
    }
    
    if ( d.Treasury_Approved__c == true && Trigger.old[0].Treasury_Approved__c == false &&  d.Manual_Approval__c==false) {
        
        RecordType rec =  [Select Id,SobjectType,Name From RecordType where Name ='Master Credebtor' and 
                           SobjectType ='Account' limit 1];
        
        Account[] existingMasterCreds = [SELECT Id, Name, CurrencyIsoCode, Average_Cycle_Payment__c, BillingCity, BillingCountry,
                                         BillingPostalCode, BillingState, BillingStreet, Company_Registration_Number__c,
                                         Counterparty_Since__c, Credit_Notes_Issued__c, Invoices_Predicted_Per_Annum__c,
                                         Phone, Predicted_Annual_Revenue__c, Previous_Name__c, Total_Historic_Value__c, 
                                         Trading_Name__c, Originator__c, RecordTypeId from Account 
                                         where Name=:d.Name and Company_Registration_Number__c=:d.Company_Number__c 
                                         and RecordTypeId=:rec.Id];
        
        Application_Bank_Account__c[] appBanks=[Select Name, Bank_Name__c, IBAN_Number__c, Bank_Account_Number__c, Swift_Code__c, 
                                                CurrencyIsoCode, Sort_Code__c from Application_Bank_Account__c 
                                                where Application_Debtor__c=:d.Id];
        
        
        //Create Account
        Account a = new Account();
        a.Name = d.Name;
        a.CurrencyIsoCode = d.CurrencyIsoCode;
        a.Average_Cycle_Payment__c = d.Average_Cycle_Payment__c;
        
        a.ShippingStreet = d.Street__c;
        a.ShippingCity = d.City__c;
        a.ShippingCountry = d.Country__c;
        a.ShippingPostalCode = d.Zip_Postal_Code__c;
        a.ShippingState = d.State_Province__c;
        
        a.BillingStreet = d.Street_Bill__c;
        a.BillingCity = d.City_Bill__c;
        a.BillingCountry = d.Country_Bill__c;
        a.BillingPostalCode = d.Zip_Postal_Code_Bill__c;
        
        a.Email__c=d.Email_Address__c;
        a.Email_Bill__c=d.Email_Address_Bill__c;
        
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
            master.BillingCity = d.City__c;
            master.BillingCountry = d.Country__c;
            master.BillingPostalCode = d.Zip_Postal_Code__c;
            master.BillingState = d.State_Province__c;
            master.BillingStreet = d.Street__c;
            master.Company_Registration_Number__c = d.Company_Number__c;
            master.RecordTypeId = [Select Id,SobjectType,Name From RecordType 
                                   where Name ='Master Credebtor' and SobjectType ='Account' limit 1].Id;
            
            insert master;
            
            a.ParentId = master.Id;
        }
        insert a;
        
        //Create Debtor's Bank Account
        if(appBanks.size() > 0) {
            Bank_Account__c bank = new Bank_Account__c();
            bank.Name = appBanks[0].Name;
            bank.Bank__c = appBanks[0].Bank_Name__c;
            bank.IBAN_Number__c = appBanks[0].IBAN_Number__c;
            bank.Bank_Account_Number__c = appBanks[0].Bank_Account_Number__c;
            bank.Swift_Code__c = appBanks[0].Swift_Code__c;
            bank.Sort_Code__c = appBanks[0].Sort_Code__c;
            bank.CurrencyIsoCode = appBanks[0].CurrencyIsoCode;
            bank.Account__c = a.Id;
            insert bank;
            
        }
        
        //Create Contact
        Contact cont = new Contact();
        cont.FirstName = d.First_Name__c;
        cont.LastName = d.Last_Name__c;
        cont.Email = d.Email__c;
        cont.phone=d.Direct_Dial_Phone__c;
        cont.AccountId = a.Id;
        
        cont.MailingStreet=d.Street__c;
        cont.MailingPostalCode=d.Zip_Postal_Code__c;
        cont.MailingCity=d.City__c;
        cont.MailingCountry=d.Country__c;
        
        if (!Test.isRunningTest()) {
            cont.RecordTypeId = [Select Id,SobjectType,Name From RecordType where Name ='Debtor' 
                                 and SobjectType ='Contact' limit 1].Id;
        }
        insert cont;
        
        //Delete Temporary Debtors
        if(appBanks.size() > 0) {
            delete appBanks;
        }
        //Commented due to error
        //List<Application_Debtor__c> debtorstodelete = [Select Id From Application_Debtor__c Where Id IN :Trigger.new];
        //delete debtorstodelete; 
        
    }    
    
}