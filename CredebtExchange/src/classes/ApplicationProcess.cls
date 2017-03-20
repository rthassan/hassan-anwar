public class ApplicationProcess {
    public string ORIGINATOR_ID;
    public Account originator;
    public Application__c app;
    List<Application__c> Apps;
    
    public ApplicationProcess()
    {
        system.debug('out');
        
        List<User> u=[SELECT Originator_Id__c from User Where Id = :UserInfo.getUserId()];
        if (Test.isRunningTest()) {
            u=[SELECT Originator_Id__c from User Where LastName = 'lastname'];
        }
        if(u.size()>0)
        {
            ORIGINATOR_ID=u[0].Originator_Id__c;
            system.debug('in');
            system.debug(ORIGINATOR_ID);
        }
     
        Apps=[SELECT Id,CheckVerified__c,Logged_In__c,Upload_Stage__c,BankStatement__c, CompanyLogo__c,Refer_A_Friend__c, Credebtors__c, Verification_Approved__c,Organisation_Attachment_Id__c,Bank_Attachment_Id__c,
             Fast_Trading__c, Organisation_Details__c, Bank_Accounts__c,Director_Information__c,Creditors_Received__c,
             Debtors_Received__c,Directors__c, Stage__c from Application__c where Originator__c=:ORIGINATOR_ID];
        
        if(Apps.size() > 0)
        {
            app = Apps[0];
        }
        
        originator = [SELECT OrgLogoId__c,Referral_Bank_Account_Number__c, Referral_Swift_Bic__c,SWIFT_BIC_Fast_Trading__c,Bank_Account_Number_Fast_Trading__c,
                      credit_insurer__c,IDF_Provider__c,name,trading_name__c,Number_of_Directors__c,Country_of_Registration__c,website,
                      Company_Registration_Number__c,VAT_Number__c,NumberOfEmployees, Company_Structure__c, Verification_Approved__c,
                      Fiscal_Year_End__c, Offer_Warranties__c,Offer_Return_Rights__c,Invoice_on_Consignment__c,Accounting_Software__c,
                      Rebates_Discounts_or_other_Incentives__c,Customers_pay_Percentage__c, Revenue_Access_Number__c, PPSN_Tax_Reference_Number__c
                      from Account where Id=:ORIGINATOR_ID];
    }
    
    public PageReference cancel() {
        PageReference homePage = new PageReference('/_ui/core/chatter/ui/ChatterPage');//ApexPages.StandardController(opportunity).view();
        homePage.setRedirect(true);
        return homePage;
    }
    
   

    public PageReference LandingPage()
    {
        if(Apps.size() == 0)
        {
            return new PageReference('/apex/ApplicationStatus');
        }
        
        if(app.Logged_In__c == false)
        {
           app.Logged_In__c = true;
           app.Stage__c='Login';
           update app;
        }
       
        PageReference p;
        if(app.Upload_Stage__c == true || app.Stage__c == 'Submitted')
        {
            p = page.ReviewingApplicationStaticPage;
        }
        else if(app.Creditors_Received__c == true || app.Stage__c == 'Creditors')
        {
            p = page.UploadAttachments;
        }
        else if(app.Debtors_Received__c == true || app.Stage__c == 'Debtors')
        {
             p = Page.Creditor;
        }
        else if(app.Bank_Accounts__c == true || app.Stage__c == 'Bank')
        {
            p = Page.Debtor;
        }
        else if(app.Directors__c == true  || app.Stage__c == 'Directors')
        {
             p = Page.BankDetails; 
        }
        else if(app.Director_Information__c == true)
        {
            p = Page.DirectorDocuments;
        }
        else if(app.Organisation_Details__c == true || app.Stage__c == 'Organisation & Practices')
        {
            p = Page.Directors;
        }
        else if(app.Fast_Trading__c == true || app.Stage__c == 'Fast-Trading')
        {
            p = new PageReference('/apex/OrganisationDetails');
        }
        else if(app.Verification_Approved__c == true || app.Stage__c == 'Verified')
        {
            p = new PageReference('/apex/FastTrading');
        }
        else if(app.Credebtors__c == true || app.Stage__c == 'Credebtors')
        {
            p = new PageReference('/apex/Verified');
           // p.setredirect(true);
        }
        else if(app.Refer_a_Friend__c == true || app.Stage__c == 'Refer-a-Friend')
        {
            p = new PageReference('/apex/SelectOrganisations');
        }
        else
        {
             p = new PageReference('/apex/ReferAFriend');
        }
        return p; 
    }    
}