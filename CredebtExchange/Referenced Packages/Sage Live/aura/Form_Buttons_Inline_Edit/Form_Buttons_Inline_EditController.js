/**
 * Created by daniel.colquhoun on 02/12/2016.
 */
({
    doInit:function(component)
    {
        component.set('v.rendered',false);
    },
//    cancelInlineEditCont:function(component,event)
//    {
//        var action = component.get('c.cancelInlineEdit');
//        $A.enqueueAction(action);
//    },

    saveInlineEditCont:function(component,event)
    {
//        var action = component.get('v.saveInlineEdit');
//        $A.enqueueAction(action);
    },
    dataChange:function(component,event)
    {
        //dataChange
        var scope = component.get('v.scope');
        if(scope.mode=='inline-edit');
        component.set('v.rendered',true);
    }
})