/**
 * Created by daniel.nicholson on 16/08/2016.
 */
({
    postJournal: function(component, event, helper ) {
        var ids = helper.getRecordIds(component);
        helper.callServer(component,'c.postJournalsById', function(response) {

            if (ids.length > 1) {
                component.set('v.jobId', response);
            }
            else {
                helper.showToast(
                    component,
                    $A.get("$Label.s2cor.Journal_Post_Successful"),
                    "success"
                );
            }
        },
        {
            "journalIds": ids,
            "post": true
        }, null, function(response) {
            helper.showToast(
                component,
                $A.get("$Label.s2cor.Journal_Post_Error")  + ': ' + response,
                "error"
            );
        })
    },
    getJobStatus : function (component, event, helper) {
        var params = {
            "journalIds": component.get("v.recordIds"),
            "post": true
            };

        var apexMethod = 'c.getFailedJournals';
        var completeFunction = function(response) {
            var failedJournalNames = [];
            for (var i = 0; i < response.length; i++)
            {
                if (response[i].Status__c != 'Submitted')
                    failedJournalNames.push(response[i].Name);
            }
            helper.showToast(
                component,
                $A.get("$Label.s2cor.Journal_Post_Error") + ': ' + failedJournalNames.join(),
                "error"
            );
        };
        var successMessage = $A.get("$Label.s2cor.Journal_Post_Successful");
        var errorMessage = $A.get("$Label.s2cor.Journal_Post_Error");
        helper.getJobStatus(component, helper, component.get('v.jobId'), params, apexMethod, completeFunction, successMessage, errorMessage);
    }
})