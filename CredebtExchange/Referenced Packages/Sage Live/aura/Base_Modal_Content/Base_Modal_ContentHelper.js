/**
 * Created by daniel.nicholson on 13/10/2016.
 */
({

    applyStyles : function(component)
    {
        this.callServer(component,'c.getBaseModalData', function(response){
             var buttons = component.get('v.buttons');
             if(response.uiTheme != null && typeof(response.uiTheme)!='undefined')
             {
                 var mobile = (response.uiTheme === "Theme4t");
                 component.set('v.mobile', mobile);
                 if (mobile) {

                     if (buttons == "InputForm") {
                         var className = "slds-modal__container sl-modal-container";
                         component.set('v.containerClass', className);
                         var contentClass = "slds-modal__content slds-p-around--medium slds-is-relative sl-modal-content-input";
                         component.set('v.contentClass', contentClass);
                     }
                     if (buttons == "Progress") {
                         var contentClass = "slds-modal__content slds-p-around--large slds-is-relative sl-modal-content-progress";
                         component.set('v.contentClass', contentClass);
                     }
                     if (buttons == "Confirmation") {
                         var contentClass = "slds-modal__content slds-p-around--large slds-is-relative sl-modal-content-confirmation";
                         component.set('v.contentClass', contentClass);
                     }
                     if (buttons == "ActionsMenu") {
                         var className = "slds-modal__container sl-modal-actions-container";
                         component.set('v.containerClass', className);
                         component.set('v.contentClass', '');
                     }
                 }else{
                     var className = "slds-modal__container ";
                     if (buttons == "DataInputForm") {
                         var contentClass = "slds-modal__content  slds-is-relative ";
                         component.set('v.contentClass', contentClass);
                         var className = "slds-modal__container sl-modal__container--medium";

                     }else{
                         var contentClass = "slds-modal__content  slds-p-around--medium slds-is-relative ";
                         component.set('v.contentClass', contentClass);
                     }
                      component.set('v.containerClass', className);
                 }
             }else{
                 var isModal = component.get('v.isModal')
                 if(isModal===true)
                 {
                     var className = "slds-modal__container ";
                     if (buttons == "DataInputForm") {
                         var contentClass = "slds-modal__content  slds-is-relative ";
                         component.set('v.contentClass', contentClass);
                         var className = "slds-modal__container sl-modal__container--medium";

                     }else{
                         var contentClass = "slds-modal__content  slds-p-around--medium slds-is-relative ";
                         component.set('v.contentClass', contentClass);
                     }
                      component.set('v.containerClass', className);
                 }
             }
        },null,true,function(error){
                 console.log('Error ' + error);
        });




    },

    showSpinner : function (component) {
        var spinner = component.find('spinner');
        $A.util.removeClass(spinner, "slds-hide");
    },

    hideSpinner : function (component) {
        var spinner = component.find('spinner');
        $A.util.addClass(spinner, "slds-hide");
        if (component.get("v.error")) {
            var cmpTarget = component.find('error');
            $A.util.removeClass(cmpTarget, 'slds-hide');
        }
        else {
            var cmpTarget = component.find('success');
            $A.util.removeClass(cmpTarget, 'slds-hide');
        }
    },

    showToast : function (component, message, type, refresh) {
         var toastEvent = $A.get("e.force:showToast");
         toastEvent.setParams({
             "message": message,
             "type": type,
             "mode": (type == 'error' ? 'sticky' : 'dismissible')
         });
         toastEvent.fire();
         this.closeModal(refresh);
    },

    getJobStatus : function (component, helper, jobId, params, apexMethod, completeFunction, successMessage, errorMessage) {
        var jobId = component.get('v.jobId');
        if (jobId == null || jobId == undefined) return;

        params['jobId'] = jobId;

        this.callServer(component, apexMethod, function(response) {
            if (response == null) {

                //retry in 5 seconds;
                window.setTimeout(
                    $A.getCallback(function() {
                        if (component.isValid()) {
                            helper.getJobStatus(component, helper, jobId, params, apexMethod, completeFunction, successMessage, errorMessage);
                        }
                    }), 5000
                );
                return;
            }
            else if (response.length > 0) {
                completeFunction(response);
            }
            else {
                helper.showToast(
                    component,
                    successMessage,
                    "success"
                );
            }
            component.set('v.jobId', null);
        }, params, null, function(response) {
            helper.showToast(
                component,
                errorMessage  + ': ' + response,
                "error"
            );
            component.set('v.jobId', null);
        })
    },

    getRecordIds : function(component) {
        var ids = component.get('v.recordIds');
        if (ids.length < 1) {
            if (component.get('v.recordId') != null && component.get('v.recordId') != undefined) {
                ids=[component.get("v.recordId")];
            }
            else ids = [];
        }

        return ids;
    },
    closeModal: function (refresh) {
        var evt = $A.get("e.s2cor:Event_Close_Modal");
        if (evt != null && typeof(evt) != 'undefined') {
            if (refresh == null || typeof(refresh) == 'undefined') {
                //Default to refresh (to maintain existing behavior)
                evt.setParam('refresh', true);
            } else {
                evt.setParam('refresh',refresh);
            }
            evt.fire();
        }
    },
    cancelModal: function() {
        var evt = $A.get("e.s2cor:Event_Close_Model_On_Cancel");
        if (evt != null && typeof(evt) != 'undefined') {
            evt.fire();
        }
    },
    onAccept:function(component)
    {

    },
    onCancel:function(component)
    {
        this.cancelModal();
    },
    // This method is used to bind the subcomponents helper method and itself to the base components attributes to
    initBind:function(component,helper)
    {
        component.set('v.subComponentHelper',helper);
        component.set('v.subComponent',component);
    },
    toggleAccept: function(component, enabled) {
        component.set('v.acceptEnabled', enabled);
    }
})