/**
 Copyright: © Sage Global Services Limited 2016. All rights reserved.
 */
({
    doInit: function(component, event, helper) {
        helper.initBind(component,helper);
        var privateList = component.get('v.privateList');
        console.log('private list ' + privateList);
  },
    handlePrivateOption: function(component, event, helper) {
        component.set('v.privateList', 'true');
    },
    handlePublicOption: function(component, event, helper) {
        component.set('v.privateList', 'false');
    },
})