({
    formLoad: function(component, event, helper) {
        
        component.set('v.show_content', false);
        var spinner = component.find('spinner');
        spinner.handleToggle();
        
        var fields = [ 'name', 'vatNumber', 'postalCode', 'standardIndustrialCode' ]
        
        var action = component.get("c.GetOrganisationEnrollment");
        
        var self = this;
        action.setCallback(this, function(actionResult) {
            
            var result = actionResult.getReturnValue();
            
            var metadata = result.metadataProperties;
            
            for(var key in metadata.company)
            {
                var comp = component.find(key);
                
                if(comp != null) {
                    comp.set('v.validation', metadata.company[key]);
                }
            }

            if(metadata.terms != null) {
                var comp = component.find('terms');

                if(comp != null) {
                    comp.set('v.validation', metadata.terms);
                }
            }
            
            var content = result.content;

            if(content.organisationId != null && content.companyId != null) {
                // both org and this company are enrolled
                component.set('v.is_company_enrolled', true);
                component.set('v.is_edit', false);
            }
            else if(content.organisationId != null) {
                // only the org is enrolled, any potentially a different company in this org.
                component.set('v.is_company_enrolled', false);
                component.set('v.is_edit', true);
            }
            
            if(content.company != null) {
                for(var key in fields)
                {
                    var comp = component.find(fields[key]);
                    
                    if(comp != null) {
                        comp.set('v.value', content.company[fields[key]]);                        
                    }
                }
            }
            
            if(content.bank_accounts != null) {
                component.set('v.bank_accounts', content.bank_accounts);
            }
            
            helper.loadJS('/resource/Custom_Script', function() { });
            helper.getBanks(component, event, helper);
            spinner.handleToggle();
            component.set('v.show_content', true);
        });
        
        $A.enqueueAction(action);
  	},
    getBanks: function(component, event, helper) {
        
        var action = component.get("c.GetBanks");
        
        var self = this;
        action.setCallback(this, function(actionResult) {
            var result = actionResult.getReturnValue();
            component.set('v.banks', result);
        });
        
        $A.enqueueAction(action);
  	},
    formSubmit: function(component, event, helper) {
        
        var company = { name: '', vatNumber: '', postalCode: '', standardIndustrialCode: 00 }
        var terms = { terms: '' }

        var has_error = false
        
        for(var key in company)
        {
            var comp = component.find(key);
            
            if(comp != null) {
                comp.checkValue();
                
                var fieldValue = comp.get('v.value');
                has_error |= comp.get('v.has_error');

                company[key] = fieldValue;
            }
        }

        for(var key in terms)
        {
            var comp = component.find(key);

            if(comp != null) {
                comp.checkValue();

                var fieldValue = comp.get('v.value');
                has_error |= comp.get('v.has_error');

                terms[key] = fieldValue;
            }
        }
        
        if(has_error == false) {
            var action = component.get("c.AddOrganisation");
            
            action.setParams({
                'company': company
            });
            
            //Set up the callback
            var self = this;
            action.setCallback(this, function(actionResult) {

                var result = actionResult.getReturnValue();

                if(result == null) {
                    helper.formLoad(component, event, helper);
                }
                else {
                    for(var index in result) {
                        var key = result[index];

                        var comp = component.find(key);

                        if(comp != null) {
                            comp.set('v.error_message', 'This field is invalid');
                            comp.setInvalid();
                        }
                    }
                }

                /*var evt = $A.get("e.force:navigateToComponent");
                
                evt.setParams({
                    componentDef: "axxx_js2016_6:Sage_LTN_Enrollment_Address"
                });
                
                evt.fire();*/
                
            });
            
            $A.enqueueAction(action);
        }
        else {
            helper.validationError(component, event);
        }
  	},
    edit: function(component, event, helper) {
        component.set('v.is_edit', true);
  	},
    update: function(component, event, helper) {
        var company = { name: '', vatNumber: '', postalCode: '', standardIndustrialCode: 00 }

        var has_error = false
        
        for(var key in company)
        {
            var comp = component.find(key);
            
            if(comp != null) {
                comp.checkValue();
                
                var fieldValue = comp.get('v.value');
                has_error |= comp.get('v.has_error');

                company[key] = fieldValue;
            }
        }
        
        if(has_error == false) {
            var action = component.get("c.UpdateCompany");
            
            action.setParams({
                'company_map': company
            });
            
            //Set up the callback
            var self = this;
            action.setCallback(this, function(actionResult) {

                var result = actionResult.getReturnValue();

                if(result == null) {
                    helper.formLoad(component, event, helper);
                }
                else {
                    for(var index in result) {
                        var key = result[index];

                        var comp = component.find(key);

                        if(comp != null) {
                            comp.set('v.error_message', 'This field is invalid');
                            comp.setInvalid();
                        }
                    }
                }
            });
            
            $A.enqueueAction(action);
        }
        else {
            helper.validationError(component, event);
        }
  	},
  	cancel: function(component, event, helper) {
        helper.formLoad(component, event, helper);
        component.set('v.is_edit', false);

        var company = { name: '', vatNumber: '', postalCode: '', standardIndustrialCode: 00 }
        var terms = { terms: '' }

        var has_error = false

        for(var key in company)
        {
            var comp = component.find(key);

            if(comp != null) {
                comp.setValid();
                comp.set('v.error_message', null);
            }
        }

        for(var key in terms)
        {
            var comp = component.find(key);

            if(comp != null) {
                comp.setValid();
                comp.set('v.error_message', null);
            }
        }
    },
    toggleButtons : function(component, event, helper) {
        var more = component.find('more-buttons');
        
        if($A.util.hasClass(more, 'slds-hidden')) {
            $A.util.removeClass(more, 'slds-hidden');
        }
        else {
            $A.util.addClass(more, 'slds-hidden');
        }
         
    },
    selectBank : function(component, event, helper) {
        var bank = event.target.dataset.bank;
        
        var testEvent = component.getEvent("bubblingEventModal");
        testEvent.setParams 
        ({
            'type': 'bank_account_modal',
            'additional_info': { bank: bank }
        });
        testEvent.fire();
        helper.toggleButtons(component, event, helper);
    }
})