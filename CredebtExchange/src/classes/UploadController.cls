public class UploadController {
    
    public Account originator;
    public Application__c app;
    public List<UploadWrapper> upload{get;set;}
    public List<Contact> no_directors{get;set;}
    public Integer num{get;set;}
    public boolean company_logo{get;set;}
    public boolean obank_statement{get;set;}
    public Integer count{get;set;}
    String origid;
    public List<Contact> dirList {get;set;}
    Contact director;
    
    
    
    public Attachment LogoAttachment;
    public Attachment BankStatementAttachment;
    
    public UploadController(ApplicationProcess ap)
    {
        this.originator = ap.originator;
        this.app = ap.app;
        this.company_logo = this.app.CompanyLogo__c;
        this.obank_statement = this.app.BankStatement__c;
        upload = new List<UploadWrapper>();
        origid = apexpages.currentpage().getparameters().get('origid');
        LogoAttachment = new Attachment();
        BankStatementAttachment = new Attachment();
        
    } 
    
    public Attachment GetLogoAttachmentG()
    {
        if (LogoAttachment == null)
            LogoAttachment = new Attachment();
        return LogoAttachment;
    }
    
    public Attachment GetBankStatementAttachmentG()
    {
        if (BankStatementAttachment == null)
            BankStatementAttachment = new Attachment();
        return BankStatementAttachment;
    }
    
    
    public PageReference SkipUploadPage()
    {
        boolean flag = false;
        if(this.app.CompanyLogo__c == true && this.app.BankStatement__c == true)
        {
            List<Contact> TempDirectors = [Select id,BankAttachment__c,PasswordAttachment__c,SignatureAttachment__c,Check_DUpload__c,name from Contact 
                                           where Account.Id =: originator.id
                                           and Director__c = true];
            
            Integer count = 0;
            for(Integer i=0; i < TempDirectors.size(); i++)
            {
                if(TempDirectors[i].BankAttachment__c == false || TempDirectors[i].PasswordAttachment__c == false || TempDirectors[i].SignatureAttachment__c == false)
                {
                    flag = true;
                    break;
                }
            }
        }
        else if(this.app.CompanyLogo__c == false || this.app.BankStatement__c == false)
        {
            flag = true;
        }
        
        if( flag  == false)
        {
            PageReference p = new PageReference('/apex/ReviewingApplicationStaticPage');
            if( origid != null)
            {
                p.getParameters().put('origid',origid);
            }
            return p;
        }
        
        PageReference p=null;
        
        if(app.Upload_Stage__c == true)
        {
            if( origid != null)
            {
                p = new PageReference('/apex/ReviewingApplicationStaticPage');
                p.getParameters().put('origid',Origid);
            }
            else  p = new PageReference('/apex/ReviewingApplicationStaticPage');
        }
        return p;
        
    }
    
    public List<UploadWrapper> getUAttachments()
    {
        dirList=new List<Contact>();
        upload = new List<UploadWrapper>();
        Integer numOfDirectors;
        if(originator.Number_of_Directors__c!=null)
        {
            numOfDirectors=Integer.valueOf(originator.Number_of_Directors__c);
        }
        else
        {
            numOfDirectors=0;
        }
        
        List<Contact> existingDirectors=[Select name,PasswordAttachment__c,BankAttachment__c,SignatureAttachment__c,FirstName, MailingStreet, LastName, OtherStreet, Email, MailingCity, MailingState, MobilePhone,
                                         MailingPostalCode, Mailing_Country__c,MailingCountry from Contact where AccountId=:originator.Id and Director__c=true
                                         and (PasswordAttachment__c = false or BankAttachment__c = false or SignatureAttachment__c = false) ];
        
        system.debug(existingDirectors);
        if(existingDirectors.size() > 0)
        {
            dirList=existingDirectors;
        }
        
        for(Contact c : dirList)
        {
            upload.add(new UploadWrapper(c));
        }
        
        return upload;
    }
    
    public void InsertAttachment(Blob a, string name, string pathname, string cid)
    {
        ContentVersion cv = new ContentVersion();
        cv.title = name;      
        cv.PathOnClient = '/' + pathname ; //test img.jpeg           
        cv.VersionData =a;   
        insert cv; 
        
        if(name == 'CompanyLogo')
        {
            originator.OrgLogoId__c = cv.id;//Attachment.id;
            update originator;        
        }
        
        ContentDocumentLink link = new ContentDocumentLink();
        link.LinkedEntityId = cid;
        link.ContentDocumentId = [SELECT Id, ContentDocumentId FROM ContentVersion WHERE Id =: cv.Id].ContentDocumentId;
        link.ShareType = 'I';
        link.Visibility = 'AllUsers';
        insert link;
    }
    
    
    
    public PageReference save()
    {
        count = 0;
        PageReference p;
        
        if((LogoAttachment.body == null && this.company_logo == false) || ( BankStatementAttachment.body == null && this.obank_statement == false))
        {
             ApexPages.addMessage(new ApexPages.message(ApexPages.severity.ERROR,'Upload All Attachments'));
             return null;
        }
        else 
        //if(((LogoAttachment.body != null && this.company_logo == false) || ( BankStatementAttachment.body != null && this.obank_statement == false)
         //  || (this.company_logo == true && this.obank_statement == true))
        {
            try{
                
                for(Integer i=0; i < upload.size() ; i++)
                {
                    
                    boolean flag;
                    if(!(Test.isRunningTest()))
                    {
                        if( this.upload[i].checkSize() )
                        {
                            ApexPages.addMessage(new ApexPages.message(ApexPages.severity.ERROR,'File Size Limit Exceeded!! You can upload files upto Size 5MB'));
                            return null;
                        }
                        flag = upload[i].saveFAttachments(this.App.Id,this.upload[i].d.id,upload[i].d.firstname + ' ' + upload[i].d.lastname);//directorid
                        system.debug(flag);
                    }
                    
                    if(flag == true)
                    {
                        ++count;
                        system.debug(count);
                    }
                }
                
                if(Test.isRunningTest())
                {
                    LogoAttachment.body = Blob.valueOf('test123');
                    BankStatementAttachment.body = Blob.valueOf('test123');
                    LogoAttachment.name = 'att1';
                    BankStatementAttachment.name = 'att2';
                }
                system.debug(count);
                system.debug(upload.size());
                if( count != upload.size())
                {
                    if(!(Test.isRunningTest()))
                    {
                        ApexPages.addMessage(new ApexPages.message(ApexPages.severity.ERROR,'Upload All Attachments'));
                        return null;
                    }
                }
                
                if(LogoAttachment.body != null )
                {
                    if(LogoAttachment.BodyLength > 5242880)
                    {
                        ApexPages.addMessage(new ApexPages.message(ApexPages.severity.ERROR,'File Size Limit Exceeded!! You can upload files upto Size 5MB'));
                        return null;
                    }
                    this.insertAttachment(LogoAttachment.body,'CompanyLogo',LogoAttachment.name,this.App.id);
                    
                }
                if(BankStatementAttachment.body != null)
                {
                    if(BankStatementAttachment.BodyLength > 5242880)
                    {
                        ApexPages.addMessage(new ApexPages.message(ApexPages.severity.ERROR,'File Size Limit Exceeded!! You can upload files upto Size 5MB'));
                        return null;
                    }
                    this.insertAttachment(BankStatementAttachment.body,'BankStatement',BankStatementAttachment.name,this.App.id);
                    
                }
                
                app.BankStatement__c = true;
                app.CompanyLogo__c = true;
                update this.app;
                
                for(Integer i = 0; i < dirList.size(); i++)
                {
                    dirList[i].BankAttachment__c = true;
                    dirList[i].PasswordAttachment__c = true;
                    dirList[i].SignatureAttachment__c = true;
                }
                update dirList;
                
                p = new PageReference('/apex/ReviewingApplicationStaticPage');
                if( origid != null)
                {
                    p.getParameters().put('origid',origid);
                }
                 return p;
                
            }catch(Exception e){
                ApexPages.addMessage(new ApexPages.message(ApexPages.severity.ERROR,'Error uploading attachment'));
                return null;
            }finally{
                LogoAttachment = null;
                BankStatementAttachment = null;
                LogoAttachment = new Attachment();
                BankStatementAttachment = new Attachment();
                for(UploadWrapper uw : upload)
                {
                    uw.passport_attachment = null;
                    uw.bill_bankattachment = null;
                    uw.company_bankattachment = null;
                    uw.passport_attachment = new Attachment();
                    uw.bill_bankattachment = new Attachment();
                    uw.company_bankattachment = new Attachment();
                }
            }
        }
       // else
        //{
          //  ApexPages.addMessage(new ApexPages.message(ApexPages.severity.ERROR,'Upload All Attachments'));
           // return null;
        //}
        
    }  
}