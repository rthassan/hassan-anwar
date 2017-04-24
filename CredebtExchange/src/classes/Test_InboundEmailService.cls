@isTest
private class Test_InboundEmailService {
    static testMethod void TestInboundEmailService() {
        
        RecordType r1 = [Select Id,SobjectType,Name From RecordType where Name ='Debtor' and SobjectType ='Account' limit 1];

        RecordType r2 = [Select Id,SobjectType,Name From RecordType where Name ='Originator' and SobjectType ='Account' limit 1];

        Account a2 = new Account(Name='testing', RecordTypeId = r2.Id);
        insert a2;
        
        Account a1 = new Account(Name='testing', RecordTypeId = r1.Id, Originator__c=a2.Id);
        insert a1;
        

        
        RecordType r = [Select Id,SobjectType,Name From RecordType where Name ='Debtor' and SobjectType ='Contact' limit 1];
        
        //insert App Debtor
        Application__c app = new Application__c(Originator__c = a2.Id);
        insert app;
        
        Contact c = new Contact(LastName='testing', AccountId=a1.Id, RecordTypeId=r.Id, Email='someaddress@email.com');
        insert c;
        // create a new email and envelope object
        Messaging.InboundEmail email = new Messaging.InboundEmail() ;
        Messaging.InboundEnvelope env = new Messaging.InboundEnvelope();
       
        // setup the data for the email
        email.subject = 'Create Contact';
        email.fromAddress = 'someaddress@email.com';
        email.plainTextBody = 'confirm body\n2225256325\nTitle';
        email.fromName = 'testing';
        
        // call the email service class and test it with the data in the testMethod
        InboundEmailService testInbound = new InboundEmailService ();
        testInbound.handleInboundEmail(email, env);
    }
}