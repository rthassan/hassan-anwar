({
    init : function(component, event, helper) {
    	this.loadJS('/resource/Custom_Script', function() { }); // problem
        helper.riskManagement(component, event, helper);
	},
    showHide : function(component, event, helper) {

        if(component.get('v.class') == 'slds-hide') {
        	component.set('v.class', '');    
        }
        else {
            component.set('v.class', 'slds-hide');
        }
        
	},
    loadJS : function(source, callback) {
        var loadScript = document.createElement('script');
        loadScript.setAttribute('src', source);
        loadScript.onload = callback;
        document.head.appendChild(loadScript);
    },
    validationError : function(component, event) {
        /*var toast = component.getEvent("bubblingEventToast");
        toast.setParams 
        ({
            'type': 'error',
            'title': 'Errors',
            'message': 'Please correct the errors and try again'
        });
        toast.fire();*/ // cannot use in Ligthning Out
  	}
})