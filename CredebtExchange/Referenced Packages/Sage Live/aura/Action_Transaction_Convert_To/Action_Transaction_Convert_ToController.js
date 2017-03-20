({
    doInit : function(component, event, helper){
        helper.initBind(component,helper);
        component.find("selectType").set("v.value",$A.get("$Label.s2cor.Type_Complete"));
        var ids = [component.get("v.recordId")];
        var params = {
            "recordIds": ids
        };
        helper.callServer(component,'c.getVals', function(response) {
            component.set("v.convertTypes", response.types);
            component.set("v.hasError", (response.canConvert ? false : true));
            component.set("v.errorMessage", response.canConvertErrorMessage);
            component.set("v.outstandingAmount", response.outstandingAmount);
            component.set("v.totalAmount", response.totalAmount);
            component.set("v.amountToCredit", response.outstandingAmount);
            component.set("v.allowConvertRepetition", response.allowConvertRepetition);
            component.set("v.isConverted", response.isConverted);
            component.set("v.title", response.title);
            component.set("v.documentDate", response.documentDate);

            // setup dto
            var dto = {
                        "renderType": "Input",
                        "type": response.convertingToDocumentType,
                        "postingRuleType": "Header",
                        "itemType": null,
                        "suppliedTags": response.existingTags,
                        "showOptional": true
                      };
             component.set("v.dto", dto);
            if (response.isConverted && !response.allowConvertRepetition)
            {
                helper.toggleAccept(component, false);
            }
            else
            {
                 helper.toggleAccept(component, true);
            }
            $A.util.addClass(component.find("loadingSpinnerTop"), "slds-hide");
        }, params, false);
    },

    setTypeSelected : function(component, event, helper){
        var amountInputDiv = component.find("amountInputDiv");
    	var dropDownType = component.find("selectType").get("v.value");

        helper.toggleAccept(component, true);

        if (dropDownType == $A.get("$Label.s2cor.Type_Complete"))
        {
            $A.util.addClass(amountInputDiv, "slds-hide");
        }
        else if (dropDownType == $A.get("$Label.s2cor.Type_Partial"))
        {
            helper.toggleAccept(component, false);
            $A.util.removeClass(amountInputDiv, "slds-hide");
            helper.callServer(component,'c.getProducts', function(response) {
                        component.set("v.products", response.products);
                        component.set("v.productIdFromUserContext", response.productIdFromUserContext);
                        if (response.productIdFromUserContext != null && response.productIdFromUserContext != '')
                        {
                            component.find("productSelector").set('v.value', response.productIdFromUserContext);
                            helper.toggleAccept(component, true);
                        }
            }, null);
        }
    },

    setProductSelected : function(component, event, helper){
        var prod = component.find("productSelector").get("v.value");
        if (prod != '-1')
        {
            helper.toggleAccept(component, true);
        }
        else
        {
            helper.toggleAccept(component, false);
        }
     },

	validateAmount : function(component, event, helper)
	{
        var input = component.find("amountToCreditInput");
        var prod = component.find("productSelector").get("v.value");

        var validProduct = (prod == null ? false : true);
        validProduct = (prod == "-1" ? false : true);
        validProduct = (prod == undefined ? false : true);

        helper.toggleAccept(component, (input.get("v.validity").valid && validProduct));
    },

    handleAllRequiredTagsSelected : function(component, event, helper)
    {
        if (component.get("v.allRequiredTagsSelected") == false)
        {
            helper.toggleAccept(component, false);
        }
        else
        {
            helper.toggleAccept(component, true);
        }
    },

    handleErrorChange : function(component, event, helper)
    {
        helper.toggleAccept(component, !component.get("v.hasError"));
    }
})