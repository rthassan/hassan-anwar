@isTest
public class Test_OriginatorTrigger {
  @isTest static void TestOriginatorTrigger() {
        //insert account
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
        );
        insert u;
        system.debug('start');
        system.debug(a.Id);
        system.debug(c.Id);
        system.debug(c.AccountId);
        system.debug(u.Originator_Id__c);
        system.debug('end');
        
        //update account with General Info and Jotform OppId fields
        a.Submit_Verification_Approval__c = true;
        a.Bank_Details_Changed__c = true;
        update a;
        
        //approve approval process
        Id retVal = null;
        for(ProcessInstanceWorkitem workItem  : [Select p.Id from ProcessInstanceWorkitem p
            where p.ProcessInstance.TargetObjectId =: a.Id]) {
            retVal  =  workItem.Id;
        }
        system.debug(retVal);
        Approval.ProcessWorkitemRequest req2 = new Approval.ProcessWorkitemRequest();
        req2.setComments('Approving request.');
        req2.setAction('Approve');
        req2.setNextApproverIds(new Id[] {UserInfo.getUserId()});
        req2.setWorkitemId(retVal);
        Approval.ProcessResult result2 =  Approval.process(req2);
        
        //update account with No Form
        a.Bank_Details_Changed__c = true;
        update a;
                
        //update account with Photo Strip and Jotform OppId fields
        a.Verification_Rejected__c = true;
        update a;
    }
}