public class ApprovalPageDebtorController {
    public String processId;
    public String debtorId;
    public ProcessInstance objProcessInstance;
    public Application_Debtor__c objDebtor {get; set;}
    public PageReference redirectPage;
    public PageReference afterApprovePage;
    
    public List<Application_Bank_Account__c> appBanks;
    
    public ApprovalPageDebtorController(){
        processId = ApexPages.currentPage().getParameters().get('id');
        debtorId = ApexPages.currentPage().getParameters().get('debtorId');
        objDebtor = [select Name,Comments__c from Application_Debtor__c where id =:debtorId];
        redirectPage = new PageReference('/001/o');
        afterApprovePage =  new PageReference('/apex/ConvertDebtor?debtorId='+debtorId);
        
        appBanks=[Select Name, Bank_Name__c, IBAN_Number__c, Bank_Account_Number__c, Swift_Code__c, CurrencyIsoCode,
                                            Sort_Code__c from Application_Bank_Account__c where Application_Debtor__c=:debtorId];
        
    }
    
    public PageReference Approve(){
        Approval.ProcessWorkitemRequest req = new Approval.ProcessWorkitemRequest();
        req.setComments(objDebtor.Comments__c);
        req.setAction('Approve');
        req.setWorkitemId(processId);
        Approval.ProcessResult result =  Approval.process(req);
        update objDebtor;
        return afterApprovePage ;
    }
    
    public PageReference Reject(){
        Approval.ProcessWorkitemRequest req = new Approval.ProcessWorkitemRequest();
        req.setComments(objDebtor.Comments__c);
        req.setAction('Reject');
        req.setWorkitemId(processId);
        Approval.ProcessResult result =  Approval.process(req);
        update objDebtor;
        
        delete objDebtor;
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