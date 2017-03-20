/**
 * Created by daniel.nicholson on 15/11/2016.
 */
({
    onAccept : function (component, event) {
        component.set('v.acceptEnabled', false);

        var feedIds = [];
        if (component.get('v.selectedFeedId') != undefined) {
            feedIds = [component.get('v.selectedFeedId')];
        }
        else {
            var feeds = component.get('v.feeds');
            for (f in feeds) {
                feedIds.push(feeds[f].id);
            }
        }

        // Accept form
        this.callServer(component,'c.executeFeedProcess', function(response) {
            // Start monitoring batch(es)
            if (this.getRecordIds(component).length > 1) {
                for (batchId in response) {
                    var evt = $A.get("e.s2cor:Event_Monitor_Batch");
                    evt.setParams
                    ({
                        'batchId': response[batchId].id,
                        'description' : $A.get("$Label.s2cor.Bank_Feed_Process_Description") + ': ' + response[batchId].name,
                        'userId' : null
                    });
                    evt.fire();
                }
                this.showToast(
                    component,
                    $A.get("$Label.s2cor.Feed_Process_In_Progress"),
                    "success");
            }
            else this.checkStatus(component, this);
        },
        {
            "feeds": feedIds,
            "csv": component.get('v.csvFile')
        }, null, function(response) {
             this.showToast(
                 component,
                 $A.get("$Label.s2cor.Feed_Process_Error")  + ': ' + response,
                 "error"
        )});
    },
    doInit : function (component) {

        this.initBind(component, this);
        var ids = this.getRecordIds(component);

        // Individual action
        if (ids.length == 1) {
            // get feed brokers (type = 'Journal', configuration contains bank tag and dimension)
            this.callServer(component,'c.getMatchingFeeds', function(response) {
                console.log("c.getMatchingFeeds response:");
                console.log(response);
                feeds = JSON.parse(response);
                component.set('v.feeds', feeds);

                if (feeds.length > 1) {
                    // Display feeds in a select list asking to the user to select one
                    component.set('v.showFeedSelector', true);
                }
                else if (feeds.length == 1)  {
                    // Display UI as per bank drive.
                    // - If feed type 'csv', display upload input for file.
                    component.set("v.selectedFeedId", feeds[0].id);
                    this.changeSelectedFeed(component);
                }
                else
                {
                    this.showToast(
                        component,
                        $A.get("$Label.s2cor.No_Feeds_Available"),
                        "error"
                    );
                }
                this.hideSpinner(component);
            },
            {
                "bankIds": ids
            });
        }
        // Bulk action
        else {
            // When bulk, the option will process directly all the feeds associated with the selected banks
            // (except those of type 'CSV'). It will ask confirmation to the user and, once accepted,
            // it will execute each one of the process methods for each feed.
            // get feed brokers (type = 'Journal', configuration contains bank tag and dimension)
            this.callServer(component,'c.getMatchingFeeds', function(response) {
                console.log("c.getMatchingFeeds response:");
                console.log(response);
                feeds = JSON.parse(response);
                component.set('v.feeds', feeds);

                if (feeds.length > 0) {
                    // Display feeds in a select list asking to the user to select one
                    component.set('v.acceptEnabled', true);
                }
                else
                {
                    this.showToast(
                        component,
                        $A.get("$Label.s2cor.No_Feeds_Available"),
                        "error"
                    );
                }
                this.hideSpinner(component);
            },
            {
                "bankIds": ids
            });

        }
    },
    changeSelectedFeed : function (component) {
        var selectedFeedId = component.get("v.selectedFeedId");
        var selectedFeed;
        var feeds = component.get("v.feeds");

        for (var f in feeds)
        {
           if (feeds[f].id == selectedFeedId) {
                component.set("v.selectedFeed", feeds[f]);
                selectedFeed = feeds[f];
           }
        }

        if (selectedFeed != undefined) {
            if (selectedFeed.broker_type == 'Bank-Manual') $A.util.removeClass(component.find("csvUpload"), "slds-hide"); // prompt for file
            else {
                $A.util.addClass(component.find("csvUpload"), "slds-hide"); // do not prompt for file
                component.set('v.csvFile', null);
            }
            component.set('v.acceptEnabled', true);
        }
        else {
            component.set("v.selectedFeed", undefined);
            component.set('v.acceptEnabled', false);
        }

        this.hideSpinner(component);
    },
    handleUpload : function (component, event) {
        var content = event.getParam('content');
        component.set("v.csvFile", content);
        this.hideSpinner(component);
    },
    checkStatus : function(component, helper) {
        window.setTimeout(
            $A.getCallback(function() {

                var action = component.get("c.GetProcessFeedStatus");

                console.log(component.get('v.selectedFeed'));

                action.setParams({
                    'feedId': component.get('v.selectedFeed').id
                });

                var self = this;
                action.setCallback(this, function(actionResult) {
                    var feed = actionResult.getReturnValue();

                    var feed_execution_status = feed.feed_execution_status;
                    component.set('v.title', feed.feed_execution_status)

                    if(feed.feed_execution_status.startsWith($A.get("$Label.s2cor.Feed_Execution_Status_Finished")) == false && feed.feed_execution_status.startsWith($A.get("$Label.s2cor.Done")) == false){
                        helper.checkStatus(component, helper);
                    }
                    else {
                        if (feed.end_url != null && feed.end_url != undefined) {
                            $A.util.addClass(component.find("mainContent"), "slds-hide");
                            component.set('v.output', feed.end_url);
                            component.set('v.title', $A.get("$Label.s2cor.Feed_Process_Complete") + ' ' + feed.feed_execution_result);
                            helper.hideSpinner(component);
                        }
                        else {
                            helper.showToast(
                                component,
                                $A.get("$Label.s2cor.Feed_Process_Complete") + ' ' + feed.feed_execution_result,
                                "success"
                            );
                        }
                    }
                });
                $A.enqueueAction(action);
            }), (1 * 2000)
        );
    }
})