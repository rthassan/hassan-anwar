trigger OriginatorTrigger on Account (after update) {
    Account a = Trigger.new[0];
    /*if (a.Submit_Verification_Approval__c == true && Trigger.old[0].Submit_Verification_Approval__c == false) {
        //if([select count() from ProcessInstance where targetobjectid=:a.Id] < 1)
        
        	Group[] g = [select Id, Name from Group where Type = 'Queue' and Name = 'Trade Desk Queue'];        	
        
            Approval.ProcessSubmitRequest req1 = new Approval.ProcessSubmitRequest();
            req1.setComments('Submitting request for approval..');
            req1.setObjectId(a.Id);
            system.debug(a.Id);//0019E000005NW9D
            req1.setSubmitterId(a.OwnerId);
            req1.setProcessDefinitionNameOrId('Trade_Desk_Verification');
            req1.setSkipEntryCriteria(true);
            req1.setNextApproverIds(new Id[] {g[0].id});
            Approval.ProcessResult result = Approval.process(req1);
    }*/
    
    if (a.Bank_Details_Changed__c == true && Trigger.old[0].Bank_Details_Changed__c == false) {
        //if([select count() from ProcessInstance where targetobjectid=:a.Id] < 1)
        //{
        	Group[] g = [select Id, Name from Group where Type = 'Queue' and Name = 'Treasury Managers Queue'];
        
            Approval.ProcessSubmitRequest req1 = new Approval.ProcessSubmitRequest();
            req1.setComments('Submitting request for approval..');
            req1.setObjectId(a.Id);
            system.debug(a.Id);//0019E000005NW9D
        	req1.setSubmitterId(a.OwnerId);
            /*List<User> u=[SELECT Id from User where Originator_Id__c= :a.Id];
            system.debug(u);
            if(u.size()>0)
            {
                req1.setSubmitterId(u[0].id);
            }
            else
            {
                req1.setSubmitterId('0059E000000Jbdz');//UserInfo.getUserId());
            }*/
            
            req1.setProcessDefinitionNameOrId('Debtors_Authorized');
            req1.setSkipEntryCriteria(true);
            req1.setNextApproverIds(new Id[] {g[0].id});
            Approval.ProcessResult result = Approval.process(req1);
        //}
    }
    
    /*if (a.Verification_Rejected__c == true && Trigger.old[0].Verification_Rejected__c == false) { 
        string acctid = String.valueOf(a.Id).substring(0, 15);
        DeactivateUserOnRejection.DeactivateUser(acctid);
        
    }*/
}