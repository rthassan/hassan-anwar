/**
 * Created by daniel.colquhoun on 20/11/2016.
 */
({
    // mode
    // type
    doInit:function(component,event,helper){

         // User can override the label -  "" = hide label
         var label =  component.get('v.label');
         // Hide the label, if not set use default

         // dc todo - change this programtically
         if(label!=null)
         {
             if(label == "#hide#")
             {
                  // so the lightning components do not bug out
                component.set('v.labelStyle', 'hide-label');

             }else{
                 if(label=="")
                 {
                    component.set('v.label', ' '); // dc todo : be wary that if a user is binding to this field, the field would change from '' to ' '
                 }
             }

         }
        // if an index is supplied then we know that we are in an itterator - fire the dataChange event as the data has alredy been loaded at this point.

        var rendered = component.get('v.rendered');
        var index = component.get('v.index');
        var autoBind = component.get('v.autoBind');
        var scope = component.get('v.scope');
        if(scope!=null && scope != undefined)
        {
            if(scope.loaded==true)
            {
               helper.dataChange(component,event,helper);
            }
        }
        if(((index != null && index != undefined) || autoBind == true) &&  rendered == true)
        {
            component.set('v.intialised',true);
            helper.dataChange(component,event,helper);
        }
        component.set('v.preRendered', true);

    },

    doNothing:function(){},
    // This method handles onchange event from the inner component
    changedValue:function(component,event,helper){

         var doneRendering = component.get('v.doneRendering');
         if( doneRendering==true)
         {
                var fieldName = component.get('v.fieldName');
                if(fieldName==null || fieldName== undefined)
                {
                    // if a developer has an action handler call it
                    var action = component.get("{!v.onchange}");
                    if(action!=null)
                    {
                       $A.enqueueAction(action);
                    }
                    return;
                }
                // get the debounceTimeout
                var debounceTimeout = component.get('v.debounceTimeout');
                var timeout = component.get('v.timeOutFunc');
                if(timeout!=null && timeout!=undefined)
                {
                    window.clearTimeout(timeout);
                }
                timeout = window.setTimeout(
                    $A.getCallback(function() {
                        component.set('v.timeOutFunc',null);
                        if (component.isValid()) {


                           var value = component.get('v.value');
                           var control = component.find('thisComponnet');
                           var scope =  component.get('v.scope');
                           if(scope == undefined || scope == null)
                           {
                                // dc todo implement 'binding data missing' error message
                                return;
                           }
                           var schemaIsCustom = scope['s'] == 'custom' ? true :false ;
                           //console.log(fieldName);
                           var lFieldName = fieldName.toLowerCase() ;
                           if(scope['s'][lFieldName] != undefined) // schema based
                           {

                               var sourceNameRef = scope['s'][lFieldName]['SourceNameReferenceField']; // dc todo - refactor this into a function
                               if(sourceNameRef!=undefined && sourceNameRef !=null )
                               {
                                   // always display the Name field of the object that the Id reference is pointing to
                                   lFieldName = sourceNameRef;
                               }else{
                                   lFieldName = scope['s'][lFieldName].fullName;
                               }
                           }else{
                              // console.log('The schema doesnt exist' + lFieldName);
                           }
                           component.set('v.dataChangeDirection','component'); // Make sure that setting this component does not set the dataChange on this component - other dataChange components should be retriggered though

                           var sFieldName = lFieldName;
                           if(scope.type == 'object')
                           {
                              // check if the data is different
                              if(component.get('v.value')!= helper.getValue(scope['d'],sFieldName,component))
                               {
                                   component.set('v.dirtyValue', value);
                                   helper.setValue(scope['d'],sFieldName,value);  // this will update the bindings to the scope - trigger arua:if conditiosn ect
                                   var dirtyObject = scope.dirty;
                                   if(dirtyObject=='undefined' || dirtyObject==null)
                                   {
                                       dirtyObject = {};
                                       dirtyObject[sFieldName] = true;
                                   }else{
                                       dirtyObject[sFieldName] = true;
                                   }

                                  component.set('v.scope',scope); // this will update the bindings to the scope - trigger arua:if conditiosn ect

                                  // If an onchanged event has been passed through to this component raise it in sync with the any changes above
                                  var action = component.get("{!v.onchange}");
                                  if(action!=null)
                                  {
                                      $A.enqueueAction(action);
                                  }

                               }

                           }
                           else
                           {
                               var index = component.get('v.index');
                               if(index!=null && index!=undefined)
                               {
                                if(component.get('v.value')!= helper.getValue(scope['d'][index],sFieldName,component))
                                {
                                    component.set('v.dirtyValue', value);
                                    helper.setValue(scope['d'][index],sFieldName,value);  // this will update the bindings to the scope - trigger arua:if conditiosn ect
                                    var dirtyObject = scope.dirty;
                                    if(dirtyObject=='undefined' || dirtyObject==null)
                                       {
                                           dirtyObject = {};
                                           var df = dirtyObject[index] = {};
                                           df[sFieldName] = true;
                                       }else{
                                           var df = dirtyObject[index] ;
                                           if(df==undefined)
                                           {
                                                var df = dirtyObject[index] = {};
                                                df[sFieldName] = true;
                                           }else{
                                                df[sFieldName] = true;
                                           }

                                       }

                                       component.set('v.scope',scope); // this will update the bindings to the scope - trigger arua:if conditiosn ect

                                       // If an onchanged event has been passed through to this component raise it in sync with the any changes above
                                       var action = component.get("{!v.onchange}");
                                       if(action!=null)
                                       {
                                           $A.enqueueAction(action);
                                       }
                                   }
                               }
                           }


                        }
                    }), debounceTimeout
                );
                component.set('v.timeOutFunc',timeout);

         }
    },
    // this fires when the scope  changes.
    // This is not granular and would fire on every component when the scope is loaded.
    // If there are different scope's data objects loaded at different times every Data Field will have this event fired.
    dataChange : function(component,event,helper)
    {
        helper.dataChange(component,event,helper);
    },
    onInlineEdit:function(component,event,helper)
    {
        var scope = component.get('v.scope');
        scope.mode = 'inline-edit';
        component.set('v.scope',scope);
        // set the focus to the input control
        // dc todo unable to set the focus of a component - it doesnt seem to work
//        var globalId = component.get('v.inputComponentId');
//        window.setTimeout(
//                    $A.getCallback(function() {
//                        if (component.isValid()) {
//                            var inputCmp = $A.getComponent(globalId);
//                            if(inputCmp)
//                            {
//                                inputCmp.focus();
//                            }
//                        }
//                    }),300);

    },
    firstRender: function(component,event,helper)
    {

        var rendered = component.get('v.rendered');
        if(rendered==true)
        {
            var hasRendered = component.get('v.doneRendering');
            if(!hasRendered)
            {
               helper.dataChange(component,event,helper);
            }
        }
    },


    reload:function (component,event,helper)
    {
        component.set('v.doneRendering',false);
        helper.dataChange(component,event,helper);
    },

})