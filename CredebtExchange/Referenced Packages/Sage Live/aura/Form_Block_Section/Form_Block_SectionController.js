/**
 * Created by dancolq on 23/08/2016.
 */
({
    doInit:function(component,event,helper)
    {
        var collapsed = component.get('v.collapsed');
        if(collapsed == true)
        {
            var content = component.find('content');
            if(content!=null)
            {
                $A.util.toggleClass(content, "slds-hide");
            }
        }
        var gridStyle = component.get('v.gridStyle');
        helper.applyGridStyles(component,event,gridStyle);
    },
    changeGridStyle:function(component,event,helper)
    {
        var gridStyle = component.get('v.gridStyle');
        helper.applyGridStyles(component,event,gridStyle);
    },

    toggleHide:function(component,event,helper)
    {
        console.log('TOGGLE CLICKED');
        var content = component.find('content');
        if(content!=null)
        {
           $A.util.toggleClass(content, "slds-hide");
        }
    },
    toggleGridStyles:function(component,event,helper)
    {
        var list = helper.cycleList(helper.styleList());
        var gridStyleIndex = component.get('v.gridStyleIndex');
        helper.applyGridStyles(component,event,list[gridStyleIndex].next.object);
        event.preventDefault();
    }
// onclick="{!c.toggleHide}"
})