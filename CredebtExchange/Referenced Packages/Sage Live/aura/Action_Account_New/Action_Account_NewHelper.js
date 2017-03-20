/**
 Copyright: © Sage Global Services Limited 2016. All rights reserved.
 */
({
    onAccept : function(component, event) {
        var account = component.get('v.newAccount');
        var uid =  component.get('v.uid');
        var params = { "account": account,
                        "uid":uid
                     }
        this.callServer(component,'c.createNewAccount',function(response){
            var navEvent = $A.get("e.force:navigateToSObject");
            navEvent.setParams({
              "recordId": response.objects.Account.Id,
              "slideDevName": "detail"
            });
            navEvent.fire();
            this.closeModal();
        }, params)
    }
})