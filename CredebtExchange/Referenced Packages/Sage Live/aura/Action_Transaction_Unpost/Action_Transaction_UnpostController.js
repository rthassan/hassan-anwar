/**
 * Created by marc.albaladejo on 18/08/2016.
 */
({
    postTransaction: function(component, event, helper ) {
        var ids = helper.getRecordIds(component);
        var params = {
            "documentIds": ids,
            "post": false
        };
        helper.callServer(component,'c.postDocumentsById', function(response) {
            if (ids.length > 1) {
                component.set('v.jobId', response);
            }
            else {
                helper.showToast(
                    component,
                    $A.get("$Label.s2cor.Unpost_Complete"),
                    "success"
                );
            }
        }, params, false, function(result) {
             helper.showToast(
                 component,
                 $A.get("$Label.s2cor.Unpost_Error") + ': ' + result,
                 "error"
             );
        })
    },
     getJobStatus : function (component, event, helper) {
         var params = {
             "recordIds": component.get("v.recordIds"),
             "post": false
          };

         var apexMethod = 'c.getFailedTransactions';
         var completeFunction = function(response) {
              var failedRecordNames = [];
              for (var i = 0; i < response.length; i++)
              {
                  if (response[i].Status__c != 'Unsubmitted')
                      failedRecordNames.push(response[i].Name);
              }
              helper.showToast(
                  component,
                  $A.get("$Label.s2cor.Unpost_Error") + ': ' + failedRecordNames.join(),
                  "error"
              );
         };
         var successMessage = $A.get("$Label.s2cor.Unpost_Complete");
         var errorMessage = $A.get("$Label.s2cor.Unpost_Error");

         helper.getJobStatus(component, helper, component.get('v.jobId'), params, apexMethod, completeFunction, successMessage, errorMessage);
     }
})