public  class UploadWrapper {
	
	public Attachment passport_attachment{
        get {
            if (passport_attachment == null)
                passport_attachment = new Attachment();
            return passport_attachment;
        }
        set;
    }
    
    public Attachment bill_bankattachment{
        get {
            if (bill_bankattachment == null)
                bill_bankattachment = new Attachment();
            return bill_bankattachment;
        }
        set;
    }
    
    public Attachment company_bankattachment{
        get {
            if (company_bankattachment == null)
                company_bankattachment = new Attachment();
            return company_bankattachment;
        }
        set;
    }
    
    public string name{get;set;}
    public boolean passport_attachment_visibility{get;set;}
    public boolean bank_attachment_visibility{get;set;}
    public boolean director_signature_visibility{get;set;}
    public boolean PBlockVisibility{get;set;}
    
    public UploadWrapper(string name)
    {
    	this.name = name;
    }
    
    public UploadWrapper(string name,boolean pa,boolean ba,boolean ds)
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
    }
    
    public boolean saveFAttachments(String AppId,String DirectorId)
    {
    	if((passport_attachment.body != null || this.passport_attachment_visibility == true) && 
    	        (bill_bankattachment.body != null || this.bank_attachment_visibility == true)
    	        && (company_bankattachment.body != null || this.director_signature_visibility == true))
		{   
			if(passport_attachment.body != null)
			{
				passport_attachment.OwnerId = UserInfo.getUserId();
	            passport_attachment.ParentId = AppId;
	            Attachment att1 = new Attachment();
                passport_attachment.name=this.name+'-Passport/DrivingLisence';
	            att1.name = 'Passport/DrivingLisence';//passport_attachment.name;
	            att1.body = passport_attachment.body;
	            att1.ownerId = UserInfo.getUserId();
	            att1.parentId = DirectorId;
				insert passport_attachment;	
				insert att1;	
			}
			
			if(bill_bankattachment.body != null)
			{
	            bill_bankattachment.OwnerId = UserInfo.getUserId();
	            bill_bankattachment.ParentId = AppId;
	            Attachment att2 = new Attachment();
                bill_bankattachment.name=this.name+'-UtilityBill';
	            att2.name = 'UtilityBill';//bill_bankattachment.name;
	            att2.body = bill_bankattachment.body;
	            att2.ownerId = UserInfo.getUserId();
	            att2.parentId = DirectorId;
				insert bill_bankattachment;
				insert att2;
			}
		
			if(company_bankattachment.body != null)
			{
		        company_bankattachment.OwnerId = UserInfo.getUserId();
		        company_bankattachment.ParentId = AppId;
		        Attachment att3 = new Attachment();
                company_bankattachment.name=this.name+'-Signature';
		        att3.name = 'Signature';//company_bankattachment.name;
		        att3.body = company_bankattachment.body;
		        att3.ownerId = UserInfo.getUserId();
		        att3.parentId = DirectorId;
				insert company_bankattachment;
				insert att3;
			}
			return true;
		}
		return false;
		
    }
    
    public void saveDAttachments(String AppId,String DirectorId)
    {
    	if(passport_attachment.body != null)
		{   
			passport_attachment.OwnerId = UserInfo.getUserId();
            passport_attachment.ParentId = AppId;
            Attachment att1 = new Attachment();
            passport_attachment.name=this.name+'-Passport/DrivingLisence';
	        att1.name = 'Passport/DrivingLisence';//passport_attachment.name;
            att1.body = passport_attachment.body;
            att1.ownerId = UserInfo.getUserId();
            att1.parentId = DirectorId;
			insert passport_attachment;	
			insert att1;	
		}
		
		if( bill_bankattachment.body != null)
		{   	
            bill_bankattachment.OwnerId = UserInfo.getUserId();
            bill_bankattachment.ParentId = AppId;
            Attachment att2 = new Attachment();
            bill_bankattachment.name=this.name+'-UtilityBill';
	        att2.name = 'UtilityBill';//bill_bankattachment.name;
            att2.body = bill_bankattachment.body;
            att2.ownerId = UserInfo.getUserId();
            att2.parentId = DirectorId;
			insert bill_bankattachment;
			insert att2;
			
		}
		
		if(company_bankattachment.body != null)
		{   	
            company_bankattachment.OwnerId = UserInfo.getUserId();
            company_bankattachment.ParentId = AppId;
            Attachment att3 = new Attachment();
            company_bankattachment.name=this.name+'-Signature';
		    att3.name = 'Signature';//company_bankattachment.name;
            att3.body = company_bankattachment.body;
            att3.ownerId = UserInfo.getUserId();
            att3.parentId = DirectorId;
			insert company_bankattachment;
			insert att3;
        }	
    }   
}