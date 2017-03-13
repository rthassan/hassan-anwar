public class ApplicationProcess {
    public string ORIGINATOR_ID;
    public Account originator;
    public Application__c app;
    
    public ApplicationProcess()
    {
        List<User> u=[SELECT Originator_Id__c from User Where Id = :UserInfo.getUserId()];
        if(u.size()>0)
        {
            ORIGINATOR_ID=u[0].Originator_Id__c;
        }
     
        app=[SELECT Id,Upload_Stage__c,BankStatement__c, CompanyLogo__c,Refer_A_Friend__c, Details_Confirmed__c, Verification_Approved__c,Organisation_Attachment_Id__c,Bank_Attachment_Id__c,
             Fast_Trading__c, Organisation_Details__c, Bank_Accounts__c,Director_Information__c,Creditors_Received__c,
             Debtors_Received__c,Directors__c from Application__c where Originator__c=:ORIGINATOR_ID];
        
        originator = [SELECT OrgLogoId__c,Referral_Bank_Account_Number__c, Referral_Swift_Bic__c,SWIFT_BIC_Fast_Trading__c,Bank_Account_Number_Fast_Trading__c,
                      credit_insurer__c,IDF_Provider__c,name,trading_name__c,Number_of_Directors__c,Country_of_Registration__c,website,
                      Company_Registration_Number__c,VAT_Number__c,NumberOfEmployees, Company_Structure__c, Verification_Approved__c,
                      Fiscal_Year_End__c, Offer_Warranties__c,Offer_Return_Rights__c,Invoice_on_Consignment__c,Accounting_Software__c,
                      Rebates_Discounts_or_other_Incentives__c,Customers_pay_Percentage__c
                      from Account where Id=:ORIGINATOR_ID];
    }
    
    public PageReference cancel() {
        PageReference homePage = new PageReference('/_ui/core/chatter/ui/ChatterPage');//ApexPages.StandardController(opportunity).view();
        homePage.setRedirect(true);
        return homePage;
    }

    public PageReference LandingPage()
    {
        PageReference p;
        if(app.Upload_Stage__c == true)
        {
            p = page.ReviewingApplicationStaticPage;
        }
        else if(app.Debtors_Received__c == true)
        {
            p = page.UploadAttachments;
        }
        else if(app.Directors__c == true)
        {
            p = Page.Creditor;
        }
        else if(app.Director_Information__c == true)
        {
            p = Page.DirectorsPractices;
        }
        else if(app.Bank_Accounts__c == true)
        {
            p = Page.Directors;
        }
        else if(app.Organisation_Details__c == true)
        {
            p = Page.BankDetails;
        }
        else if(app.Fast_Trading__c == true)
        {
            p = new PageReference('/apex/OrganisationDetails');
        }
        else if(app.Verification_Approved__c == true)
        {
            p = new PageReference('/apex/FastTrading');
        }
        else if(app.Details_Confirmed__c == true)
        {
            p = new PageReference('/apex/Verified');
           // p = new PageReference('/apex/FastTrading');
        }
        else if(app.Refer_a_Friend__c == true)
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