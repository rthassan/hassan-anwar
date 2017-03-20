/**
 * Created by daniel.colquhoun on 13/10/2016.
 */
({
    doInit:function(component,event,helper){
          helper.loadSelectionOptions(component,'companySelect');
    },
    updateSettings:function(component,event,helper)
    {
        helper.updateSelectionOptions(component);
    },
    changeCompany:function(component,event,helper){
       // alert('companyChanged');
        helper.changeCompanyHelper(component,event,'companySelect');
    }
})