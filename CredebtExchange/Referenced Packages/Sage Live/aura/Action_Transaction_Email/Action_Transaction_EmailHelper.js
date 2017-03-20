/**
   * Created by Sayan.Chakravartty on 16/11/2016.
   */
  ({
      onAccept : function (component, event) {

          var ids = this.getRecordIds(component);
          var templateName = component.get("v.selectedEmailTemplate");
          var cc_Emails = component.get("v.cc_EmailsInput");
          var attachmentIds = component.get("v.selectedAttachmentIds");

          var params = {
              "ids": ids,
              "templateName": templateName,
              "cc_Emails": cc_Emails,
              "attachmentIds": attachmentIds
          };

          this.callServer(component,'c.sendEmail', function(response) {

              this.showToast(
                  component,
                  $A.get("$Label.s2cor.VF_Documents_Emails_Success"),
                  "success");

            }, params, false, function(result) {

                var message = '';

                for (var key in response) {
                    message = message + response[key] + '<br />';
                }

                component.set('v.message', message);
                component.set('v.error', true);
                this.hideSpinner(component);

            });
      }
  })