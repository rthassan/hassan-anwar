({
	doInit : function(component, event, helper) {  

        var params = {
            area : component.get('v.area')
        };
        
        helper.callServer(component,'c.getCurrentCompany',params, function(response){
            component.set('v.companyName',response);
        });        
        var titleIcon = component.get("v.icon");
        if (titleIcon != null && titleIcon.indexOf('-') > -1) {
            var res = titleIcon.split('-');
            component.set("v.iconType",res[0]);
            component.set("v.iconName",res[1]);
        }
        else {
            component.set("v.iconName",titleIcon);
        }  
    },
})