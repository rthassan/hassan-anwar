/**
 * Created by ansja02 on 11/3/16.
 */
({
        touchStart:function(component,event,helper){
            var touchobj = event.changedTouches[0] // reference first touch point (ie: first finger)
            var y = parseInt(touchobj.clientY) // get y position of touch point relative to left edge of browser
            component.set('v.startTouchY', y);
        },
        touchMove:function(component, event, helper) {
            var starty = component.get('v.startTouchY');
            var originalMoveY = component.get('v.moveTouchY');
            var touchobj = event.changedTouches[0]; // reference first touch point for this event
            var newMoveY = parseInt(touchobj.clientY);
            var dist = newMoveY - originalMoveY;

            if (originalMoveY == 0) {
                component.set('v.moveTouchY', newMoveY);
                return;
            }

            var transformPixels = component.get('v.transformPixels');
            var actionsArea = component.find('actionsArea');
            var element = actionsArea.getElement();
            var height = element.clientHeight;
            var style = element.style;

            var maxTransform = (height - (500 + 200)) * -1;

            var newTransformPixels = transformPixels + dist;
            if (newTransformPixels > 0) {
                newTransformPixels = 0;
            } else if (newTransformPixels < maxTransform) {
                newTransformPixels = maxTransform;
            }

            style.transform = "translate3d(0px, " + newTransformPixels + "px, 0px)";
            component.set('v.transformPixels', newTransformPixels);
            component.set('v.moveTouchY', newMoveY);
        },
        touchEnd:function(component,event,helper){
            var touchobj = event.changedTouches[0]; // reference first touch point for this event
            var y = parseInt(touchobj.clientY);
            var movey = component.get('v.moveTouchY');
            if (movey == 0) {
                return;
            }
            var starty = component.get('v.startTouchY');
            var dist = y - starty;

            component.set('v.startTouchY', 0);
            component.set('v.moveTouchY', 0)
        },
})