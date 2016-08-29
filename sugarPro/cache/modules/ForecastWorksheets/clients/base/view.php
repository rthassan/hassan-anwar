<?php
$clientCache['ForecastWorksheets']['base']['view'] = array (
  'recordlist' => 
  array (
    'meta' => 
    array (
      'css_class' => 'forecast-worksheet',
      'favorite' => false,
      'selection' => 
      array (
      ),
      'rowactions' => 
      array (
        'actions' => 
        array (
          0 => 
          array (
            'type' => 'rowaction',
            'css_class' => 'btn',
            'tooltip' => 'LBL_PREVIEW',
            'event' => 'list:preview:fire',
            'icon' => 'fa-eye',
            'acl_action' => 'view',
          ),
        ),
      ),
      'dependencies' => 
      array (
        0 => 
        array (
          'name' => 'opportunity_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'opportunity',
            1 => 'opportunity_id',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'opportunity_name',
                'value' => 'related($opportunity, "name")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        1 => 
        array (
          'name' => 'account_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'account',
            1 => 'account_id',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'account_name',
                'value' => 'related($account, "name")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        2 => 
        array (
          'name' => 'campaign_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'campaign',
            1 => 'campaign_id',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'campaign_name',
                'value' => 'related($campaign, "name")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        3 => 
        array (
          'name' => 'product_template_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'template',
            1 => 'product_template_id',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'product_template_name',
                'value' => 'related($template, "name")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        4 => 
        array (
          'name' => 'category_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'category',
            1 => 'category_id',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'category_name',
                'value' => 'related($category, "name")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        5 => 
        array (
          'name' => 'currency_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'currency',
            1 => 'currency_id',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'currency_name',
                'value' => 'related($currency, "name")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        6 => 
        array (
          'name' => 'probability',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'sales_stage',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'probability',
                'value' => 'getDropdownValue("sales_probability_dom",$sales_stage)',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        7 => 
        array (
          'name' => 'readOnlyopportunity_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'opportunity',
            1 => 'opportunity_id',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'opportunity_name',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        8 => 
        array (
          'name' => 'readOnlyaccount_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'account',
            1 => 'account_id',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'account_name',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        9 => 
        array (
          'name' => 'readOnlycampaign_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'campaign',
            1 => 'campaign_id',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'campaign_name',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        10 => 
        array (
          'name' => 'readOnlyproduct_template_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'template',
            1 => 'product_template_id',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'product_template_name',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        11 => 
        array (
          'name' => 'readOnlycategory_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'category',
            1 => 'category_id',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'category_name',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        12 => 
        array (
          'name' => 'readOnlycurrency_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'currency',
            1 => 'currency_id',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'currency_name',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        13 => 
        array (
          'name' => 'readOnlyprobability',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'sales_stage',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'probability',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        14 => 
        array (
          'name' => 'ForecastWorksheetsRecordlistView_commit_stage_readonly_set_value',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'sales_stage',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'commit_stage',
                'label' => 'commit_stage_label',
                'value' => 'isForecastClosed($sales_stage)',
              ),
            ),
            1 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'commit_stage',
                'value' => 'ifElse(isForecastClosedWon($sales_stage), "include",                    ifElse(isForecastClosedLost($sales_stage), "exclude", $commit_stage))',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        15 => 
        array (
          'name' => 'ForecastWorksheetsRecordlistView_best_worst_sales_stage_read_only',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'sales_stage',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'best_case',
                'label' => 'best_case_label',
                'value' => 'isForecastClosed($sales_stage)',
              ),
            ),
            1 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'worst_case',
                'label' => 'worst_case_label',
                'value' => 'isForecastClosed($sales_stage)',
              ),
            ),
            2 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'best_case',
                'value' => 'ifElse(isForecastClosed($sales_stage), $likely_case, $best_case)',
              ),
            ),
            3 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'worst_case',
                'value' => 'ifElse(isForecastClosed($sales_stage), $likely_case, $worst_case)',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        16 => 
        array (
          'name' => 'ForecastWorksheetsRecordlistView_likely_case_copy_when_closed',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'likely_case',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'best_case',
                'value' => 'ifElse(isForecastClosed($sales_stage), $likely_case, $best_case)',
              ),
            ),
            1 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'worst_case',
                'value' => 'ifElse(isForecastClosed($sales_stage), $likely_case, $worst_case)',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
      ),
    ),
    'templates' => 
    array (
      'totals' => '
<tfoot>
<tr id="forecastsWorksheetTotalsFilteredTotals">
    {{#each this.leftColumns}}
        <td>&nbsp;</td>
    {{/each}}
    <td colspan=\'{{before_colspan}}\'>{{str "LBL_DISPLAYED_TOTAL" "Forecasts"}}</td>

    {{#if this.totals.worst_case_display}}
        <td class="tright">
            {{#if this.totals.worst_case_access}}
                {{formatCurrency this.totals.filtered_worst}}
            {{else}}
                {{{this.noAccessDataErrorTemplate}}}
            {{/if}}
        </td>
    {{/if}}

    {{#if this.totals.likely_case_display}}
        <td class="tright">
            {{#if this.totals.likely_case_access}}
                {{formatCurrency this.totals.filtered_amount}}
            {{else}}
                {{{this.noAccessDataErrorTemplate}}}
            {{/if}}
        </td>
    {{/if}}

    {{#if this.totals.best_case_display}}
        <td class="tright">
            {{#if this.totals.best_case_access}}
                {{formatCurrency this.totals.filtered_best}}
            {{else}}
                {{{this.noAccessDataErrorTemplate}}}
            {{/if}}
        </td>
    {{/if}}
    {{#if this.after_colspan}}
         <td colspan=\'{{after_colspan}}\'>&nbsp;</td>
    {{/if}}
    {{#each this.rightColumns}}
        <td>&nbsp;</td>
    {{/each}}
</tr>
<tr id="forecastsWorksheetTotalsOverallTotals">
    {{#each this.leftColumns}}
        <td>&nbsp;</td>
    {{/each}}
    <td colspan=\'{{before_colspan}}\'>{{str "LBL_OVERALL_TOTAL" "Forecasts"}}</td>

    {{#if this.totals.worst_case_display}}
        <td class="tright">
            {{#if this.totals.worst_case_access}}
                {{formatCurrency this.totals.overall_worst}}
            {{else}}
                {{{this.noAccessDataErrorTemplate}}}
            {{/if}}
        </td>
    {{/if}}

    {{#if this.totals.likely_case_display}}
        <td class="tright">
            {{#if this.totals.likely_case_access}}
                {{formatCurrency this.totals.overall_amount}}
            {{else}}
                {{{this.noAccessDataErrorTemplate}}}
            {{/if}}
        </td>
    {{/if}}

    {{#if this.totals.best_case_display}}
        <td class="tright">
            {{#if this.totals.best_case_access}}
                {{formatCurrency this.totals.overall_best}}
            {{else}}
                {{{this.noAccessDataErrorTemplate}}}
            {{/if}}
        </td>
    {{/if}}
    {{#if this.after_colspan}}
         <td colspan=\'{{after_colspan}}\'>&nbsp;</td>
    {{/if}}
    {{#each this.rightColumns}}
        <td>&nbsp;</td>
    {{/each}}
</tr>
</tfoot>


',
      'noresults' => '
<tr>
    {{#if collection.dataFetched}}
        {{#eq filteredCollection.length 0}}
            <td class="tcenter" colspan="{{this._fields.visible.length}}">{{str "LBL_LISTVIEW_NO_RECORDS"}}</td>
            <td>&nbsp;</td>
        {{/eq}}
    {{else}}
        <td class="tcenter" colspan="{{this._fields.visible.length}}">
            <div class="loading">
                {{str "LBL_ALERT_TITLE_LOADING"}}<i class="l1 fa fa-circle"></i><i class="l2 fa fa-circle"></i><i class="l3 fa fa-circle"></i>
            </div>
        </td>
        <td>&nbsp;</td>
    {{/if}}
</tr>
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
 * Forecast Sales Rep Worksheet Record List.
 *
 * @class View.Views.Base.ForecastsWorksheets.RecordlistView
 * @alias SUGAR.App.view.views.BaseForecastsWorksheetsRecordlistView
 * @extends View.Views.Base.RecordlistView
 */
/**
 * Events
 *
 * forecasts:worksheet:is_dirty
 *  on: this.context.parent || this.context
 *  by: this.dirtyModels \'add\' Event
 *  when: a model is added to the dirtModels collection
 *
 * forecasts:worksheet:needs_commit
 *  on: this.context.parent || this.context
 *  by: checkForDraftRows
 *  when: this.collection has a row newer than the last commit date
 *
 * forecasts:worksheet:totals
 *  on: this.context.parent || this.context
 *  by: calculateTotals
 *  when: after it\'s done calculating totals from a collection change or reset event
 *
 * forecasts:worksheet:saved
 *  on: this.context.parent || this.context
 *  by: saveWorksheet
 *  when: after it\'s done saving the worksheets to the db for a save draft
 *
 * forecasts:worksheet:commit
 *  on: this.context.parent || this.context
 *  by: forecasts:worksheet:saved event
 *  when: only when the commit button is pressed
 *
 */
({
    /**
     * Who is my parent
     */
    extendsFrom: \'RecordlistView\',

    /**
     * Type of worksheet
     */
    worksheetType: \'sales_rep\',

    /**
     * Totals Storage
     */
    totals: {},

    /**
     * Before W/L/B Columns Colspan
     */
    before_colspan: 0,

    /**
     * After W/L/B Columns Colspan
     */
    after_colspan: 0,

    /**
     * Selected User Storage
     */
    selectedUser: {},

    /**
     * Can we edit this worksheet?
     *
     * defaults to true as it\'s always the current user that loads first
     */
    canEdit: true,

    /**
     * Active Filters
     */
    filters: [],

    /**
     * Filtered Collection
     */
    filteredCollection: new Backbone.Collection(),

    /**
     * Selected Timeperiod Storage
     */
    selectedTimeperiod: \'\',

    /**
     * Navigation Message To Display
     */
    navigationMessage: \'\',

    /**
     * Special Navigation for the Window Refresh
     */
    routeNavigationMessage: \'\',

    /**
     * Do we actually need to display a navigation message
     */
    displayNavigationMessage: false,

    /**
     * Only check for draft records once
     */
    hasCheckedForDraftRecords: false,

    /**
     * Holds the model currently being displayed in the preview panel
     */
    previewModel: undefined,

    /**
     * Tracks if the preview panel is visible or not
     */
    previewVisible: false,

    /**
     * is the collection syncing
     * @param boolean
     */
    isCollectionSyncing: false,

    /**
     * is the commit history being loading
     * @param boolean
     */
    isLoadingCommits: false,

    /**
     * The template for when we don\'t have access to a data point
     */
    noAccessDataErrorTemplate: undefined,

    /**
     * Target URL of the nav action
     */
    targetURL: \'\',
    
    /**
     * Current URL of the module
     */
    currentURL: \'\',
    
    initialize: function(options) {
        // we need to make a clone of the plugins and then push to the new object. this prevents double plugin
        // registration across ExtendedComponents
        this.plugins = _.without(this.plugins, \'ReorderableColumns\');
        this.plugins.push(\'CteTabbing\', \'DirtyCollection\');
        this._super("initialize", [options]);
        // we need to get the flex-list template from the ForecastWorksheets module so it can use the filteredCollection
        // for display
        this.template = app.template.getView(\'flex-list\', this.module);
        this.selectedUser = this.context.get(\'selectedUser\') || this.context.parent.get(\'selectedUser\') || app.user.toJSON();
        this.selectedTimeperiod = this.context.get(\'selectedTimePeriod\') || this.context.parent.get(\'selectedTimePeriod\') || \'\';
        this.context.set(\'skipFetch\', !(this.selectedUser.showOpps || !this.selectedUser.is_manager)); // if user is a manager, skip the initial fetch
        this.filters = this.context.get(\'selectedRanges\') || this.context.parent.get(\'selectedRanges\');
        this.collection.sync = _.bind(this.sync, this);
        this.noAccessDataErrorTemplate = app.template.getField(\'base\', \'noaccess\')(this);
        this.currentURL = Backbone.history.getFragment();
    },

    _dispose: function() {
        if (!_.isUndefined(this.context.parent) && !_.isNull(this.context.parent)) {
            this.context.parent.off(null, null, this);
            if (this.context.parent.has(\'collection\')) {
                this.context.parent.get(\'collection\').off(null, null, this);
            }
        }
        app.routing.offBefore(\'route\', this.beforeRouteHandler, this);
        $(window).off("beforeunload." + this.worksheetType);
        this._super("_dispose");
    },

    bindDataChange: function() {
        // these are handlers that we only want to run when the parent module is forecasts
        if (!_.isUndefined(this.context.parent) && !_.isUndefined(this.context.parent.get(\'model\'))) {
            if (this.context.parent.get(\'model\').module == \'Forecasts\') {
                this.context.parent.on(\'button:export_button:click\', function() {
                    if (this.layout.isVisible()) {
                        this.exportCallback();
                    }
                }, this);
                this.before(\'render\', function() {
                    return this.beforeRenderCallback()
                }, this);
                this.on(\'render\', function() {
                    this.renderCallback();
                    if (this.previewVisible) {
                        this.decorateRow(this.previewModel);
                    }
                }, this);

                this.on(\'list:toggle:column\', function(column, isVisible, columnMeta) {
                    // if we hide or show a column, recalculate totals
                    this.calculateTotals();
                }, this);

                this.context.parent.on(\'forecasts:worksheet:totals\', function(totals, type) {
                    if (type == this.worksheetType && this.layout.isVisible()) {
                        var tpl = app.template.getView(\'recordlist.totals\', this.module);
                        this.$el.find(\'tfoot\').remove();
                        this.$el.find(\'tbody\').after(tpl(this));
                    }
                }, this);
                
                /**
                 * trigger an event if dirty
                 */
                this.dirtyModels.on("add change reset", function(){
                    if(this.layout.isVisible()){
                        this.context.parent.trigger("forecasts:worksheet:dirty", this.worksheetType, this.dirtyModels.length > 0);
                    }
                }, this);
                
                this.context.parent.on(\'change:selectedTimePeriod\', function(model, changed) {
                    this.updateSelectedTimeperiod(changed);
                }, this);

                this.context.parent.on(\'change:selectedUser\', function(model, changed) {
                    this.updateSelectedUser(changed)
                }, this);

                this.context.parent.on(\'button:save_draft_button:click\', function() {
                    if (this.layout.isVisible()) {
                        // after we save, trigger the needs_commit event
                        this.context.parent.once(\'forecasts:worksheet:saved\', function() {
                            // clear out the current navigation message
                            this.setNavigationMessage(false, \'\', \'\');
                            this.cleanUpDirtyModels();
                            this.refreshData();
                            this.collection.once(\'reset\', function(){
                                this.context.parent.trigger(\'forecasts:worksheet:needs_commit\', this.worksheetType);
                            }, this);
                        }, this);
                        this.saveWorksheet(true);
                    }
                }, this);

                this.context.parent.on(\'button:commit_button:click\', function() {
                    if (this.layout.isVisible()) {
                        this.context.parent.once(\'forecasts:worksheet:saved\', function() {
                            this.context.parent.trigger(\'forecasts:worksheet:commit\', this.selectedUser, this.worksheetType, this.getCommitTotals())
                        }, this);
                        this.saveWorksheet(false);
                    }
                }, this);

                this.context.parent.on(\'change:currentForecastCommitDate\', function(context, changed) {
                    if (this.layout.isVisible()) {
                        this.checkForDraftRows(changed);
                    }
                }, this);

                if (this.context.parent.has(\'collection\')) {
                    var parentCollection = this.context.parent.get(\'collection\');

                    parentCollection.on(\'data:sync:start\', function() {
                        this.isLoadingCommits = true;
                    }, this);
                    parentCollection.on(\'data:sync:complete\', function() {
                        this.isLoadingCommits = false;
                    }, this);
                }

                this.collection.on(\'data:sync:start\', function() {
                    this.isCollectionSyncing = true;
                }, this);

                this.collection.on(\'data:sync:complete\', function() {
                    this.isCollectionSyncing = false;
                }, this);

                this.collection.on(\'reset\', function() {
                    this.setNavigationMessage(false, \'\', \'\');
                    this.cleanUpDirtyModels();
                    var ctx = this.context.parent || this.context;
                    ctx.trigger(\'forecasts:worksheet:is_dirty\', this.worksheetType, false);
                    if (this.isLoadingCommits === false) {
                        this.checkForDraftRows(ctx.get(\'currentForecastCommitDate\'));
                    }
                    this.filterCollection();
                }, this);

                this.collection.on(\'change:commit_stage\', function(model) {
                    if (!_.isEmpty(this.filters)  // we have filters
                        && _.indexOf(this.filters, model.get(\'commit_stage\')) === -1 // and the commit_stage is not shown
                        ) {
                        this.filterCollection();
                        if (!this.disposed) {
                            this.render();
                        }
                    } else {
                        var commitStage = model.get(\'commit_stage\'),
                            includedCommitStages = app.metadata.getModule(\'Forecasts\', \'config\').commit_stages_included,
                            el = this.$el.find(\'tr[name=\' + model.module + \'_\' + model.id + \']\'),
                            isIncluded = _.include(includedCommitStages, commitStage);

                        if (el) {
                            // we need to update the data-forecast attribute on the row
                            // and the new commit stage is visible
                            el.attr(\'data-forecast\', commitStage);

                            if (isIncluded && !el.hasClass(\'included\')) {
                                // if the commitStage is included, and it doesnt have the included class, add it
                                el.addClass(\'included\');
                                model.set({ includedInForecast: true }, {silent: true});
                            } else if (!isIncluded && el.hasClass(\'included\')) {
                                // if the commitStage isn\'t included, and it still has the class, remove it
                                el.removeClass(\'included\');
                                model.unset(\'includedInForecast\');
                            }
                        }
                    }
                }, this);

                this.context.parent.on(\'change:selectedRanges\', function(model, changed) {
                    this.filters = changed;
                    this.once(\'render\', function() {
                        app.alert.dismiss(\'worksheet_filtering\');
                    });
                    this.filterCollection();
                    this.calculateTotals();
                    if (!this.disposed) this.render();
                }, this);

                this.context.parent.on(\'forecasts:worksheet:committed\', function() {
                    if (this.layout.isVisible()) {
                        this.setNavigationMessage(false, \'\', \'\');
                        this.cleanUpDirtyModels();
                        var ctx = this.context.parent || this.context;
                        ctx.trigger(\'forecasts:worksheet:is_dirty\', this.worksheetType, false);
                        this.refreshData();
                    }
                }, this);

                this.context.parent.on(\'forecasts:worksheet:is_dirty\', function(worksheetType, is_dirty) {
                    if (this.worksheetType == worksheetType) {
                        if (is_dirty) {
                            this.setNavigationMessage(true, \'LBL_WARN_UNSAVED_CHANGES\', \'LBL_WARN_UNSAVED_CHANGES\');
                        } else {
                            this.setNavigationMessage(false, \'\', \'\');
                        }
                    }
                }, this);

                app.routing.before(\'route\', this.beforeRouteHandler, {}, this);

                $(window).bind("beforeunload." + this.worksheetType, _.bind(function() {
                    var ret = this.showNavigationMessage(\'window\');
                    if (_.isString(ret)) {
                        return ret;
                    }
                }, this));
            }
        }

        // listen for the before list:orderby to handle if the worksheet is dirty or notW
        this.before(\'list:orderby\', function(options) {
            if (this.isDirty()) {
                app.alert.show(\'leave_confirmation\', {
                    level: \'confirmation\',
                    messages: app.lang.get(\'LBL_WARN_UNSAVED_CHANGES_CONFIRM_SORT\', \'Forecasts\'),
                    onConfirm: _.bind(function() {
                        this._setOrderBy(options);
                    }, this)
                });
                return false;
            }
            return true;
        }, undefined, this);

        this.collection.on(\'reset change\', function() {
            this.calculateTotals();
        }, this);

        if (!_.isUndefined(this.dirtyModels)) {
            this.dirtyModels.on(\'add\', function() {
                if (this.canEdit) {
                    var ctx = this.context.parent || this.context;
                    ctx.trigger(\'forecasts:worksheet:is_dirty\', this.worksheetType, true);
                }
            }, this);
        }

        this.layout.on(\'hide\', function() {
            this.totals = {};
        }, this);

        // call the parent
        this._super("bindDataChange");
    },

    beforeRouteHandler: function() {
        return this.showNavigationMessage(\'router\');
    },
    
    /**
     * default navigation callback for alert message
     */
    defaultNavCallback: function(){
        this.displayNavigationMessage = false;
        app.router.navigate(this.targetURL, {trigger: true});
    },

    /**
     * {@inheritdoc}
     */
    unbindData: function() {
        app.events.off(null, null, this);
        this._super("unbindData");
    },

    /**
     * Handle Showing of the Navigation messages if any are applicable
     *
     * @param type
     * @returns {*}
     */
    showNavigationMessage: function(type, callback) {
        if (!_.isFunction(callback)) {
            callback = this.defaultNavCallback;
        }
        
        if (this.layout.isVisible()) {
            var canEdit = this.dirtyCanEdit || this.canEdit;
            if (canEdit && this.displayNavigationMessage) {
                if (type == \'window\') {
                    if (!_.isEmpty(this.routeNavigationMessage)) {
                        return app.lang.get(this.routeNavigationMessage, \'Forecasts\');
                    }
                    return false;
                }
                this.targetURL = Backbone.history.getFragment();

                //Replace the url hash back to the current staying page
                app.router.navigate(this._currentUrl, {trigger: false, replace: true});

                app.alert.show(\'leave_confirmation\', {
                    level: \'confirmation\',
                    messages: app.lang.get(this.navigationMessage, \'Forecasts\').split(\'<br>\'),
                    onConfirm: _.bind(function() {
                        callback.call(this);
                    }, this)
                });
                return false;
            }
        }
        return true;
    },

    /**
     * Utility to set the Navigation Message and Flag
     *
     * @param display
     * @param reload_label
     * @param route_label
     */
    setNavigationMessage: function(display, reload_label, route_label) {
        this.displayNavigationMessage = display;
        this.navigationMessage = reload_label;
        this.routeNavigationMessage = route_label;
        this.context.parent.trigger("forecasts:worksheet:navigationMessage", this.navigationMessage);
    },

    /**
     * Handle the export callback
     */
    exportCallback: function() {

        if (this.canEdit && this.isDirty()) {
            app.alert.show(\'leave_confirmation\', {
                level: \'confirmation\',
                messages: app.lang.get(\'LBL_WORKSHEET_EXPORT_CONFIRM\', \'Forecasts\'),
                onConfirm: _.bind(function() {
                    this.doExport();
                }, this)
            });
        } else {
            this.doExport();
        }
    },

    /**
     * Actually run the export
     */
    doExport: function() {
        app.alert.show(\'massexport_loading\', {level: \'process\', title: app.lang.get(\'LBL_LOADING\')});
        var params = {
            timeperiod_id: this.selectedTimeperiod,
            user_id: this.selectedUser.id,
            filters: this.filters,
            platform: app.config.platform
        };
        var url = app.api.buildURL(this.module, \'export\', null, params);

        app.api.fileDownload(url, {
            complete: function(data) {
                app.alert.dismiss(\'massexport_loading\');
            }
        }, { iframe: this.$el });
    },

    /**
     * Callback for the before(\'render\') event
     * @returns {boolean}
     */
    beforeRenderCallback: function() {
        // set the defaults to make it act like a manager so it doesn\'t actually render till the selected
        // user is updated
        var showOpps = (_.isUndefined(this.selectedUser.showOpps)) ? false : this.selectedUser.showOpps,
            isManager = (_.isUndefined(this.selectedUser.is_manager)) ? true : this.selectedUser.is_manager;

        if (!(showOpps || !isManager) && this.layout.isVisible()) {
            this.layout.hide();
        } else if ((showOpps || !isManager) && !this.layout.isVisible()) {
            this.layout.once(\'show\', this.calculateTotals, this);
            this.layout.show();
        }

        // empty out the left columns
        this.leftColumns = [];

        return (showOpps || !isManager);
    },

    /**
     * Callback for the on(\'render\') event
     */
    renderCallback: function() {
        var user = this.selectedUser || this.context.parent.get(\'selectedUser\') || app.user.toJSON()
        if (user.showOpps || !user.is_manager) {
            if (!this.layout.isVisible()) {
                this.layout.show();
            }

            if (this.filteredCollection.length == 0) {
                var tpl = app.template.getView(\'recordlist.noresults\', this.module);
                this.$el.find(\'tbody\').html(tpl(this));
            }

            // insert the footer
            if (!_.isEmpty(this.totals) && this.layout.isVisible()) {
                var tpl = app.template.getView(\'recordlist.totals\', this.module);
                this.$el.find(\'tbody\').after(tpl(this));
            }
            //adjust width of sales stage column to longest value so cells don\'t shift when using CTE
            var sales_stage_width = this.$el.find(\'td[data-field-name="sales_stage"] span.isEditable\').width();
            var sales_stage_outerwidth = this.$el.find(\'td[data-field-name="sales_stage"] span.isEditable\').outerWidth();
            this.$el.find(\'td[data-field-name="sales_stage"] span.isEditable\').width(sales_stage_width + 20);
            this.$el.find(\'td[data-field-name="sales_stage"] span.isEditable\').parent("td").css("min-width", sales_stage_outerwidth + 26 + "px");

            // figure out if any of the row actions need to be disabled
            this.setRowActionButtonStates();
        } else {
            if (this.layout.isVisible()) {
                this.layout.hide();
            }
        }
    },

    /**
     * Code to handle if the selected user changes
     *
     * @param changed
     */
    updateSelectedUser: function(changed) {
        var doFetch = false;
        if (this.selectedUser.id != changed.id) {
            // user changed. make sure it\'s not a manager view before we say fetch or not
            doFetch = (changed.showOpps || !changed.is_manager);
        }
        // if we are already not going to fetch, check to see if the new user is showingOpps or is not
        // a manager, then we want to fetch
        if (!doFetch && (changed.showOpps || !changed.is_manager)) {
            doFetch = true;
        }

        if (this.displayNavigationMessage) {
            // save the user just in case
            this.dirtyUser = this.selectedUser;
            this.dirtyCanEdit = this.canEdit;
        }
        this.cleanUpDirtyModels();
        
        this.selectedUser = changed;

        // Set the flag for use in other places around this controller to suppress stuff if we can\'t edit
        this.canEdit = (this.selectedUser.id == app.user.get(\'id\'));
        this.hasCheckedForDraftRecords = false;

        if (doFetch) {
            this.refreshData();
        } else {
            if ((!this.selectedUser.showOpps && this.selectedUser.is_manager) && this.layout.isVisible()) {
                // we need to hide
                this.layout.hide();
            }
        }
    },

    updateSelectedTimeperiod: function(changed) {
        if (this.displayNavigationMessage) {
            // save the time period just in case
            this.dirtyTimeperiod = this.selectedTimeperiod;
        }
        this.selectedTimeperiod = changed;
        this.hasCheckedForDraftRecords = false;
        if (this.layout.isVisible()) {
            this.refreshData();
        }
    },

    /**
     * Check to make sure that if there are dirty rows, then trigger the needs_commit event to enable
     * the buttons
     *
     * @fires forecasts:worksheet:needs_commit
     * @param lastCommitDate
     */
    checkForDraftRows: function(lastCommitDate) {
        if (this.layout.isVisible() && this.canEdit && this.hasCheckedForDraftRecords === false
            && !_.isEmpty(this.collection.models) && this.isCollectionSyncing === false) {
            this.hasCheckedForDraftRecords = true;
            if (_.isUndefined(lastCommitDate)) {
                // we have rows but no commit, enable the commit button
                this.context.parent.trigger(\'forecasts:worksheet:needs_commit\', this.worksheetType);
            } else {
                // check to see if anything in the collection is a draft, if it is, then send an event
                // to notify the commit button to enable
                this.collection.find(function(item) {
                    if (item.get(\'date_modified\') > lastCommitDate) {
                        this.context.parent.trigger(\'forecasts:worksheet:needs_commit\', this.worksheetType);
                        return true;
                    }
                    return false;
                }, this);
            }
        } else if (this.layout.isVisible() === false && this.canEdit && this.hasCheckedForDraftRecords === false) {
            // since the layout is not visible, lets wait for it to become visible
            this.layout.once(\'show\', function() {
                this.checkForDraftRows(lastCommitDate);
            }, this);
        } else if (this.isCollectionSyncing === true) {
            this.collection.once(\'data:sync:complete\', function() {
                this.checkForDraftRows(lastCommitDate);
            }, this);
        }
    },

    /**
     * Handles setting the proper state for the Preview in the row-actions
     */
    setRowActionButtonStates: function() {
        _.each(this.fields, function(field) {
            if (field.def.event === \'list:preview:fire\') {
                // we have a field that needs to be disabled, so disable it!
                field.setDisabled((field.model.get(\'parent_deleted\') == "1"));
                field.render();
            }
        });
    },

    /**
     * Filter the Collection so we only show what the filter says we should show
     */
    filterCollection: function() {
        this.filteredCollection.reset();
        if (_.isEmpty(this.filters)) {
            this.filteredCollection.add(this.collection.models);
        } else {
            this.collection.each(function(model) {
                if (_.indexOf(this.filters, model.get(\'commit_stage\')) !== -1) {
                    this.filteredCollection.add(model);
                }
            }, this);
        }
    },

    /**
     * Save the worksheet to the database
     *
     * @fires forecasts:worksheet:saved
     * @return {Number}
     */
    saveWorksheet: function(isDraft) {
        // only run the save when the worksheet is visible and it has dirty records
        var totalToSave = 0;
        if (this.layout.isVisible()) {
            var saveCount = 0,
                ctx = this.context.parent || this.context;

            if (this.isDirty()) {
                totalToSave = this.dirtyModels.length;
                this.dirtyModels.each(function(model) {
                    //set properties on model to aid in save
                    model.set({
                        "draft": (isDraft && isDraft == true) ? 1 : 0,
                        "timeperiod_id": this.dirtyTimeperiod || this.selectedTimeperiod,
                        "current_user": this.dirtyUser.id || this.selectedUser.id
                    }, {silent: true});

                    // set the correct module on the model since sidecar doesn\'t support sub-beans yet
                    model.save({}, {success: _.bind(function() {
                        saveCount++;

                        // Make sure the preview panel gets updated model info
                        if (this.previewVisible) {
                            var previewId = this.previewModel.get(\'parent_id\') || this.previewModel.get(\'id\');
                            if (model.get(\'parent_id\') == previewId) {
                                var previewCollection = new Backbone.Collection();
                                this.filteredCollection.each(function(model) {
                                    if (model.get(\'parent_deleted\') !== "1") {
                                        previewCollection.add(model);
                                    }
                                }, this);

                                app.events.trigger("preview:render", model, previewCollection, true, model.get(\'id\'), true);
                            }
                        }

                        //if this is the last save, go ahead and trigger the callback;
                        if (totalToSave === saveCount) {
                            // we only want to show this when the draft is being saved
                            if (isDraft) {
                                app.alert.show(\'success\', {
                                    level: \'success\',
                                    autoClose: true,
                                    autoCloseDelay: 10000,
                                    title: app.lang.get("LBL_FORECASTS_WIZARD_SUCCESS_TITLE", "Forecasts") + ":",
                                    messages: [app.lang.get("LBL_FORECASTS_WORKSHEET_SAVE_DRAFT_SUCCESS", "Forecasts")]
                                });
                            }
                            ctx.trigger(\'forecasts:worksheet:saved\', totalToSave, this.worksheetType, isDraft);
                        }
                    }, this), silent: true, alerts: { \'success\': false }});
                }, this);

                this.cleanUpDirtyModels();
            } else {
                // we only want to show this when the draft is being saved
                if (isDraft) {
                    app.alert.show(\'success\', {
                        level: \'success\',
                        autoClose: true,
                        autoCloseDelay: 10000,
                        title: app.lang.get("LBL_FORECASTS_WIZARD_SUCCESS_TITLE", "Forecasts") + ":",
                        messages: [app.lang.get("LBL_FORECASTS_WORKSHEET_SAVE_DRAFT_SUCCESS", "Forecasts")]
                    });
                }
                ctx.trigger(\'forecasts:worksheet:saved\', totalToSave, this.worksheetType, isDraft);
            }
        }

        return totalToSave
    },

    /**
     * Calculate the totals for the visible fields
     */
    calculateTotals: function() {
        // fire an event on the parent context
        if (this.layout.isVisible()) {
            this.totals = this.getCommitTotals();
            var calcFields = [\'worst_case\', \'best_case\', \'likely_case\'],
                fields = _.filter(this._fields.visible, function(field) {
                    if (_.contains(calcFields, field.name)) {
                        this.totals[field.name + \'_access\'] = app.acl.hasAccess(\'read\', this.module, app.user.get(\'id\'), field.name);
                        this.totals[field.name + \'_display\'] = true;
                        return true;
                    }

                    return false;
                }, this);

            // loop though all the fields and find where the worst/likely/best start at
            for(var x = 0; x < this._fields.visible.length; x++) {
                var f = this._fields.visible[x];
                if (_.contains(calcFields, f.name)) {
                    break;
                }
            }

            this.before_colspan = x;
            this.after_colspan = (this._fields.visible.length - (x + fields.length));

            var ctx = this.context.parent || this.context;
            ctx.trigger(\'forecasts:worksheet:totals\', this.totals, this.worksheetType);
        }
    },

    /**
     * Set the loading message and have a way to hide it
     */
    displayLoadingMessage: function() {
        app.alert.show(\'workshet_loading\',
            {level: \'process\', title: app.lang.get(\'LBL_LOADING\')}
        );
        this.collection.once(\'reset\', function() {
            app.alert.dismiss(\'workshet_loading\');
        }, this);
    },

    /**
     * Custom Method to handle the refreshing of the worksheet Data
     */
    refreshData: function() {
        this.displayLoadingMessage();
        this.collection.fetch();
    },

    /**
     * Custom Sync Method
     *
     * @param method
     * @param model
     * @param options
     */
    sync: function(method, model, options) {
        var callbacks,
            url;

        options = options || {};
        options.params = options.params || {};

        if (!_.isUndefined(this.selectedUser.id)) {
            options.params.user_id = this.selectedUser.id;
        }
        if (!_.isEmpty(this.selectedTimeperiod)) {
            options.params.timeperiod_id = this.selectedTimeperiod;
        }

        options.limit = 1000;
        options = app.data.parseOptionsForSync(method, model, options);

        // Since parent_name breaks the XHR call in the order by, just use the name field instead
        // they are the same anyways.
        if (!_.isUndefined(options.params.order_by) && options.params.order_by.indexOf(\'parent_name\') === 0) {
            options.params.order_by = options.params.order_by.replace(\'parent_\', \'\');
        }

        // custom success handler
        options.success = _.bind(function(model, data, options) {
            if(!this.disposed) {
                this.collection.reset(data);
            }
        }, this);

        callbacks = app.data.getSyncCallbacks(method, model, options);
        this.collection.trigger("data:sync:start", method, model, options);

        url = app.api.buildURL("ForecastWorksheets", null, null, options.params);
        app.api.call("read", url, null, callbacks);
    },

    /**
     * Get the totals that need to be committed
     *
     * @returns {{amount: number, best_case: number, worst_case: number, overall_amount: number, overall_best: number, overall_worst: number, timeperiod_id: (*|bindDataChange.selectedTimeperiod), lost_count: number, lost_amount: number, won_count: number, won_amount: number, included_opp_count: number, total_opp_count: Number, closed_count: number, closed_amount: number}}
     */
    getCommitTotals: function() {
        var includedAmount = 0,
            includedBest = 0,
            includedWorst = 0,
            filteredAmount = 0,
            filteredBest = 0,
            filteredWorst = 0,
            filteredCount = 0,
            overallAmount = 0,
            overallBest = 0,
            overallWorst = 0,
            includedCount = 0,
            lostCount = 0,
            lostAmount = 0,
            lostBest = 0,
            lostWorst = 0,
            wonCount = 0,
            wonAmount = 0,
            wonBest = 0,
            wonWorst = 0,
            includedClosedCount = 0,
            includedClosedAmount = 0,
            cfg = app.metadata.getModule(\'Forecasts\', \'config\'),
            startEndDates = this.context.get(\'selectedTimePeriodStartEnd\') ||
                this.context.parent.get(\'selectedTimePeriodStartEnd\'),
            activeFilters = this.context.get(\'selectedRanges\') || this.context.parent.get(\'selectedRanges\') || [];

        //Get the excluded_sales_stage property.  Default to empty array if not set
        var sales_stage_won_setting = cfg.sales_stage_won || [],
            sales_stage_lost_setting = cfg.sales_stage_lost || [];

        // set up commit_stages that should be processed in included total
        var commit_stages_in_included_total = [\'include\'];

        if (cfg.forecast_ranges == \'show_custom_buckets\') {
            commit_stages_in_included_total = cfg.commit_stages_included;
        }

        this.collection.each(function(model) {
            // make sure that the selected date is between the start and end dates for the current timeperiod
            // if it\'s not, then don\'t include it in the totals
            if (app.date(model.get(\'date_closed\')).isBetween(startEndDates[\'start\'], startEndDates[\'end\'])) {
                var won = _.include(sales_stage_won_setting, model.get(\'sales_stage\')),
                    lost = _.include(sales_stage_lost_setting, model.get(\'sales_stage\')),
                    commit_stage = model.get(\'commit_stage\'),
                    base_rate = model.get(\'base_rate\'),
                    // added || 0 in case these converted out to NaN so they dont make charts blow up
                    worst_base = app.currency.convertWithRate(model.get(\'worst_case\'), base_rate) || 0,
                    amount_base = app.currency.convertWithRate(model.get(\'likely_case\'), base_rate) || 0,
                    best_base = app.currency.convertWithRate(model.get(\'best_case\'), base_rate) || 0,
                    includedInForecast = _.include(commit_stages_in_included_total, commit_stage),
                    includedInFilter = _.include(activeFilters, commit_stage);

                if (won && includedInForecast) {
                    wonAmount = app.math.add(wonAmount, amount_base);
                    wonBest = app.math.add(wonBest, best_base);
                    wonWorst = app.math.add(wonWorst, worst_base);
                    wonCount++;

                    includedClosedCount++;
                    includedClosedAmount = app.math.add(amount_base, includedClosedAmount);
                } else if (lost) {
                    lostAmount = app.math.add(lostAmount, amount_base);
                    lostBest = app.math.add(lostBest, best_base);
                    lostWorst = app.math.add(lostWorst, worst_base);
                    lostCount++;
                }

                if (includedInFilter || _.isEmpty(activeFilters)) {
                    filteredAmount = app.math.add(filteredAmount, amount_base);
                    filteredBest = app.math.add(filteredBest, best_base);
                    filteredWorst = app.math.add(filteredWorst, worst_base);
                    filteredCount++;
                }

                if (includedInForecast) {
                    includedAmount = app.math.add(includedAmount, amount_base);
                    includedBest = app.math.add(includedBest, best_base);
                    includedWorst = app.math.add(includedWorst, worst_base);
                    includedCount++;

                    // since we\'re already looping through the collection of models and we have
                    // the included commit stages, set or unset the includedInForecast property here
                    model.set({ includedInForecast: true }, {silent: true});
                } else if (model.has(\'includedInForecast\')) {
                    model.unset(\'includedInForecast\');
                }

                overallAmount = app.math.add(overallAmount, amount_base);
                overallBest = app.math.add(overallBest, best_base);
                overallWorst = app.math.add(overallWorst, worst_base);
            }
        }, this);

        return {
            \'likely_case\': includedAmount,
            \'best_case\': includedBest,
            \'worst_case\': includedWorst,
            \'overall_amount\': overallAmount,
            \'overall_best\': overallBest,
            \'overall_worst\': overallWorst,
            \'filtered_amount\': filteredAmount,
            \'filtered_best\': filteredBest,
            \'filtered_worst\': filteredWorst,
            \'timeperiod_id\': this.dirtyTimeperiod || this.selectedTimeperiod,
            \'lost_count\': lostCount,
            \'lost_amount\': lostAmount,
            \'won_count\': wonCount,
            \'won_amount\': wonAmount,
            \'included_opp_count\': includedCount,
            \'total_opp_count\': this.collection.length,
            \'closed_count\': includedClosedCount,
            \'closed_amount\': includedClosedAmount
        };
    },

    /**
     * We need to overwrite so we pass in the filterd list
     */
    addPreviewEvents: function() {
        //When clicking on eye icon, we need to trigger preview:render with model&collection
        this.context.on("list:preview:fire", function(model) {
            var previewCollection = new Backbone.Collection();
            this.filteredCollection.each(function(model) {
                if (model.get(\'parent_deleted\') !== "1") {
                    previewCollection.add(model);
                }
            }, this);

            if (_.isUndefined(this.previewModel) || model.get(\'id\') != this.previewModel.get(\'id\')) {
                this.previewModel = model;
                app.events.trigger("preview:render", model, previewCollection, true);
            } else {
                // user already has the preview panel open and has clicked the preview icon again
                // remove row decoration
                this.decorateRow();
                // close the preview panel
                app.events.trigger(\'preview:close\');
            }
        }, this);

        //When switching to next/previous record from the preview panel, we need to update the highlighted row
        app.events.on("list:preview:decorate", this.decorateRow, this);
        if (this.layout) {
            this.layout.on("list:sort:fire", function() {
                //When sorting the list view, we need to close the preview panel
                app.events.trigger("preview:close");
            }, this);
        }

        app.events.on(\'preview:render\', function(model) {
            this.previewModel = model;
            this.previewVisible = true;
        }, this);

        app.events.on(\'preview:close\', function() {
            this.previewVisible = false;
            this.previewModel = undefined;
        }, this);
    }
})
',
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
              'name' => 'commit_stage',
              'type' => 'enum',
              'searchBarThreshold' => 7,
              'label' => 'LBL_FORECAST',
              'sortable' => false,
              'default' => true,
              'enabled' => true,
              'click_to_edit' => true,
            ),
            1 => 
            array (
              'name' => 'parent_name',
              'label' => 'LBL_REVENUELINEITEM_NAME',
              'link' => true,
              'id' => 'parent_id',
              'sortable' => true,
              'default' => true,
              'enabled' => true,
              'display' => false,
              'type' => 'parent',
              'readonly' => true,
            ),
            2 => 
            array (
              'name' => 'opportunity_name',
              'label' => 'LBL_OPPORTUNITY_NAME',
              'link' => true,
              'id' => 'opportunity_id',
              'id_name' => 'opportunity_id',
              'module' => 'Opportunities',
              'sortable' => true,
              'default' => true,
              'enabled' => true,
              'type' => 'relate',
              'readonly' => true,
            ),
            3 => 
            array (
              'name' => 'account_name',
              'label' => 'LBL_ACCOUNT_NAME',
              'link' => true,
              'id' => 'account_id',
              'id_name' => 'account_id',
              'module' => 'Accounts',
              'sortable' => true,
              'default' => true,
              'enabled' => true,
              'type' => 'relate',
              'readonly' => true,
            ),
            4 => 
            array (
              'name' => 'date_closed',
              'label' => 'LBL_DATE_CLOSED',
              'sortable' => true,
              'default' => false,
              'enabled' => true,
              'type' => 'date',
              'view' => 'detail',
              'click_to_edit' => true,
            ),
            5 => 
            array (
              'name' => 'sales_stage',
              'label' => 'LBL_SALES_STAGE',
              'type' => 'enum',
              'options' => 'sales_stage_dom',
              'searchBarThreshold' => 7,
              'sortable' => false,
              'default' => false,
              'enabled' => true,
              'click_to_edit' => true,
            ),
            6 => 
            array (
              'name' => 'probability',
              'label' => 'LBL_OW_PROBABILITY',
              'type' => 'int',
              'default' => false,
              'enabled' => true,
              'click_to_edit' => true,
              'align' => 'right',
            ),
            7 => 
            array (
              'name' => 'likely_case',
              'label' => 'LBL_LIKELY',
              'type' => 'currency',
              'default' => false,
              'enabled' => true,
              'convertToBase' => true,
              'showTransactionalAmount' => true,
              'align' => 'right',
              'click_to_edit' => true,
            ),
            8 => 
            array (
              'name' => 'best_case',
              'label' => 'LBL_BEST',
              'type' => 'currency',
              'default' => false,
              'enabled' => true,
              'convertToBase' => true,
              'showTransactionalAmount' => true,
              'align' => 'right',
              'click_to_edit' => true,
            ),
          ),
        ),
      ),
      'dependencies' => 
      array (
        0 => 
        array (
          'name' => 'opportunity_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'opportunity',
            1 => 'opportunity_id',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'opportunity_name',
                'value' => 'related($opportunity, "name")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        1 => 
        array (
          'name' => 'account_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'account',
            1 => 'account_id',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'account_name',
                'value' => 'related($account, "name")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        2 => 
        array (
          'name' => 'campaign_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'campaign',
            1 => 'campaign_id',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'campaign_name',
                'value' => 'related($campaign, "name")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        3 => 
        array (
          'name' => 'product_template_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'template',
            1 => 'product_template_id',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'product_template_name',
                'value' => 'related($template, "name")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        4 => 
        array (
          'name' => 'category_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'category',
            1 => 'category_id',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'category_name',
                'value' => 'related($category, "name")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        5 => 
        array (
          'name' => 'currency_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'currency',
            1 => 'currency_id',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'currency_name',
                'value' => 'related($currency, "name")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        6 => 
        array (
          'name' => 'probability',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'sales_stage',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'probability',
                'value' => 'getDropdownValue("sales_probability_dom",$sales_stage)',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        7 => 
        array (
          'name' => 'readOnlyopportunity_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'opportunity',
            1 => 'opportunity_id',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'opportunity_name',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        8 => 
        array (
          'name' => 'readOnlyaccount_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'account',
            1 => 'account_id',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'account_name',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        9 => 
        array (
          'name' => 'readOnlycampaign_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'campaign',
            1 => 'campaign_id',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'campaign_name',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        10 => 
        array (
          'name' => 'readOnlyproduct_template_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'template',
            1 => 'product_template_id',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'product_template_name',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        11 => 
        array (
          'name' => 'readOnlycategory_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'category',
            1 => 'category_id',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'category_name',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        12 => 
        array (
          'name' => 'readOnlycurrency_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'currency',
            1 => 'currency_id',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'currency_name',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        13 => 
        array (
          'name' => 'readOnlyprobability',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'sales_stage',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'probability',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
      ),
    ),
  ),
  'filter' => 
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
 * @class View.Views.Base.ForecastsWorksheets.FilterView
 * @alias SUGAR.App.view.views.BaseForecastsWorksheetsFilterView
 * @extends View.View
 */
({
    /**
     * Front End Javascript Events
     */
    events: {
        \'keydown .select2-input\': \'disableSelect2KeyPress\'
    },

    /**
     * Since we don\'t what the user to be able to type in the filter input
     * just disable all key press events for the .select2-input boxes
     *
     * @param event
     */
    disableSelect2KeyPress: function(event) {
        event.preventDefault();
    },

    /**
     * Key for saving the users last selected filters
     */
    userLastWorksheetFilterKey: undefined,

    /**
     * Initialize because we need to set the selectedUser variable
     * @param {Object} options
     */
    initialize: function(options) {
        this._super(\'initialize\', [options]);
        this.userLastWorksheetFilterKey = app.user.lastState.key(\'worksheet-filter\', this);
        this.selectedUser = {
            id: app.user.get(\'id\'),
            is_manager: app.user.get(\'is_manager\'),
            showOpps: false
        };
    },

    // prevent excessive renders when things change.
    bindDomChange: function() {},

    /**
     * Override the render to have call the group by toggle
     *
     * @private
     */
    _render:function () {
        app.view.View.prototype._render.call(this);

        this.node = this.$el.find("#" + this.cid);

        // set up the filters
        this._setUpFilters();

        return this;
    },


    /**
     * Set up select2 for driving the filter UI
     * @param node the element to use as the basis for select2
     * @private
     */
    _setUpFilters: function() {
        var ctx = this.context.parent || this.context,
            user_ranges = app.user.lastState.get(this.userLastWorksheetFilterKey),
            selectedRanges = user_ranges || ctx.get(\'selectedRanges\') || app.defaultSelections.ranges;

        this.node.select2({
            data:this._getRangeFilters(),
            initSelection: function(element, callback) {
                callback(_.filter(
                    this.data,
                    function(obj) {
                        return _.contains(this, obj.id);
                    },
                    $(element.val().split(","))
                ));
            },
            multiple:true,
            placeholder: app.lang.get("LBL_MODULE_FILTER"),
            dropdownCss: {width:"auto"},
            containerCssClass: "select2-choices-pills-close",
            containerCss: "border: none",
            formatSelection: this.formatCustomSelection,
            dropdownCssClass: "search-filter-dropdown",
            escapeMarkup: function(m) { return m; },
            width: \'100%\'
        });

        // set the default selections
        this.node.select2("val", selectedRanges);

        // add a change handler that updates the forecasts context appropriately with the user\'s selection
        this.node.change(
            {
                context: ctx
            },
            _.bind(function(event) {
                app.alert.show(\'worksheet_filtering\',
                    {level: \'process\', title: app.lang.get(\'LBL_LOADING\')}
                );
                app.user.lastState.set(this.userLastWorksheetFilterKey, event.val);
                _.delay(function() {
                    event.data.context.set(\'selectedRanges\', event.val);
                }, 25);
            }, this)
        );
    },
    /**
     * Formats pill selections
     * 
     * @param item selected item
     */
    formatCustomSelection: function(item) {        
        return \'<span class="select2-choice-type" disabled="disabled">\' + app.lang.get("LBL_FILTER") + \'</span><a class="select2-choice-filter" rel="\'+ item.id + \'" href="javascript:void(0)">\'+ item.text +\'</a>\';
    },

    /**
     * Gets the list of filters that correspond to the forecasts range settings that were selected by the admin during
     * configuration of the forecasts module.
     * @return {Array} array of the selected ranges
     */
    _getRangeFilters: function() {
        var options = app.metadata.getModule(\'Forecasts\', \'config\').buckets_dom || \'commit_stage_binary_dom\';

        return _.map(app.lang.getAppListStrings(options), function(value, key)  {
            return {id: key, text: value};
        });
    }

})
',
    ),
    'templates' => 
    array (
      'filter' => '
<div class="search-filter">
    <div class="control-group">
        <div class="filter">
            <div class="filter-view search">
                <input id="{{cid}}" class="select2 search-filter" type="hidden">
            </div>
        </div>
    </div>
</div>
',
    ),
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
              'name' => 'ranges',
              'type' => 'enum',
              'multi' => true,
              'label' => 'LBL_FILTERS',
              'default' => false,
              'enabled' => true,
            ),
          ),
        ),
      ),
      'last_state' => 
      array (
        'id' => 'filter',
      ),
      'dependencies' => 
      array (
        0 => 
        array (
          'name' => 'opportunity_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'opportunity',
            1 => 'opportunity_id',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'opportunity_name',
                'value' => 'related($opportunity, "name")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        1 => 
        array (
          'name' => 'account_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'account',
            1 => 'account_id',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'account_name',
                'value' => 'related($account, "name")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        2 => 
        array (
          'name' => 'campaign_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'campaign',
            1 => 'campaign_id',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'campaign_name',
                'value' => 'related($campaign, "name")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        3 => 
        array (
          'name' => 'product_template_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'template',
            1 => 'product_template_id',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'product_template_name',
                'value' => 'related($template, "name")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        4 => 
        array (
          'name' => 'category_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'category',
            1 => 'category_id',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'category_name',
                'value' => 'related($category, "name")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        5 => 
        array (
          'name' => 'currency_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'currency',
            1 => 'currency_id',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'currency_name',
                'value' => 'related($currency, "name")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        6 => 
        array (
          'name' => 'probability',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'sales_stage',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'probability',
                'value' => 'getDropdownValue("sales_probability_dom",$sales_stage)',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        7 => 
        array (
          'name' => 'readOnlyopportunity_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'opportunity',
            1 => 'opportunity_id',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'opportunity_name',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        8 => 
        array (
          'name' => 'readOnlyaccount_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'account',
            1 => 'account_id',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'account_name',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        9 => 
        array (
          'name' => 'readOnlycampaign_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'campaign',
            1 => 'campaign_id',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'campaign_name',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        10 => 
        array (
          'name' => 'readOnlyproduct_template_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'template',
            1 => 'product_template_id',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'product_template_name',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        11 => 
        array (
          'name' => 'readOnlycategory_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'category',
            1 => 'category_id',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'category_name',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        12 => 
        array (
          'name' => 'readOnlycurrency_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'currency',
            1 => 'currency_id',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'currency_name',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        13 => 
        array (
          'name' => 'readOnlyprobability',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'sales_stage',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'probability',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
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
              'name' => 'commit_stage',
              'type' => 'enum',
              'searchBarThreshold' => 7,
              'label' => 'LBL_FORECAST',
              'sortable' => false,
              'default' => true,
              'enabled' => true,
              'click_to_edit' => true,
            ),
            1 => 
            array (
              'name' => 'parent_name',
              'label' => 'LBL_REVENUELINEITEM_NAME',
              'link' => true,
              'id' => 'parent_id',
              'sortable' => true,
              'default' => true,
              'enabled' => true,
              'display' => false,
              'type' => 'parent',
              'readonly' => true,
            ),
            2 => 
            array (
              'name' => 'opportunity_name',
              'label' => 'LBL_OPPORTUNITY_NAME',
              'link' => true,
              'id' => 'opportunity_id',
              'id_name' => 'opportunity_id',
              'module' => 'Opportunities',
              'sortable' => true,
              'default' => true,
              'enabled' => true,
              'type' => 'relate',
              'readonly' => true,
            ),
            3 => 
            array (
              'name' => 'account_name',
              'label' => 'LBL_ACCOUNT_NAME',
              'link' => true,
              'id' => 'account_id',
              'id_name' => 'account_id',
              'module' => 'Accounts',
              'sortable' => true,
              'default' => true,
              'enabled' => true,
              'type' => 'relate',
              'readonly' => true,
            ),
            4 => 
            array (
              'name' => 'date_closed',
              'label' => 'LBL_DATE_CLOSED',
              'sortable' => true,
              'default' => false,
              'enabled' => true,
              'type' => 'date',
              'view' => 'detail',
              'click_to_edit' => true,
            ),
            5 => 
            array (
              'name' => 'sales_stage',
              'label' => 'LBL_SALES_STAGE',
              'type' => 'enum',
              'options' => 'sales_stage_dom',
              'searchBarThreshold' => 7,
              'sortable' => false,
              'default' => false,
              'enabled' => true,
              'click_to_edit' => true,
            ),
            6 => 
            array (
              'name' => 'probability',
              'label' => 'LBL_OW_PROBABILITY',
              'type' => 'int',
              'default' => false,
              'enabled' => true,
              'click_to_edit' => true,
              'align' => 'right',
            ),
            7 => 
            array (
              'name' => 'likely_case',
              'label' => 'LBL_LIKELY',
              'type' => 'currency',
              'default' => false,
              'enabled' => true,
              'convertToBase' => true,
              'showTransactionalAmount' => true,
              'align' => 'right',
              'click_to_edit' => true,
            ),
            8 => 
            array (
              'name' => 'best_case',
              'label' => 'LBL_BEST',
              'type' => 'currency',
              'default' => false,
              'enabled' => true,
              'convertToBase' => true,
              'showTransactionalAmount' => true,
              'align' => 'right',
              'click_to_edit' => true,
            ),
          ),
        ),
      ),
      'dependencies' => 
      array (
        0 => 
        array (
          'name' => 'opportunity_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'opportunity',
            1 => 'opportunity_id',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'opportunity_name',
                'value' => 'related($opportunity, "name")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        1 => 
        array (
          'name' => 'account_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'account',
            1 => 'account_id',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'account_name',
                'value' => 'related($account, "name")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        2 => 
        array (
          'name' => 'campaign_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'campaign',
            1 => 'campaign_id',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'campaign_name',
                'value' => 'related($campaign, "name")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        3 => 
        array (
          'name' => 'product_template_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'template',
            1 => 'product_template_id',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'product_template_name',
                'value' => 'related($template, "name")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        4 => 
        array (
          'name' => 'category_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'category',
            1 => 'category_id',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'category_name',
                'value' => 'related($category, "name")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        5 => 
        array (
          'name' => 'currency_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'currency',
            1 => 'currency_id',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'currency_name',
                'value' => 'related($currency, "name")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        6 => 
        array (
          'name' => 'probability',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'sales_stage',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'probability',
                'value' => 'getDropdownValue("sales_probability_dom",$sales_stage)',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        7 => 
        array (
          'name' => 'readOnlyopportunity_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'opportunity',
            1 => 'opportunity_id',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'opportunity_name',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        8 => 
        array (
          'name' => 'readOnlyaccount_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'account',
            1 => 'account_id',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'account_name',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        9 => 
        array (
          'name' => 'readOnlycampaign_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'campaign',
            1 => 'campaign_id',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'campaign_name',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        10 => 
        array (
          'name' => 'readOnlyproduct_template_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'template',
            1 => 'product_template_id',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'product_template_name',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        11 => 
        array (
          'name' => 'readOnlycategory_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'category',
            1 => 'category_id',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'category_name',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        12 => 
        array (
          'name' => 'readOnlycurrency_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'currency',
            1 => 'currency_id',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'currency_name',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        13 => 
        array (
          'name' => 'readOnlyprobability',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'sales_stage',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'probability',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
      ),
    ),
  ),
  'flex-list' => 
  array (
    'templates' => 
    array (
      'flex-list' => '
{{#each meta.panels}}
<div class="flex-list-view-content">
<table class="table table-striped dataTable{{#has "ReorderableColumns" ../plugins}} reorderable-columns{{/has}}">
    <thead>
    <tr>
        {{#each ../leftColumns}}
        <th{{#if name}} data-fieldname="{{name}}"{{/if}}>
            <span>
                {{field ../../this template="list-header"}}
            </span>
        </th>
        {{/each}}
        {{#each ../_fields.visible}}
            <th class="{{#isSortable ../../module this}}sorting{{#eq ../../../orderBy.field name}}_{{../../../../orderBy.direction}}{{/eq}} orderBy{{name}}{{/isSortable}}{{#if widthClass}} {{widthClass}}{{/if}}"
                {{#if name}} data-fieldname="{{name}}"{{/if}} data-orderby="{{orderBy}}">
                {{#has "ReorderableColumns" ../../plugins}}
                {{! Insert a <div> around all the inner element of the column.
                    This is a fix for firefox because the <th> does not support
                    a relative positioning.}}
                <div>
                    <div class="th-droppable-placeholder" data-droppableindex="{{@index}}"></div>
                    {{! Insert a <div> around the <span> containing the field label.
                        That <div> is the draggable element.
                        This is a fix for firefox because dragging a <th> is not
                        supported.}}
                    <div{{#has "ReorderableColumns" ../../../plugins}} data-draggable="true"{{/has}}>
                {{/has}}
                        <span>
                            {{str label ../../module}}
                        </span>
                {{#has "ReorderableColumns" ../../plugins}}
                    </div>
                    {{#if @last}}
                        <div class="th-droppable-placeholder th-droppable-placeholder-last" data-droppableindex="{{../../../../_fields.visible.length}}"></div>
                    {{/if}}
                </div>
                {{/has}}
            </th>
        {{/each}}
        {{#each ../rightColumns}}
            {{#if isColumnDropdown}}
            <th class="nosort morecol">
                <div class="dropdown">
                    <button class="btn btn-invisible" data-toggle="dropdown" data-action="fields-toggle"><i class="fa fa-ellipsis-h"></i></button>
                    <ul class="dropdown-menu left carettop">
                    {{#each ../../../_fields.all}}
                        <li>
                            <button{{#if selected}} class="active"{{/if}} data-field-toggle="{{name}}">
                                {{#if selected}}<i class="fa fa-check"></i> {{/if}}{{str label ../../../../module}}
                            </button>
                        </li>
                    {{/each}}
                    </ul>
                </div>
            </th>
            {{else}}
            <th{{#if name}} data-fieldname="{{name}}"{{/if}}>
                <span>
                    {{field ../../this template="list-header"}}
                </span>
            </th>
            {{/if}}
        {{/each}}
    </tr>
    <tr class="alert alert-warning hide">
        <td class="container"{{#if ../this.colSpan}} colspan="{{../../this.colSpan}}"{{/if}}></td>
    </tr>
    </thead>
    <tbody>
    {{#each ../filteredCollection.models}}
    <tr name="{{module}}_{{attributes.id}}" data-forecast="{{attributes.commit_stage}}"
        class="single{{#if attributes.includedInForecast}} included{{/if}}">

        {{#each ../../leftColumns}}
        <td>
             {{field ../../../this model=../this template=../../../this.viewName}}
        </td>
        {{/each}}
        {{#each ../../_fields.visible}}
            <td class="{{name}}_field {{#if align}} {{align}}{{/if}}{{#if click_to_edit}} editableColumn{{/if}}" data-field-name="{{name}}" data-type="{{type}}">
              {{field ../../../this model=../this template=../../../this.viewName}}
            </td>
        {{/each}}
        {{#each ../../rightColumns}}
        <td>
             {{field ../../../this model=../this template=../../../this.viewName}}
        </td>
        {{/each}}
    </tr>
    {{/each}}
    </tbody>
</table>
<span class="scrollbar-landmark"></span>
</div>
<div class="uxs-scroll-bar" data-scroll-spy="flex-list-view-content"><div>&nbsp;</div></div>
{{/each}}
',
    ),
    'meta' => 
    array (
      'dependencies' => 
      array (
        0 => 
        array (
          'name' => 'opportunity_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'opportunity',
            1 => 'opportunity_id',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'opportunity_name',
                'value' => 'related($opportunity, "name")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        1 => 
        array (
          'name' => 'account_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'account',
            1 => 'account_id',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'account_name',
                'value' => 'related($account, "name")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        2 => 
        array (
          'name' => 'campaign_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'campaign',
            1 => 'campaign_id',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'campaign_name',
                'value' => 'related($campaign, "name")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        3 => 
        array (
          'name' => 'product_template_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'template',
            1 => 'product_template_id',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'product_template_name',
                'value' => 'related($template, "name")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        4 => 
        array (
          'name' => 'category_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'category',
            1 => 'category_id',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'category_name',
                'value' => 'related($category, "name")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        5 => 
        array (
          'name' => 'currency_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'currency',
            1 => 'currency_id',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'currency_name',
                'value' => 'related($currency, "name")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        6 => 
        array (
          'name' => 'probability',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'sales_stage',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'probability',
                'value' => 'getDropdownValue("sales_probability_dom",$sales_stage)',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        7 => 
        array (
          'name' => 'readOnlyopportunity_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'opportunity',
            1 => 'opportunity_id',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'opportunity_name',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        8 => 
        array (
          'name' => 'readOnlyaccount_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'account',
            1 => 'account_id',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'account_name',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        9 => 
        array (
          'name' => 'readOnlycampaign_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'campaign',
            1 => 'campaign_id',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'campaign_name',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        10 => 
        array (
          'name' => 'readOnlyproduct_template_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'template',
            1 => 'product_template_id',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'product_template_name',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        11 => 
        array (
          'name' => 'readOnlycategory_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'category',
            1 => 'category_id',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'category_name',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        12 => 
        array (
          'name' => 'readOnlycurrency_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'currency',
            1 => 'currency_id',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'currency_name',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        13 => 
        array (
          'name' => 'readOnlyprobability',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'sales_stage',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'probability',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
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
              'name' => 'commit_stage',
              'type' => 'enum',
              'searchBarThreshold' => 7,
              'label' => 'LBL_FORECAST',
              'sortable' => false,
              'default' => true,
              'enabled' => true,
              'click_to_edit' => true,
            ),
            1 => 
            array (
              'name' => 'parent_name',
              'label' => 'LBL_OPPORTUNITY_NAME',
              'link' => true,
              'id' => 'parent_id',
              'sortable' => true,
              'default' => true,
              'enabled' => true,
              'type' => 'parent',
              'readonly' => true,
              'related_fields' => 
              array (
                0 => 'parent_id',
                1 => 'parent_type',
                2 => 'parent_deleted',
                3 => 'name',
              ),
            ),
            2 => 
            array (
              'name' => 'account_name',
            ),
            3 => 
            array (
              'name' => 'date_closed',
              'label' => 'LBL_DATE_CLOSED',
              'sortable' => true,
              'default' => true,
              'enabled' => true,
              'type' => 'date',
              'view' => 'detail',
              'click_to_edit' => true,
              'related_fields' => 
              array (
                0 => 'date_closed_timestamp',
              ),
            ),
            4 => 
            array (
              'name' => 'sales_stage',
              'label' => 'LBL_SALES_STAGE',
              'type' => 'enum',
              'options' => 'sales_stage_dom',
              'searchBarThreshold' => 7,
              'sortable' => false,
              'default' => true,
              'enabled' => true,
              'click_to_edit' => true,
              'related_fields' => 
              array (
                0 => 'probability',
              ),
            ),
            5 => 
            array (
              'name' => 'probability',
              'label' => 'LBL_OW_PROBABILITY',
              'type' => 'int',
              'default' => true,
              'enabled' => true,
              'maxValue' => 100,
              'minValue' => 0,
              'align' => 'right',
              'related_fields' => 
              array (
                0 => 'sales_stage',
              ),
            ),
            6 => 
            array (
              'name' => 'likely_case',
              'label' => 'LBL_LIKELY',
              'type' => 'currency',
              'default' => true,
              'enabled' => true,
              'convertToBase' => true,
              'showTransactionalAmount' => true,
              'skip_preferred_conversion' => true,
              'align' => 'right',
              'click_to_edit' => true,
              'related_fields' => 
              array (
                0 => 'base_rate',
                1 => 'currency_id',
                2 => 'best_case',
                3 => 'worst_case',
              ),
            ),
            7 => 
            array (
              'name' => 'best_case',
              'label' => 'LBL_BEST',
              'type' => 'currency',
              'default' => true,
              'enabled' => true,
              'convertToBase' => true,
              'showTransactionalAmount' => true,
              'skip_preferred_conversion' => true,
              'align' => 'right',
              'click_to_edit' => true,
              'related_fields' => 
              array (
                0 => 'base_rate',
                1 => 'currency_id',
              ),
            ),
          ),
        ),
      ),
      'dependencies' => 
      array (
        0 => 
        array (
          'name' => 'opportunity_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'opportunity',
            1 => 'opportunity_id',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'opportunity_name',
                'value' => 'related($opportunity, "name")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        1 => 
        array (
          'name' => 'account_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'account',
            1 => 'account_id',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'account_name',
                'value' => 'related($account, "name")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        2 => 
        array (
          'name' => 'campaign_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'campaign',
            1 => 'campaign_id',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'campaign_name',
                'value' => 'related($campaign, "name")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        3 => 
        array (
          'name' => 'product_template_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'template',
            1 => 'product_template_id',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'product_template_name',
                'value' => 'related($template, "name")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        4 => 
        array (
          'name' => 'category_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'category',
            1 => 'category_id',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'category_name',
                'value' => 'related($category, "name")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        5 => 
        array (
          'name' => 'currency_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'currency',
            1 => 'currency_id',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'currency_name',
                'value' => 'related($currency, "name")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        6 => 
        array (
          'name' => 'probability',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'sales_stage',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'probability',
                'value' => 'getDropdownValue("sales_probability_dom",$sales_stage)',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        7 => 
        array (
          'name' => 'readOnlyopportunity_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'opportunity',
            1 => 'opportunity_id',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'opportunity_name',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        8 => 
        array (
          'name' => 'readOnlyaccount_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'account',
            1 => 'account_id',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'account_name',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        9 => 
        array (
          'name' => 'readOnlycampaign_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'campaign',
            1 => 'campaign_id',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'campaign_name',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        10 => 
        array (
          'name' => 'readOnlyproduct_template_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'template',
            1 => 'product_template_id',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'product_template_name',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        11 => 
        array (
          'name' => 'readOnlycategory_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'category',
            1 => 'category_id',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'category_name',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        12 => 
        array (
          'name' => 'readOnlycurrency_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'currency',
            1 => 'currency_id',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'currency_name',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        13 => 
        array (
          'name' => 'readOnlyprobability',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'sales_stage',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'probability',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        14 => 
        array (
          'name' => 'ForecastWorksheetsListView_commit_stage_readonly_set_value',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'sales_stage',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'commit_stage',
                'label' => 'commit_stage_label',
                'value' => 'isForecastClosed($sales_stage)',
              ),
            ),
            1 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'commit_stage',
                'value' => 'ifElse(isForecastClosedWon($sales_stage), "include",                    ifElse(isForecastClosedLost($sales_stage), "exclude", $commit_stage))',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        15 => 
        array (
          'name' => 'ForecastWorksheetsListView_best_worst_sales_stage_read_only',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'sales_stage',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'best_case',
                'label' => 'best_case_label',
                'value' => 'isForecastClosed($sales_stage)',
              ),
            ),
            1 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'worst_case',
                'label' => 'worst_case_label',
                'value' => 'isForecastClosed($sales_stage)',
              ),
            ),
            2 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'best_case',
                'value' => 'ifElse(isForecastClosed($sales_stage), $likely_case, $best_case)',
              ),
            ),
            3 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'worst_case',
                'value' => 'ifElse(isForecastClosed($sales_stage), $likely_case, $worst_case)',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        16 => 
        array (
          'name' => 'ForecastWorksheetsListView_likely_case_copy_when_closed',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'likely_case',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'best_case',
                'value' => 'ifElse(isForecastClosed($sales_stage), $likely_case, $best_case)',
              ),
            ),
            1 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'worst_case',
                'value' => 'ifElse(isForecastClosed($sales_stage), $likely_case, $worst_case)',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
      ),
    ),
  ),
  'resolve-conflicts-list' => 
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
              'name' => 'commit_stage',
              'type' => 'enum',
              'searchBarThreshold' => 7,
              'label' => 'LBL_FORECAST',
              'sortable' => false,
              'default' => true,
              'enabled' => true,
              'click_to_edit' => true,
            ),
            1 => 
            array (
              'name' => 'parent_name',
              'label' => 'LBL_REVENUELINEITEM_NAME',
              'link' => true,
              'id' => 'parent_id',
              'sortable' => true,
              'default' => true,
              'enabled' => true,
              'display' => false,
              'type' => 'parent',
              'readonly' => true,
            ),
            2 => 
            array (
              'name' => 'opportunity_name',
              'label' => 'LBL_OPPORTUNITY_NAME',
              'link' => true,
              'id' => 'opportunity_id',
              'id_name' => 'opportunity_id',
              'module' => 'Opportunities',
              'sortable' => true,
              'default' => true,
              'enabled' => true,
              'type' => 'relate',
              'readonly' => true,
            ),
            3 => 
            array (
              'name' => 'account_name',
              'label' => 'LBL_ACCOUNT_NAME',
              'link' => true,
              'id' => 'account_id',
              'id_name' => 'account_id',
              'module' => 'Accounts',
              'sortable' => true,
              'default' => true,
              'enabled' => true,
              'type' => 'relate',
              'readonly' => true,
            ),
            4 => 
            array (
              'name' => 'date_closed',
              'label' => 'LBL_DATE_CLOSED',
              'sortable' => true,
              'default' => false,
              'enabled' => true,
              'type' => 'date',
              'view' => 'detail',
              'click_to_edit' => true,
            ),
            5 => 
            array (
              'name' => 'sales_stage',
              'label' => 'LBL_SALES_STAGE',
              'type' => 'enum',
              'options' => 'sales_stage_dom',
              'searchBarThreshold' => 7,
              'sortable' => false,
              'default' => false,
              'enabled' => true,
              'click_to_edit' => true,
            ),
            6 => 
            array (
              'name' => 'probability',
              'label' => 'LBL_OW_PROBABILITY',
              'type' => 'int',
              'default' => false,
              'enabled' => true,
              'click_to_edit' => true,
              'align' => 'right',
            ),
            7 => 
            array (
              'name' => 'likely_case',
              'label' => 'LBL_LIKELY',
              'type' => 'currency',
              'default' => false,
              'enabled' => true,
              'convertToBase' => true,
              'showTransactionalAmount' => true,
              'align' => 'right',
              'click_to_edit' => true,
            ),
            8 => 
            array (
              'name' => 'best_case',
              'label' => 'LBL_BEST',
              'type' => 'currency',
              'default' => false,
              'enabled' => true,
              'convertToBase' => true,
              'showTransactionalAmount' => true,
              'align' => 'right',
              'click_to_edit' => true,
            ),
          ),
        ),
      ),
      'dependencies' => 
      array (
        0 => 
        array (
          'name' => 'opportunity_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'opportunity',
            1 => 'opportunity_id',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'opportunity_name',
                'value' => 'related($opportunity, "name")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        1 => 
        array (
          'name' => 'account_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'account',
            1 => 'account_id',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'account_name',
                'value' => 'related($account, "name")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        2 => 
        array (
          'name' => 'campaign_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'campaign',
            1 => 'campaign_id',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'campaign_name',
                'value' => 'related($campaign, "name")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        3 => 
        array (
          'name' => 'product_template_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'template',
            1 => 'product_template_id',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'product_template_name',
                'value' => 'related($template, "name")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        4 => 
        array (
          'name' => 'category_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'category',
            1 => 'category_id',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'category_name',
                'value' => 'related($category, "name")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        5 => 
        array (
          'name' => 'currency_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'currency',
            1 => 'currency_id',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'currency_name',
                'value' => 'related($currency, "name")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        6 => 
        array (
          'name' => 'probability',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'sales_stage',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'probability',
                'value' => 'getDropdownValue("sales_probability_dom",$sales_stage)',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        7 => 
        array (
          'name' => 'readOnlyopportunity_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'opportunity',
            1 => 'opportunity_id',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'opportunity_name',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        8 => 
        array (
          'name' => 'readOnlyaccount_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'account',
            1 => 'account_id',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'account_name',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        9 => 
        array (
          'name' => 'readOnlycampaign_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'campaign',
            1 => 'campaign_id',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'campaign_name',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        10 => 
        array (
          'name' => 'readOnlyproduct_template_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'template',
            1 => 'product_template_id',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'product_template_name',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        11 => 
        array (
          'name' => 'readOnlycategory_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'category',
            1 => 'category_id',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'category_name',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        12 => 
        array (
          'name' => 'readOnlycurrency_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'currency',
            1 => 'currency_id',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'currency_name',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        13 => 
        array (
          'name' => 'readOnlyprobability',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'sales_stage',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'probability',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
      ),
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
      'dependencies' => 
      array (
        0 => 
        array (
          'name' => 'opportunity_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'opportunity',
            1 => 'opportunity_id',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'opportunity_name',
                'value' => 'related($opportunity, "name")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        1 => 
        array (
          'name' => 'account_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'account',
            1 => 'account_id',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'account_name',
                'value' => 'related($account, "name")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        2 => 
        array (
          'name' => 'campaign_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'campaign',
            1 => 'campaign_id',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'campaign_name',
                'value' => 'related($campaign, "name")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        3 => 
        array (
          'name' => 'product_template_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'template',
            1 => 'product_template_id',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'product_template_name',
                'value' => 'related($template, "name")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        4 => 
        array (
          'name' => 'category_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'category',
            1 => 'category_id',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'category_name',
                'value' => 'related($category, "name")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        5 => 
        array (
          'name' => 'currency_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'currency',
            1 => 'currency_id',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'currency_name',
                'value' => 'related($currency, "name")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        6 => 
        array (
          'name' => 'probability',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'sales_stage',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'probability',
                'value' => 'getDropdownValue("sales_probability_dom",$sales_stage)',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        7 => 
        array (
          'name' => 'readOnlyopportunity_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'opportunity',
            1 => 'opportunity_id',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'opportunity_name',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        8 => 
        array (
          'name' => 'readOnlyaccount_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'account',
            1 => 'account_id',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'account_name',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        9 => 
        array (
          'name' => 'readOnlycampaign_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'campaign',
            1 => 'campaign_id',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'campaign_name',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        10 => 
        array (
          'name' => 'readOnlyproduct_template_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'template',
            1 => 'product_template_id',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'product_template_name',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        11 => 
        array (
          'name' => 'readOnlycategory_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'category',
            1 => 'category_id',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'category_name',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        12 => 
        array (
          'name' => 'readOnlycurrency_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'currency',
            1 => 'currency_id',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'currency_name',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        13 => 
        array (
          'name' => 'readOnlyprobability',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'sales_stage',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'probability',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        14 => 
        array (
          'name' => 'ForecastWorksheetsRecordView_commit_stage_readonly_set_value',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'sales_stage',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'commit_stage',
                'label' => 'commit_stage_label',
                'value' => 'isForecastClosed($sales_stage)',
              ),
            ),
            1 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'commit_stage',
                'value' => 'ifElse(isForecastClosedWon($sales_stage), "include",                    ifElse(isForecastClosedLost($sales_stage), "exclude", $commit_stage))',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        15 => 
        array (
          'name' => 'ForecastWorksheetsRecordView_best_worst_sales_stage_read_only',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'sales_stage',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'best_case',
                'label' => 'best_case_label',
                'value' => 'isForecastClosed($sales_stage)',
              ),
            ),
            1 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'worst_case',
                'label' => 'worst_case_label',
                'value' => 'isForecastClosed($sales_stage)',
              ),
            ),
            2 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'best_case',
                'value' => 'ifElse(isForecastClosed($sales_stage), $likely_case, $best_case)',
              ),
            ),
            3 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'worst_case',
                'value' => 'ifElse(isForecastClosed($sales_stage), $likely_case, $worst_case)',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        16 => 
        array (
          'name' => 'ForecastWorksheetsRecordView_likely_case_copy_when_closed',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'likely_case',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'best_case',
                'value' => 'ifElse(isForecastClosed($sales_stage), $likely_case, $best_case)',
              ),
            ),
            1 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'worst_case',
                'value' => 'ifElse(isForecastClosed($sales_stage), $likely_case, $worst_case)',
              ),
            ),
          ),
          'notActions' => 
          array (
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
      'dependencies' => 
      array (
        0 => 
        array (
          'name' => 'opportunity_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'opportunity',
            1 => 'opportunity_id',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'opportunity_name',
                'value' => 'related($opportunity, "name")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        1 => 
        array (
          'name' => 'account_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'account',
            1 => 'account_id',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'account_name',
                'value' => 'related($account, "name")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        2 => 
        array (
          'name' => 'campaign_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'campaign',
            1 => 'campaign_id',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'campaign_name',
                'value' => 'related($campaign, "name")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        3 => 
        array (
          'name' => 'product_template_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'template',
            1 => 'product_template_id',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'product_template_name',
                'value' => 'related($template, "name")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        4 => 
        array (
          'name' => 'category_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'category',
            1 => 'category_id',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'category_name',
                'value' => 'related($category, "name")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        5 => 
        array (
          'name' => 'currency_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'currency',
            1 => 'currency_id',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'currency_name',
                'value' => 'related($currency, "name")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        6 => 
        array (
          'name' => 'probability',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'sales_stage',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'probability',
                'value' => 'getDropdownValue("sales_probability_dom",$sales_stage)',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        7 => 
        array (
          'name' => 'readOnlyopportunity_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'opportunity',
            1 => 'opportunity_id',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'opportunity_name',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        8 => 
        array (
          'name' => 'readOnlyaccount_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'account',
            1 => 'account_id',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'account_name',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        9 => 
        array (
          'name' => 'readOnlycampaign_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'campaign',
            1 => 'campaign_id',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'campaign_name',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        10 => 
        array (
          'name' => 'readOnlyproduct_template_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'template',
            1 => 'product_template_id',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'product_template_name',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        11 => 
        array (
          'name' => 'readOnlycategory_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'category',
            1 => 'category_id',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'category_name',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        12 => 
        array (
          'name' => 'readOnlycurrency_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'currency',
            1 => 'currency_id',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'currency_name',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        13 => 
        array (
          'name' => 'readOnlyprobability',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'sales_stage',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'probability',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
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
      'dependencies' => 
      array (
        0 => 
        array (
          'name' => 'opportunity_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'opportunity',
            1 => 'opportunity_id',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'opportunity_name',
                'value' => 'related($opportunity, "name")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        1 => 
        array (
          'name' => 'account_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'account',
            1 => 'account_id',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'account_name',
                'value' => 'related($account, "name")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        2 => 
        array (
          'name' => 'campaign_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'campaign',
            1 => 'campaign_id',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'campaign_name',
                'value' => 'related($campaign, "name")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        3 => 
        array (
          'name' => 'product_template_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'template',
            1 => 'product_template_id',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'product_template_name',
                'value' => 'related($template, "name")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        4 => 
        array (
          'name' => 'category_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'category',
            1 => 'category_id',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'category_name',
                'value' => 'related($category, "name")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        5 => 
        array (
          'name' => 'currency_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'currency',
            1 => 'currency_id',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'currency_name',
                'value' => 'related($currency, "name")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        6 => 
        array (
          'name' => 'probability',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'sales_stage',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'probability',
                'value' => 'getDropdownValue("sales_probability_dom",$sales_stage)',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        7 => 
        array (
          'name' => 'readOnlyopportunity_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'opportunity',
            1 => 'opportunity_id',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'opportunity_name',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        8 => 
        array (
          'name' => 'readOnlyaccount_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'account',
            1 => 'account_id',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'account_name',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        9 => 
        array (
          'name' => 'readOnlycampaign_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'campaign',
            1 => 'campaign_id',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'campaign_name',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        10 => 
        array (
          'name' => 'readOnlyproduct_template_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'template',
            1 => 'product_template_id',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'product_template_name',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        11 => 
        array (
          'name' => 'readOnlycategory_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'category',
            1 => 'category_id',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'category_name',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        12 => 
        array (
          'name' => 'readOnlycurrency_name',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'currency',
            1 => 'currency_id',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'currency_name',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        13 => 
        array (
          'name' => 'readOnlyprobability',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'sales_stage',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'probability',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        14 => 
        array (
          'name' => 'ForecastWorksheetsSubpanel-listView_commit_stage_readonly_set_value',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'sales_stage',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'commit_stage',
                'label' => 'commit_stage_label',
                'value' => 'isForecastClosed($sales_stage)',
              ),
            ),
            1 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'commit_stage',
                'value' => 'ifElse(isForecastClosedWon($sales_stage), "include",                    ifElse(isForecastClosedLost($sales_stage), "exclude", $commit_stage))',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        15 => 
        array (
          'name' => 'ForecastWorksheetsSubpanel-listView_best_worst_sales_stage_read_only',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'sales_stage',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'best_case',
                'label' => 'best_case_label',
                'value' => 'isForecastClosed($sales_stage)',
              ),
            ),
            1 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'worst_case',
                'label' => 'worst_case_label',
                'value' => 'isForecastClosed($sales_stage)',
              ),
            ),
            2 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'best_case',
                'value' => 'ifElse(isForecastClosed($sales_stage), $likely_case, $best_case)',
              ),
            ),
            3 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'worst_case',
                'value' => 'ifElse(isForecastClosed($sales_stage), $likely_case, $worst_case)',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        16 => 
        array (
          'name' => 'ForecastWorksheetsSubpanel-listView_likely_case_copy_when_closed',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'likely_case',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'best_case',
                'value' => 'ifElse(isForecastClosed($sales_stage), $likely_case, $best_case)',
              ),
            ),
            1 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'worst_case',
                'value' => 'ifElse(isForecastClosed($sales_stage), $likely_case, $worst_case)',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
      ),
    ),
  ),
  '_hash' => '6a9de5fbe947fc944b2b1095e00ff96f',
);

