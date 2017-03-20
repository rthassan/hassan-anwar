/**
 * Created by daniel.colquhoun on 13/12/2016.
 */
({
    doInit:function(component,event,helper){
            helper.initBind(component,helper);


            //        // Transaction form
            //
            //        var mode = component.get('v.mode');
            //
            //
            //
            //       // Example 1 - standard
            //      //  if the defaultGetRecord has been set to false then you would need  get the record yourself
            //       if(mode=='edit' || mode == 'view' || mode == 'inline-edit')
            //       {
            //           helper.getRecord(component,function(scope){
            //               // do not chain callServer requests to populate the scope
            //               // try and get all the data on the server first.
            //               component.set('v.scope',scope);
            //               component.set('v.loaded',true);
            //           });
            //           return;
            //       }
            //       if(mode=='edit' || mode == 'new')
            //       {
            //           helper.getNew(component,function(scope){
            //               component.set('v.scope',scope);
            //               component.set('v.loaded',true);
            //           });
            //           return;
            //       }
            //
            //       // Example 2 - recordWithOtherSObjects
            //       if(mode=='edit' || mode == 'view')
            //       {
            //           // get the data with a company list collection
            //           var recordId = component.get('v.recordId');
            //           var fieldList = component.get('v.fieldList');
            //           var sObjectType = component.get('v.sObjectType');
            //           var mode = component.get('v.mode');
            //           var param = {
            //                recordId : recordId == null || recordId == undefined ? '': recordId,
            //                fieldList : fieldList == null || fieldList == undefined ? '': fieldList
            //           }
            //           helper.callServer(component,"c.GetRecordWithCompnay",function(data)
            //           {
            //               // build the data structure
            //               var scope = helper.initialiseRecordScope(component,data,recordId,sObjectType,mode)
            //               component.set('v.scope',scope);
            //
            //           },param);
            //           return;
            //       }

                  // Example 3 - recordWithOtherSObjectsAndACustomObject
            //      if(mode=='edit' || mode == 'view')
            //      {
            //          // get the data with a company list collection
            //          var recordId = component.get('v.recordId');
            //          var fieldList = component.get('v.fieldList');
            //          var sObjectType = component.get('v.sObjectType');
            //          var mode = component.get('v.mode');
            //          var param = {
            //               recordId : recordId == null || recordId == undefined ? '': recordId,
            //               fieldList : fieldList == null || fieldList == undefined ? '': fieldList
            //          }
            //          helper.callServer(component,"c.GetRecordWithCompnayAndCustomObject",function(data)
            //          {
            //              // build the data structure
            //
            //              var scope = helper.initialiseRecordScope(component,data,recordId,sObjectType,mode)
            //              console.log(scope);
            //              component.set('v.scope',scope);
            //
            //          },param);
            //          return;
            //      }

    },
    // We should override the base controller version of this method as Salesforce says that this functionality may not be available in the future
    saveInlineEdit:function(component,event,helper)
    {
        helper.saveRecord(component);
    },
     // We should override the base controller version of this method as Salesforce says that this functionality may not be available in the future
    cancelInlineEditCont:function(component,event,helper)
    {
       helper.cancelEdit(component);
    }
})