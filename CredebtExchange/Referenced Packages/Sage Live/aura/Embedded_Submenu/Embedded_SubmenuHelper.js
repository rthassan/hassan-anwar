/**
 * Created by dancolq on 12/08/2016.
 */
({


    getCompaniesAndAreaActionDTOs:function(component,event)
    {
        var areaId = component.get('v.areaId');
          // Call the server for the area data;
          if(event)
          {
             if(typeof(event.getParam("Id"))!='undefined')
             {
                areaId = event.getParam("Id");
             }
          }
          // Call the server for the area data;
          var params = {"areaId" : areaId}
          this.callServer(component,'c.getCompanyAndAreaMenuActionDTOs', function(response)
          {
              console.log('Embedded : XHR: CompanyAndAreaMenuActionDTOs retrieved');
              var actionDTOS = response.actionDTOs;
              var companies = response.companies;
              if((typeof(response.areaId) != 'undefined') && response.areaId != null)
              {
                   component.set('v.areaId',response.areaId);
              }

               // area
              var sections = [];
              if((typeof(actionDTOS) != 'undefined') && actionDTOS != null)
              {
                  var section =
                  {
                         title: 'Sales',
                         links: actionDTOS
                  }
                  sections.push(section);
              }
              component.set('v.sections',sections);

               var companyList = [];
               var selectedCompany = '';

               if((typeof(companies) != 'undefined') && companies != null)
               {
                   companyList = companies.Items;
                   selectedCompany = companies.Selected;
               }

               component.set('v.companies',companyList);
               component.set('v.selectedCompany',selectedCompany);

          },params,true);
    },

    getCompanies:function(component)
    {
         this.callServer(component,'c.getCompanies', function(response){
            console.log('Embedded : XHR: getCompanies retrieved');
             var companyList = response.Items;
             var selectedCompany = response.Selected;

             component.set('v.companies',companyList);
             component.set('v.selectedCompany',selectedCompany);

         },null,true,function(error){
             console.log('Error ' + error);
         });


     },

    getAreaMenuActionDTOs:function(component,event)
    {
         var areaId = component.get('v.areaId');
        // Call the server for the area data;
        if(event)
        {
           areaId = event.getParam("Id");

        }
     var params = {"areaId" : areaId}
     this.callServer(component,'c.getAreaMenuActionDTOs', function(response)
     {
       var sections = [];

       var section = {
           title: 'Sales', // this is not needed
           links: response
       }
       sections.push(section);
       component.set('v.areaId',areaId);
       component.set('v.sections',sections);
     },params,true);
    },

    companyChanged:function(component,event)
    {
        // identify the element that it is now selected
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

        var areaId = component.get('v.areaId');
        var params = {"companyId" : selectedCompany.Id,"areaId": areaId}
        this.callServer(component,'c.setCompany', function(response)
        {
            console.log('Embedded : XHR: setCompany finished');
           if(typeof(response.actionDTOs) != 'undefined'  && response.actionDTOs!=null )
           {
               component.set('v.selectedCompany',selectedCompany);
               var sections = [];
               var section = {
                      links: response.actionDTOs
               }
               sections.push(section);
               component.set('v.sections',sections);

               var appEvent = component.get("c.Event_Company_Changed");
               appEvent.setParams({ "CompanyName" : selectedCompany.Name, "CompanyId":selectedCompany.Id , "OldCompanyId":oldCompany.Name , "OldCompanyId":oldCompany.Id });
               appEvent.fire();
        //                       this.getAreaMenuActionDTOs(component);
           }
           else
           {

               event.target.value = oldCompany.Name ;
               component.set('v.errorMessage','Unable to select selected company');
           }
           // testing error =
        },params,true,function(errMessage){
           console.log('Unable to update company : ' + errorMessage);
           event.target.value = oldCompany.Name ;
        });
    },
    areaIdPing:function(component,event)
    {
           var appEvent = $A.get("e.s2cor:Event_Context_Area_Ping");
           appEvent.fire();
    }

})