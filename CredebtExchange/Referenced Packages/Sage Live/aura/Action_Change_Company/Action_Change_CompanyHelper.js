/**
 * Created by ansja02 on 10/13/16.
 */
({
    getCompanies:function(component)
    {
        this.callServer(component,'c.getCompanies', function(response){
            var companyList = response.Items;
            var selectedCompany = response.Selected;
            component.set('v.selectedCompanyId',selectedCompany.Id);
            component.set('v.selectedCompany',selectedCompany);
            component.set('v.companies',companyList);
            if(response.uiTheme != null && typeof(response.uiTheme)!='undefined')
            {
                component.set('v.mobile', response.uiTheme === "Theme4t");
            }
        },null,null,function(error){
            console.log('Error ' + error);
        });
    },

    changeCompany:function(component, event)
    {
        var selectCompanies = component.find('selectCompanies'); // Fix lightning locker
        if(selectCompanies)
        {
           var selectedCompanyId = selectCompanies.get('v.value');
           component.set('v.selectedCompanyId', selectedCompanyId );
           var companies =  component.get('v.companies');

           var selectedCompany = null;
           for(var key in companies)
           {
               if(companies[key].Id == selectedCompanyId)
               {
                    component.set('v.selectedCompany', companies[key]);
                    return;
               }
           }
       }
    },

    onAccept:function(component,event)
    {
        var selectedCompany = component.get('v.selectedCompany');
        var selectedCompanyId = component.get('v.selectedCompanyId');

        if(typeof(selectedCompanyId) == 'undefined'  || selectedCompanyId == null ) {
            this.onCancel(component);
            return;
        }

        var params = {"companyId" : selectedCompanyId,"areaId":null}

        this.callServer(component,'c.setCompany', function(response)
        {
            if (response == null)
            {
                this.showToast(component,$A.get("$Label.s2cor.Company_Changed"), "success");

                var refreshView = $A.get('e.force:refreshView');
                if (refreshView != null && typeof(refreshView) != 'undefined') {
                    refreshView.fire();
                }

                var dismissActionPanel = $A.get("e.force:closeQuickAction");
                if (dismissActionPanel != null && typeof(dismissActionPanel) != 'undefined') {
                    dismissActionPanel.fire();
                }
            }
            else
            {
                this.showToast(component,$A.get("$Label.s2cor.Error_Changing_Company"), "error");
                this.onCancel(); // Closes
            }
        },params,null,function(errMessage){
                this.showToast(component,$A.get("$Label.s2cor.Error_Changing_Company"), "error");
                this.onCancel(); // Closes
         });
    },

    onCancel:function(component)
    {
        var dismissActionPanel = $A.get("e.force:closeQuickAction");
        if (dismissActionPanel != null && typeof(dismissActionPanel) != 'undefined') {
            dismissActionPanel.fire();
        }

        var evt = $A.get("e.s2cor:Event_Close_Model_On_Cancel");
        if (evt != null && typeof(evt) != 'undefined') {
            evt.fire();
        }
    },

})