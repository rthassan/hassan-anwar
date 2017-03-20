({
	formLoad: function(component, event, helper) { 
        var id = component.get('v.id');

        var action = component.get("c.GetBankAccountIndex");

        action.setParams({
            'entity_id': id
        });

        //Set up the callback
        var self = this;
        action.setCallback(this, function(actionResult) {

            var result = actionResult.getReturnValue();

            component.set('v.current_index', result);

            helper.loadJS('/resource/Custom_Script', function() { });
        });

        $A.enqueueAction(action);

  	},
    formClear: function(component, event, helper) {

        component.set('v.id', null);

        helper.refresh(component, event, helper);
        helper.closeModal(component, event, helper);
  	},
    formSubmit: function(component, event, helper) {

        var id = component.get('v.id');

        var action = component.get("c.ResetBankAccount");

        action.setParams({
            'entity_id': id
        });

        var self = this;
        action.setCallback(this, function(actionResult) {

            helper.formClear(component, event, helper);

        });

        $A.enqueueAction(action);

  	},
    closeModal : function(component, event, helper)
    {
        var testEvent = component.getEvent("bubblingEventModal");
        testEvent.setParams
        ({
            'type': 'reset_modal'
        });
        testEvent.fire();
    },
    refresh : function(component, event, helper)
    {
        var refreshEvent = component.getEvent("refreshEvent");
        refreshEvent.fire();
    }
})