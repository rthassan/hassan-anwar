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
        
        RecordType rectype = [Select id,name from RecordType where SobjectType='Lead' and name='Originator'];
        lead.RecordTypeId = rectype.id;
        lead.CurrencyIsoCode='EUR';
        lead.IDF_Provider__c='None';
        lead.Status='Unused';
        lead.Originator_Name__c	= originator.id;
       // lead.PartnerAccount = new Account();
       // lead.PartnerAccount.id = originator.id;
        upsert lead;
        
        update originator;
        
        app.Refer_A_Friend__c=true;
        app.Stage__c = 'Refer-a-Friend';
        update app;
        
        return Page.SelectOrganisations;
    }
    
     public PageReference skip() {
        return Page.SelectOrganisations;
    }
    
}