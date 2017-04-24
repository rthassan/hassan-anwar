public class ReferAFriendController {
    
    Account originator;
    Application__c app;
    Lead lead;
    String origid;
    public string selectedTab {get; set;}
    public ReferAFriendController(ApplicationProcess obj)
    {
        origid = apexpages.currentpage().getparameters().get('origid');
        originator=obj.originator;
        app=obj.app;
        selectedTab = 'tab1';
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
        lead.Country=lead.Country__c;
        lead.CurrencyIsoCode='EUR';
        lead.IDF_Provider__c='None';
        lead.Status='Unused';
        lead.Originator_Name__c	= originator.id;
       // lead.PartnerAccount = new Account();
       // lead.PartnerAccount.id = originator.id;
        upsert lead;
        
        try
        {
            update originator;
        }
        catch(Exception e)
        { 
           return null;
        }
        
        app.Refer_A_Friend__c=true;
        app.Stage__c = 'Credebtors';
        update app;
        
        PageReference p = new PageReference('/apex/SelectOrganisations');
        if( origid != null)
        {
             p.getParameters().put('origid',origid);
        }
        return p;
    }
    
     public PageReference skip() {
        app.Refer_A_Friend__c=true;
        app.Stage__c = 'Credebtors';
        update app;
        PageReference p = new PageReference('/apex/SelectOrganisations');
        if( origid != null)
        {
             p.getParameters().put('origid',origid);
        }
        return p;
    }
    
    public PageReference isReferFriend()
    {
        PageReference p=null;
        if(app.Refer_a_Friend__c == true )
        {
            if( origid != null)
            {
                p = new PageReference('/apex/SelectOrganisations');
                p.getParameters().put('origid',Origid);
                
            }
            else  p = new PageReference('/apex/SelectOrganisations');
        }
        return p;
    }
    
}