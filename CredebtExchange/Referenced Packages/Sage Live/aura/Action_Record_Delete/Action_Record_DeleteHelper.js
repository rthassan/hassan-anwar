/**
 * Created by ansja02 on 11/2/16.
 */
({
    onAccept : function(component, event) {
        this.deleteRecord(component, event);
    },
    deleteRecord: function(component, event) {
        var cmpTarget = component.find('confirmation');
        $A.util.addClass(cmpTarget, 'slds-hide');

        this.toggleAccept(component, false);

        var params = {
            "recordIDs": this.getRecordIds(component)
        };

        this.callServer(component,'c.deleteRecords', function(response) {
            this.showToast(
                component,
                $A.get("$Label.s2cor.Delete_Records_Complete"),
                "success"
            );
        }, params, null, function(result) {
            this.showToast(
                component,
                $A.get("$Label.s2cor.Error_Deleting") + ': ' + result,
                "error"
            );
        })
    }
})