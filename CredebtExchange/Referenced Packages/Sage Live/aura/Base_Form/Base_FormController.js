/**
 * Created by dancolq on 17/08/2016.
 */


({

    doInit:function(component,event,helper){

        helper.applyContext(component);
        var defaultGetRecord = component.get('v.defaultGetRecord');
        var defaultNewRecord = component.get('v.defaultNewRecord');
        var mode = component.get('v.mode');
         // If within  modal these attributes will be populated

        if(defaultGetRecord==true && mode != 'new')
        {
            console.log('Base Form - getRecord called')
            helper.getRecord(component,function(scope){
                component.set('v.scope',scope); // Set the data
                component.set('v.loaded',true);
            });
            return;
        }

        if(defaultNewRecord ==true && mode == 'new')
        {
             console.log('Base Form - getNew called')
            helper.getNew(component,function(scope){
                component.set('v.scope',scope); // Set the data
                component.set('v.loaded',true);
            });
            return;
        }

    },
    getNew:function(component,event,helper){
        helper.getNew(component,function(scope){
           component.set('v.scope',scope); // Set the data
        });
    },
    saveRecord:function(component,event,helper)
    {
        helper.saveRecord(component);

    },
    cancelInlineEditCont:function(component,event,helper)
    {
       helper.cancelEdit(component);
    },
    saveInlineEdit:function(component,event,helper)
    {
        helper.saveRecord(component);
    },
    handleAccept:function(component,event,helper)
    {

        helper.saveRecord(component);
    },
//    loadData:function()
//    // dc todo - check if loaddash js is compatible with lightning locker
//    oldInit:function(component,event,helper){
//        var recordId = component.get('v.recordId');
//        var sObjectType = component.get('v.sObjectType');
//        var param = {'recordId': 1};
//        // Get the form object
//        var form = component.get("v.form");
//        var autoConvertIdName = component.get('v.autoConvertIdName');
//        if(form==null)
//        {
//            form = {}
//        }
//        form['autoConvertIdName'] = autoConvertIdName;
//        form['recordId'] = recordId;
//        form['sObjectType'] = sObjectType;
//        form['loaded'] = false;
//        form['edit'] = component.get("v.edit");  // Set the default edit
//        form['inputClass']= component.get("v.inputClass");
//        form['validilty'] = {}; //  this object should be used to check the validity across all fields.  This means that if a field is valid and another field is depeneded on that validity - the second field
//                                //  can check if the first field is valid
//        form['dirtyfields'] = {};
//        form['reender'] = function()  // Experiment - may be able to use this to rerend the whole component from sub components - should be used sparingly!!
//        {
//            component.set("v.reRender",true);
//        }
//        component.set('v.form',form);
//
//
//
//
//        helper.callServer(component,"c.GetRecordSObject",function(data)
//        {
//            data = JSON.parse(data);
//            if(typeof(data!='undefined') && data!=null)
//            {
//
//                var form = component.get("v.form");
//
//                // automatically add aditional data to the form
//                for(key in data)
//                {
//                    if(key!='sobject' && key !='schema')
//                    {
//                        form[key] = data[key];
//                    }
//                }
//
//                form['sobjects'] = data.sobject;
//                form['sobject'] = data.sobject[0];
//                form['schema'] = data.schema;
//
//                form['loaded'] = true;
//                component.set('v.form',form);
//                component.set("v.loaded", true);
//
//            }
//
//        },param);
//
//     },
//
//    toggleEditEvent:function(component,event)
//    {
//        var edit = component.get('v.edit');
//        edit = edit == true?false:true;
//        component.set('v.edit',edit);
//
//        var form = component.get('v.form');
//        form.edit = edit;
//        component.set('v.form',form);
//        component.set('v.reRender',true);
//    },
//
//    saveRecord:function(component,event,helper)
//    {
//        component.set("v.saving", true);
//        var record = {};
//        var recordId;
//        var dirtyFieldList = [];
//        var row = component.get("v.row");
//
//        for(var fieldName in row.fieldsMap)
//        {
//            // Create an object that matches the SObject field structure
//            record[fieldName] = row.fieldsMap[fieldName].value;
//            // Create a list of dirty fields
//            console.log(row.fieldsMap[fieldName]);
//            console.log(row.fieldsMap[fieldName].dirty);
//
//            if(row.fieldsMap[fieldName].dirty===true && typeof(row.fieldsMap[fieldName].dirty)!= 'undefined')
//            {
//                console.log(fieldName);
//                dirtyFieldList.push(fieldName);
//            }
//        }
//
//        console.log('dirty field list ' + dirtyFieldList);
//        var params = {
//            'record': record,
//            'recordId':row.recordId,
//            'dirtyFieldList': dirtyFieldList
//        };
//
//
//        helper.callServer(component,'c.UpdateRecord',function(result){
//            console.log('Result ' + result);
//            component.set("v.saving", false);
//        },params,false,function(ex){
//            console.log('Exception ' + ex);
//            component.set("v.saving", false);
//        });
//    },
//
//    saveRecords:function(component,event,helper)
//    {
//        component.set("v.saving", true);
//
//
//        var record = {};
//        var recordId;
//        var dirtyFieldList = [];
//
//        var row = component.get("v.row");
//        for(var fieldName in row.fieldsMap)
//        {
//            // Create an object that matches the SObject field structure
//            record[fieldName] = row.fieldsMap[fieldName].value;
//
//            // Create a list of dirty fields
//            console.log(row.fieldsMap[fieldName]);
//            console.log(row.fieldsMap[fieldName].dirty);
//
//            if(row.fieldsMap[fieldName].dirty===true && typeof(row.fieldsMap[fieldName].dirty)!= 'undefined')
//            {
//             console.log(fieldName);
//             dirtyFieldList.push(fieldName);
//            }
//        }
//
//        var records = {};
//        var recordTypeAndId = 'Sage_INV_Trade_Document__c:' + row.recordId;
//        records[recordTypeAndId] = record;
//
//        console.log('dirty field list ' + dirtyFieldList);
//        var params = {
//         'records':records
//        };
//
//
//        helper.callServer(component,'c.UpdateRecords',function(result){
//        console.log('Result ' + result);
//        component.set("v.saving", false);
//        },params,false,function(ex){
//        console.log('Exception ' + ex);
//        component.set("v.saving", false);
//        });
//    }
})