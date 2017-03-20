/**
 * Created by dancolq on 16/08/2016.
 */
({
    doInit:function(component,event,helper)
    {
        // Calculate the url;
        // get the
        var url = component.get('v.url');
        //url += "?isdtp=p1";  // Needs to identifie as a salesforece1 app
        // add params
        var param = component.get('v.paramIdName');
        var recordId = component.get('v.recordId');
        var prefix = "/";

        if(typeof(recordId)!='undefined' && recordId != null)
        {
              if(typeof(paramIdName)!='undefined' && paramIdName!=null && paramIdName!="")
            {
                url += "&" + paramIdName + '=' + recordId;
            }else{
                 url += prefix + recordId + "?" + paramIdName + '=' + recordId;
            }
        }

        component.set('v.fullUrl',url);
    },
})