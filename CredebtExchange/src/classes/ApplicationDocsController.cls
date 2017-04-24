public class ApplicationDocsController {
    
    Application__c app;
    List<Contact> Directors = new List<Contact>();
    public Boolean isDebtors{get;set;}
    
    public ApplicationDocsController(ApexPages.StandardController std)
    {
        app = (Application__c)std.getRecord();
        app = [Select id,originator__c,CompanyLogo__c,BankStatement__c from Application__c where id =: app.id];
        List<Application_Debtor__c> appDebtors = [Select id,name,Experience_File__c from Application_Debtor__c where originator__c =: app.Originator__c and Mandatory__c=true and isDeleted = false];
        if(appDebtors.size()>0)
        {
            isDebtors=true;
        }
        else
        {
            isDebtors=false;
        }
        
    }
    
    public List<Contact> getDirectorsList()
    {
        Directors = [Select id,name,PasswordAttachment__c,BankAttachment__c,SignatureAttachment__c from Contact 
                     where accountid =: app.originator__c and Director__c=true and isDeleted = false];
        system.debug(Directors);
        return Directors;
    }
    
    public List<APplication_Debtor__c> getApplicationDebtor()
    {
        return [Select id,name,Experience_File__c from Application_Debtor__c where originator__c =: app.Originator__c and Mandatory__c=true and isDeleted = false];
        
    }
    

}