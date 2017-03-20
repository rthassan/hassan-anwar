({
	formLoad : function(component, event, helper) {

        var action = component.get("c.GetBankAccounts");

        var self = this;
        action.setCallback(this, function(actionResult) {
            var result = actionResult.getReturnValue();

            component.set('v.bank_accounts', result);
        });

        $A.enqueueAction(action);
	},
	formSubmit : function(component, event, helper) {
        var comp = component.find('bank_account');
        var bank_account_id = null;

        var has_error = false

        if(comp != null) {

            comp.checkValue();
            has_error |= comp.get('v.has_error');
            bank_account_id = comp.get('v.value');

            if(bank_account_id != null && has_error == false) {

                var action = component.get("c.CreateFeed");

                action.setParams({
                    'bank_account_id': bank_account_id
                });

                var self = this;
                action.setCallback(this, function(actionResult) {
                    // message
                    helper.formClose(component, event, helper);
                });

                $A.enqueueAction(action);

            }
        }
    },
    formClose : function(component, event, helper) {
        // redirect...
    }
})