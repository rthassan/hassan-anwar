({
	showToast: function(component, event) {
        var showToast = $A.get('e.force:showToast');
		var mode = event.getParam('mode');
        
        if(mode == null) {
            mode = 'dismissible'
        }
        
        //set the title and message params
        showToast.setParams 
        ({
            'title': event.getParam('title'),
            'message': event.getParam('message'),
            'type': event.getParam('type'),
            'mode': mode
        });
        
        //fire the event
        showToast.fire();
  	},
    showModal: function(component, event) {
        var type = event.getParam('type');
        var id = event.getParam('id');
        var additional_info = event.getParam('additional_info');
        
        if(type == null) {
            type = 'Sage_COR_Bank_Drive_Notification_Modal';
        }
        
        var new_modal = component.find(type);
        
        // hoping for hidden
        var class_value = new_modal.get('v.class');
        
        // now shown
        new_modal.showHide();
        
        // if it WAS hidden
        if(class_value == 'slds-hide') {
            new_modal.set('v.id', id);
            new_modal.set('v.additional_info', additional_info);
            new_modal.init();
        }
  	},
    checkNotifications : function(component, event, helper) {
        
  	},
    validationError : function(component, event) {
        /*var toast = component.getEvent("bubblingEventToast");
        toast.setParams 
        ({
            'type': 'error',
            'title': 'Errors',
            'message': 'Please correct the errors and try again'
        });
        toast.fire();*/
  	},
    loadJS : function(source, callback) {
        var loadScript = document.createElement('script');
        loadScript.setAttribute('src', source);
        loadScript.onload = callback;
        document.head.appendChild(loadScript);
    }
})