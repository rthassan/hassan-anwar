/**
 Copyright: © Sage Global Services Limited 2016. All rights reserved.
 */
({
    onAccept : function(component, event) {
        var product = component.get('v.newProduct');
        var uid =  component.get('v.uid');
        var params = { "product": product,
                        "uid":uid
                     }
        this.callServer(component,'c.createNewProduct',function(response){
            var navEvent = $A.get("e.force:navigateToSObject");
            navEvent.setParams({
              "recordId": response.objects.Product2.Id,
              "slideDevName": "detail"
            });
            navEvent.fire();
            this.closeModal();
        }, params)
    }
})