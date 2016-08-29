<?php
$clientCache['Opportunities']['base']['field'] = array (
  'radioenum' => 
  array (
    'templates' => 
    array (
      'edit' => '
{{#eachOptions items}}
    <span class="radioenum-inline">
        <label>
            <input type="radio" name="{{../name}}" value="{{key}}"
                {{#if def.tabindex}} tabindex="{{def.tabindex}}"{{/if}}{{#eq key ../value}}checked{{/eq}}>
            {{value}}
        </label>
    </span>
{{/eachOptions}}
{{#unless hideHelp}}
    {{#if def.help}}
        <p class="help-block">{{str def.help module}}</p>
    {{/if}}
{{/unless}}
',
    ),
  ),
  'quickcreate' => 
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
 * @class View.Fields.Base.Opportunities.QuickcreateField
 * @alias SUGAR.App.view.fields.BaseOpportunitiesQuickcreateField
 * @extends View.Fields.Base.QuickcreateField
 */
({
    extendsFrom: \'QuickcreateField\',

    /**
     * @inheritdoc
     *
     * Had to extend QuickcreateField for Opps since we need the create-actions layout not the create layout
     */
    openCreateDrawer: function(module) {
        this.actionLayout = \'create-actions\';
        this._super(\'openCreateDrawer\', [module]);
    }
})
',
    ),
  ),
  'rowaction' => 
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
    extendsFrom: "RowactionField",
    
    /**
     * {@inheritdoc}
     */
    initialize: function(options) {
        this.plugins = _.clone(this.plugins) || [];
        this.plugins.push(\'DisableDelete\');
        this._super("initialize", [options]);
    }
})
',
    ),
  ),
  '_hash' => '99e457143365d08b5b6f12f05ef0e905',
);

