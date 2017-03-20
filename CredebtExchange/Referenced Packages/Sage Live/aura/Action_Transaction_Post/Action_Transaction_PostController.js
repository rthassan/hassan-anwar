/**
 * Created by marc.albaladejo on 13/08/2016.
 */
({
    postTransaction: function(component, event, helper ) {
        var ids = helper.getRecordIds(component);
        var params = {
            "documentIds": ids,
            "post": true
        };
        helper.callServer(component,'c.postDocumentsById', function(response) {
            if (ids.length > 1) {
                component.set('v.jobId', response);
            }
            else {
                helper.showToast(
                    component,
                    $A.get("$Label.s2cor.Post_Transactions_Complete"),
                    "success"
                );
            }
        }, params, null, function(result) {
             helper.showToast(
                 component,
                 $A.get("$Label.s2cor.Post_Transaction_Error") + ': ' + result,
                 "error"
             );
        })
    },
    getJobStatus : function (component, event, helper) {
        var params = {
            "recordIds": component.get("v.recordIds"),
            "post": true
         };

        var apexMethod = 'c.getFailedTransactions';
        var completeFunction = function(response) {
             var failedRecordNames = [];
             for (var i = 0; i < response.length; i++)
             {
                 if (response[i].Status__c != 'Submitted')
                     failedRecordNames.push(response[i].Name);
             }
             helper.showToast(
                 component,
                 $A.get("$Label.s2cor.Post_Transaction_Error") + ': ' + failedRecordNames.join(),
                 "error"
             );
        };
        var successMessage = $A.get("$Label.s2cor.Post_Transactions_Complete");
        var errorMessage = $A.get("$Label.s2cor.Post_Transaction_Error");

        helper.getJobStatus(component, helper, component.get('v.jobId'), params, apexMethod, completeFunction, successMessage, errorMessage);
    }
})