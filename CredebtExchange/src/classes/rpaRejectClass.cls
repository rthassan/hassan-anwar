public class rpaRejectClass {
    
    public string rpaRejectClass(List<id> oppIds){
        string result;
        List<Task> tasks = new List<Task>();
        for(Opportunity opp : [SELECT Id, Name, OwnerId, Account.Name FROM Opportunity WHERE Id In : oppIds ] ){
            tasks.add(
                new Task(
                    Subject = 'RPA Rejection - ' + opp.Account.Name,                
                    OwnerId = opp.OwnerID,
                    WhatId = opp.Id,
                    ActivityDate = system.today(),
                    Type = 'RPA Request Task',
                    Description = opp.Name + ' opportunity which was submitted for RPA has been rejected, please review. ' +URL.getSalesforceBaseUrl().toExternalForm() +'/' +opp.id                
                )            
            );
        }
        try{
            insert tasks;
            result = 'success';
        }
        catch(Exception ex){
            system.debug(ex);
            result = 'fail' + ex;
        }
        
        return result;
    }
}