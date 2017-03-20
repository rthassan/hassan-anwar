/**
 * Base Component Helper
 */
({
    /**
      * Queue action to call server method and handle response
      * @param {object} component - A reference to the component
      * @param {string} method - The apex method to call
      * @param {object} callback - The method to call on response
      * @param {object[]} params - List of parameters to pass to apex method - can be set null if no params are supplied
      * @param {boolean} cacheable - Call setStorable() on action - can be set to null if cacheable is not set.  Set to true if caching is set
      * @param {object} errorCallback - The method to call when an error occurs.
      */
    callServer : function(component,method,callback,params,cacheable,errorCallback,background) {

        var action = component.get(method);
        if (typeof(params) != 'undefined' && params !=null) {
            action.setParams(params);
        }
        if (typeof(cacheable)!='undefined' && cacheable !=null) {
            // Issue identified a check for true or false should be applied here as it is confusing if we just supply any object
            // These files will get the incorrect results
                // Post_TransactionController cache = false;
                // Delete_RecordController cache = false;
                // Clone_TransactionController cache = false;

            if(cacheable==true) {
               action.setStorable();
            }
        }
        if (background == true) {
            action.setBackground();
        }
        action.setCallback(this, function(response) {
            var state = response.getState();
            if (state === "SUCCESS") {
                // pass returned value to callback function
                callback.call(this, response.getReturnValue());
            } else if (state === "ERROR") {
                // generic error handler
                var errors = response.getError();
                if (errors) {
                    $A.log("Errors", errors);
                    var message = '';
                    for (var i = 0; i < errors.length; i++) {
                        if (errors[i] && errors[i].message) {
                            message += errors[i].message + ' <br \>';
                        }
                    }
                    if (errors[0] && errors[0].message) {
                        if(errorCallback)
                        {
                            errorCallback.call(this,errors[0].message);
                        }else{
                            throw "Call Server Error: " + errors[0].message;
                        }
                    }
                } else {
                    if(errorCallback)
                    {
                        errorCallback.call(this,"Unknown Error");
                    }else{
                        throw "Call Server Error: " +  "Unknown Error";
                    }
                }
            }
        });
        $A.enqueueAction(action);
    },
    /*
     * List of icon objects
     * @returns {object[]} - List of icon objects
     */
    icons : function() {
        var resourceBase = '/resource/slds204beta/assets/icons/';
        var resourcePaths = {'action' : resourceBase + 'action-sprite/svg/symbols.svg#',
                             'custom' : resourceBase + 'custom-sprite/svg/symbols.svg#',
                             'doctype' : resourceBase + 'doctype-sprite/svg/symbols.svg#',
                             'standard' : resourceBase + 'standard-sprite/svg/symbols.svg#',
                             'utility' : resourceBase + 'utility-sprite/svg/symbols.svg#'
                            }
        var iconList = [
            {'id' : 'back', 'resource': resourcePaths['action'] + 'back', 'type' : 'action'},
            {'id' : 'add',  'resource': resourcePaths['utility'] + 'add', 'type' : 'utility'}
        ]
        return iconList;
    },
    /*
     * Get icon object from list of icon objects
     * @param {string} iconID - ID of icon to retrieve
     * @returns {object} - Icon object
     */
    getIcon : function(iconID) {
        var iconList = this.icons;
        for(i = 0; i < iconList.length; i++)
        {
            if (iconList[i]['id'] == iconID) {
                return iconList[i];
            }
        }
    },

    /*
    * Execute Action from DTO
    * @param {object} actionDTO - Sage_COR_Action_DTO to execute
    */
    executeAction : function(component, actionDTO, recordId, recordIds, parentId) {
        if (actionDTO.type == 'VFPage' && actionDTO.target !== undefined) {

            // Navigate to VF Page.
            var visualforceNavigation = actionDTO.target;
            var paramList = [];
            // Optional: set some data for the navigation
            if (actionDTO.params != null && actionDTO.params !== undefined) {
                // iterate through attributes and set params on VisualForce navigation
                for (var i = 0; i < actionDTO.params.length; i++) {
                    var param = actionDTO.params[i];
                    for(var k in param) {
                        paramList.push(k +'='+ this.substituteActionParam(component, param[k]));
                    }
                }
            }
            if ((recordId !== undefined && recordId !== '' && recordId !== null)) {
                paramList.push('id='+recordId);
            }
            if ((recordIds !== undefined && recordIds !== '' && recordIds !== null)) {
              paramList.push('recordIds='+recordIds);
            }
            if (paramList.length > 0) {
                if (visualforceNavigation.includes('?')) visualforceNavigation += '&' + paramList.join('&');
                else visualforceNavigation += '?' + paramList.join('&');
            }
            var urlEvent = $A.get("e.force:navigateToURL");
            urlEvent.setParams({
              "url": visualforceNavigation
            });
            urlEvent.fire();
            return;
      }
      else if (actionDTO.type == 'LightningEvent' && actionDTO.target !== undefined) {
          var compEvent = $A.get(actionDTO.target);
          if (compEvent === undefined)
          {
              alert('event not found ' + actionDTO.target);
          }
          else
          {

              var paramsObj = {};
              if (recordId !== undefined && recordId !== '' && recordId != null) {
                paramsObj = {"recordId":recordId}
              }
              else if (recordIds !== undefined) {
                  if(recordIds.length!=0)
                  {
                    paramsObj = {"recordIds":recordIds}
                  }
              }

              if (actionDTO.params != null && actionDTO.params !== undefined) {
                for (var i = 0; i < actionDTO.params.length; i++) {
                    var param = actionDTO.params[i];
                    for (var k in param) {
                        paramsObj[k] = this.substituteActionParam(component, param[k]);
                    }
                }
              }

              compEvent.setParams(paramsObj);
              compEvent.fire();
          }
      }
      else if (actionDTO.type == 'LightningComponent' && actionDTO.target !== undefined && (actionDTO.modal == false || actionDTO.modal === undefined || actionDTO.modal == null)) {
          //Navigate to component
          var compEvent = $A.get('e.force:navigateToComponent');
          if (compEvent === undefined)
          {
              alert('event not found ' + actionDTO.target);
          }
          else
          {
               // Optional: set some data for the event (also known as event shape)
               //TODO: Refactor
              if (actionDTO.params !== undefined || (recordId !== undefined && recordId !== '' && recordId !== null))
              {
                  var paramsObj = {};
                  if (recordId !== undefined && recordId !== '' && recordId !== null && actionDTO.params === undefined) {
                      paramsObj = {"recordId":recordId}
                  }
                  else if (recordIds !== undefined && actionDTO.params === undefined) {
                      paramsObj = {"recordIds":recordIds}
                  }

                  //TODO: add the additional parameters properly
                  // iterate through attributes and set params on event
                  if (actionDTO.params != null && actionDTO.params !== undefined) {
                       for (var i = 0; i < actionDTO.params.length; i++) {
                          var param = actionDTO.params[i];
                          for (var k in param) {
                             paramsObj[k] = this.substituteActionParam(component, param[k]);
                          }
                      }
                  }

                  var navigateToComponentParams = {
                      "componentDef": actionDTO.target,
                      "componentAttributes": paramsObj
                  }
                  compEvent.setParams(navigateToComponentParams);
              }
              compEvent.fire();
          }
      }
      else if (actionDTO.type == 'LightningComponent' && actionDTO.target !== undefined && actionDTO.modal == true) {

          // Don't do anything if recordId or recordIds should be set but are not
          if ((actionDTO.context == 'List' || actionDTO.context == 'Record') && recordId == undefined && recordIds.length == 0)
          {
              var toastEvent = $A.get("e.force:showToast");
               toastEvent.setParams({
                   "message": $A.get("$Label.s2cor.Generic_Records_None_Selected"),
                   "type": "error",
                   "mode": 'sticky'
               });
               toastEvent.fire();
               return;
          }

          //this.openModal(component);
          var compEvent = $A.get('e.s2cor:Event_Display_Modal');
          var paramsObj = {};
          if (recordId !== undefined && recordId !== '' && recordId != null) {
              paramsObj = {"recordId":recordId, "title": actionDTO.title}
          }
          else if (recordIds !== undefined) {
              paramsObj = {"recordIds":recordIds, "title": actionDTO.title}
          }

          if (actionDTO.params != null && actionDTO.params !== undefined) {
            // iterate through attributes and set params on event
            for (var i = 0; i < actionDTO.params.length; i++) {
                var param = actionDTO.params[i];
                for (var k in param) {
                    paramsObj[k] = this.substituteActionParam(component, param[k]);
                }
            }
          }

          compEvent.setParams({
              "component":  actionDTO.target,
              "attributes": paramsObj,
              "parentId": parentId
          });
          compEvent.fire();
      }
    },
    /*
     * Substitute placeholder strings in param list for component attributes
     * @param {object} component - The component in use
     * @param {string} param - The parameter value to search and substitute
     */
    substituteActionParam : function (component, param) {
        if (param == undefined || param == null) return param;
        if (typeof(param) == "boolean") {
            return param;
        }

        if (param.indexOf('{') !== -1)
        {
            // Placeholder string found. Find and replace.
            var regex = /{([\w\d]+)}/g;
            var match = regex.exec(param);
            while (match != null) {
                param = param.replace('{'+match[1]+'}', component.get(match[1]));
                match = regex.exec(param);
            }
        }
        return param;
    },

    getVal : function (val, defaultVal) {
        return (val != null && val != undefined ? val : defaultVal);
    },

    showToast : function (component, message, type) {
         var toastEvent = $A.get("e.force:showToast");
         toastEvent.setParams({
             "message": message,
             "type": type,
             "mode": (type == 'error' || type == 'info' ? 'sticky' : 'dismissible')
         });
         toastEvent.fire();
    }

})