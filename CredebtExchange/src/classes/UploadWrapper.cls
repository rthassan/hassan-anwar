public  class UploadWrapper {
    
    public Transient Attachment passport_attachment{get;set;}
    
    public Transient Attachment bill_bankattachment{get;set;} //utility_bill
    
    public Transient Attachment company_bankattachment{get;set;} 
    
    public string name{get;set;}
    public boolean passport_attachment_visibility{get;set;}
    public boolean bank_attachment_visibility{get;set;}
    public boolean director_signature_visibility{get;set;}
    public boolean PBlockVisibility{get;set;}
    public Contact d{get;set;}
    
    public UploadWrapper(string name)
    {
        this.name = name;
    }
    
    public UploadWrapper(Contact con)
    {
        this.d = con;
        passport_attachment = new Attachment();
        bill_bankattachment = new Attachment();
        company_bankattachment = new Attachment();
        
    }
    
    public Attachment GetPAttachment()
    {
        if(passport_attachment == null)
        {
            passport_attachment = new Attachment();
        }
        return passport_attachment;
    }
    
    public Attachment GetBAttachment()
    {
        if(bill_bankattachment == null)
        {
            bill_bankattachment = new Attachment();
        }
        return bill_bankattachment;
    }
    
    public Attachment GetCAttachment()
    {
        if(company_bankattachment == null)
        {
            company_bankattachment = new Attachment();
        }
        return company_bankattachment;
    }
    
    /*public UploadWrapper(string name,boolean pa,boolean ba,boolean ds)
    {
        this.name = name;
        this.passport_attachment_visibility = pa;
        this.bank_attachment_visibility = ba;
        this.director_signature_visibility = ds;
        if(this.passport_attachment_visibility == true && this.bank_attachment_visibility == true && this.director_signature_visibility == true)
        {
            this.PBlockVisibility = false;
        }
        else
        {
            this.PBlockVisibility = true;
        }
    }*/
    
    public void DeleteAttachment(string name,string AppId,String DirectorId)
    {
        List<ContentDocument> cv = new List<ContentDocument>();
        List<ContentDocumentLink> cd = new List<ContentDocumentLink>(); 
        List<ContentDocumentLink> att = [Select id,linkedEntityId,ContentDocumentId from ContentDocumentLink where  LinkedEntityId =: AppId or LinkedEntityId =:DirectorId ];
        
        for(ContentDocumentLink c : att) 
        {
            List<ContentDocument> Temp = [Select id,title from ContentDocument where Id =: c.ContentDocumentId and title =: name];
            if(Temp.size() > 0)
            {
                cv.add(Temp[0]);
                cd.add(c);
            }
            
        }
        
        delete cd; // should delete content document first
        delete cv; // should delete content verion after it
    }
    
    public boolean checksizeDirector()
    {
        if(passport_attachment.body != null)
        {
            if(passport_attachment.BodyLength > 5242880)
            {
                return true;
            }
        }
        
        if(bill_bankattachment.body != null)
        {
            if(bill_bankattachment.BodyLength > 5242880)
            {
                return true;
            }
        }
        
        if(company_bankattachment.body != null)
        {
            if(company_bankattachment.BodyLength > 5242880)
            {
                return true;
            }
        }
        
        return false;
    }
    
    
    public boolean checksize()
    {
        system.debug('inside');
        if((passport_attachment.body != null || this.d.PasswordAttachment__c == true) && 
           (bill_bankattachment.body != null || this.d.BankAttachment__c == true)
           && (company_bankattachment.body != null || this.d.SignatureAttachment__c == true))
        {
            if(passport_attachment.body != null)
            {
                if(passport_attachment.BodyLength > 5242880)
                {
                    return true;
                }
            }
            
            if(bill_bankattachment.body != null)
            {
                if(bill_bankattachment.BodyLength > 5242880)
                {
                    return true;
                }
            }
            
            if(company_bankattachment.body != null)
            {
                if(company_bankattachment.BodyLength > 5242880)
                {
                    return true;
                }
            }
        }
        return false;
    }
    
    
    public boolean saveFAttachments(String AppId,String DirectorId,String n)
    {
        this.name = n;
        if((passport_attachment.body != null || this.d.PasswordAttachment__c == true) && 
           (bill_bankattachment.body != null || this.d.BankAttachment__c == true)
           && (company_bankattachment.body != null || this.d.SignatureAttachment__c == true))
        {   
            
            if(passport_attachment.body != null)
            {
                system.debug(passport_attachment.BodyLength);
                this.DeleteAttachment(this.name+'-Passport/DrivingLisence',AppId,DirectorId);
                this.insertAttachment(passport_attachment.body,this.name+'-Passport/DrivingLisence' ,passport_attachment.name,AppId);
                this.insertAttachment(passport_attachment.body,this.name+'-Passport/DrivingLisence' ,passport_attachment.name,DirectorId);
            }
            
            if(bill_bankattachment.body != null)
            {
                system.debug(bill_bankattachment.BodyLength);
                this.DeleteAttachment(this.name+'-UtilityBill',AppId,DirectorId);
                this.insertAttachment(bill_bankattachment.body,this.name + '-UtilityBill' ,bill_bankattachment.name,AppId);
                this.insertAttachment(bill_bankattachment.body,this.name + '-UtilityBill' ,bill_bankattachment.name,DirectorId);
                
            }
            
            if(company_bankattachment.body != null)
            {
                system.debug(company_bankattachment.BodyLength);
                this.DeleteAttachment(this.name+'-Signature',AppId,DirectorId);
                this.insertAttachment(company_bankattachment.body,this.name + '-Signature' ,company_bankattachment.name,AppId);
                this.insertAttachment(company_bankattachment.body,this.name + '-Signature' ,company_bankattachment.name,DirectorId);
            }
            return true;
        }
        return false;
        
    }
    
    public void InsertAttachment(Blob a, string name, string pathname, string cid)
    {
        ContentVersion cv = new ContentVersion();
        cv.title = name;      
        cv.PathOnClient = '/' + pathname ; ///test img.jpeg           
        cv.VersionData =a;   
        insert cv; 
        
        ContentDocumentLink link = new ContentDocumentLink();
        link.LinkedEntityId = cid;
        link.ContentDocumentId = [SELECT Id, ContentDocumentId FROM ContentVersion WHERE Id =: cv.Id].ContentDocumentId;
        link.ShareType = 'I';
        link.Visibility = 'AllUsers';
        insert link;
    }
    
    public void saveDAttachments(String AppId,String DirectorId,String n)
    {
        this.name = n;
        if(passport_attachment.body != null)
        {   system.debug(passport_attachment.BodyLength);
         this.DeleteAttachment(this.name+'-Passport/DrivingLisence',AppId,DirectorId);
         this.insertAttachment(passport_attachment.body,this.name+'-Passport/DrivingLisence' ,passport_attachment.name,AppId);
         this.insertAttachment(passport_attachment.body,this.name+'-Passport/DrivingLisence' ,passport_attachment.name,DirectorId);
        }
        
        if( bill_bankattachment.body != null)
        {   system.debug(bill_bankattachment.BodyLength);	
         this.DeleteAttachment(this.name+'-UtilityBill',AppId,DirectorId);
         this.insertAttachment(bill_bankattachment.body,this.name + '-UtilityBill' ,bill_bankattachment.name,AppId);
         this.insertAttachment(bill_bankattachment.body,this.name + '-UtilityBill' ,bill_bankattachment.name,DirectorId);
         
        }
        
        if(company_bankattachment.body != null)
        {   	system.debug(company_bankattachment.BodyLength);
         this.DeleteAttachment(this.name+'-Signature',AppId,DirectorId);
         this.insertAttachment(company_bankattachment.body,this.name + '-Signature' ,company_bankattachment.name,AppId);
         this.insertAttachment(company_bankattachment.body,this.name + '-Signature' ,company_bankattachment.name,DirectorId);
        }	
    }   
}