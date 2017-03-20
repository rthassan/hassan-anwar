({
    doInit :  function(component, event, helper)
    {
        helper.initBind(component,helper);
    },
    handleChangeFileName  : function(component, event, helper)
    {
        var header = component.get("v.header");
        var rows = component.get("v.rows");
        var input = component.find("fileNameInput");
        if (input.get("v.validity").valid && header.length > 0 && rows.length > 0)
        {
            helper.toggleAccept(component, true);
        }
        else
        {
            helper.toggleAccept(component, false);
        }
    }

})