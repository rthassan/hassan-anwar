/**
 * Created by dancolq on 17/08/2016.
 */
({
     doInit:function(component,event,helper){

        var param = {'recordId': 1};
         component.set("v.saving", false);
        helper.callServer(component,"c.GetRecord",function(transactionTable){
            console.log(transactionTable);
            if(typeof(transactionTable!='undefined') && transactionTable!=null)
            {
                if(transactionTable.rows.length>0)
                {
                    component.set("v.row", transactionTable.rows[0]);
//                    for(var fieldName in transactionTable.rows[0].fieldsMap)
//                    {
//
//                    }

                    component.set("v.loaded", true);
                }
            }

        },param);

     },
     toggleEditEvent:function(component,event)
     {
         var edit = component.get('v.edit');
         edit = edit == true?false:true;
         component.set('v.edit',edit);
     },

     saveRecord:function(component,event,helper)
     {
        component.set("v.saving", true);


        var record = {};
        var recordId;
        var dirtyFieldList = [];

        var row = component.get("v.row");
        for(var fieldName in row.fieldsMap)
        {
            // Create an object that matches the SObject field structure
            record[fieldName] = row.fieldsMap[fieldName].value;

            // Create a list of dirty fields
            console.log(row.fieldsMap[fieldName]);
            console.log(row.fieldsMap[fieldName].dirty);

            if(row.fieldsMap[fieldName].dirty===true && typeof(row.fieldsMap[fieldName].dirty)!= 'undefined')
            {
                console.log(fieldName);
                dirtyFieldList.push(fieldName);
            }
        }

        console.log('dirty field list ' + dirtyFieldList);
        var params = {
            'record': record,
            'recordId':row.recordId,
            'dirtyFieldList': dirtyFieldList
        };


        helper.callServer(component,'c.UpdateRecord',function(result){
           console.log('Result ' + result);
           component.set("v.saving", false);
        },params,false,function(ex){
          console.log('Exception ' + ex);
          component.set("v.saving", false);
});
     },
      saveRecords:function(component,event,helper)
      {
         component.set("v.saving", true);


         var record = {};
         var recordId;
         var dirtyFieldList = [];

         var row = component.get("v.row");
         for(var fieldName in row.fieldsMap)
         {
             // Create an object that matches the SObject field structure
             record[fieldName] = row.fieldsMap[fieldName].value;

             // Create a list of dirty fields
             console.log(row.fieldsMap[fieldName]);
             console.log(row.fieldsMap[fieldName].dirty);

             if(row.fieldsMap[fieldName].dirty===true && typeof(row.fieldsMap[fieldName].dirty)!= 'undefined')
             {
                 console.log(fieldName);
                 dirtyFieldList.push(fieldName);
             }
         }

        var records = {};
        var recordTypeAndId = 'Sage_INV_Trade_Document__c:' + row.recordId;
        records[recordTypeAndId] = record;

         console.log('dirty field list ' + dirtyFieldList);
         var params = {
             'records':records
         };


         helper.callServer(component,'c.UpdateRecords',function(result){
            console.log('Result ' + result);
            component.set("v.saving", false);
         },params,false,function(ex){
           console.log('Exception ' + ex);
           component.set("v.saving", false);
         });
          }
})