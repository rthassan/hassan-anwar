@isTest
public class Test_DeactivateUserOnRejection {
    @isTest static void DeactivateUser() {
        Account a = new Account(Name='test_acct');
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
        
        Account a1 = [Select Name, Id from Account where Id=:a.Id];
        string acctid = String.valueOf(a1.Id);
        DeactivateUserOnRejection.DeactivateUser(acctid);
    }
}