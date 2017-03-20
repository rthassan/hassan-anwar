({
    doInit : function(component,event,helper)
    {
        helper.init(component);
    },
    handleHeaderOptionSelected : function(component,event,helper)
    {
        if (component.get('v.listView') != event.getParam('selectedOption'))
        {
            component.set('v.title', '');
        }
    },
    handleHeaderViewModeChanged : function(component, event, helper)
    {
        var mode = event.getParam('viewResultsMode');
        component.set('v.viewResultsMode', mode);
    },
    handleRowSelected : function (component, event, helper) {
        var selectedRows = component.get('v.selectedRows');
        var newIDs = event.getParam('IDs');
        selectedRows = selectedRows.concat(newIDs);
        component.set('v.selectedRows', selectedRows);
    },
    handleRowUnselected : function (component, event, helper) {
        var selectedRows = component.get('v.selectedRows');
        var newIDs = event.getParam('IDs');

        for(id in newIDs) {
            var index = selectedRows.indexOf(newIDs[id]);
            if (index > -1) {
                selectedRows.splice(index, 1);
            }
        }
        component.set('v.selectedRows', selectedRows);
    },
    handleCompanyChanged:function(component,event,helper)
    {
        // the company would have already been saved so just re-load the breadcrumbs;
        helper.getBreadcrumbsNoCache(component);
    },
    handleTableColumnSorted: function(component, event, helper) {
        helper.handleChangeSortColumn(component, event);
    },
    handleTableColumnResized: function(component, event, helper) {
        helper.handleChangeColumnWidth(component, event);
    },
    handlePageLimitChanged : function (component, event, helper) {
        helper.handleChangePageLimit(component, event);
    }
})