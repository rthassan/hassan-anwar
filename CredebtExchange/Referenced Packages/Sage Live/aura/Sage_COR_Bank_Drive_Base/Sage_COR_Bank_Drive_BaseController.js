({
    handleToast : function(component, event, helper) {
		helper.showToast(component, event);
	},
    handleModal : function(component, event, helper) {
		helper.showModal(component, event);
	},
    handleNotifications : function(component, event, helper) {
		helper.checkNotifications(component, event, helper);
	}
})