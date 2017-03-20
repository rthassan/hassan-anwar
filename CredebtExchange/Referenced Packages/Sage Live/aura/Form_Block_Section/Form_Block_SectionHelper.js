/**
 * Created by daniel.colquhoun on 29/11/2016.
 */
({
    applyGridStyles:function(component,event, gridStyle)
    {
        var body = component.get('v.body');
        var cssGridStyle = '';
        var sml11med11lrg11 = 'slds-p-horizontal--small slds-size--1-of-1 slds-medium-size--1-of-1 slds-large-size--1-of-1';
        var sml11med12lrg12 = 'slds-p-horizontal--small slds-size--1-of-1 slds-medium-size--1-of-2 slds-large-size--1-of-2';
        var sml11med12lrg13 = 'slds-p-horizontal--small slds-size--1-of-1 slds-medium-size--1-of-2 slds-large-size--1-of-3';


        var gridStyleIndex = 0;
        switch(gridStyle)
        {
            case 'sml-1-1-med-1-1-lrg-1-1':{
                cssGridStyle = sml11med11lrg11;
                gridStyleIndex = 0;
                break;
            }
            case 'sml-1-1-med-1-2-lrg-1-2':{
                cssGridStyle = sml11med12lrg12;
                gridStyleIndex = 1;
                break;
            }
            case 'sml-1-1-med-1-2-lrg-1-3':{
                cssGridStyle = sml11med12lrg13;
                gridStyleIndex = 2;
                break;
            }
            default:{
                cssGridStyle = sml11med12lrg12;
                gridStyleIndex = 2;
                break;
            }
        }

        // set the current style index
        component.set('v.gridStyleIndex',gridStyleIndex);
        // attribute name to set
        var attributeName = 'internalStyle';
        // Traverse the body and apply the values to the Data Field element
        this.traverseBody(body,'s2cor:Data_Field',cssGridStyle,attributeName);
    },

    styleList:function()
    {
        return  [
                 'sml-1-1-med-1-1-lrg-1-1','sml-1-1-med-1-2-lrg-1-2','sml-1-1-med-1-2-lrg-1-3'
                ];
    },

    cycleList:function(records)
    {

        var cycleRecordList = [];
        var previous = null;
        var first = null;
        var last = null;
        for(var i in records)
        {
            var circObj = {
                next:null,
                object: records[i]
            }
            cycleRecordList.push(circObj);
            if(first == null)
            {
                first = circObj;
            }
            if(previous == null)
            {
                previous = circObj;
            }else{
                previous.next = circObj;
                previous = circObj;
            }
            last = circObj;
        }
        last.next = first;
        return cycleRecordList;

    },

    // This cannot traverse components that it cannot see
    traverseBody:function(body, markupName, setObject,attributeName)
    {

        if(body!=null && body != undefined)
        {
            for(var i = 0; i < body.length;i++)
            {
                if(body[i].isInstanceOf(markupName))
                {
                    body[i].getReference('v.' + attributeName).set(setObject);
                }
                else
                {
                   this.traverseBody(body[i].get('v.body'),markupName,setObject,attributeName);
                }
            }
        }


    },
})