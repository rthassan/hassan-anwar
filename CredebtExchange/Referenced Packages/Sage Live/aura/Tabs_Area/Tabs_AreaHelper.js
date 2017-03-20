/**
 * Created by daniel.colquhoun on 10/10/2016.
 */
({
    getCompaniesAndAreaActionDTOs:function(component,event)
    {
         var areaId = component.get('v.area');
        //console.log('');
        //console.log('');
        //console.log('ATH ' + areaId + ' - Init');

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
        //var currentComponent = component; //  << make this compoent avaialbel even when out of scope;
        this.callServer(component,'c.getCompanyAndAreaMenuActionDTOs', function(response)
        {
            response = JSON.parse(JSON.stringify(response));
            var actionDTOS = response.actionDTOs;
            var companies = response.companies;
            var selectedTab = response.lastSelectedTab
            var area = '';
            if(response.domain!=null && typeof(response.domain)!='undefined')
            {
                //console.log('ATH ' + areaId + '- set domain');
                component.set('v.domain', response.domain);
            }
            if((typeof(response.areaId) != 'undefined') && response.areaId != null)
            {
                 //console.log('ATH ' + areaId + '- set area');
                 component.set('v.area',response.areaId);
                 area = response.areaId;

            }else{
               //console.log('ATH ' + areaId + '- Error 1 ** ');
            }

            var mobile = false;
            if(typeof(response.uiTheme)!='undefined' && response.uiTheme != null)
            {
                mobile = response.uiTheme === "Theme4t";
                component.set('v.mobile', mobile);
            }

             // area
            var sections = [];
            var hasReports = false;


             if((typeof(actionDTOS) != 'undefined') && actionDTOS != null)
            {
                // Make the first item active - if this isn't mobile

                // None report objects
                var noneReportDTOS = [];
                var reportDTOS = [];

                for(var key in actionDTOS)
                {
                    actionDTOS[key].id = key;
                    if(actionDTOS[key].type != 'VFPage')
                    {
                        noneReportDTOS.push(actionDTOS[key]);
                        actionDTOS[key].tabType = 'Action';
                    }else{
                        reportDTOS.push(actionDTOS[key]);
                        actionDTOS[key].tabType = 'Action';
                        hasReports = true;
                    }

                    if(selectedTab=='')
                    {
                        if(key==0 && !mobile)
                        {
                            actionDTOS[key].active = true;
                        }else{
                            actionDTOS[key].active = false;
                        }
                    }else{
                        if(selectedTab==actionDTOS[key].title && !mobile)
                        {
                                actionDTOS[key].active = true;
//                            component.set('v.currentActionDTO',actionDTOS[key]);
                            //onsole.log('ATH ' + areaId + ' set selectedTabId 1');
                            component.set('v.selectedTabId',actionDTOS[key].id);
                        }else{
                            actionDTOS[key].active = false;
                        }
                    }
                }

                if(hasReports==true)
                {
                    var reportAction = {
                         title: $A.get("$Label.s2cor.VF_Financials_Reports"),
                         id:actionDTOS.length + 1,
                         tabType:'Report',
                         target:reportDTOS
                    }
                    noneReportDTOS.push(reportAction);
                     if(selectedTab==reportAction.title && !mobile)
                    {
                        reportAction.active = true;
                        //console.log('ATH ' + areaId + ' set selectedTabId 2');
                        component.set('v.selectedTabId',reportAction.id);
                    }else{
                        reportAction.active = false;
                    }
                }

                var section =
                {
                       title: areaId,
                       actionDTOs: noneReportDTOS,
                }


                sections.push(section);
            }else{
               //console.log('No actionDTOS');
            }
            //console.log('ATH ' + areaId + '- set sections');
            component.set('v.sections',sections);
            //console.log('ATH ' + areaId + '- set hasReports');
            component.set('v.hasReports',hasReports);
            //console.log('SET ' + areaId + '- et loaded');
            component.set('v.loaded',true);

        },params);
    },
    setTabSelectionChange:function(component,actionDTO,area)
    {
        var loaded = component.get('v.loaded');
        if(loaded==true)
        {
            if(actionDTO!=null && typeof(actionDTO)!='undefined')
            {
                //console.log('ATH - ' + area + ' ' + actionDTO.title);

                var params = {"area" : area,"tabTitle":actionDTO.title}

                this.callServer(component,'c.setTabSelection', function(response)
                {
                    //console.log('Area tabs setTabSelection' + response);
                },params);
            }else{
                //console.log('Action dto null');
            }
        }

     }

})