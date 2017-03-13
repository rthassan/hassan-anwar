public class VisualforceEmailController {

    public Id CId{get;set;}
    public string path;
    List<Contact> con;
 
    
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
    
    public string getLogoId()
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
       	 	List<Account> originator = [Select OrgLogoId__c,name from Account where id =: DAccount.originator__c];
       	 	if(originator.size() > 0)
       	 	{
       	 		string origid = originator[0].orgLogoId__c;
       	 		path = URL.getSalesforceBaseUrl().toExternalForm() +'/servlet/servlet.ImageServer?id=' + origid + '&oid=' + UserInfo.getOrganizationId();
       	 	}	 	
       	 }
       }   
       
      // path =   URL.getSalesforceBaseUrl().toExternalForm() + '/servlet/servlet.ImageServer?id=0159E0000009C2g&oid=00D9E000000D0l7';  
       return path;
    }
    
    
}