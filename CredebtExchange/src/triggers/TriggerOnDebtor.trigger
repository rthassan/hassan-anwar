trigger TriggerOnDebtor on Contact (after insert) {
    
    for(Contact debtor : Trigger.new)
    {
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
            //semail.setsetInReplyTo('');
            Messaging.sendEmail( new Messaging.SingleEmailMessage[] {semail} );
        }
    }

}