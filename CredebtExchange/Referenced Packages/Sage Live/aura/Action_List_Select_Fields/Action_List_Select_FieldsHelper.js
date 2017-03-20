/**
 * Created by ansja02 on 12/6/16.
 */
({
    onAccept : function(component, event) {
        this.toggleAccept(component, false);

        var selectedFieldsList = component.get('v.selectedFields');
        if (selectedFieldsList.length == 0) {
            //Shouldn't happen - because we are disabling the save button if this list is empty
            return;
        }

        var fields = '';
        for (var i = 0; i < selectedFieldsList.length; i++) {
            if (fields.length > 0) {
                fields = fields + ', ';
            }
            fields = fields + selectedFieldsList[i].name;
        }

        var helper = this;
        var listViewUID =  component.get('v.listViewUID');
        var params = {
                       "listViewUID":listViewUID,
                       "fields": fields,
                     }
        this.callServer(component,'c.changeListViewFields',function(response){
            var compEvent = component.getEvent("Event_List_View_Fields_Changed");
            compEvent.setParam("listViewUID", listViewUID);
            compEvent.fire();

            helper.showToast(
                component,
                $A.get("$Label.s2cor.List_View_Updated"),
                "success",
                false
            );
        }, params, false, function(result) {
            helper.showToast(component,
                                 $A.get("$Label.s2cor.Error_Saving") + ': ' + result,
                                 "error",
                                 false
                             );
        });
    },
    processFieldsSchema: function (component, fieldsSchemaMap) {
        var listViewFields = component.get('v.listViewFields');
        var availableFieldsList = [];
        var selectedFieldsList = [];
        var fieldsDescribe = fieldsSchemaMap.fieldsDescribe;

        if (Object.keys(fieldsDescribe).length > 0) {
            for (var key in fieldsDescribe) {
                var field = fieldsDescribe[key];
                if (field.isAccessible) {
                    availableFieldsList.push(field);
                }
            }

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
        }

        if (listViewFields != null && typeof(listViewFields) != 'undefined') {
            var fields = listViewFields.split(",");
            for (var i = 0; i < fields.length; i++) {
                var field = null;
                var fieldIndex = 0;
                var fieldName = fields[i].trim();
                for (var j = 0; j < availableFieldsList.length; j++) {
                    var temp = availableFieldsList[j];
                    if (temp.name == fieldName) {
                        field = temp;
                        fieldIndex = j;
                        break;
                    }
                }

                if (field != null) {
                    selectedFieldsList.push(field);
                    availableFieldsList.splice(fieldIndex, 1);
                }
            }
        }

        this.toggleAccept(component, selectedFieldsList.length > 0);
        component.set('v.availableFields', availableFieldsList);
        component.set('v.selectedFields', selectedFieldsList);
        component.set("v.loading", false);
        component.set('v.loaded',true);
    },
    moveField: function(fromList, toList, selectedList) {
        for (var i = 0; i < selectedList.length; i++) {
            var fieldValue = selectedList[i];
            var field = null;
            var fieldIndex = 0;
            for (var j = 0; j < fromList.length; j++) {
                var temp = fromList[j];
                if (temp.name == fieldValue) {
                    field = temp;
                    fieldIndex = j;
                    break;
                }
            }

            if (field != null) {
                toList.push(field);
                fromList.splice(fieldIndex, 1);
            }
        }
    },
    changeFieldOrder: function(component, moveUp) {
        var selectedFieldsList = component.get('v.selectedFields');
        var selected = component.find("selectedFields").get("v.value");
        var selectedList = selected.split(";");

        if (selectedList.length > 0) {
            var index = moveUp ? 0 : selectedList.length - 1;
            var endIndex = moveUp ? selectedList.length : -1;

            do {
                var fieldValue = selectedList[index];
                var field = null;
                var fieldIndex = 0;
                for (var j = 0; j < selectedFieldsList.length; j++) {
                    var temp = selectedFieldsList[j];
                    if (temp.name == fieldValue) {
                        field = temp;
                        fieldIndex = j;
                        break;
                    }
                }

                var move = (field != null) && ((moveUp && (fieldIndex > 0)) || (!moveUp && (fieldIndex < selectedFieldsList.length)));
                if (move && selectedList.length > 1) {
                    //Make sure that multiple selected fields move within the list - and don't change position
                    if (moveUp && index > 0) {
                        move = fieldIndex > index;
                    }
                    if (!moveUp && index < (selectedList.length - 1)) {
                        move = (selectedFieldsList.length - fieldIndex) > selectedList.length;
                    }
                }

                if (move) {
                    selectedFieldsList.splice(fieldIndex, 1);
                    if (moveUp) {
                        selectedFieldsList.splice(fieldIndex - 1, 0, field);
                    } else {
                        selectedFieldsList.splice(fieldIndex + 1, 0, field);
                    }
                }

                index = moveUp ? index + 1 : index - 1;
            } while ( index != endIndex)

            component.set('v.selectedFields', selectedFieldsList);
        }
     },
})