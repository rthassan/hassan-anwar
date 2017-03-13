trigger ApplicationTrigger on Application__c (after update) {
   
    
    //submit for verification approval
    Application__c app = Trigger.new[0];
   if(app.Details_Confirmed__c == true && Trigger.old[0].Details_Confirmed__c == false){
        List<Account> account = [Select Name, Submit_Verification_Approval__c 
                           From Account where Id = :app.Originator__c];
        
       if(account.size() > 0)
       {
           account[0].Submit_Verification_Approval__c = true;
           update account;
       }
    }
    
    
    //submit for treasury approval
    if(app.Upload_Stage__c == true && Trigger.old[0].Upload_Stage__c == false){
        
        Application_Debtor__c[] debtors = [Select Name, Submit_Treasury_Approval__c 
                                           From Application_Debtor__c where Originator__c = :app.Originator__c];
        for (Application_Debtor__c d : debtors) {
            d.Submit_Treasury_Approval__c = true;   
            update d;
        }
        
        Application_Creditor__c[] creditors = [Select Name, Submit_Treasury_Approval__c 
                                           From Application_Creditor__c where Originator__c = :app.Originator__c];
        for (Application_Creditor__c c : creditors) {
            c.Submit_Treasury_Approval__c = true;   
            update c;
        }
        //called by application trigger
        Approval.ProcessSubmitRequest req1 = new Approval.ProcessSubmitRequest();
        req1.setComments('Submitting request for approval..');
        req1.setObjectId(app.Id);
        
        List<User> u=[SELECT Id from User where Originator_Id__c=:app.Originator__c];
        if(u.size()>0)
        {
            req1.setSubmitterId(u[0].id);
        }
        else
        {
            req1.setSubmitterId('0059E000000Jbdz');//UserInfo.getUserId());
        }
        
        
        req1.setProcessDefinitionNameOrId('Application_Treasury_Approval');
        req1.setSkipEntryCriteria(true);
        Approval.ProcessResult result = Approval.process(req1);
    }
}