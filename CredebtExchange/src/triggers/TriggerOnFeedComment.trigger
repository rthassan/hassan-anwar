trigger TriggerOnFeedComment on FeedComment (after update,after insert) {

    system.debug(trigger.new[0]);
    for(FeedComment fi : Trigger.new)
    {
        List<Application__c> apps = [Select id,last_updated_date__c from Application__c where id =: fi.parentId];
        
        if(apps.size() > 0)
        {
            Application__c app = apps[0];
            app.last_updated_date__c = system.today();
            update app;
        }
        else
        {
            List<Task> Tasks = [Select id,subject,whatid from Task where id =: fi.ParentId];
            if(Tasks.size() > 0)
            {
                apps = [Select id,last_updated_date__c from Application__c where id =: Tasks[0].whatid];
                if(apps.size() > 0)
                {
                    apps[0].last_updated_date__c = system.today();
                	update apps;
                }
            }
            else
            {
                List<Event> Events = [Select id,whatid,subject from Event where id =: fi.ParentId];
                apps = [Select id,last_updated_date__c from Application__c where id =: Events[0].whatid];
                if(apps.size() > 0)
                {
                    apps[0].last_updated_date__c = system.today();
                	update apps;
                }
            }
        }
    }
}