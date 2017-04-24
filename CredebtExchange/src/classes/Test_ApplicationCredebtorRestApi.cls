@isTest
public class Test_ApplicationCredebtorRestApi {
    @isTest static void TestAppCredebtorRestApi() {
        
        RecordType rtoriginator = [Select Id,SobjectType,Name From RecordType where Name ='Originator' and 
                         SobjectType ='Account' limit 1];
        
        RecordType rtdebtor = [Select Id,SobjectType,Name From RecordType where Name ='Debtor' and 
                         SobjectType ='Account' limit 1];
        
        RecordType rtcreditor = [Select Id,SobjectType,Name From RecordType where Name ='Creditor' and 
                         SobjectType ='Account' limit 1];

        Account originator = new Account(Name='originator', RecordTypeId = rtoriginator.Id);
        insert originator;
        
        Account debtor = new Account(Name='debtor', RecordTypeId = rtdebtor.Id, Originator__c=originator.Id);
        insert debtor;
        
        Account creditor = new Account(Name='creditor', RecordTypeId = rtcreditor.Id, Originator__c=originator.Id);
        insert creditor;
        

        RecordType rtdebtorcont = [Select Id,SobjectType,Name From RecordType where Name ='Debtor' and 
                                   SobjectType ='Contact' limit 1];
        
        RecordType rtcreditorcont = [Select Id,SobjectType,Name From RecordType where Name ='Creditor' and 
                                     SobjectType ='Contact' limit 1];
        
        //insert App Debtor
        Application__c app = new Application__c(Originator__c = originator.Id);
        insert app;
        
        Contact originatorcont = new Contact(LastName='testing4', AccountId=originator.Id, Director__c = true);
        insert originatorcont;
        
        Contact originatorcont1 = new Contact(LastName='testing3', AccountId=originator.Id, Director__c = false);
        insert originatorcont1;
        
        Contact debtorcont = new Contact(LastName='testing2', AccountId=debtor.Id, RecordTypeId=rtdebtorcont.Id, 
                                         Email='someaddress@email.com', Director__c = true);
        insert debtorcont;
        
        Contact creditorcont = new Contact(LastName='testing1', AccountId=creditor.Id, RecordTypeId=rtcreditorcont.Id, 
                                           Email='someaddress1@email.com', Director__c = true);
        insert creditorcont;
        
        Bank_Account__c debtorbank = new Bank_Account__c(Name = 'test',Account__c = debtor.Id, Bank__c = 'ACC',
                                                 IBAN_Number__c = '389',Sort_Code__c = '43',Swift_Code__c = '342');
        
        insert debtorbank;
        
        Bank_Account__c originatorbank = new Bank_Account__c(Name = 'test',Account__c = originator.Id, Bank__c = 'ACC',
                                                 IBAN_Number__c = '389',Sort_Code__c = '43',Swift_Code__c = '342');
        
        insert originatorbank;
        
        Test.setMock(HttpCalloutMock.class, new Test_MockCallout()); 
        ApplicationCredebtorRestApi.sendDebtors(debtor.Id); 
        ApplicationCredebtorRestApi.sendOriginator(originator.Id);
    }
}