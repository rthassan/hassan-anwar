trigger supportingFilesRollup on Attachment (before insert, before update) {

    
    List<Id> updateOppIds = new List<Id>();
    
    for(Attachment a : trigger.new){
        if(a.Parent.Type == 'Opportunity' ){
    		updateOppIds.add(a.ParentId);
        }
    }
	
    Map<Id, Opportunity> updateOppMap = new Map<Id, Opportunity>();
    Map<Id, Set<String>> oppAttMap = new Map<Id, Set<String>>();
    for(Opportunity o : [SELECT Id  FROM Opportunity WHERE Id IN :updateOppIds]){
        updateOppMap.put(o.Id, o);
        oppAttMap.put(o.Id, new Set<String>());
    }
    
    
    List<Attachment> attachments = [SELECT Id, Name FROM Attachment WHERE ParentId IN :updateOppIds];
    for(Attachment a : attachments){
   		oppAttMap.get(a.ParentId).add(a.Name);
    }
    
    for(Id i : oppAttMap.keySet()){
        if(oppAttMap.get(i).contains('Aged Debtors') && oppAttMap.get(i).contains('Aged Creditors') 
           && oppAttMap.get(i).contains('Directors ID') && oppAttMap.get(i).contains('Utility Bill') 
           && oppAttMap.get(i).contains('Bank Statement') && oppAttMap.get(i).contains('Experience Files') ){
               //updateOppMap.get(i).supporting_files_Complete__c = true;
           }
    }
    
    update updateOppMap.values();
    
    
    	
}