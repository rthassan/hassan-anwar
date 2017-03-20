({
   onAccept:function(component,event, helper)
   {
       // disable the button for double clicks
        this.toggleAccept(component, false);
       	// show the spinner
       	$A.util.removeClass(component.find("loadingSpinner"), "slds-hide");

        var ids = [component.get("v.recordId")];
        var selectedType =  component.find("selectType").get("v.value");
        var amountToCredit = component.get("v.amountToCredit");
        var totalAmount = component.get("v.totalAmount");
        var productId = component.find("productSelector").get("v.value");
        var headerRequiredTags = JSON.stringify(component.get("v.tags"));
        var documentDate = component.get("v.documentDate");
        var params = {
                   "recordIds": ids,
                   "selectedType": selectedType,
                   "amountToCredit": amountToCredit,
                   "productId" : productId,
                   "totalAmount" : totalAmount,
                   "tagsMap" : headerRequiredTags,
                   "documentDate" : documentDate
        };

        this.callServer(component,'c.convertTo', function(response) {
            this.showToast(component,$A.get("$Label.s2cor.Conversion_Complete"), "success");
        }, params, false, function(result) {
            this.showToast(component,$A.get("$Label.s2cor.Conversion_Failed"), "error");
        });
   },
   onCancel:function(component)
   {
       this.cancelModal();
   }
})