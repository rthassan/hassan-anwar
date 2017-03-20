({
	callServer : function(component,method,callback,params,cacheable) {
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
    
        $A.enqueueAction(action);
    },
    
    // Code from Section 4 page 38 of the Lighting Training Guide 2016
    findParentElement: function(elem,type)
    {
    	type = type.toUpperCase();
        while (true){ 
            if(elem.tagName.toUpperCase() == type){
            	return elem;    
            }
            else{
                elem = elem.parentNode;
            }
        }
	}
})