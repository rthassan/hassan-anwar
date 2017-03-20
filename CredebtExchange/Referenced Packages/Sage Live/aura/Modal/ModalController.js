/**
 * Created by marc.albaladejo on 13/08/2016.
 */
({
    openModal: function(component, event, helper) {
        // handle the application event and set the record id to the recordId attribute:
        var params = event.getParams();
        var eventComponent = params.component;
        var eventAttributes = params.attributes;
        var eventParentId = params.parentId;
        //only if belonging to the parent
        if (eventParentId == component.get('v.parentId')) {
            //build the component and push into the body
            helper.createComponent(component, eventComponent, eventAttributes);
            //display the modal
            helper.displayModal(component);
            event.stopPropagation();
        }
    },

    closeModal : function(component, event, helper) {
        helper.hideModal(component);
        helper.destroyComponent(component);
        var refresh = event.getParam('refresh');
        if (refresh) {
            helper.refreshInnerListView(component);
        }
    },

    // No refresh list event called
    closeModalOnCancel:function(component, event, helper)
    {
        helper.hideModal(component);
        helper.destroyComponent(component);
    }
})