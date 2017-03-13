public class ReferAFriendController {
    
    Account originator;
    Application__c app;
    Lead lead;
   
    public ReferAFriendController(ApplicationProcess obj)
    {
        originator=obj.originator;
        app=obj.app;
    }
    
    public Lead getLead() {
        if(lead == null) lead = new Lead();
        return lead;
    }
    
    public Account getOriginator() {
        return originator;
    }
   
    public PageReference step2() {
        lead.CurrencyIsoCode='EUR';
        lead.IDF_Provider__c='None';
        lead.Status='Unused';
        insert lead;
        
        update originator;
        
        app.Refer_A_Friend__c=true;
        update app;
        
        return Page.SelectOrganisations;
    }
    
     public PageReference skip() {
        return Page.SelectOrganisations;
    }
    
    
    /*public PageReference save() {
        
        account.phone = contact.phone;
        insert account;
       
        contact.accountId = account.id;
        insert contact;
   
        opportunity.accountId = account.id;
        
        insert opportunity;
       
        role.opportunityId = opportunity.id;
        role.contactId = contact.id;
        insert role;
        
        PageReference opptyPage = new ApexPages.StandardController(opportunity).view();
        opptyPage.setRedirect(true);
        return opptyPage;
    }*/
}