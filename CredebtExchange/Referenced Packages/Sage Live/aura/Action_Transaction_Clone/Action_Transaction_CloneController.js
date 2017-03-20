/**
 * Created by marc.albaladejo on 18/08/2016.
 */
({
    cloneTransaction: function(component, event, helper ) {
        var params = {
            "recordIds": helper.getRecordIds(component)
        };
        helper.callServer(component,'c.cloneDocuments', function(response) {
             helper.showToast(
                 component,
                 $A.get("$Label.s2cor.Clone_Transaction_Complete"),
                 "success"
             );
            var evtNavigate = $A.get('e.force:navigateToSObject');
            evtNavigate.setParam('recordId',response);
            evtNavigate.fire();
        }, params, false, function(result) {
            helper.showToast(
                component,
                $A.get("$Label.s2cor.Post_Transaction_Error") + ': ' + result,
                "error"
            );
        })
    }
})