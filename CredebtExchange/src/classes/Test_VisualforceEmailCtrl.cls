@isTest
public class Test_VisualforceEmailCtrl {
    @isTest static void TestVisualforceEmailCtrl() {
        RecordType r1 = [Select Id,SobjectType,Name From RecordType where Name ='Debtor' and SobjectType ='Account' limit 1];

        RecordType r2 = [Select Id,SobjectType,Name From RecordType where Name ='Originator' and SobjectType ='Account' limit 1];

        Account a = new Account(Name='testing', RecordTypeId = r2.Id);
        insert a;
        
        Account a1 = new Account(Name='testing', RecordTypeId = r1.Id, Originator__c=a.Id);
        insert a1;
        
        Contact cont = new Contact(LastName = 'testname', AccountId = a1.Id);
        insert cont;
        
        //insert App Debtor
        Application__c app = new Application__c(Originator__c = a.Id);
        insert app;
        
        Application_Debtor__c d = new Application_Debtor__c(Name = 'testappdebtor', Originator__c=a.Id, 
                                                            Last_Name__c = 'testln',
                                                           Email__c = 'test@mailinator.com', Mandatory__c = true);
        insert d;
        
        Application_Creditor__c c = new Application_Creditor__c(Name = 'testappcreditor', Originator__c=a.Id, 
                                                                Last_Name__c = 'testln',
                                                           Email__c = 'test@mailinator.com', Mandatory__c = true);
        insert c;
        
        Bank_Account__c ba = new Bank_Account__c(Bank__c = 'ACC', Swift_Code__c = '784', IBAN_Number__c='858', 
                                                 Account__c = a.Id);
        insert ba;
        
        VisualforceEmailController ctrl = new VisualforceEmailController();
        ctrl.CId = cont.Id;
        ctrl.getDebtor();
        ctrl.getDebtorOrganisation();
        ctrl.getOriginator();
        ctrl.getBankAccount();
        ctrl.getSignatureId();
        ctrl.getLogoId();
        ctrl.getDirectorSignatureId();
        
    }
}