/**
 * Created by daniel.colquhoun on 16/11/2016.
 */
({
    onfocus:function(component,event,helper)
    {
        var objName = component.get('v.objectName');
        var params = {
            objectName :objName
        }

        helper.callServer(component,'c.GetRecentObjects',function(response){

            var data = JSON.parse(response);

            for(key in data.sobjects)
            {
                data.sobjects[key]['schema'] = data.schema;
            }
            component.set('v.loaded',true);
            component.set('v.sobjects',data.sobjects);

            $A.util.addClass(component,'slds-is-open');
        },params);


    },

    onblur:function(component,event,helper)
    {

        $A.util.removeClass(component,'slds-is-open');

    }
})