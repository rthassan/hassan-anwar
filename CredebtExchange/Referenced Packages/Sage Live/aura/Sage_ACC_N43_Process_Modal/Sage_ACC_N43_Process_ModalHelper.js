({
	formLoad : function(component, event, helper) {
		var spinner = component.find('spinner');
        spinner.handleToggle();

        // start download
        var action = component.get("c.ProcessFeed");

        var content = component.get('v.additional_info').content

        action.setParams({
            'feedId': component.get('v.id'),
            'content': content
        });

        var self = this;
        action.setCallback(this, function(actionResult) {
            var result = actionResult.getReturnValue();

            if(result == null) {
        	    helper.checkStatus(component, event, helper);
        	}
        	else {

                component.set('v.title', result)
        	    window.setTimeout(
                    $A.getCallback(function() {
                        helper.formClear(component, event, helper);
                    }), (1 * 2000)
                );
                /*var toastEvent = $A.get("e.force:showToast");
                toastEvent.setParams({
                    "message": result,
                    "type": "error",
                    "mode": 'sticky'
                });
                toastEvent.fire();
                helper.closeModal(component, event, helper);*/
            }


        });

        $A.enqueueAction(action);
	},
    checkStatus : function(component, event, helper) {

		window.setTimeout(
            $A.getCallback(function() {

                var action = component.get("c.GetProcessFeedStatus");

                action.setParams({
                    'feedId': component.get('v.id')
                });

                var self = this;
                action.setCallback(this, function(actionResult) {
                    var feed = actionResult.getReturnValue();

                    var feed_execution_status = feed.feed_execution_status;

                    component.set('v.title', feed.feed_execution_status)

                    var status = feed.feed_execution_status;
                    if (status.startsWith($A.get("$Label.s2cor.Feed_Execution_Status_Finished"))){
                        helper.openSuccessUrl(component, event, helper);
                        helper.closeModal(component, event, helper);
                    }
                    else {
                        helper.checkStatus(component, event, helper);
                    }
                });

                $A.enqueueAction(action);

            }), (1 * 2000)
        );
	},

    openSuccessUrl: function(component, event, helper) {
        var action = component.get("c.getSuccessUrl");
        action.setParams({
            'feedId': component.get('v.id')
        });
        action.setCallback(this, function(actionResult) {
            var response = actionResult.getReturnValue();
             if (response.theme == "Theme3") {
                        window.location.href = response.url;
                   } else {
                       sforce.one.navigateToURL(response.url);
              }
        });
        $A.enqueueAction(action);
    },

    formClear: function(component, event, helper) {
        var spinner = component.find('spinner');
        spinner.handleToggle();

        component.set('v.title', $A.get("$Label.s2cor.Process_Transactions"));

        helper.refresh(component, event, helper);
        helper.closeModal(component, event, helper);
    },
    closeModal : function(component, event, helper)
    {
        var testEvent = component.getEvent("bubblingEventModal");

        testEvent.setParams
        ({
            'type': 'n43_process_modal',
            'id': component.get('v.id')
        });

        testEvent.fire();
    },
    refresh : function(component, event, helper)
    {
        var refreshEvent = component.getEvent("refreshEvent");
        refreshEvent.fire();
    }
})