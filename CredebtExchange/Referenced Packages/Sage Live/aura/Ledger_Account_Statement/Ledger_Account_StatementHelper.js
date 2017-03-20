({
    init : function(component, event, helper)
    {

        helper.callServer(component,'c.doInitApex',function(response)
        {
            if (response != undefined || response != null)
            {
                // build select list in here for now
                if (response.ledgerAccountsList != null || response.ledgerAccountId == undefined)
                {
                    var paramLedgerId = (response.parameters != false ? response.parameters.ledgerAccountId  : null );
                    var cmp = component.find('ledgerAccountSelectList');
                    cmp.set('v.body', []); // clear all options
                    var body = cmp.get('v.body');

                    response.ledgerAccountsList.forEach(function (opt) {
                        $A.createComponent(
                            'aura:html',
                            {
                                tag: 'option',
                                HTMLAttributes: {
                                    value: opt.key,
                                    text: opt.value,
                                    selected: (paramLedgerId != null ? (opt.key == paramLedgerId ? 'selected' : '') : '')
                                }
                            },
                            function (newOption) {
                                //Add options to the body
                                if (newOption.isValid()) {
                                    body.push(newOption);
                                    cmp.set('v.body', body);
                                }
                            })
                    });
                }

                // years drop down
                if (response.yearsList != null || response.yearsList == undefined)
                {
                    var paramYear = (response.parameters != false ? response.parameters.year  : (response.currentFinancialYear != null ? response.currentFinancialYear : null));
                    var cmp = component.find('yearSelectList');
                    cmp.set('v.body', []); // clear all options
                    var body = cmp.get('v.body');

                    response.yearsList.forEach(function (opt) {
                        $A.createComponent(
                            'aura:html',
                            {
                                tag: 'option',
                                HTMLAttributes: {
                                    value: opt.key,
                                    text: opt.value,
                                    selected: (paramYear != null ? (opt.key == paramYear ? 'selected' : '') : '')
                                }
                            },
                            function (newOption) {
                                //Add options to the body
                                if (newOption.isValid())
                                {
                                    body.push(newOption);
                                    cmp.set('v.body', body);
                                }
                            })
                    });
                }
                if(typeof(response.breadcrumbs)!='undefined' && response.breadcrumbs != null)
                {
                    component.set('v.breadcrumbs',response.breadcrumbs);
                }
                // parameters handling
                if (response.parameters != false)
                {
                    helper.initParameters(component, event, helper, response.parameters);
                }
                else
                {
                    if (response.currentFinancialYear != null && response.currentPeriod != null)
                    {
                        // populate with current year and period
                        component.set("v.year",response.currentFinancialYear);
                        component.set("v.periodFrom",response.currentPeriod);
                        component.set("v.periodTo",response.currentPeriod);
                        helper.refreshPeriodsList(component, event, helper, "periodSelectListFrom", parseInt(response.currentFinancialYear), response.currentPeriod, response.currentPeriod);
                        component.set("v.table",null);
                        component.set('v.loaded',true);
                        component.set('v.loadingTable',false);
                    }
                }
            }
        },null);
    },
    initParameters : function(component, event, helper, parameters)
    {
        // set the parameters

        component.set("v.ledgerAccountId",parameters.ledgerAccountId);
        component.set("v.year",parameters.year);
        component.set("v.periodFrom",parameters.periodFrom);
        component.set("v.periodTo",parameters.periodTo);
        // render the periods now with the default value match
        helper.refreshPeriodsList(component, event, helper, "periodSelectListFrom", parseInt(parameters.year), parameters.periodFrom, parameters.periodTo);
        if (parameters.dimId != null)
            component.set("v.dimId",parameters.dimId);
        if (parameters.tagId != null)
            component.set("v.tagId",parameters.tagId);
    },
    renderTagAndResetPagination : function (component, event, helper)
    {
        // reset pagination when the changing a parameter
        component.set("v.paginationOffset",0);
        helper.renderTable(component, event, helper, false);
    },
    renderTable : function(component, event, helper, exportToCsv)
    {
        component.set('v.loadingTable',true);
        // get the form parameters
        var selectedLedgerAccountId = component.get("v.ledgerAccountId");
        var periodFrom = parseInt(component.get("v.periodFrom"));
        var periodTo = parseInt(component.get("v.periodTo"));
        var year = component.get("v.year");
        var tagId = component.get("v.tagId");
        tagId = (tagId == '-1' ? null : tagId);
        // pass the dimensions id, we don't use it for the query just to save in parameters
        var dimId = component.get("v.dimId");
        dimId = (dimId == '-1' ? null : dimId);
        var rowsDisplayed = component.get("v.rowsDisplayed");
        var paginationOffset = component.get('v.paginationOffset');
        var paginationLimit = component.get('v.paginationLimit');
        if (periodFrom > periodTo)
        {
            component.set("v.table",null);
            component.set('v.loaded',true);
            component.set('v.loadingTable',false);
        }
        else
        {
            var params = {
                           "ledgerAccountId": selectedLedgerAccountId,
                           "year": year,
                           "periodFrom": periodFrom,
                           "periodTo": periodTo,
                           "dimId": dimId,
                           "tagId": tagId,
                           "exportToCsv": exportToCsv
                        };

            params['paginationOffset'] = (paginationOffset != undefined ? String(paginationOffset) : null);
            params['paginationLimit'] = (paginationLimit != undefined ? String(paginationLimit) : null);

            helper.callServer(component,'c.getTable',function(response)
            {
                if (exportToCsv)
                {
                    component.set('v.loadingTable',false);
                    // if we are exporting to csv open the modal and populate the String header and value lists - don't refresh the full table
                    if(typeof(response.printHeader) !='undefined' && response.printHeader !=null && typeof(response.printRows) !='undefined' && response.printRows !=null)
                    {
                        helper.openExportModal(component, helper, response.printHeader, response.printRows);
                    }

                }
                else
                {
                    if(typeof(response.table) !='undefined' && response.table !=null)
                    {
                        var rowsDisplayed = component.get('v.rowsDisplayed');
                        component.set("v.table",response.table);
                        component.set("v.rowsDisplayed", response.table.rows.length + rowsDisplayed);
                        component.set("v.mobile",false);
                        component.set('v.loaded',true);
                        component.set('v.loadingTable',false);

                        var mobile = component.get('v.mobile');
                        // hack to remove the total rows from the rows.length
                        var dataRowCount = (response.table.rows.length - 2);

                        // removing opening row from all but first page
                        if (paginationOffset != 0)
                        {
                            // this removes the first row
                            response.table.rows.shift();
                        }

                        //remove the last row (closing balance) from all pages other than the last
                        if (response.table.fullRowCount > (paginationOffset * paginationLimit + dataRowCount))
                        {
                            // this removes the last row from the list
                            response.table.rows.pop();
                        }
                        component.set("v.rowsDisplayed", dataRowCount);

                        if (response.table.fullRowCount != null)
                        {
                          component.set('v.rowCount', response.table.fullRowCount);

                        }
                        component.set("v.table",response.table);
                    }
                    else
                    {
                        component.set("v.table",null);
                        component.set('v.loaded',true);
                        component.set('v.loadingTable',false);
                    }
                }
            },params);
        }
    },
    refreshPeriodsList : function(component, event, helper, selectListAuraId, year, defaultValueFrom, defaultValueTo)
    {
        var params = {
                        "year": parseInt(year)
                     };

        helper.setPeriodListToState(component, selectListAuraId ,'loading');
        helper.setPeriodListToState(component, 'periodSelectListTo' ,'loading');
        helper.callServer(component,'c.getPeriodsForYear',function(response)
        {
            if (response != null || response == undefined)
            {
                helper.populateSelectList(component,selectListAuraId,response,defaultValueFrom);
                helper.populateSelectList(component,"periodSelectListTo",response,defaultValueTo);
            }

        },params);
    },
    populateDimList : function(component, event, helper, ledgerAccountId, year, periodFrom, periodTo )
    {
        var params = {
                        "ledgerAccountId": ledgerAccountId,
                        "year": parseInt(year),
                        "periodFrom": parseInt(periodFrom),
                        "periodTo": parseInt(periodTo)
                     };
        component.set("v.showDimDrop",false);
        component.set("v.showTagDrop",false);

        helper.callServer(component,'c.getDims',function(response)
        {
            if (response != null || response == undefined)
            {
                if (response.length > 1)
                {
                    component.set("v.showDimDrop",true);
                    component.set("v.tagId",-1);
                    component.set("v.dimId",-1);
                    helper.populateSelectList(component,"dimensionSelectList",response,"-1");
                }
                else
                {
                    component.set("v.showDimDrop",false);
                    component.set("v.showTagDrop",false);
                    component.set("v.tagId",-1);
                    component.set("v.dimId",-1);
                }
            }
        },params);
    },
    populateTagList  : function(component, event, helper, ledgerAccountId, dimensionId, year, periodFrom, periodTo)
    {
        var params = {
                        "ledgerAccountId": ledgerAccountId,
                        "dimensionId": dimensionId,
                        "year": year,
                        "periodFrom": periodFrom,
                        "periodTo": periodTo
                     };

        helper.callServer(component,'c.getTags',function(response)
        {
            if (response != null || response == undefined)
            {
                if (response.length > 1)
                {
                    component.set("v.showTagDrop",true);
                    helper.populateSelectList(component,"tagSelectList",response,null);
                }
            }
        },params);

    },
    setPeriodListToState : function(component,selectListAuraId,theState)
    {
        var periodList = component.find(selectListAuraId);
        var label;
        if (theState == 'start')
        {
            label = $A.get("$Label.s2cor.Select_Year_to_view_Periods");
        }
        else if (theState == 'loading')
        {
            label = $A.get("$Label.s2cor.Loading_Periods");
        }

        if (periodList.isValid())
        {
            periodList.set('v.body', []); // clear all options
            var body = periodList.get('v.body');
            $A.createComponent(
                                'aura:html',
                                {
                                    tag: 'option',
                                    HTMLAttributes: {
                                        value: '-1',
                                        text: label
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
    },
    populateSelectList : function(component,targetListId,options,selectedValue)
    {
        var targetList = component.find(targetListId);
        if (targetList.isValid() && options != null)
        {
            targetList.set('v.body', []); // clear all options
            var body = targetList.get('v.body');

            options.forEach(function (opt) {
                $A.createComponent(
                    'aura:html',
                    {
                        tag: 'option',
                        HTMLAttributes: {
                            value: opt.key,
                            text: opt.value,
                            selected: (selectedValue != null ? (opt.key == selectedValue ? 'selected' : '') : '')
                        }
                    },
                    function (newOption) {
                        //Add options to the body
                        if (newOption.isValid())
                        {
                            body.push(newOption);
                            targetList.set('v.body', body);
                        }
                    });
            });
        }
    },
    openExportModal : function(component, helper, header, rows)
    {
        var params = [];
        params.push({"title":$A.get("$Label.s2cor.Export_To_Csv")});
        params.push({"header":header});
        params.push({"rows":rows});

        var openExportModalAction = {
            "type": "LightningComponent",
            "target": "s2cor:Action_Table_Export",
            "params": params,
            "modal": true
        };
        helper.executeAction(component, openExportModalAction, null, null, component.getGlobalId());
    }
})