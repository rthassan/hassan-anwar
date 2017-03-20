({
	formLoad: function(component, event, helper) {
        
        component.set('v.show_content', false);
        var spinner = component.find('spinner');
        spinner.handleToggle();
        
        var id = component.get('v.id');
        
        var action = component.get("c.GetBankAccountEnrollment");
        
        action.setParams({
            'entity_id': id
        });
        
        var self = this;
        action.setCallback(this, function(actionResult) {
            
            var result = actionResult.getReturnValue();
            
            var metadata = result.metadataProperties;
            
            for(var key in metadata.bank_account)
            {
                var comp = component.find(key);
                
                if(comp != null) {
                    comp.set('v.validation', metadata.bank_account[key]);
                }
            }
            
            var content = result.content;
            
            if(content != null) {
                for(var key in content.bank_account)
                {
                    var comp = component.find(key);
                    
                    if(comp != null) {
                        comp.set('v.value', content.bank_account[key]);
                    }
                }
                
                if(content.bank_account.bankId != null) {
                    component.set('v.additional_info', { bank: content.bank_account.bankId })
                }
            }
            
            helper.loadJS('/resource/AMEX_Script', function() { });
            component.set('v.show_content', true);
            spinner.handleToggle();
        });
        
        $A.enqueueAction(action);
        
  	},
    formClear: function(component, event, helper) {

        component.set('v.id', null);
        component.set('v.additional_info', null);
        
        var bank_account = { accountType: '', bankIdentifier: '', accountIdentifier: '', defaultCurrency: '', clientAuthorisationToken: '', name: '' }
        
        for(var key in bank_account)
        {
            var comp = component.find(key);
                
            if(comp != null) {
                comp.set('v.value', '');
            }
        }
        
        helper.refresh(component, event, helper);
        helper.closeModal(component, event, helper);
  	},
    formSubmit: function(component, event, helper) {

        var bank_account = { accountType: '', bankIdentifier: '', accountIdentifier: '', defaultCurrency: '', clientAuthorisationToken: '', bankId: '', branchIdentifier: 'NULL' }
        var additional = { name: '' }
        var has_error = false
        
        for(var key in bank_account)
        {
            var comp = component.find(key);
            
            if(comp != null) {
                
                comp.checkValue();
                has_error |= comp.get('v.has_error');
                var fieldValue = comp.get('v.value');

                bank_account[key] = fieldValue;
            }
        }
        
        for(var key in additional)
        {
            var comp = component.find(key);
            
            if(comp != null) {
                
                comp.checkValue();
                has_error |= comp.get('v.has_error');
                var fieldValue = comp.get('v.value');

                additional[key] = fieldValue;
            }
        }
        
        bank_account.bankId = component.get('v.additional_info').bank;
        
        //console.log('**************In addBankAccount Method:has_error= '+has_error);
        
        if(has_error == false) {
            
            var action = null;
            var id = component.get('v.id');
            
            if(id == null) {
                action = component.get("c.AddBankAccount");
                
                action.setParams({
                    'bank_account_map': bank_account,
                    'name': additional.name
                });
            }
            else {
                action = component.get("c.UpdateBankAccount");
                
                action.setParams({
					'entity_id': id,
                    'bank_account_map': bank_account,
                    'name': additional.name
                });
            }
            
            var self = this;
            action.setCallback(this, function(actionResult) {
                var result = actionResult.getReturnValue();
                
                //Some delay for USBank after Save, needs fix
                
                if(result != null && result[0] == 'Attachment_Id' && result[1] != null) {
                	component.set('v.attachment_id', result[1]);
                    //alert('IN formSubmit: ' + result[1]);
                    helper.getCAF(component, event, helper);
                } 
                else if(result == null) {
                    //alert('IN Callback Else If!!! ');
                    helper.formClear(component, event, helper);
                }
                else {
                    //alert('IN Callback Else: ');
                    for(var index in result) {
                        var key = result[index];

                        var comp = component.find(key);

                        if(comp != null) {
                            comp.set('v.error_message', 'This field is invalid');
                            comp.setInvalid();
                        }
                    }
                    helper.closeModal(component, event, helper);
                }
                
            });
        	$A.enqueueAction(action);
            
        }
		else {
			helper.validationError(component, event);
		}
  	},
    getCAF : function(component, event, helper)
    {
        //alert('In getCAF: ' + component.get('v.attachment_id'));
        var testEvent = component.getEvent("bubblingEventModal");
        testEvent.setParams({
            'type': 'CAF_modal',
            'additional_info': { attachment_id: component.get('v.attachment_id') }
        });
        testEvent.fire();
        helper.formClear(component, event, helper);
    },
    closeModal : function(component, event, helper)
    {
        var testEvent = component.getEvent("bubblingEventModal");
    
        testEvent.setParams 
        ({
            'type': 'bank_account_modal'
        });
            
        testEvent.fire();
    },
    refresh : function(component, event, helper)
    {
        var refreshEvent = component.getEvent("refreshEvent");
        refreshEvent.fire();
    }
})