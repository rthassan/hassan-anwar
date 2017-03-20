({
    selectTab : function(component) {
        var mobile = component.get("v.mobile");
        var action = component.get("v.actionDTO");
        if(action.tabType == "Report") {
             var links = []
            for (var i = 0; i < action.target.length; i++) {
                var link = action.target[i];
                links.push(link);
            }

            var params = [];
            params.push({"actionDTOs":links});
            params.push({"mobile":mobile});


            var newAction = {
                "type": "LightningComponent",
                "target": "s2cor:Tabs_Area_Reports",
                "params": params,
            };

            this.executeAction(component, newAction, null, null, null);
        } else {
            this.executeAction(component, action, null, null, null);
        }
    },
 })