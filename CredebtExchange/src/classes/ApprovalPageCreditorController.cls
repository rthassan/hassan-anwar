public class ApprovalPageCreditorController {
    public String processId;
    public String creditorId;
    public ProcessInstance objProcessInstance;
    public Application_Creditor__c objCreditor {get; set;}
    public PageReference redirectPage;
    public PageReference afterApprovePage;
    
    public List<Application_Bank_Account__c> appBanks;
    
    public ApprovalPageCreditorController(){
        processId = ApexPages.currentPage().getParameters().get('id');
        creditorId = ApexPages.currentPage().getParameters().get('creditorId');
        objCreditor = [select Name,Comments__c from Application_Creditor__c where id =:creditorId];
        redirectPage = new PageReference('/001/o');
        afterApprovePage =  new PageReference('/apex/ConvertCreditor?creditorId='+creditorId);
        
        appBanks=[Select Name, Bank_Name__c, IBAN_Number__c, Bank_Account_Number__c, Swift_Code__c, CurrencyIsoCode,
                                            Sort_Code__c from Application_Bank_Account__c where Application_Creditor__c=:creditorId];
        
    }
    
    public PageReference Approve(){
        Approval.ProcessWorkitemRequest req = new Approval.ProcessWorkitemRequest();
        req.setComments(objCreditor.Comments__c);
        req.setAction('Approve');
        req.setWorkitemId(processId);
        Approval.ProcessResult result =  Approval.process(req);
        update objCreditor;
        return afterApprovePage ;
    }
    
    public PageReference Reject(){
        Approval.ProcessWorkitemRequest req = new Approval.ProcessWorkitemRequest();
        req.setComments(objCreditor.Comments__c);
        req.setAction('Reject');
        req.setWorkitemId(processId);
        Approval.ProcessResult result =  Approval.process(req);
        update objCreditor;
        
        delete objCreditor;
        if(appBanks.size()>0)
        {
            delete appBanks[0];
        }
        
        return redirectPage ;      
    }
    
    public PageReference Cancel(){
        return redirectPage;
    }
}