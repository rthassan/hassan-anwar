public class ReviewingApplicationController {
    
    Application__c app;
    
    public ReviewingApplicationController(ApplicationProcess obj)
    {
        this.app=obj.app;
    }
    
    
    public void SubmitForApproval()
    {
        app.Upload_Stage__c=true;
        update app;
    }

}