@isTest
// Test for Trigger of the same name on Leads.
class AutoLeadConversionTest {
    /*static TestMethod void testConversion() {
        Lead l = new Lead(
            Firstname = 'John',
            Lastname = 'Doe',
            Email = Math.round(Math.random()*1000) + 'john@doe.com',
            Company = 'Dead as a doe doe',
            LeadSource = 'Web Application',
            Type__c = 'Originator'
        );
        
        insert l;
        
        l = [SELECT Id, Firstname, Lastname, Email, Company, ConvertedAccountId, ConvertedContactId, ConvertedOpportunityId, IsConverted FROM Lead][0];
        System.AssertEquals(true, l.IsConverted);
        System.AssertNotEquals(null, l.ConvertedAccountId);
        System.AssertNotEquals(null, l.ConvertedContactId);
        System.AssertNotEquals(null, l.ConvertedOpportunityId);
    }*/
}