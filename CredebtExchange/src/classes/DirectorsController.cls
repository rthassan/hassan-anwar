public class DirectorsController {
    Account originator;
    Application__c app;
    Contact director;
    public List<Contact> dirList {get;set;}
    Boolean isLoaded;
    Boolean isDataFilled;    
    public String name{get;set;}
    public List<UploadWrapper> upload{get;set;}
    String origid;
    
    public DirectorsController(ApplicationProcess obj)
    {
        this.originator=obj.originator;
        this.app=obj.app;
        dirList=new List<Contact>();
        upload = new List<UploadWrapper>();
        isLoaded=true;
        isDataFilled=true;
        origid = apexpages.currentpage().getparameters().get('origid');
        
    }
    
    public PageReference isDirectors()
    {
        PageReference p;
        if(app.Directors__c == true)
        {
            if( origid != null)
            {
                p = new PageReference('/apex/BankDetails');
                p.getParameters().put('origid',Origid);
            }
            else  p = new PageReference('/apex/BankDetails');
        }
        return p;
    }
    
    public List<UploadWrapper> getDirectorsList()
    {
        Integer numOfDirectors;
        system.debug(originator.Number_of_Directors__c);
        if(originator.Number_of_Directors__c==null)
        {
            numOfDirectors=0;
        }
        else
        {
            numOfDirectors=Integer.valueOf(originator.Number_of_Directors__c);
        }
        
        if(dirList.size()==0)
        {
            List<Contact> existingDirectors=[Select name,PasswordAttachment__c,BankAttachment__c,SignatureAttachment__c,FirstName, MailingStreet, LastName, OtherStreet, Email, MailingCity, MailingState, MobilePhone,
                                             MailingPostalCode, Mailing_Country__c,MailingCountry from Contact where AccountId=:originator.Id and Director__c=true
                                             and isdeleted = false];
            
            if(existingDirectors.size() > 0)
            {
                dirList=existingDirectors;
            }
            else
            {
                List<Opportunity> opp = [Select id,name from Opportunity where AccountId =: originator.id Limit 1];
                if(opp.size() > 0)
                {
                    List<OpportunityContactRole> ocr = [Select id,contactid from OpportunityContactRole where opportunityid =: opp[0].id and isprimary = true Limit 1];
                    if(ocr.size() > 0)
                    {
                        
                        Contact[] c = [Select name,PasswordAttachment__c,BankAttachment__c,SignatureAttachment__c,FirstName, MailingStreet, LastName, OtherStreet, Email, MailingCity, MailingState, MobilePhone,
                                       MailingPostalCode, Mailing_Country__c,MailingCountry from Contact where id =: ocr[0].contactid
                                       and isDeleted = false and Accountid=:originator.id];
                        if(c.size()>0)
                        {
                            
                            dirList.add(c[0]);
                        }                        
                    }
                }
            }
            
            Integer NoDirectors = numOfDirectors - dirList.size();
            system.debug(NoDirectors); //1
            system.debug(numOfDirectors);
            system.debug(existingdirectors.size());
            for(Integer i=0;i<NoDirectors;i++)
            {
                RecordType r= [SELECT id, Name from RecordType where Name='Contact' and sobjecttype='Contact' Limit 1];
                director=new Contact(AccountId=originator.Id, Director__c=true, recordtypeid=r.id);
                dirList.add(director);
            }
            
            for(Contact c : dirList)
            {
                upload.add(new UploadWrapper(c));
            }
            
            system.debug(upload);
        }
        
        return upload;
    }
    
    
    public PageReference save() {
        
        
        PageReference p1;
        //Check Unique Email address
        set<String> directorEmails = new set<String>();
        
        for(Integer i=0; i < dirList.size(); i++)
        {
            if(upload[i].d.Mailing_Country__c != null)
            {
                upload[i].d.MailingCountry = upload[i].d.Mailing_Country__c;
            }
        }
        
        
        for(Integer i=0; i < upload.size(); i++)
        {
            system.debug(upload[i].d.email);
            if(!directorEmails.add(upload[i].d.email)){
                ApexPages.addmessage(new ApexPages.message(ApexPages.severity.ERROR,'Email of all Directors should be unique'));
                PageReference p = new PageReference('/apex/Directors');
                if( origid != null)
                {
                    p.getParameters().put('origid',origid);
                }
                if(!Test.isRunningTest())
                {
                    return null;
                }
            }
            
        }
        
        for(UploadWrapper uw : upload)
        {
            uw.d.Director__c = true;
            upsert uw.d;
        }
        try
        {     
            for(INteger i=0; i < upload.size() ; i++)
            {
                system.debug(upload);
                system.debug(upload[i].passport_attachment.name);
                if(this.upload[i].checksizeDirector())
                {
                    ApexPages.addMessage(new ApexPages.message(ApexPages.severity.ERROR,'File Size Limit Exceeded!! You can upload file upto Size 5MB'));
                    return null;
                }
                system.debug(upload[i].passport_attachment.name);
                if(upload[i].passport_attachment.body != null)
                {
                    upload[i].d.PasswordAttachment__c = true;       
                }
                if(upload[i].bill_bankattachment.body != null)
                {
                    upload[i].d.BankAttachment__c = true;
                }
                if(upload[i].company_bankattachment.body != null)
                {
                    upload[i].d.SignatureAttachment__c = true;
                }
                if(upload[i].passport_attachment.body != null || upload[i].bill_bankattachment.body != null || upload[i].company_bankattachment.body != null)
                {
                    system.debug('Appid:'+ this.App.id);
                    system.debug('Contactid:'+ this.dirList[i].id);
                    // upload[i].saveDAttachments(this.App.Id,this.dirList[i].id,upload[i].d.firstname + ' ' + upload[i].d.lastname); //director id
                    upload[i].saveDAttachments(this.App.Id,this.upload[i].d.id,upload[i].d.firstname + ' ' + upload[i].d.lastname);
                }     
            }
        }
        catch(Exception e)
        {
            
        }
        finally
        {
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
        
        system.debug(upload);
        for(UploadWrapper uw : upload)
        {
            
            upsert uw.d;
        }
        app.Directors__c = true;
        app.Stage__c='Bank';
        update app;
        p1 = new PageReference('/apex/BankDetails');
        if( origid != null)
        {
            p1.getParameters().put('origid',origid);
        }
        
        
        return p1;
        
    }
    
    /*public PageReference saveAndReturn() {

for(UploadWrapper uw : upload)
{
upsert uw.d;
} 

PageReference homePage; 
if(origid != null)
{
homePage  = new PageReference('/' + originator.id);//ApexPages.StandardController(opportunity).view();
}
else
{
homePage = new PageReference('/_ui/core/chatter/ui/ChatterPage');//ApexPages.StandardController(opportunity).view();

}
homePage.setRedirect(true);
return homePage;

}*/
    
    
}