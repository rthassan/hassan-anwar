trigger oppRPAtrigger on Opportunity (before update) {
    
    system.debug(userInfo.getUserId());
    User u = [SELECT Id, ProfileId, Name, Profile.Name FROM User WHERE Id = :userInfo.getUserId()];
    
    Map<Id, opportunity> oldMap = new Map<Id, opportunity>();
    for(opportunity o : trigger.old){
        oldMap.put(o.Id, o);
    }
    
    List<Opportunity> requestOpps = new List<Opportunity>();
    List<id> rpaRejectOppIds = new List<Id>();
    List<id> rpaIssueOppIds = new List<Id>();

    
    List<Id> accountIds = new List<Id>();
    List<Id> oppIds = new List<Id>();
    for(Opportunity o : trigger.new){
        system.debug('opp stage' + o.stageName + '  opp old stage' + oldMap.get(o.Id).stageName);
        if(o.stageName == 'RPA Request' && oldMap.get(o.Id).stageName != 'RPA Request'){
            requestOpps.add(o);
            accountIds.add(o.AccountId);
            oppIds.add(o.Id);
            
        }
        else if(o.stageName == 'Pre-Approval' && oldMap.get(o.Id).stageName == 'RPA Request'){
            rpaRejectOppIds.add(o.Id);
        }
        else if(o.stageName == 'RPA Issued' ){
            
            if((oldMap.get(o.Id).stageName == 'RPA Request') || (oldMap.get(o.Id).stageName == 'RPA Approved') || (oldMap.get(o.Id).stageName == 'Pre-Approval') || (oldMap.get(o.Id).stageName == 'Pre-RPA')   ){
                if(u.Profile.Name == 'System Administrator' || u.Profile.Name == 'CE Approver'){
                    rpaIssueOppIds.add(o.Id);
                }else{
                    o.addError('You do not have the user privileges to Issue RPA');
                }
            }
            else{
                // Do nothing, let stage be moved back
            }
        }
    }   

    
    // Request Rpa
    Map<Id, string> triggerErrors = new Map<id, string>();
    if(!requestOpps.isEmpty()){
        rpaRequestClass rReq = new rpaRequestClass();
        triggerErrors = rReq.rpaRequestClass(requestOpps);
        system.debug(triggerErrors);
    }
    
    //Rejected Opps
    if(!rpaRejectOppIds.isEmpty()){
        rpaRejectClass rRej = new rpaRejectClass();
        string rejectRes = rRej.rpaRejectClass(rpaRejectOppIds);
    }
    
    //Issue RPAs
    
    /* not being used yet
    integer issueCount = [SELECT Id FROM Opportunity WHERE RPA_Issued_Date__c = :system.today()].size() + 1;    
    Map<id, string> issueSuccess = new Map<Id, String>();
    if(!rpaIssueOppIds.isEmpty()){
        for(Id i : rpaIssueOppIds){
            // set count field
            Date d = system.today();
            String dateString = DateTime.newInstance(d.year(),d.month(),d.day()).format('YYYYMMDD');
            string count = string.valueOf(issueCount);
            if(issueCount < 10){
                count = '00' + count;
            }else if(issueCount < 100){
                count = '0' + count;
            }
            trigger.newMap.get(i).Opportunity_Code__c = dateString + count;
            
            
            rpaIssueClass rIss = new rpaIssueClass();
            string issueRes = rIss.rpaIssueClass(i);
            issueSuccess.put(i, issueRes);
            
            if(issueRes == 'success'){
                issueCount += 1;
                trigger.newMap.get(i).Name = dateString + count + ' - ' + trigger.newMap.get(i).Name;
            }else{
                trigger.newMap.get(i).Opportunity_Code__c = '';
            }
            
        }
    }*/
    
    
    for(opportunity o : trigger.new){
        system.debug(o.Id);
        system.debug(triggerErrors);
        if(triggerErrors.get(o.Id) != '' && triggerErrors.get(o.Id) != null){
            o.addError(triggerErrors.get(o.id), false);
        }
    }
    
}