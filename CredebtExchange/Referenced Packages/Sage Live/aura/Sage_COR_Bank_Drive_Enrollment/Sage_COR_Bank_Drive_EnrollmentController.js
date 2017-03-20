({
	handleFormSubmit : function(component, event, helper) {
		helper.formSubmit(component, event, helper);
	},
    handleFormLoad : function(component, event, helper) {
		helper.formLoad(component, event, helper);
	},
    handleEdit : function(component, event, helper) {
		helper.edit(component, event, helper);
	},
    handleUpdate : function(component, event, helper) {
		helper.update(component, event, helper);
	},
	handleCancel : function(component, event, helper) {
        helper.cancel(component, event, helper);
    },
    handleToggleButtons : function(component, event, helper) {
		helper.toggleButtons(component, event, helper);
	},
    handleSelectBank : function(component, event, helper) {
		helper.selectBank(component, event, helper);
	}
})