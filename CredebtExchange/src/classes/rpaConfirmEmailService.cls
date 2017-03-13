global class rpaConfirmEmailService implements Messaging.InboundEmailHandler {
    
    global Messaging.InboundEmailResult handleInboundEmail(Messaging.inboundEmail email, Messaging.InboundEnvelope env){
        
        Messaging.InboundEmailResult result = new Messaging.InboundEmailResult();
        
        String emailText= '';
        
        // Add the email plain text into the local variable 
        emailText = email.plainTextBody;
        
        if(emailText.trim().left(7).equalsIgnoreCase('confirm'))  {
            // New Task object to be created
            Task[] newTask = new Task[0];
            
            // Try to look up any contacts based on the email from address
            // If there is more than one contact with the same email address,
            // an exception will be thrown and the catch statement will be called.
            try {
                //Contact Con = [SELECT Id, Name, Email FROM Contact WHERE Email = :email.fromAddress LIMIT 1];                
                OpportunityContactRole ocr = [SELECT Id, ContactId, OpportunityId, Contact.Name, Contact.Email FROM OpportunityContactRole WHERE contact.Email = :email.fromAddress /* AND IsPrimary = true */ AND Opportunity.RPA_Status__c = 'Approved'];
                
                Opportunity opp = [SELECT Id, Name, RPA_Status__c, OwnerId FROM Opportunity WHERE Id = :ocr.OpportunityId];
                opp.RPA_Status__c = 'Accepted';
                update opp;
                
                
                // Add a new Task to the contact record we just found above.
                newTask.add(new Task(
                    OwnerId = opp.OwnerId,
                    Subject = 'RPA Accepted - ' + opp.Name,
                    WhoId =  ocr.ContactId,
                    WhatId = opp.Id,
                    Description =  ocr.contact.Name +' has accepted the Provisional RPA Offer that was sent',
                    Priority = 'Normal'
                    //Status = 'Inbound Email',            
                    //IsReminderSet = true,
                    //ReminderDateTime = System.now()+1,
                    
                ));
                
                // Insert the new Task 
                insert newTask;    
                
                System.debug('New Task Object: ' + newTask );   
            }
            // If an exception occurs when the query accesses 
            // the contact record, a QueryException is called.
            // The exception is written to the Apex debug log.
            catch (QueryException e) {
                System.debug('Query Issue: ' + e);
            }
            
            // Set the result to true. No need to send an email back to the user 
            // with an error message
            result.success = true;
            
            
        }
        
        // Return the result for the Apex Email Service
            return result;
        
    }
}