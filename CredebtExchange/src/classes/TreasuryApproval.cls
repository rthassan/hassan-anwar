public with sharing class TreasuryApproval {
    public Boolean isValidated { set; get; }
    public Boolean isSubmitted { set; get; }
    public Application__c app { set; get; }

    public TreasuryApproval(ApexPages.StandardController controller) {      
      app = [select id from Application__c where id = :ApexPages.currentPage().getParameters().get('id')];
    }
    public void SubmitApproval() {
        //called by application trigger
        Approval.ProcessSubmitRequest req1 = new Approval.ProcessSubmitRequest();
        req1.setComments('Submitting request for approval..');
        req1.setObjectId(app.Id);
        req1.setSubmitterId('0059E000000Jbdz');
        req1.setProcessDefinitionNameOrId('Application_Treasury_Approval');
        req1.setSkipEntryCriteria(true);
        Approval.ProcessResult result = Approval.process(req1);
    }
}