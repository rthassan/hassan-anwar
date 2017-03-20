/**
 * Created by ansja02 on 11/16/16.
 */
({
    loadActionsToDisplay: function(component) {
        var actions = component.get('v.actions');
        var actionsToDisplay = [];
        if ((actions != null) && (typeof(actions) != 'undefined')) {
            for (var i = 0; i < actions.length; i++) {
                var action = actions[i];
                if ((action.iconName != null) && (action != "")) {
                    actionsToDisplay.push(action);
                }
                if (actionsToDisplay.length == 3) {
                    break;
                }
            }
            component.set("v.actionsToDisplay", actionsToDisplay);
        }
    },
    isTableLoaded : function(component) {
        var loaded = component.get('v.loaded');
        return loaded;
    }
})