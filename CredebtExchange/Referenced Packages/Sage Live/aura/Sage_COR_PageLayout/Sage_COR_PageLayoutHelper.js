({
		callServer : function(component,method,params,callback,cacheable) {
        var action = component.get(method);
        if (params) {
            action.setParams(params);
        }
        if (cacheable) {
            action.setStorable();
        }
        action.setCallback(this,function(response) {
            var state = response.getState();
            if (state === "SUCCESS") { 
                // pass returned value to callback function
                callback.call(this,response.getReturnValue());   
            } else if (state === "ERROR") {
                // generic error handler
                var errors = response.getError();
                if (errors) {
                    $A.log("Errors", errors);
                    if (errors[0] && errors[0].message) {
                        throw new Error("Error" + errors[0].message);
                    }
                } else {
                    throw new Error("Unknown Error");
                }
            }
        });
    	//http://pchittum.com/2015/04/28/Lightning-Component-Exclusive-Actions/
    	//action.setExclusive();
        $A.enqueueAction(action);
    }
})