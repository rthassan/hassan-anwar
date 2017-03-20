/**
 * Created by john.hulme on 10/08/2016.
 */
({
    doInit : function(component,event,helper)
    {
        helper.calculateListLabel(component);
    },
    titleChanged : function(component,event,helper)
    {
        helper.calculateListLabel(component);
    },
    handleButtonSelect: function (component, event, helper) {
        var menuItem = event.detail.menuItem;
        var action = menuItem.get("v.value");
        helper.executeAction(component, action, null, component.get('v.recordIds'), component.getGlobalId());
        var menu = component.find("buttonMenu");
        if (Array.isArray(menu)) menu = menu[0];
        menu.set("v.visible", false);
        menu.focus();
    },
    handleSelect: function (component, event, helper) {
        //console.log('handle Select');
        var menuItem = event.detail.menuItem;
        var selectedLabel = menuItem.get("v.label");
        var menu = component.find("actionMenu");
        if (Array.isArray(menu)) menu = menu[0];
        menu.set("v.visible", false);
        menu.focus();

        var compEvent = component.getEvent("Event_Header_Option_Selected");
        compEvent.setParam("selectedOption",selectedLabel);
        compEvent.fire();



    },
    handleListSetupSelect : function (component, event, helper) {
        var menuItem = event.detail.menuItem;
        var action = menuItem.get("v.value");

        //Pass the current list of list view titles to the action
        var params = action.params;
        if ((params == null) || (typeof(params) == 'undefined')) {
            params = [];
            action.params = params;
        }

        var listParamFound = false;
        for (var i = 0; i < params.length; i++) {
             var keyName = Object.keys(params[i])[0];
             if (keyName == 'listViewsTitles') {
                listParamFound = true;
                params[i].listViewsTitles = component.get('v.titleOptions');
                break;
             }
        }

        if (!listParamFound) {
            params.push({"listViewsTitles":component.get('v.titleOptions')});
        }

        //Pass the objectDescribe to the action
        var objectDescribe = component.get('v.objectDescribe');
        if (objectDescribe != null && typeof(objectDescribe) != 'undefined') {
            var paramFound = false;
            for (var i = 0; i < params.length; i++) {
                 var keyName = Object.keys(params[i])[0];
                 if (keyName == 'objectDescribe') {
                    paramFound = true;
                    params[i].objectDescribe = objectDescribe;
                    break;
                 }
            }

            if (!paramFound) {
                params.push({"objectDescribe":objectDescribe});
            }
        }

        helper.executeAction(component, action, null, null, component.getGlobalId());
        var menu = component.find("listSetupMenu");
        if (Array.isArray(menu)) menu = menu[0];
        menu.set("v.visible", false);
        menu.focus();
    },
   handleRowSelected : function (component, event, helper) {
       var selectedRows = component.get('v.recordIds');
       var newIDs = event.getParam('IDs');
       selectedRows = selectedRows.concat(newIDs);
       //console.log("SELECTED ROWS:");
       //console.log(selectedRows);
       component.set('v.recordIds', selectedRows);
   },
   handleRowUnselected : function (component, event, helper) {
       var selectedRows = component.get('v.recordIds');
       var newIDs = event.getParam('IDs');

       for(id in newIDs) {
           var index = selectedRows.indexOf(newIDs[id]);
           if (index > -1) {
               selectedRows.splice(index, 1);
           }
       }
       //console.log("SELECTED ROWS:");
       //console.log(selectedRows);
       component.set('v.recordIds', selectedRows);
   },
   handleRowClearAll : function (component, event, helper) {
          var selectedRows = [];
          //console.log("SELECTED ROWS:");
          //console.log(selectedRows);
          component.set('v.recordIds', selectedRows);
      },
   doneRendering: function(component, event, helper) {
       if(component.get("v.isDoneRendering")){
          return;
       }

       var elements = component.getElements();
       if(typeof(elements)=='undefined' || elements == null) {
           return;
       }

       var buttons = component.get('v.buttons');
       if(typeof(buttons)=='undefined' || buttons == null || buttons.length < 1) {
           return;
       }

       var element = elements[0];
       if(typeof(element)=='undefined' || element == null) {
           return;
       }

       component.set("v.isDoneRendering", true);

       var clientWidth = element.clientWidth;
       //console.log('CLIENT WIDTH ' + clientWidth)
       if (clientWidth > 0) {
           //The buttons take up half of the header
           clientWidth = clientWidth / 2;
           var buttonCount = Math.min(buttons.length,component.get('v.buttonsLimit'));
           //console.debug('buttons ' + buttonCount);
           var buttonWidth = clientWidth / buttonCount;

           //75 is a "magic number" - which results in a nice display in small screens like iPhone.  A more
           //accurate calculation would take into consideration the text to display in each button - since that
           //takes into consideration the true size of each button - but that is tricky since the size calc would
           //also need to take into consideration the font being used on the device.
           while (buttonWidth < 75 && buttonCount > 1) {
               buttonCount--;
               buttonWidth = clientWidth / buttonCount;
           }

           //console.log('CALCULATED BUTTON COUNT ' + buttonCount);
           component.set('v.buttonsLimit', buttonCount);
       }
   },
   refresh: function(component, event, helper) {

       try{
           var appEvent = $A.get("e.s2cor:Event_Refresh_Data_Tables");
               appEvent.setParam('innerListViewId',component.get('v.innerListViewId'));
               appEvent.fire();
       }
       catch(err)
       {
           //console.log('Error firing Event_Refresh_Data_Tables ' + err.message);
       }
    },
    handleHeaderSelect: function(component, event, helper) {
        //If this is mobile then toggle the list mode - show results or show lists
        var mobile = component.get("v.mobile");
        if (!mobile) return;
        var mode = component.get("v.viewResultsMode");

        var compEvent = component.getEvent("Event_Header_View_Mode_Changed");
        compEvent.setParam("viewResultsMode",!mode);
        compEvent.fire();
    }
})