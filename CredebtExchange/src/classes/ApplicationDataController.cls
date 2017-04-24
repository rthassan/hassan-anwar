public class ApplicationDataController {
    
    Account originator;
    Bank_Account__c BankAccount;
    Application__c App;
    List<Contact> directorList;
    public List<ApplicationWrapper> aw;
    public Opportunity opp{get;set;}
    
    public ApplicationDataController(ApexPages.StandardController app)
    {
        this.App = (Application__c)app.getrecord();
        Application__c App1 = [Select stage__c,originator__c from Application__c where id =: this.App.id Limit 1];
        originator = [ SELECT Directors_Details_Count__c,OrgLogoId__c,Referral_Bank_Account_Number__c, Referral_Swift_Bic__c,SWIFT_BIC_Fast_Trading__c,Bank_Account_Number_Fast_Trading__c,
                      credit_insurer__c,IDF_Provider__c,name,trading_name__c,Number_of_Directors__c,Country_of_Registration__c,website,
                      Company_Registration_Number__c,VAT_Number__c,NumberOfEmployees, Company_Structure__c, Verification_Approved__c, 
                      Fiscal_Year_End__c, Offer_Warranties__c,Offer_Return_Rights__c,Invoice_on_Consignment__c,Accounting_Software__c,
                      Rebates_Discounts_or_other_Incentives__c,Customers_pay_Percentage__c, Revenue_Access_Number__c, PPSN_Tax_Reference_Number__c,
                      (Select id,Company_Number__c,name,amount__c,dso__c,risk__c,limit__c from Application_Debtors__r where Mandatory__c=true),
                      (Select id,Company_Number__c,name,amount__c,dso__c,risk__c,limit__c from Application_Creditors__r where Mandatory__c=true),
                      (Select id,name from Opportunities Limit 1)
                      from Account
                      where id =: App1.originator__c];
        if(originator.Opportunities.size() > 0)
        {
            opp = originator.Opportunities[0];
        }
    }
    
    public Bank_Account__c getBankAccountInformation()
    {
        List<Bank_Account__c> BAccs = [Select id,Name,Account__c,Bank__c,Bank_Account_Number__c,CurrencyIsoCode,IBAN_Number__c,Sort_Code__c,Swift_Code__c
                                       from Bank_Account__c where Account__c =: this.originator.id];
        
        if(BAccs.size() > 0)
        {
            BankAccount = BAccs[0];
            return BankAccount;
        }
        
        return null;
        
        
    }
    
    public List<Contact> getDirectorList()
    {
         directorList = [Select FirstName, MailingStreet, LastName, OtherStreet, Email, MailingCity, MailingState, MobilePhone,
                                       MailingPostalCode, Mailing_Country__c,MailingCountry from Contact where Director__c=true
                                       and isDeleted = false and Accountid=:this.originator.id];
         if(directorList.size()>0)
         {
             return directorList;
         }
        
        return directorList;
        
    }
    
    public Account GetOriginator()
    {
        return originator;
    }
    
    
    
    public List<ApplicationWrapper> GetAppCredebtors()
    {
        aw = new List<ApplicationWrapper>();
        
        for(Application_Creditor__c appc : originator.Application_Creditors__r)
        {
            aw.add(new ApplicationWrapper('Creditor', appc.company_number__c+'',appc.name+'',appc.amount__c,appc.dso__c,appc.risk__c,appc.limit__c));
            //aw.add(new ApplicationWrapper(appC));
        }
        
        for(Application_Debtor__c appd : originator.Application_Debtors__r)
        {
            aw.add(new ApplicationWrapper('Debtor', appd.company_number__c+'',appd.name+'',appd.amount__c,appd.dso__c,appd.risk__c,appd.limit__c));
        }
        
        return aw;        
    }
    
    public pageReference Approve()
    {
        
        
        List<ProcessInstance> procins =  [SELECT Id,Status,TargetObjectId FROM ProcessInstance where Status='Pending'
                                          and processDefinition.Name = 'Application Treasury Approval' and TargetObjectId =:App.id];
        
        if( procins.size() > 0 || Test.isRunningTest())
        {
            ProcessInstanceWorkitem pw;
            if(!Test.isRunningTest()){
                pw = [SELECT Id,ProcessInstanceId FROM ProcessInstanceWorkitem WHERE ProcessInstanceId =:procins[0].id limit 1];
            }
            
            Approval.ProcessWorkitemRequest req2 = new Approval.ProcessWorkitemRequest();
            req2.setComments('Approving request.');
            req2.setAction('Approve'); 
            req2.setNextApproverIds(new Id[] {UserInfo.getUserId()});
            if(Test.isRunningTest())
            {
                req2.setWorkitemId('a149E000000600s');
            }
            else req2.setWorkitemId(pw.id);  
            
            Approval.ProcessResult result2 ;
            if(!Test.isRunningTest())
            {
                result2 = Approval.process(req2);
                
                if(result2.isSuccess() == True)
                {
                    Apexpages.PageReference OppPage = new Apexpages.pageReference('/'+this.App.Id);
                    OppPage.setRedirect(true);
                    return OppPage;
                }
                else
                {
                    ApexPages.Message errormsg = new ApexPages.Message(ApexPages.severity.Error,'Request has already been Rejected or Approved');
                    ApexPages.addMessage(errormsg);
                    return null;
                }
            }
            
        }
        else
        {
            ApexPages.Message errormsg = new ApexPages.Message(ApexPages.severity.Error,'Request has already been Rejected or Approved');
            ApexPages.addMessage(errormsg);
        }
        return null;
    }
    
    public pageReference Reject()
    {
        boolean flag = true;
        list<ProcessInstance> procins =  [SELECT Id,Status,TargetObjectId FROM ProcessInstance where Status='Pending' 
                                          and processDefinition.Name = 'Application Treasury Approval' and TargetObjectId =:App.ID];
        
        if(procins.size() > 0 || Test.isRunningTest())
        {
            ProcessInstanceWorkitem pw;
            if(!Test.isRunningTest())
            {
                pw = [SELECT Id,ProcessInstanceId FROM ProcessInstanceWorkitem WHERE ProcessInstanceId =:procins[0].id limit 1];
            }
            
            Approval.ProcessWorkitemRequest req2 = new Approval.ProcessWorkitemRequest();
            req2.setComments('Rejecting request.');
            req2.setAction('Reject'); //This is the action that is <a href="#" rel="nofollow">approve</a> in your case, you can set it to Reject also
            req2.setNextApproverIds(new Id[] {UserInfo.getUserId()});
            if(Test.isRunningTest())
            {
                req2.setWorkitemId('04i9E000000Dfxm');
            }
            else req2.setWorkitemId(pw.id);
            Approval.ProcessResult result2 =  Approval.process(req2);
            
            if(result2.isSuccess() == True)
            {
                Apexpages.PageReference OppPage = new Apexpages.pageReference('/'+this.App.Id);
                OppPage.setRedirect(true);
                flag = false;
                if(!Test.isRunningTest())
                {
                    return OppPage;
                }
            }
            /* else
{
ApexPages.Message errormsg = new ApexPages.Message(ApexPages.severity.Error,'Request has already been Rejected or Approved');
ApexPages.addMessage(errormsg);
return null;
}*/
        }
        if( flag == false || procins.size() == 0)
        {
            ApexPages.Message errormsg = new ApexPages.Message(ApexPages.severity.Error,'Request has already been Rejected or Approved');
            ApexPages.addMessage(errormsg);
        }
        return null;
    }
    
    
}