public class OrganisationDetailsController {
    
    Public Account originator{get;set;}
    public Application__c App;
    public Attachment PAttachment;
    public Attachment attachment{
        get {
            if (attachment == null)
                attachment = new Attachment();
            return attachment;
        }
        set;
    }
    public Document document;
    
    public OrganisationDetailsController(ApplicationProcess ap)
    {
        this.originator = ap.originator;
        this.App = ap.app;
        this.document = new Document();
    }
    
    public PageReference save()
    {
        attachment.Name='CompanyLogo';
        attachment.OwnerId = UserInfo.getUserId();
        attachment.ParentId = this.App.Id;// the record the file is attached to
       // attachment.IsPrivate = true;
        if(attachment.body != null)
        {
           // attachment.ContentType = 'Image/gif';
            try {
                insert attachment;
                originator.OrgLogoId__c = Attachment.id;
                update originator;
                /*document = new Document();
                document.authorId = Userinfo.getUserId();
                document.folderId = '0059E000000Jbdz'; //personal Documents ID
                document.body = attachment.body;
                document.name = attachment.name;
                document.isPublic = true;
                insert document;
                originator.OrgLogoId__c = document.id;*/
              
                app.CompanyLogo__c = true;
                
            } 
            catch (DMLException e) {
                ApexPages.addMessage(new ApexPages.message(ApexPages.severity.ERROR,'Error uploading attachment'));
                return null;
            }
            finally{
                attachment = new attachment();
                //document.body = null;
                document = new Document();
                
            }
            
            ApexPages.addMessage(new ApexPages.message(ApexPages.severity.INFO,'Attachment uploaded successfully'));
            
        }
        
        update originator;
        app.Organisation_Details__c=true;
        app.Stage__c = 'Organisation & Practices';
        update app;  
        return Page.Directors;
    }
}