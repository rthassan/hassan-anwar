/**
 * Created by marc.albaladejo on 11/08/2016.
 */
({
    doInit: function (component, event, helper) {
        if (component.get('v.innerListViewId') == event.getParam('innerListViewId'))
        {
            helper.doInit(component, helper);
        }
    },
    changePage : function (component, event, helper) {
        //Protect against calling this twice before the first has finished
        var loading = component.get("v.loading");
        if (loading) {
            return;
        }
        helper.doInit(component, helper);
    },
     refresh: function (component, event, helper) {
        if (component.get('v.innerListViewId') == event.getParam('innerListViewId'))
        {
            helper.doInit(component, helper);
        }
    },
})