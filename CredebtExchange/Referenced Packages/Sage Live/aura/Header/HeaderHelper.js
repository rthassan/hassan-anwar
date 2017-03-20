/**
 * Created by ansja02 on 10/24/16.
 */
({
    calculateListLabel : function(component)
    {
        var title = component.get("v.title");
        var label = title;
        var all = $A.get("$Label.s2cor.VF_Generic_All");
        if (title == all) {
            var listView = null;
            try
            {
                var listDescriptions = component.get("v.listViews.descriptions");
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
        component.set("v.listLabel", label);
     },
})