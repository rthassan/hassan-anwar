({
    doInit:function(component,event,helper){
        helper.getCompanies(component);
        helper.initBind(component,helper);
	},
	changeCompany:function(component, event, helper) {
        helper.changeCompany(component, event);
    }
})