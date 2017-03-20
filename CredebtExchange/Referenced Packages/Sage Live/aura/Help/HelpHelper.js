/**
 * Created by daniel.nicholson on 05/12/2016.
 */
({
    monitorBatches : function (component, helper) {
        var interval = (5 * 1000); // in milliseconds
        var timeout = 60; // in minutes

        // Run every <interval> milliseconds until there are no batches to monitor,
        // timeout a batch after <timeout> minutes
        window.setTimeout(
         $A.getCallback(function() {

            console.log('Checking batches');

            var batches = component.get('v.batches');
            var params = {"batchListString": JSON.stringify(batches)};

            var activeBatches = [];

            // returns updated list of active batches
            helper.callServer(component,'c.getBatchStatuses', function(response) {

                   for (var batch in batches) {
                        // Look for batch in response
                        if (response[batches[batch].id] == undefined) {
                            console.log('Ignoring batch ' + batches[batch].id);
                            continue;
                        }

                        // Sage_ACC_Constants.kRunning
                        if (response[batches[batch].id] != 'Running') {
                            // batch is complete. show toast

                            // @todo add additional statuses
                            // comment hint, do not remove!
                            //$Label.s2cor.Finished
                            //$Label.s2cor.Success
                            //$Label.s2cor.Warnings
                            //$Label.s2cor.Completed

                            var statusLabel = $A.get("$Label.s2cor." + response[batches[batch].id]);

                            var msg = $A.get("$Label.s2cor.Batch_Complete")  + ' "' + statusLabel + '": ' + batches[batch].description;
                            helper.showToast(
                                 component,
                                 msg,
                                 "info"
                            );
                        }
                        else if ((batches[batch].started  + (timeout*60)) < Math.floor(Date.now() / 1000)) {
                             // batch has reached timeout
                             helper.showToast(
                                  component,
                                  $A.get("$Label.s2cor.Batch_Timeout")  + ': ' + batches[batch].description,
                                  "error"
                             );
                        }
                        else {
                             activeBatches.push(batches[batch]);
                        }
                   }
                   console.log('Active Batches: ');
                   console.log(activeBatches);
                  // Update batch list with current active batch
                  component.set('v.batches', activeBatches);
                  // only call again if there are batches to monitor
                  if (activeBatches.length > 0) helper.monitorBatches(component, helper);
               }, params);
            }), interval
        );
    }
})