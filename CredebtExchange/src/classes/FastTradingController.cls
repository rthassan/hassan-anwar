public class FastTradingController {
    
    Account originator;
    Application__c app;
    String origid;
    
    public FastTradingController(ApplicationProcess obj)
    {
        this.originator = obj.originator;
        this.app=obj.app;
        origid = apexpages.currentpage().getparameters().get('origid');
    }
    
    public Account getOriginator() {
        return originator;
    }
    
     public PageReference isFastTrading()
    {
        PageReference p=null;
        if(app.Fast_Trading__c == true)
        {
            if( origid != null)
            {
                p = new PageReference('/apex/OrganisationDetails');
                p.getParameters().put('origid',origid);
            }
            else  p = new PageReference('/apex/OrganisationDetails');
        }
        return p;
    }

    
    public PageReference step5()
    {
        try
        {
            update originator;
        }
        catch(Exception e)
        { 
		
           return null;
        }
        
        app.Fast_Trading__c=true;
        app.Stage__c = 'Organisation & Practices';
        update app;
     
        PageReference p = new PageReference('/apex/OrganisationDetails');
        if( origid != null)
        {
            p.getParameters().put('origid',origid);
        }
        return p;
    }
    
}