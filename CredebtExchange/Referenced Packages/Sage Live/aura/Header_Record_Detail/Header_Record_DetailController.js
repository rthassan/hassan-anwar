/**
 * Created by john.hulme on 11/08/2016.
 */
({
    doInit : function(component, event, helper){
        var params = {
            recordId: component.get("v.recordId")
        };
        helper.callServer(component,'c.getRecordHeaderDetails', function(response) {
            component.set("v.title",response.title);
            component.set("v.area",response.area);
            component.set("v.breadcrumbs",response.breadcrumbs);
            component.set("v.buttons",response.buttons);

            //component.set("v.iconName",response.iconName); //TODO: Ask Dan about how to use the icons

        }, params)
    }
})