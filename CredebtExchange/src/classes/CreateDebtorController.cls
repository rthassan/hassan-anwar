public class CreateDebtorController {
    
    public Account originator{get;set;}
    Application__c app;
    Application_Bank_Account__c bank;
    Application_Debtor__c debtor;
    public List<Application_Debtor__c> debtorsList;
    public transient Attachment attachment;
    
    public Attachment GetEAttachment()
    {
        if (attachment == null)
            attachment = new Attachment();
        return attachment;
    }
    
    public CreateDebtorController(ApplicationProcess obj)
    {
        this.originator=obj.originator;
        this.app=obj.app;
        
    }
    
     public Application_Debtor__c getAppDebtor()
    {
        if(debtor == null)
        {
            debtor = new Application_Debtor__c();
            debtor.originator__c = originator.id;
        }    
        return debtor;
    }
    
    public Id uploadFile(Blob file, String fileName, String title) {
        ContentVersion v = new ContentVersion();
        v.versionData = file;
        v.title = title;
        v.pathOnClient =fileName;
        insert v;
        
        ContentVersion cdi=[SELECT ContentDocumentId from ContentVersion where id=:v.id];
        
        ContentDocumentLink cdl=new ContentDocumentLink(ContentDocumentId=cdi.ContentDocumentId, LinkedEntityId=this.originator.Id, ShareType='I');
        insert cdl;
        
        return v.id;
    }
    
    public PageReference saveAndcontinue() {
        
        PageReference p;
        if(debtor.Primary_Country__c != null)
        {
            debtor.Country__c = debtor.Primary_Country__c;
        }
        if(debtor.Billing_Country__c != null)
        {
            debtor.Country_Bill__c = debtor.Billing_Country__c;
        }
        
        upsert debtor;
       
        if(attachment.body != null && debtor.No_Previous_Trade_History__c==false)
        {
            if(attachment.BodyLength > 5242880)
            {
                ApexPages.addMessage(new ApexPages.message(ApexPages.severity.ERROR,'File Size Limit Exceeded!! You can upload files upto Size 5MB'));
                return null;
            }
            this.uploadFile(attachment.body, attachment.name, debtor.name+'-ExperienceFile');
        }
        else if(debtor.No_Previous_Trade_History__c==false)
        {
            update debtor;
            ApexPages.addMessage(new ApexPages.message(ApexPages.severity.ERROR,'Provide Experience Document'));
            return null;
        }
        
        debtor.Submit_Treasury_Approval__c = true;
        update debtor;
        
        return Page.ApplicationCredebtors;
        
    } 
}