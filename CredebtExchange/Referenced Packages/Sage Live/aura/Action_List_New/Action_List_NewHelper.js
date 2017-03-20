/**
 Copyright: © Sage Global Services Limited 2016. All rights reserved.
 */
({
    onAccept : function(component, event) {
        this.toggleAccept(component, false);

        if (!this.validateForm(component)) {
            this.toggleAccept(component, true);
            return;
        }

        var name = component.get('v.name');
        var objectType = component.get('v.SObjectType');
        var uid = component.get('v.UID');
        var listViewUID =  component.get('v.listViewUID');
        var private = component.get('v.privateList');
        var helper = this;
        var params = {
                       "sObjectType" : objectType,
                       "sObjectUID" : uid,
                       "listViewUID":listViewUID,
                       "name": name,
                       "privateList":private.toString()
                     }
        this.callServer(component,'c.createNewListView',function(response){
            var compEvent = component.getEvent("Event_Header_Option_Selected");
            compEvent.setParam("selectedOption",name);
            compEvent.fire();
            helper.closeModal(false);
        }, params, false, function(result) {
            helper.showToast(component,
                                 $A.get("$Label.s2cor.Error_Saving") + ': ' + result,
                                 "error", false
                             );
        });
    },
    clearError: function(component) {
        var formElement = component.find('name-form');
        var errorMessageElement = component.find('error-message');
        $A.util.addClass(errorMessageElement, "slds-hide");
        $A.util.removeClass(formElement, "slds-has-error");
    },
    showError: function(component) {
        var formElement = component.find('name-form');
        var errorMessageElement = component.find('error-message');
        $A.util.removeClass(errorMessageElement, "slds-hide");
        $A.util.addClass(formElement, "slds-has-error");
    },
    validateForm: function(component) {
        this.clearError(component);

        var nameElement = component.find('name');
        var validity = nameElement.get('v.validity');
        if ((validity != null) && validity.valid) {
            return this.checkName(component);
        } else {
            if (validity == null) {
                var newValidity = {valid: false,valueMissing: true};
                nameElement.set('v.validity', newValidity);
            }
            return false;
        }
    },
    checkName: function(component) {
        var name = component.get('v.name');
        var titles = component.get('v.listViewsTitles');

        if (titles == null || typeof(titles) == 'undefined') {
            return true;
        }

        var nameFound = false;
        for (var i = 0; i < titles.length; i++) {
            nameFound = name.toUpperCase() == titles[i].toUpperCase();
            if (nameFound) {
                break;
            }
        }

        if (nameFound) {
            this.showError(component);
        }

        return !nameFound;
    }
})