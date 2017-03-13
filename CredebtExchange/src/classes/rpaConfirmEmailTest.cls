@IsTest
public class rpaConfirmEmailTest {  
    
    @isTest public static void testMethod1(){
        // Set up records
        Id originatorAccRecType = [SELECT Id FROM RecordType WHERE sObjectType = 'Account' AND Name = 'Originator'][0].Id;                    
        Account a = new Account(
            Name = 'originator',
            billingStreet = 'maain',
            billingCity = 'Dublin',
            billingState = 'Dublin',
            billingPostalCode = '00000',
            billingCountry = 'Ireland',
            idf_provider__c = 'None',
            recordTypeId = originatorAccRecType
        );
        insert a;
        
        Contact c = new Contact(
            
            lastName = 'originatorContact',
            accountId = a.Id,
            director__c = true,
            phone = '123456',
            email = 'test@test.com'
        );
        insert c;
        
        Id originatorOppRecType = [SELECT Id FROM RecordType WHERE sObjectType = 'Opportunity' AND Name = '2. Convertibill® Sales Finance'][0].Id;                    
        Opportunity o = new Opportunity(
            recordTypeId = originatorOppRecType,
            Name = 'Test Opp',
            AccountId = a.Id,
            closeDate = System.today().addDays(30),
            stageName = 'Apply',
            RPA_Status__c = 'Approved'
        );
        insert o;
        
        opportunityContactRole ocr = new opportunityContactRole(
            OpportunityId = o.id,
            ContactId = c.id,
            isPrimary = true
        );
        insert ocr;
        
        Debtor__c d = new Debtor__c(
            Originator__c = a.Id,
            Opportunity__c = o.Id
        );
        insert d;
        
        
        // Create a new email and envelope object (Mandatory)
        Messaging.InboundEmail email  = new Messaging.InboundEmail();
        Messaging.InboundEnvelope env = new Messaging.InboundEnvelope();

    
        // Create the email body
        email.plainTextBody = 'confirm';
        email.fromAddress ='test@test.com';
        String contactEmail = 'test@domain.com';
        email.ccAddresses = new String[] {'Test Domain <' + contactEmail + '>'};
        email.subject = 'Dummy Subject';

        rpaConfirmEmailService edr = new rpaConfirmEmailService();

        Test.startTest();
        // pass email & enveloper object as parameters here
        Messaging.InboundEmailResult result = edr.handleInboundEmail(email, env);
        Test.stopTest();

        System.assert (result.success, 'InboundEmailResult returned a failure message');
/*
        Account [] accDb = [select ID from Account where name=:email.subject];
        System.assertEquals (1, accDb.size(),'Account was not inserted');
        Contact [] cDb = [select firstname,lastname from Contact where email=:contactEmail];
        System.assertEquals (1, cDb.size(),'Contact was not inserted!');
        Contact c = CDb[0];
        System.assertEquals ('Test', c.firstName);
        System.assertEquals ('Domain', c.LastName);
        Note [] nDb = [select body from Note where ParentID=:accDb[0].id];
        System.assertEquals (1,nDb.size(), 'A note should have been attached');
        System.assertEquals (email.plainTextBody, nDb[0].body);
*/
    } 

}