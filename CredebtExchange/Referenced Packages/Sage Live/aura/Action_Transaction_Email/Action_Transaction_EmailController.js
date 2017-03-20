/**
 * Created by daniel.nicholson on 19/10/2016.
 */
({
    doInit: function(component, event, helper) {

        helper.initBind(component,helper);

        var ids = helper.getRecordIds(component);

        if (ids.length > 1)
        {
            component.set("v.showCC", false);
            component.set("v.showAttachments", false);
        }

        var params = {
            "recordIds": ids
        };

        helper.callServer(component, 'c.checkEmailContact', function(response) {
            if (response.length > 0) {
                var message = '<div class="slds-notify slds-notify--alert slds-theme--error slds-theme--alert-texture" '
                + 'role="alert"><span class="slds-assistive-text">Error</span><h2>'
                + $A.get("$Label.s2cor.VF_Generic_Error")
                + '</h2></div>';

                for (var key in response) {
                    message = message + '<div class="slds-text-color--error">' + response[key] + '</div>';
                }

                component.set('v.message', message);
                component.set('v.error', true);
                component.set('v.acceptEnabled', false);
          }
        }, params);

        helper.callServer(component, 'c.getEmailTemplates', function(response) {
            console.log(' Response: ' + response);
            if (response != null)
            {
                component.set("v.emailTemplates", response);
                component.set('v.selectedEmailTemplate', response[0]);
            }
        }, params);

        helper.callServer(component, 'c.getEmailAttachments', function(response) {
            console.log(' Response: ' + response);
            if (response.names != null)
            {
               component.set("v.emailAttachments", response.names);
               component.set('v.selectedAttachmentIds', response.names[0]);
               component.set('v.emailAttachmentMetadata', response);
            }
        }, params);
    },

    setEmailTemplate: function(component, event, helper) {
        if (component.find('selectEmailTemplate') != null && component.find('selectEmailTemplate') != undefined)
        {
            var selectedEmailTemplate = component.find('selectEmailTemplate').get("v.value");
            component.set('v.selectedEmailTemplate', selectedEmailTemplate);
        }
     },

    setAttachmentIds: function(component, event, helper) {
        if (component.find('selectAttachmentsId') != null && component.find('selectAttachmentsId') != undefined)
        {
           var selectComponents = component.find('selectAttachmentsId');

           var selectedList = [];
           var options = selectComponents.getElements()[0].children ;
           for (var key in options)
           {
               if (options[key].selected == true)
               {
                   selectedList.push(options[key].value);
               }
           }
           component.set('v.selectedAttachmentIds', selectedList);
        }
    },


    emailTransactions: function(component, event, helper ) {

        var params = {
            "ids": helper.getRecordIds(component),
            "templateName": null
        };
        helper.callServer(component,'c.sendEmail', function(response) {
            if (Object.keys(response).length > 0) {
                var message = '';

                for (var key in response) {
                    message = message + response[key] + '<br />';
                }

                component.set('v.message', message);
                component.set('v.error', true);
                helper.hideSpinner(component);
            }
            else {
                helper.showToast(
                    component,
                    $A.get("$Label.s2cor.VF_Documents_Emails_Success"),
                    "success"
                );
            }

        }, params);
    }
})