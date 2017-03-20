/**
 * Created by dancolq on 12/08/2016.
 */
({
    doInit:function(component,event,helper){
        // fire an area event;
        var areaId = component.get("v.Id");
        var appEvent = $A.get("e.s2cor:Event_Context_Area_Change");
        appEvent.setParams({ "Id" : areaId});
        appEvent.fire();
        // save the settings
        var params = {'areaId': areaId};
        helper.callServer(component, 'c.setAreaId',function(){
            //console.log ('AreaId: area id set ' + areaId);
        },params);
    },
    areaIdPing:function(component,event,helper)
    {
        //console.log('AreaId:  areaIdPing has been fired');
        var areaId = component.get("v.Id");
        var appEvent = $A.get("e.s2cor:Event_Context_Area_Change");
        appEvent.setParams({ "Id" : areaId});
        appEvent.fire();
    }
})