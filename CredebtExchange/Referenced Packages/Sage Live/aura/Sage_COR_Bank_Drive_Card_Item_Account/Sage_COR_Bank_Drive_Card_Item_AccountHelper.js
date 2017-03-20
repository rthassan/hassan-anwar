({
	toggleButtons : function(component, event, helper) {
        var more = component.find('more-buttons');
        
        if($A.util.hasClass(more, 'slds-hidden')) {
            $A.util.removeClass(more, 'slds-hidden');
        }
        else {
            $A.util.addClass(more, 'slds-hidden');
        }
    },
    deleteModal : function(component, event, helper) {
		
        var testEvent = component.getEvent("bubblingEventModal");
		
        testEvent.setParams 
        ({
            'type': 'bank_account_delete_modal',
            'id': component.get('v.bank_account').bankAccountId
        });
        
        testEvent.fire();
        
        helper.toggleButtons(component, event, helper);
        
	},
    editModal : function(component, event, helper) {
		
        var testEvent = component.getEvent("bubblingEventModal");
		
        testEvent.setParams 
        ({
            'type': 'bank_account_modal',
            'id': component.get('v.bank_account').bankAccountId
        });
        
        testEvent.fire();
        
        helper.toggleButtons(component, event, helper);
        
	},
	resetModal : function(component, event, helper) {

        var testEvent = component.getEvent("bubblingEventModal");

        testEvent.setParams
        ({
            'type': 'reset_modal',
            'id': component.get('v.bank_account').bankAccountId
        });

        testEvent.fire();

        helper.toggleButtons(component, event, helper);

    }
})