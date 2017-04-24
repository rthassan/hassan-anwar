public class ApplicationMain {
    
    Account originator;
    Application__c app;
    Lead lead;
    String origid;
    public string selectedTab {get; set;}
    public Boolean refer {get; set;}{refer=true;}
    public Boolean refer1 {get; set;}{refer1=false;}
    public ApplicationMain(ApplicationProcess obj)
    {
        origid = apexpages.currentpage().getparameters().get('origid');
        originator=obj.originator;
        app=obj.app;
        selectedTab = 'tab1';
        if(system.currentPageReference().getParameters().get('selectedTab') != null){
            selectedTab = system.currentPageReference().getParameters().get('selectedTab');
        }
    }
    
    public Lead getLead() {
        if(lead == null) lead = new Lead();
        return lead;
    }
    
    public Account getOriginator() {
        return originator;
    }
   
    
}