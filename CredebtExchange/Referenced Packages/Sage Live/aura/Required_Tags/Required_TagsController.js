({
    validateAttributes :  function(component, event, helper)
    {
        helper.renderComponent(component, event, helper);
    },
    handleChangeSelect : function(component, event, helper)
    {
        helper.setTagIdsFromSelectLists(component, event, helper);
    },
    buildTagList : function(component, event, helper)
    {
        helper.buildTagListFromIds(component, event, helper);
    }
})