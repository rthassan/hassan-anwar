public class newExternalFileController {
	
    public external_file__c vFile {get; set;}
    public Id accountId {get; set;}
    public Id caseId {get; set;}
    public Id leadId {get; set;}
    public Id opportunityId {get; set;}
    
    public newExternalFileController(apexpages.StandardController control){
        vFile = new External_File__c();
        
        accountId = apexpages.currentPage().getParameters().get('CF00N0Y000006FYCn_lkid');
        caseId = apexpages.currentPage().getParameters().get('CF00N0Y000006FYCo_lkid');
        leadId = apexpages.currentPage().getParameters().get('CF00N0Y000006FYCs_lkid');
        opportunityId = apexpages.currentPage().getParameters().get('CF00N0Y000006FYCt_lkid');
        
        vFile.account__c = apexpages.currentPage().getParameters().get('CF00N0Y000006FYCn_lkid');
        vFile.case__c = apexpages.currentPage().getParameters().get('CF00N0Y000006FYCo_lkid');
        vfile.Lead__c = apexpages.currentPage().getParameters().get('CF00N0Y000006FYCs_lkid');
        vfile.opportunity__c = apexpages.currentPage().getParameters().get('CF00N0Y000006FYCt_lkid');
        
    }
    
    public pageReference save(){
        string parentId;
        if(accountId != null){
            parentId = accountId;
            vfile.Account__c = accountId;
        }
        if(caseId != null){
            parentId = caseId;
            vfile.Case__c = caseId;
        }
        if(leadId != null){
            parentId = leadId;
            vFile.Lead__c = leadId;
        }
        if(opportunityId != null){
            parentId = opportunityId;
            vfile.Opportunity__c = opportunityId;
        }
        pageReference home = new PageReference('/'+parentId);
        
        //vfile.Name = vFile.Filename__c.right(80);
        insert vFile;
        
        return home;                
    }
}