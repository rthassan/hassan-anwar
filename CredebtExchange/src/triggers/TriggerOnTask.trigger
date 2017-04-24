trigger TriggerOnTask on Task (after update,after insert) {

    system.debug(trigger.new[0]);
    for(Task fi : Trigger.new)
    {
        List<Application__c> apps = [Select id,last_updated_date__c from Application__c where id =: fi.WhatId];
        system.debug(apps);
        if(apps.size() > 0)
        {
            system.debug('1');
            Application__c app = apps[0];
            app.last_updated_date__c = system.today();
            update app;
        }
    }

}