/**
 * Created by marc.albaladejo on 10/08/2016.
 */
({
    doInit:function(component,event,helper) {
        var mobile = component.get('v.mobile');
        if (mobile == false) {
            return;
        }

        var actions = component.get('v.actions');
        if ((actions != null) && (typeof(actions) != 'undefined')) {
            for (var i = 0; i < actions.length; i++) {
                var action = actions[i];

                var params = action.params;
                if ((params == null) || (typeof(params) == 'undefined')) {
                    params = [];
                    action.params = params;
                }
                params.push({"mobile":true});
            }
            component.set("v.actions", actions);
        }
    },
    handleButtonSelect: function (component, event, helper) {

        var menuItem = event.detail.menuItem;
        var action = menuItem.get("v.value");
        var recordId = null;
        var element = event.detail.menuItem.getElements()[0];

        for (var i=0; i < 7; i++) {
             if (recordId != null && typeof(recordId) != 'undefined') break;
             element = element.parentNode;
             recordId = element.attributes.getNamedItem('data-id');
        }
        helper.executeAction(component, action, recordId.value, null, component.getGlobalId());
    },

    donRendering : function (component, event, helper)
    {
        var tableChanging = component.get('v.tableChanging');
        if(tableChanging==true){
            var idList =  component.get('v.selectedRows');
            if(idList!==null)
            {
                if(idList.length > 0 )
                {
                   var fastSearchString = idList.join('#');
                   fastSearchString = '#' + fastSearchString + '#';
                   var checkboxes = component.find('multiselectCheckbox');
                   if(checkboxes!=null && typeof(checkboxes)!='undefined')
                   {
                        if(checkboxes.length==undefined)
                        {
                            if (fastSearchString.indexOf('#' + checkboxes.getElement().id + '#')>-1) {
                                checkboxes.getElement().checked = true;
                            }
                        }else{
                             for (var i = 0; i < checkboxes.length; i++){

                                if(typeof(checkboxes[i].getElement().id)!='undefined' && checkboxes[i].getElement().id != null )
                                {
                                   if (fastSearchString.indexOf('#' + checkboxes[i].getElement().id + '#')>-1) {
                                       checkboxes[i].getElement().checked = true;
                                   }
                                }
                           }
                        }

                   }
                }
            }
            component.set('v.tableChanging',false);
        }



    },

    tableChanging: function (component, event, helper){
        component.set('v.tableChanging',true);
    },

    executeAction: function (component, event, helper) {
        alert(event.action);
        helper.executeAction(component, event.action);
    },

    /*
     * Toggle all checkboxes named 'options' when 'selectAll' is checked/unchecked
     */
    selectAll: function (component, event, helper) {

        var checkboxes = component.find('multiselectCheckbox');
        var multiselectCheckboxAll = component.find('multiselectCheckboxAll');
        var checked = multiselectCheckboxAll.getElement().checked;
        var idList = [];
        if(checkboxes!= null && checkboxes != undefined)
        {
            if(checkboxes.length==undefined)
            {
                checkboxes.getElement().checked = checked;
                idList.push(checkboxes.getElement().id);
            }else{
                for (var i = 0; i < checkboxes.length; i++){
                    checkboxes[i].getElement().checked = checked;
                    if (checkboxes[i].getElement().id !== undefined) {
                        idList.push(checkboxes[i].getElement().id);
                    }
                }
            }
            component.set('v.selectedRows', idList);
        }
    },
    showMore : function(component) {
        var target = component.find('showMore');
        $A.util.toggleClass(target, 'slds-is-open');
    },
    /*
     * Fire select event for single checkbox
     */
    selectEvent : function (component, event, helper) {
        var id = event.target.id;
        var checked = event.target.checked;
        if (id != null) {
            helper.fireSelectEvent(component, [id], checked);
        }
    },
    /*
     * Handler for clicking the td where the checkbox resides - this will fire the select event for single checkbox
     */
    selectRowClickedEvent : function (component, event, helper) {

        var checkboxes = component.find('multiselectCheckbox');
        var idList = [];
         if(checkboxes!= null && checkboxes != undefined){
            if(checkboxes.length==undefined){
                // Only one found
               if(checkboxes.getElement().checked == true){
                 if (checkboxes.getElement().id !== undefined) {
                     idList.push(checkboxes.getElement().id);
                 }
               }
            } else {
                for (var i = 0; i < checkboxes.length; i++){
                    if(checkboxes[i].getElement().checked == true) {
                      if (checkboxes[i].getElement().id !== undefined) {
                          idList.push(checkboxes[i].getElement().id);
                      }
                    }
                }
            }
            component.set('v.selectedRows', idList);
        }
    },

    getActions : function (component, event, helper){
        var params = {};
        var data_id = event.target.attributes.getNamedItem('data-id');
        var element = event.target;
        var found = false;
        if (data_id != null && typeof(data_id) != 'undefined') {
            params = { "recordId": data_id.value };
        } else {
            for (var i=0; i < 6; i++) {
                 element = element.parentNode;
                 data_id = element.attributes.getNamedItem('data-id');
                 if (data_id != null && typeof(data_id) != 'undefined') {
                     params = { "recordId": data_id.value };
                     found = true;
                     break;
                 }
            }
        }
        if (component.get('v.actions').length == 0) {
            helper.callServer(component,'c.getActionsById',function(response) {
                       component.set('v.actions', response);
                        var menu = component.find(data_id.value);
                               if (menu) menu.set("v.visible", true);
                    }, params);
        } else {
            var menu = component.find(data_id.value);
            if (menu) menu.set("v.visible", true);
        }

        return false;
    },
    handleResizingEvent : function(component, event, helper) {
    	var column = event.getParam("column");
        var startX = event.getParam("resizeStartX");
        var startWidth = event.getParam("resizeStartWidth");

        component.set('v.colResize', column);
        component.set('v.colResizingStartX', startX);
        component.set('v.colResizingStartWidth', startWidth);
        component.set('v.colBeingResized', true);
    },
    handleMouseMove : function(component, event, helper) {
        var resizing = component.get('v.colBeingResized');
        if (!resizing) return;

        if (event.which == 0) {
        	component.set('v.colBeingResized', false);
            return;
        }

        var column = component.get('v.colResize');
        var startWidth = component.get('v.colResizingStartWidth');
        var startX = component.get('v.colResizingStartX');
        var newWidth = startWidth + (event.pageX - startX);
        var table = component.get('v.table');
        var columns = table.columns;

        //Find column
        for (var i = 0; i < columns.length; i++) {
            if (columns[i].name == column.name) {
                columns[i].width = newWidth;
                break;
            }
        }

        component.set('v.table', table);
 	},
	handleMouseUp : function(component, event, helper) {
	    var resizing = component.get('v.colBeingResized');
        if (!resizing) return;

        var column = component.get('v.colResize');
        component.set('v.colBeingResized', false);

        if (column != null && typeof(column) != 'undefined') {
	        var compEvent = component.getEvent("Event_Table_Column_Resized");
            compEvent.setParams({"column": column});
            compEvent.fire();
        }
	}
})