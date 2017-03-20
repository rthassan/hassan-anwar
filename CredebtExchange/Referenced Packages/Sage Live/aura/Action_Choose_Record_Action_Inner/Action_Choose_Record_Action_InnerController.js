/**
 * Created by ansja02 on 10/28/16.
 */
({
    select: function(component, event, helper)
    {
        //Close this modal before navigating to action
        var evt = $A.get("e.s2cor:Event_Close_Model_On_Cancel");
        evt.fire();

        var action = component.get("v.action");
        if (action.modal == false) {
           helper.executeAction(component, action, component.get('v.recordId'), null, component.get('v.parentId'));
        } else {
           var evt = $A.get("e.s2cor:Event_Record_Action_Chosen");
           var params = {
               "action":action,
               "recordId":component.get('v.recordId'),
               "parentId":component.get('v.parentId')
                }

           evt.setParams(params);
           evt.fire();
        }
    }
})