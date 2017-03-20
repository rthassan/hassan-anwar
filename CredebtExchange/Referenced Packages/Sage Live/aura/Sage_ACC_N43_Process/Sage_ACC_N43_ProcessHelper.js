({
	process : function(component, event, helper) {

		var testEvent = component.getEvent("bubblingEventModal");

        var content = event.getParam('content');
        var additional_info = { content: content }

        testEvent.setParams
        ({
            'type': 'n43_process_modal',
            'id': component.get('v.id'),
            'additional_info': additional_info
        });

        testEvent.fire();
	},
    formLoad : function(component, event, helper) {
        var action = component.get("c.GetFeed");

        action.setParams({
            'feedId': component.get('v.id')
        });

        var self = this;
        action.setCallback(this, function(actionResult) {
            var feed = actionResult.getReturnValue();

            if(feed != null) {
                if(feed.Name != null) {
                	component.set('v.name', feed.Name);
                }
                if(feed.LastRun != null) {
                	component.set('v.last_run', feed.LastRun);
                }
                if(feed.LastError != null) {
                	component.set('v.last_error', feed.LastError);
                }
                if(feed.Job != null) {
                	component.set('v.schedule_id', feed.Job);
                    component.set('v.schedule_name', feed.JobName);
                }
                if(feed.JournalType != null) {
                	component.set('v.output_journal_type_id', feed.JournalType);
                    component.set('v.output_journal_type_name', feed.JournalTypeName);
                }
                if(feed.feed_items != null) {
                	component.set('v.feed_items', feed.feed_items);
                }
                if(feed.feed_execution_id != null) {
                	component.set('v.feed_execution_id', feed.feed_execution_id);
                    component.set('v.feed_execution_name', feed.feed_execution_name);
                }
            }

            //helper.loadJS('/resource/Custom_Script', function() { });
        });

        $A.enqueueAction(action);
	}
})