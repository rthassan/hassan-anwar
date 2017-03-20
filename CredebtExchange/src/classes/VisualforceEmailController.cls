public class VisualforceEmailController {
    
    public Id CId{get;set;}
    public string path;
    List<Contact> con;
    
    public Contact getDebtor()
    {
        con = [Select id, firstname, lastname, MailingCity, MailingCountry from contact where id =: CId];
        if(con.size() > 0)
        {
            return con[0];
        }
        
        return null;
    }
    
    public Account getDebtorOrganisation()
    {
        con = [Select id,account.Id,name from contact where id =: CId];
        if(con.size() > 0)
        {
            Contact Tcontact = con[0];
            String debt_id = TContact.Account.Id;
            List<Account> DebtorAccounts = [Select id,name,BillingCity, BillingCountry  from Account where id=: debt_id];
            if(DebtorAccounts.size() > 0)
            {
                Account DAccount = DebtorAccounts[0];
                return DAccount;
            }
        }
        
        return null;
    }
    
    public Account getOriginator()
    {
        con = [Select id,account.Id,name from contact where id =: CId];
        if(con.size() > 0)
        {
            Contact Tcontact = con[0];
            String debt_id = TContact.Account.Id;
            List<Account> DebtorAccounts = [Select id,name,Originator__c from Account where id=: debt_id];
            if(DebtorAccounts.size() > 0)
            {
                Account DAccount = DebtorAccounts[0];
                
                List<Account> originator = [Select name, email__c, phone, mobile__c, BillingCity, BillingCountry from Account where id =: DAccount.originator__c];
                if(originator.size() > 0)
                {
                    return originator[0];
                }	 	
            }
         
        }
        return null;
    }
    
    
    public Bank_Account__c getBankAccount()
    {
        con = [Select id,account.Id,name from contact where id =: CId];
        if(con.size() > 0)
        {
            List<Bank_Account__c> bankAccount = [Select name,Bank__c,Bank_Account_Number__c,IBAN_Number__c,Sort_Code__c,Swift_Code__c from Bank_Account__c where 
                                                 Account__c =: con[0].Account.Id];
            if(BankAccount.size() > 0)
            {
                return bankAccount[0];
            }
        }
        
        return null;
    }
    
    public string getSignatureId()
    {
        con = [Select id,account.Id,name from contact where id =: CId];
        if(con.size() > 0)
        {
            Contact Tcontact = con[0];
            String debt_id = TContact.Account.Id;
            List<Account> DebtorAccounts = [Select id,name,originator__c from Account where id=: debt_id];
            if(DebtorAccounts.size() > 0)
            {
                Account DAccount = DebtorAccounts[0];
                
                List<Account> originator = [Select baseurl__c, name, email__c, phone, mobile__c, BillingCity, BillingCountry from Account where id =: DAccount.originator__c];
                if(originator.size() > 0)
                {
                    List<Contact> directors=[SELECT Id, (SELECT Id, Name FROM Attachments where name='Signature') from Contact where AccountId=:DebtorAccounts[0].originator__c AND Director__c=true];
                    if(directors.size()>0)
                    {
                        return originator[0].baseurl__c + '/servlet/servlet.FileDownload?file='+directors[0].Attachments[0].Id;
                    }
                    
                }	 
                
            }
            
        }
        return null;
    }
    
    public string getLogoId()
   {
      con = [Select id,account.Id,name from contact where id =: CId];
      if(con.size() > 0)
      {
          Contact Tcontact = con[0];
          system.debug('contact id is' + TContact.id);
          String debt_id = TContact.Account.Id;
          List<Account> DebtorAccounts = [Select id,name,originator__c from Account where id=: debt_id];
          if(DebtorAccounts.size() > 0)
          {
              Account DAccount = DebtorAccounts[0];
              List<Account> originator = [Select OrgLogoId__c,name, baseurl__c from Account where id =: DAccount.originator__c];
              if(originator.size() > 0)
              {
                  string origid = originator[0].orgLogoId__c;
                  system.debug('origid id is' + origid);
                  path = originator[0].baseurl__c  +'/servlet/servlet.FileDownload?file=' + origid + '&oid=' + UserInfo.getOrganizationId();
              }	
          }
      }   
      system.debug('path is' + path);
      return path;
   }
    
    public string getDirectorSignatureId()
    {
       List<Document> lstDocument = [Select Id,Name from Document where Name ='Director Signature' limit 1];
       
        if(lstDocument.size()>0)
        {
            return URL.getSalesforceBaseUrl().toExternalForm() +'/servlet/servlet.ImageServer?id=' + lstDocument[0].Id + '&oid=' + UserInfo.getOrganizationId();
        }
         
        return null;
    }
    
    
    
    
    
}