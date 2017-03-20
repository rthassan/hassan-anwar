trigger TriggerOnDebtor on Contact (after insert) {
    
    for(Contact debtor : Trigger.new)
    {
        String name;
        List<Account> debtorAccounts=[Select Id, Name, Originator__c from Account where id=:debtor.AccountId];
        List<Application__c> app;
        if(debtorAccounts.size()>0)
        {
            List<Account> originatorAccounts=[Select Id, Name, Originator__c from Account where Id=:debtorAccounts[0].Originator__c];
            if(originatorAccounts.size()>0)
            {
                app = [Select id,NoA_Issued__c from Application__c where Originator__c =: originatorAccounts[0].id Limit 1];
                name=originatorAccounts[0].Name;
            }
        }
        
        RecordType debtorid = [Select id,name from RecordType where Name='Debtor' and sObjectType='Contact'];
        EmailTemplate template = [Select id,HtmlValue,Body from EmailTemplate where name = 'NoA Notice Of Ownership' limit 1];  
        if(debtor.RecordTypeId == debtorid.id)
        {
            Messaging.SingleEmailMessage semail = new Messaging.SingleEmailMessage();
            semail.setTargetObjectId(debtor.id);
            //semail.setSubject( subject );
            //semail.setOrgWideEmailAddressId(owea.get(0).Id);
            semail.setToAddresses(new String[]{ debtor.Email });
            semail.setTemplateId(template.Id);
            semail.setTreatTargetObjectAsRecipient(false);
            semail.setsenderDisplayName(name);
            //semail.setsetInReplyTo('');
            if (!Test.isRunningTest()) {
                Messaging.sendEmail( new Messaging.SingleEmailMessage[] {semail} );
            }
            
            if(app.size() > 0)
            {
                app[0].NoA_Issued__c = true;
                update app;
            }
        }
    }

}