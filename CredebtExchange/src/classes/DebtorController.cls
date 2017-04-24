public class DebtorController {
    
    Account originator;
    Application__c app;
    Application_Debtor__c debtor {get;set;}
    
    public List<Application_Debtor__c> debtorsList;
    public transient Attachment attachment;
    String origid;
    
    public Attachment GetEAttachment()
    {
        if (attachment == null)
            attachment = new Attachment();
        return attachment;
    }
    
    public DebtorController(ApplicationProcess obj)
    {
        this.originator=obj.originator;
        this.app=obj.app;
        
        debtorsList=[SELECT Id,Experience_File__c,Name, First_Name__c, Last_Name__c, Company_Number__c, 
                     CurrencyIsoCode, Amount__c, Company_Name__c, Trading_Name__c,
                     Previous_Name__c, Originator__c, 
                     Street__c, Street_Bill__c, Zip_Postal_Code__c, Zip_Postal_Code_Bill__c,
                     Phone__c, Mobile__c, City__c, City_Bill__c, 
                     Country__c, Country_Bill__c, 
                     Direct_Dial_Phone__c, Email__c, No_Previous_Trade_History__c, Counterparty_Since__c, Total_Historic_Value__c,
                     Average_Cycle_Payment__c, State_Province__c, State_Province_Bill__c,
                     Credit_Notes_Issued__c, Invoices_Predicted_Per_Annum__c,
                     Predicted_Annual_Revenue__c, isFilled__c,primary_country__c,billing_country__c
                     from Application_Debtor__c where Originator__c=:originator.Id and Mandatory__c=true ORDER BY CreatedDate ASC];
        
        if(debtorsList.size()>0 && originator.Current_Debtor__c < originator.Number_of_App_Debtors__c)
        {
            debtor = debtorsList[(Integer)originator.Current_Debtor__c];
        }
        
        origid = apexpages.currentpage().getparameters().get('origid');
        
    }
    
    
    public Application_Debtor__c getAppDebtor()
    {
        return debtor;
    }
    
    /*public void DeleteAttachment(string n,string OrigId)
{
List<Attachment> att = [Select id,body from Attachment where name =: n and parentId =: OrigId  ];
if(att.size() > 0) { delete att; }

}*/
    
    public void DeleteAttachment(string name)
    {
        List<ContentDocument> cv = new List<ContentDocument>();
        List<ContentDocumentLink> cd = new List<ContentDocumentLink>(); 
        List<ContentDocumentLink> att = [Select id,linkedEntityId,ContentDocumentId from ContentDocumentLink where LinkedEntityId =:this.originator.id  ];
        
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
        
        //check for previous button functionality and attachment giving validation error
        PageReference p;
        if(debtor.Primary_Country__c != null)
        {
            debtor.Country__c = debtor.Primary_Country__c;
        }
        if(debtor.Billing_Country__c != null)
        {
            debtor.Country_Bill__c = debtor.Billing_Country__c;
        }
        
        if(attachment.body != null && debtor.No_Previous_Trade_History__c==false)
        {
            if(attachment.BodyLength > 5242880)
            {
                ApexPages.addMessage(new ApexPages.message(ApexPages.severity.ERROR,'File Size Limit Exceeded!! You can upload files upto Size 5MB'));
                return null;
            }
            this.DeleteAttachment(debtor.name+'-ExperienceFile');
            this.uploadFile(attachment.body, attachment.name, debtor.name+'-ExperienceFile');
            debtor.experience_file__c = true;
        }
        else if(debtor.No_Previous_Trade_History__c==false && debtor.experience_file__c == false)
        {
            ApexPages.addMessage(new ApexPages.message(ApexPages.severity.ERROR,'Provide Experience Document'));
            return null;
        }
        
        //debtor.isFilled__c=true;
        
        originator.Current_Debtor__c++;
        update originator;
        
        update debtor;
        
        //debtorsList=[SELECT Id, Name from Application_Debtor__c where Originator__c=:originator.Id AND isFilled__c=false];
        if( !(originator.Current_Debtor__c+1>originator.Number_of_App_Debtors__c) )
        {
            p = new PageReference('/apex/Debtor');
            if( origid != null)
            {
                p.getParameters().put('origid',origid);
            }
            p.setRedirect(true);
            return p;
        }
        else
        {
            this.app.Debtors_Received__c = true;
            this.app.Stage__c='Creditors';
            update app;
            p = new PageReference('/apex/Creditor');
            if( origid != null)
            {
                p.getParameters().put('origid',origid);
            }
            return p;
        }
        
    }
    
    public PageReference isDebtorsFilled()
    {
        
        PageReference p;
        //debtorsList=[SELECT Id, Name from Application_Debtor__c where Originator__c=:originator.Id AND isFilled__c=false];!(debtorsList.size()>0)
        if( (originator.Current_Debtor__c+1>originator.Number_of_App_Debtors__c && app.Debtors_Received__c==true) || originator.Number_of_App_Debtors__c==0 )
        {
            this.app.Debtors_Received__c = true;
            this.app.Stage__c='Creditors';
            update app;
            
            p = new PageReference('/apex/Creditor');
            if( origid != null)
            {
                p.getParameters().put('origid',origid);
            }
            return p;
        }
        return null;
    }
}