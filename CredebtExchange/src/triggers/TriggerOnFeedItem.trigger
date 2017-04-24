trigger TriggerOnFeedItem on FeedItem (after update,after insert) {

    system.debug(trigger.new[0]);
    for(FeedItem fi : Trigger.new)
    {
        List<Application__c> apps = [Select id,last_updated_date__c from Application__c where id =: fi.parentId];
        
        if(apps.size() > 0)
        {
            system.debug(trigger.new[0]);
            Application__c app = apps[0];
            app.last_updated_date__c = system.today();
            update app;
        }
    }
}