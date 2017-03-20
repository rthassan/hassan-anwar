// Copyright (c) 2016. Sage Global Services Limited. All rights reserved.

({
    doInit: function (component, helper) {

        component.set('v.loaded',false);
        component.set("v.loading", true);

        var schemaParams = {
            objectName: component.get('v.objectName')
        };

        if (component.get('v.objectDescribe') == null || component.get('v.objectDescribe') == undefined) {
            console.log('*******************   Null ********');
            helper.callServer(component,'c.getFieldsSchemaMap',function(response) {
                helper.getData(component, helper, response);
            },schemaParams,true)
        }
        else {
            helper.getData(component, helper, JSON.parse(component.get('v.objectDescribe')));
        }
    },

    getData: function (component, helper, objectDescribe) {
        var params = {
        objectName: component.get("v.objectName"),
        fields: component.get("v.fields"),
        filter: component.get("v.filter"),
        order: component.get("v.order"),
        recordsLimit: (component.get("v.recordsLimit") != undefined ? String(component.get("v.recordsLimit")) : null),
        filterByCompany: component.get("v.filterByCompany"),
        uid: component.get("v.UID"),
        fieldsSchemaMap: objectDescribe
        };
        if (component.get('v.paginate')){
            params['paginationOffset'] = (component.get('v.paginationOffset') != undefined ? String(component.get('v.paginationOffset')) : null);
            params['paginationLimit'] = (component.get('v.paginationLimit') != undefined ? String(component.get('v.paginationLimit')) : null);
        }
        helper.callServer(component,'c.getDataAndActions',function(response){
             if(typeof(response) !='undefined') {
                 response = JSON.parse(response);
                 if(typeof(response.data) !='undefined' && response.data !=null)
                 {
                      var table = response.data;
                      var columns = table.columns;
                      var columnCount = columns.length;

                      if (columnCount > 1 && component.elements != undefined) {
                          var clientWidth = component.elements[0].clientWidth;

                          //Hack: if the display of the table has change to stack - we should not be reducing the column number
                          //      we can't detect this change (because it's a CSS level effect) - but - when this happens the columnCount
                          //      is usually reduced to 2 - so - if we find the column column is reduced to 2 - then revert back to original
                          //      column count.
                          if (clientWidth > 0) {
                            var columnWidth = clientWidth / columnCount;
                            while (columnWidth < 150 && columnCount > 1) {
                              columnCount--;
                              columnWidth = clientWidth / columnCount;
                            }
                            if (columnCount <= 2) {
                                columnCount = columns.length;
                            }
                          }
                      }

                      var rowsDisplayed = component.get('v.rowsDisplayed');
                      var mobile = component.get('v.mobile');

                      component.set("v.columnsLimit", columnCount);
                      component.set("v.actions",response.actions);

                      if (mobile && rowsDisplayed > 0) {
                          var table = component.get('v.table');

                          //We will add the next page of records to the existing list
                          for (var i = 0; i < response.data.rows.length; i++) {
                              table.rows.push(response.data.rows[i]);
                          }

                          component.set('v.table', table);
                          component.set("v.rowsDisplayed", response.data.rows.length + rowsDisplayed);
                      } else {
                          if (!mobile) {
                              var columnWidths = component.get("v.columnWidths");
                              if (columnWidths != null && typeof(columnWidths) != undefined) {
                                  for (var i = 0; i < table.columns.length; i++) {
                                      var column = table.columns[i];
                                      var width = columnWidths.get(column.apiName);
                                      if (width != null && typeof(width) != undefined) {
                                          column.width = width;
                                      }
                                  }
                              }
                          }

                          component.set("v.table", table);
                          component.set("v.rowsDisplayed", response.data.rows.length);
                      }

                      if (response.data.fullRowCount != null) {
                          component.set('v.rowCount', response.data.fullRowCount);
                      }
                      if (window.location.href.includes('flexipageEditor')) {
                          component.set('v.rowCount',1);
                      }
                      component.set("v.loading", false);
                      component.set('v.loaded',true);
                 }
             }

        },params,null,null,true);
    }
})