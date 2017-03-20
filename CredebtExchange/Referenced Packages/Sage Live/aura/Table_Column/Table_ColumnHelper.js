/**
 * Created by ansja02 on 11/25/16.
 */
({
    calculateColumnStyle: function(component) {
        var column = component.get('v.column');
        if (column == null || typeof(column) == 'undefined') {
            component.set('v.columnStyle', '');
            return;
        }
        var width = column.width;
        if (width == null || typeof(width) == 'undefined') {
            width = 0;
        }

        var style = "";
        if (width > 0) {
        	style = "width:" + width + "px";
        }
        component.set('v.columnStyle', style);
    }
})