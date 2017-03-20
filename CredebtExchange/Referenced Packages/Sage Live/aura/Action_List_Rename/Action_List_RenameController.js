/**
 * Created by ansja02 on 12/5/16.
 */
({
    doInit:function(component,event,helper) {
        helper.initBind(component,helper);
        var listViewTitle = component.get('v.listViewTitle');
        component.set('v.name', listViewTitle);
        var listViewUID = component.get('v.listViewUID');
        var renameEnabled = (listViewUID != null && typeof(listViewUID) != 'undefined');
        helper.toggleAccept(component, renameEnabled);
    },
    handleChangeName: function(component, event, helper) {
        helper.clearError(component);
    }
})