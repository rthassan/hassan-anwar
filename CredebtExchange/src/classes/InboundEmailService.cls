global class InboundEmailService implements Messaging.InboundEmailHandler {
	
    
	global Messaging.InboundEmailResult handleInboundEmail(Messaging.InboundEmail email, Messaging.InboundEnvelope envelope)
	{
        RecordType r = [Select Id,SobjectType,Name From RecordType where Name ='Debtor' and SobjectType ='Contact' limit 1];
		String body = email.plainTextBody;
		body = body.toLowerCase();
		
		List<Contact> contacts = [Select id,Account.id,name,email from contact where email =: email.FromAddress 
                                  and recordtypeid =: r.id 
                                  and isdeleted=false
                                 ];
		if(contacts.size() > 0)
		{
			Contact c = contacts[0];
			List<Account> DebtorAccount = [Select id,Originator__c,Trading_Name__c,name,Bank_Details_Changed__c,Bank_Details_Changed_Time__c from Account where id =: c.AccountId];
            
			if(DebtorAccount.size() > 0)
			{
                List<Application__c> app = [Select id,bank_changed__c from APplication__c where Originator__c =: DebtorAccount[0].Originator__c Limit 1];
				if(body.contains('confirm') == true)
				{
                    if(app.size() > 0)
                    {
                        app[0].bank_changed__c = true;
                        update app;
                    }
					DebtorAccount[0].Bank_Details_Changed__c = true;
                    DebtorAccount[0].Bank_Details_Changed_Time__c = System.now();
					update DebtorAccount;
				}
                
                Note note = new Note();
                note.body = body;
                note.ParentId = c.id;
                note.OwnerId = userinfo.getUserId();
                note.title = 'ert';
                //insert note;
			}
            
		}
		return null;
	}
}