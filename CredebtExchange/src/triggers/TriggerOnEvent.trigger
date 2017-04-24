trigger TriggerOnEvent on Event (after update,after insert) {
    
    system.debug(Trigger.new[0]);
    for(Event fi : Trigger.new)
    {
        List<Application__c> apps = [Select id,last_updated_date__c from Application__c where id =: fi.WhatId];
        
        if(apps.size() > 0)
        {
            Application__c app = apps[0];
            app.last_updated_date__c = system.today();
            update app;
        }
    }

}