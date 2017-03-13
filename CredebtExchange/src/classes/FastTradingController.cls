public class FastTradingController {
	
	Account originator;
    Application__c app;
	
	public FastTradingController(ApplicationProcess obj)
	{
		this.originator = obj.originator;
        this.app=obj.app;
	}
	
	public Account getOriginator() {
        return originator;
    }
    
    public PageReference step5()
    {
    	update originator;
        
        app.Fast_Trading__c=true;
        update app;
        
        return Page.OrganisationDetails;
    }
    
}