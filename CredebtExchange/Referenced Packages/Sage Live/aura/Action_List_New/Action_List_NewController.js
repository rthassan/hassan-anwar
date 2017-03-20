/**
 Copyright: © Sage Global Services Limited 2016. All rights reserved.
 */
({
    doInit: function(component, event, helper) {
        helper.initBind(component,helper);

        var uid = component.get('v.listViewUID');
        console.log('listviewuid ' + uid);
        var canBePublic = component.get('v.canBePublic');
        console.log('canBePublic ' + canBePublic);
    },
    handlePrivateOption: function(component, event, helper) {
        component.set('v.privateList', 'true');
    },
    handlePublicOption: function(component, event, helper) {
        component.set('v.privateList', 'false');
    },
    handleChangeName: function(component, event, helper) {
        helper.clearError(component);
    }
})