public class DirectorsDocumentsController
{
    Account originator;
    public Application__c App;
    List<Contact> no_directors;
    public String name{get;set;}
    public List<UploadWrapper> upload{get;set;}
    
    public DirectorsDocumentsController(ApplicationProcess ap)
    {
        this.originator = ap.originator;
        this.App = ap.App;
    }
    
    
    public Account getOriginator()
    {
        return originator;
    }
    
    public List<UploadWrapper> getUAttachments()
    {
         Integer numOfDirectors=Integer.valueOf(originator.Number_of_Directors__c);
         upload = new List<UploadWrapper>();
        
         if(numOfDirectors > 0)
         {
            no_directors = [Select id,BankAttachment__c ,PasswordAttachment__c,SignatureAttachment__c,Check_DUpload__c,name from Contact 
                            where Account.Id =: originator.id
                            and Director__c = true
                            ];
                            
            for(Integer i = 0; i < no_directors.size(); i++)
             {
                upload.add(new UploadWrapper(no_directors[i].name));
             }
         }
         return upload;
    }
    
    public PageReference skip()
    {
        update originator;
        update no_directors;
        app.Directors__c = true;
        update app;
        return Page.BankDetails; 
    }
    
    public PageReference save()
    {
        for(INteger i=0; i < upload.size() ; i++)
        {
            if(upload[i].passport_attachment.body != null)
            {
                no_directors[i].PasswordAttachment__c = true;       
            }
            if(upload[i].bill_bankattachment.body != null)
            {
                no_directors[i].BankAttachment__c = true;
            }
            if(upload[i].company_bankattachment.body != null)
            {
                no_directors[i].SignatureAttachment__c = true;
            }
            if(upload[i].passport_attachment.body != null && upload[i].bill_bankattachment.body != null && upload[i].company_bankattachment.body != null)
            {
                upload[i].saveDAttachments(this.App.Id,this.no_directors[i].id);
            }
            else
            {
                ApexPages.addMessage(new ApexPages.message(ApexPages.severity.ERROR,'Please upload all Documents'));
                return null;
            }
                
        }
        update originator;
        update no_directors;
        app.Directors__c = true;
        app.Stage__c='Directors';
        update app;
        return Page.BankDetails; 
    }
}