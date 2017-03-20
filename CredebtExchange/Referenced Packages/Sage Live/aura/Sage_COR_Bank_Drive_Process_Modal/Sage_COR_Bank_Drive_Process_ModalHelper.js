({
	formLoad : function(component, event, helper) {
		var spinner = component.find('spinner');
        spinner.handleToggle();

        // start download
        var action = component.get("c.ProcessFeed");

        action.setParams({
            'feedId': component.get('v.id')
        });

        var self = this;
        action.setCallback(this, function(actionResult) {
        	helper.checkStatus(component, event, helper);
        });

        $A.enqueueAction(action);
	},
    checkStatus : function(component, event, helper) {

        var in_progress = { 1: 'In Progress', 2: 'Still In Progress', 3: 'This is complex, just a while longer', 4: 'We wont keep you much longer', 5: 'Just finishing up...' }

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
                    var in_progress_count = component.get('v.in_progress_count');

                    if(feed_execution_status == 'In Progress') {
                        in_progress_count += 1;

                        if(in_progress_count > 5){
                            in_progress_count = 1;
                        }

                        component.set('v.in_progress_count', in_progress_count);

                        component.set('v.title', in_progress[in_progress_count])
                    }
                    else {
                        component.set('v.title', feed.feed_execution_status)
                    }

                    if(feed.feed_execution_status != 'Finished'){
                    	helper.checkStatus(component, event, helper);
                    }
                    else {
                        window.setTimeout(
                            $A.getCallback(function() {

                                helper.formClear(component, event, helper);

                            }), (1 * 1000)
                        );
                    }
                });

                $A.enqueueAction(action);

            }), (1 * 2000)
        );
	},
    formClear: function(component, event, helper) {
        var spinner = component.find('spinner');
        spinner.handleToggle();

        component.set('v.title', 'Initializing Transfer');

        helper.refresh(component, event, helper);
        helper.closeModal(component, event, helper);
    },
    closeModal : function(component, event, helper)
    {
        var testEvent = component.getEvent("bubblingEventModal");

        testEvent.setParams
        ({
            'type': 'process_modal',
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