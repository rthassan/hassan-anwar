<?php
$clientCache['Forecasts']['base']['view'] = array (
  'tutorial' => 
  array (
    'meta' => 
    array (
      'records' => 
      array (
        'intro' => 'LBL_TOUR_FORECAST_INTRO',
        'version' => 1,
        'content' => 
        array (
          0 => 
          array (
            'name' => '.topline [for="date_filter"]',
            'text' => 'LBL_TOUR_FORECASTS_TIMEPERIODS',
            'full' => true,
            'horizAdj' => -15,
            'vertAdj' => -15,
          ),
          1 => 
          array (
            'name' => '.topline .last-commit',
            'text' => 'LBL_TOUR_FORECASTS_COMMITS',
            'full' => true,
            'horizAdj' => -20,
            'vertAdj' => -20,
          ),
          2 => 
          array (
            'name' => '.editableColumn',
            'text' => 'LBL_TOUR_FORECASTS_INLINEEDIT',
            'full' => true,
          ),
          3 => 
          array (
            'name' => '.dashlets .forecast-details',
            'text' => 'LBL_TOUR_FORECASTS_PROGRESS',
            'full' => true,
            'horizAdj' => -1,
            'vertAdj' => -5,
          ),
          4 => 
          array (
            'name' => '.dashlets .forecasts-chart-wrapper',
            'text' => 'LBL_TOUR_FORECASTS_CHART',
            'full' => true,
            'horizAdj' => -1,
            'vertAdj' => -5,
          ),
        ),
      ),
    ),
  ),
  'forecasts-chart' => 
  array (
    'controller' => 
    array (
      'base' => '/*
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
 * Dashlet that displays a chart
 */
({
    plugins: [\'Dashlet\'],

    /**
     * This is the values model for the template
     */
    values: new Backbone.Model(),

    className: \'forecasts-chart-wrapper\',

    /**
     * Hold the initOptions if we have to call the Forecast/init end point cause we are not on Forecasts
     */
    initOptions: null,

    /**
     * The context of the ForecastManagerWorksheet Module if one exists
     */
    forecastManagerWorksheetContext: undefined,

    /**
     * The context of the ForecastWorksheet Module if one exists
     */
    forecastWorksheetContext: undefined,

    /**
     * @inheritdoc
     */
    initialize: function(options) {
        this.values.clear({silent: true});
        // after we init, find and bind to the Worksheets Contexts
        this.once(\'init\', this.findWorksheetContexts, this);
        this.once(\'render\', function() {
            this.parseCollectionForData();
        }, this);
        this._super(\'initialize\', [options]);
        if (!this.meta.config) {
            var ctx = this.context.parent,
                user = ctx.get(\'selectedUser\') || app.user.toJSON(),
                showMgr = ctx.get(\'model\').get(\'forecastType\') == \'Rollup\';

            this.values.set({
                user_id: user.id,
                display_manager: showMgr,
                show_target_quota: (user.is_manager && !user.is_top_level_manager),
                ranges: ctx.get(\'selectedRanges\') || [\'include\'],
                timeperiod_id: ctx.get(\'selectedTimePeriod\'),
                dataset: \'likely\',
                group_by: \'forecast\',
                no_data: true
            });
        }
    },

    /**
     * Specific code to run after a dashlet Init Code has ran
     */
    initDashlet: function() {
        var fieldOptions,
            cfg = app.metadata.getModule(\'Forecasts\', \'config\');
        fieldOptions = app.lang.getAppListStrings(this.dashletConfig.dataset.options);
        this.dashletConfig.dataset.options = {};

        if (cfg.show_worksheet_worst &&
            app.acl.hasAccess(\'view\', \'ForecastWorksheets\', app.user.get(\'id\'), \'worst_case\')) {
            this.dashletConfig.dataset.options[\'worst\'] = fieldOptions[\'worst\'];
        }

        if (cfg.show_worksheet_likely) {
            this.dashletConfig.dataset.options[\'likely\'] = fieldOptions[\'likely\'];
        }

        if (cfg.show_worksheet_best &&
            app.acl.hasAccess(\'view\', \'ForecastWorksheets\', app.user.get(\'id\'), \'best_case\')) {
            this.dashletConfig.dataset.options[\'best\'] = fieldOptions[\'best\'];
        }

        // Hide dataset drop-down if there is only one option.
        this.dashletConfig.show_dataset = true;
        if (_.size(this.dashletConfig.dataset.options) <= 1) {
            this.dashletConfig.show_dataset = false;
        }
    },

    /**
     * Loop though the parent context children context to find the worksheet, if they exist
     */
    findWorksheetContexts: function() {
        // loop though the children context looking for the ForecastWorksheet and ForecastManagerWorksheet Modules
        _.filter(this.context.parent.children, function(item) {
            if (item.get(\'module\') == \'ForecastWorksheets\') {
                this.forecastWorksheetContext = item;
                return true;
            } else if (item.get(\'module\') == \'ForecastManagerWorksheets\') {
                this.forecastManagerWorksheetContext = item;
                return true;
            }
            return false;
        }, this);

        var collection;

        if (this.forecastWorksheetContext) {
            // listen for collection change events
            collection = this.forecastWorksheetContext.get(\'collection\');
            if (collection) {
                collection.on(\'change\', this.repWorksheetChanged, this);
                collection.on(\'reset\', function(collection) {
                    this.parseCollectionForData(collection);
                }, this);
            }
        }

        if (this.forecastManagerWorksheetContext) {
            // listen for collection change events
            collection = this.forecastManagerWorksheetContext.get(\'collection\');
            if (collection) {
                collection.on(\'change\', this.mgrWorksheetChanged, this);
                collection.on(\'reset\', function(collection) {
                    this.parseCollectionForData(collection);
                }, this);
            }
        }
    },

    /**
     * Figure out which way we need to parse a collection
     *
     * @param {Backbone.Collection} [collection]
     */
    parseCollectionForData: function(collection) {
        if (this.meta.config) {
            return;
        }
        // get the field
        var field = this.getField(\'paretoChart\');
        if(field && !field.hasServerData()) {
            // if the field does not have any data, wait for the xhr call to run and then just call this
            // method again
            field.once(\'chart:pareto:rendered\', this.parseCollectionForData, this);
            return;
        }

        if (this.values.get(\'display_manager\')) {
            this.parseManagerWorksheet(collection || this.forecastManagerWorksheetContext.get(\'collection\'));
        } else {
            this.parseRepWorksheet(collection || this.forecastWorksheetContext.get(\'collection\'));
        }
    },

    /**
     * Parses a chart data collection for the Rep worksheet
     *
     * @param {Backbone.Collection} collection
     */
    parseRepWorksheet: function(collection) {
        var field = this.getField(\'paretoChart\');
        if(field) {
            var serverData = field.getServerData();

            serverData.data = collection.map(function(item) {
                var i = {
                    id: item.get(\'id\'),
                    forecast: item.get(\'commit_stage\'),
                    probability: item.get(\'probability\'),
                    sales_stage: item.get(\'sales_stage\'),
                    likely: app.currency.convertWithRate(item.get(\'likely_case\'), item.get(\'base_rate\')),
                    date_closed_timestamp: parseInt(item.get(\'date_closed_timestamp\'))
                };

                if (!_.isUndefined(this.dashletConfig.dataset.options[\'best\'])) {
                    i.best = app.currency.convertWithRate(item.get(\'best_case\'), item.get(\'base_rate\'));
                }
                if (!_.isUndefined(this.dashletConfig.dataset.options[\'worst\'])) {
                    i.worst = app.currency.convertWithRate(item.get(\'worst_case\'), item.get(\'base_rate\'));
                }

                return i;
            }, this);

            field.setServerData(serverData, true);
        }
    },

    /**
     * Parses a chart data collection for the Manager worksheet
     *
     * @param {Backbone.Collection} collection
     */
    parseManagerWorksheet: function(collection) {
        var field = this.getField(\'paretoChart\');
        if(field) {
            var serverData = field.getServerData();

            serverData.data = collection.map(function(item) {
                var i = {
                    id: item.get(\'id\'),
                    user_id: item.get(\'user_id\'),
                    name: item.get(\'name\'),
                    likely: app.currency.convertWithRate(item.get(\'likely_case\'), item.get(\'base_rate\')),
                    likely_adjusted: app.currency.convertWithRate(item.get(\'likely_case_adjusted\'), item.get(\'base_rate\')),
                    quota: app.currency.convertWithRate(item.get(\'quota\'), item.get(\'base_rate\'))
                };

                if (!_.isUndefined(this.dashletConfig.dataset.options[\'best\'])) {
                    i.best = app.currency.convertWithRate(item.get(\'best_case\'), item.get(\'base_rate\'));
                    i.best_adjusted = app.currency.convertWithRate(item.get(\'best_case_adjusted\'), item.get(\'base_rate\'));
                }
                if (!_.isUndefined(this.dashletConfig.dataset.options[\'worst\'])) {
                    i.worst = app.currency.convertWithRate(item.get(\'worst_case\'), item.get(\'base_rate\'));
                    i.worst_adjusted = app.currency.convertWithRate(item.get(\'worst_case_adjusted\'), item.get(\'base_rate\'));
                }

                return i;
            }, this);

            serverData.quota = _.reduce(serverData.data, function(memo, item) {
                return app.math.add(memo, item.quota, undefined, true);
            }, 0);

            field.setServerData(serverData);
        }
    },

    /**
     * Handler for when the Rep Worksheet Changes
     * @param {Object} model
     */
    repWorksheetChanged: function(model) {
        // get what we are currently filtered by
        // find the item in the serverData
        var changed = model.changed,
            changedField = _.keys(changed),
            field = this.getField(\'paretoChart\'),
            serverData = field.getServerData();

        // if the changedField is date_closed, we need to adjust the timestamp as well since SugarLogic doesn\'t work
        // on list views yet
        if (changedField.length == 1 && changedField[0] == \'date_closed\') {
            // convert this into the timestamp
            changedField.push(\'date_closed_timestamp\');
            changed.date_closed_timestamp = Math.round(+app.date.parse(changed.date_closed).getTime() / 1000);
            model.set(\'date_closed_timestamp\', changed.date_closed_timestamp, {silent: true});
        }

        if (_.contains(changedField, \'likely_case\')) {
            changed.likely = app.currency.convertWithRate(changed.likely_case, model.get(\'base_rate\'));
            delete changed.likely_case;
        }
        if (_.contains(changedField, \'best_case\')) {
            changed.best = app.currency.convertWithRate(changed.best_case, model.get(\'base_rate\'));
            delete changed.best_case;
        }
        if (_.contains(changedField, \'worst_case\')) {
            changed.worst = app.currency.convertWithRate(changed.worst_case, model.get(\'base_rate\'));
            delete changed.worst_case;
        }

        if (_.contains(changedField, \'commit_stage\')) {
            changed.forecast = changed.commit_stage;
            delete changed.commit_stage;
        }

        _.find(serverData.data, function(record, i, list) {
            if (model.get(\'id\') == record.id) {
                list[i] = _.extend({}, record, changed);
                return true;
            }
            return false;
        });

        field.setServerData(serverData, _.contains(changedField, \'probability\'));
    },

    /**
     * Handler for when the Manager Worksheet Changes
     * @param {Object} model
     */
    mgrWorksheetChanged: function(model) {
        var fieldsChanged = _.keys(model.changed),
            changed = model.changed,
            field = this.getField(\'paretoChart\');
        if(field && field.hasServerData()) {
            var serverData = field.getServerData();

            if (_.contains(fieldsChanged, \'quota\')) {
                var q = parseInt(serverData.quota, 10);
                q = app.math.add(app.math.sub(q, model.previous(\'quota\')), model.get(\'quota\'));
                serverData.quota = q;
            } else {
                var f = _.first(fieldsChanged),
                    fieldChartName = f.replace(\'_case\', \'\');

                // find the user
                _.find(serverData.data, function(record, i, list) {
                    if (model.get(\'user_id\') == record.user_id) {
                        list[i][fieldChartName] = changed[f];
                        return true;
                    }
                    return false;
                });
            }

            field.setServerData(serverData);
        }
    },

    /**
     * When loadData is called, find the paretoChart field, if it exist, then have it render the chart
     *
     * @override
     */
    loadData: function(options) {
        var field = this.getField(\'paretoChart\');

        if (!_.isUndefined(field)) {
            field.once(\'chart:pareto:rendered\', this.parseCollectionForData, this);
            field.renderChart(options);
        }
        if (options && _.isFunction(options.complete)) {
            options.complete();
        }
    },

    /**
     * Called after _render
     */
    toggleRepOptionsVisibility: function() {
        this.$(\'div.groupByOptions\').toggleClass(\'hide\', this.values.get(\'display_manager\') === true);
    },

    /**
     * @inheritdoc
     */
    bindDataChange: function() {
        // on the off chance that the init has not run yet.
        var meta = this.meta || this.initOptions.meta;
        if (meta.config) {
            return;
        }

        this.values.on(\'change:title\', function(model, title) {
            this.layout.setTitle(app.lang.get(this.meta.label) + title);
        }, this);

        this.on(\'render\', function() {
            var field = this.getField(\'paretoChart\'),
                dashToolbar = this.layout.getComponent(\'dashlet-toolbar\');

            // if we have a dashlet-toolbar, then make it do the refresh icon while the chart is loading from the
            // server
            if (dashToolbar) {
                field.before(\'chart:pareto:render\', function() {
                    this.$("[data-action=loading]").removeClass(this.cssIconDefault).addClass(this.cssIconRefresh);
                }, {}, dashToolbar);
                field.on(\'chart:pareto:rendered\', function() {
                    this.$("[data-action=loading]").removeClass(this.cssIconRefresh).addClass(this.cssIconDefault);
                }, dashToolbar);
            }
            this.toggleRepOptionsVisibility();
            this.parseCollectionForData();
        }, this);

        var ctx = this.context.parent;

        ctx.on(\'change:selectedUser\', function(context, user) {
            var displayMgr = ctx.get(\'model\').get(\'forecastType\') == \'Rollup\',
                showTargetQuota = (displayMgr && !user.is_top_level_manager);
            this.values.set({
                user_id: user.id,
                display_manager: displayMgr,
                show_target_quota: showTargetQuota
            });
            this.toggleRepOptionsVisibility();
        }, this);
        ctx.on(\'change:selectedTimePeriod\', function(context, timePeriod) {
            this.values.set({timeperiod_id: timePeriod});
        }, this);
        ctx.on(\'change:selectedRanges\', function(context, value) {
            this.values.set({ranges: value});
        }, this);
    },

    /**
     * @inheritdoc
     */
    unbindData: function() {
        var ctx = this.context.parent;
        if (ctx) {
            ctx.off(null, null, this);
        }

        if (this.forecastManagerWorksheetContext && this.forecastManagerWorksheetContext.get(\'collection\')) {
            this.forecastManagerWorksheetContext.get(\'collection\').off(null, null, this);
        }

        if (this.forecastWorksheetContext && this.forecastWorksheetContext.get(\'collection\')) {
            this.forecastWorksheetContext.get(\'collection\').off(null, null, this);
        }

        if (this.context) {
            this.context.off(null, null, this);
        }

        if (this.values) {
            this.values.off(null, null, this);
        }

        this._super(\'unbindData\');
    }
})
',
    ),
    'meta' => 
    array (
      'dashlets' => 
      array (
        0 => 
        array (
          'label' => 'LBL_DASHLET_FORECASTS_CHART_NAME',
          'description' => 'LBL_DASHLET_FORECASTS_CHART_DESC',
          'config' => 
          array (
            'module' => 'Forecasts',
          ),
          'preview' => 
          array (
          ),
          'filter' => 
          array (
            'module' => 
            array (
              0 => 'Forecasts',
            ),
          ),
        ),
      ),
      'chart' => 
      array (
        'name' => 'paretoChart',
        'label' => 'Pareto Chart',
        'type' => 'forecast-pareto-chart',
      ),
      'timeperiod' => 
      array (
        0 => 
        array (
          'name' => 'selectedTimePeriod',
          'label' => 'TimePeriod',
          'type' => 'enum',
          'default' => true,
          'enabled' => true,
          'view' => 'edit',
        ),
      ),
      'group_by' => 
      array (
        'name' => 'group_by',
        'label' => 'LBL_DASHLET_FORECASTS_GROUPBY',
        'type' => 'enum',
        'searchBarThreshold' => 5,
        'default' => true,
        'enabled' => true,
        'view' => 'edit',
        'options' => 'forecasts_chart_options_group',
      ),
      'dataset' => 
      array (
        'name' => 'dataset',
        'label' => 'LBL_DASHLET_FORECASTS_DATASET',
        'type' => 'enum',
        'searchBarThreshold' => 5,
        'default' => true,
        'enabled' => true,
        'view' => 'edit',
        'options' => 'forecasts_options_dataset',
      ),
    ),
    'templates' => 
    array (
      'forecasts-chart' => '
<div class="dashlet-options">
    <div class="row-fluid">
        <div class="span4 groupByOptions">
            {{#with dashletConfig.group_by}}
                {{field ../this model=../this.values}}
            {{/with}}
        </div>
        {{#if dashletConfig.show_dataset}}
        <div class="span3">
            {{#with dashletConfig.dataset}}
                {{field ../this model=../this.values}}
            {{/with}}
        </div>
        {{/if}}
    </div>
</div>
{{#with dashletConfig.chart}}
    {{field ../this model=../this.values}}
{{/with}}

',
    ),
  ),
  'preview' => 
  array (
    'controller' => 
    array (
      'base' => '/*
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
 * @class View.Views.Base.Forecasts.PreviewView
 * @alias SUGAR.App.view.views.BaseForecastsPreviewView
 * @extends View.Views.Base.PreviewView
 */
({
    extendsFrom: \'PreviewView\',

    /**
     * Track the original model passed in from the worksheet, this is needed becuase of how the base preview works
     */
    originalModel: undefined,

    /**
     * {@inheritDoc}
     */
    closePreview: function() {
        this.originalModel = undefined;
        this._super("closePreview");
    },

    /**
     * Override _renderPreview to pull in the parent_type and parent_id when we are running a fetch
     *
     * @param model
     * @param collection
     * @param fetch
     * @param previewId
     * @param dontClose overrides triggering preview:close
     * @private
     */
    _renderPreview: function(model, collection, fetch, previewId, dontClose){
        var self = this;
        dontClose = dontClose || false;

        // If there are drawers there could be multiple previews, make sure we are only rendering preview for active drawer
        if(app.drawer && !app.drawer.isActive(this.$el)){
            return;  //This preview isn\'t on the active layout
        }

        // Close preview if we are already displaying this model
        if(!dontClose && this.originalModel && model && (this.originalModel.get("id") == model.get("id") && previewId == this.previewId)) {
            // Remove the decoration of the highlighted row
            app.events.trigger("list:preview:decorate", false);
            // Close the preview panel
            app.events.trigger(\'preview:close\');
            return;
        }

        if (model) {
            // Get the corresponding detail view meta for said module.
            // this.meta needs to be set before this.getFieldNames is executed.
            this.meta = app.metadata.getView(model.get(\'parent_type\') || model.get(\'_module\'), \'record\') || {};
            this.meta = this._previewifyMetadata(this.meta);
        }

        if (fetch) {
            var mdl = app.data.createBean(model.get(\'parent_type\'), {\'id\' : model.get(\'parent_id\')});
            this.originalModel = model;
            mdl.fetch({
                //Show alerts for this request
                showAlerts: true,
                success: function(model) {
                    self.renderPreview(model, collection);
                }
            });
        } else {
            this.renderPreview(model, collection);
        }

        this.previewId = previewId;
    },

    /**
     * Show previous and next buttons groups on the view.
     *
     * This gets called everytime the collection gets updated. It also depends
     * if we have a current model or layout.
     *
     * TODO we should check if we have the preview open instead of doing a bunch
     * of if statements.
     */
    showPreviousNextBtnGroup: function () {
        if (!this.model || !this.layout || !this.collection) {
            return;
        }
        var collection = this.collection;
        if (!collection.size()) {
            this.layout.hideNextPrevious = true;
        }
        // use the originalModel if one is defined, if not fall back to the basic model
        var model = this.originalModel || this.model;
        var recordIndex = collection.indexOf(collection.get(model.id));
        this.layout.previous = collection.models[recordIndex-1] ? collection.models[recordIndex-1] : undefined;
        this.layout.next = collection.models[recordIndex+1] ? collection.models[recordIndex+1] : undefined;
        this.layout.hideNextPrevious = _.isUndefined(this.layout.previous) && _.isUndefined(this.layout.next);

        // Need to rerender the preview header
        this.layout.trigger("preview:pagination:update");
    },

    /**
     * Renders the preview dialog with the data from the current model and collection
     * @param model Model for the object to preview
     * @param newCollection Collection of related objects to the current model
     */
    renderPreview: function(model, newCollection) {
        if(newCollection) {
            this.collection.reset(newCollection.models);
        }

        if (model) {
            this.model = app.data.createBean(model.module, model.toJSON());
            this.render();

            // TODO: Remove when pagination on activity streams is fixed.
            if (this.previewModule && this.previewModule === "Activities") {
                this.layout.hideNextPrevious = true;
                this.layout.trigger("preview:pagination:update");
            }
            // Open the preview panel
            app.events.trigger("preview:open",this);
            // Highlight the row
            // use the original model when going to the list:preview:decorate event
            app.events.trigger("list:preview:decorate", this.originalModel, this);
        }
    },

    /**
     * Switches preview to left/right model in collection.
     * @param {String} data direction Direction that we are switching to, either \'left\' or \'right\'.
     * @param index Optional current index in list
     * @param id Optional
     * @param module Optional
     */
    switchPreview: function(data, index, id, module) {
        var self = this,
            currModule = module || this.model.module,
            currID = id || this.model.get("postId") || this.model.get("id"),
            // use the originalModel vs the model
            currIndex = index || _.indexOf(this.collection.models, this.collection.get(this.originalModel.get(\'id\')));

        if( this.switching || this.collection.models.length < 2) {
            // We\'re currently switching previews or we don\'t have enough models, so ignore any pagination click events.
            return;
        }
        this.switching = true;
        // get the parent_id from the specific module
        if( data.direction === "left" && (currID === _.first(this.collection.models).get("parent_id")) ||
            data.direction === "right" && (currID === _.last(this.collection.models).get("parent_id")) ) {
            this.switching = false;
            return;
        }
        else {
            // We can increment/decrement
            data.direction === "left" ? currIndex -= 1 : currIndex += 1;

            // If there is no target_id, we don\'t have access to that activity record
            // The other condition ensures we\'re previewing from activity stream items.
            if( _.isUndefined(this.collection.models[currIndex].get("target_id")) &&
                this.collection.models[currIndex].get("activity_data") ) {

                currID = this.collection.models[currIndex].id;
                this.switching = false;
                this.switchPreview(data, currIndex, currID, currModule);
            } else {
                var targetModule = this.collection.models[currIndex].get("target_module") || currModule;

                this.model = app.data.createBean(targetModule);

                if( _.isUndefined(this.collection.models[currIndex].get("target_id")) ) {
                    // get the parent_id
                    this.model.set("id", this.collection.models[currIndex].get("parent_id"));
                } else {
                    this.model.set("postId", this.collection.models[currIndex].get("id"));
                    this.model.set("id", this.collection.models[currIndex].get("target_id"));
                }
                this.originalModel = this.collection.models[currIndex];
                this.model.fetch({
                    //Show alerts for this request
                    showAlerts: true,
                    success: function(model) {
                        model.set("_module", targetModule);
                        self.model = null;
                        //Reset the preview
                        app.events.trigger("preview:render", model, null, false);
                        self.switching = false;
                    }
                });
            }
        }
    }
})
',
    ),
  ),
  'forecast-pipeline' => 
  array (
    'meta' => 
    array (
      'dashlets' => 
      array (
        0 => 
        array (
          'label' => 'LBL_DASHLET_PIPELINE_CHART_NAME',
          'description' => 'LBL_DASHLET_PIPELINE_CHART_DESC',
          'config' => 
          array (
            'module' => 'Forecasts',
          ),
          'preview' => 
          array (
            'module' => 'Forecasts',
          ),
          'filter' => 
          array (
            'module' => 
            array (
              0 => 'Home',
              1 => 'Accounts',
              2 => 'Opportunities',
              3 => 'RevenueLineItems',
            ),
            'view' => 
            array (
              0 => 'record',
              1 => 'records',
            ),
          ),
        ),
      ),
      'panels' => 
      array (
        0 => 
        array (
          'name' => 'panel_body',
          'columns' => 2,
          'labelsOnTop' => true,
          'placeholders' => true,
          'fields' => 
          array (
            0 => 
            array (
              'name' => 'visibility',
              'label' => 'LBL_DASHLET_CONFIGURE_MY_ITEMS_ONLY',
              'type' => 'enum',
              'options' => 'forecast_pipeline_visibility_options',
              'enum_width' => 'auto',
            ),
          ),
        ),
      ),
      'timeperiod' => 
      array (
        0 => 
        array (
          'name' => 'selectedTimePeriod',
          'label' => 'TimePeriod',
          'type' => 'timeperiod',
        ),
      ),
    ),
    'templates' => 
    array (
      'forecast-pipeline' => '
<div class="dashlet-options">
    <div class="row-fluid">
        <div class="span4">{{#each dashletConfig.timeperiod}}
            {{field ../this model=../this.settings template="edit"}}
        {{/each}}</div>
        {{#if isManager}}
        <div class="span8">
            <div class="btn-group pull-right dashlet-group" data-toggle="buttons-radio">
                <button class="btn{{#eq settings.attributes.visibility "user"}} active{{/eq}}"
                        data-action="visibility-switcher" rel="tooltip" data-placement="bottom" value="user"
                        title="{{{str "LBL_DASHLET_MY_PIPELINE" \'Forecasts\' this.context}}}"
                        track="click:viewMyUserPipeline">
                    <i class="fa fa-user"></i>
                </button>
                <button class="btn{{#eq settings.attributes.visibility "group"}} active{{/eq}}"
                        data-action="visibility-switcher" rel="tooltip" data-placement="bottom"
                        value="group" title="{{{str "LBL_DASHLET_MY_TEAMS_PIPELINE" \'Forecasts\' this.context}}}"
                        track="click:viewMyTeamsPipeline">
                    <i class="fa fa-users"></i>
                </button>
            </div>
        </div>
        {{/if}}
    </div>
</div>
<div class="opportunity-pipeline-wrapper">
    <div class="nv-chart nv-funnelChart" data-content="chart">
        <svg id="{{cid}}"></svg>
    </div>
    <div class="block-footer hide" data-content="nodata">{{str "LBL_NO_DATA_AVAILABLE"}}</div>
</div>
',
    ),
    'controller' => 
    array (
      'base' => '/*
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
({
    results: {},
    chart: {},
    plugins: [\'Dashlet\', \'Chart\', \'Tooltip\'],

    /**
     * Is the forecast Module setup??
     */
    forecastSetup: 0,

    /**
     * Holds the forecast isn\'t set up message if Forecasts hasn\'t been set up yet
     */
    forecastsNotSetUpMsg: undefined,

    /**
     * Track if current user is manager.
     */
    isManager: false,

    /**
     * @inheritDoc
     */
    initialize: function(options) {
        this.isManager = app.user.get(\'is_manager\');
        this._initPlugins();
        this._super(\'initialize\', [options]);

        // check to make sure that forecast is configured
        this.forecastSetup = app.metadata.getModule(\'Forecasts\', \'config\').is_setup;
    },

    /**
     * {@inheritDoc}
     */
    initDashlet: function(view) {
        if (!this.isManager && this.meta.config) {
            // FIXME: Dashlet\'s config page is rendered from meta.panels directly.
            // See the "dashletconfiguration-edit.hbs" file.
            this.meta.panels = _.chain(this.meta.panels).filter(function(panel) {
                panel.fields = _.without(panel.fields, _.findWhere(panel.fields, {name: \'visibility\'}));
                return panel;
            }).value();
        }
        // get the current timeperiod
        if (this.forecastSetup) {
            app.api.call(\'GET\', app.api.buildURL(\'TimePeriods/current\'), null, {
                success: _.bind(function(currentTP) {
                    this.settings.set({\'selectedTimePeriod\': currentTP.id}, {silent: true});
                    this.layout.loadData();
                }, this),
                error: _.bind(function() {
                    // Needed to catch the 404 in case there isnt a current timeperiod
                }, this),
                complete: view.options ? view.options.complete : null
            });
        } else {
            this.settings.set({\'selectedTimePeriod\': \'current\'}, {silent: true});
        }
        this.chart = nv.models.funnelChart()
            .showTitle(false)
            .tooltips(true)
            .margin({top: 0})
            .direction(app.lang.direction)
            .tooltipContent(function(key, x, y, e, graph) {
                var val = app.currency.formatAmountLocale(y, app.currency.getBaseCurrencyId());
                var salesStageLabels = app.lang.getAppListStrings(\'sales_stage_dom\');
                return \'<p>\' + SUGAR.App.lang.get(\'LBL_SALES_STAGE\', \'Forecasts\') + \': <b>\' + ((salesStageLabels && salesStageLabels[key]) ? salesStageLabels[key] : key) + \'</b></p>\' +
                    \'<p>\' + SUGAR.App.lang.get(\'LBL_AMOUNT\', \'Forecasts\') + \': <b>\' + val + \'</b></p>\' +
                    \'<p>\' + SUGAR.App.lang.get(\'LBL_PERCENT\', \'Forecasts\') + \': <b>\' + x + \'%</b></p>\';
            })
            .colorData(\'class\', {step: 2})
            .fmtValueLabel(function(d) {
                var y = d.label || d;
                return app.currency.formatAmountLocale(y, app.currency.getBaseCurrencyId()).replace(/\\,00$|\\.00$/,\'\');
            })
            .strings({
                legend: {
                    close: app.lang.get(\'LBL_CHART_LEGEND_CLOSE\'),
                    open: app.lang.get(\'LBL_CHART_LEGEND_OPEN\')
                },
                noData: app.lang.get(\'LBL_CHART_NO_DATA\')
            });
    },


    /**
     * Initialize plugins.
     * Only manager can toggle visibility.
     *
     * @return {View.Views.BaseForecastPipeline} Instance of this view.
     * @protected
     */
    _initPlugins: function() {
        if (this.isManager) {
            this.plugins = _.union(this.plugins, [
                \'ToggleVisibility\'
            ]);
        }
        return this;
    },

    /**
     * {@inheritDoc}
     */
    bindDataChange: function() {
        this.settings.on(\'change\', function(model) {
            // reload the chart
            if (this.$el && this.$el.is(\':visible\')) {
                this.loadData({});
            }
        }, this);
    },

    /**
     * Generic method to render chart with check for visibility and data.
     * Called by _renderHtml and loadData.
     */
    renderChart: function() {
        if (!this.isChartReady()) {
            return;
        }
        // Clear out the current chart before a re-render
        this.$(\'svg#\' + this.cid).children().remove();

        d3.select(\'svg#\' + this.cid)
            .datum(this.results)
            .transition().duration(500)
            .call(this.chart);

        this.chart_loaded = _.isFunction(this.chart.update);
        this.displayNoData(!this.chart_loaded);
    },

    hasChartData: function() {
        return !_.isEmpty(this.results) && this.results.data && this.results.data.length > 0;
    },

    /**
     * @inheritDoc
     */
    loadData: function(options) {
        var timeperiod = this.settings.get(\'selectedTimePeriod\');
        if (timeperiod) {
            var forecastBy = app.metadata.getModule(\'Forecasts\', \'config\').forecast_by || \'Opportunities\',
                url_base = forecastBy + \'/chart/pipeline/\' + timeperiod + \'/\';

            if (this.isManager) {
                url_base += \'/\' + this.getVisibility();
            }
            var url = app.api.buildURL(url_base);
            app.api.call(\'GET\', url, null, {
                success: _.bind(function(o) {
                    if (o && o.data) {
                        var salesStageLabels = app.lang.getAppListStrings(\'sales_stage_dom\');

                        // update sales stage labels to translated strings
                        _.each(o.data, function(dataBlock) {
                            if (dataBlock && dataBlock.key && salesStageLabels && salesStageLabels[dataBlock.key]) {
                                dataBlock.key = salesStageLabels[dataBlock.key];
                            }

                        });
                    }
                    this.results = {};
                    this.results = o;
                    this.renderChart();
                }, this),
                error: _.bind(function(o) {
                    this.results = {};
                    this.renderChart();
                }, this),
                complete: options ? options.complete : null
            });
        }
    },

    /**
     * @inheritDoc
     */
    unbind: function() {
        this.settings.off(\'change\');
        this._super(\'unbind\');
    }
})
',
    ),
  ),
  'config-timeperiods' => 
  array (
    'templates' => 
    array (
      'config-timeperiods' => '
<div class="accordion-heading">
    <a id=\'{{name}}Title\' class="accordion-toggle" data-help-id="{{name}}" data-toggle="collapse" data-parent="#config-accordion" href="#{{name}}Collapse"></a>
</div>
<div id="{{name}}Collapse" class="accordion-body collapse">
    <div class="accordion-inner">
        {{#each meta.panels}}
            <p>{{str "LBL_FORECASTS_CONFIG_TIMEPERIOD_DESC" "Forecasts"}}</p>
            <ol>
                {{#each fields}}
                    {{#if enabled}}
                        <li>
                            <p>{{{str ../label "Forecasts"}}}</p>
                            <p>{{field ../../../this model=../../../model}}</p>
                            <p id="{{../name}}_sublabel"></p>
                            <p id="{{../name}}_subfield"></p>
                        </li>
                    {{/if}}
                {{/each}}
            </ol>
        {{/each}}
    </div>
</div>
',
    ),
    'meta' => 
    array (
      'label' => 'LBL_FORECASTS_CONFIG_BREADCRUMB_TIMEPERIODS',
      'panels' => 
      array (
        0 => 
        array (
          'fields' => 
          array (
            0 => 
            array (
              'name' => 'timeperiod_interval',
              'type' => 'enum',
              'options' => 'forecasts_timeperiod_options_dom',
              'searchBarThreshold' => 5,
              'label' => 'LBL_FORECASTS_CONFIG_TIMEPERIOD',
              'default' => false,
              'enabled' => true,
              'view' => 'edit',
            ),
            1 => 
            array (
              'name' => 'timeperiod_start_date',
              'type' => 'date',
              'label' => 'LBL_FORECASTS_CONFIG_START_DATE',
              'default' => false,
              'enabled' => true,
              'view' => 'detail',
            ),
            2 => 
            array (
              'name' => 'timeperiod_fiscal_year',
              'type' => 'fiscal-year',
              'options' => 'forecast_fiscal_year_options',
              'label' => 'LBL_FORECASTS_CONFIG_TIMEPERIOD_FISCAL_YEAR',
              'default' => false,
              'enabled' => true,
              'view' => 'edit',
            ),
            3 => 
            array (
              'name' => 'timeperiod_shown_forward',
              'type' => 'enum',
              'options' => 
              array (
                1 => 1,
                2 => 2,
                3 => 3,
                4 => 4,
                5 => 5,
              ),
              'searchBarThreshold' => 5,
              'label' => 'LBL_FORECASTS_CONFIG_TIMEPERIODS_FORWARD',
              'default' => false,
              'enabled' => true,
              'view' => 'edit',
            ),
            4 => 
            array (
              'name' => 'timeperiod_shown_backward',
              'type' => 'enum',
              'options' => 
              array (
                1 => 1,
                2 => 2,
                3 => 3,
                4 => 4,
                5 => 5,
              ),
              'searchBarThreshold' => 5,
              'label' => 'LBL_FORECASTS_CONFIG_TIMEPERIODS_BACKWARD',
              'default' => false,
              'enabled' => true,
              'view' => 'edit',
            ),
          ),
        ),
      ),
    ),
    'controller' => 
    array (
      'base' => '/*
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
 * @class View.Views.Base.ForecastsConfigTimeperiodsView
 * @alias SUGAR.App.view.layouts.BaseForecastsConfigTimeperiodsView
 * @extends View.Views.Base.ConfigPanelView
 */
({
    extendsFrom: \'ConfigPanelView\',

    /**
     * Holds the moment.js date object
     * @type Moment
     */
    tpStartDate: undefined,

    /**
     * If the Fiscal Year field is displayed, this holds the reference to the field
     */
    fiscalYearField: undefined,

    /**
     * Holds the timeperiod_fiscal_year metadata so it doesn\'t render until the view needs it
     */
    fiscalYearMeta: undefined,

    /**
     * @inheritdoc
     */
    initialize: function(options) {
        // remove the fiscal year metadata since we cant use the enabled check
        var fieldsMeta = _.filter(_.first(options.meta.panels).fields, function(field) {
            if(field.name === \'timeperiod_fiscal_year\') {
                this.fiscalYearMeta = _.clone(field);
            }
            // return all fields except fiscal year
            return field.name !== \'timeperiod_fiscal_year\';
        }, this);

        // put updated fields back into options
        _.first(options.meta.panels).fields = fieldsMeta;

        this._super(\'initialize\', [options]);

        // check if Forecasts is set up, if so, make the timeperiod field readonly
        if(!this.model.get(\'is_setup\')) {
            _.each(fieldsMeta, function(field) {
                if(field.name == \'timeperiod_start_date\') {
                    field.click_to_edit = true;
                }
            }, this);
        }

        this.tpStartDate = this.model.get(\'timeperiod_start_date\');
        if (this.tpStartDate) {
            // convert the tpStartDate to a Moment object
            this.tpStartDate = app.date(this.tpStartDate);
        }
    },

    /**
     * @inheritdoc
     * @override
     */
    _updateTitleValues: function() {
        this.titleSelectedValues = (this.tpStartDate) ? this.tpStartDate.formatUser(true) : \'\';
    },

    /**
     * Checks the timeperiod start date to see if it\'s 01/01 to know
     * if we need to display the Fiscal Year field or not
     */
    checkFiscalYearField: function() {
        // moment.js months are zero-based: 0 = January
        if (this.tpStartDate.month() !== 0 ||
            (this.tpStartDate.month() === 0 && this.tpStartDate.date() !== 1)) {
            // if the start date\'s month isn\'t Jan,
            // or it IS Jan but a date other than the 1st, add the field
            this.addFiscalYearField();
        } else if(this.fiscalYearField) {
            this.model.set({
                timeperiod_fiscal_year: null
            });
            this.removeFiscalYearField();
        }
    },

    /**
     * @inheritdoc
     */
    bindDataChange: function() {
        if(this.model) {
            this.model.once(\'change\', function(model) {
                // on a fresh install with no demo data,
                // this.model has the values and the param model is undefined
                if(_.isUndefined(model)) {
                    model = this.model;
                }
            }, this);

            this.model.on(\'change:timeperiod_start_date\', function(model) {
                this.tpStartDate = app.date(model.get(\'timeperiod_start_date\'));
                this.checkFiscalYearField();
                this.titleSelectedValues = this.tpStartDate.formatUser(true);
                this.updateTitle();
            }, this);
        }
    },

    /**
     * Creates the fiscal-year field and adds it to the DOM
     */
    addFiscalYearField: function() {
        if(!this.fiscalYearField) {
            // set the value so the fiscal-year field chooses its first option
            // in the dropdown
            this.model.set({
                timeperiod_fiscal_year: \'current_year\'
            });

            var $el = this.$(\'#timeperiod_start_date_subfield\');
            if ($el) {
                var fiscalYearFieldMeta = this.updateFieldMetadata(this.fiscalYearMeta),
                    fieldSettings = {
                        view: this,
                        def: fiscalYearFieldMeta,
                        viewName: \'edit\',
                        context: this.context,
                        module: this.module,
                        model: this.model,
                        meta: app.metadata.getField(\'enum\')
                    };

                this.fiscalYearField = app.view.createField(fieldSettings);

                $el.html(this.fiscalYearField.el);
                this.fiscalYearField.render();
            }
        }
    },

    /**
     * Takes the default fiscal-year metadata and adds any dynamic values
     * Done in function form in case this field ever needs to be extended with
     * more than just 2 years
     *
     * @param {Object} fieldMeta The field\'s metadata
     * @returns {Object}
     */
    updateFieldMetadata: function(fieldMeta) {
        fieldMeta.startYear = this.tpStartDate.year();
        return fieldMeta;
    },

    /**
     * Disposes the fiscal-year field and removes it from the DOM
     */
    removeFiscalYearField: function() {
        this.model.set({
            timeperiod_fiscal_year: null
        });
        this.fiscalYearField.dispose();
        this.fiscalYearField = null;
        this.$(\'#timeperiod_start_date_subfield\').html(\'\')
    },

    /**
     * @inheritdoc
     *
     * Sets up a binding to the start month dropdown to populate the day drop down on change
     *
     * @param {View.Field} field
     * @private
     */
    _renderField: function(field) {
        field = this._setUpTimeperiodConfigField(field);

        // check for all fields, if forecast is setup, set to detail/readonly mode
        if(this.model.get(\'is_setup\')) {
            field.options.def.view = \'detail\';
        } else if(field.name == \'timeperiod_start_date\') {
            // if this is the timeperiod_start_date field and Forecasts is not setup
            field.options.def.click_to_edit = true;
        }

        this._super(\'_renderField\', [field]);

        if (field.name == \'timeperiod_start_date\') {
            if (this.model.get(\'is_setup\')) {
                var year = this.model.get(\'timeperiod_start_date\').substring(0, 4),
                    str,
                    $el;

                if (this.model.get(\'timeperiod_fiscal_year\') === \'next_year\') {
                    year++;
                }

                str = app.lang.get(\'LBL_FISCAL_YEAR\', \'Forecasts\') + \': \' + year;
                $el = this.$(\'#timeperiod_start_date_sublabel\');
                if ($el) {
                    $el.html(str);
                }
            } else {
                this.tpStartDate = app.date(this.model.get(\'timeperiod_start_date\'));
                this.checkFiscalYearField();
            }
        }
    },

    /**
     * Sets up the fields with the handlers needed to properly get and set their values for the timeperiods config view.
     *
     * @param {View.Field} field the field to be setup for this config view.
     * @return {*} field that has been properly setup and augmented to function for this config view.
     * @private
     */
    _setUpTimeperiodConfigField: function(field) {
        switch(field.name) {
            case "timeperiod_shown_forward":
            case "timeperiod_shown_backward":
                return this._setUpTimeperiodShowField(field);
            case "timeperiod_interval":
                return this._setUpTimeperiodIntervalBind(field);
            default:
                return field;
        }
    },

    /**
     * Sets up the timeperiod_shown_forward and timeperiod_shown_backward dropdowns to set the model and values properly
     *
     * @param {View.Field} field The field being set up.
     * @return {*} The configured field.
     * @private
     */
    _setUpTimeperiodShowField: function (field) {
        // ensure Date object gets an additional function
        field.events = _.extend({"change input":  "_updateSelection"}, field.events);
        field.bindDomChange = function() {};

        field._updateSelection = function(event) {
            var value =  $(event.currentTarget).val();
            this.def.value = value;
            this.model.set(this.name, value);
        };

        // force value to a string so hbs has helper will match the dropdown correctly
        this.model.set(field.name, this.model.get(field.name).toString(), {silent: true});

        field.def.value = this.model.get(field.name) || 1;
        return field;
    },

    /**
     * Sets up the change event on the timeperiod_interval drop down to maintain the interval selection
     * and push in the default selection for the leaf period
     *
     * @param {View.Field} field the dropdown interval field
     * @return {*}
     * @private
     */
    _setUpTimeperiodIntervalBind: function(field) {
        field.def.value = this.model.get(field.name);

        // ensure selected day functions like it should
        field.events = _.extend({"change input":  "_updateIntervals"}, field.events);
        field.bindDomChange = function() {};

        if(typeof(field.def.options) == \'string\') {
            field.def.options = app.lang.getAppListStrings(field.def.options);
        }

        /**
         * function that updates the selected interval
         * @param event
         * @private
         */
        field._updateIntervals = function(event) {
            //get the timeperiod interval selector
            var selected_interval = $(event.currentTarget).val();
            this.def.value = selected_interval;
            this.model.set(this.name, selected_interval);
            this.model.set(\'timeperiod_leaf_interval\', selected_interval == \'Annual\' ? \'Quarter\' : \'Month\');
        }

        return field;
    }
})
',
    ),
  ),
  'list-headerpane' => 
  array (
    'templates' => 
    array (
      'list-headerpane' => '
<div class="headerpane">
    <h1>
        <div class="record-cell">
            <span class="module-title pull-left">{{title}}</span>
            {{#if meta.tree}}
                {{#each meta.tree}}
                    {{field ../this}}
                {{/each}}
            {{/if}}
        </div>
        <div class="btn-toolbar pull-right dropdown">
            {{#each meta.buttons}}
                {{field ../this}}
            {{/each}}
        </div>
    </h1>
</div>
',
    ),
    'meta' => 
    array (
      'tree' => 
      array (
        0 => 
        array (
          'type' => 'reportingUsers',
          'acl_action' => 'is_manager',
        ),
      ),
      'buttons' => 
      array (
        0 => 
        array (
          'name' => 'save_draft_button',
          'events' => 
          array (
            'click' => 'button:save_draft_button:click',
          ),
          'type' => 'button',
          'label' => 'LBL_SAVE_DRAFT',
          'acl_action' => 'current_user',
        ),
        1 => 
        array (
          'type' => 'actiondropdown',
          'name' => 'main_dropdown',
          'primary' => true,
          'buttons' => 
          array (
            0 => 
            array (
              'name' => 'commit_button',
              'type' => 'button',
              'label' => 'LBL_QC_COMMIT_BUTTON',
              'events' => 
              array (
                'click' => 'button:commit_button:click',
              ),
              'tooltip' => 'LBL_COMMIT_TOOLTIP',
              'css_class' => 'btn-primary',
              'icon' => 'fa-arrow-circle-o-up',
              'acl_action' => 'current_user',
              'primary' => true,
            ),
            1 => 
            array (
              'name' => 'assign_quota',
              'type' => 'assignquota',
              'label' => 'LBL_ASSIGN_QUOTA_BUTTON',
              'events' => 
              array (
                'click' => 'button:assign_quota:click',
              ),
              'acl_action' => 'manager_current_user',
            ),
            2 => 
            array (
              'name' => 'export_button',
              'type' => 'rowaction',
              'label' => 'LBL_EXPORT_CSV',
              'event' => 'button:export_button:click',
            ),
            3 => 
            array (
              'name' => 'settings_button',
              'type' => 'rowaction',
              'label' => 'LBL_FORECAST_SETTINGS',
              'acl_action' => 'developer',
              'route' => 
              array (
                'action' => 'config',
              ),
              'events' => 
              array (
                'click' => 'button:settings_button:click',
              ),
            ),
          ),
        ),
        2 => 
        array (
          'name' => 'sidebar_toggle',
          'type' => 'sidebartoggle',
        ),
      ),
    ),
    'controller' => 
    array (
      'base' => '/*
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
 * @class View.Views.Base.ForecastsListHeaderpaneView
 * @alias SUGAR.App.view.layouts.BaseForecastsListHeaderpaneView
 * @extends View.Views.Base.ListHeaderpaneView
 */
({
    extendsFrom: \'HeaderpaneView\',

    plugins: [\'FieldErrorCollection\'],

    /**
     * Boolean if the Save button should be disabled or not
     */
    saveBtnDisabled: true,

    /**
     * Boolean if the Save button should be disabled or not
     */
    commitBtnDisabled: true,

    /**
     * Boolean if any fields in the view have errors or not
     */
    fieldHasErrorState: false,

    /**
     * @inheritdoc
     */
    initialize: function(options) {
        this._super("initialize", [options]);

        this.on(\'render\', function() {
            this.getField(\'save_draft_button\').setDisabled();
            // this is a hacky way to add the class but it needs to be done for proper spacing
            this.getField(\'save_draft_button\').$el.addClass(\'btn-group\');
            this.getField(\'commit_button\').setDisabled();
        }, this);
    },

    /**
     * @inheritdoc
     */
    bindDataChange: function() {
        this.context.on(\'change:selectedUser\', function(model, changed) {
            this._title = changed.full_name;
            if (!this.disposed) {
                this.render();
            }
        }, this);

        this.context.on(\'plugin:fieldErrorCollection:hasFieldErrors\', function(collection, hasErrors) {
            if(this.fieldHasErrorState !== hasErrors) {
                this.fieldHasErrorState = hasErrors;
                this.setButtonStates();
            }
        }, this)

        this.context.on(\'button:print_button:click\', function() {
            window.print();
        }, this);

        this.context.on(\'forecasts:worksheet:is_dirty\', function(worksheet_type, is_dirty) {
            is_dirty = !is_dirty;
            if (this.saveBtnDisabled !== is_dirty || this.commitBtnDisabled !== is_dirty) {
                this.saveBtnDisabled = is_dirty;
                this.commitBtnDisabled = is_dirty;
                this.setButtonStates();
            }
        }, this);

        this.context.on(\'button:commit_button:click button:save_draft_button:click\', function() {
            if (!this.saveBtnDisabled || !this.commitBtnDisabled) {
                this.saveBtnDisabled = true;
                this.commitBtnDisabled = true;
                this.setButtonStates();
            }
        }, this);

        this.context.on(\'forecasts:worksheet:saved\', function(totalSaved, worksheet_type, wasDraft){
            if(wasDraft === true && this.commitBtnDisabled) {
                this.commitBtnDisabled = false;
                this.setButtonStates();
            }
        }, this);

        this.context.on(\'forecasts:worksheet:needs_commit\', function(worksheet_type) {
            if (this.commitBtnDisabled) {
                this.commitBtnDisabled = false;
                this.setButtonStates();
            }
        }, this);

        this._super("bindDataChange");
    },

    /**
     * Sets the Save Button and Commit Button to enabled or disabled
     */
    setButtonStates: function() {
        // fieldHasErrorState trumps the disabled flags, but when it\'s cleared
        // revert back to whatever states the buttons were in
        if (this.fieldHasErrorState) {
            this.getField(\'save_draft_button\').setDisabled(true);
            this.getField(\'commit_button\').setDisabled(true);
        } else {
            this.getField(\'save_draft_button\').setDisabled(this.saveBtnDisabled);
            this.getField(\'commit_button\').setDisabled(this.commitBtnDisabled);
        }
    },

    /**
     * @inheritdoc
     */
    _renderHtml: function() {
        var user = this.context.get(\'selectedUser\') || app.user.toJSON();
        this._title = this._title || user.full_name;

        this._super("_renderHtml");
    }
})
',
    ),
  ),
  'help-dashlet' => 
  array (
    'controller' => 
    array (
      'base' => '/*
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
({
    extendsFrom: \'HelpDashletView\',

    /**
     * @override
     *
     * We also add the forecast_by module to the context, that we are passing in, so we can have a dynamic name for
     * for when we are using the help dashlet on the forecast module
     */
    getHelpObject: function() {
        var config = app.metadata.getModule(\'Forecasts\', \'config\'),
            helpUrl = {
                forecastby_singular_module: app.lang.getModuleName(config.forecast_by),
                forecastby_module: app.lang.getModuleName(config.forecast_by, {plural: true}),
                more_info_url: this.createMoreHelpLink(),
                more_info_url_close: \'</a>\'
            },
            ctx = this.context && this.context.parent || this.context,
            layout = (this.meta.preview) ? \'preview\' : ctx.get(\'layout\');

        this.helpObject = app.help.get(ctx.get(\'module\'), layout, helpUrl);

        // if title is empty for some reason, use the dashlet label as the fallback
        if (_.isEmpty(this.helpObject.title)) {
            this.helpObject.title = app.lang.get(this.meta.label);
        }
    }
})
',
    ),
  ),
  'config-header-buttons' => 
  array (
    'controller' => 
    array (
      'base' => '/*
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
 * @class View.Views.Base.ForecastsConfigHeaderButtonsView
 * @alias SUGAR.App.view.layouts.BaseForecastsConfigHeaderButtonsView
 * @extends View.Views.Base.ConfigHeaderButtonsView
 */
({
    extendsFrom: \'ConfigHeaderButtonsView\',

    /**
     * @inheritdoc
     * @override
     */
    _beforeSaveConfig: function() {
        var ctxModel = this.context.get(\'model\');

        // Set config settings before saving
        ctxModel.set({
            is_setup:true,
            show_forecasts_commit_warnings: true
        });

        // update the commit_stages_included property and
        // remove \'include_in_totals\' from the ranges so it doesn\'t get saved
        if(ctxModel.get(\'forecast_ranges\') == \'show_custom_buckets\') {
            var ranges = ctxModel.get(\'show_custom_buckets_ranges\'),
                labels = ctxModel.get(\'show_custom_buckets_options\'),
                commitStages = [],
                finalLabels = [];

            ctxModel.unset(\'commit_stages_included\');
            _.each(ranges, function(range, key) {
                if(range.in_included_total) {
                    commitStages.push(key)
                }
                delete range.in_included_total;

                finalLabels.push([key, labels[key]]);
            }, this);

            ctxModel.set({
                commit_stages_included: commitStages,
                show_custom_buckets_ranges: ranges,
                show_custom_buckets_options: finalLabels
            }, {silent: true});
        }
    },

    /**
     * @inheritdoc
     */
    _handleCancelRedirect: function() {
        if (this.context.get(\'model\').get(\'is_setup\') == 0) {
            app.router.goBack();
        }
    }
})
',
    ),
  ),
  'config-scenarios' => 
  array (
    'meta' => 
    array (
      'label' => 'LBL_FORECASTS_CONFIG_BREADCRUMB_SCENARIOS',
      'panels' => 
      array (
        0 => 
        array (
          'fields' => 
          array (
            0 => 
            array (
              'name' => 'show_worksheet_likely',
              'type' => 'bool',
              'label' => 'LBL_FORECASTS_CONFIG_WORKSHEET_SCENARIOS_LIKELY',
              'default' => false,
              'enabled' => true,
              'view' => 'detail',
            ),
            1 => 
            array (
              'name' => 'show_worksheet_best',
              'type' => 'bool',
              'label' => 'LBL_FORECASTS_CONFIG_WORKSHEET_SCENARIOS_BEST',
              'default' => false,
              'enabled' => true,
              'view' => 'forecastsWorksheet',
            ),
            2 => 
            array (
              'name' => 'show_worksheet_worst',
              'type' => 'bool',
              'label' => 'LBL_FORECASTS_CONFIG_WORKSHEET_SCENARIOS_WORST',
              'default' => false,
              'enabled' => true,
              'view' => 'forecastsWorksheet',
            ),
          ),
        ),
      ),
    ),
    'controller' => 
    array (
      'base' => '/*
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
 * @class View.Views.Base.ForecastsConfigScenariosView
 * @alias SUGAR.App.view.layouts.BaseForecastsConfigScenariosView
 * @extends View.Views.Base.ConfigPanelView
 */
({
    extendsFrom: \'ConfigPanelView\',

    /**
     * Holds ALL possible different scenarios
     */
    scenarioOptions: [],

    /**
     * Holds the scenario objects that should start selected by default
     */
    selectedOptions: [],

    /**
     * Holds the option from config that users cannot change
     */
    defaultOption: {},

    /**
     * Holds the select2 instance of the default scenario that users cannot change
     */
    defaultSelect2: undefined,

    /**
     * Holds the select2 instance of the options that users can add/remove
     */
    optionsSelect2: undefined,

    /**
     * The default key used for the "Amount" value in forecasts, right now it is "likely" but users will be able to
     * change that in admin to be best or worst
     *
     * todo: eventually this will be moved to config settings where users can select their default forecasted value likely/best/worst
     */
    defaultForecastedAmountKey: \'show_worksheet_likely\',

    /**
     * @inheritdoc
     */
    initialize: function(options) {
        this._super(\'initialize\', [options]);

        this.selectedOptions = [];
        this.defaultOption = {};
        this.scenarioOptions = [];

        // set up scenarioOptions
        _.each(this.meta.panels[0].fields, function(field) {
            var obj = {
                id: field.name,
                text: app.lang.get(field.label, \'Forecasts\')
            }

            // Check if this field is the one we don\'t want users to delete
            if(field.name == this.defaultForecastedAmountKey) {
                obj[\'locked\'] = true;
                this.defaultOption = obj;
            } else {
                // Push fields to all other scenario options
                this.scenarioOptions.push(obj);
            }

            // if this should be selected by default and it is not the undeletable scenario, push it to selectedOptions
            if(this.model.get(field.name) == 1 && !obj.locked) {
                // push fields that should be selected to selectedOptions
                this.selectedOptions.push(obj);
            }
        }, this);
    },

    /**
     * @inheritdoc
     *
     * Empty function as the title values have already been set properly
     * with the change:scenarios event handler
     *
     * @override
     */
    _updateTitleValues: function() {
    },

    /**
     * @inheritdoc
     */
    bindDataChange: function() {
        this.model.on(\'change:scenarios\', function(model) {
            var arr = [];

            if(model.get(\'show_worksheet_likely\')) {
                arr.push(app.lang.get(\'LBL_FORECASTS_CONFIG_WORKSHEET_SCENARIOS_LIKELY\', \'Forecasts\'));
            }
            if(model.get(\'show_worksheet_best\')) {
                arr.push(app.lang.get(\'LBL_FORECASTS_CONFIG_WORKSHEET_SCENARIOS_BEST\', \'Forecasts\'));
            }
            if(model.get(\'show_worksheet_worst\')) {
                arr.push(app.lang.get(\'LBL_FORECASTS_CONFIG_WORKSHEET_SCENARIOS_WORST\', \'Forecasts\'));
            }

            this.titleSelectedValues = arr.join(\', \');

            this.updateTitle();
        }, this);

        // trigger the change event to set the title when this gets added
        this.model.trigger(\'change:scenarios\', this.model);
    },

    /**
     * @inheritdoc
     */
    _render: function() {
        this._super(\'_render\');

        // handle default/un-delete-able scenario
        this.defaultSelect2 = this.$(\'#scenariosLocked\').select2({
            data: this.defaultOption,
            multiple: true,
            dropdownCss: {width:\'auto\'},
            dropdownCssClass: \'search-related-dropdown\',
            containerCss: "border: none",
            containerCssClass: \'select2-choices-pills-close select2-container-disabled\',
            escapeMarkup: function(m) {
                return m;
            },
            initSelection : _.bind(function (element, callback) {
                callback(this.defaultOption);
            }, this)
        });

        this.$(\'.select2-container-disabled\').width(\'auto\');
        this.$(\'.select2-search-field\').css(\'display\',\'none\');
        // set the default value
        this.defaultSelect2.select2(\'val\', this.defaultOption);

        // disable the select2
        this.defaultSelect2.select2(\'disable\');

        // handle setting up select2 options
        var isRTL = app.lang.direction === \'rtl\';
        this.optionsSelect2 = this.$(\'#scenariosSelect\').select2({
            data: this.scenarioOptions,
            multiple: true,
            dropdownCss: {
                width: \'auto\',
                left: isRTL ? \'\' : \'71px\', //prevent calculated value
                right: isRTL ? \'71px\' : \'\'
            },
            width: "90%",
            containerCss: "border: none",
            containerCssClass: "select2-choices-pills-close",
            escapeMarkup: function(m) {
                return m;
            },
            initSelection : _.bind(function (element, callback) {
                callback(this.selectedOptions);
            }, this)
        });
        this.optionsSelect2.select2(\'val\', this.selectedOptions);

        this.optionsSelect2.on(\'change\', _.bind(this.handleScenarioModelChange, this));
    },

    /**
     * Event handler for the select2 dropdown changing selected items
     *
     * @param {jQuery.Event} evt select2 change event
     */
    handleScenarioModelChange: function(evt) {
        var changedEnabled = [],
            changedDisabled = [],
            allOptions = [];

        // Get the options that changed and set the model
        _.each($(evt.target).val().split(\',\'), function(option) {
            changedEnabled.push(option);
            this.model.set(option, true, {silent: true});
        }, this);

        // Convert all scenario options into a flat array of ids
        _.each(this.scenarioOptions, function(option) {
            allOptions.push(option.id);
        }, this);

        // Take all options and return an array without the ones that changed to true
        changedDisabled = _.difference(allOptions, changedEnabled);

        // Set any options that weren\'t changed to true to false
        _.each(changedDisabled, function(option) {
            this.model.set(option, false, {silent: true});
        }, this);

        this.model.trigger(\'change:scenarios\', this.model);
    },

    /**
     * Formats pill selections
     *
     * @param {Object} item selected item
     */
    formatCustomSelection: function(item) {
        return \'<a class="select2-choice-filter" rel="\'+ item.id + \'" href="javascript:void(0)">\'+ item.text +\'</a>\';
    },

    /**
     * @inheritdoc
     *
     * Remove custom listeners off select2 instances
     */
    _dispose: function() {
        // remove event listener from select2
        if (this.defaultSelect2) {
            this.defaultSelect2.off();
            this.defaultSelect2.select2(\'destroy\');
            this.defaultSelect2 = null;
        }
        if (this.optionsSelect2) {
            this.optionsSelect2.off();
            this.optionsSelect2.select2(\'destroy\');
            this.optionsSelect2 = null;
        }

        this._super(\'_dispose\');
    }
})
',
    ),
    'templates' => 
    array (
      'config-scenarios' => '
<div class="accordion-heading">
    <a id=\'{{name}}Title\' class="accordion-toggle" data-help-id="{{name}}" data-toggle="collapse" data-parent="#config-accordion" href="#{{name}}Collapse"></a>
</div>
<div id="{{name}}Collapse" class="accordion-body collapse">
    <div class="accordion-inner">
        <p>{{str "LBL_FORECASTS_CONFIG_WORKSHEET_SCENARIOS" "Forecasts"}}</p>
        <p><em>{{str "LBL_FORECASTS_CONFIG_WORKSHEET_LIKELY_INFO" "Forecasts"}}</em></p>
        <div class="control-group">
            <div class="filter">
                <div class="filter-view search">
                    <input id="scenariosLocked" class="select2" type="hidden">
                    {{!-- left and right CSS properties are hardcoded in the controller to fix right to left interface --}}
                    <input id="scenariosSelect" class="select2" type="hidden">
                </div>
            </div>
        </div>
    </div>
</div>
',
    ),
  ),
  'config-ranges' => 
  array (
    'controller' => 
    array (
      'base' => '/*
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
 * @class View.Views.Base.ForecastsConfigRangesView
 * @alias SUGAR.App.view.layouts.BaseForecastsConfigRangesView
 * @extends View.Views.Base.ConfigPanelView
 */
({
    extendsFrom: \'ConfigPanelView\',

    events: {
        \'click #btnAddCustomRange a\': \'addCustomRange\',
        \'click #btnAddCustomRangeWithoutProbability a\': \'addCustomRange\',
        \'click .addCustomRange\': \'addCustomRange\',
        \'click .removeCustomRange\': \'removeCustomRange\',
        \'keyup input[type=text]\': \'updateCustomRangeLabel\',
        \'change :radio\': \'selectionHandler\'
    },

    /**
     * Holds the fields metadata
     */
    fieldsMeta: {},

    /**
     * used to hold the metadata for the forecasts_ranges field, used to manipulate and render out as the radio buttons
     * that correspond to the fieldset for each bucket type.
     */
    forecastRangesField: {},

    /**
     * Used to hold the buckets_dom field metadata, used to retrieve and set the proper bucket dropdowns based on the
     * selection for the forecast_ranges
     */
    bucketsDomField: {},

    /**
     * Used to hold the category_ranges field metadata, used for rendering the sliders that correspond to the range
     * settings for each of the values contained in the selected buckets_dom dropdown definition.
     */
    categoryRangesField: {},

    /**
     * Holds the values found in Forecasts Config commit_stages_included value
     */
    includedCommitStages: [],

    //TODO-sfa remove this once the ability to map buckets when they get changed is implemented (SFA-215).
    /**
     * This is used to determine whether we need to lock the module or not, based on whether forecasts has been set up already
     */
    disableRanges: false,

    /**
     * Used to keep track of the selection as it changes so that it can be used to determine how to hide and show the
     * sub-elements that contain the fields for setting the category ranges
     */
    selectedRange: \'\',

    /**
     * a placeholder for the individual range sliders that will be used to build the range setting
     */
    fieldRanges: {},

    /**
     * @inheritdoc
     */
    initialize: function(options) {
        this._super(\'initialize\', [options]);

        // parse get the fields metadata
        _.each(_.first(this.meta.panels).fields, function(field) {
            this.fieldsMeta[field.name] = field;
            if (field.name === \'category_ranges\') {
                // get rid of the name key so it doesn\'t mess up the other fields
                delete this.fieldsMeta.category_ranges.name;
            }
        }, this);

        // init the fields from metadata
        this.forecastRangesField = this.fieldsMeta.forecast_ranges;
        this.bucketsDomField = this.fieldsMeta.buckets_dom;
        this.categoryRangesField = this.fieldsMeta.category_ranges;

        // get the included commit stages
        this.includedCommitStages = this.model.get(\'commit_stages_included\');

        // set the values for forecastRangesField and bucketsDomField from the model, so it can be set to selected properly when rendered
        this.forecastRangesField.value = this.model.get(\'forecast_ranges\');
        this.bucketsDomField.value = this.model.get(\'buckets_dom\');

        // This will be set to true if the forecasts ranges setup should be disabled
        this.disableRanges = this.model.get(\'has_commits\');
        this.selectedRange = this.model.get(\'forecast_ranges\');
    },

    /**
     * @inheritdoc
     * @override
     */
    _updateTitleValues: function() {
        var forecastRanges = this.model.get(\'forecast_ranges\'),
            rangeObjs = this.model.get(forecastRanges + \'_ranges\'),
            tmpArr = [],
            str = \'\',
            aSort = function(a, b) {
                if (a.min < b.min) {
                    return -1;
                } else if (a.min > b.min) {
                    return 1;
                }
            }

        // Get the keys into an object
        _.each(rangeObjs, function(value, key) {
            if(key.indexOf(\'without_probability\') === -1) {
                tmpArr.push({
                    min: value.min,
                    max: value.max
                });
            }
        });

        tmpArr.sort(aSort);

        _.each(tmpArr, function(val) {
            str += val.min + \'% - \' + val.max + \'%, \';
        });

        this.titleSelectedValues = str.slice(0, str.length - 2);
        this.titleSelectedRange = app.lang.getAppListStrings(\'forecasts_config_ranges_options_dom\')[forecastRanges];
    },

    /**
     * @inheritdoc
     * @override
     */
    _updateTitleTemplateVars: function() {
        this.titleTemplateVars = {
            title: this.titleViewNameTitle,
            message: this.titleSelectedRange,
            selectedValues: this.titleSelectedValues,
            viewName: this.name
        };
    },

    /**
     * @inheritdoc
     */
    bindDataChange: function() {
        this.model.on(\'change:show_binary_ranges change:show_buckets_ranges change:show_custom_buckets_ranges\',
            function() {
                this.updateTitle();
            }, this
        );
        this.model.on(\'change:forecast_ranges\', function(model) {
            this.updateTitle();
            if(model.get(\'forecast_ranges\') === \'show_custom_buckets\') {
                this.updateCustomRangesCheckboxes();
            }
        }, this);
    },

    /**
     * @inheritdoc
     */
    _render: function() {
        this._super(\'_render\');

        // after the view renders, check for the range that has been selected and
        // trigger the change event on its element so that it shows
        this.$(\':radio:checked\').trigger(\'change\');

        if(this.model.get(\'forecast_ranges\') === \'show_custom_buckets\') {
            this.updateCustomRangesCheckboxes();
        }
    },

    /**
     * Handles when the radio buttons change
     *
     * @param {jQuery.Event} event
     */
    selectionHandler: function(event) {
        var newValue = $(event.target).val(),
            oldValue = this.selectedRange,
            bucket_dom = this.bucketsDomField.options[newValue],
            elToHide = this.$(\'#\' + oldValue + \'_ranges\'),
            elToShow = this.$(\'#\' + newValue + \'_ranges\');

        // now set the new selection, so that if they change it,
        // we can later hide the things we are about to show.
        this.selectedRange = newValue;

        if(elToShow.children().length === 0) {
            if(newValue === \'show_custom_buckets\') {
                this._customSelectionHandler(newValue, elToShow);
            } else {
                this._selectionHandler(newValue, elToShow);
            }

            // use call to set context back to the view for connecting the sliders
            this.connectSliders.call(this, newValue, this.fieldRanges);
        }

        if(elToHide) {
            elToHide.toggleClass(\'hide\', true);
        }

        if(elToShow) {
            elToShow.toggleClass(\'hide\', false);
        }

        // set the forecast ranges and associated dropdown dom on the model
        this.model.set({
            forecast_ranges: newValue,
            buckets_dom: bucket_dom
        });
    },

    /**
     * Selection handler for standard ranges (two and three ranges)
     *
     * @param {Object} elementVal value of the radio button that was clicked
     * @param {Object} showElement the jQuery-wrapped html element from selectionHandler
     * @private
     */
    _selectionHandler: function(elementVal, showElement) {
        var bucketDomStrings = app.lang.getAppListStrings(this.bucketsDomField.options[elementVal]);

        // add the things here...
        this.fieldRanges[elementVal] = {};
        showElement.append(\'<p>\' + app.lang.get(\'LBL_FORECASTS_CONFIG_\' + elementVal.toUpperCase() + \'_RANGES_DESCRIPTION\', \'Forecasts\', this) + \'</p>\');

        _.each(bucketDomStrings, function(label, key) {
            if(key != \'exclude\') {
                var rangeField,
                    model = new Backbone.Model(),
                    fieldSettings;

                // get the value in the current model and use it to display the slider
                model.set(key, this.model.get(elementVal + \'_ranges\')[key]);

                // build a range field
                fieldSettings = {
                    view: this,
                    def: this.fieldsMeta.category_ranges[key],
                    viewName: \'edit\',
                    context: this.context,
                    module: this.module,
                    model: model,
                    meta: app.metadata.getField(\'range\')
                };

                rangeField = app.view.createField(fieldSettings);
                showElement.append(\'<b>\' + label + \':</b>\').append(rangeField.el);
                rangeField.render();

                // now give the view a way to get at this field\'s model, so it can be used to set the value on the
                // real model.
                this.fieldRanges[elementVal][key] = rangeField;

                // this gives the field a way to save to the view\'s real model. It\'s wrapped in a closure to allow us to
                // ensure we have everything when switching contexts from this handler back to the view.
                rangeField.sliderDoneDelegate = function(category, key, view) {

                    return function(value) {
                        this.view.updateRangeSettings(category, key, value);
                    };
                }(elementVal, key, this);
            }
        }, this);
        showElement.append($(\'<p>\' + app.lang.get(\'LBL_FORECASTS_CONFIG_RANGES_EXCLUDE_INFO\', \'Forecasts\') + \'</p>\'));
    },

    /**
     * Selection handler for custom ranges
     *
     * @param {Object} elementVal value of the radio button that was clicked
     * @param {Object} showElement the jQuery-wrapped html element from selectionHandler
     * @private
     */
    _customSelectionHandler: function(elementVal, showElement) {
        var bucketDomOptions = {},
            elValRanges = elementVal + \'_ranges\',
            bucketDomStrings = app.lang.getAppListStrings(this.bucketsDomField.options[elementVal]),
            rangeField,
            _ranges = _.clone(this.model.get(elValRanges));

        this.fieldRanges[elementVal] = {};
        showElement.append(\'<p>\' + app.lang.get(\'LBL_FORECASTS_CONFIG_\' + elementVal.toUpperCase() + \'_RANGES_DESCRIPTION\', \'Forecasts\', this) + \'</p>\');

        // if custom bucket isn\'t defined save default values
        if(!this.model.has(elValRanges)) {
            this.model.set(elValRanges, {});
        }

        _.each(bucketDomStrings, function(label, key) {
            if (_.isUndefined(_ranges[key])) {
                // the range doesn\'t exist, so we add it to the ranges
                _ranges[key] = {min: 0, max: 100, in_included_total: false};
            } else {
                // the range already exists, update the in_included_total value
                _ranges[key].in_included_total = (_.contains(this.includedCommitStages, key));
            }
            bucketDomOptions[key] = label;
        }, this);
        this.model.set(elValRanges, _ranges);

        // save key and label of custom range from the language file to model
        // then we can add or remove ranges and save it on backend side
        // bind handler on change to validate data
        this.model.set(elementVal + \'_options\', bucketDomOptions);
        this.model.on(\'change:\' + elementVal + \'_options\', function(event) {
            this.validateCustomRangeLabels(elementVal);
        }, this);

        // create layout, create placeholders for different types of custom ranges
        this._renderCustomRangesLayout(showElement, elementVal);

        // render custom ranges
        _.each(bucketDomStrings, function(label, key) {
            rangeField = this._renderCustomRange(key, label, showElement, elementVal);
            // now give the view a way to get at this field\'s model, so it can be used to set the value on the
            // real model.
            this.fieldRanges[elementVal][key] = rangeField;
        }, this);

        // if there are custom ranges not based on probability hide add button on the top of block
        if(this._getLastCustomRangeIndex(elementVal, \'custom\')) {
            this.$(\'#btnAddCustomRange\').hide();
        }

        // if there are custom ranges not based on probability hide add button on the top of block
        if(this._getLastCustomRangeIndex(elementVal, \'custom_without_probability\')) {
            this.$(\'#btnAddCustomRangeWithoutProbability\').hide();
        }
    },

    /**
     * Render layout for custom ranges, add placeholders for different types of ranges
     *
     * @param {Object} showElement the jQuery-wrapped html element from selectionHandler
     * @param {string} category type for the ranges \'show_binary\' etc.
     * @private
     */
    _renderCustomRangesLayout: function(showElement, category) {
        var template = app.template.getView(\'config-ranges.customRangesDefault\', \'Forecasts\'),
            mdl = {
                category: category
            };

        showElement.append(template(mdl));
    },

    /**
     * Creates a new custom range field and renders it in showElement
     *
     * @param {string} key
     * @param {string} label
     * @param {Object} showElement the jQuery-wrapped html element from selectionHandler
     * @param {string} category type for the ranges \'show_binary\' etc.
     * @private
     * @return {View.field} new created field
     */
    _renderCustomRange: function(key, label, showElement, category) {
        var customType = key,
            customIndex = 0,
            isExclude = false,
            // placeholder to insert custom range
            currentPlaceholder = showElement,
            rangeField,
            model = new Backbone.Model(),
            fieldSettings,
            lastCustomRange;

        // define type of new custom range based on name of range and choose placeholder to insert
        // custom_default: include, upside or exclude
        // custom - based on probability
        // custom_without_probability - not based on probability
        if(key.substring(0, 26) == \'custom_without_probability\') {
            customType = \'custom_without_probability\';
            customIndex = key.substring(27);
            currentPlaceholder = this.$(\'#plhCustomWithoutProbability\');
        } else if(key.substring(0, 6) == \'custom\') {
            customType = \'custom\';
            customIndex = key.substring(7);
            currentPlaceholder = this.$(\'#plhCustom\');
        } else if(key.substring(0, 7) == \'exclude\') {
            customType = \'custom_default\';
            currentPlaceholder = this.$(\'#plhExclude\');
            isExclude = true;
        } else {
            customType = \'custom_default\';
            currentPlaceholder = this.$(\'#plhCustomDefault\');
        }

        // get the value in the current model and use it to display the slider
        model.set(key, this.model.get(category + \'_ranges\')[key]);

        // get the field definition from
        var fieldDef = this.fieldsMeta.category_ranges[key] || this.fieldsMeta.category_ranges[customType];

        // build a range field
        fieldSettings = {
            view: this,
            def: _.clone(fieldDef),
            viewName: \'forecastsCustomRange\',
            context: this.context,
            module: this.module,
            model: model,
            meta: app.metadata.getField(\'range\')
        };
        // set up real range name
        fieldSettings.def.name = key;
        // set up view
        fieldSettings.def.view = \'forecastsCustomRange\';
        // enable slider
        fieldSettings.def.enabled = true;

        rangeField = app.view.createField(fieldSettings);
        currentPlaceholder.append(rangeField.el);
        rangeField.label = label;
        rangeField.customType = customType;

        // added + to make sure customIndex is numeric
        rangeField.customIndex = +customIndex;

        rangeField.isExclude = isExclude;
        rangeField.in_included_total = (_.contains(this.includedCommitStages, key));
        rangeField.category = category;

        if(key == \'include\') {
            rangeField.isReadonly = true;
        }

        rangeField.render();

        // enable slider after render
        rangeField.$(rangeField.fieldTag).noUiSlider(\'enable\');

        // hide add button for previous custom range not based on probability
        lastCustomRange = this._getLastCustomRange(category, rangeField.customType);
        if(lastCustomRange) {
            lastCustomRange.$(\'.addCustomRange\').parent().hide();
        }

        // add error class if the range has an empty label
        if(_.isEmpty(rangeField.label)) {
            rangeField.$(\'.control-group\').addClass(\'error\');
        } else {
            rangeField.$(\'.control-group\').removeClass(\'error\');
        }

        // this gives the field a way to save to the view\'s real model. It\'s wrapped in a closure to allow us to
        // ensure we have everything when switching contexts from this handler back to the view.
        rangeField.sliderDoneDelegate = function(category, key, view) {
            return function(value) {
                this.view.updateRangeSettings(category, key, value);
            };
        }(category, key, this);

        return rangeField;
    },

    /**
     * Returns the index of the last custom range or 0
     *
     * @param {string} category type for the ranges \'show_binary\' etc.
     * @param {string} customType
     * @return {number}
     * @private
     */
    _getLastCustomRangeIndex: function(category, customType) {
        var lastCustomRangeIndex = 0;
        // loop through all ranges, if there are multiple ranges with the same customType, they\'ll just overwrite
        // each other\'s index and after the loop we\'ll have the final index left
        if(this.fieldRanges[category]) {
            _.each(this.fieldRanges[category], function(range) {
                if(range.customType == customType && range.customIndex > lastCustomRangeIndex) {
                    lastCustomRangeIndex = range.customIndex;
                }
            }, this);
        }
        return lastCustomRangeIndex;
    },

    /**
     * Returns the last created custom range object, if no range object, return upside/include
     * for custom type and exclude for custom_without_probability type
     *
     * @param {string} category type for the ranges \'show_binary\' etc.
     * @param {string} customType
     * @return {*}
     * @private
     */
    _getLastCustomRange: function(category, customType) {
        if(!_.isEmpty(this.fieldRanges[category])) {
            var lastCustomRange = undefined;
            // loop through all ranges, if there are multiple ranges with the same customType, they\'ll just overwrite
            // each other on lastCustomRange and after the loop we\'ll have the final one left
            _.each(this.fieldRanges[category], function(range) {
                if(range.customType == customType
                    && (_.isUndefined(lastCustomRange) || range.customIndex > lastCustomRange.customIndex)) {
                    lastCustomRange = range;
                }
            }, this);

            if(_.isUndefined(lastCustomRange)) {
                // there is not custom range - use default ranges
                if(customType == \'custom\') {
                    // use upside or include
                    lastCustomRange = this.fieldRanges[category].upside || this.fieldRanges[category].include;
                } else {
                    // use exclude
                    lastCustomRange = this.fieldRanges[category].exclude;
                }
            }
        }

        return lastCustomRange;
    },

    /**
     * Adds a new custom range field and renders it in specific placeholder
     *
     * @param {jQuery.Event} event click
     */
    addCustomRange: function(event) {
        var self = this,
            category = $(event.currentTarget).data(\'category\'),
            customType = $(event.currentTarget).data(\'type\'),
            categoryRange = category + \'_ranges\',
            categoryOptions = category + \'_options\',
            ranges = _.clone(this.model.get(categoryRange)),
            bucketDomOptions = _.clone(this.model.get(categoryOptions));

        if (_.isUndefined(category) || _.isUndefined(customType)
            || _.isUndefined(ranges) || _.isUndefined(bucketDomOptions)) {
            return false;
        }

        var showElement = (customType == \'custom\') ? this.$(\'#plhCustom\') : this.$(\'#plhCustomWithoutProbability\'),
            label = app.lang.get(\'LBL_FORECASTS_CUSTOM_RANGES_DEFAULT_NAME\', \'Forecasts\'),
            rangeField,
            lastCustomRange = this._getLastCustomRange(category, customType),
            lastCustomRangeIndex = this._getLastCustomRangeIndex(category, customType);

        lastCustomRangeIndex++;

        // setup key for the new range
        var key = customType + \'_\' + lastCustomRangeIndex;

        // set up min/max values for new custom range
        if (customType != \'custom\') {
            // if range is without probability setup min and max values to 0
            ranges[key] = {
                min: 0,
                max: 0,
                in_included_total: false
            };
        } else if (ranges.exclude.max - ranges.exclude.min > 3) {
            // decrement exclude range to insert new range
            ranges[key] = {
                min: parseInt(ranges.exclude.max, 10) - 1,
                max: parseInt(ranges.exclude.max, 10),
                in_included_total: false
            };
            ranges.exclude.max = parseInt(ranges.exclude.max, 10) - 2;
            if (this.fieldRanges[category].exclude.$el) {
                this.fieldRanges[category].exclude.$(this.fieldRanges[category].exclude.fieldTag)
                    .noUiSlider(\'move\', {handle: \'upper\', to: ranges.exclude.max});
            }
        } else if (ranges[lastCustomRange.name].max - ranges[lastCustomRange.name].min > 3) {
            // decrement previous range to insert new range
            ranges[key] = {
                min: parseInt(ranges[lastCustomRange.name].min, 10),
                max: parseInt(ranges[lastCustomRange.name].min, 10) + 1,
                in_included_total: false
            };
            ranges[lastCustomRange.name].min = parseInt(ranges[lastCustomRange.name].min, 10) + 2;
            if (lastCustomRange.$el) {

                lastCustomRange.$(lastCustomRange.fieldTag)
                    .noUiSlider(\'move\', {handle: \'lower\', to: ranges[lastCustomRange.name].min});
            }
        } else {
            ranges[key] = {
                min: parseInt(ranges[lastCustomRange.name].min, 10) - 2,
                max: parseInt(ranges[lastCustomRange.name].min, 10) - 1,
                in_included_total: false
            };
        }

        this.model.set(categoryRange, ranges);

        rangeField = this._renderCustomRange(key, label, showElement, category);
        if(rangeField) {
            this.fieldRanges[category][key] = rangeField;
        }

        bucketDomOptions[key] = label;
        this.model.set(categoryOptions, bucketDomOptions);

        // adding event listener to new custom range
        rangeField.$(\':checkbox\').each(function() {
            var $el = $(this);
            $el.on(\'click\', _.bind(self.updateCustomRangeIncludeInTotal, self));
            app.accessibility.run($el, \'click\');
        });

        if(customType == \'custom\') {
            // use call to set context back to the view for connecting the sliders
            this.$(\'#btnAddCustomRange\').hide();
            this.connectSliders.call(this, category, this.fieldRanges);
        } else {
            // hide add button form top of block and for previous ranges not based on probability
            this.$(\'#btnAddCustomRangeWithoutProbability\').hide();
            _.each(this.fieldRanges[category], function(item) {
                if(item.customType == customType && item.customIndex < lastCustomRangeIndex && item.$el) {
                    item.$(\'.addCustomRange\').parent().hide();
                }
            }, this);
        }

        // update checkboxes
        this.updateCustomRangesCheckboxes();
    },

    /**
     * Removes a custom range from the model and view
     *
     * @param {jQuery.Event} event click
     * @return void
     */
    removeCustomRange: function(event) {
        var category = $(event.currentTarget).data(\'category\'),
            fieldKey = $(event.currentTarget).data(\'key\'),
            categoryRanges = category + \'_ranges\',
            categoryOptions = category + \'_options\',
            ranges = _.clone(this.model.get(categoryRanges)),
            bucketDomOptions = _.clone(this.model.get(categoryOptions));

        if (_.isUndefined(category) || _.isUndefined(fieldKey) || _.isUndefined(this.fieldRanges[category])
            || _.isUndefined(this.fieldRanges[category][fieldKey]) || _.isUndefined(ranges)
            || _.isUndefined(bucketDomOptions))
        {
            return false;
        }

        var range,
            previousCustomRange,
            lastCustomRangeIndex,
            lastCustomRange;

        range = this.fieldRanges[category][fieldKey];

        if (_.indexOf([\'include\', \'upside\', \'exclude\'], range.name) != -1) {
            return false;
        }

        if(range.customType == \'custom\') {
            // find previous renge and reassign range values form removed to it
            _.each(this.fieldRanges[category], function(item) {
                if(item.customType == \'custom\' && item.customIndex < range.customIndex) {
                    previousCustomRange = item;
                }
            }, this);

            if(_.isUndefined(previousCustomRange)) {
                previousCustomRange = (this.fieldRanges[category].upside) ? this.fieldRanges[category].upside : this.fieldRanges[category].include;
            }

            ranges[previousCustomRange.name].min = +ranges[range.name].min;

            if(previousCustomRange.$el) {
                previousCustomRange.$(previousCustomRange.fieldTag).noUiSlider(\'move\', {handle: \'lower\', to: ranges[previousCustomRange.name].min});
            }
        }

        // update included ranges
        this.includedCommitStages = _.without(this.includedCommitStages, range.name)

        // removing event listener for custom range
        range.$(\':checkbox\').off(\'click\');

        // remove view for the range
        this.fieldRanges[category][range.name].remove();

        delete ranges[range.name];
        delete this.fieldRanges[category][range.name];
        delete bucketDomOptions[range.name];

        this.model.set(categoryOptions, bucketDomOptions);
        this.model.set(categoryRanges, ranges);

        lastCustomRangeIndex = this._getLastCustomRangeIndex(category, range.customType);
        if(range.customType == \'custom\') {
            // use call to set context back to the view for connecting the sliders
            if (lastCustomRangeIndex == 0) {
                this.$(\'#btnAddCustomRange\').show();
            }
            this.connectSliders.call(this, category, this.fieldRanges);
        } else {
            // show add button for custom range not based on probability
            if(lastCustomRangeIndex == 0) {
                this.$(\'#btnAddCustomRangeWithoutProbability\').show();
            }
        }
        lastCustomRange = this._getLastCustomRange(category, range.customType);
        if(lastCustomRange.$el) {
            lastCustomRange.$(\'.addCustomRange\').parent().show();
        }

        // update checkboxes
        this.updateCustomRangesCheckboxes();
    },

    /**
     * Change a label for a custom range in the model
     *
     * @param {jQuery.Event} event keyup
     */
    updateCustomRangeLabel: function(event) {
        var category = $(event.target).data(\'category\'),
            fieldKey = $(event.target).data(\'key\'),
            categoryOptions = category + \'_options\',
            bucketDomOptions = _.clone(this.model.get(categoryOptions));

        if (category && fieldKey && bucketDomOptions) {
            bucketDomOptions[fieldKey] = $(event.target).val();
            this.model.set(categoryOptions, bucketDomOptions);
        }
    },

    /**
     * Validate labels for custom ranges, if it is invalid add error style for input
     *
     * @param {string} category type for the ranges \'show_binary\' etc.
     */
    validateCustomRangeLabels: function(category) {
        var opts = this.model.get(category + \'_options\'),
            hasErrors = false,
            range;

        _.each(opts, function(label, key) {
            range = this.fieldRanges[category][key];
            if(_.isEmpty(label.trim())) {
                range.$(\'.control-group\').addClass(\'error\');
                hasErrors = true;
            } else {
                range.$(\'.control-group\').removeClass(\'error\');
            }
        }, this);

        var saveBtn = this.layout.layout.$(\'[name=save_button]\');
        if(saveBtn) {
            if(hasErrors) {
                // if there are errors, disable the save button
                saveBtn.addClass(\'disabled\');
            } else if(!hasErrors && saveBtn.hasClass(\'disabled\')) {
                // if there are no errors and the save btn is disabled, enable it
                saveBtn.removeClass(\'disabled\');
            }
        }
    },

    /**
     * Change in_included_total value for custom range in model
     *
     * @param {Backbone.Event} event change
     */
    updateCustomRangeIncludeInTotal: function(event) {
        var category = $(event.target).data(\'category\'),
            fieldKey = $(event.target).data(\'key\'),
            categoryRanges = category + \'_ranges\',
            ranges;

        if (category && fieldKey) {
            ranges = _.clone(this.model.get(categoryRanges));
            if (ranges && ranges[fieldKey]) {
                if (fieldKey !== \'exclude\' && fieldKey.indexOf(\'custom_without_probability\') == -1) {
                    var isChecked = $(event.target).is(\':checked\');
                    ranges[fieldKey].in_included_total = isChecked;
                    if(isChecked) {
                        // silently add this range to the includedCommitStages
                        this.includedCommitStages.push(fieldKey);
                    } else {
                        // silently remove this range from includedCommitStages
                        this.includedCommitStages = _.without(this.includedCommitStages, fieldKey)
                    }

                    this.model.set(\'commit_stages_included\', this.includedCommitStages);

                } else {
                    ranges[fieldKey].in_included_total = false;
                }
                this.model.set(categoryRanges, ranges);
                this.updateCustomRangesCheckboxes();
            }
        }
    },

    /**
     * Iterates through custom ranges checkboxes and enables/disables
     * checkboxes so users can only select certain checkboxes to include ranges
     */
    updateCustomRangesCheckboxes: function() {
        var els = this.$(\'#plhCustomDefault :checkbox, #plhCustom :checkbox\'),
            len = els.length,
            $el,
            fieldKey,
            i;

        for(i = 0; i < len; i++) {
            $el = $(els[i]);
            fieldKey = $el.data(\'key\');

            //disable the checkbox
            $el.attr(\'disabled\', true);
            // remove any click event listeners
            $el.off(\'click\');

            // looking specifically for checkboxes that are not the \'include\' checkbox but that are
            // the last included commit stage range or the first non-included commit stage range
            if(fieldKey !== \'include\'
                && (i == this.includedCommitStages.length - 1 || i == this.includedCommitStages.length)) {
                // enable the checkbox
                $el.attr(\'disabled\', false);
                // add new click event listener
                $el.on(\'click\', _.bind(this.updateCustomRangeIncludeInTotal, this));
                app.accessibility.run($el, \'click\');
            }
        }
    },

    /**
     * Updates the setting in the model for the specific range types.
     * This gets triggered when the range slider after the user changes a range
     *
     * @param {string} category type for the ranges \'show_binary\' etc.
     * @param {string} range - the range being set, i. e. `include`, `exclude` or `upside` for `show_buckets` category
     * @param {number} value - the value being set
     */
    updateRangeSettings: function(category, range, value) {
        var catRange = category + \'_ranges\',
            setting = _.clone(this.model.get(catRange));

        if (category == \'show_custom_buckets\') {
            value.in_included_total = setting[range].in_included_total || false;
        }

        setting[range] = value;
        this.model.set(catRange, setting);
    },

    /**
     * Graphically connects the sliders to the one below, so that they move in unison when changed, based on category.
     *
     * @param {string} ranges - the forecasts category that was selected, i. e. \'show_binary\' or \'show_buckets\'
     * @param {Object} sliders - an object containing the sliders that have been set up in the page.  This is created in the
     * selection handler when the user selects a category type.
     */
    connectSliders: function(ranges, sliders) {
        var rangeSliders = sliders[ranges];

        if(ranges == \'show_binary\') {
            rangeSliders.include.sliderChangeDelegate = function(value) {
                // lock the upper handle to 100, as per UI/UX requirements to show a dual slider
                rangeSliders.include.$(rangeSliders.include.fieldTag).noUiSlider(\'move\', {handle: \'upper\', to: rangeSliders.include.def.maxRange});
                // set the excluded range based on the lower value of the include range
                this.view.setExcludeValueForLastSlider(value, ranges, rangeSliders.include);
            };
        } else if(ranges == \'show_buckets\') {
            rangeSliders.include.sliderChangeDelegate = function(value) {
                // lock the upper handle to 100, as per UI/UX requirements to show a dual slider
                rangeSliders.include.$(rangeSliders.include.fieldTag).noUiSlider(\'move\', {handle: \'upper\', to: rangeSliders.include.def.maxRange});

                rangeSliders.upside.$(rangeSliders.upside.fieldTag).noUiSlider(\'move\', {handle: \'upper\', to: value.min - 1});
                if(value.min <= rangeSliders.upside.$(rangeSliders.upside.fieldTag).noUiSlider(\'value\')[0] + 1) {
                    rangeSliders.upside.$(rangeSliders.upside.fieldTag).noUiSlider(\'move\', {handle: \'lower\', to: value.min - 2});
                }
            };
            rangeSliders.upside.sliderChangeDelegate = function(value) {
                rangeSliders.include.$(rangeSliders.include.fieldTag).noUiSlider(\'move\', {handle: \'lower\', to: value.max + 1});
                // set the excluded range based on the lower value of the upside range
                this.view.setExcludeValueForLastSlider(value, ranges, rangeSliders.upside);
            };
        } else if(ranges == \'show_custom_buckets\') {
            var i, max,
                customSliders = _.sortBy(_.filter(
                    rangeSliders,
                    function(item) {
                        return item.customType == \'custom\';
                    }
                ), function(item) {
                        return parseInt(item.customIndex, 10);
                    }
                ),
                probabilitySliders = _.union(rangeSliders.include, rangeSliders.upside, customSliders, rangeSliders.exclude);

            if(probabilitySliders.length) {
                for(i = 0, max = probabilitySliders.length; i < max; i++) {
                    probabilitySliders[i].connectedSlider = (probabilitySliders[i + 1]) ? probabilitySliders[i + 1] : null;
                    probabilitySliders[i].connectedToSlider = (probabilitySliders[i - 1]) ? probabilitySliders[i - 1] : null;
                    probabilitySliders[i].sliderChangeDelegate = function(value, populateEvent) {
                        // lock the upper handle to 100, as per UI/UX requirements to show a dual slider
                        if(this.name == \'include\') {
                            this.$(this.fieldTag).noUiSlider(\'move\', {handle: \'upper\', to: this.def.maxRange});
                        } else if(this.name == \'exclude\') {
                            this.$(this.fieldTag).noUiSlider(\'move\', {handle: \'lower\', to: this.def.minRange});
                        }

                        if(this.connectedSlider) {
                            this.connectedSlider.$(this.connectedSlider.fieldTag).noUiSlider(\'move\', {handle: \'upper\', to: value.min - 1});
                            if(value.min <= this.connectedSlider.$(this.connectedSlider.fieldTag).noUiSlider(\'value\')[0] + 1) {
                                this.connectedSlider.$(this.connectedSlider.fieldTag).noUiSlider(\'move\', {handle: \'lower\', to: value.min - 2});
                            }
                            if(_.isUndefined(populateEvent) || populateEvent == \'down\') {
                                this.connectedSlider.sliderChangeDelegate.call(this.connectedSlider, {
                                    min: this.connectedSlider.$(this.connectedSlider.fieldTag).noUiSlider(\'value\')[0],
                                    max: this.connectedSlider.$(this.connectedSlider.fieldTag).noUiSlider(\'value\')[1]
                                }, \'down\');
                            }
                        }
                        if(this.connectedToSlider) {
                            this.connectedToSlider.$(this.connectedToSlider.fieldTag).noUiSlider(\'move\', {handle: \'lower\', to: value.max + 1});
                            if(value.max >= this.connectedToSlider.$(this.connectedToSlider.fieldTag).noUiSlider(\'value\')[1] - 1) {
                                this.connectedToSlider.$(this.connectedToSlider.fieldTag).noUiSlider(\'move\', {handle: \'upper\', to: value.max + 2});
                            }
                            if(_.isUndefined(populateEvent) || populateEvent == \'up\') {
                                this.connectedToSlider.sliderChangeDelegate.call(this.connectedToSlider, {
                                    min: this.connectedToSlider.$(this.connectedToSlider.fieldTag).noUiSlider(\'value\')[0],
                                    max: this.connectedToSlider.$(this.connectedToSlider.fieldTag).noUiSlider(\'value\')[1]
                                }, \'up\');
                            }
                        }
                    };
                }
            }
        }
    },

    /**
     * Provides a way for the last of the slider fields in the view, to set the value for the exclude range.
     *
     * @param {Object} value the range value of the slider
     * @param {string} ranges the selected config range
     * @param {Object} slider the slider
     */
    setExcludeValueForLastSlider: function(value, ranges, slider) {
        var excludeRange = {
                min: 0,
                max: 100
            },
            settingName = ranges + \'_ranges\',
            setting = _.clone(this.model.get(settingName));

        excludeRange.max = value.min - 1;
        excludeRange.min = slider.def.minRange;
        setting.exclude = excludeRange;
        this.model.set(settingName, setting);
    }
})
',
    ),
    'templates' => 
    array (
      'customRangesDefault' => '
<div>
    <span class="tbold">{{str "LBL_FORECASTS_RANGES_BASED_TITLE" "Forecasts"}}</span>
</div>
<div id="plhCustomProbabilityRanges">
    <div id="plhCustomDefault"></div>
    <div>
        <span class="tbold">{{str "LBL_FORECASTS_CUSTOM_BASED_TITLE" "Forecasts"}}</span>
    </div>
    <div id="plhCustom"></div>
    <div id="plhExclude">
        <div class="btn-group" id="btnAddCustomRange">
            <a class="btn" href="javascript:void(0)" data-type="custom" data-category="{{category}}"><i class="fa fa-plus"></i></a>
        </div>
    </div>
</div>
<div>
    <span class="tbold">{{str "LBL_FORECASTS_CUSTOM_NO_BASED_TITLE" "Forecasts"}}</span>
</div>
<div id="plhCustomWithoutProbability">
    <div class="btn-group" id="btnAddCustomRangeWithoutProbability"><a class="btn" href="javascript:void(0)" data-type="custom_without_probability" data-category="{{category}}"><i class="fa fa-plus"></i></a></div>
</div>
',
      'config-ranges' => '
<div class="accordion-heading">
    <a id=\'{{name}}Title\' class="accordion-toggle" data-help-id="{{name}}" data-toggle="collapse" data-parent="#config-accordion" href="#{{name}}Collapse"></a>
</div>
<div id="{{name}}Collapse" class="accordion-body collapse">
    <div class="accordion-inner">
        <!--TODO-sfa remove this once the ability to map buckets when they get changed is implemented (SFA-215).-->
        <p><em>{{str "LBL_FORECASTS_CONFIG_RANGES_SETUP_NOTICE" "Forecasts"}}</em></p>
        <p>{{str "LBL_FORECASTS_CONFIG_RANGES_OPTIONS" "Forecasts" this}}</p>
        {{#with forecastRangesField}}
            {{#eachOptions options}}
                <fieldset class="{{{key}}}Fields">
                    <p>
                        <input type="radio" name="{{../name}}" value="{{{key}}}" {{#eq key ../value}}checked{{/eq}} {{#if ../../disableRanges}}disabled="true"{{/if}}>
                        <b>{{value}}</b>
                    </p>
                    <div id="{{{key}}}_ranges" class="options {{#notEq key ../value}}hide{{/notEq}}"></div>
                </fieldset>
            {{/eachOptions}}
        {{/with}}
    </div>
</div>
',
    ),
    'meta' => 
    array (
      'label' => 'LBL_FORECASTS_CONFIG_BREADCRUMB_RANGES',
      'panels' => 
      array (
        0 => 
        array (
          'fields' => 
          array (
            0 => 
            array (
              'name' => 'forecast_ranges',
              'type' => 'radioenum',
              'label' => 'LBL_FORECASTS_CONFIG_RANGES_OPTIONS',
              'view' => 'edit',
              'options' => 'forecasts_config_ranges_options_dom',
              'default' => false,
              'enabled' => true,
            ),
            1 => 
            array (
              'name' => 'category_ranges',
              'include' => 
              array (
                'name' => 'include',
                'type' => 'range',
                'view' => 'edit',
                'sliderType' => 'connected',
                'minRange' => 0,
                'maxRange' => 100,
                'default' => true,
                'enabled' => true,
              ),
              'upside' => 
              array (
                'name' => 'upside',
                'type' => 'range',
                'view' => 'edit',
                'sliderType' => 'connected',
                'minRange' => 0,
                'maxRange' => 100,
                'default' => true,
                'enabled' => true,
              ),
            ),
            2 => 
            array (
              'name' => 'buckets_dom',
              'options' => 
              array (
                'show_binary' => 'commit_stage_binary_dom',
                'show_buckets' => 'commit_stage_dom',
              ),
            ),
          ),
        ),
      ),
    ),
  ),
  'info' => 
  array (
    'meta' => 
    array (
      'type' => 'info',
      'timeperiod' => 
      array (
        0 => 
        array (
          'name' => 'selectedTimePeriod',
          'label' => 'LBL_TIMEPERIOD_NAME',
          'type' => 'timeperiod',
          'css_class' => 'forecastsTimeperiod',
          'dropdown_class' => 'topline-timeperiod-dropdown',
          'dropdown_width' => 'auto',
          'view' => 'edit',
          'default' => true,
          'enabled' => true,
        ),
      ),
      'last_commit' => 
      array (
        0 => 
        array (
          'name' => 'lastCommitDate',
          'type' => 'lastcommit',
          'datapoints' => 
          array (
            0 => 'worst_case',
            1 => 'likely_case',
            2 => 'best_case',
          ),
        ),
      ),
      'commitlog' => 
      array (
        0 => 
        array (
          'name' => 'commitLog',
          'type' => 'commitlog',
        ),
      ),
      'datapoints' => 
      array (
        0 => 
        array (
          'name' => 'quota',
          'label' => 'LBL_QUOTA',
          'type' => 'quotapoint',
        ),
        1 => 
        array (
          'name' => 'worst_case',
          'label' => 'LBL_WORST',
          'type' => 'datapoint',
        ),
        2 => 
        array (
          'name' => 'likely_case',
          'label' => 'LBL_LIKELY',
          'type' => 'datapoint',
        ),
        3 => 
        array (
          'name' => 'best_case',
          'label' => 'LBL_BEST',
          'type' => 'datapoint',
        ),
      ),
    ),
    'templates' => 
    array (
      'info-rtl' => '
<div class="row-fluid topline">
    <div class="span8 datapoints">
        <div class="pull-left">
            {{#each this.meta.datapoints}}
                {{field ../this model=../this.model}}
            {{/each}}
        </div>
    </div>
    <div class="hr hide"></div>
    <div class="span4">
        {{#if this.meta.timeperiod}}
            {{#each this.meta.timeperiod}}
                <strong>{{str "LBL_IN_FORECAST" "Forecasts"}}</strong>
                <label for="date_filter" class="control-label">{{str this.label "Forecasts"}}</label>
                <div class="controls">
                    {{field ../this model=../this.tpModel}}
                </div>
            {{/each}}
        {{/if}}
    </div>
</div>
{{#if this.meta.last_commit}}
    {{#each this.meta.last_commit}}
        {{field ../this model=../this.model}}
    {{/each}}
{{/if}}
{{#if this.meta.commitlog}}
    {{#each this.meta.commitlog}}
        {{field ../this model=../this.model}}
    {{/each}}
{{/if}}
',
      'info' => '
<div class="row-fluid topline">
    <div class="span4">
        {{#if this.meta.timeperiod}}
            {{#each this.meta.timeperiod}}
                <strong>{{str "LBL_IN_FORECAST" "Forecasts"}}</strong>
                <label for="date_filter" class="control-label">{{str this.label "Forecasts"}}</label>
                <div class="controls">
                    {{field ../this model=../this.tpModel}}
                </div>
            {{/each}}
        {{/if}}
    </div>
    <div class="hr hide"></div>
    <div class="span8 datapoints">
        <div class="pull-right">
            {{#each this.meta.datapoints}}
                {{field ../this model=../this.model}}
            {{/each}}
        </div>
    </div>
</div>
{{#if this.meta.last_commit}}
    {{#each this.meta.last_commit}}
        {{field ../this model=../this.model}}
    {{/each}}
{{/if}}
{{#if this.meta.commitlog}}
    {{#each this.meta.commitlog}}
        {{field ../this model=../this.model}}
    {{/each}}
{{/if}}
',
    ),
    'controller' => 
    array (
      'base' => '/*
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
 * @class View.Views.Base.Forecasts.InfoView
 * @alias SUGAR.App.view.views.BaseForecastsInfoView
 * @extends View.View
 */
({
    /**
     * Timeperiod model 
     */
    tpModel: undefined,
    
    /**
     * {@inheritdoc}
     *
     */
    initialize: function(options) {
        if (app.lang.direction === \'rtl\') {
            options.template = app.template.getView(\'info.info-rtl\', \'Forecasts\');

            // reverse the datapoints
            options.meta.datapoints.reverse();
        }

        this.tpModel = new Backbone.Model();
        this._super("initialize", [options]);
        this.resetSelection(this.context.get("selectedTimePeriod"));
    },
    
    /**
     * {@inheritdoc}
     *
     */
    bindDataChange: function(){
        this.tpModel.on("change", function(model){
            this.context.trigger(
                \'forecasts:timeperiod:changed\',
                model,
                this.getField(\'selectedTimePeriod\').tpTooltipMap[model.get(\'selectedTimePeriod\')]);
        }, this);
        
        this.context.on("forecasts:timeperiod:canceled", function(){
            this.resetSelection(this.tpModel.previous("selectedTimePeriod"));
        }, this);
        
    },
    
    /**
     * Sets the timeperiod to the selected timeperiod, used primarily for resetting
     * the dropdown on nav cancel
     */
    resetSelection: function(timeperiod_id){
        this.tpModel.set({selectedTimePeriod:timeperiod_id}, {silent:true});
        _.find(this.fields, function(field){
            if(_.isEqual(field.name, "selectedTimePeriod")){
                field.render();
                return true;
            }
        });
    }
    
})
',
    ),
  ),
  'config-worksheet-columns' => 
  array (
    'controller' => 
    array (
      'base' => '/*
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
 * @class View.Views.Base.ForecastsConfigWorksheetColumnsView
 * @alias SUGAR.App.view.layouts.BaseForecastsConfigWorksheetColumnsView
 * @extends View.Views.Base.ConfigPanelView
 */
({
    extendsFrom: \'ConfigPanelView\',

    /**
     * Holds the select2 reference to the #wkstColumnSelect element
     */
    wkstColumnsSelect2: undefined,

    /**
     * Holds the default/selected items
     */
    selectedOptions: [],

    /**
     * Holds all items
     */
    allOptions: [],

    /**
     * The field object id/label for likely_case
     */
    likelyFieldObj: {},

    /**
     * The field object id/label for best_case
     */
    bestFieldObj: {},

    /**
     * The field object id/label for worst_case
     */
    worstFieldObj: {},

    /**
     * @inheritdoc
     */
    initialize: function(options) {
        // patch metadata for if opps_view_by is Opportunities, not RLIs
        if (app.metadata.getModule(\'Opportunities\', \'config\').opps_view_by === \'Opportunities\') {
            _.each(_.first(options.meta.panels).fields, function(field) {
                if (field.label_module && field.label_module === \'RevenueLineItems\') {
                    field.label_module = \'Opportunities\';
                }
            });
        }

        this._super(\'initialize\', [options]);

        this.allOptions = [];
        this.selectedOptions = [];

        var cfgFields = this.model.get(\'worksheet_columns\'),
            index = 0;

        // set up scenarioOptions
        _.each(this.meta.panels[0].fields, function(field) {
            var obj = {
                    id: field.name,
                    text: app.lang.get(field.label, this._getLabelModule(field.name, field.label_module)),
                    index: index,
                    locked: field.locked || false
                },
                cField = _.find(cfgFields, function(cfgField) {
                    return cfgField == field.name;
                }, this),
                addFieldToFullList = true;

            // save the field objects
            if (field.name == \'best_case\') {
                this.bestFieldObj = obj;
                addFieldToFullList = (this.model.get(\'show_worksheet_best\') === 1);
            } else if (field.name == \'likely_case\') {
                this.likelyFieldObj = obj;
                addFieldToFullList = (this.model.get(\'show_worksheet_likely\') === 1);
            } else if (field.name == \'worst_case\') {
                this.worstFieldObj = obj;
                addFieldToFullList = (this.model.get(\'show_worksheet_worst\') === 1);
            }

            if (addFieldToFullList) {
                this.allOptions.push(obj);
            }

            // If the current field being processed was found in the config fields,
            if (!_.isUndefined(cField)) {
                // push field to defaults
                this.selectedOptions.push(obj);
            }

            index++;
        }, this);
    },

    /**
     * @inheritdoc
     *
     * Empty function as the title values have already been set properly
     * with the change:worksheet_columns event handler
     *
     * @override
     */
    _updateTitleValues: function() {
    },

    /**
     * @inheritdoc
     */
    bindDataChange: function() {
        this.model.on(\'change:worksheet_columns\', function() {
            var arr = [],
                cfgFields = this.model.get(\'worksheet_columns\'),
                metaFields = this.meta.panels[0].fields;

            _.each(metaFields, function(metaField) {
                _.each(cfgFields, function(field) {
                    if (metaField.name == field) {
                        arr.push(
                            app.lang.get(
                                metaField.label,
                                this._getLabelModule(metaField.name, metaField.label_module)
                            )
                        );
                    }
                }, this);
            }, this);
            this.titleSelectedValues = arr.join(\', \');

            // Handle truncating the title string and adding "..."
            this.titleSelectedValues = this.titleSelectedValues.slice(0, 50) + \'...\';

            this.updateTitle();
        }, this);

        // trigger the change event to set the title when this gets added
        this.model.trigger(\'change:worksheet_columns\');

        this.model.on(\'change:scenarios\', function() {
            // check model settings and update select2 options
            if (this.model.get(\'show_worksheet_best\')) {
                this.addOption(this.bestFieldObj);
            } else {
                this.removeOption(this.bestFieldObj);
            }

            if (this.model.get(\'show_worksheet_likely\')) {
                this.addOption(this.likelyFieldObj);
            } else {
                this.removeOption(this.likelyFieldObj);
            }

            if (this.model.get(\'show_worksheet_worst\')) {
                this.addOption(this.worstFieldObj);
            } else {
                this.removeOption(this.worstFieldObj);
            }

            // force render
            this._render();

            // update the model, since a field was added or removed
            var arr = [];
            _.each(this.selectedOptions, function(field) {
                arr.push(field.id);
            }, this);

            this.model.set(\'worksheet_columns\', arr);
        }, this);
    },

    /**
     * Adds a field object to allOptions & selectedOptions if it is not found in those arrays
     *
     * @param {Object} fieldObj
     */
    addOption: function(fieldObj) {
        if (!_.contains(this.allOptions, fieldObj)) {
            this.allOptions.splice(fieldObj.index, 0, fieldObj);
            this.selectedOptions.splice(fieldObj.index, 0, fieldObj);
        }
    },

    /**
     * Removes a field object to allOptions & selectedOptions if it is not found in those arrays
     *
     * @param {Object} fieldObj
     */
    removeOption: function(fieldObj) {
        this.allOptions = _.without(this.allOptions, fieldObj);
        this.selectedOptions = _.without(this.selectedOptions, fieldObj);
    },

    /**
     * @inheritdoc
     */
    _render: function() {
        this._super(\'_render\');

        // handle setting up select2 options
        this.wkstColumnsSelect2 = this.$(\'#wkstColumnsSelect\').select2({
            data: this.allOptions,
            multiple: true,
            containerCssClass: \'select2-choices-pills-close\',
            initSelection: _.bind(function(element, callback) {
                callback(this.selectedOptions);
            }, this)
        });
        this.wkstColumnsSelect2.select2(\'val\', this.selectedOptions);

        this.wkstColumnsSelect2.on(\'change\', _.bind(this.handleColumnModelChange, this));
    },

    /**
     * Handles the select2 adding/removing columns
     *
     * @param {Object} evt change event from the select2 selected values
     */
    handleColumnModelChange: function(evt) {
        // did we add something?  if so, lets add it to the selectedOptions
        if (!_.isUndefined(evt.added)) {
            this.selectedOptions.push(evt.added);
        }

        // did we remove something? if so, lets remove it from the selectedOptions
        if (!_.isUndefined(evt.removed)) {
            this.selectedOptions = _.without(this.selectedOptions, evt.removed);
        }

        this.model.set(\'worksheet_columns\', evt.val);
    },

    /**
     * @inheritdoc
     *
     * Remove custom listeners off select2 instances
     */
    _dispose: function() {
        if (this.wkstColumnsSelect2) {
            this.wkstColumnsSelect2.off();
            this.wkstColumnsSelect2.select2(\'destroy\');
            this.wkstColumnsSelect2 = null;
        }
        this._super(\'_dispose\');
    },

    /**
     * Re-usable method to get the module label for the column list
     *
     * @param {String} fieldName The field we are currently looking at
     * @param {String} setModule If the metadata has a module set it will be passed in here
     * @return {string}
     * @private
     */
    _getLabelModule: function(fieldName, setModule) {
        var labelModule = setModule || \'Forecasts\';
        if (fieldName === \'parent_name\') {
            // when we have the parent_name, pull the label from the module we are forecasting by
            labelModule = this.model.get(\'forecast_by\');
        }

        return labelModule;
    }
})
',
    ),
    'templates' => 
    array (
      'config-worksheet-columns' => '
<div class="accordion-heading">
    <a id=\'{{name}}Title\' class="accordion-toggle" data-help-id="{{name}}" data-toggle="collapse" data-parent="#config-accordion" href="#{{name}}Collapse"></a>
</div>
<div id="{{name}}Collapse" class="accordion-body collapse">
    <div class="accordion-inner">
        <p>{{str \'LBL_FORECASTS_CONFIG_WORKSHEET_TEXT\' \'Forecasts\'}}:</p>
        <div class="record-cell">
            <div id="wkstColumnsSelect"></div>
        </div>
    </div>
</div>
',
    ),
    'meta' => 
    array (
      'label' => 'LBL_FORECASTS_CONFIG_TITLE_WORKSHEET_COLUMNS',
      'panels' => 
      array (
        0 => 
        array (
          'fields' => 
          array (
            0 => 
            array (
              'name' => 'commit_stage',
              'label' => 'LBL_FORECASTS_CONFIG_TITLE_RANGES',
              'locked' => true,
              'order' => 0,
            ),
            1 => 
            array (
              'name' => 'parent_name',
              'label' => 'LBL_NAME',
              'label_module' => 'Opportunities',
              'locked' => true,
              'order' => 1,
            ),
            2 => 
            array (
              'name' => 'account_name',
              'label' => 'LBL_LIST_ACCOUNT_NAME',
              'label_module' => 'RevenueLineItems',
              'order' => 5,
            ),
            3 => 
            array (
              'name' => 'date_closed',
              'label' => 'LBL_DATE_CLOSED',
              'label_module' => 'RevenueLineItems',
              'order' => 6,
            ),
            4 => 
            array (
              'name' => 'sales_stage',
              'label' => 'LBL_SALES_STAGE',
              'label_module' => 'Products',
              'order' => 10,
            ),
            5 => 
            array (
              'name' => 'probability',
              'label' => 'LBL_OW_PROBABILITY',
              'order' => 11,
            ),
            6 => 
            array (
              'name' => 'worst_case',
              'label' => 'LBL_FORECASTS_CONFIG_WORKSHEET_SCENARIOS_WORST',
              'locked' => true,
              'order' => 12,
            ),
            7 => 
            array (
              'name' => 'likely_case',
              'label' => 'LBL_FORECASTS_CONFIG_WORKSHEET_SCENARIOS_LIKELY',
              'locked' => true,
              'order' => 13,
            ),
            8 => 
            array (
              'name' => 'best_case',
              'label' => 'LBL_FORECASTS_CONFIG_WORKSHEET_SCENARIOS_BEST',
              'locked' => true,
              'order' => 14,
            ),
            9 => 
            array (
              'name' => 'product_type',
              'label' => 'LBL_TYPE',
              'label_module' => 'RevenueLineItems',
              'order' => 25,
            ),
            10 => 
            array (
              'name' => 'lead_source',
              'label' => 'LBL_LEAD_SOURCE',
              'label_module' => 'Contacts',
              'order' => 26,
            ),
            11 => 
            array (
              'name' => 'campaign_name',
              'label' => 'LBL_CAMPAIGN',
              'order' => 27,
            ),
            12 => 
            array (
              'name' => 'assigned_user_name',
              'label' => 'LBL_ASSIGNED_TO_NAME',
              'order' => 28,
            ),
            13 => 
            array (
              'name' => 'team_name',
              'label' => 'LBL_TEAMS',
              'order' => 29,
            ),
            14 => 
            array (
              'name' => 'next_step',
              'label' => 'LBL_NEXT_STEP',
              'label_module' => 'RevenueLineItems',
              'order' => 30,
            ),
            15 => 
            array (
              'name' => 'description',
              'label' => 'LBL_DESCRIPTION',
              'label_module' => 'RevenueLineItems',
              'order' => 31,
            ),
          ),
        ),
      ),
    ),
  ),
  'config-forecast-by' => 
  array (
    'templates' => 
    array (
      'config-forecast-by' => '
<div class="accordion-heading">
    <a id=\'{{name}}Title\' class="accordion-toggle" data-help-id="{{name}}" data-toggle="collapse" data-parent="#config-accordion" href="#{{name}}Collapse"></a>
</div>
<div id="{{name}}Collapse" class="accordion-body collapse">
    <div class="accordion-inner">
        {{#each meta.panels}}
            {{#each fields}}
                <label for="{{name}}">{{str label currentModule}}</label>
                {{field ../../this model=../../model}}
            {{/each}}
        {{/each}}
    </div>
</div>
',
    ),
    'meta' => 
    array (
      'label' => 'LBL_FORECASTS_CONFIG_BREADCRUMB_WORKSHEET_LAYOUT',
      'panels' => 
      array (
        0 => 
        array (
          'fields' => 
          array (
            0 => 
            array (
              'name' => 'forecast_by',
              'type' => 'radioenum',
              'label' => '',
              'view' => 'edit',
              'options' => 'forecasts_config_worksheet_layout_forecast_by_options_dom',
              'default' => false,
              'enabled' => true,
            ),
          ),
        ),
      ),
    ),
    'controller' => 
    array (
      'base' => '/*
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
 * @class View.Views.Base.ForecastsConfigForecastByView
 * @alias SUGAR.App.view.layouts.BaseForecastsConfigForecastByView
 * @extends View.Views.Base.ConfigPanelView
 */
({
    extendsFrom: \'ConfigPanelView\',

    /**
     * @inheritdoc
     * @override
     */
    _updateTitleValues: function() {
        this.titleSelectedValues = this.model.get(\'forecast_by\');
    }
})
',
    ),
  ),
  'record' => 
  array (
    'meta' => 
    array (
      'panels' => 
      array (
        0 => 
        array (
          'name' => 'panel_header',
          'label' => 'LBL_RECORD_HEADER',
          'header' => true,
          'fields' => 
          array (
            0 => 
            array (
              'name' => 'picture',
              'type' => 'avatar',
              'width' => 42,
              'height' => 42,
              'dismiss_label' => true,
              'readonly' => true,
            ),
            1 => 'name',
            2 => 
            array (
              'name' => 'favorite',
              'label' => 'LBL_FAVORITE',
              'type' => 'favorite',
              'readonly' => true,
              'dismiss_label' => true,
            ),
            3 => 
            array (
              'name' => 'follow',
              'label' => 'LBL_FOLLOW',
              'type' => 'follow',
              'readonly' => true,
              'dismiss_label' => true,
            ),
          ),
        ),
        1 => 
        array (
          'name' => 'panel_body',
          'label' => 'LBL_RECORD_BODY',
          'columns' => 2,
          'labelsOnTop' => true,
          'placeholders' => true,
          'fields' => 
          array (
            0 => 'assigned_user_name',
            1 => 'team_name',
          ),
        ),
        2 => 
        array (
          'name' => 'panel_hidden',
          'label' => 'LBL_SHOW_MORE',
          'hide' => true,
          'columns' => 2,
          'labelsOnTop' => true,
          'placeholders' => true,
          'fields' => 
          array (
            0 => 
            array (
              'name' => 'description',
              'span' => 12,
            ),
            1 => 
            array (
              'name' => 'date_modified_by',
              'readonly' => true,
              'inline' => true,
              'type' => 'fieldset',
              'label' => 'LBL_DATE_MODIFIED',
              'fields' => 
              array (
                0 => 
                array (
                  'name' => 'date_modified',
                ),
                1 => 
                array (
                  'type' => 'label',
                  'default_value' => 'LBL_BY',
                ),
                2 => 
                array (
                  'name' => 'modified_by_name',
                ),
              ),
            ),
            2 => 
            array (
              'name' => 'date_entered_by',
              'readonly' => true,
              'inline' => true,
              'type' => 'fieldset',
              'label' => 'LBL_DATE_ENTERED',
              'fields' => 
              array (
                0 => 
                array (
                  'name' => 'date_entered',
                ),
                1 => 
                array (
                  'type' => 'label',
                  'default_value' => 'LBL_BY',
                ),
                2 => 
                array (
                  'name' => 'created_by_name',
                ),
              ),
            ),
          ),
        ),
      ),
    ),
  ),
  'selection-list' => 
  array (
    'meta' => 
    array (
      'panels' => 
      array (
        0 => 
        array (
          'label' => 'LBL_PANEL_1',
          'fields' => 
          array (
            0 => 
            array (
              'name' => 'name',
              'label' => 'LBL_NAME',
              'default' => true,
              'enabled' => true,
              'link' => true,
            ),
            1 => 
            array (
              'name' => 'team_name',
              'label' => 'LBL_TEAM',
              'default' => true,
              'enabled' => true,
            ),
            2 => 
            array (
              'name' => 'assigned_user_name',
              'label' => 'LBL_ASSIGNED_TO_NAME',
              'default' => true,
              'enabled' => true,
              'link' => true,
            ),
            3 => 
            array (
              'label' => 'LBL_DATE_MODIFIED',
              'enabled' => true,
              'default' => true,
              'name' => 'date_modified',
              'readonly' => true,
            ),
          ),
        ),
      ),
      'orderBy' => 
      array (
        'field' => 'date_modified',
        'direction' => 'desc',
      ),
    ),
  ),
  'list' => 
  array (
    'meta' => 
    array (
      'panels' => 
      array (
        0 => 
        array (
          'label' => 'LBL_PANEL_1',
          'fields' => 
          array (
            0 => 
            array (
              'name' => 'name',
              'label' => 'LBL_NAME',
              'default' => true,
              'enabled' => true,
              'link' => true,
            ),
            1 => 
            array (
              'name' => 'team_name',
              'label' => 'LBL_TEAM',
              'default' => false,
              'enabled' => true,
            ),
            2 => 
            array (
              'name' => 'assigned_user_name',
              'label' => 'LBL_ASSIGNED_TO_NAME',
              'default' => true,
              'enabled' => true,
              'link' => true,
            ),
            3 => 
            array (
              'name' => 'date_modified',
              'enabled' => true,
              'default' => true,
            ),
            4 => 
            array (
              'name' => 'date_entered',
              'enabled' => true,
              'default' => true,
            ),
          ),
        ),
      ),
      'orderBy' => 
      array (
        'field' => 'date_modified',
        'direction' => 'desc',
      ),
    ),
  ),
  'dupecheck-list' => 
  array (
    'meta' => 
    array (
      'panels' => 
      array (
        0 => 
        array (
          'label' => 'LBL_PANEL_1',
          'fields' => 
          array (
            0 => 
            array (
              'name' => 'name',
              'label' => 'LBL_NAME',
              'default' => true,
              'enabled' => true,
              'link' => true,
            ),
            1 => 
            array (
              'name' => 'team_name',
              'label' => 'LBL_TEAM',
              'default' => true,
              'enabled' => true,
            ),
            2 => 
            array (
              'name' => 'assigned_user_name',
              'label' => 'LBL_ASSIGNED_TO_NAME',
              'default' => true,
              'enabled' => true,
              'link' => true,
            ),
            3 => 
            array (
              'label' => 'LBL_DATE_MODIFIED',
              'enabled' => true,
              'default' => true,
              'name' => 'date_modified',
              'readonly' => true,
            ),
          ),
        ),
      ),
    ),
  ),
  'massupdate' => 
  array (
    'meta' => 
    array (
      'buttons' => 
      array (
        0 => 
        array (
          'type' => 'button',
          'value' => 'cancel',
          'css_class' => 'btn-link btn-invisible cancel_button',
          'label' => 'LBL_CANCEL_BUTTON_LABEL',
          'primary' => false,
        ),
        1 => 
        array (
          'name' => 'update_button',
          'type' => 'button',
          'label' => 'LBL_UPDATE',
          'acl_action' => 'massupdate',
          'css_class' => 'btn-primary',
          'primary' => true,
        ),
      ),
      'panels' => 
      array (
        0 => 
        array (
          'fields' => 
          array (
          ),
        ),
      ),
    ),
  ),
  'subpanel-list' => 
  array (
    'meta' => 
    array (
      'panels' => 
      array (
        0 => 
        array (
          'name' => 'panel_header',
          'label' => 'LBL_PANEL_1',
          'fields' => 
          array (
            0 => 
            array (
              'label' => 'LBL_NAME',
              'enabled' => true,
              'default' => true,
              'name' => 'name',
              'link' => true,
            ),
            1 => 
            array (
              'label' => 'LBL_DATE_MODIFIED',
              'enabled' => true,
              'default' => true,
              'name' => 'date_modified',
            ),
          ),
        ),
      ),
      'orderBy' => 
      array (
        'field' => 'date_modified',
        'direction' => 'desc',
      ),
    ),
  ),
  '_hash' => '7b239d48cd1703184cc355708f1fd35e',
);

