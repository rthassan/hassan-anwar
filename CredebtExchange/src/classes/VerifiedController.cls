public class VerifiedController {
    
    Account originator;
    Application__c app;
    String origid;
   
    public VerifiedController(ApplicationProcess obj)
    {
        origid = apexpages.currentpage().getparameters().get('origid');
        
        if(Test.isRunningTest())
        {
           origid='123'; 
        }
        
        originator=obj.originator;
        app=obj.app;
    }
    
    public PageReference isVerified()
    {
        PageReference p=null;
        if(app.Verification_Approved__c == true || app.Stage__c == 'Verified')
        {
            if( origid != null)
            {
                p = new PageReference('/apex/FastTrading');
                p.getParameters().put('origid',origid);
            }
            else  p = new PageReference('/apex/FastTrading');
        }
        return p;
    }
    

}