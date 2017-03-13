public class UploadController {
   
   public Account originator;
   public Application__c app;
   public List<UploadWrapper> upload{get;set;}
   List<Contact> no_directors{get;set;}
   public Integer num{get;set;}
   public boolean company_logo{get;set;}
   public boolean obank_statement{get;set;}
   public Attachment LogoAttachment{
        get {
            if (LogoAttachment == null)
                LogoAttachment = new Attachment();
            return LogoAttachment;
        }
        set;
    }
    public Attachment BankStatementAttachment{
        get {
            if (BankStatementAttachment == null)
                BankStatementAttachment = new Attachment();
            return BankStatementAttachment;
        }
        set;
    }
    public Document document;
   
   public UploadController(ApplicationProcess ap)
   {
   	 this.originator = ap.originator;
   	 this.app = ap.app;
   	 this.company_logo = this.app.CompanyLogo__c;
   	 this.obank_statement = this.app.BankStatement__c;
     this.document = new Document();
   	 
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
            return Page.ReviewingApplicationStaticPage;
        }
      
        return null;
    }
   
   public List<UploadWrapper> getUAttachments()
   {
   	 Integer numOfDirectors=Integer.valueOf(originator.Number_of_Directors__c);
   	 
   	 upload = new List<UploadWrapper>();
   	 system.debug(numofdirectors);
   	 if(numOfDirectors > 0)
   	 {
   	 	no_directors = [Select id,BankAttachment__c,PasswordAttachment__c,SignatureAttachment__c,Check_DUpload__c,name from Contact 
                        where Account.Id =: originator.id
                        and Director__c = true
                        ];
                        
        for(Integer i = 0; i < numOfDirectors; i++)
	   	 {
	   	 	upload.add(new UploadWrapper(no_directors[i].name,no_directors[i].PasswordAttachment__c,
	   	 	no_directors[i].BankAttachment__c,no_directors[i].SignatureAttachment__c));
	   	 }
   	 }
   	 
   	 return upload;
   }
   
   public PageReference save()
   {
   	 Integer count = 0;
   	 
   	 if((LogoAttachment.body != null && this.company_logo == false) || ( BankStatementAttachment.body != null && this.obank_statement == false)
                || (this.company_logo == true && this.obank_statement == true))
   	 {
	   	 try{
	   	 	
	   	    for(INteger i=0; i < upload.size() ; i++)
		   	{
		   	 	boolean flag = upload[i].saveFAttachments(this.App.Id,this.no_directors[i].id);
		   	 	if(flag == true)
		   	 	{
		   	 		++count;
		   	 	}
		   	}
		   	 system.debug('count is:' + count);
             system.debug(upload);
            
		   	if( count != upload.size())
		   	{
		   		PageReference p = Page.UploadAttachments;
                p.setRedirect(true);
                return ApexPages.currentPage();
		   	}
             	       
            if(LogoAttachment.body != null)
            {
                 LogoAttachment.OwnerId = UserInfo.getUserId();
	             LogoAttachment.ParentId = this.App.Id;
                 insert LogoAttachment;
            }
            if(BankStatementAttachment.body != null)
            {
                 BankStatementAttachment.OwnerId = UserInfo.getUserId();
	             BankStatementAttachment.ParentId = this.App.Id;
                 insert BankStatementAttachment;
            }
		   	
            if(LogoAttachment.body != null)
            {
                document = new Document();
                document.authorId = Userinfo.getUserId();
                document.folderId = '0059E000000Jbdz'; //personal Documents ID
                document.body = LogoAttachment.body;
                document.name = LogoAttachment.name;
                document.isPublic = true;
                insert document;
                originator.OrgLogoId__c = document.id;
	            update originator;
            }
             this.app.BankStatement__c = true;
             this.app.CompanyLogo__c = true;
             update this.app;
             
             for(Integer i = 0; i < no_directors.size(); i++)
             {
                 no_directors[i].BankAttachment__c = true;
                 no_directors[i].PasswordAttachment__c = true;
                 no_directors[i].SignatureAttachment__c = true;
             }
             update no_directors;
		   	return new PageReference('/apex/ReviewingApplicationStaticPage');
	   	 }catch(Exception e){
	   	 	ApexPages.addMessage(new ApexPages.message(ApexPages.severity.ERROR,'Error uploading attachment'));
            return null;
	   	 }finally{
	   	 	//document.body = null;
	        document = new Document();
	        LogoAttachment = new Attachment();
	        BankStatementAttachment = new Attachment();
	   	 }
   	 	
   	 }
   	 else
   	 {
   	 	return null;
   	 }
   	 
   }
   
   
}