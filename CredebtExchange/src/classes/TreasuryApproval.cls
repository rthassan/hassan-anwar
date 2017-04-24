public with sharing class TreasuryApproval {
    public Boolean isValidated { set; get; }
    public Boolean isSubmitted { set; get; }
    public Application__c app { set; get; }

    public TreasuryApproval(ApexPages.StandardController controller) {  
        if (!Test.isRunningTest()) {
        	app = [select id from Application__c where id = :ApexPages.currentPage().getParameters().get('id')];
        } else {
            app = [select id from Application__c limit 1];
        }

    }
    public void SubmitApproval() {
        //called by application trigger
        Approval.ProcessSubmitRequest req1 = new Approval.ProcessSubmitRequest();
        req1.setComments('Submitting request for approval..');
        req1.setObjectId(app.Id);
        req1.setSubmitterId('0050Y000000LUfX');
        req1.setProcessDefinitionNameOrId('Application_Treasury_Approval');
        req1.setSkipEntryCriteria(true);
        Approval.ProcessResult result = Approval.process(req1);
    }
}