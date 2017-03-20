/**
 * Created by ansja02 on 10/20/16.
 */
({
    doInit : function(component,event,helper)
    {
        var title = component.get("v.title");
        var label = title;
        var all = $A.get("$Label.s2cor.VF_Generic_All");
        if (title == all) {
            var listView = null;
            try
            {
                var listDescriptions = component.get("v.listDescriptions");
                listView = listDescriptions[title];
            }
            catch(err)
            {
                 //Do nothing
            }

            if (listView != null) {
                label = all + " - " + listView.objectPluralName;
            }
        }
        component.set("v.label", label);
    },
    selectTitle:function(component,event,helper)
    {
        var title = component.get("v.title");

        var compEvent = component.getEvent("Event_Header_View_Mode_Changed");
        compEvent.setParam("viewResultsMode",true);
        compEvent.fire();

        var compEvent = component.getEvent("Event_Header_Option_Selected");
        compEvent.setParam("selectedOption",title);
        compEvent.fire();
    }
})