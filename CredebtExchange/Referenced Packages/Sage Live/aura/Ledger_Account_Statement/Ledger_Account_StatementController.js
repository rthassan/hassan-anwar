({
    doInit : function(component, event, helper)
    {
        helper.init(component, event, helper);
    },
    handleChangeForm : function(component, event, helper)
    {
        // to stop the table being rendered with the tag or dims is changed to -1
        if (event.getParams().expression == "v.tagId" && component.get("v.tagId") == "-1")
            return;
        if (event.getParams().expression == "v.dimId" && component.get("v.dimId") == "-1")
            return;

         // if the event is the top level parameters then reset the additional parameters
         if (event.getParams().expression == "v.ledgerAccountId")
         {
            component.set("v.tagId","-1");
            component.set("v.dimId","-1");
         }

        var ledgerAccountId = component.get('v.ledgerAccountId');
        var year = component.get('v.year');
        var periodFrom = component.get('v.periodFrom');
        var periodTo = component.get('v.periodTo');
        if (ledgerAccountId != "-1" && year != "-1" && periodFrom != "-1" && periodTo != "-1")
        {
            helper.renderTagAndResetPagination(component, event, helper);
            // don't refresh the dimlist if the event was from tag or periods select
            if (event.getParams().expression == "v.ledgerAccountId" || (event.getParams().expression == "v.periodTo" && event.getParams().oldValue == "-1") )
            {
                helper.populateDimList(component, event, helper, ledgerAccountId, year, periodFrom, periodTo);
            }
        }

    },
    changedYearSelectList : function(component, event, helper)
    {
        var val = component.get('v.year');
        if (val == '-1')
        {
            component.set("v.table",null);
            component.set("v.periodFrom",-1);
            component.set("v.periodTo",-1);
            var periodLists = ["periodSelectListFrom","periodSelectListTo"];
            for (i = 0; i < periodLists.length; i++)
            {
                // reset the periods list
                var periodList = component.find(periodLists[i]);
                if (periodList.isValid())
                {
                    periodList.set('v.body', []); // clear all options
                    var body = periodList.get('v.body');
                    $A.createComponent(
                                        'aura:html',
                                        {
                                            tag: 'option',
                                            HTMLAttributes: {
                                                value: -1,
                                                text: $A.get("$Label.s2cor.Select_Year_to_view_Periods")
                                            }
                                        },
                                        function (newOption) {
                                            //Add options to the body
                                            if (newOption.isValid()) {
                                                body.push(newOption);
                                                periodList.set('v.body', body);
                                            }
                                        });
                }

            }


        }
    },
    handleChangeYear : function(component, event, helper)
    {
        component.set("v.table",null);
        var year = component.get('v.year');
        // reset the tag parameters
        component.set("v.dimId","-1");
        component.set("v.tagId","-1");
        component.set("v.showDimDrop",false);
        component.set("v.showTagDrop",false);
        // reset the period on year change
        component.set("v.periodFrom",-1);
        component.set("v.periodTo",-1);
        // always blank the table
        component.set("v.table",null);
        if (year != "-1")
        {
            helper.refreshPeriodsList(component, event, helper, "periodSelectListFrom", parseInt(year), null, null);
        }
    },
    handleChangeDimId : function(component, event, helper)
    {
        var ledgerAccountId = component.get('v.ledgerAccountId');
        var year = component.get('v.year');
        var periodFrom = component.get('v.periodFrom');
        var periodTo = component.get('v.periodTo');
        var dimId = component.get('v.dimId');

        if (dimId == "-1")
        {
            // change the tag select to -1
            var tagSelect = component.find("tagSelectList");
            if (tagSelect != null)
            {
                tagSelect.set("v.value",-1);
            }
        }
        else
        {
            helper.populateTagList(component, event, helper, ledgerAccountId, dimId, year, periodFrom, periodTo);
        }
    },
    changePage : function (component, event, helper)
    {
        //Protect against calling this twice before the first has finished
        var loading = component.get("v.loadingTable");
        if (loading)
            return;
        helper.renderTable(component, event, helper, false);
    },
    exportToCsv : function (component, event, helper)
    {
        helper.renderTable(component, event, helper, true);
    },
    resetTagFilter : function (component, event, helper)
    {
        var dimSelect = component.find("dimensionSelectList");
        var tagSelect = component.find("tagSelectList");
        if (dimSelect != null && tagSelect != null)
        {
           dimSelect.set("v.value",-1);
           tagSelect.set("v.value",-1);
           helper.renderTagAndResetPagination(component, event, helper);
        }
    }
})