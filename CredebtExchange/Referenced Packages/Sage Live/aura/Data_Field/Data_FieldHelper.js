/**
 * Created by daniel.colquhoun on 20/11/2016.
 */
({
    buildDefaultParams:function(component,options,type)
    {
      options['accessKey'] = {isParam : true}
      options['class'] = {isParam : true}
      options['disabled'] = {isParam : true}
      options['formatter'] = {isParam : true}
      options['label'] = {isParam : true}
      options['max'] = {isParam : true}
      options['maxlength'] = {isParam : true}
      options['messageWhenBadInput'] = {isParam : true}
      options['messageWhenPatternMismatch'] = {isParam : true}
      options['messageWhenRangeOverflow'] = {isParam : true}
      options['messageWhenRangeUnderflow'] = {isParam : true}
      options['messageWhenStepMismatch'] = {isParam : true}
      options['messageWhenTooLong'] = {isParam : true}
      options['messageWhenTypeMismatch'] = {isParam : true}
      options['messageWhenValueMissing'] = {isParam : true}
      options['min'] = {isParam : true}
      options['minlength'] = {isParam : true}
      options['name'] = {isParam : true}
//      options['onfocus'] = {isParam : true, isReference: true}
      options['pattern'] = {isParam : true}
      options['placeholder'] = {isParam : true}
      options['readonly'] = {isParam : true}
      options['required'] = {isParam : true}
      options['step'] = {isParam : true}
      options['tabindex'] = {isParam : true}
      options['type'] = {isParam : true}
      options['validity'] = {isParam : true}   // return this object and save after it has been created
    },

    buildTextAreaParams:function(component,options,type)
    {
      options['accessKey'] = {isParam : true}
      options['class'] = {isParam : true}
      options['disabled'] = {isParam : true}
      options['label'] = {isParam : true}
      options['maxlength'] = {isParam : true}
      options['messageWhenBadInput'] = {isParam : true}
      options['messageWhenTooLong'] = {isParam : true}
      options['messageWhenValueMissing'] = {isParam : true}
      options['minlength'] = {isParam : true}
      options['name'] = {isParam : true}
//      options['onfocus'] = {isParam : true, isReference: true}
      options['placeholder'] = {isParam : true}
      options['readonly'] = {isParam : true}
      options['required'] = {isParam : true}
      options['step'] = {isParam : true}
      options['tabindex'] = {isParam : true}
      options['type'] = {isParam : true}
      options['validity'] = {isParam : true}   // return this object and save after it has been created
    },

    setParams:function(component,options)
    {
        var params = {};
        for(var key in options)
        {
            this.setParam(component,params,key,options);
        }
        return params;
    },

    setParam:function(component,params,keyName,option)
    {
        if(option[keyName].isParam==true)
        {
            var obj = null;
            if(option[keyName].isReference==true)
            {
                // get it as a reference
                obj = component.getReference('v.' + keyName);
            }else{
                // get it as a value
                obj = component.get('v.' + keyName);
            }

            // Only add it if it is not null or undefined
            if(obj != null && obj != undefined)
            {
                // set the key value
                params[keyName] = obj;
            }
        }

    },

 // This method converts a lowercase field name, to and Title case field name used
    toSObjectFieldCase:function(str){
        str = str.replace(/([a-z])/, function(a, l) { return l.toUpperCase(); });
        str = str.replace(/_([a-z])/gi, function(a, l) { return '_'+l.toUpperCase(); });
        str = str.replace(/\.([a-z])/gi, function(a, l) { return '.'+l.toUpperCase(); });
        str = str.replace(/(__C|__R)/, function(a, l) { return l.toLowerCase(); });
        return str;
    },

    getValue:function(obj,fieldName,component)
    {

        var fieldParts = fieldName.split('.');
        var indexCount = fieldParts.length;
        var tmpObject = obj;

        for(var i = 0; i < indexCount; i++)
        {
            if(!(fieldParts[i] in tmpObject))
            {
                if(component)
                {
//                    var tmplabel = component.get('v.label');
//                    component.set('v.label', tmplabel + ' Dev - '+ fieldName + ' -     Data My not have been serialised as it is null' );
                    // dc todo :  create a null value for this object;
                }
            }
            var t = tmpObject[fieldParts[i]];
            // if the field does not exist or there is no data break out of this safely
            if(t == undefined || t == null)
            {
                tmpObject = null;
                break;
            }else{
                tmpObject = t;
            }
        }

        return tmpObject;

    },
    // If the field has not been serialised and it is not a refernece type
    // create a null
    createDefaultValue:function(obj,fieldName,component)
    {

    },
    setValue:function(obj,fieldName,value)
        {

            var fieldParts = fieldName.split('.');
            var indexCount = fieldParts.length;
            var tmpObject = obj;

            var pCount = 1;

            var currentFieldPart = fieldName;
            for(var i = 0; i < indexCount-1; i++)
            {
                currentFieldPart = fieldParts[i];
                var t = tmpObject[fieldParts[i]];

                // if the field does not exist or there is no data break out of this safely
                if(t == undefined || t == null)
                {
                    tmpObject = null;  // dc todo - create the object safely and if it is the last fieldPart assign the object type

                    break;
                }else{
                    tmpObject = t;
                }
                pCount++;
                // change the fieldPartName to the last field part name
               if(pCount==indexCount)
               {
                 currentFieldPart = fieldParts[i+1];
               }
            }

            if(pCount==indexCount)
            {

                tmpObject[currentFieldPart] = value;
                return true;
            }
            return false;

        },
    // this fires when the scope  changes.
    // This is not granular and would fire on every component when the scope is loaded.
    // If there are different scope's data objects loaded at different times every Data Field will have this event fired.
    dataChange : function(component,event,helper)
    {
        var name = component.get('v.name');
        var intialised = component.get('v.intialised');
        var doneRendering = component.get('v.doneRendering');
        var scope =  component.get('v.scope');
        var index = component.get('v.index');
        var isArray =  index!=null && index!=undefined ? true : false;

        if(scope == undefined || scope == null)
        {
            // dc todo implement 'binding data missing' error message
            return;
        }
        var schemaIsCustom = scope['s'] == 'custom' ? true :false ;

        if( doneRendering==true)
        {
            var fieldName = component.get('v.fieldName');
            if(fieldName==null || fieldName== undefined)
            {

                return;
            }

            var dataChangeDirection =  component.get('v.dataChangeDirection');
            if(dataChangeDirection!='component') // Make sure that this component has not triggered the datchanges
            {
                var thisComponentValue = component.get('v.value');

                var lFieldName = fieldName.toLowerCase();
               // Check if the field is an Id field and points to the Name field name of the object the Id reference is pointing to

               if(scope['s'][lFieldName] != undefined) // schema based
               {

                   var sourceNameRef = scope['s'][lFieldName]['SourceNameReferenceField']; // dc todo - refactor this into a function
                   if(sourceNameRef!=undefined && sourceNameRef !=null )
                   {
                       // always display the Name field of the object that the Id reference is pointing to
                       lFieldName = sourceNameRef;
                   }else{
                        lFieldName = scope['s'][lFieldName].fullName;;
                   }
               }else{
                 // This may be a custom field type

               }

                // check if this is an object type or an array type of object
                var dataSourceValue = null;
                var sFieldName = lFieldName;

                if(scope.type=='object')
                {
                    dataSourceValue = helper.getValue(scope['d'],sFieldName,component);  // this will update the bindings to the scope - trigger arua:if conditiosn ect
                }else{
                    if(isArray)
                    {
                        dataSourceValue = helper.getValue(scope['d'][index],sFieldName,component);  // this will update the bindings to the scope - trigger arua:if conditiosn ect
                    }
                }

                if(dataSourceValue!==thisComponentValue)
                {
                    component.set('v.value',dataSourceValue); // may trigger a never ending loop
                }
            }else{
                // to reset the component
                // this component has already been
                component.set('v.dataChangeDirection','reset');
            }
            return;
        }
//        if(intialised==false )
//        {
//            component.set('v.intialised',true);
//            return ;
//        }
       // alert('loaded2');
        // get the scope attribute
        var rendered = component.get('v.rendered');
        if(scope != null && scope != undefined  && rendered == true)
        {
        if(typeof(scope.loaded) != 'undefined' && scope.loaded===true)
            {
               // get the fieldName
               var fieldName = component.get('v.fieldName');
               fieldName = fieldName.toLowerCase();
               // make sure the scope has been loaded, and the field name supplied
               if(typeof(scope.loaded) != 'undefined' && scope.loaded===true && fieldName!=undefined)
               {
                   // The field name must contain the scope name e.g. Account or Sage_COR_Company__c.

                   var data = scope;
                   // set the debounce level
                   var thisDebounceTimeout = component.get('v.debounceTimeout');
                   var debounceTimeout = ((thisDebounceTimeout == null) || (thisDebounceTimeout == undefined)) ? scope.debounceTimeout :  thisDebounceTimeout;
                   component.set('v.debounceTimeout', debounceTimeout);

                   // show edit
                   var showEdit = scope.showEditButtons;
                   component.set('v.showEdit',scope.showEditButtons);


                   var lFieldName = fieldName;  // the lowercase field name is access the schema object
                  // console.log(lFieldName);
                   // check if the schema field exists
                    if(data['s'] == undefined)
                   {
                       return ;
                   }

                   if(data['s'][lFieldName] != undefined ||data['s']=='custom') // schema based or custom based
                   {


                       var sourceIdRef = null;


                       if(schemaIsCustom == false)
                       {
                           // Check if the field is an Id field and points to the Name field name of the object the Id reference is pointing to
                           var sourceNameRef = data['s'][lFieldName]['SourceNameReferenceField'];
                           if(sourceNameRef!=undefined && sourceNameRef !=null )
                           {
                               // the current lFieldName is an ID reference field type
                               sourceIdRef = data['s'][lFieldName].fullName;

                               // always display the Name field of the object that the Id reference is pointing to
                               lFieldName = sourceNameRef;
                           }else{
                               // This field may be a 'Name' type field, so it would need the name of the Id reference to be used to build the action
                               sourceIdRef = data['s'][lFieldName]['SourceIDReferenceFieldFull'];
                           }
                       }else{
                           lFieldName = fieldName;
                           if(lFieldName.includes('.Name')) // It is possible have link in the custom dto as long as there is a xxx.Name field and and xxx field that is an Id
                           {
                               var sourceFieldNameArray = lFieldName.split('.');
                               if(sourceFieldNameArray.length>1)
                               {
                                   sourceIdRef = sourceFieldNameArray[0];
                               }

                           }

                       }

                       var value = component.get('v.value');

                       var sFieldName = lFieldName;
                       var llFieldName = lFieldName.toLowerCase();
                      var dFieldName  = scope['s'][llFieldName].fullName;


                       // if the value has not been set automatically attempt to get the value from the scope by using the field name
                       // if the value has not been set then two way binding will not work and is best in view mode
                       if( value==null || value == undefined)
                       {

                            if(scope.type=='object')
                            {

                              value = helper.getValue(scope['d'],dFieldName,component);
                            }
                            else
                            {
                              if(isArray)
                              {

                                   value = helper.getValue(scope['d'][index],dFieldName,component);
                              }
                            }

                           component.set('v.value', value);
                       }


                       // set previous value for future for Undo feature
                       component.set('v.previousValue',value);
                       // Get the type of the component
                       var type = component.get('v.type')
                       // If the type is not overridden - get it from the schema
                       if(type==null && schemaIsCustom == false)
                       {
                            // If this field has a sourceIdRef then get the type from the sourceIdRef field schema
                           if(sourceIdRef!=undefined && sourceIdRef != null)
                           {

                               type = data['s'][sourceIdRef.toLowerCase()]['Type'];
                               component.set('v.type',type);
                           }
                           else
                           {
                               // The field is a 'normal field i.e. Not a reference id or a Name field
                               type = data['s'][llFieldName]['Type'];
                               component.set('v.type',type);
                           }
                       }

                        var maxlength = component.get('v.maxlength');
                        if(maxlength==null && schemaIsCustom == false)
                        {
                           if(sourceIdRef!=undefined && sourceIdRef != null)
                           {
                               maxlength = data['s'][sourceIdRef.toLowerCase()]['Length'];
                               component.set('v.maxlength',maxlength);
                           }
                           else
                           {
                               maxlength = data['s'][llFieldName]['Length'];
                               component.set('v.maxlength',maxlength);
                           }
                        }

                       var label = component.get('v.label');
                       // Check if the label is set ' ' 1 space char. As that is minimum requirement of lighting:input

                       if(label == ' ' && schemaIsCustom == false)
                       {
                           label = data['s'][llFieldName]['label'];
                           component.set('v.label',label);
                       }

                       // Check if the field has been set.
                       // By default disabled is set to false.  If a user wants to override this they can else use the shema settings for the field.
                       var disabled =  component.get('v.disabled');
                       if(disabled!==true && schemaIsCustom == false)
                       {
                           disabled = data['s'][llFieldName]['disabled'];
                           component.set('v.disabled',disabled);
                       }

                       // If this field is a .name field then get the object that it is pointing to set the action
                       // should not use 'includes' as it is not compatible for most browsers.
                       if(lFieldName.toLowerCase().indexOf('.name')> -1)
                       {
                           //   var ind = data['s'][sourceIdRef]['ReferenceTo'].length-1;
                           //   var objectName = data['s'][sourceIdRef]['ReferenceTo'][ind];
                           //   component.set('v.objectReference', objectName);

                           var action_dto = {
                               title: value, // dc todo : is this needed ?
                               type: 'LightningEvent',
                               target: 'e.force:navigateToSObject',
                               params:{
                                        recordId: schemaIsCustom==true? helper.getValue(scope['d'],sourceIdRef,component) : isArray? helper.getValue(scope['d'][index],sourceIdRef,component) : helper.getValue(scope['d'],sourceIdRef,component)
                                    }
                               }
                           component.set('v.actionDto',action_dto);
                       }

                        var realType = "" ;
                        if(schemaIsCustom==false)
                        {
                           realType = data['s'][llFieldName]['fieldType'];
                        }
                        var editable = true;
                        if(schemaIsCustom==false)
                        {
                            editable = data['s'][llFieldName]['editable'];
                            // update the UI
                            if(editable==false)
                            {
                                component.set('v.disabled', true);
                            }

                            component.set('v.decimalPlaces',data['s'][llFieldName]['decimalPlaces']);
                            //dc todo there is no prefix information
                        }


                        switch(realType){
                            case 'PICKLIST': {

                                    var rawPickListValues = data['s'][llFieldName]['PicklistValues'];
                                    var list = [];
                                    var defaultValue = "";
                                    for(var key in rawPickListValues)
                                    {
                                        if(rawPickListValues[key].active== true)
                                        {
                                            if(rawPickListValues[key].defaultValue== true)
                                            {
                                                defaultValue = { label:rawPickListValues[key].label , value:rawPickListValues[key].value }
                                            }
                                            list.push({ label:rawPickListValues[key].label , value:rawPickListValues[key].value });
                                        }
                                    }

                                    var param = {};
                                    param['label'] =  component.get('v.label');
                                    param['selected'] = component.getReference('v.value');
                                    param['onchange'] = component.getReference('c.changedValue');
                                    param['list'] = list;

                                    $A.createComponent("s2cor:Data_Field_Picklist",param,
                                        function(newCmp, status)
                                        {
                                          if (status === "SUCCESS")
                                          {
                                            component.set('v.body',newCmp);
                                          }

                                        }
                                    );

                                    break;
                                }
                            case 'TEXTAREA':{

                                var options = {};
                                this.buildTextAreaParams(component,options);
                                var params = this.setParams(component,options);
                                params['value'] = component.getReference('v.value');
                                params[scope.updateBoundFieldsOn] = component.getReference('c.changedValue');
                                this.createComponent(component,"lightning:textarea",params,scope,llFieldName);
                                break;
                            }

                            default:{
                                 // create the component dynamically
                                    var options = {};
                                    this.buildDefaultParams(component,options);
                                    var params = this.setParams(component,options);
                                    params['aura:id'] = 'thisComponent'; // this doesnt work
                                    if(editable==false)
                                    {
                                         params['disabled'] = true;
                                    }

                                    switch(type)
                                    {
                                        case 'boolean':
                                        case 'checkbox':{
                                            params['checked'] = component.getReference('v.value');
                                            params['onchange'] = component.getReference('c.changedValue');
                                            params['type'] = 'checkbox';
                                            this.createComponent(component,"lightning:input",params,scope,llFieldName);
                                            break;
                                        }
                                        case 'currency':{
                                            params['formatter'] = "currency";
                                            params['step'] = this.getDecimalToStep(data['s'][llFieldName]['decimalPlaces']);    // This sets the decimal place increasement
                                            params['type'] = 'number';
                                            params[scope.updateBoundFieldsOn] = component.getReference('c.changedValue');
                                            params['value'] = component.getReference('v.value');
                                            this.createComponent(component,"lightning:input",params,scope,llFieldName);
                                            break;
                                        }
                                        case 'number':{
                                            params['step'] = this.getDecimalToStep(data['s'][llFieldName]['decimalPlaces']);    // This sets the decimal place increasement
                                            params['type'] = 'number';
                                            params[scope.updateBoundFieldsOn] = component.getReference('c.changedValue');
                                            params['value'] = component.getReference('v.value');
                                            this.createComponent(component,"lightning:input",params,scope,llFieldName);
                                            break;
                                        }
                                        case 'datetime':{
                                            params['type'] = 'datetime';
                                            params[scope.updateBoundFieldsOn] = component.getReference('c.changedValue');
                                            params['value'] = component.getReference('v.value');
                                            this.createComponent(component,"lightning:input",params,scope,llFieldName);
                                            break;
                                        }
                                        case 'reference':{
                                              // disable reference
    //                                          params['disabled'] = true;
    //                                          params['value'] = component.getReference('v.value');
    //                                          component.set('v.isReference',true);
    //                                          params[scope.updateBoundFieldsOn] = component.getReference('c.changedValue');
    //                                          this.createComponent(component,"lightning:input",params,scope,llFieldName);
                                              // Tempory until lookup field has been generated
                                              params = {};
                                              params['fieldName'] = fieldName;
                                              params['value'] = component.getReference('v.value');
                                              params['valid'] = component.get('v.valid'); // defaults to true
                                              params['label'] = component.get('v.label');
                                              params['actionDto'] = component.get('v.actionDto');
                                              params['mode'] = 'inline-edit'; // dc todo we no that the mode is not goint to be view however we need to make the mode an object reference so that it binds.  Posisbly by just an attribute
                                              params['disabled'] = true;
                                              params['isReference'] = true;
                                              component.set('v.isReference',true);
                                              params['onInlineEdit'] = component.getReference('c.onInlineEdit') ;
                                              params['showEdit'] = showEdit;

                                              this.createComponent(component,"s2cor:Data_Field_Display",params,scope,llFieldName);

                                              break;
                                        }
                                        default:{
                                                params['value'] = component.getReference('v.value');
                                                params[scope.updateBoundFieldsOn] = component.getReference('c.changedValue');
                                                this.createComponent(component,"lightning:input",params,scope,llFieldName);
                                                break;
                                         }
                                    }
                             }
                        }

                   }
                   else
                   {
                      // console.log('Schema does not exist');
                       component.set('v.valid',false);
                       component.set('v.label','Schema does not exist ' + llFieldName );
                   }

                  // helper.createComponent(component,newComponentParams);
                  }

                  component.set('v.doneRendering',true);
              }
        }

    },

    getDecimalToStep:function(decimal)
    {
        var step = "1";
        for(var i= 1; i < decimal;i++)
        {
            step = '0' + step;
        }
        if(decimal>0)
        {
            step = '0.' + step;
        }
        return step;
    },

    createComponent:function(component,name, params,scope,fieldName)
    {

      $A.createComponent(name,params,
          function(newComponent, status, errorMessage){
              if (status === "SUCCESS") {
                  scope.validity.push({name:fieldName, results: newComponent.get('v.validity')});
                  if( scope.s!=undefined)
                  {
                    var field = scope.s[fieldName]
                   // field['component'] = newComponent;  // possible for future use
                  }
                  var body = component.get('v.body');
                  body.push(newComponent);
                  component.set('v.body',body);
                  component.set('v.inputComponentId', newComponent.getGlobalId());

              }
              else if (status === "INCOMPLETE") {
              }
              else if (status === "ERROR") {
              }
          }
      );
    },

    componentsFactory2:function()
    {
       var r = [
                    {
                        name:"aura:text",
                        params:{value: "test"}
                    }
        ]
        return r;
    },
    componentsFactory:function()
    {
        var com = [
            ["aura:HTML", {tag: "div", HTMLAttributes:{"id": "parent","class": "slds-form-element slds-has-divider--bottom row-icon-indicator slds-col--padded slds-size--1-of-1 slds-medium-size--1-of-2 slds-large-size--1-of-2"}}],
//            ["aura:HTML", {tag: "label", HTMLAttributes:{"id": "child1","class": "slds-form-element__label"}}],
//            ["aura:HTML", {tag: "span", HTMLAttributes:{"id": "child2","class": "slds-truncate output-text"}}],
            ["aura:text", {value:'** dc **'}]
//            ["aura:HTML", {tag: "div", HTMLAttributes:{"id": "child2","class": "slds-float--right"}}],
//            ["lightning:icon", {iconName:"utility:edit", size:"x-small", alternativeText:"Indicates approval" , class:"icon-indicator"}]
        ]

        return com;
    },

    componentsFactory3:function()
    {
        var com = [
                    {
                        name:"aura:HTML",
                        params:{tag: "div", HTMLAttributes:{"id": "parent","class": "slds-form-element slds-has-divider--bottom row-icon-indicator slds-col--padded slds-size--1-of-1 slds-medium-size--1-of-2 slds-large-size--1-of-2"}},
                        inner:[
                                {
                                    name:"aura:HTML",
                                    params:{tag: "label", HTMLAttributes:{"id": "child1","class": "slds-form-element__label"}}
                                },
                                {
                                    name:"aura:HTML",
                                    params:{tag: "span", HTMLAttributes:{"id": "child2","class": "slds-truncate output-text"}},
                                    inner:[
                                        {
                                            name:"aura:text",
                                            params:{value:'** dc **'}
                                        }]
                                },
                                {
                                    name:"aura:HTML",
                                    params:{tag: "div", HTMLAttributes:{"id": "child2","class": "slds-float--right"}},
                                    inner:[
                                        {
                                            name:"lightning:icon",
                                            params:{iconName:"utility:edit", size:"x-small", alternativeText:"Indicates approval" , class:"icon-indicator"}
                                        }]
                                }
                                ]
                    }
                ]

                return com;
    },

    getComponentList:function(component, schema)
    {
        var lst = [];


        // This protects from any deeplevel property locking that lightning does
        function buildList(com)
        {
            var length = com.length;
            for(var key = 0; key < length; key++)
            {
                if(com[key].name != undefined)
                {
                    var obj = [com[key].name,com[key].params];
                    lst.push(obj); // link index to this toSchema
                    // check for more
                    if(com[key].inner!=undefined)
                    {
                        buildList(com[key].inner);
                    }
                }
            }
        }
        buildList(schema);
        $A.createComponents(lst,
                    function(components, status)
                    {
                      if (status === "SUCCESS")
                      {

                        var index = 0;
                        function buildNestedComponents(sch,components,parentCom)
                        {
                          var length = sch.length;
                          for(var key = 0; key < length; key++)
                          {
                             if(sch[key].name != undefined)
                             {

                                 var currentComponent = components[index++];
                                 if(sch[key].inner!=undefined)
                                 {

                                    buildNestedComponents(sch[key].inner,components,currentComponent);
                                 }
                                 var body = parentCom.get('v.body');
                                  if(currentComponent!=undefined)
                                  {
                                      if(body!=undefined)
                                      {
                                         body.push(currentComponent);
                                         parentCom.set('v.body',body);

                                      }
                                  }

                             }

                          }
                        }

                        buildNestedComponents(schema,components,component);
                      }

                    }
                );
        return lst;
    },

    createComponents:function(component,list)
    {
        $A.createComponents(list,
            function(coms, status)
            {
              if (status === "SUCCESS")
              {
                var len = coms.length;
                var first = coms[0].get('v.body');
                for(var i = 1; i < len ; i++)
                {
                    first.push(coms[i]);
                }
                coms[0].set('v.body',first);
                var or = component.get('v.body');
                or.push(coms[0]);
                component.set('v.body',or);
              }

            }
        );
    }
})