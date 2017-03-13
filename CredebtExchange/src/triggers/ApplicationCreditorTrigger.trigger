trigger ApplicationCreditorTrigger on Application_Creditor__c (after update) {
    Application_Creditor__c c = Trigger.new[0];
    
    if (c.Submit_Treasury_Approval__c == true && Trigger.old[0].Submit_Treasury_Approval__c == false) {
        Approval.ProcessSubmitRequest req1 = new Approval.ProcessSubmitRequest();
        req1.setComments('Submitting request for approval..');
        req1.setObjectId(c.Id);
        
        List<User> u=[SELECT Id from User where Originator_Id__c=:c.Originator__c];
        if(u.size()>0)
        {
            req1.setSubmitterId(u[0].id);
        }
        else
        {
            req1.setSubmitterId('0059E000000Jbdz');//UserInfo.getUserId());
        }
       
        req1.setProcessDefinitionNameOrId('Application_Creditor_Treasury_Approved');
        req1.setSkipEntryCriteria(true);
        Approval.ProcessResult result = Approval.process(req1);
    }
    
    
}