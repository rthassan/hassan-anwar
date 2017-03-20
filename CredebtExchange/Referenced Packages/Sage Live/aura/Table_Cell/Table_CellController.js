/**
 * Created by ansja02 on 10/25/16.
 */
({
    selectAction:function(component, event, helper) {
         var params = event.getParams();
         var action = params.action;
         var recordId = params.recordId;
         var parentId = params.parentId;
         var row = component.get('v.row');
         if ((recordId == row.recordId) && (parentId == component.get('v.parentId'))) {
            helper.executeAction(component, action, recordId, null, parentId);
            event.stopPropagation();
         }
    },
    moreActions:function(component, event, helper) {
        var row = component.get('v.row');
        var actions = component.get('v.actions');
        var params = [];
        params.push({"actions":actions});
        params.push({"mobile":true});
        params.push({"parentId":component.get('v.parentId')});

        var action = {
            "context": "Record",
            "type": "LightningComponent",
            "target": "s2cor:Action_Choose_Record_Action",
            "modal": true,
            "title": "",
            "params": params
        };

        helper.executeAction(component, action, row.recordId, null, component.get('v.parentId'));
    },
    touchStart:function(component,event,helper){
        var touchobj = event.changedTouches[0] // reference first touch point (ie: first finger)
        var x = parseInt(touchobj.clientX) // get x position of touch point relative to left edge of browser
        component.set('v.startTouchX', x);
        component.set('v.startTouchY', parseInt(touchobj.clientY));
    },
    touchMove:function(component, event, helper) {
        var startx = component.get('v.startTouchX');
        var originalMoveX = component.get('v.moveTouchX');
        var touchobj = event.changedTouches[0]; // reference first touch point for this event

        var starty = component.get('v.startTouchY');
        var movey = parseInt(touchobj.clientY);
        if (starty != 0) {
            var disty = movey - starty;
            if (Math.abs(disty) > 10) {
                //They are not scrolling horizontally - they are scrolling vertically - so do nothing
                return;
            }
        }

        var newMoveX = parseInt(touchobj.clientX);
        var dist = newMoveX - startx;

        if (originalMoveX == 0) {
            component.set('v.moveTouchX', newMoveX);
            return;
        }


        var actionsArea = component.find('actionsArea');
        var element = actionsArea.getElement();
        var width = element.clientWidth;
        var style = element.style;

        if (width > newMoveX) {
            var ratio = ((width - newMoveX)/width) * 100;
            if (ratio > 80) {
                ratio = 80;
            }
            style.transform = "translate3d(-" + ratio + "%, 0px, 0px)";
        }

        component.set('v.moveTouchX', newMoveX);
    },
    touchEnd:function(component,event,helper){
        var touchobj = event.changedTouches[0]; // reference first touch point for this event
        var x = parseInt(touchobj.clientX);
        var movex = component.get('v.moveTouchX');
        if (movex == 0) {
            return;
        }
        var startx = component.get('v.startTouchX');
        var dist = x - startx;

        var actionsArea = component.find('actionsArea');
        var element = actionsArea.getElement();
        var style = element.style;

        component.set('v.startTouchX', 0);
        component.set('v.moveTouchX', 0)

        if (dist < 0) {
            style.transform = "translate3d(-80%, 0px, 0px)";
        } else if (dist > 0) {
            style.transform = "translate3d(0%, 0px, 0px)";
        }
    },
})