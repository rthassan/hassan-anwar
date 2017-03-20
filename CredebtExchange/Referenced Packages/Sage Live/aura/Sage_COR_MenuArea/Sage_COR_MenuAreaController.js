({
	doInit : function(component, event, helper,callback) {

        // The current theme needs only to be set once
        helper.callServer(component,'c.getUIThemeDescription',function(response){
            component.set('v.theme',response);
        },null,true);  
        
        var params = {
            area : component.get('v.area')
        };
        
     
        helper.callServer(component,'c.getColumnMenuCards', function(response){

            // Check if error -
            if(typeof(response.error)!='undefined' || response.error !=null)
            {
                // display the list of errors.
                 component.set('v.hasError',true);
                 component.set('v.errorList',response.error);
                 component.set('v.errorTitle',response.labels.title);
                 component.set('v.errorAccept',response.labels.accept);
                 if(typeof(response.redirect)!='undefined' || response.redirect !=null)
                 {
                      component.set('v.redirect',response.redirect);
                 }else{
                     component.set('v.redirect','/');
                 }


                 return ;
            }

            component.set('v.dtosC1',response[0]);
            component.set('v.dtosC2',response[1]);
            component.set('v.dtosC3',response[2]);
            component.set('v.dtosC4',response[3]);
            if(typeof(callback)!='undefined' && callback !=null)
            {
                callback(component);
            }
            
        },params)           
	
	},
     action : function(component, event, helper){
     if (component.get("v.theme") === "Theme3") {
           //window.parent.location.href = component.get('v.dto.actionLink');
           window.location.href = component.get('v.redirect');

           }else {
               sforce.one.navigateToURL(component.get('v.redirect'));
           }
       },
})