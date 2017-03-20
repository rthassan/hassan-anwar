/**
 * Created by daniel.colquhoun on 10/10/2016.
 */
({

        doInit:function(component,event,helper){
             helper.getCompaniesAndAreaActionDTOs(component,event);
        },
        tabSelected:function(component,event,helper)
        {
            //alert('Slected Tab');
            var area = component.get('v.area');
            //console.log('');
            //console.log('ATH ' + area + ' - tabSelected called');
            // Get the selected tab index

            var loaded = component.get('v.loaded');

            if(loaded==false){
                 //console.log('ATH ' + loaded + ' - loaded false');
                 return;
            }

            var tabIndex=-1;
            var tab = event.detail.selectedTab;
            if(tab!=null && typeof(tab)!='undefined')
            {
               tabIndex = tab.get('v.id');
            }else{
               tabIndex = event.detail.target.get('v.id');
            }
            // Reset the active tabs
            if(tabIndex!=null && typeof(tabIndex) != 'undefined')
            {
                //console.log('ATH  ' + area + ' - tabSelected Reset the active tabs');
                var sections = component.get('v.sections');
                var actionDTOs = sections[0].actionDTOs;  // These are action actionDTO's
                for(var key in actionDTOs)
                {
                    if(actionDTOs[key].id==tabIndex)
                    {
                        actionDTOs[key].active = true;
                        //console.log('ATH  ' + area + ' - tabSelected Reset selectedTabId');
//                        component.set('v.selectedTabId',actionDTOs[key].id);
                        var title = component.get('v.area');
                        helper.setTabSelectionChange(component,actionDTOs[key],title);
                    }else{
                        actionDTOs[key].active = false;
                    }
                }
                component.set('v.sections',sections);

            }else{
                //console.log('ATH    ' + area + ' Unable to retrieve the tab index');
            }
        }


})