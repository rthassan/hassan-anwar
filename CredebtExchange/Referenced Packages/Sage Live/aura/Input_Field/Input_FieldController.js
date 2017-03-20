/**
 * Created by dancolq on 17/08/2016.
 */
({
     doInit : function(component,event,helper)
    {
        var field = component.get('v.field');
        component.set('v.doneRendering',false);
        component.set('v.value',field.value);
        component.set('v.type',field.type);
        component.set('v.label',field.label);
        component.set('v.editable',field.editable);
        component.set('v.doneRendering',true);
    },

    raiseToggleEditEvent:function(component, event,helper)
    {
        //console.log('Toggle event fired');
        // raise a toggleEditEvent
        var compEvent = component.getEvent('Event_Edit_Toggle');
        compEvent.fire();

    },

    doneRendering:function(component,event,helper)
    {
        var doneRendering = component.get('v.doneRendering');
        doneRendering = true;
        component.set('v.doneRendering',doneRendering);
    },

    dirtyfield:function(component,event,helper)
    {
        var doneRendering = component.get('v.doneRendering');
        if(doneRendering==true)
        {

            var field = component.get('v.field');
            field.dirty = true;
            field.value = component.get('v.value');
            //console.log(field.value);
            component.set('v.field',field);
        }
    }
})