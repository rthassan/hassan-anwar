trigger TriggerOnDebtor on Contact (after insert,after update,before delete,before insert,before update) {
    
    
    //=================================================================Decrement Directors Count AFter Deletion============================
    if(Trigger.isBefore && Trigger.isDelete)
    {
        for(Contact c : Trigger.old)
        {
            if(c.Director__c == true)
            {
                List<Account> acc = [Select id,name,directors_details_count__c from Account where id =: c.AccountId LImit 1];
                if(acc.size() > 0)
                {
                    acc[0].Directors_Details_Count__c = acc[0].Directors_Details_Count__c - 1;
                    if(acc[0].Directors_Details_Count__c == 0)
                    {
                        acc[0].Number_of_Directors__c = null;
                    }
					else acc[0].Number_of_Directors__c = String.valueof(acc[0].Directors_Details_Count__c);                }
                update acc;
            }
        }
    }
    
    //==================================================================Update Number of Directors in Account==================================================
    
    if(Trigger.isUpdate && Trigger.isBefore)
    {
        for(Integer i=0; i<trigger.new.size(); i++) 
        { 
            if(trigger.new[i].director__c==false && trigger.old[i].director__c==true)
            { 
                List<Account> acc = [Select id,name,directors_details_count__c from Account where id =:trigger.new[i].AccountId LImit 1];
                if(acc.size() > 0)
                {
                    acc[0].Directors_Details_Count__c = acc[0].Directors_Details_Count__c - 1;
                    if(acc[0].Directors_Details_Count__c == 0)
                    {
                        acc[0].Number_of_Directors__c = null;
                    }
                    else acc[0].Number_of_Directors__c = String.valueof(acc[0].Directors_Details_Count__c);
                }
                update acc;
            }
            else if(trigger.new[i].director__c==true && trigger.old[i].director__c==false)
            {
                List<Account> acc = [Select id,name,directors_details_count__c from Account where id =:trigger.new[i].AccountId LImit 1];
                if(acc.size() > 0)
                {
                    acc[0].Directors_Details_Count__c = acc[0].Directors_Details_Count__c + 1;
                    if(acc[0].Directors_Details_Count__c <= 10)
                    {
                    	acc[0].Number_of_Directors__c = String.valueof(acc[0].Directors_Details_Count__c);
                    }
                }
                update acc;
            }
        } 
    }
    
    if((Trigger.isInsert && Trigger.isbefore))
    {
        List<Id> updateAccountIds = new List<Id>();
        List<Account> acc = new List<Account>();
        for(Contact c : trigger.new){
            if(c.director__c ){
                updateAccountIds.add(c.AccountId);
            }
            
        }
        
        for(Account a : [SELECT Id, Name, Number_of_Directors__c, Directors_Details_Count__c, director_added__c  FROM Account WHERE Id IN :updateAccountIds]){
            a.Directors_Details_Count__c = a.Directors_Details_Count__c + 1;
            if(a.Directors_Details_Count__c <= 10)
            {
                a.Number_of_directors__c = String.valueof( a.Directors_Details_Count__c );
            }
            
            acc.add(a);
        }   
        update acc;
    } 
    
    //=================================================================Sending an email to new Debtor Contact=================================================
    if(Trigger.isInsert && Trigger.isAfter)
    {
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
                system.debug(debtor.email);
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
}