/**
 * Created by ansja02 on 11/21/16.
 */
({
    doInit: function(component, event, helper) {
        helper.calculateColumnStyle(component);
    },
    handleSortClick: function(component, event, helper) {
        var column = component.get('v.column');
        if (column.isSortable) {
            if (column.isSortedAsc) {
                column.isSortedAsc = false;
                column.isSortedDesc = true;
            } else if (column.isSortedDesc) {
                column.isSortedDesc = false;
                column.isSortedAsc = true;
            } else {
                column.isSortedAsc = true;
                column.isSortedDesc = false;
            }

            var compEvent = component.getEvent("Event_Table_Column_Sorted");
            compEvent.setParam("column",column);
            compEvent.fire();
        }
    },
	handleMouseDown : function(component, event, helper) {
        var column = component.get('v.column');
        if (column == null || typeof(column) == 'undefined') {
            return;
        }

        var tableHeader = component.find('tableHeader');
        var element = tableHeader.getElement();
        var width = element.clientWidth;
        var startX = event.pageX;

        var compEvent = component.getEvent("Event_Table_Column_Resizing");
        compEvent.setParams({"column": column,
            				 "resizeStartX" : startX,
                             "resizeStartWidth": width});
		compEvent.fire();
	},
    handleColumnChange: function(component, event, helper) {
        helper.calculateColumnStyle(component);
    }
})