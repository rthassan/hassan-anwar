public class ApplicationProcess {
    public string ORIGINATOR_ID;
    public Account originator;
    public Application__c app{get;set;}
    List<Application__c> Apps;
    @TestVisible String origid{get;set;}
    
    public ApplicationProcess(ApexPages.StandardController OriginatorAccount)
    {
        
        origid = OriginatorAccount.getId();
        List<User> u=[SELECT Originator_Id__c from User Where Id = :UserInfo.getUserId()];
        if (Test.isRunningTest()) {
            u=[SELECT Originator_Id__c from User Where LastName = 'lastname'];
        }
        
        if(Origid != null)
        {
            Originator_ID = OrigId;
            system.debug(Originator_Id);
        }
        else if(u.size()>0)
        {
            ORIGINATOR_ID=u[0].Originator_Id__c;
            system.debug('in');
            system.debug(ORIGINATOR_ID);
        }
        
        
        Apps=[SELECT Id,CheckVerified__c,Logged_In__c,Upload_Stage__c,BankStatement__c, CompanyLogo__c,Refer_A_Friend__c, Credebtors__c, Verification_Approved__c,Organisation_Attachment_Id__c,Bank_Attachment_Id__c,
              Fast_Trading__c, Organisation_Details__c, Bank_Accounts__c,Director_Information__c,Creditors_Received__c,
              Debtors_Received__c,Directors__c, Stage__c, Application_Approval_Status__c from Application__c where Originator__c=:ORIGINATOR_ID];
        
        if(Apps.size() > 0)
        {
            app = Apps[0];
        }
        
        List<Account> Originators = [SELECT isPracticesfilled__c, Directors_Details_Count__c,OrgLogoId__c,Referral_Bank_Account_Number__c, Referral_Swift_Bic__c,SWIFT_BIC_Fast_Trading__c,Bank_Account_Number_Fast_Trading__c,
                                     credit_insurer__c,IDF_Provider__c,name,trading_name__c,Number_of_Directors__c,Country_of_Registration__c,website,
                                     Number_of_App_Creditors__c, Number_of_App_Debtors__c, Current_Creditor__c, Current_Debtor__c,
                                     Company_Registration_Number__c,VAT_Number__c,NumberOfEmployees, Company_Structure__c, Verification_Approved__c,
                                     Fiscal_Year_End__c, Offer_Warranties__c,Offer_Return_Rights__c,Invoice_on_Consignment__c,Accounting_Software__c,
                                     Rebates_Discounts_or_other_Incentives__c,Customers_pay_Percentage__c, Revenue_Access_Number__c, PPSN_Tax_Reference_Number__c
                                     from Account where Id=:ORIGINATOR_ID];
        
        if(Originators.size() > 0)
        {
            originator = Originators[0];
        }
    }
    
    public ApplicationProcess()
    {
        system.debug('DefaultConstructor');
        system.debug(apexpages.currentpage().getparameters().get('origid'));
        origid = apexpages.currentpage().getparameters().get('origid');
        List<User> u=[SELECT Originator_Id__c from User Where Id = :UserInfo.getUserId()];
        if (Test.isRunningTest()) {
            u=[SELECT Originator_Id__c from User Where LastName = 'lastname'];
            origid=u[0].Originator_Id__c;
        }
        
        if(Origid != null)
        {
            Originator_ID = OrigId;
            system.debug(Originator_Id);
        }
        else if(u.size()>0)
        {
            ORIGINATOR_ID=u[0].Originator_Id__c;
            system.debug('in');
            system.debug(ORIGINATOR_ID);
        }
        
        Apps=[SELECT Id,CheckVerified__c,Logged_In__c,Upload_Stage__c,BankStatement__c, CompanyLogo__c,Refer_A_Friend__c, Credebtors__c, Verification_Approved__c,Organisation_Attachment_Id__c,Bank_Attachment_Id__c,
              Fast_Trading__c, Organisation_Details__c, Bank_Accounts__c,Director_Information__c,Creditors_Received__c,
              Debtors_Received__c,Directors__c, Stage__c, Application_Approval_Status__c from Application__c where Originator__c=:ORIGINATOR_ID];
        
        if(Apps.size() > 0)
        {
            app = Apps[0];
        }
        
        List<Account> Originators = [SELECT isPracticesfilled__c, Directors_Details_Count__c,OrgLogoId__c,Referral_Bank_Account_Number__c, Referral_Swift_Bic__c,SWIFT_BIC_Fast_Trading__c,Bank_Account_Number_Fast_Trading__c,
                                     credit_insurer__c,IDF_Provider__c,name,trading_name__c,Number_of_Directors__c,Country_of_Registration__c,website,
                                     Number_of_App_Creditors__c, Number_of_App_Debtors__c, Current_Creditor__c, Current_Debtor__c,
                                     Company_Registration_Number__c,VAT_Number__c,NumberOfEmployees, Company_Structure__c, Verification_Approved__c,
                                     Fiscal_Year_End__c, Offer_Warranties__c,Offer_Return_Rights__c,Invoice_on_Consignment__c,Accounting_Software__c,
                                     Rebates_Discounts_or_other_Incentives__c,Customers_pay_Percentage__c, Revenue_Access_Number__c, PPSN_Tax_Reference_Number__c
                                     from Account where Id=:ORIGINATOR_ID];
        
        if(Originators.size() > 0)
        {
            originator = Originators[0];
        }
    }
    
    public PageReference cancel() {
        
        PageReference homePage; 
        if(apexpages.currentpage().getparameters().get('origid') != null)
        {
            homePage  = new PageReference('/' + originator.id);//ApexPages.StandardController(opportunity).view();
        }
        else
        {
            homePage = new PageReference('/apex/OriginatorInformation?id='+ Originator.id);//ApexPages.StandardController(opportunity).view();

        }
        homePage.setRedirect(true);
        return homePage;
    }
    
    public PageReference LandingPage()
    {
        //return new PageReference('/apex/ApplicationMain');
        
        if(Apps.size() == 0)
        {
            if( origid != null)
            {
                PageReference p1 = new PageReference('/apex/ApplicationStatus');
                p1.getParameters().put('origid',Originator_id);
                return p1;
            }
            else return new PageReference('/apex/ApplicationStatus');
            
        }
        
        if(app.Logged_In__c == false)
        {
            app.Logged_In__c = true;
            app.Stage__c='Refer-a-Friend';
            update app;
        }
        
        PageReference p;
        if(app.Upload_Stage__c == true)
        {
            if( origid != null)
            {
                p = new PageReference('/apex/ReviewingApplicationStaticPage');
                p.getParameters().put('origid',Originator_id);
            }
            else  p = new PageReference('/apex/ReviewingApplicationStaticPage');
        }
        else if(app.Creditors_Received__c == true)
        {
            if( origid != null)
            {
                p = new PageReference('/apex/UploadAttachments');
                p.getParameters().put('origid',Originator_id);
            }
            else  p = new PageReference('/apex/UploadAttachments');
        }
        else if(app.Debtors_Received__c == true)
        {
            if( origid != null)
            {
                p = new PageReference('/apex/Creditor');
                p.getParameters().put('origid',Originator_id);
            }
            else  p = new PageReference('/apex/Creditor');
        }
        else if(app.Bank_Accounts__c == true)
        {
            if( origid != null)
            {
                p = new PageReference('/apex/Debtor');
                p.getParameters().put('origid',Originator_id);
            }
            else  p = new PageReference('/apex/Debtor');
        }
        else if(app.Directors__c == true)
        {
            if( origid != null)
            {
                p = new PageReference('/apex/BankDetails');
                p.getParameters().put('origid',Originator_id);
            }
            else  p = new PageReference('/apex/BankDetails');
        }
        else if(app.Organisation_Details__c == true)
        {
            if( origid != null)
            {
                p = new PageReference('/apex/Directors');
                p.getParameters().put('origid',Originator_id);
            }
            else  p = new PageReference('/apex/Directors');
        }
        else if(app.Fast_Trading__c == true)
        {
            if( origid != null)
            {
                p = new PageReference('/apex/OrganisationDetails');
                p.getParameters().put('origid',Originator_id);
            }
            else  p = new PageReference('/apex/OrganisationDetails');
        }
        
        else if(app.Credebtors__c == true)
        {
            if( origid != null)
            {
                p = new PageReference('/apex/FastTrading');
                p.getParameters().put('origid',Originator_id);
            }
            else  p = new PageReference('/apex/FastTrading');
        }
        else if(app.Refer_a_Friend__c == true)
        {
            if( origid != null)
            {
                p = new PageReference('/apex/SelectOrganisations');
                p.getParameters().put('origid',Originator_id);
                
            }
            else  p = new PageReference('/apex/SelectOrganisations');
        }
        else
        {
            if( origid != null)
            {
                p = new PageReference('/apex/ReferAFriend');
                p.getParameters().put('origid',Originator_id);
            }
            else  p = new PageReference('/apex/ReferAFriend');
        }
        return p; 
    }  
    
    public PageReference Back1()  //select organisations
    {
        PageReference p; 
        app.Refer_A_Friend__c=false;
        app.Stage__c = 'Refer-a-Friend';
        update app;
        system.debug(origid);
        if( origid != null)
        {
            p = new PageReference('/apex/ReferAFriend');
            p.getParameters().put('origid',Originator_id);
        }
        else  p = new PageReference('/apex/ReferAFriend');
        return p;
    }
    
    public PageReference Back2() //fast trading
    {
        PageReference p; 
        app.Credebtors__c=false;
        app.Stage__c = 'Credebtors';
        update app;
        if( origid != null)
        {
            p = new PageReference('/apex/SelectOrganisations');
            p.getParameters().put('origid',Originator_id);
            
        }
        else  p = new PageReference('/apex/SelectOrganisations');
        return p;
    }
    
    public PageReference Back3() //organisation details
    {
        PageReference p; 
        app.Fast_Trading__c=false;
        app.Stage__c = 'Fast-Trading';
        update app;
        if( origid != null)
        {
            p = new PageReference('/apex/FastTrading');
            p.getParameters().put('origid',Originator_id);
        }
        else  p = new PageReference('/apex/FastTrading');
        return p;
    }
    
    public PageReference Back4() //directors information
    {
        
        PageReference p; 
        app.Organisation_Details__c=false;
        app.stage__c = 'Organisation & Practices';
        update app;
        if( origid != null)
        {
            p = new PageReference('/apex/OrganisationDetails');
            p.getParameters().put('origid',Origid);
        }
        else  p = new PageReference('/apex/OrganisationDetails');
        return p;
    }
    
    
    public PageReference Back5() //directors
    {
        PageReference p;
        app.Directors__c = false;
        app.stage__c = 'Directors';
        update app;
        if( origid != null)
        {
            p = new PageReference('/apex/Directors');
            p.getParameters().put('origid',Originator_id);
        }
        else  p = new PageReference('/apex/Directors');
        return p;
    }
    
    
    
    public PageReference Back6() //debtors
    {
        if(originator.Current_Debtor__c-1 < 0)
        {
            PageReference p; 
            app.Bank_Accounts__c=false;
            app.Stage__c='Bank';
            update app;
            if( origid != null)
            {
                p = new PageReference('/apex/BankDetails');
                p.getParameters().put('origid',Originator_id);
            }
            else  p = new PageReference('/apex/BankDetails');
            return p;
        }
        else
        {
            PageReference p; 
            if( origid != null)
            {
                p = new PageReference('/apex/Debtor');
                p.getParameters().put('origid',Originator_id);
            }
            else  p = new PageReference('/apex/Debtor');
            p.setRedirect(true);
            
            if(originator.Current_Debtor__c!=0)
            {
                originator.Current_Debtor__c--;
                update originator;
            }
            
            return p;
        }
        
    }
    
    public PageReference Back7() //creditors
    {
        if(originator.Current_Creditor__c-1 < 0)
        {
            if(originator.Number_of_App_Debtors__c>0)
            {
                PageReference p; 
                app.Debtors_Received__c=false;
                app.Stage__c='Debtors';
                update app;
                if( origid != null)
                {
                    p = new PageReference('/apex/Debtor');
                    p.getParameters().put('origid',Originator_id);
                }
                else  p = new PageReference('/apex/Debtor');
                
                if(originator.Current_Debtor__c>0)
                {
                    originator.Current_Debtor__c--;
                    update originator;
                }
                
                return p;
            }
            else
            {
                PageReference p;
                app.Debtors_Received__c = false;
                app.Bank_Accounts__c=false;
                app.Stage__c='Bank';
                update app;
                if( origid != null)
                {
                    p = new PageReference('/apex/BankDetails');
                    p.getParameters().put('origid',Originator_id);
                }
                else  p = new PageReference('/apex/BankDetails');
                
                return p;
            }
            
            
        }
        else
        {
            PageReference p; 
            if( origid != null)
            {
                p = new PageReference('/apex/Creditor');
                p.getParameters().put('origid',Originator_id);
            }
            else  p = new PageReference('/apex/Creditor');
            p.setRedirect(true);
            
            if(originator.Current_Creditor__c>0)
            {
                originator.Current_Creditor__c--;
                update originator;
            }
            
            return p;
        }
        
        
    }
    
    public PageReference Back8() //upload attachments
    {
        if(originator.Number_of_App_Creditors__c!=0)
        {
            PageReference p;
            app.Creditors_Received__c = false;
            app.stage__c = 'Creditors';
            update app;
            if( origid != null)
            {
                p = new PageReference('/apex/Creditor');
                p.getParameters().put('origid',Originator_id);
            }
            else  p = new PageReference('/apex/Creditor');
            
            if(originator.Current_Creditor__c>0)
            {
                originator.Current_Creditor__c--;
                update originator;
            }
            
            
            return p;
            
        }
        else if(originator.Number_of_App_Debtors__c!=0)
        {
            PageReference p;
            app.Creditors_Received__c = false;
            app.Debtors_Received__c = false;
            app.stage__c = 'Debtors';
            update app;
            if( origid != null)
            {
                p = new PageReference('/apex/Debtor');
                p.getParameters().put('origid',Originator_id);
            }
            else  p = new PageReference('/apex/Debtor');
            
            if(originator.Current_Debtor__c > 0)
            {
                originator.Current_Debtor__c--;
                update originator;
            }
            
            return p;
        }
        else
        {
            PageReference p;
            app.Creditors_Received__c = false;
            app.Debtors_Received__c = false;
            app.Bank_Accounts__c=false;
            app.Stage__c='Bank';
            update app;
            if( origid != null)
            {
                p = new PageReference('/apex/BankDetails');
                p.getParameters().put('origid',Originator_id);
            }
            else  p = new PageReference('/apex/BankDetails');
            
            return p;
        }
        
    }
    
    
    /*  
public PageReference LandingPage()
{
PageReference p;
if(Apps.size() == 0)
{
if( origid != null)
{
PageReference p1 = new PageReference('/apex/ApplicationStatus');
p1.getParameters().put('origid',Originator_id);
return p1;
}
else return new PageReference('/apex/ApplicationStatus');

}

if(app.Logged_In__c == false)
{
app.Logged_In__c = true;
app.Stage__c='Login';
update app;
}
if(app.refer_a_friend__c == true)
{
if( app.credebtors__c == true)
{
if(app.fast_Trading__c ==true)
{
if(app.Organisation_Details__c == true)
{
if(app.Director_Information__c == true)
{
if(app.directors__c == true)
{
if(app.Bank_Accounts__c == true)
{
if(app.debtors_received__c == true)
{
if(app.creditors_received__c == true)
{
if(app.upload_stage__c == true)
{
if( origid != null)
{
p = new PageReference('/apex/ReviewingApplicationStaticPage');
p.getParameters().put('origid',Originator_id);
}
else  p = new PageReference('/apex/ReviewingApplicationStaticPage');
}
else
{
if( origid != null)
{
p = new PageReference('/apex/UploadAttachments');
p.getParameters().put('origid',Originator_id);
}
else  p = new PageReference('/apex/UploadAttachments');
}
}
else
{
if( origid != null)
{
p = new PageReference('/apex/Creditor');
p.getParameters().put('origid',Originator_id);
}
else  p = new PageReference('/apex/Creditor');
}
}
else
{
if( origid != null)
{
p = new PageReference('/apex/Debtor');
p.getParameters().put('origid',Originator_id);
}
else  p = new PageReference('/apex/Debtor');
}
}
else
{
if( origid != null)
{
p = new PageReference('/apex/BankDetails');
p.getParameters().put('origid',Originator_id);
}
else  p = new PageReference('/apex/BankDetails');
}
}
else
{
if( origid != null)
{
p = new PageReference('/apex/DirectorDocuments');
p.getParameters().put('origid',Originator_id);
}
else  p = new PageReference('/apex/DirectorDocuments');
}
}
else
{
if( origid != null)
{
p = new PageReference('/apex/Directors');
p.getParameters().put('origid',Originator_id);
}
else  p = new PageReference('/apex/Directors');
}
}
else
{
if( origid != null)
{
p = new PageReference('/apex/OrganisationDetails');
p.getParameters().put('origid',Originator_id);
}
else  p = new PageReference('/apex/OrganisationDetails');
}

}
else
{
if( origid != null)
{
p = new PageReference('/apex/FastTrading');
p.getParameters().put('origid',Originator_id);
}
else  p = new PageReference('/apex/FastTrading');

}

}
else
{
if( origid != null)
{
p = new PageReference('/apex/SelectOrganisations');
p.getParameters().put('origid',Originator_id);

}
else  p = new PageReference('/apex/SelectOrganisations');
}

}
else
{

if( origid != null)
{
p = new PageReference('/apex/ReferAFriend');
p.getParameters().put('origid',Originator_id);
}
else  p = new PageReference('/apex/ReferAFriend');
}
return p;
}


*/
}