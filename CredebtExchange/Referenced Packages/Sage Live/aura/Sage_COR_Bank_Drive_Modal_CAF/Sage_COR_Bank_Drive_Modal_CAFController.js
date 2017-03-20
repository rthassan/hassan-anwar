({
    handleLoadCAF : function(component, event, helper) {
        helper.loadCAF(component, event, helper);
    },
    handleFormSubmit : function(component, event, helper) {
		helper.formSubmit(component, event, helper);
	},
    handleFormClear : function(component, event, helper) {
		helper.formClear(component, event, helper);
	},
    handlePrintPDF : function(component, event, helper) {
        helper.printPDF(component, event, helper);
    },
    handlePrintObjectPDF : function(component, event, helper) {
    	helper.printObjectPDF(component, event, helper);
	},
    handlePrintIframePDF : function(component, event, helper) {
        helper.printIframePDF(component, event, helper);
    }
})