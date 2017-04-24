public class OrganisationDetailsController {
    
    Public Account originator;
    public Application__c App;
    public Attachment PAttachment;
    
    public string rebateDiscount {get;set;}
    public string customerPercentage {get;set;}
    public string invoiceConsignment {get;set;}
    public string warranty {get;set;}
    public string returnRights {get;set;}
    
    public transient Attachment attachment;
    String origid;
    
    public Attachment GetCAttachment()
    {
        if (attachment == null)
            attachment = new Attachment();
        return attachment;
    }
    
    public OrganisationDetailsController(ApplicationProcess ap)
    {
        this.originator = ap.originator;
        
        if(originator.Directors_Details_Count__c==0)
        {
            List<Opportunity> opp = [Select id,name from Opportunity where AccountId =: originator.id Limit 1];
            if(opp.size() > 0)
            {
                List<OpportunityContactRole> ocr = [Select id,contactid from OpportunityContactRole where opportunityid =: opp[0].id and isprimary = true Limit 1];
                if(ocr.size() > 0)
                {
                    
                    Contact[] c = [Select Id from Contact where id =: ocr[0].contactid and isDeleted = false and Accountid=:originator.id];
                    if(c.size()>0)
                    {
                        originator.Number_of_directors__c='1';
                    }
                    
                }
            }
            else
            {
                originator.Number_of_directors__c=null;
            }
        }
        else if(originator.Directors_Details_Count__c<=10)
        {
            originator.Number_of_directors__c=originator.Directors_Details_Count__c+'';
        }
        else
        {
            originator.Number_of_directors__c='10';
        }
        
        
        this.App = ap.app;
        origid = apexpages.currentpage().getparameters().get('origid');
        
        if(originator.isPracticesFilled__c)
        {
            if(originator.Rebates_Discounts_or_other_Incentives__c)
            {
                rebateDiscount='Yes';
            }
            else
            {
                rebateDiscount='No';
            }
            
            if(originator.Customers_pay_Percentage__c)
            {
                customerPercentage='Yes';
            }
            else
            {
                customerPercentage='No';
            }
            
            if(originator.Invoice_on_Consignment__c)
            {
                invoiceConsignment='Yes';
            }
            else
            {
                invoiceConsignment='No';
            }
            
            if(originator.Offer_Warranties__c)
            {
                warranty='Yes';
            }
            else
            {
                warranty='No';
            }
            
            if(originator.Offer_Return_Rights__c)
            {
                returnRights='Yes';
            }
            else
            {
                returnRights='No';
            }
        }
        
    }
    
   
    public Account GetOriginator()
    {
        return Originator;
    }
    
    public PageReference isOrganisationDetails()
    {
        PageReference p=null;
        
        if(app.Organisation_Details__c == true)
        {
            if( origid != null)
            {
                p = new PageReference('/apex/Directors');
                p.getParameters().put('origid',Origid);
            }
            else  p = new PageReference('/apex/Directors');
        }
        return p;
    }
    
    public void DeleteAttachment(string name,string AppId)
    {
        List<ContentDocument> cv = new List<ContentDocument>();
        List<ContentDocumentLink> cd = new List<ContentDocumentLink>(); 
        List<ContentDocumentLink> att = [Select id,linkedEntityId,ContentDocumentId from ContentDocumentLink where LinkedEntityId =: AppId  ];
        
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
    
    public Id uploadFile(Blob file, String fileName) {
        ContentVersion v = new ContentVersion();
        v.versionData = file;
        v.title = 'CompanyLogo';
        v.pathOnClient =fileName;
        insert v;
        
        ContentVersion cdi=[SELECT ContentDocumentId from ContentVersion where id=:v.id];
        
        ContentDocumentLink cdl=new ContentDocumentLink(ContentDocumentId=cdi.ContentDocumentId, LinkedEntityId=this.App.Id, ShareType='I');
        insert cdl;
        
        return v.id;
        
    }
    
    public PageReference save()
    {
        if(attachment.body!=null)
        {
            try {
                if(attachment.BodyLength > 5242880)
                {
                    ApexPages.addMessage(new ApexPages.message(ApexPages.severity.ERROR,'File Size Limit Exceeded!! You can upload files upto Size 5MB'));
                    return null;
                }
                this.DeleteAttachment('CompanyLogo',this.app.id);
                Id fileid=this.uploadFile(attachment.body, attachment.name);
                originator.OrgLogoId__c = fileid;//Attachment.id;
                update originator;
                app.CompanyLogo__c = true;
            } 
            catch (DMLException e) {
                ApexPages.addMessage(new ApexPages.message(ApexPages.severity.ERROR,'Error uploading attachment'));
                return null;
            }
            finally{
                attachment.body = null;
                attachment = new attachment();
            }
            ApexPages.addMessage(new ApexPages.message(ApexPages.severity.INFO,'Attachment uploaded successfully'));
        }
        
        try
        {
            if(rebateDiscount == 'Yes'){
                originator.Rebates_Discounts_or_other_Incentives__c=true;
            } else if (rebateDiscount == 'No'){
                originator.Rebates_Discounts_or_other_Incentives__c=false;
            } else {
                ApexPages.addmessage(new ApexPages.message(ApexPages.severity.ERROR,'Please provide all required Information'));
                return null;
            }
            
            if(customerPercentage == 'Yes'){
                originator.Customers_pay_Percentage__c=true;
            } else if (customerPercentage == 'No'){
                originator.Customers_pay_Percentage__c=false;
            } else {
                ApexPages.addmessage(new ApexPages.message(ApexPages.severity.ERROR,'Please provide all required Information'));
                return null;
            }
            
            if(invoiceConsignment == 'Yes'){
                originator.Invoice_on_Consignment__c=true;
            } else if (invoiceConsignment == 'No'){
                originator.Invoice_on_Consignment__c=false;
            } else {
                ApexPages.addmessage(new ApexPages.message(ApexPages.severity.ERROR,'Please provide all required Information'));
                return null;
            }
            
            if(warranty == 'Yes'){
                originator.Offer_Warranties__c=true;
            } else if (warranty == 'No'){
                originator.Offer_Warranties__c=false;
            } else {
                ApexPages.addmessage(new ApexPages.message(ApexPages.severity.ERROR,'Please provide all required Information'));
                return null;
            }
            
            if(returnRights == 'Yes'){
                originator.Offer_Return_Rights__c=true;
            } else if (returnRights == 'No'){
                originator.Offer_Return_Rights__c=false;
            } else {
                ApexPages.addmessage(new ApexPages.message(ApexPages.severity.ERROR,'Please provide all required Information'));
                return null;
            }
            
            originator.isPracticesFilled__c=true;
            update originator;
        }
        catch(Exception e)
        { 
            
            return null;
        }
        
        app.Organisation_Details__c=true;
        app.Stage__c = 'Directors';
        update app;  
        PageReference p = new PageReference('/apex/Directors');
        if( origid != null)
        {
            p.getParameters().put('origid',origid);
        }
        return p;
    }
    
    public List<SelectOption> getDecision() {
        
        
        List<SelectOption> options = new List<SelectOption>(); 
        options.add(new SelectOption('Yes','Yes')); 
        options.add(new SelectOption('No','No')); 
        return options; 
    }   
}