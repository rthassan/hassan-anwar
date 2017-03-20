/**
 * Created by daniel.colquhoun on 13/10/2016.
 */
({
        loadSelectionOptions: function (component, selectionId ) {
            this.callServer(component,'c.getReportSettingsFinancials',function(response){
                     var selectedCompany = response.Selected;
                     var companies = response.Items;
                     var companyList = [];

                     if((typeof(companies) != 'undefined') && companies != null)
                     {
                         component.set('v.companies',companies);
                         component.set('v.selectedCompany',selectedCompany);
                         component.set('v.financialYear', response.financialYear);
                         component.set('v.financialPeriod', response.financialPeriod);
                         component.set('v.retroDate', response.retroDate);
                     }
                });
        },
        changeCompanyHelper: function(component,event, selectionId){

            var selectedCompanyItem = event.target.value;
            var companies = component.get('v.companies');
            var oldCompany = component.get('v.selectedCompany');
            var selectedCompany = {};
            for(var i=0; i < companies.length;i++)
            {
               var company = companies[i];
               if(company.Name == selectedCompanyItem)
               {
                   selectedCompany = company;
                   break;
               }
            }
             component.set('v.selectedCompany',selectedCompany);
            var params = {"companyId" : selectedCompany.Id,"areaId": ''}
            this.callServer(component,'c.setCompany', function(response)
            {
               //alert('company changed');
               // testing error =
            },params,true,function(errMessage){
               //console.log('Unable to update company : ' + errorMessage);
               event.target.value = oldCompany.Name ;
            });


//
//            var cmp = component.find(selectionId);
//            if(cmp != null && typeof(cmp)!=='undefined')
//            {
//                var value = cmp.get('v.value');
////                component.set('v.selectedCompany',value);
//                //string companyId,string areaId
//                var selectedCompany =  component.get('v.selectedCompany');
//                var params = {'companyId':selectedCompany.Id,'areaId':''}
//                this.callServer(component,'c.setCompany',function(response){
//                    alert('Company Saved');
//                },params);
//            }
        },
        updateSelectionOptions:function(component) {

            var financialYear = component.get('v.financialYear');
            var financialPeriod = component.get('v.financialPeriod');
            var retroDate = component.get('v.retroDate');
            //console.log(' Retro date ' + retroDate);

            var params = {
                'financialYear':financialYear,
                'financialPeriod':financialPeriod,
                'retroDate':retroDate
            }
            var wrappedArgs = {
                args: params
            }
            this.callServer(component,'c.updateReportSettingsFinancials',function(response){
               // alert(response);
            },params);

        }

})