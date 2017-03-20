({
    // this method is used to load all the data in one go
    init:function(component)
    {
        component.set('v.loaded',false);
        if (component.get('v.listView') == null) {
            return;
        }

        var params = {"sObjectType" : component.get('v.SObjectType'),
                     "UID" : component.get('v.UID'),
                     "listView" : component.get('v.listView'),
                     "recordId" : component.get('v.recordId'),
                     "type" : component.get('v.type')};

        this.callServer(component,'c.init', function(response)
        {
            if(typeof(response) !='undefined') {
                response = JSON.parse(response);
                if(typeof(response.breadcrumbs)!='undefined' && response.breadcrumbs != null)
                {
                   component.set('v.breadcrumbs',response.breadcrumbs);
                }
                if(typeof(response.listViews)!='undefined' && response.listViews != null)
                {
                    component.set('v.listViews',response.listViews);
                    var listView = '';
                    var listViewDescribe = this.findSelectedListView(component, response.listViews);
                    if ((listViewDescribe == null) || (typeof(listViewDescribe) == 'undefined')) {
                        listView = 'All';
                    } else {
                        listView = listViewDescribe.label;
                    }

                    if(typeof(response.relatedListFilter)!='undefined' && response.relatedListFilter != null)
                    {
                       component.set('v.relatedListFilter',response.relatedListFilter);
                    }

                    this.setNewListView(component,listView);
                }

                if(typeof(response.viewAll)!='undefined' && response.viewAll != null)
                {
                   component.set('v.viewAll',response.viewAll);
                }
                if(typeof(response.uiTheme)!='undefined' && response.uiTheme != null)
                {
                    component.set('v.mobile', response.uiTheme === "Theme4t");
                }
                if(typeof(response.buttons)!='undefined' && response.buttons != null)
                {
                   var mobile = component.get('v.mobile');

                   if (mobile) {
                       var buttons = [];
                        //Filter out buttons that are not global
                        for (var i = 0; i < response.buttons.length; i++) {
                            var button = response.buttons[i];
                            if (button.context === "Global") {
                               buttons.push(button);
                            }
                        }
                        component.set('v.buttons',buttons);
                     } else {
                        component.set('v.buttons',response.buttons);
                   }
                }
            }
            component.set('v.loaded',true);

        },params,null,function(error)
        {
            console.log('Error ' + error);
        },true);
    },
    getBreadcrumbs : function(component)
    {
        var params = {"objectType" : component.get('v.SObjectType'),
                             "UID" : component.get('v.UID')};

        this.callServer(component,'c.getBreadcrumbs', function(response)
            {
                component.set('v.breadcrumbs',response);

            },
        params,true,function(error)
            {
                  console.log('Error ' + error);
            });
    },
    getBreadcrumbsNoCache : function(component)
    {
         var params = {"objectType" : component.get('v.SObjectType'),
                       "UID" : component.get('v.UID')};

        this.callServer(component,'c.getBreadcrumbs', function(response)
        {
            component.set('v.breadcrumbs',response);

        },params,null,function(error)
        {
            console.log('Error ' + error);
        });
    },
    getViewAll : function(component)
    {
        var params = {"objectType" : component.get('v.SObjectType'),
                     "UID" : component.get('v.UID'),
                     "listView" : component.get('v.listView')};

        this.callServer(component,'c.getViewAll', function(response) {
            component.set('v.viewAll',response);

        },params,true,function(error) {
            console.log('Error ' + error);
        });
    },
    setNewListView : function(component, selectedOption)
    {
      var listviews = component.get('v.listViews');

      if (listviews != null)
      {
            var listView = null;
            try
            {
                listView = listviews.descriptions[selectedOption];
            }
            catch(err)
            {
                listView = listviews.descriptions[0];
            }

            if (listView != null && typeof(listView) != 'undefined') ///  *************  Fix bug
            {
                if(listView.describe!=null && typeof(listView.describe!='undefined')) /// **** fixing undefined.toString()
                {

                    if(listView.describe.FIELDS!=null && typeof(listView.describe.FIELDS)!='undefined')
                    {
                        var fields = listView.describe.FIELDS.toString();
                        component.set('v.listViewFields',fields);
                    }

                    if(listView.describe.ORDERBY!=null && typeof(listView.describe.ORDERBY)!='undefined')
                    {
                        var order = listView.describe.ORDERBY.toString();
                        component.set('v.listViewOrder',order);
                    } else {
                        component.set('v.listViewOrder', null);
                    }

                    if (listView.describe.WIDTHS!=null && typeof(listView.describe.WIDTHS)!='undefined')
                    {
                        var widths = listView.describe.WIDTHS.toString();
                        var columnWidths = this.parseColumnWidths(widths);
                        component.set('v.listViewColumnWidths', columnWidths);
                    } else {
                        component.set('v.listViewColumnWidths', null);
                    }

                    if(listView.describe.PAGINATIONLIMIT!=null && typeof(listView.describe.PAGINATIONLIMIT)!='undefined')
                    {
                        var paginationLimit = listView.describe.PAGINATIONLIMIT.toString();
                        component.set('v.paginationLimit',parseInt(paginationLimit));
                    } else {
                        component.set('v.paginationLimit', 20);
                    }

                    if(listView.describe.WHERE!=null && typeof(listView.describe.WHERE)!='undefined')
                    {
                        var filter = listView.describe.WHERE.toString();
                        if (component.get('v.relatedListFilter') != '' && component.get('v.relatedListFilter') != undefined)
                        {
                            if (filter == null || filter == '')
                            {
                              filter = component.get('v.relatedListFilter');
                            }
                            else
                            {
                              filter = filter + ' AND ' + component.get('v.relatedListFilter');
                            }
                        }
                        component.set('v.listViewFilter',filter);
                    }
                    if (listView.describe.objectDescribe != null && typeof(listView.describe.objectDescribe) != 'undefined')
                    {
                        component.set('v.listViewObjectDescribe', listView.describe.objectDescribe);
                    }

                    if(listView.describe.ACTIONS !=null && typeof(listView.describe.ACTIONS)!='undefined')
                    {
                        component.set('v.listViewSetupActions', listView.describe.ACTIONS);
                    } else {
                        component.set('v.listViewSetupActions', null);
                    }
                }
                if (component.get('v.headerStyle') == 'narrow' && (component.get('v.title') == '' || component.get('v.title') == undefined)) {
                    component.set('v.title',listView.objectPluralName + ' - ' + listView.label);
                }

                if (component.get('v.title') == '' || component.get('v.title') == undefined ) {
                    component.set('v.title',listView.label);
                }
            }
      }

      //We are changing the list - so we need to reset the paginationOffset - so it will retrieve records from the first page (not whatever page the last query was on)
      component.set('v.paginationOffset', 0);

        var mobile = component.get('v.mobile');
        if (mobile) {
            //When we change the list we need to initialize the rowsDisplayed - so the rows will be reset (and not just appended to)
            component.set('v.rowsDisplayed', 0);
        }
        try{

            var appEvent = $A.get("e.s2cor:Event_Refresh_Data_Tables");
            appEvent.setParam('innerListViewId',component.getGlobalId());
            appEvent.fire();
        }
        catch(err)
        {
            console.log('Error firing Event_Refresh_Data_Tables ' + err.message);
        }


    },

    getButtons : function(component)
    {
       var params = {"objectType" : component.get('v.SObjectType'),
                     "UID" : component.get('v.UID')};

      this.callServer(component,'c.getButtons', function(response)
      {
          component.set('v.buttons',response);

      },params,true,function(error)
      {
          console.log('Error ' + error);
      });
    },


    handleCustomSetting : function(component) {
        component.set('v.loaded',false);
        //console.log('DN: Full_List_View.handleCustomSetting()');
        var listView = component.get('v.listView');
        //console.log('mm ' + component.get('v.SObjectType'));
        if (component.get('v.SObjectType') != null ){
            var params = {"sObjectType" : component.get('v.SObjectType'),
                                         "UID" : component.get('v.UID')};
            if (listView == null) {
                //console.log('getting');
                this.callServer(component,'c.getListView', function(response) {
                    //console.log('DN: Full_List_View.handleCustomSetting() getter response: ' + response);
                    component.set('v.listView',response);
                    component.set('v.title', '');
                     component.set('v.loaded',true);
                },params,null,function(error) {
                    //console.log('Error ' + error);
                });
            }
            else {
                params["listView"] = listView;
                //console.log('setting to ' + listView );
                this.callServer(component,'c.setListView', function(response) {
                        //console.log('DN: Full_List_View.handleCustomSetting() setter response');
                        //$A.get('e.force:refreshView').fire();
                         component.set('v.loaded',true);
                    },
                    params,null,function(error) {
                        //console.log('Error ' + error);
                    });
            }
        }else{
//             component.set('v.loaded',true);
        }
    },
    handleChangeColumnWidth: function(component, event) {
        if (component.get('v.headerStyle') == 'narrow') {
            //Do not save widths for the narrow list view (i.e. the Related List View)
            return;
        }

        var column = event.getParam('column');
        var columnWidths = component.get('v.listViewColumnWidths');
        if (columnWidths == null || typeof(columnWidths) == 'undefined') {
            columnWidths = new Map();
        }

        columnWidths.set(column.apiName, column.width);
        component.set('v.listViewColumnWidths', columnWidths);

        var listViews = component.get('v.listViews');
        var listView = this.findSelectedListView(component, listViews);

       if ((listView == null) || (typeof(listView) == 'undefined')) {
            //The current list has not been found - should never happen - but if it does, we cannot save the change
            return;
        }

        this.persistListViewOptions(component, listViews, listView, null);
    },
    handleChangeSortColumn: function(component, event) {
        var column = event.getParam('column');
        var order = column.apiName;
        if (column.isSortedDesc) {
            order = order + ' DESC';
        } else {
            order = order + ' ASC';
        }

        var listViews = component.get('v.listViews');
        var listView = this.findSelectedListView(component, listViews);

        component.set('v.listViewOrder', order);

        if ((listView == null) || (typeof(listView) == 'undefined')) {
            //The current list has not been found - should never happen - but if it does, we cannot save the change
            this.refreshDataTable(component);
            return;
        }

        this.persistListViewOptions(component, listViews, listView, function() {
            this.refreshDataTable(component);
        });
    },
    handleChangePageLimit : function (component, event) {
        var limit = event.getParam('paginationLimit');
        if (!isNaN(limit) && limit > 0) {
            component.set('v.paginationLimit', limit);
            var listViews = component.get('v.listViews');
            var listView = this.findSelectedListView(component, listViews);
            this.persistListViewOptions(component, listViews, listView, function() {
                this.refreshDataTable(component);
            });
        }
    },
    refreshDataTable: function(component) {
        component.set('v.paginationOffset', 0);

        try{
            var appEvent = $A.get("e.s2cor:Event_Refresh_Data_Tables");
            appEvent.setParam('innerListViewId',component.getGlobalId());
            appEvent.fire();
        }
        catch(err)
        {
            console.log('Error firing Event_Refresh_Data_Tables ' + err.message);
        }
    },
    findSelectedListView: function(component, listViews) {
        var listViewTitle = component.get('v.listView');

        if ((listViewTitle == null) || (typeof(listViewTitle) == 'undefined') || (listViews == null) || (typeof(listViews) == 'undefined')) {
            return null;
        }

        var listView = null;
        try
        {
            listView = listViews.descriptions[listViewTitle];
        }
        catch(err)
        {
            listView = listViews.descriptions[listViews.labels[0]];
        }

        if ((listView == null) || (typeof(listView) == 'undefined')) {
            var descriptions = listViews.descriptions;
            for(var lv in descriptions) {
                if (descriptions[lv].developerName == listViewTitle || descriptions[lv].label == listViewTitle || descriptions[lv].name == listViewTitle) {
                    listView = descriptions[lv];
                    break;
                }
            }
        }

        if ((listView == null) || (typeof(listView) == 'undefined')) {
            var descriptions = listViews.descriptions;
            for(var lv in descriptions) {
                if (descriptions[lv].developerName.includes('All') || descriptions[lv].label.includes('All') || descriptions[lv].name.includes('All')) {
                    listView = descriptions[lv];
                    break;
                }
            }
        }

        return listView;
    },
    parseColumnWidths : function(widths) {
        var columnWidths = new Map();
        if (widths == null || typeof(widths) == 'undefined' || widths.length == 0) {
            return columnWidths;
        }

        var columns = widths.split(',');
        for (var i = 0; i < columns.length; i++) {
            var column = columns[i];
            var def = column.trim();
            var parts = def.split(' ');
            if (parts.length == 2) {
                columnWidths.set(parts[0], parseInt(parts[1]));
            }
        }

        return columnWidths;
    },
    serializeColumnWidths: function(component) {
        var widths = component.get('v.listViewColumnWidths');
        if (widths == null || typeof(widths) == 'undefined' || widths.size == 0) {
            return '';
        }

        var columnWidths = '';
        widths.forEach(function (value, key) {
            if (columnWidths.length > 0) {
                 columnWidths = columnWidths + ', ';
             }
             columnWidths = columnWidths + key + ' ' + value;
        });

        return columnWidths;
    },
    persistListViewOptions: function(component, listViews, listView, callback) {
        var columnWidths = this.serializeColumnWidths(component);
        var order = component.get('v.listViewOrder');
        var paginationLimit = component.get("v.paginationLimit").toString();
        var objectType = component.get('v.SObjectType');
        var uid = component.get('v.UID');

        var params = {"listViewUID" : listView.developerName,
                      "order" : order,
                      "columnWidths" : columnWidths,
                      "paginationLimit" : paginationLimit,
                      "sObjectType" : objectType,
                      "UID" : uid
                      };

        this.callServer(component,'c.setListViewUserSettings', function()
            {
                if(callback) {
                    callback.call(this);
                }
             },
        params,null,function(error)
            {
                console.log('Error persisting list view options: ' + error);
            },
        true);
    },
})