trigger NOIApproval on Account (before update) {
    Account old;
    List<Task> tasks = new List<Task>();
    Task t;
    
    //Group g = [SELECT Id, Name FROM Group WHERE Name = 'Onboarding Team'][0];
    //System.debug(g);
    for ( Account acc : trigger.new ) {
        old = trigger.oldMap.get(acc.Id);
        if ( acc.NOI_Email__c != old.NOI_Email__c ) {
            acc.NOI_Status__c = 'NOI Details Updated';
        }
    }
}