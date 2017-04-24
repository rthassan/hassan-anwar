public class ApplicationBankDetailsController {
    
    public Account originator;
    public Bank_Account__c BankAccount;
    public Application__c App;
    public transient Attachment attachment;    
    String origid;
    
    public Attachment GetBAttachment()
    {
        if (attachment == null)
            attachment = new Attachment();
        return attachment;
    }
    
    public ApplicationBankDetailsController(ApplicationProcess ap)
    {
        this.originator = ap.originator;
        this.App = ap.app;
        origid = apexpages.currentpage().getparameters().get('origid');
    }
    
    public Bank_Account__c GetBankAccountInformation()
    {
        attachment = new Attachment();
        if(BankAccount == null)
        {
            List<Bank_Account__c> BAccs = [Select id,Name,Account__c,Bank__c,Bank_Account_Number__c,CurrencyIsoCode,IBAN_Number__c,Sort_Code__c,Swift_Code__c
                                           from Bank_Account__c where Account__c =: this.originator.id];
            
            if(BAccs.size() > 0)
            {
                BankAccount = BAccs[0];
                system.debug(BankAccount);
            }
            else
            {
                BankAccount = new Bank_Account__c();
                BankAccount.Account__c = this.originator.id;
                system.debug(BankAccount);
            }
            
        }
        return BankAccount;
    }
    
    public PageReference isBankDetails()
    {
        PageReference p=null;
        
        if(app.Bank_Accounts__c == true)
        {
            if( origid != null)
            {
                p = new PageReference('/apex/Debtor');
                p.getParameters().put('origid',Origid);
            }
            else  p = new PageReference('/apex/Debtor');
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
    
    public void InsertAttachment(Blob a, string name, string pathname, string cid)
    {
        ContentVersion cv = new ContentVersion();
        cv.title = name;      
        cv.PathOnClient = '/' + pathname ; //test img.jpeg           
        cv.VersionData =a;   
        insert cv; 
        
        ContentDocumentLink link = new ContentDocumentLink();
        link.LinkedEntityId = cid;
        link.ContentDocumentId = [SELECT Id, ContentDocumentId FROM ContentVersion WHERE Id =: cv.Id].ContentDocumentId;
        link.ShareType = 'I';
        link.Visibility = 'AllUsers';
        insert link;
    }
    
    public PageReference save()
    {
        if(attachment.body != null)
        {
            try {
                if(attachment.BodyLength > 5242880)
                {
                    ApexPages.addMessage(new ApexPages.message(ApexPages.severity.ERROR,'File Size Limit Exceeded!! You can upload files upto Size 5MB'));
                    return null;
                }
                this.deleteAttachment('BankStatement',this.App.Id);
                this.insertAttachment(attachment.body,'BankStatement',attachment.name,this.App.id);
                app.BankStatement__c = true;
            } catch (DMLException e) {
                ApexPages.addMessage(new ApexPages.message(ApexPages.severity.ERROR,'Error uploading attachment'));
                return null;
            }
            ApexPages.addMessage(new ApexPages.message(ApexPages.severity.INFO,'Attachment uploaded successfully'));
        }
        
        try
        {
            upsert BankAccount;
        }
        catch(Exception e)
        { 
            return null;
        }
        
        
        app.Bank_Accounts__c=true;
        app.Stage__c='Debtors';
        update app;
        
        PageReference p = new PageReference('/apex/Debtor');
        if( origid != null)
        {
            p.getParameters().put('origid',origid);
        }
        return p; 
    }
}