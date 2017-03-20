({
    createOutput : function(cmp, componentType, value, attributes, prefix) {

         if (value == null || value == undefined) return;

         if (attributes == null || attributes == undefined)
         {
             attributes = {};
         }
         attributes["value"] = this.getVal(prefix,'') + value;

         $A.createComponent(
             componentType,
             attributes,
             function(newOutput, status, errorMessage){
                 //Add the new button to the body array
                 if (status === "SUCCESS") {
                     var body = cmp.get("v.body");
                     body.push(newOutput);
                     cmp.set("v.body", body);
                 }
                 else if (status === "INCOMPLETE") {
                     //console.log("No response from server or client is offline.")
                     // Show offline error
                 }
                 else if (status === "ERROR") {
                     //console.log("Error: " + errorMessage);
                     // Show error message
                 }
             }
         );

    },
    getDateValueFromISODate: function(date) {
        var parts = date.split('-');
        // new Date(year, month [, day [, hours[, minutes[, seconds[, ms]]]]])
        var tempDate = new Date(parts[0], parts[1]-1, parts[2]); // Note: months are 0-based
        return tempDate.getTime();
    }
})