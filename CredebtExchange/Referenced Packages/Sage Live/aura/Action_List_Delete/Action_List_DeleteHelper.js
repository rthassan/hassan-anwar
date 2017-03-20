/**
 * Created by ansja02 on 12/5/16.
 */
({
    onAccept : function(component, event) {
        this.deleteRecord(component, event);
    },
    deleteRecord: function(component, event) {
        var cmpTarget = component.find('confirmation');
        $A.util.addClass(cmpTarget, 'slds-hide');

        this.toggleAccept(component, false);

        var objectType = component.get('v.SObjectType');
        var uid = component.get('v.UID');
        var listViewUID =  component.get('v.listViewUID');
        var helper = this;
        var params = {
                       "sObjectType" : objectType,
                       "sObjectUID" : uid,
                       "listViewUID":listViewUID
                     }

        this.callServer(component,'c.deleteListView', function(response) {
            //Select the first item in the list
            var listViewName = component.get('v.listViewTitle');
            var listViewTitles = component.get('v.listViewsTitles');
            var selectedList = listViewTitles[0];
            if (selectedList == listViewName) {
                if (listViews.labels.length > 1) {
                    selectedList = listViews.labels[1];
                } else {
                    selectedList = $A.get("$Label.s2cor.VF_Generic_All");
                }
            }
            var compEvent = component.getEvent("Event_Header_Option_Selected");
            compEvent.setParam("selectedOption",selectedList);
            compEvent.fire();

            helper.showToast(
                component,
                $A.get("$Label.s2cor.Delete_List_View_Complete"),
                "success",
                false
            );
        }, params, null, function(result) {
            helper.showToast(
                component,
                $A.get("$Label.s2cor.Error_Deleting") + ': ' + result,
                "error",
                false
            );
        })
    }
})