trigger directorRollup on Contact (after insert, after Update) {    
    
   /* List<Id> updateAccountIds = new List<Id>();
    
    for(Contact c : trigger.new){
        if(c.director__c ){
    		updateAccountIds.add(c.AccountId);
        }
    }
	
    Map<Id, Account> updateAccountMap = new Map<Id, Account>();
    for(Account a : [SELECT Id, Name, Number_of_Directors__c, Directors_Details_Count__c, director_added__c  FROM Account WHERE Id IN :updateAccountIds]){
        updateAccountMap.put(a.Id, a);
    }    
    
    List<aggregateResult> directorContacts = [SELECT COUNT(Id), AccountId FROM Contact WHERE AccountId IN :updateAccountIds AND Director__c = TRUE  GROUP BY AccountId ];
    
    for(aggregateResult ar : directorContacts){
        if(updateAccountMap.get((Id)ar.get('AccountId')).Directors_Details_Count__c == 0 && updateAccountMap.get((Id)ar.get('AccountId')).Director_Added__c == null && (decimal)ar.get('expr0') > 0){
            updateAccountMap.get((Id)ar.get('AccountId')).Director_Added__c = system.today();
        }
    	updateAccountMap.get((Id)ar.get('AccountId')).Directors_Details_Count__c = (decimal)ar.get('expr0');
    }
    
    update updateAccountMap.values();*/
}