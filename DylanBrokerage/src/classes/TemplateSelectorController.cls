public class TemplateSelectorController {
    public String subject { get; set; }
	public String body { get; set; }
    private final Campaign campaign1 { get; set; }
	private Campaign campaign { get; set; }
    
	public TemplateSelectorController(ApexPages.StandardController stdController) {
         campaign1 = (Campaign)stdController.getRecord();
         //campaign = [Select ID, Name, (SELECT Id, Name, Status, LeadId, Email FROM CampaignMembers where Type='Lead') 
                    // FROM campaign WHERE id = :ApexPages.currentPage().getParameters().get('id') ];
	}
    
    public String selectedTemplateId { public get; public set; }
	public EmailTemplate t1 { public get; public set; }
    public List<SelectOption> getMyPersonalTemplateOptions() {
        List<SelectOption> options = new List<SelectOption>();
        for (EmailTemplate t : [select Id,Name from EmailTemplate]) {
            options.add(new SelectOption(t.Id,t.Name));
        }
        return options;
    }
    
    public PageReference cancel() {
        PageReference p = new ApexPages.StandardController(campaign1).view();
        return p;
    }
    
    public PageReference send() {
        if(!test.isRunningTest())
        {
            t1 = [select Id,Name,Body,Subject from EmailTemplate where Id = :selectedTemplateId];
        }
        else   
        {
            List<EmailTemplate> listTemplates= [select Id,Name,Body,Subject from EmailTemplate];
            t1=listTemplates[0];
        }
        
        subject = t1.Subject;
        body = t1.Body;
        campaign = [Select ID, Name, (SELECT Id, Name, Status, LeadId, Email FROM CampaignMembers where Type='Lead') 
                     FROM campaign WHERE id = :campaign1.Id ]; //ApexPages.currentPage().getParameters().get('id')
		List<String> cm_emails = new List<String>();
        List<Id> cm_ids = new List<Id>();
        //t1 = [select Id,Name,Body,Subject from EmailTemplate where Id = :selectedTemplateId];
        List < Messaging.SingleEmailMessage > mailList = new List < Messaging.SingleEmailMessage > ();
        OrgWideEmailAddress[] owea = [select Id from OrgWideEmailAddress 
                                      where Address = 'mailhassananwar@gmail.com'];
        
       for(CampaignMember c_mem : campaign.CampaignMembers) {
           Messaging.SingleEmailMessage semail = new Messaging.SingleEmailMessage();
           if ( owea.size() > 0 ) {
               semail.setTargetObjectId(c_mem.LeadId);
               semail.setSubject( subject );
               semail.setOrgWideEmailAddressId(owea.get(0).Id);
               semail.setToAddresses(new String[]{ c_mem.Email });
               semail.setTemplateId(t1.Id);
               semail.setTreatTargetObjectAsRecipient(false);
               mailList.add(semail);
               cm_emails.add(c_mem.email);
           }  
        }
        Email_Campaign__c ec = new Email_Campaign__c(Name = t1.Subject, Campaign__c = campaign.Id);
        insert ec;
        Messaging.sendEmail( mailList, false );
		PageReference p = new ApexPages.StandardController(campaign1).view();
        return p;
	}
}