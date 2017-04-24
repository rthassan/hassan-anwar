public class CreateCreditorController {
    
    public Account originator{get;set;}
    Application__c app;
    Application_Bank_Account__c bank;
    Application_Creditor__c creditor;
    
    public CreateCreditorController(ApplicationProcess obj)
    {
        this.originator=obj.originator;
        this.app=obj.app;
        
    }
    
     public Application_Creditor__c getAppCreditor()
    {
        if(creditor == null)
        {
            creditor = new Application_Creditor__c();
            creditor.originator__c = originator.id;
        }    
        return creditor;
    }
    
    public Application_Bank_Account__c getAppBankAccount()
    {
        if(bank == null)
        {
             bank=new Application_Bank_Account__c();
        }
        return bank;
    }
    
    public PageReference saveAndcontinue() {
        
        if(creditor.Primary_Country__c != null)
        {
            creditor.Country__c = creditor.Primary_Country__c;
        }
        if(creditor.Billing_Country__c != null)
        {
            creditor.Country_Bill__c = creditor.Billing_Country__c;
        }
        
        upsert creditor;
        try{
            bank.Application_Creditor__c=creditor.Id;
            upsert bank;
        }
        catch(Exception e)
        {
            return null;
        }
        creditor.Submit_Treasury_Approval__c = true;
		update creditor;
        
        return Page.ApplicationCredebtors;
    }
    

}