/**
 * Created by daniel.colquhoun on 10/10/2016.
 */
({

         doInit:function(component,event,helper){
            // get actionDTO
            var area = component.get('v.area');
            var actionDTO = component.get('v.actionDTO');
            var title = 'NotSet';
            if(actionDTO !=null)
            {
                title=actionDTO.title;
            }

            if(actionDTO.active==true)
            {
                $A.util.removeClass(component,' slds-hide');
                $A.util.addClass(component,' slds-show');
                //console.log('ATP - ' + title + ' Set hasbeenActive');
                component.set('v.hasbeenActive', true);
            }else{

                $A.util.removeClass(component,' slds-show');
                $A.util.addClass(component,' slds-hide');
            }

            if(actionDTO.tabType!='Report')
            {

               if ((actionDTO.type == 'VFPage' || (actionDTO.type == 'LightningEvent' && actionDTO.target=='e.force:navigateToURL') )&& actionDTO.target !== undefined) {
                   var visualforceNavigation = '';
                   if(actionDTO.target=='e.force:navigateToURL')
                   {

                      if (actionDTO.params !== undefined)
                      {

                          var paramList = [];
                          // iterate through attributes and set params on visualforce navigation
                          for (var i = 0; i < actionDTO.params.length; i++) {
                              var param = actionDTO.params[i];
                              if(param['url']!=null && typeof(param['url'])!='undefined')
                              {
                                  visualforceNavigation = param['url'] +  '?isdtp=p1';
                                  var domain = component.get('v.domain');
                                  if (domain != undefined) visualforceNavigation += '&sfdcIFrameOrigin='+ domain.url +'.lightning.force.com';
                              }
                          }
                      }
                    //console.log('ATP - ' + title + ' Set url');
                    component.set('v.url', visualforceNavigation);
                   //console.log('ATP - ' + title + ' Set type');
                    component.set('v.type','VFPage');

                   }else{
                        visualforceNavigation = actionDTO.target;
                        if (actionDTO.params !== undefined)
                        {

                           var paramList = [];
                           // iterate through attributes and set params on visualforce navigation
                           for (var i = 0; i < actionDTO.params.length; i++) {
                               var param = actionDTO.params[i];
                               for(var k in param) {
                                   paramList.push(k +'='+ helper.substituteActionParam(component, param[k]));
                               }
                           }
                           visualforceNavigation += '?' + paramList.join('&');
                        }
                        else if ((component.get('v.recordId') !== undefined && component.get('v.recordId') !== '')) {
                           var paramList = [];
                           paramList.push('id='+component.get('v.recordId'));
                           visualforceNavigation = '/apex/'
                           visualforceNavigation += '?isdtp=p1&' + paramList.join('&');
                           var domain = component.get('v.domain');
                           if (domain != undefined) visualforceNavigation += '&sfdcIFrameOrigin='+ domain.url +'.lightning.force.com';

                        }
                       // console.log('ATP - ' + title + ' - Set url');
                        component.set('v.url', visualforceNavigation);
                        //console.log('ATP - ' + title + ' - Set type');
                        component.set('v.type','VFPage');
                   }


               }else{

                    //console.log('ATP - Creating Object');
                    component.set('v.type','Component');
                    var  title =actionDTO.title;
                    if(actionDTO.active==true)
                     {
                        var params = {}
                        if( actionDTO.target.indexOf('Full_List_View') >-1)
                        {
                           for(var i =0; i < actionDTO.params.length;i++)
                           {
                               var paramObj= actionDTO.params[i];
                               for(var key in paramObj)
                               {
                                   params[key]=paramObj[key];
                               }
                           }
                        }
                        //console.log('ATP - params ' + params);

                        $A.createComponent(
                              actionDTO.target,params,
                              function(newComponent){
                                  if (newComponent.isValid()) {
                                      var body = component.get("v.body");
                                      body.push(newComponent);
                                      //console.log('ATP - ' + title + ' Set body');
                                      component.set("v.body", body);
                                  }
                              }
                          )
                   }else{

                   }
               }
            }else{

            }
           //console.log('ATP - Set initalised');
            component.set('v.initalised', true);

         },

         tabSelectionChanged: function(component, event, helper)
         {

            var actionDTO = component.get('v.actionDTO');
            var title = 'NotSet';
            if(actionDTO !=null)
            {
                title=actionDTO.title;
            }
            if(component.isValid()==true)
            {

                if(actionDTO.active==true)
                {

                    if (!(actionDTO.type == 'VFPage' || (actionDTO.type == 'LightningEvent' && actionDTO.target=='e.force:navigateToURL') )&& actionDTO.target !== undefined) {

                   if( component.get('v.hasbeenActive')==false)
                   {
                       if(actionDTO.tabType!='Report')
                         {
                         var params = {}
                         if( actionDTO.target.indexOf('Full_List_View') >-1)
                         {
                            for(var i =0; i < actionDTO.params.length;i++)
                            {
                                var paramObj= actionDTO.params[i];
                                for(var key in paramObj)
                                {
                                    params[key]=paramObj[key];
                                }
                            }
                         }

                              $A.createComponent(
                                  actionDTO.target,params,
                                  function(newComponent){
                                      if (newComponent.isValid()) {
                                          var body = component.get("v.body");
                                          body.push(newComponent);
                                          ///console.log('ATP - ' + title + ' Set body');
                                          component.set("v.body", body);
                                      }
                                  }
                              )
                           }
                       }
                    }

//                    $A.util.removeClass(component,' slds-hide');
//                    $A.util.addClass(component,' slds-show');
                    //console.log('ATP - ' + title + ' Set has been acctivated');
                    component.set('v.hasbeenActive', true);
                }else{
//                    $A.util.removeClass(component,' slds-show');
//                    $A.util.addClass(component,' slds-hide');
                     //console.log('ATP - ' + title + ' Set has been deactivated');
                }
            }else{
                //console.log('ATP - ' + title + ' Is not a valid compoent');
            }
         }


})