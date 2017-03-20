({
    doInit : function(component,event,helper)
    {
        helper.calcCardClass(component);

        //DEPRECATED
         /*var params = {
                    recordId: component.get("v.recordId")
                };
                helper.callServer(component,'c.getRecordInfo', function(response) {

                    var parentDimensionsToShowFor = component.get('v.dimensions');

                    if (parentDimensionsToShowFor != null && parentDimensionsToShowFor != undefined)
                    {
                        console.log('RESPONSE.DIMENSION: ' + response.dimension);
                        console.log('parentDimensionsToShowFor: ' + parentDimensionsToShowFor);
                        console.log('parentDimensionsToShowFor.includes(response.dimension): ' + parentDimensionsToShowFor.includes(response.dimension));
                        component.set('v.showForThisParent',parentDimensionsToShowFor.includes(response.dimension));
                    }
                    else
                    {
                        component.set('v.showForThisParent',true);
                    }
                }, params)*/
    },
    calcCardClass : function(component, event, helper) {
        helper.calcCardClass(component);
    }
})