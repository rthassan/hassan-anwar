/**
 * Created by ansja02 on 12/6/16.
 */
({
    onAccept : function(component, event) {
        this.toggleAccept(component, false);

        var listViewTitle = component.get('v.listViewTitle');
        var objectType = component.get('v.SObjectType');
        var uid = component.get('v.UID');
        var listViewUID =  component.get('v.listViewUID');
        var privateList = component.get('v.privateList');
        var helper = this;
        var params = {
                       "sObjectType" : objectType,
                       "sObjectUID" : uid,
                       "listViewUID":listViewUID,
                       "privateList":privateList
                     }
        this.callServer(component,'c.shareSettingsListView',function(response){
            var compEvent = component.getEvent("Event_List_View_Share_Changed");
            compEvent.setParam("privateList",privateList);
            compEvent.fire();

            helper.showToast(
                component,
                $A.get("$Label.s2cor.List_View_Updated"),
                "success",
                false
            );
         }, params, false, function(result) {
            helper.showToast(component,
                                 $A.get("$Label.s2cor.Error_Saving") + ': ' + result,
                                 "error",
                                 false
                             );
        });
    },
})