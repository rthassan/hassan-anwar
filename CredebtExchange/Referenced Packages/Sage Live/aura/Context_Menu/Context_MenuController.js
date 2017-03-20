/**
 * Created by dancolq on 10/08/2016.
 */
({
    doInit:function(component,event,helper){

        //console.log('Submenu: doInit called');
        var areaId = component.get('v.areaId');
//        if(typeof(areaId)=='undefined' || areaId == null || areaId == "")
//        {
//            helper.areaIdPing(component);
//        }else{
         helper.getCompaniesAndAreaActionDTOs(component,event);

//        }
	},


    companyChanged:function(component,event,helper)
    {

        //console.log('Submenu:Company Changed event has been raised');
        helper.companyChanged(component,event);
    },

    areaChangedEvent:function(component,event,helper)
    {
        //console.log('Submenu: area changed event handled');
        var companies = component.get('v.companies');
        if(typeof(companies)=='undefined'|| companies == null || companies.length == 0)
        {
             helper.getCompaniesAndAreaActionDTOs(component,event);
        }
        else
        {
         helper.getAreaMenuActionDTOs(component,event);

        }
    }

})