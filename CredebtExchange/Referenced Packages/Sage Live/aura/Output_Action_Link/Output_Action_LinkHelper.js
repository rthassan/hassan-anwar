/**
 * Created by marc.albaladejo on 11/08/2016.
 */
({
    handle_onclick: function(component) {
        var action = component.get("v.action");
        this.executeAction(component, action, component.get('v.recordId'), component.get('v.recordIds'), component.get('v.parentId'));
    },


    openModal: function (component)  // dc todo :  This code is is not used - refactor
    {
        $A.createComponent(
            "s2cor:Modal",
            {
                "aura:id": "modalId",
                "modalComponent": "Press Me",
                "modalAttributes": "",
                "onClose": ""
            },
            function(newModal){
                if (newModal.isValid()) {
                    var divComponent = component.find("ModalPlaceholder");
                    var divBody = divComponent.get("v.body");
                    divBody.push(newModal);
                    divComponent.set("v.body", divBody);
                }
            }
        );
    }
})