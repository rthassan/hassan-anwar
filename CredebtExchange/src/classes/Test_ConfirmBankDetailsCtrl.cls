@isTest
public class Test_ConfirmBankDetailsCtrl {
  @isTest static void TestConfirmBank() {
        //insert account
        
        RecordType rtoriginator = [Select Id,SobjectType,Name From RecordType where Name ='Originator' and 
                         SobjectType ='Account' limit 1];
        
        RecordType rtdebtor = [Select Id,SobjectType,Name From RecordType where Name ='Debtor' and 
                         SobjectType ='Account' limit 1];
        
        
        Account a = new Account(Name='test_acct', RecordTypeId = rtoriginator.Id);
        insert a;
        
        Account d = new Account(Name='test_acct',RecordTypeId = rtdebtor.Id, Originator__c=a.Id);
        insert d;
      
        Contact c = new Contact(LastName = 'testname', AccountId = d.Id);
        insert c;
        
        Application__c app = new Application__c(Originator__c=a.Id);
        insert app;
        
        
        Bank_Account__c b = new Bank_Account__c(Bank__c = 'ACC', Swift_Code__c='ABCDEF12', IBAN_Number__c='IE02BOFI90008413113207',
                                               Account__c=a.Id);
        insert b;
        
        ApexPages.StandardController sc = new ApexPages.StandardController(c);
        ConfirmBankDetailsController cbdc = new ConfirmBankDetailsController(sc);
        cbdc.GetBankDetails();
        cbdc.Confirm();
        
        delete b;
        ConfirmBankDetailsController cbdc1 = new ConfirmBankDetailsController(sc);
        cbdc1.GetBankDetails();
    }
}