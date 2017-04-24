@isTest
public class Test_SelectOrganizationWrapper {
    @isTest static void TestSelectOrgWrapper() {
        //insert account
        Account a = new Account(Name='test_acctd');
        insert a;
        
        Application_Debtor__c ad = new Application_Debtor__c(Name = 'testappDebtor', Originator__c=a.Id, Last_Name__c = 'testln',
                                                           Email__c = 'test@mailinator.com',Company_Number__c='99');
        insert ad;
        
        Application_Creditor__c ac = new Application_Creditor__c(Name = 'testappCreditor', Originator__c=a.Id, Last_Name__c = 'testln',
                                                           Email__c = 'test@mailinator.com',Company_Number__c='99');
        insert ac;
        
        SelectOrganisationWrapper sow = new SelectOrganisationWrapper(ac);
        sow.Type = 'testtype';
        SelectOrganisationWrapper sow1 = new SelectOrganisationWrapper(ad);
    }
}