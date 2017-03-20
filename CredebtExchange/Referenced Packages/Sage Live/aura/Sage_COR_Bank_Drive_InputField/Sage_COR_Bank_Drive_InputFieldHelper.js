({
	checkValue : function(component, event, helper) {
		
        var form = component.find('field-form').getElement();
		var isvalid = form.checkValidity();
        
        if(isvalid == false) {
            $A.util.addClass(form, 'slds-has-error'); 
            component.set('v.has_error', true);
        }
        else {
            $A.util.removeClass(form, 'slds-has-error'); 
            component.set('v.has_error', false);
        }
	},
	setInvalid : function(component, event, helper) {
	    var form = component.find('field-form').getElement();
        $A.util.addClass(form, 'slds-has-error');
    },
    setValid : function(component, event, helper) {
        var form = component.find('field-form').getElement();
        $A.util.removeClass(form, 'slds-has-error');
    }
})