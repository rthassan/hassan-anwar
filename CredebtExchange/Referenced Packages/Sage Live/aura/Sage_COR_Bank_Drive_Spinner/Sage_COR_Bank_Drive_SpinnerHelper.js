({
	toggle : function(component, event, helper) {
        var wrapper_element = component.find('wrapper_element');
        $A.util.toggleClass(wrapper_element, 'slds-is-collapsed');
	}
})