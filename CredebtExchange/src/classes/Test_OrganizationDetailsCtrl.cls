@isTest
public class Test_OrganizationDetailsCtrl {
    @isTest static void TestOrgDetails() {
        //insert account
        Account a = new Account(Name='test_acct',isPracticesFilled__c= true);
        insert a;
        
        Contact c = new Contact(LastName = 'testname', AccountId = a.Id);
        insert c;
        
        User u = new User(
             ProfileId = [SELECT Id FROM Profile WHERE Name = 'Credebt Community User'].Id,
             LastName = 'lastname',
             Email = 'lastname400@company7.com',
             Username = 'lastname400@company7.com' + System.currentTimeMillis(),
             CompanyName = 'testcompany',
             Title = 'testtitle',
             Alias = 'testal',
             TimeZoneSidKey = 'America/Los_Angeles',
             EmailEncodingKey = 'UTF-8',
             LanguageLocaleKey = 'en_US',
             LocaleSidKey = 'en_US',
             ContactId = c.Id
             //UserRoleId = [SELECT Id FROM UserRole where Name = 'MyOrg Partner User'].Id
        );
        insert u;
        
        User u1 = [Select LastName, Originator_Id__c from User where Id=:u.Id];
        system.debug('u1');
        system.debug(u1);
        Account a1 = [Select Name, Id from Account where Id=:a.Id];
        system.debug(a1);
        Application__c app = new Application__c(Originator__c = u1.Originator_Id__c, Organisation_Details__c = true);
        insert app;
        
        Test.setCurrentPage(new pageReference('/apex/OrganisationDetails?origid='+a.id));
        ApplicationProcess applprocess = new ApplicationProcess();
        OrganisationDetailsController odc = new OrganisationDetailsController(applprocess);
        odc.GetCAttachment();
        odc.attachment.name = 'b1';
        odc.attachment.body = Blob.valueof('123');
        odc.save();
        Blob bl = Blob.valueOf('test');
        odc.attachment.body = bl;
        odc.GetOriginator();
        odc.getDecision();
        
        
        odc.rebateDiscount = 'Yes';
        odc.customerPercentage = 'Yes';
        odc.invoiceConsignment = 'Yes';
        odc.warranty = 'Yes';
        odc.returnRights = 'Yes';
        odc.rebateDiscount = 'Yes';
        odc.save();
        
        odc.rebateDiscount = 'No';
        odc.customerPercentage = 'No';
        odc.invoiceConsignment = 'No';
        odc.warranty = 'No';
        odc.returnRights = 'No';
        odc.rebateDiscount = 'No';
        odc.save();
        
        odc.rebateDiscount = 'Yes1';
        odc.customerPercentage = 'Yes1';
        odc.invoiceConsignment = 'Yes1';
        odc.warranty = 'Yes1';
        odc.returnRights = 'Yes1';
        odc.rebateDiscount = 'Yes1';
        odc.save();
        odc.isOrganisationDetails();
    }
}