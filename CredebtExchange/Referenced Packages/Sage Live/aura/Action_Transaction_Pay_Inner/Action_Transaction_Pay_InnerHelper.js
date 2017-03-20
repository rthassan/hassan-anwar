/**
 * Created by andrew.fenner on 06/01/2017.
 */
({
    doInit: function(component, event, helper) {
        helper.setTimeStamp(component,event,helper);
    },
    amountChanged: function (component,event,helper){
        helper.setTimeStamp(component,event,helper);
    },
    setTimeStamp: function (component,event,helper){
        var dt = new Date();
        var t = dt.getTime();
        component.set("v.paymentChangedTime", t);
    }
})