/**
 * Created by marc.albaladejo on 13/08/2016.
 */
({
    displayModal: function(component) {
        var backdrop = component.find('backdrop');
        var modal = component.find('modaldialog');
        $A.util.addClass(backdrop,'slds-backdrop--open');
        $A.util.addClass(modal,'slds-fade-in-open');
    },

    hideModal: function(component) {
        var backdrop = component.find('backdrop');
        var modal = component.find('modaldialog');
        $A.util.removeClass(backdrop,'slds-backdrop--open');
        $A.util.removeClass(modal,'slds-fade-in-open');
    },

    createComponent: function(component, eventComponent, eventAttributes) {
        if (eventAttributes == undefined) eventAttributes = {};
        eventAttributes["aura:id"]="createdComponent";
        $A.createComponent(
            eventComponent,
            eventAttributes,
            function(newComponent){
                if (component.isValid() && newComponent.isValid()) {
                    var body = [];//component.get("v.body");
                    body.push(newComponent);
                    component.set("v.body", body);
                }
            }
        );
    },

    destroyComponent: function(component)
    {
        var newbody = component.get("v.body");
        component.set("v.body",[]);
    },

    refreshInnerListView: function(component) {
        try{

            var innerListViewId = component.get('v.innerListViewId');

            if (innerListViewId != null) {
                var appEvent = $A.get("e.s2cor:Event_Refresh_Data_Tables");
                    appEvent.setParam('innerListViewId',innerListViewId);
                    appEvent.fire();
            }
        }
        catch(err)
        {
            //console.log('Error firing Event_Refresh_Data_Tables ' + err.message);
        }
    }
})