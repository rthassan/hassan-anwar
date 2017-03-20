/**
 * Created by ansja02 on 12/6/16.
 */
({
    doInit: function(component, event, helper) {
        helper.initBind(component,helper);
        helper.toggleAccept(component, false);

        var schemaParams = {
            objectName: component.get('v.SObjectType')
        };
        if (component.get('v.objectDescribe') == null || component.get('v.objectDescribe') == undefined) {
            helper.callServer(component,'c.getFieldsSchemaMap',function(response) {
//                response = JSON.parse(response); // response should be a JSON string and not a DTO - server should return a string.
                helper.processFieldsSchema(component, response);
            },schemaParams,true)
        } else {
            helper.processFieldsSchema(component, JSON.parse(component.get('v.objectDescribe')));
        }
    },
    handleAdd: function(component, event, helper) {
        var availableFieldsList = component.get('v.availableFields');
        var selectedFieldsList = component.get('v.selectedFields');
        var selected = component.find("availableFields").get("v.value");
        var selectedList = selected.split(";");

        helper.moveField(availableFieldsList, selectedFieldsList, selectedList);

        component.set('v.selectedFields', selectedFieldsList);
        component.set('v.availableFields', availableFieldsList);
        helper.toggleAccept(component, selectedFieldsList.length > 0);
     },
    handleRemove: function(component, event, helper) {
        var availableFieldsList = component.get('v.availableFields');
        var selectedFieldsList = component.get('v.selectedFields');
        var selected = component.find("selectedFields").get("v.value");
        var selectedList = selected.split(";");

        helper.moveField(selectedFieldsList, availableFieldsList, selectedList);

        //Sort the available fields list
        availableFieldsList.sort(
            function(a, b){
                if (a.label < b.label)
                    return -1;
                if (a.label > b.label)
                    return 1;
                return 0;
            }
        );

        component.set('v.selectedFields', selectedFieldsList);
        component.set('v.availableFields', availableFieldsList);
        helper.toggleAccept(component, selectedFieldsList.length > 0);
    },
    handleUp: function(component, event, helper) {
        helper.changeFieldOrder(component, true);
    },
    handleDown: function(component, event, helper) {
        helper.changeFieldOrder(component, false);
    }
})