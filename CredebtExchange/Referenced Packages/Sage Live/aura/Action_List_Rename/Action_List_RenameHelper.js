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
        var listViewTitle = component.get('v.listViewTitle');
        var helper = this;

        if (name == listViewTitle) {
            //No need to call the server - the name has not actually been changed
            helper.showToast(
                component,
                $A.get("$Label.s2cor.List_View_Updated"),
                "success"
            );

            return;
        }

        var listViewUID =  component.get('v.listViewUID');
        var params = {
                       "listViewUID":listViewUID,
                       "name": name,
                     }
        this.callServer(component,'c.renameListView',function(response){
            var compEvent = component.getEvent("Event_Header_Option_Selected");
            compEvent.setParam("selectedOption",name);
            compEvent.fire();

            helper.showToast(
                component,
                $A.get("$Label.s2cor.List_View_Updated"),
                "success",
                false
            );
        }, params, false, function(result) {
            helper.showToast(component,
                                 $A.get("$Label.s2cor.Error_Renaming") + ': ' + result,
                                 "error",
                                 false
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
        var originalName = component.get('v.listViewTitle');
        var titles = component.get('v.listViewsTitles');

        if (titles == null || typeof(titles) == 'undefined') {
            return true;
        }

        if (name == originalName) {
            //Name hasn't changed
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