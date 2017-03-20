/**
 * Created by ansja02 on 12/5/16.
 */
({
    doInit:function(component,event,helper) {
        helper.initBind(component,helper);
        var listViewUID = component.get('v.listViewUID');
        var deleteEnabled = (listViewUID != null && typeof(listViewUID) != 'undefined');
        helper.toggleAccept(component, deleteEnabled);
    }
})