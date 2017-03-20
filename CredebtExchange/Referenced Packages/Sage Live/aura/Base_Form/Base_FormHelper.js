/**
 * Created by daniel.colquhoun on 19/11/2016.
 */
({

    applyContext:function(component)
    {
        console.log('apply Context called');
        var recordIds = component.get('v.recordIds');
        var title = component.get('v.title');
        var uid = component.get('v.uid');
        if(recordIds || (title != '' && title != undefined ) || (uid !='' && uid != undefined))
        {
            component.set('v.isModal',true);
            console.log('isModel == true');
            component.set('v.buttons','DataInputForm');

            // this is hardcoded and would need development before release
            if(title.toLowerCase() == 'new')
            {
                component.set('v.mode','new');
            }else if(title.toLowerCase() == 'edit'){
                component.set('v.mode','edit');
            }

            this.applyStyles(component);
        }else{
//            component.set('v.isModal',false);
            console.log('isModel == ' + component.get('v.isModal'));
        }

    },
    // This will get a record from s specified recordId
    getRecord:function(component,callback)
    {
        console.log('getRecord');
        var recordId = component.get('v.recordId');
        var sObjectType = component.get('v.sObjectType');
        var fieldList = component.get('v.fieldList');
        var additionalFields = component.get('v.additionalFields');
        var mode = component.get('v.mode');
        var param = {
             recordId : recordId == null || recordId == undefined ? '': recordId,
             fieldList : fieldList == null || fieldList == undefined ? '': fieldList,
             additionalFields : additionalFields == null || additionalFields == undefined ? '': additionalFields
        }
        this.callServer(component,"c.GetRecord",function(data)
        {
            // build the data structure
             var scope = this.initialiseRecordScope(component,data);
            console.log(scope);
            callback(scope);
        },param);
        return;
    },

    // This will get the schema of an object and create a dummy sObject from the schema
    getNew:function(component,callback)
    {
        console.log('getNew');
        var recordId = component.get('v.recordId');
        var sObjectType = component.get('v.sObjectType');
        var fieldList = component.get('v.fieldList');
        var additionalFields = component.get('v.additionalFields');
        var mode = component.get('v.mode');
        var sObjectType = component.get('v.sObjectType');
        var param = {
             sObjectType : sObjectType == null || sObjectType == undefined ? '': sObjectType,  // A record id will always be supplied unless it is new
             fieldList : fieldList
        }
        // This will get an object type
        this.callServer(component,"c.GetNewObjectType",function(data)
        {

            // build the data structure
            var scope = this.initialiseRecordScope(component,data,'',sObjectType,mode)
            callback(scope);
        },param);
    },


    saveRecord:function(component,extraCallBack)
    {
        component.set('v.loaded',false);
        var scope = component.get('v.scope');
        var primaryScope = this.getPrimaryScope(scope);
                // check the id is the isSame
        var mode = primaryScope.mode;
        var pinThis = this;
        function callback(response){
           // dc todo  - validate the a successful save;
           component.set('v.loaded',true);
           pinThis.changeToViewMode(component);
           if(extraCallBack){
                extraCallBack();
           }
        }
        switch(mode)
        {
            case 'edit':
            case 'inline-edit':
            {
                var recordId = component.get('v.recordId');
                this.saveDirtyRecord(component,scope,recordId,callback);
                break;
            }
            case 'new':
            {
                 var saveObject = {};
                        for(var dirtyKey in primaryScope.dirty)  // assuming it is not an array collection
                        {
                            saveObject[dirtyKey] = primaryScope.d[dirtyKey];  // dc todo - at the moment if the field has not been serialised over e.g. number - it will automatically be a text value in the when it should be the type of the lightning:input control that has been set
                        }

                        var sObjectType = component.get('v.sObjectType');
                        var sObjectString = JSON.stringify(saveObject);
                        var param = {
                            sObjectType : sObjectType,
                            sObjectString : '[' + sObjectString + ']'    // This is just a single object

                        }
                        this.callServer(component,'c.InsertRecord',function(response){
                            console.log(response);
                            this.changeToViewMode(component);
                        },param);
                break;
            }
        }
    },

    cancelEdit:function(component)
    {
        // dc todo implement full undoo - easy to just reload original data - or is it?
        this.changeToViewMode(component);
    },

    changeToViewMode:function(component)
    {
        // dc todo implement full undoo - easy to just reload original data - or is it?
        var scope = component.get('v.scope');
        // loop through each of sub scopes
        for(var key in scope)
        {

            if(scope[key] != undefined)
            {
                if(scope[key].mode == 'inline-edit')
                {
                    scope[key].mode = 'view'; // dc todo - assume preview view was view,
                }
            }
        }
        component.set('v.scope',scope);
    },

    saveDirtyRecord:function(component,scope,recordId,callback)
    {
        // Save primary object
        // scan each of the scopes for options.isPrimary - if primary that is the primary scope to save.
        // each of the objects have a dirty object with a collection of dirtyfields -  build a dirty field collections
        var saveObject = {};
        // find the primary scopeObject
        var primaryScope = this.getPrimaryScope(scope);
        // check the id is the isSame
        if(primaryScope.d.Id.toLowerCase() == recordId.toLowerCase())
        {
            saveObject['Id'] = recordId;
            for(var dirtyKey in primaryScope.dirty)  // assuming it is not an array collection
            {
                saveObject[dirtyKey] = primaryScope.d[dirtyKey];  // dc todo - at the moment if the field has not been serialised over e.g. number - it will automatically be a text value in the when it should be the type of the lightning:input control that has been set
            }
            var sObjectString = JSON.stringify(saveObject);; var param = {
                recordId : recordId,
                sObjectString : '[' + sObjectString + ']'    // This is just a single object
            }
            this.callServer(component,'c.UpsertRecord',function(response){
                console.log(response);
                if(callback)
                {
                    callback(response);
                }
            },param);


        }
    },

    // This renews existing data from existing schema
    renewFromSchema:function(component,callback)
    {

        var sObjectType = component.get('v.sObjectType');
        var scope = component.get('v.scope');
        this.populateFieldTypes(component,scope[sObjectType],true );
        callback(scope);
    },

    getPrimaryScope:function(scope)
    {
        for(var key in scope)
        {
            // keyname
            if(scope[key]['options']!=undefined)
            {
                if(scope[key]['options'].isPrimary == true)
                {
                    return scope[key];
                }
            }
        }
    },
    // This is used to receive the raw data from the server with the forms information and produce a scope object
    // Note the data should be serialised string, and will a JSON.parse will be called on it
    initialiseRecordScope:function(component,data)
    {

        var recordId = component.get('v.recordId');
        var sObjectType = component.get('v.sObjectType');
        var fieldList = component.get('v.fieldList');
        var additionalFields = component.get('v.additionalFields');
        var mode = component.get('v.mode');
        var showEditButtons = component.get('v.showEditButtons');
        // Create validity object for the object scope
        var validity = {};


        // setup new scope object
        var scope = this.setupScopeData(component,data,validity);
        this.setupFormScope(component,scope,recordId,sObjectType,mode,validity,showEditButtons);
        return scope;
    },

    // Not used - this was an attempt iterate through visible mark up
    traverseInitiateMarkup:function(body, markupName, setObject,attributeName){

        if(body!=null && body != undefined)
        {
            for(var i = 0; i < body.length;i++)
            {
                if(body[i].isInstanceOf(markupName)) // dc todo = will need to get the correct namespace here.
                {
                    body[i].getReference('v.' + attributeName).set(setObject);
                    body[i].set("v.loaded",true);  // need to generilize this
                }
                else
                {

                    this.traverseInitiateMarkup(body[i].get('v.body'),markupName,setObject,attributeName);
                }
            }
        }


    },

    stitchFields:function(schema)
    {
        var newDataStructure = {};
        for(var fieldName in schema)
        {
            newDataStructure[fieldName] = this.setType(schema[fieldName].Type)
        }
        return newDataStructure;
    },
 // This method converts a lowercase field name, to and Title case field name used
    toSObjectFieldCase:function(str){
        str = str.replace(/([a-z])/, function(a, l) { return l.toUpperCase(); });
        str = str.replace(/_([a-z])/gi, function(a, l) { return '_'+l.toUpperCase(); });
        str = str.replace(/\.([a-z])/gi, function(a, l) { return '.'+l.toUpperCase(); });
        str = str.replace(/(__C|__R)/, function(a, l) { return l.toLowerCase(); });
        return str;
    },

    setupFormScope:function(component,scope,recordId,sObjectType,mode,validity,showEditButtons)
    {
        scope['recordId'] = recordId;
        scope['sObjectType'] = sObjectType;
        scope['mode'] = mode;
        scope['layoutClass'] = "slds-col--padded slds-size--1-of-1 slds-medium-size--1-of-2 slds-large-size--1-of-2";
        scope['validity'] = validity;
        scope['showEditButtons'] = showEditButtons;
        component.set('v.busy',false);
    },
     // This sets up the each sub scopes with required fields and data
     setupScopeData:function(component,data,validity)
     {
         data = JSON.parse(data);
         var generic = [];

         if(typeof(data!='undefined') && data!=null)
         {

          var newScope = {};
          // there may be existing data on the scope
          this.assignExistingScopeData(component,newScope);

          var debounceTimeout = component.get('v.debounceTimeout');
          var updateBoundFieldsOn = component.get('v.updateBoundFieldsOn');
          var mode = component.get('v.mode');
          var showEditButtons = component.get('v.showEditButtons');
          // iterate through each of the objects and assign to scope
          for(var key in data)
          {

             newScope[key] = data[key];
             //this.populateFieldTypes(component,newScope[key]);

            // This needs to be created here - do not move.  The reasons being is that the newScope[key] is assigned to a param of a function, security is added to the objects properties that are pased to a function
            // and any further changes wil change all the binding of the object.
            var inlineNamedFunc = {
                      populateFieldTypes: function(all)
                           {
                               // loop through each of the schema fields and check if they exist within the data.  If they do not exist create the object dynamically.
                               // Also we need to check that the default values are set for the correct data type - either binding will not work
                               var tmpData = {}
                               // If the data does not exist create it
                               if(newScope[key].d==null || newScope[key].d == undefined)
                               {
                                   newScope[key]['d'] = {};
                               }
                               if(newScope[key].s != undefined && newScope[key].d != undefined)
                               {
                                   if( newScope[key].s != 'custom')
                                   {
                                       for(var schemaKey in newScope[key].s)
                                       {
                                           // check if the keyExists in the data scope
                                              // check if the name of the field is mulit level field name i.e. contains a '.'
                                              if(newScope[key].s[schemaKey].fullName.indexOf('.') > -1)
                                              {

                                                  var fieldParts = newScope[key].s[schemaKey].fullName.split('.');
                                                  var indexCount = fieldParts.length;

                                                  if(newScope[key].d[fieldParts[0]]==undefined)
                                                  {
                                                      newScope[key].d[fieldParts[0]] = {};
                                                  }
                                                  var tmpObject = newScope[key].d[fieldParts[0]] ;


                                                  var pCount = 1;

                                                  for(var i = 1; i <= indexCount-1; i++)
                                                  {

                                                      var t = tmpObject[fieldParts[i]];
                                                      if(t == undefined || t == null)
                                                      {
                                                          // is this the last field
                                                          if(i==indexCount-1)
                                                          {
                                                              tmpObject[fieldParts[i]] = this.setType(newScope[key].s[schemaKey].Type);

                                                          }else{
                                                                 tmpObject[fieldParts[i]] = {}; // just create the object for the next field name
                                                          }
                                                      }else{
                                                          if(i==indexCount-1)
                                                          {
                                                               if(all==true)
                                                               {
                                                                  tmpObject[fieldParts[i]] = this.setType(newScope[key].s[schemaKey].Type);
                                                               }

                                                               // check the value here

                                                               console.log(tmpObject[fieldParts[i]]);


                                                          }else{
                                                              tmpObject = t;
                                                          }
                                                      }
                                                      pCount++;
                                                      // change the fieldPartName to the last field part name
                                                  }
                                              }else{
                                                  if(newScope[key].d[newScope[key].s[schemaKey].fullName]== undefined)
                                                  {
                                                   //    field does not exist create the field

                                                      newScope[key].d[newScope[key].s[schemaKey].fullName] = this.setType(newScope[key].s[schemaKey].Type);
                                                  }else{
                                                      if(all==true)
                                                      {
                                                          newScope[key].d[newScope[key].s[schemaKey].fullName] = this.setType(newScope[key].s[schemaKey].Type);
                                                      }
                                                  }
                                              }
                                       }
                                   }
                               }
                           },
                           setType:function(typeName)
                           {
                               switch(typeName)
                               {
                                   case 'text':{
                                       return '';
                                       break;
                                       }
                                   case 'currency':
                                   {
                                       return 0;
                                       break;
                                   }
                                   case 'date':{
                                       return new Date();
                                       break;
                                   }
                                   case 'number':{
                                       return  0;
                                       break;
                                   }
                                   case 'percentage':{
                                       return 0;
                                       break;
                                   }
                                   case 'datetime':{
                                       return new Date();
                                       break;
                                   }
                                   case 'boolean':{
                                       return false;
                                       break;
                                       }
                                   default: return '';

                               }
                           },
                  }

             generic.push(newScope[key]);
             inlineNamedFunc.populateFieldTypes();
             newScope[key]['loaded'] = true;
             newScope[key]['debounceTimeout'] = debounceTimeout;
             newScope[key]['updateBoundFieldsOn'] = updateBoundFieldsOn;
             newScope[key]['validity'] = [];
             newScope[key]['mode'] = mode;//
             newScope[key]['internalStyle'] = 'slds-col--padded slds-size--1-of-1 slds-medium-size--1-of-2 slds-large-size--1-of-1';
             newScope[key]['dirty'] = {};
             newScope[key]['showEditButtons'] = showEditButtons;
             validity[key] = newScope[key]['validity']; // Make the validity available on the main form src object - This object may keep destroy componnets validity objects




          }
          newScope['loaded'] = true;
          component.set('v.generic',generic);
          component.set("v.loaded", true);

         }
         return newScope
     },
     // If the form currently has scope data - keep it and assign it to the new scope object
     assignExistingScopeData:function(component, newScope)
     {
         var scope = component.get("v.scope");
         if(scope!=null && scope!=undefined)
         {
             for(var key in scope)
             {
                 newScope[key] = scope[key];
             }
         }
         return newScope;
     },

     populateFieldTypes:function(component,scope,all)
     {
         // loop through each of the schema fields and check if they exist within the data.  If they do not exist create the object dynamically.
         // Also we need to check that the default values are set for the correct data type - either binding will not work
         var tmpData = {}
         if(scope.s != undefined && scope.d != undefined)
         {
             if(scope.s != 'custom')
             {
                 for(var schemaKey in scope.s)
                 {
                     // check if the keyExists in the data scope
                        // check if the name of the field is mulit level field name i.e. contains a '.'
                        if(scope.s[schemaKey].fullName.indexOf('.') > -1)
                        {
                            // dc todo

                            var fieldParts = scope.s[schemaKey].fullName.split('.');
                            var indexCount = fieldParts.length;

                            if(scope.d[fieldParts[0]]==undefined)
                            {
                                scope.d[fieldParts[0]] = {};
                            }
                            var tmpObject = scope.d[fieldParts[0]] ;

                            var pCount = 1;
                            for(var i = 1; i <= indexCount-1; i++)
                            {

                                var t = tmpObject[fieldParts[i]];
                                if(t == undefined || t == null)
                                {
                                    // is this the last field
                                    if(i==indexCount-1)
                                    {
                                        tmpObject[fieldParts[i]] = this.setType(scope.s[schemaKey].Type);

                                    }else{
                                        tmpObject[fieldParts[i]] = {}; // just create the object for the next field name
                                    }
                                }else{
                                    if(i==indexCount-1)
                                    {
                                         if(all==true)
                                         {
                                            tmpObject[fieldParts[i]] = this.setType(scope.s[schemaKey].Type);
                                         }

                                         // check the value here
                                         console.log(tmpObject[fieldParts[i]]);


                                    }else{
                                        tmpObject = t;
                                    }
                                }
                                pCount++;
                                // change the fieldPartName to the last field part name
                            }
                        }else{
                            if(scope.d[scope.s[schemaKey].fullName]== undefined)
                            {
                             //    field does not exist create the field

                                scope.d[scope.s[schemaKey].fullName] = this.setType(scope.s[schemaKey].Type);
                            }else{
                                if(all==true)
                                {
                                    scope.d[scope.s[schemaKey].fullName] = this.setType(scope.s[schemaKey].Type);
                                }
                            }
                        }
                 }
             }
         }
     },
     setType:function(typeName)
     {
         switch(typeName)
         {
             case 'text':{
                 return '';
                 break;
                 }
             case 'currency':
             {
                 return 0;
                 break;
             }
             case 'date':{
                 return new Date();
                 break;
             }
             case 'number':{
                 return  0;
                 break;
             }
             case 'percentage':{
                 return 0;
                 break;
             }
             case 'datetime':{
                 return new Date();
                 break;
             }
             case 'boolean':{
                 return false;
                 break;
                 }
             default: return '';

         }
     },
     getType:function(obj)
     {
        var constructor = obj.constructor;
        if(constructor == Date)
            return 'date';
        if(constructor == Number)
            return 'number';
        if(constructor == String)
            return 'string';
    },


})