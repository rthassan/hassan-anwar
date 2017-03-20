/**
 * Created by ansja02 on 11/3/16.
 */
({
    doInit:function(component,event,helper){
        helper.loadActionsToDisplay(component);
    },
    actionsChanging: function (component, event, helper){
        helper.loadActionsToDisplay(component);
    },

        touchStart:function(component,event,helper){
            if (!helper.isTableLoaded(component)) {
                return;
            }
            var touchobj = event.changedTouches[0] // reference first touch point (ie: first finger)
            var y = parseInt(touchobj.clientY) // get y position of touch point relative to left edge of browser
            component.set('v.startTouchY', y);
            component.set('v.startTouchX', parseInt(touchobj.clientX));
        },
        touchMove:function(component, event, helper) {
            if (!helper.isTableLoaded(component)) {
                 return;
             }
            var starty = component.get('v.startTouchY');
            var originalMoveY = component.get('v.moveTouchY');

            var touchobj = event.changedTouches[0]; // reference first touch point for this event
            var newMoveY = parseInt(touchobj.clientY);
            var dist = newMoveY - originalMoveY;

            var startx = component.get('v.startTouchX');
            var movex = parseInt(touchobj.clientX);
            if (startx != 0) {
                var distx = movex - startx;
                if (Math.abs(distx) > 10) {
                    //They are not scrolling vertically - they are scrolling horizontally - so do nothing
                    return;
                }
            }

            if (originalMoveY == 0) {
                component.set('v.moveTouchY', newMoveY);
                return;
            }

            var transformPixels = component.get('v.transformPixels');
            var actionsArea = component.find('tableArea');
            var element = actionsArea.getElement();
            var height = element.clientHeight;
            var style = element.style;

            //400 is a magic number derived thru testing
            var minHeight = 400;
            var bottomGapHeight = 32 + 22;
            var maxTransform;
            if ((height - bottomGapHeight) > minHeight) {
                maxTransform = (height - minHeight) * -1;
            } else {
                maxTransform = 0;
            }

            var pullingForMore = component.get('v.pullingForMore');
            var newTransformPixels = transformPixels + dist;
            if (newTransformPixels > 0) {
                newTransformPixels = 0;
            } else if (newTransformPixels < maxTransform) {
                //They have reached the last page - are there more records to scroll to?
                var rowCount = component.get('v.rowCount');
                var rowsDisplayed = component.get('v.rowsDisplayed');

                if (rowCount > rowsDisplayed) {
                    //Double-check that they are actually scrolling up
                    if (newMoveY < originalMoveY) {
                        if (!pullingForMore) {
                            //Start a timer for the pulling up action
                            var timer = setTimeout(function(){
                                component.set('v.pulledForMore', true);
                            },500);
                            component.set('v.pullingTimer', timer);
                        }
                        pullingForMore = true;
                    }
                } else {
                    //Prevent further scrolling up
                    newTransformPixels = maxTransform;
                }
            }

            style.transform = "translate3d(0px, " + newTransformPixels + "px, 0px)";
            component.set('v.transformPixels', newTransformPixels);
            component.set('v.moveTouchY', newMoveY);
            component.set('v.pullingForMore', pullingForMore);
        },
        touchEnd:function(component,event,helper){
            if (!helper.isTableLoaded(component)) {
                return;
            }

            var touchobj = event.changedTouches[0]; // reference first touch point for this event
            var y = parseInt(touchobj.clientY);
            var movey = component.get('v.moveTouchY');
            if (movey == 0) {
                return;
            }

            var pullingForMore = component.get('v.pullingForMore');
            if (pullingForMore) {
                var timer = component.get('v.pullingTimer');
                if(typeof(timer)!='undefined' && timer != null) {
                    clearTimeout(timer);
                }
            }

            var starty = component.get('v.startTouchY');
            var dist = y - starty;
            var pulledForMore = component.get('v.pulledForMore');

            component.set('v.pulledForMore', false);
            component.set('v.pullingForMore', false);
            component.set('v.startTouchY', 0);
            component.set('v.moveTouchY', 0)
            component.set('v.pullingTimer', null);

            if (pulledForMore) {
                component.set('v.loaded', false);
                component.set('v.paginationOffset', component.get('v.paginationOffset') +1);
            }
        },
        rowsDisplayedChanged: function(component, element, helper) {
            var rowsDisplayed = component.get('v.rowsDisplayed');
            if (rowsDisplayed == 0) {
                var actionsArea = component.find('tableArea');
                var element = actionsArea.getElement();
                var style = element.style;
                style.transform = "translate3d(0px, 0px, 0px)";
            }
        }
})