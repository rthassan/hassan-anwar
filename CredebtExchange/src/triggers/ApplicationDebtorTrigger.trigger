trigger ApplicationDebtorTrigger on Application_Debtor__c (after update) {
    Application_Debtor__c d = Trigger.new[0];
    
    if (d.Submit_Treasury_Approval__c == true && Trigger.old[0].Submit_Treasury_Approval__c == false) {
        Approval.ProcessSubmitRequest req1 = new Approval.ProcessSubmitRequest();
        req1.setComments('Submitting request for approval..');
        req1.setObjectId(d.Id);
        
        List<User> u=[SELECT Id from User where Originator_Id__c=:d.Originator__c];
        if(u.size()>0)
        {
            req1.setSubmitterId(u[0].id);
        }
        else
        {
            req1.setSubmitterId('0059E000000Jbdz'); //UserInfo.getUserId());
        }
        
        req1.setProcessDefinitionNameOrId('Application_Debtor_Treasury_Approved');
        req1.setSkipEntryCriteria(true);
        Approval.ProcessResult result = Approval.process(req1);
    }
    
   
}