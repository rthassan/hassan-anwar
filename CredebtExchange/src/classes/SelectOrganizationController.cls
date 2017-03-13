public class SelectOrganizationController {
    
    public string originatorId;
    Application__c app;
    
    public List<Application_Creditor__c> AppCreditors{get;set;}
    public List<Application_Debtor__c> AppDebtors{get;set;}
    public String CType{
        get{ CType = 'Creditor'; return CType;}set;}
    public String DType{
        get{ DType = 'Debtor'; return Dtype;}set;}
    
    public SelectOrganizationController(ApplicationProcess obj)
    {
        originatorId=obj.ORIGINATOR_ID;
        app=obj.app;
    }
    
    public List<Application_Creditor__c> GetCreditorOrganisations(){
        
        AppCreditors = [Select id,name,Amount__c,Company_Number__c, Mandatory__c
                          from Application_Creditor__c where Originator__c = :originatorId];
                          
        return AppCreditors;
        
    }
    
    
    public List<Application_Debtor__c> GetDebtorOrganisations(){
        
        AppDebtors = [Select id,name,Amount__c,Company_Number__c, Mandatory__c
                          from Application_Debtor__c where Originator__c = :originatorId];
                          
        return AppDebtors;
    }
    
    public PageReference step3(){
        update AppCreditors;
        update AppDebtors;
        
        app.Details_Confirmed__c=true;
        update app;
       
        return Page.Verified;
    }
    
}