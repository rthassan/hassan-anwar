trigger ApplicationTrigger on Application__c (after insert, after update,before update) {
    
    
    //submit for verification approval
    Application__c app = Trigger.new[0];
    /*if(app.Credebtors__c == true && Trigger.old[0].Credebtors__c == false){
List<Account> account = [Select Name, Submit_Verification_Approval__c 
From Account where Id = :app.Originator__c];

if(account.size() > 0)
{
account[0].Submit_Verification_Approval__c = true;
update account;
}
}*/
    if(Trigger.isBefore && Trigger.isUpdate)
    {
        app.Last_Updated_Date__c = System.today();
    }
    if(Trigger.isInsert && Trigger.isAfter)
    {
        Account[] acc = [Select Current_Debtor__c, Current_Creditor__c
                         From Account where Id = :app.Originator__c];
        for (Account a : acc) {
            a.Current_Debtor__c = 0;
            a.Current_Creditor__c=0;
            update a;
        }
    }
    
    if(Trigger.isUpdate && Trigger.isAfter)
    {
        
        //submit for treasury approval
        if(app.Upload_Stage__c == true && Trigger.old[0].Upload_Stage__c == false){
            
            Application_Debtor__c[] debtors = [Select Name, Submit_Treasury_Approval__c 
                                               From Application_Debtor__c where Originator__c = :app.Originator__c and Mandatory__c=true];
            for (Application_Debtor__c d : debtors) {
                d.Submit_Treasury_Approval__c = true;   
                update d;
            }
            
            Application_Creditor__c[] creditors = [Select Name, Submit_Treasury_Approval__c 
                                                   From Application_Creditor__c where Originator__c = :app.Originator__c and Mandatory__c=true ];
            for (Application_Creditor__c c : creditors) {
                c.Submit_Treasury_Approval__c = true;   
                update c;
            }
            Application__c TApp = [select id,name,createdby.id from application__c where id =: app.id];
            //called by application trigger
            Approval.ProcessSubmitRequest req1 = new Approval.ProcessSubmitRequest();
            req1.setComments('Submitting request for approval..');
            req1.setObjectId(app.Id);
            
            system.debug(Tapp.CreatedBy.Id);
            req1.setSubmitterId(Tapp.CreatedBy.Id);
            List<User> u=[SELECT Id from User where Originator_Id__c=:app.Originator__c];
            /*if(u.size()>0)
{
req1.setSubmitterId(u[0].id);
}
else
{
req1.setSubmitterId('0059E000000Jbdz');//UserInfo.getUserId());
}*/
            
            //Group[] g = [select Id, Name from Group where Type = 'Queue' and Name = 'Treasury Managers Queue'];
            
            req1.setProcessDefinitionNameOrId('Application_Treasury_Approval');
            req1.setSkipEntryCriteria(true);
            //req1.setNextApproverIds(new Id[] {g[0].id});
            Approval.ProcessResult result = Approval.process(req1);
        }
        
        if(app.Application_Approval_Status__c == true && Trigger.old[0].Application_Approval_Status__c == false)
        {
            // ApplicationCredebtorRestApi.sendOriginator(app.Originator__c);
            //list<ProcessInstance> procins =  [SELECT Id,Status,TargetObjectId FROM ProcessInstance where Status='NoResponse' and processDefinition.Name = 'SubmitToTradeDesk' and TargetObjectId =:OppID];
            
        }
        
    }
    
    
}