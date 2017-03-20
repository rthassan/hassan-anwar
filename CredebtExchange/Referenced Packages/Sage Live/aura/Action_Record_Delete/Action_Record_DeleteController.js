/**
 * Created by daniel.nicholson on 16/08/2016.
 */
({
    doInit:function(component,event,helper) {
        helper.initBind(component,helper);
        var recordIds = component.get('v.recordIds');
        var recordId = component.get('v.recordId');
        var deleteEnabled = ((recordIds != null && typeof(recordIds) != 'undefined' && recordIds.length > 0) || (recordId != null && typeof(recordId) != 'undefined'));
        helper.toggleAccept(component, deleteEnabled);
    }
})