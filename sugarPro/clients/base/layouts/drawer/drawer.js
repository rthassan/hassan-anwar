/*
     * Your installation or use of this SugarCRM file is subject to the applicable
     * terms available at
     * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
     * If you do not agree to all of the applicable terms or do not have the
     * authority to bind the entity as an authorized representative, then do not
     * install or use this SugarCRM file.
     *
     * Copyright (C) SugarCRM Inc. All rights reserved.
     *//*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
/**
 * @class View.Layouts.Base.DrawerLayout
 * @alias SUGAR.App.view.layouts.BaseDrawerLayout
 * @extends View.Layout
 */
({
    backdropHtml: '<div class="drawer-backdrop"></div>',
    plugins: ['Tooltip'],
    onCloseCallback: null, //callbacks to be called once drawers are closed
    scrollTopPositions: [], //stores scroll positions for main and side pane

    pixelsFromFooter: 80, //how many pixels from the footer the drawer will drop down to

    initialize: function(options) {
        var self = this;

        if (!this.$el.is('#drawers')) {
            app.logger.error('Drawer layout can only be included as an Additional Component.');
            return;
        }

        app.drawer = this;
        this.onCloseCallback = [];

        //clear out drawers before routing to another page
        this.name = 'drawer';
        app.routing.before("route", this.reset, this, true);
        app.view.Layout.prototype.initialize.call(this, options);

        // Browser find functionality auto-scrolls even when overflow is set to hidden.
        // Prevent scrolling only when there are active drawers.
        $(window).on('scroll.prevent', function() {
            self._preventScroll($(this));
        });
        app.$contentEl.on('scroll.prevent', function() {
            self._preventScroll($(this));
        });
    },

    /**
     * Open the specified layout in a drawer.
     *
     * You can pass the current context if you want the context created to be a
     * child of that current context. If you don't pass a `scope`, it will
     * create a child of the main context (`app.controller.context`).
     *
     * @param {Object} layoutDef The component definition.
     * @param {Core.Context/Object} [layoutDef.context] The context to pass to
     *  the drawer.
     * @param {Core.Context} [layoutDef.context.parent] The parent context of
     *  the context to pass to the drawer.
     * @param {Function} [onClose] Callback method when the drawer closes.
     */
    open: function(layoutDef, onClose) {
        var layout;

        app.shortcuts.saveSession();
        if (!app.triggerBefore('app:view:change')) {
            return;
        }

        //store the callback function to be called later
        if (_.isUndefined(onClose)) {
            this.onCloseCallback.push(function(){});
        } else {
            this.onCloseCallback.push(onClose);
        }

        //initialize layout definition components
        this._initializeComponentsFromDefinition(layoutDef);

        layout = _.last(this._components);

        //scroll both main and sidebar to the top
        this._scrollToTop();

        //open the drawer
        this._animateOpenDrawer(function() {
            // Forecasts config route uses the drawer but if user
            // does not have access, initialize is never called so the
            // context on the layout never gets set. Adding check to make
            // sure there actually is a context to use on the layout
            if (layout.context) {
                //called after animation finished
                app.trigger("app:view:change", layout.options.name, layout.context.attributes);
            }
        });

        //load and render new layout in drawer
        layout.loadData();
        layout.render();
    },

    /**
     * Close the top-most drawer
     * @param any parameters passed into the close method will be passed to the callback
     */
    close: function() {
        var self = this,
            args = Array.prototype.slice.call(arguments, 0);

        if (!Modernizr.csstransitions) {
            this.closeImmediately.apply(this, args);
            return;
        }

        if (this._components.length > 0) {
            if (!app.triggerBefore('app:view:change')) {
                return;
            }

            //close the drawer
            this._animateCloseDrawer(function() {
                self._afterCloseActions(args);
            });
        }
    },

    /**
     * Close the top-most drawer immediately without transitions.
     * @param any parameters passed into the close method will be passed to the callback
     */
    closeImmediately: function() {
        if (this._components.length > 0) {
            var args = Array.prototype.slice.call(arguments, 0),
                drawers = this._getDrawers(false),
                drawerHeight = this._determineDrawerHeight();

            if (!app.triggerBefore('app:view:change')) {
                return;
            }

            //move the bottom drawer to the top and the next drawer to be viewed on the bottom.
            drawers.$bottom.css('top','');
            if (drawers.$next) {
                drawers.$next.css('top', this._isMainAppContent(drawers.$next) ? drawerHeight : drawers.$next.offset().top - drawerHeight);
            }

            this._removeTabAndBackdrop(drawers.$bottom);
            this._cleanUpAfterClose(drawers);
            this._afterCloseActions(args);
        }
    },

    /**
     * Reload the current drawer with a new layout
     * @param layoutDef
     */
    load: function(layoutDef) {
        var layout = this._components.pop(),
            top = layout.$el.css('top'),
            height = layout.$el.css('height'),
            drawers;

        layout.dispose();

        if (!app.triggerBefore('app:view:change')) {
            return;
        }

        this._initializeComponentsFromDefinition(layoutDef);

        drawers = this._getDrawers(true);
        drawers.$next
            .addClass('drawer active')
            .css({
                top: top,
                height: height
            });

        //refresh tab and backdrop
        this._removeTabAndBackdrop(drawers.$top);
        this._createTabAndBackdrop(drawers.$next, drawers.$top);

        layout = _.last(this._components);
        layout.loadData();
        layout.render();
    },

    /**
     * Retrieves the number of drawers in the stack
     * @returns {Number}
     */
    count: function() {
        return this._components.length;
    },

    /**
     * Test if element is part of active drawer.  Always returns true if there's no inactive components on page.
     * @param el DOM element to test if it is in the active drawer
     * @return boolean
     */
    isActive: function(el) {
        return ((this.count() === 0) || ($(el).parents('.drawer.active').length > 0));
    },

    /**
     * Get currently active drawer layout.
     * @returns {View.Layout}
     */
    getActiveDrawerLayout: function() {
        if (this.count() === 0) {
            return app.controller.layout;
        } else {
            return _.last(this._components);
        }
    },

    /**
     * Remove all drawers and reset
     * @param trigger Indicates whether to triggerBefore (defaults to true if anything other than `false`)
     */
    reset: function(triggerBefore) {
        triggerBefore = triggerBefore === false ? false : true;
        if (triggerBefore && !this.triggerBefore("reset", {drawer: this})) {
            return false;
        }

        var $main = app.$contentEl.children().first();

        _.each(this._components, function(component) {
            component.dispose();
        }, this);

        this._components = [];
        this.onCloseCallback = [];

        if ($main.hasClass('drawer')) {
            $main
                .removeClass('drawer inactive')
                .removeAttr('aria-hidden')
                .css('top','');
            this._removeTabAndBackdrop($main);
        }

        $('body').removeClass('noscroll');
        app.$contentEl.removeClass('noscroll');
    },

    /**
     * Force to create a new context and create components from the layout definition.
     * If the parent context is defined, make the new context as a child of the parent context.
     * @param {Object} layoutDef
     * @private
     */
    _initializeComponentsFromDefinition: function(layoutDef) {
        var parentContext;

        if (_.isUndefined(layoutDef.context)) {
            layoutDef.context = {};
        }

        if (_.isUndefined(layoutDef.context.forceNew)) {
            layoutDef.context.forceNew = true;
        }

        if (!(layoutDef.context instanceof app.Context) && layoutDef.context.parent instanceof app.Context) {
            parentContext = layoutDef.context.parent;
            // Remove the `parent` property to not mess up with the context
            // attributes.
            delete layoutDef.context.parent;
        }

        this._addComponentsFromDef([layoutDef], parentContext);
    },

    /**
     * Animate opening of a new drawer
     * @private
     * @param {Function} callback Called when open animation is finished
     */
    _animateOpenDrawer: function(callback) {
        if (this._components.length === 0) {
            return;
        }

        var drawers = this._getDrawers(true),
            drawerHeight = this._determineDrawerHeight(),
            topDrawerCurrentTopPos = drawers.$top.offset().top,
            aboveWindowTopPos = topDrawerCurrentTopPos - drawerHeight, //top position above the browser window
            bottomDrawerTopPos = this._isMainAppContent(drawers.$top) ? drawerHeight : topDrawerCurrentTopPos + drawerHeight,
            belowWindowTopPos; //top position below the browser window

        if (drawers.$bottom) {
            belowWindowTopPos = drawers.$bottom.offset().top + drawerHeight
        }

        if (this._isMainAppContent(drawers.$top)) {
            //make sure that the main application content is set as a drawer
            drawers.$top.addClass('drawer');
            $('body').addClass('noscroll');
            app.$contentEl.addClass('noscroll');
        }

        //add the expand tab and the backdrop to the top drawer
        this._createTabAndBackdrop(drawers.$next, drawers.$top);

        //indicate that it's an active drawer
        drawers.$next.addClass('drawer active');
        //set the height of the new drawer
        drawers.$next.css('height', drawerHeight);
        //set the animation starting point for the new drawer
        drawers.$next.css('top', aboveWindowTopPos);
        //mark the top drawer as inactive
        drawers.$top
            .addClass('inactive')
            .removeClass('active')
            .attr('aria-hidden', true); //accessibility
        //prevent scrolling on drawer
        drawers.$top.on('scroll.prevent', _.bind(function() {
            this._preventScroll(drawers.$top);
        }, this));

        // Need to do a defer so that transition can be applied when the drawer is coming down
        // but not when it's being setup above browser window.
        _.defer(_.bind(function() {
            this._setTransition(drawers);
            this._onTransitionEnd(drawers.$next, function() {
                this._removeTransition(drawers);
                if (_.isFunction(callback)) {
                    callback();
                }
                this.trigger('drawer:resize', drawerHeight);
            });

            //start animation to open the drawer
            drawers.$next.css('top','');
            drawers.$top.css('top', bottomDrawerTopPos);
            if (drawers.$bottom) {
                drawers.$bottom.css('top', belowWindowTopPos);
            }

            //resize the visible drawer when the browser resizes
            if (this._components.length === 1) {
                $(window).on('resize.drawer', _.bind(this._resizeDrawer, this));
            }
        }, this));
    },

    /**
     * Animate closing of the top-most drawer.
     * @param {Function} callback Function to be called after drawer has been closed
     * @private
     */
    _animateCloseDrawer: function(callback) {
        if (this._components.length === 0) {
            return;
        }

        var drawers = this._getDrawers(false),
            drawerHeight = this._determineDrawerHeight(),
            aboveWindowTopPos = drawers.$top.offset().top - drawerHeight, //top position above the browser window
            bottomDrawerTopPos; //top position of the bottom drawer

        if (drawers.$next) {
            bottomDrawerTopPos = this._isMainAppContent(drawers.$next) ? drawerHeight : drawers.$next.offset().top - drawerHeight;
        }

        this._setTransition(drawers);
        this._onTransitionEnd(drawers.$bottom, function() {
            this._removeTransition(drawers);
            this._cleanUpAfterClose(drawers);
            if (_.isFunction(callback)) {
                callback();
            }
        });

        //start the animation to close the drawer
        drawers.$top.css('top', aboveWindowTopPos);
        drawers.$bottom.css('top','');
        if (drawers.$next) {
            drawers.$next.css('top', bottomDrawerTopPos);
        }

        this._removeTabAndBackdrop(drawers.$bottom);
    },

    /**
     * Get all (top, bottom, next) drawers layouts depending upon whether or not a drawer is being opened or closed
     * @param open
     * @return {Object}
     * @private
     */
    _getDrawers: function(open) {
        var $main = app.$contentEl.children().first(),
            $nextDrawer, $topDrawer, $bottomDrawer,
            open = _.isUndefined(open) ? true : open,
            drawerCount = this._components.length;

        switch (drawerCount) {
            case 0: //no drawers
                break;
            case 1: //only one drawer
                $nextDrawer = open ? this._components[drawerCount-1].$el : undefined;
                $topDrawer = open ? $main : this._components[drawerCount-1].$el;
                $bottomDrawer = open? undefined : $main;
                break;
            case 2: //two drawers
                $nextDrawer = open ? this._components[drawerCount-1].$el : $main;
                $topDrawer = open ? this._components[drawerCount-2].$el : this._components[drawerCount-1].$el;
                $bottomDrawer = open? $main : this._components[drawerCount-2].$el;
                break;
            default: //more than two drawers
                $nextDrawer = open ? this._components[drawerCount-1].$el : this._components[drawerCount-3].$el;
                $topDrawer = open ? this._components[drawerCount-2].$el : this._components[drawerCount-1].$el;
                $bottomDrawer = open? this._components[drawerCount-3].$el : this._components[drawerCount-2].$el;
        }

        return {
            $next: $nextDrawer,
            $top: $topDrawer,
            $bottom: $bottomDrawer
        };
    },

    /**
     * Is this drawer the main application content area?
     * @param $layout
     * @return {Boolean}
     * @private
     */
    _isMainAppContent: function($layout) {
        return !$layout.parent().is(this.$el);
    },

    /**
     * Calculate how far down the drawer should drop down, i.e. the height of the drawer
     * @param $mainContent
     * @return {Number}
     * @private
     */
    _determineDrawerHeight: function() {
        var windowHeight = $(window).height(),
            headerHeight = $('#header .navbar').outerHeight(),
            footerHeight = $('footer').outerHeight();

        return windowHeight - headerHeight - footerHeight - this.pixelsFromFooter;
    },

    /**
     * Calculate how much to collapse the drawer
     * @return {Number}
     * @private
     */
    _determineCollapsedHeight: function() {
        return $(window).height()/2; //middle of the window
    },

    /**
     * Create tab and the backdrop. Add the ability to expand and collapse the drawer when the tab is clicked
     * @param $top
     * @param $bottom
     * @private
     */
    _createTabAndBackdrop: function($top, $bottom) {
        var $drawerTab;

        //add the expand tab and the backdrop to the top drawer
        this.expandTpl = app.template.getLayout(this.name + '.expand');
        this.expandTabHtml = this.expandTpl();

        $bottom
            .append(this.expandTabHtml)
            .append(this.backdropHtml);

        //add tooltip
        $drawerTab = $bottom.find('.drawer-tab');
        this.addPluginTooltips($drawerTab);

        //add expand/collapse tab behavior
        $drawerTab.on('click', _.bind(function(event) {
            if ($('i', event.currentTarget).hasClass('fa-chevron-up')) {
                this._collapseDrawer($top, $bottom);
            } else {
                this._expandDrawer($top, $bottom);
            }
            return false;
        }, this));
        app.accessibility.run($drawerTab, 'click');
    },

    /**
     * Remove the tab and the backdrop and the event listener that handles the ability to expand and collapse the drawer.
     * @param $drawer
     * @private
     */
    _removeTabAndBackdrop: function($drawer) {
        //remove drawer tab
        var $drawerTab = $drawer.find('.drawer-tab')
            .off('click')
            .remove();

        //remove tooltip
        this.removePluginTooltips($drawerTab);

        //remove backdrop
        $drawer.find('.drawer-backdrop')
            .remove();
    },

    /**
     * Process clean up after the drawer has been closed.
     * @param {Object} drawers Object of drawers ({@link #_getDrawers})
     * @private
     */
    _cleanUpAfterClose: function(drawers) {
        drawers.$top.removeClass('active');

        drawers.$bottom
            .removeClass('inactive')
            .addClass('active')
            .removeAttr('aria-hidden') //accessibility
            .off('scroll.prevent'); //remove event handler that prevents scrolling

        if (this._isMainAppContent(drawers.$bottom)) {
            drawers.$bottom.removeClass('drawer active');
            $('body').removeClass('noscroll');
            app.$contentEl.removeClass('noscroll');
        } else {
            //refresh drawer position and height for collapsed or resized drawers
            this._expandDrawer(drawers.$bottom, drawers.$next);
        }

        //set scrollable elements back its original position
        this._scrollBackToOriginal(drawers.$bottom);

        //remove resize handler
        if (this._components.length === 1) {
            $(window).off('resize.drawer');
        }
    },

    /**
     * Trigger view change event and restore shortcuts session.
     * @param {array} callbackArgs Arguments that will be passed to the callback
     * @private
     */
    _afterCloseActions: function(callbackArgs) {
        var layout;

        this._components.pop().dispose(); //dispose top-most drawer

        layout = _.last(this._components);
        if (layout) { // still have layouts in the drawer
            app.trigger("app:view:change", layout.options.name, layout.context.attributes);
        } else { //we've returned to base layout
            app.trigger("app:view:change", app.controller.context.get("layout"), app.controller.context.attributes);
        }

        app.shortcuts.restoreSession();

        (this.onCloseCallback.pop()).apply(window, callbackArgs); //execute callback
    },

    /**
     * Expand the drawer.
     * @param {jQuery} $top The top drawer
     * @param {jQuery} $bottom The bottom drawer
     * @private
     */
    _expandDrawer: function($top, $bottom) {
        var expandHeight = this._determineDrawerHeight();
        $top.css('height', expandHeight);

        if (this._isMainAppContent($bottom)) {
            $bottom.css('top', expandHeight);
        } else {
            $bottom.css('top', expandHeight + $top.offset().top);
        }

        $bottom
            .find('.drawer-tab i')
            .removeClass('fa-chevron-down')
            .addClass('fa-chevron-up');

        this.trigger('drawer:resize', expandHeight);
    },

    /**
     * Collapse the drawer.
     * @param {jQuery} $top The top drawer
     * @param {jQuery} $bottom The bottom drawer
     * @private
     */
    _collapseDrawer: function($top, $bottom) {
        var collapseHeight = this._determineCollapsedHeight();
        $top.css('height', collapseHeight);

        if (this._isMainAppContent($bottom)) {
            $bottom.css('top', collapseHeight);
        } else {
            $bottom.css('top', collapseHeight + $top.offset().top);
        }

        $bottom
            .find('.drawer-tab i')
            .removeClass('fa-chevron-up')
            .addClass('fa-chevron-down');

        this.trigger('drawer:resize', collapseHeight);
    },

    /**
     * Add transition to the drawers.
     * @param {Object} drawers Object of drawers ({@link #_getDrawers})
     * @private
     */
    _setTransition: function(drawers) {
        drawers.$top.addClass('transition');

        if (drawers.$next) {
            drawers.$next.addClass('transition');
        }

        if (drawers.$bottom) {
            drawers.$bottom.addClass('transition');
        }
    },

    /**
     * Remove transition from the drawers.
     * @param {Object} drawers Object of drawers ({@link #_getDrawers})
     * @private
     */
    _removeTransition: function(drawers) {
        drawers.$top.removeClass('transition');

        if (drawers.$next) {
            drawers.$next.removeClass('transition');
        }

        if (drawers.$bottom) {
            drawers.$bottom.removeClass('transition');
        }
    },

    /**
     * Is the drawer in a middle of a transition?
     * @param {jQuery} drawer top, bottom, or next drawer layout
     * @return {boolean}
     * @private
     */
    _isInTransition: function(drawer) {
        return drawer.hasClass('transition');
    },

    /**
     * Attach transition end event handler for a given drawer.
     * @param {jQuery} $drawer Drawer to attach the event
     * @param {Function} callback Event handler
     * @private
     */
    _onTransitionEnd: function($drawer, callback) {
        var self = this,
            transitionEndEvents = 'webkitTransitionEnd oTransitionEnd otransitionend transitionend msTransitionEnd';

        //once the animation is done, reset to original state and execute callback parameter
        $drawer.one(transitionEndEvents, function() {
            $drawer.off(transitionEndEvents); //some browsers fire multiple transitionend events
            callback.call(self);
        });

        //this is a failsafe to ensure that drawer will always close
        //in Chrome the css change to 'top' sometimes (randomly) doesn't actually change the css value
        _.delay(function() {
            $drawer.trigger('transitionend');
        }, 400);
    },

    /**
     * Scroll the scrollable divs to the top and save its position.
     * Content needs to be scrolled as well because in small width screens,
     * the responsive layout changes the #content div to be a scrollable container
     * @private
     */
    _scrollToTop: function() {
        var drawers = this._getDrawers(true),
            $mainpane = drawers.$top.find('.main-pane'),
            $sidepane = drawers.$top.find('.sidebar-content'),
            $content = app.$contentEl;

        this.scrollTopPositions.push({
            main: $mainpane.scrollTop(),
            side: $sidepane.scrollTop(),
            drawer: drawers.$top.scrollTop(),
            content: $content.scrollTop()
        });

        drawers.$top.scrollTop(0);
        $mainpane.scrollTop(0);
        $sidepane.scrollTop(0);
        $content.scrollTop(0);
    },

    /**
     * Scroll the scrollable elements back to its original position.
     * @param {jQuery} [$drawer] Drawer to scroll back
     * @private
     */
    _scrollBackToOriginal: function($drawer) {
        var scrollPositions = this.scrollTopPositions.pop();

        if ($drawer) {
            $drawer.scrollTop(scrollPositions.drawer);
        } else {
            $drawer = app.$contentEl;
        }

        $drawer.find('.main-pane').scrollTop(scrollPositions.main);
        $drawer.find('.sidebar-content').scrollTop(scrollPositions.side);
        app.$contentEl.scrollTop(scrollPositions.content);
    },

    /**
     * Get the current height of the active drawer
     * @returns {Number}
     */
    getHeight: function(){
        if (_.isEmpty(this._components)) {
            return 0; // No drawers on page
        }
        var $top = this._getDrawers(false).$top;
        return $top.height();
    },

    /**
     * Prevent scrolling when drawer is open.  This feature is needed because browsers
     * automatically scroll when the Find feature is used (Ctrl+F) even when the scrollable
     * elements have been set with hidden overflow.
     * @param {jQuery} $scrollable Scrollable element that needs to be prevented from scrolling
     * @private
     */
    _preventScroll: function($scrollable) {
        // Preventing scrolls in iOS 7 causes AJAX calls to be paused (MAR-2768). No problems in iOS 8.
        if (!Modernizr.touch && (app.drawer.count() > 0)) {
            $scrollable.scrollTop(0);
        }
    },

    _dispose: function() {
        app.routing.offBefore("route", this.reset, this);
        this.reset();
        $(window).off('resize.drawer');
        $(window).off('scroll.prevent');
        app.$contentEl.on('scroll.prevent');
        this._super('_dispose');
    },

    /**
     * Resize the height of the drawer by expanding.
     */
    _resizeDrawer: _.throttle(function() {
        var drawers = this._getDrawers(false);
        // Do not resize the drawer when the drawer is in the middle of a transition.
        if (drawers.$top && !this._isInTransition(drawers.$top)) {
            this._expandDrawer(drawers.$top, drawers.$bottom);
        }
    }, 300)
})
