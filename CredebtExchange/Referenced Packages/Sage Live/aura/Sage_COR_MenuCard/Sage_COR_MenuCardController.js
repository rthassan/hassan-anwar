({
    
	navigate : function(component, event, helper) {            
        if (component.get("v.theme") === "Theme3") {

           
        	//window.parent.location.href=component.get('v.dto.titleLink'); 
			window.location.href = component.get('v.dto.titleLink'); 
            
        }
        else {                           
            sforce.one.navigateToURL(component.get('v.dto.titleLink'));
        }
	},
    action : function(component, event, helper){
         if (component.get("v.theme") === "Theme3") {
            
			//window.parent.location.href = component.get('v.dto.actionLink'); 
            window.location.href = component.get('v.dto.actionLink'); 
			                  
            }else {                           
                sforce.one.navigateToURL(component.get('v.dto.actionLink'));
            }
	}, 
    doInit : function(component, event, helper) {   
        
        var titleIcon = component.get("v.dto.titleIcon");
        if (titleIcon != null && titleIcon.indexOf('-') > -1) {
            var res = titleIcon.split('-');
            component.set("v.iconTitleType",res[0]);
            component.set("v.iconTitleName",res[1]);
        }
        else {
            component.set("v.iconTitleName",titleIcon);
        }
        
        var actionIcon = component.get("v.dto.actionIcon");
        if (actionIcon != null && actionIcon.indexOf('-') > -1) {
            var res2 = titleIcon.split('-');
            component.set("v.iconActionType",res2[0]);
            component.set("v.iconActionName",res2[1]);
        }
        else {
            component.set("v.iconActionName",actionIcon);
        }
         //component.set('v.theme','Theme3');
      //  helper.callServer(component,'c.getUIThemeDescription',function(response){
      //      component.set('v.theme',response);
      //  })        
    },
    
    moreInfoToggle : function(component, event, helper)
    {
        var card = component.find('thisCardDescription');
        if($A.util.hasClass(card,'slds-hide'))
        {
            $A.util.removeClass(card ,'slds-hide');
        }else{
             $A.util.addClass(card ,'slds-hide');
        }
     
    }
})