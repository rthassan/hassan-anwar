/**
 * Created by daniel.nicholson on 18/08/2016.
 */
({
    doInit : function (component, event, helper) {


      var start = (component.get('v.paginationOffset') * component.get('v.paginationLimit') + 1);
      var end = Math.round(component.get('v.paginationOffset') * component.get('v.paginationLimit') + component.get('v.rowsDisplayed'));

      var total = component.get('v.rowCount');

      if (end > total) end = total;

      var paginationText = $A.get("$Label.s2cor.Pagination_Text");

      var counterText = `${start} - ${end} ${paginationText} ${total}`;

      component.set('v.counterText', counterText);
    },
    nextPage : function (component, event, helper) {
        component.set('v.paginationOffset', component.get('v.paginationOffset') +1);
    },
    previousPage : function (component, event, helper) {
        component.set('v.paginationOffset', component.get('v.paginationOffset') -1);
        component.set('v.rowsDisplayed', component.get('v.paginationLimit'));
    },
    firstPage : function (component, event, helper) {
        component.set('v.paginationOffset', 0);
    },
    lastPage : function (component, event, helper) {
        var remainder = (component.get('v.rowCount') %  component.get('v.paginationLimit'));
        var last = Math.floor(component.get('v.rowCount') / component.get('v.paginationLimit'));
        // to fix a remainder bug, we must subtract 1 from the last
        if (remainder  == 0)
        {
             last = (last - 1);
        }
        component.set('v.paginationOffset', last);
    },
    setPaginationLimit : function (component, event, helper) {
        var value = component.find("paginationLimit").get("v.value");
        if (value != undefined && value > 0) {
            component.set('v.paginationLimit', value);
            component.set('v.paginationOffset', 0);
            component.set('v.rowsDisplayed', value);

            var compEvent = component.getEvent("Event_Table_PageLimit_Changed");
            compEvent.setParams({"paginationLimit": value});
    		compEvent.fire();
        }
    }
})