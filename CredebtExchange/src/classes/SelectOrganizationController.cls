public class SelectOrganizationController {
    
    public string originatorId;
    Application__c app;
    
    public List<Application_Creditor__c> AppCreditors{get;set;}
    public List<Application_Debtor__c> AppDebtors{get;set;}
    
    String origid;
    
    public SelectOrganizationController(ApplicationProcess obj)
    {
        originatorId=obj.ORIGINATOR_ID;
        app=obj.app;
        origid = apexpages.currentpage().getparameters().get('origid');
    }
    
    public List<Application_Creditor__c> GetCreditorOrganisations(){
        
        AppCreditors = [Select id,name,Amount__c,Company_Number__c, Mandatory__c
                          from Application_Creditor__c where Originator__c = :originatorId and Mandatory__c=true];
                          
        return AppCreditors;
        
    }
    
    
    public List<Application_Debtor__c> GetDebtorOrganisations(){
        
        AppDebtors = [Select id,name,Amount__c,Company_Number__c, Mandatory__c
                          from Application_Debtor__c where Originator__c = :originatorId and Mandatory__c=true];
                          
        return AppDebtors;
    }
    
    public PageReference isSelectOrganisation()
    {
        PageReference p=null;
        if(app.Credebtors__c == true)
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
    
    public PageReference step3(){
        update AppCreditors;
        update AppDebtors;
        
        app.Credebtors__c=true;
        app.Stage__c='Fast-Trading';
        update app;
        
        PageReference p = new PageReference('/apex/FastTrading');
        if( origid != null)
        {
             p.getParameters().put('origid',origid);
        }
        return p;
    }
    
}