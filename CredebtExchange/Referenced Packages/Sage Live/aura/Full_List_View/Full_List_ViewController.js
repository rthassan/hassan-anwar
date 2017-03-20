/**
 * Created by john.hulme on 12/08/2016.
 */
({
    doInit : function (component, event, helper) {
        //console.log('Full list view doInit');
        helper.handleCustomSetting(component);
    },
    handleHeaderOptionSelected : function(component,event,helper) {
        component.set('v.listView', event.getParam("selectedOption"));
       helper.handleCustomSetting(component);
    }
})