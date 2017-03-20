/**
 * Created by john.hulme on 16/08/2016.
 */
({
    calcCardClass : function(component) {
        var displayWhenEmpty = component.get('v.displayWhenEmpty');
        var rowCount = component.get('v.rowCount');
        var rowCountDefined = (rowCount != null && typeof(rowCount) != 'undefined');

        if (displayWhenEmpty || (rowCountDefined && rowCount > 0)) {
            component.set('v.cardClass', 'slds-card');
            component.set('v.cardBodyClass', 'slds-card__body');
        } else {
            component.set('v.cardClass', '');
            component.set('v.cardBodyClass', '');
        }
    }
})