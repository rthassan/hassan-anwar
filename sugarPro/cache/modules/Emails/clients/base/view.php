<?php
$clientCache['Emails']['base']['view'] = array (
  'panel-top' => 
  array (
    'meta' => 
    array (
      'buttons' => 
      array (
        0 => 
        array (
          'type' => 'button',
          'css_class' => 'btn-invisible',
          'icon' => 'fa-chevron-up',
          'tooltip' => 'LBL_TOGGLE_VISIBILITY',
        ),
        1 => 
        array (
          'type' => 'actiondropdown',
          'name' => 'panel_dropdown',
          'css_class' => 'pull-right',
          'buttons' => 
          array (
            0 => 
            array (
              'type' => 'emailaction-paneltop',
              'icon' => 'fa-plus',
              'name' => 'email_compose_button',
              'label' => ' ',
              'acl_action' => 'create',
              'set_recipient_to_parent' => true,
              'set_related_to_parent' => true,
              'tooltip' => 'LBL_CREATE_BUTTON_LABEL',
            ),
            1 => 
            array (
              'type' => 'link-action',
              'name' => 'select_button',
              'label' => 'LBL_ASSOC_RELATED_RECORD',
              'css_class' => 'disabled',
            ),
          ),
        ),
      ),
    ),
  ),
  'compose-addressbook-list-bottom' => 
  array (
    'meta' => 
    array (
      'template' => 'list-bottom',
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
 */
/**
 * @class View.Views.Base.Emails.ComposeAddressbookListBottomView
 * @alias SUGAR.App.view.views.BaseEmailsComposeAddressbookListBottomView
 * @extends View.Views.Base.ListBottomView
 */
({
    extendsFrom: "ListBottomView",

    /**
     * Assign proper label for \'show more\' link.
     * Label should be "More recipients...".
     */
    setShowMoreLabel: function() {
        this.showMoreLabel = app.lang.get(\'LBL_SHOW_MORE_RECIPIENTS\', this.module);
    }
})
',
    ),
  ),
  'archive-email' => 
  array (
    'meta' => 
    array (
      'template' => 'record',
      'buttons' => 
      array (
        0 => 
        array (
          'type' => 'button',
          'name' => 'cancel_button',
          'label' => 'LBL_CANCEL_BUTTON_LABEL',
          'css_class' => 'btn-invisible btn-link',
          'events' => 
          array (
            'click' => 'button:cancel_button:click',
          ),
        ),
        1 => 
        array (
          'type' => 'button',
          'name' => 'archive_button',
          'label' => 'LBL_ARCHIVE',
          'css_class' => 'btn-primary',
        ),
        2 => 
        array (
          'name' => 'sidebar_toggle',
          'type' => 'sidebartoggle',
        ),
      ),
      'panels' => 
      array (
        0 => 
        array (
          'name' => 'panel_body',
          'label' => 'LBL_PANEL_2',
          'columns' => 1,
          'labels' => true,
          'labelsOnTop' => false,
          'placeholders' => true,
          'fields' => 
          array (
            0 => 
            array (
              'name' => 'date_sent',
              'type' => 'datetimecombo',
              'label' => 'LBL_DATE_SENT',
              'span' => 12,
              'required' => true,
            ),
            1 => 
            array (
              'name' => 'from_address',
              'type' => 'text',
              'label' => 'LBL_FROM',
              'span' => 12,
              'required' => true,
            ),
            2 => 
            array (
              'name' => 'to_addresses',
              'type' => 'recipients',
              'label' => 'LBL_TO_ADDRS',
              'span' => 12,
              'cell_css_class' => 'controls-one btn-fit',
              'required' => true,
            ),
            3 => 
            array (
              'name' => 'cc_addresses',
              'type' => 'recipients',
              'label' => 'LBL_CC',
              'span' => 12,
              'cell_css_class' => 'controls-one btn-fit',
            ),
            4 => 
            array (
              'name' => 'bcc_addresses',
              'type' => 'recipients',
              'label' => 'LBL_BCC',
              'span' => 12,
              'cell_css_class' => 'controls-one btn-fit',
            ),
            5 => 
            array (
              'name' => 'subject',
              'label' => 'LBL_SUBJECT',
              'span' => 12,
              'label_css_class' => 'end-fieldgroup',
              'required' => true,
            ),
            6 => 
            array (
              'name' => 'attachments',
              'label' => 'LBL_ATTACHMENTS',
              'type' => 'attachments',
            ),
            7 => 
            array (
              'name' => 'actionbar',
              'type' => 'compose-actionbar',
              'span' => 12,
              'inline' => true,
              'dismiss_label' => true,
              'fields' => 
              array (
                0 => 
                array (
                  'name' => 'attachments_dropdown',
                  'css_class' => 'btn-group',
                  'type' => 'actiondropdown',
                  'buttons' => 
                  array (
                    0 => 
                    array (
                      'name' => 'upload_new_button',
                      'type' => 'attachment-button',
                      'icon' => 'fa-paperclip',
                      'label' => 'LBL_ATTACHMENT',
                    ),
                    1 => 
                    array (
                      'name' => 'attach_sugardoc_button',
                      'type' => 'rowaction',
                      'label' => 'LBL_ATTACH_SUGAR_DOC',
                    ),
                  ),
                ),
                1 => 
                array (
                  'name' => 'other_actions',
                  'type' => 'fieldset',
                  'inline' => true,
                  'css_class' => 'actions pull-right',
                  'fields' => 
                  array (
                    0 => 
                    array (
                      'name' => 'signature_button',
                      'type' => 'button',
                      'icon' => 'fa-edit',
                      'label' => 'LBL_EMAIL_SIGNATURES',
                    ),
                    1 => 
                    array (
                      'name' => 'template_button',
                      'type' => 'button',
                      'icon' => 'fa-file-o',
                      'label' => 'LBL_EMAIL_TEMPLATES',
                    ),
                  ),
                ),
              ),
            ),
            8 => 
            array (
              'name' => 'html_body',
              'type' => 'htmleditable_tinymce',
              'dismiss_label' => true,
              'span' => 12,
              'tinyConfig' => 
              array (
                'script_url' => 'include/javascript/tiny_mce/tiny_mce.js',
                'height' => '100%',
                'width' => '100%',
                'browser_spellcheck' => true,
                'theme' => 'advanced',
                'skin' => 'sugar7',
                'plugins' => 'style,paste,inlinepopups',
                'entity_encoding' => 'raw',
                'forced_root_block' => false,
                'theme_advanced_buttons1' => 'code,separator,bold,italic,underline,strikethrough,separator,bullist,numlist,separator,justifyleft,justifycenter,justifyright,justifyfull,separator,forecolor,backcolor,separator,fontsizeselect',
                'theme_advanced_toolbar_location' => 'top',
                'theme_advanced_toolbar_align' => 'left',
                'theme_advanced_statusbar_location' => 'none',
                'theme_advanced_resizing' => false,
                'schema' => 'html5',
                'template_external_list_url' => 'lists/template_list.js',
                'external_link_list_url' => 'lists/link_list.js',
                'external_image_list_url' => 'lists/image_list.js',
                'media_external_list_url' => 'lists/media_list.js',
                'theme_advanced_path' => false,
                'theme_advanced_source_editor_width' => 500,
                'theme_advanced_source_editor_height' => 400,
                'inlinepopups_skin' => 'sugar7modal',
                'relative_urls' => false,
                'remove_script_host' => false,
              ),
            ),
          ),
        ),
        1 => 
        array (
          'name' => 'panel_hidden',
          'hide' => true,
          'columns' => 1,
          'labelsOnTop' => false,
          'placeholders' => true,
          'fields' => 
          array (
            0 => 
            array (
              'type' => 'teamset',
              'name' => 'team_name',
              'span' => 12,
            ),
            1 => 
            array (
              'label' => 'LBL_LIST_RELATED_TO',
              'type' => 'parent',
              'name' => 'parent_name',
              'options' => 'parent_type_display',
              'span' => 12,
            ),
            2 => 
            array (
              'name' => 'assigned_user_name',
              'type' => 'relate',
              'span' => 12,
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
 */
/**
 * @class View.Views.Base.Emails.ArchiveEmailView
 * @alias SUGAR.App.view.views.BaseEmailsArchiveEmailView
 * @extends View.Views.Base.Emails.ComposeView
 */
({
    extendsFrom: \'EmailsComposeView\',

    /**
     * Add click event handler to archive an email.
     * @param options
     */
    initialize: function(options) {
        this.events = _.extend({}, this.events, {
            \'click [name=archive_button]\': \'archive\'
        });
        this._super(\'initialize\', [options]);

        if (!this.model.has(\'assigned_user_id\')) {
            this.model.set(\'assigned_user_id\', app.user.id);
            this.model.set(\'assigned_user_name\', app.user.get(\'full_name\'));
        }
    },

    /**
     * Set headerpane title.
     * @private
     */
    _render: function () {
        this._super(\'_render\');
        this.setTitle(app.lang.get(\'LBL_ARCHIVE_EMAIL\', this.module));
    },

    /**
     * Archive email if validation passes.
     */
    archive: function(event) {
        this.setMainButtonsDisabled(true);
        this.model.doValidate(this.getFieldsToValidate(), _.bind(function(isValid) {
            if (isValid) {
                this.archiveEmail();
            } else {
                this.setMainButtonsDisabled(false);
            }
        }, this));
    },

    /**
     * Get fields that needs to be validated.
     * @returns {object}
     */
    getFieldsToValidate: function() {
        var fields = {};
        _.each(this.fields, function(field) {
            fields[field.name] = field.def;
        });
        return fields;
    },

    /**
     * Call archive api.
     */
    archiveEmail: function() {
        var archiveUrl = app.api.buildURL(\'Mail/archive\'),
            alertKey = \'mail_archive\',
            archiveEmailModel = this.initializeSendEmailModel();

        app.alert.show(alertKey, {level: \'process\', title: app.lang.get(\'LBL_EMAIL_ARCHIVING\', this.module)});

        app.api.call(\'create\', archiveUrl, archiveEmailModel, {
            success: _.bind(function() {
                app.alert.dismiss(alertKey);
                app.alert.show(alertKey, {
                    autoClose: true,
                    level: \'success\',
                    messages: app.lang.get(\'LBL_EMAIL_ARCHIVED\', this.module)
                });
                app.drawer.close(this.model);
            }, this),
            error: function(error) {
                var msg = {level: \'error\'};
                if (error && _.isString(error.message)) {
                    msg.messages = error.message;
                }
                app.alert.dismiss(alertKey);
                app.alert.show(alertKey, msg);
            },
            complete:_.bind(function() {
                if (!this.disposed) {
                    this.setMainButtonsDisabled(false);
                }
            }, this)
        });
    },

    /**
     * Get model that will be used to archive the email.
     * @returns {Backbone.Model}
     */
    initializeSendEmailModel: function() {
        var model = this._super(\'initializeSendEmailModel\');
        model.set({
            \'date_sent\': this.model.get(\'date_sent\'),
            \'from_address\': this.model.get(\'from_address\'),
            \'status\': \'archive\'
        });
        return model;
    },

    /**
     * Disable/enable archive button.
     * @param disabled
     */
    setMainButtonsDisabled: function(disabled) {
        this.getField(\'archive_button\').setDisabled(disabled);
    },

    /**
     * No need to warn of configuration status for archive email because no
     * email is being sent.
     */
    notifyConfigurationStatus: $.noop
})
',
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
          'name' => 'panel_header',
          'label' => 'LBL_PANEL_1',
          'fields' => 
          array (
            0 => 
            array (
              'label' => 'LBL_LIST_SUBJECT',
              'enabled' => true,
              'default' => true,
              'name' => 'name',
              'link' => 'true',
            ),
            1 => 
            array (
              'label' => 'LBL_LIST_STATUS',
              'enabled' => true,
              'default' => true,
              'name' => 'status',
            ),
            2 => 
            array (
              'name' => 'parent_name',
              'label' => 'LBL_LIST_RELATED_TO',
              'dynamic_module' => 'PARENT_TYPE',
              'id' => 'PARENT_ID',
              'link' => true,
              'enabled' => true,
              'default' => true,
              'sortable' => false,
              'ACLTag' => 'PARENT',
              'related_fields' => 
              array (
                0 => 'parent_id',
                1 => 'parent_type',
              ),
            ),
            3 => 
            array (
              'label' => 'LBL_DATE_CREATED',
              'enabled' => true,
              'default' => true,
              'name' => 'date_entered',
            ),
            4 => 
            array (
              'label' => 'LBL_DATE_MODIFIED',
              'enabled' => true,
              'default' => true,
              'name' => 'date_modified',
            ),
            5 => 
            array (
              'name' => 'assigned_user_name',
              'target_record_key' => 'assigned_user_id',
              'target_module' => 'Employees',
              'label' => 'LBL_LIST_ASSIGNED_TO_NAME',
              'enabled' => true,
              'default' => true,
            ),
          ),
        ),
      ),
    ),
  ),
  'compose' => 
  array (
    'meta' => 
    array (
      'template' => 'record',
      'buttons' => 
      array (
        0 => 
        array (
          'type' => 'button',
          'name' => 'cancel_button',
          'label' => 'LBL_CANCEL_BUTTON_LABEL',
          'css_class' => 'btn-invisible btn-link',
          'events' => 
          array (
            'click' => 'button:cancel_button:click',
          ),
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
              'name' => 'send_button',
              'type' => 'rowaction',
              'label' => 'LBL_SEND_BUTTON_LABEL',
              'events' => 
              array (
                'click' => 'button:send_button:click',
              ),
            ),
            1 => 
            array (
              'name' => 'draft_button',
              'type' => 'rowaction',
              'label' => 'LBL_SAVE_AS_DRAFT_BUTTON_LABEL',
              'events' => 
              array (
                'click' => 'button:draft_button:click',
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
      'panels' => 
      array (
        0 => 
        array (
          'name' => 'panel_body',
          'label' => 'LBL_PANEL_2',
          'columns' => 1,
          'labels' => true,
          'labelsOnTop' => false,
          'placeholders' => true,
          'fields' => 
          array (
            0 => 
            array (
              'name' => 'email_config',
              'label' => 'LBL_FROM',
              'type' => 'sender',
              'span' => 12,
              'css_class' => 'inherit-width',
              'label_css_class' => 'begin-fieldgroup',
              'endpoint' => 
              array (
                'module' => 'OutboundEmailConfiguration',
                'action' => 'list',
              ),
            ),
            1 => 
            array (
              'name' => 'to_addresses',
              'type' => 'recipients',
              'label' => 'LBL_TO_ADDRS',
              'span' => 12,
              'cell_css_class' => 'controls-one btn-fit',
              'required' => true,
            ),
            2 => 
            array (
              'name' => 'cc_addresses',
              'type' => 'recipients',
              'label' => 'LBL_CC',
              'span' => 12,
              'cell_css_class' => 'controls-one btn-fit',
            ),
            3 => 
            array (
              'name' => 'bcc_addresses',
              'type' => 'recipients',
              'label' => 'LBL_BCC',
              'span' => 12,
              'cell_css_class' => 'controls-one btn-fit',
            ),
            4 => 
            array (
              'name' => 'subject',
              'label' => 'LBL_SUBJECT',
              'span' => 12,
              'label_css_class' => 'end-fieldgroup',
            ),
            5 => 
            array (
              'name' => 'attachments',
              'label' => 'LBL_ATTACHMENTS',
              'type' => 'attachments',
            ),
            6 => 
            array (
              'name' => 'actionbar',
              'type' => 'compose-actionbar',
              'span' => 12,
              'inline' => true,
              'dismiss_label' => true,
              'fields' => 
              array (
                0 => 
                array (
                  'name' => 'attachments_dropdown',
                  'css_class' => 'btn-group',
                  'type' => 'actiondropdown',
                  'buttons' => 
                  array (
                    0 => 
                    array (
                      'name' => 'upload_new_button',
                      'type' => 'attachment-button',
                      'icon' => 'fa-paperclip',
                      'label' => 'LBL_ATTACHMENT',
                    ),
                    1 => 
                    array (
                      'name' => 'attach_sugardoc_button',
                      'type' => 'rowaction',
                      'label' => 'LBL_ATTACH_SUGAR_DOC',
                    ),
                  ),
                ),
                1 => 
                array (
                  'name' => 'other_actions',
                  'type' => 'fieldset',
                  'inline' => true,
                  'css_class' => 'actions pull-right',
                  'fields' => 
                  array (
                    0 => 
                    array (
                      'name' => 'signature_button',
                      'type' => 'button',
                      'icon' => 'fa-edit',
                      'label' => 'LBL_EMAIL_SIGNATURES',
                    ),
                    1 => 
                    array (
                      'name' => 'template_button',
                      'type' => 'button',
                      'icon' => 'fa-file-o',
                      'label' => 'LBL_EMAIL_TEMPLATES',
                    ),
                  ),
                ),
              ),
            ),
            7 => 
            array (
              'name' => 'html_body',
              'type' => 'htmleditable_tinymce',
              'dismiss_label' => true,
              'span' => 12,
              'tinyConfig' => 
              array (
                'script_url' => 'include/javascript/tiny_mce/tiny_mce.js',
                'height' => '100%',
                'width' => '100%',
                'browser_spellcheck' => true,
                'theme' => 'advanced',
                'skin' => 'sugar7',
                'plugins' => 'style,paste,inlinepopups',
                'entity_encoding' => 'raw',
                'forced_root_block' => false,
                'theme_advanced_buttons1' => 'code,separator,bold,italic,underline,strikethrough,separator,bullist,numlist,separator,justifyleft,justifycenter,justifyright,justifyfull,separator,forecolor,backcolor,separator,fontsizeselect',
                'theme_advanced_toolbar_location' => 'top',
                'theme_advanced_toolbar_align' => 'left',
                'theme_advanced_statusbar_location' => 'none',
                'theme_advanced_resizing' => false,
                'schema' => 'html5',
                'template_external_list_url' => 'lists/template_list.js',
                'external_link_list_url' => 'lists/link_list.js',
                'external_image_list_url' => 'lists/image_list.js',
                'media_external_list_url' => 'lists/media_list.js',
                'theme_advanced_path' => false,
                'theme_advanced_source_editor_width' => 500,
                'theme_advanced_source_editor_height' => 400,
                'inlinepopups_skin' => 'sugar7modal',
                'relative_urls' => false,
                'remove_script_host' => false,
              ),
            ),
          ),
        ),
        1 => 
        array (
          'name' => 'panel_hidden',
          'hide' => true,
          'columns' => 1,
          'labelsOnTop' => false,
          'placeholders' => true,
          'fields' => 
          array (
            0 => 
            array (
              'type' => 'teamset',
              'name' => 'team_name',
              'span' => 12,
            ),
            1 => 
            array (
              'label' => 'LBL_LIST_RELATED_TO',
              'type' => 'parent',
              'name' => 'parent_name',
              'options' => 'parent_type_display',
              'span' => 12,
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
 */
/**
 * @class View.Views.Base.Emails.ComposeView
 * @alias SUGAR.App.view.views.BaseEmailsComposeView
 * @extends View.Views.Base.RecordView
 */
({
    extendsFrom: \'RecordView\',

    _lastSelectedSignature: null,
    ATTACH_TYPE_SUGAR_DOCUMENT: \'document\',
    ATTACH_TYPE_TEMPLATE: \'template\',
    MIN_EDITOR_HEIGHT: 300,
    EDITOR_RESIZE_PADDING: 5,
    FIELD_PANEL_BODY_SELECTOR: \'.row-fluid.panel_body\',

    sendButtonName: \'send_button\',
    cancelButtonName: \'cancel_button\',
    saveAsDraftButtonName: \'draft_button\',

    /**
     * @inheritdoc
     */
    initialize: function(options) {
        _.bindAll(this);
        this._super(\'initialize\', [options]);
        this.events = _.extend({}, this.events, {
            \'click [data-toggle-field]\': \'_handleSenderOptionClick\'
        });
        this.context.on(\'actionbar:template_button:clicked\', this.launchTemplateDrawer, this);
        this.context.on(\'actionbar:attach_sugardoc_button:clicked\', this.launchDocumentDrawer, this);
        this.context.on(\'actionbar:signature_button:clicked\', this.launchSignatureDrawer, this);
        this.context.on(\'attachments:updated\', this.toggleAttachmentVisibility, this);
        this.context.on(\'tinymce:oninit\', this.handleTinyMceInit, this);
        this.on(\'more-less:toggled\', this.handleMoreLessToggled, this);
        app.drawer.on(\'drawer:resize\', this.resizeEditor, this);

        this._lastSelectedSignature = app.user.getPreference(\'signature_default\');
    },

    /**
     * @inheritdoc
     */
    delegateButtonEvents: function() {
        this.context.on(\'button:\' + this.sendButtonName + \':click\', this.send, this);
        this.context.on(\'button:\' + this.saveAsDraftButtonName + \':click\', this.saveAsDraft, this);
        this.context.on(\'button:\' + this.cancelButtonName + \':click\', this.cancel, this);
    },

    /**
     * @inheritdoc
     */
    _render: function() {
        this._super(\'_render\');
        if (this.createMode) {
            this.setTitle(app.lang.get(\'LBL_COMPOSEEMAIL\', this.module));
        }

        if (this.model.isNotEmpty) {
            var prepopulateValues = this.context.get(\'prepopulate\');
            if (!_.isEmpty(prepopulateValues)) {
                this.prepopulate(prepopulateValues);
            }
            this.addSenderOptions();

            if (this.model.isNew()) {
                this._updateEditorWithSignature(this._lastSelectedSignature);
            }
        }

        this.notifyConfigurationStatus();
    },

    /**
     * Notifies the user of configuration issues and disables send button
     */
    notifyConfigurationStatus: function() {
        var sendButton,
            emailClientPrefence = app.user.getPreference(\'email_client_preference\');

        if (_.isObject(emailClientPrefence) && _.isObject(emailClientPrefence.error)) {
            app.alert.show(\'email-client-status\', {
                level: \'warning\',
                messages: app.lang.get(emailClientPrefence.error.message, this.module),
                autoClose: false,
                onLinkClick: function() {
                    app.alert.dismiss(\'email-client-status\');
                }
            });

            sendButton = this.getField(\'send_button\');
            if (sendButton) {
                sendButton.setDisabled(true);
            }
        }
    },

    /**
     * Prepopulate fields on the email compose screen that are passed in on the context when opening this view
     * TODO: Refactor once we have custom module specific models
     * @param {Object} values
     */
    prepopulate: function(values) {
        var self = this;
        _.defer(function() {
            _.each(values, function(value, fieldName) {
                switch (fieldName) {
                    case \'related\':
                        self._populateForModules(value);
                        self.populateRelated(value);
                        break;
                    default:
                        self.model.set(fieldName, value);
                }
            });
        });
    },

    /**
     * Populates email compose with module specific data.
     * TODO: Refactor once we have custom module specific models
     * @param {Data.Bean} relatedModel
     */
    _populateForModules: function(relatedModel) {
        if (relatedModel.module === \'Cases\') {
            this._populateForCases(relatedModel);
        }
    },


    /**
     * Populates email compose with cases specific data.
     * TODO: Refactor once we have custom module specific models
     * @param {Data.Bean} relatedModel
     */
    _populateForCases: function(relatedModel) {
        var config = app.metadata.getConfig(),
            keyMacro = \'%1\',
            caseMacro = config.inboundEmailCaseSubjectMacro,
            subject = caseMacro + \' \' + relatedModel.get(\'name\');

        subject = subject.replace(keyMacro, relatedModel.get(\'case_number\'));
        this.model.set(\'subject\', subject);
        if (!this.isFieldPopulated(\'to_addresses\')) {
            // no addresses, attempt to populate from contacts relationship
            var contacts = relatedModel.getRelatedCollection(\'contacts\');

            contacts.fetch({
                relate: true,
                success: _.bind(function(data) {
                    var toAddresses = _.map(data.models, function(model) {
                        return {bean: model};
                    }, this);

                    this.model.set(\'to_addresses\', toAddresses);
                }, this),
                fields: [\'id\', \'full_name\', \'email\']
            });
        }
    },

    /**
     * Populate the parent_name (type: parent) with the related record passed in
     *
     * @param {Data.Bean} relatedModel
     */
    populateRelated: function(relatedModel) {
        var setParent = _.bind(function(model) {
            var parentNameField = this.getField(\'parent_name\');
            if (model.module && parentNameField.isAvailableParentType(model.module)) {
                model.value = model.get(\'name\');
                parentNameField.setValue(model);
            }
        }, this);

        if (!_.isEmpty(relatedModel.get(\'id\')) && !_.isEmpty(relatedModel.get(\'name\'))) {
            setParent(relatedModel);
        } else if (!_.isEmpty(relatedModel.get(\'id\'))) {
            relatedModel.fetch({
                showAlerts: false,
                success: function(relatedModel) {
                    setParent(relatedModel);
                },
                fields: [\'name\']
            });
        }
    },

    /**
     * Enable/disable the page action dropdown menu based on whether email is sendable
     * @param {boolean} disabled
     */
    setMainButtonsDisabled: function(disabled) {
        this.getField(\'main_dropdown\').setDisabled(disabled);
    },

    /**
     * Add Cc/Bcc toggle buttons
     * Initialize whether to show/hide fields and toggle show/hide buttons appropriately
     */
    addSenderOptions: function() {
        this._renderSenderOptions(\'to_addresses\');
        this._initSenderOption(\'cc_addresses\');
        this._initSenderOption(\'bcc_addresses\');
    },

    /**
     * Render the sender option buttons and place them in the given container
     *
     * @param {string} container Name of field that will contain the sender option buttons
     * @private
     */
    _renderSenderOptions: function(container) {
        var field = this.getField(container),
            $panelBody,
            senderOptionTemplate;

        if (field) {
            $panelBody = field.$el.closest(this.FIELD_PANEL_BODY_SELECTOR);
            senderOptionTemplate = app.template.getView(\'compose-senderoptions\', this.module);

            $(senderOptionTemplate({\'module\' : this.module}))
                .insertAfter($panelBody.find(\'div span.normal\'));
        }
    },

    /**
     * Check if the given field has a value
     * Hide the field if there is no value prepopulated
     *
     * @param {string} fieldName Name of the field to initialize active state on
     * @private
     */
    _initSenderOption: function(fieldName) {
        var fieldValue = this.model.get(fieldName) || [];
        this.toggleSenderOption(fieldName, (fieldValue.length > 0));
    },

    /**
     * Toggle the state of the given field
     * Sets toggle button state and visibility of the field
     *
     * @param {string} fieldName Name of the field to toggle
     * @param {boolean} [active] Whether toggle button active and field shown
     */
    toggleSenderOption: function(fieldName, active) {
        var toggleButtonSelector = \'[data-toggle-field="\' + fieldName + \'"]\',
            $toggleButton = this.$(toggleButtonSelector);

        // if explicit active state not set, toggle to opposite
        if (_.isUndefined(active)) {
            active = !$toggleButton.hasClass(\'active\');
        }

        $toggleButton.toggleClass(\'active\', active);
        this._toggleFieldVisibility(fieldName, active);
    },

    /**
     * Event Handler for toggling the Cc/Bcc options on the page.
     *
     * @param {Event} event click event
     * @private
     */
    _handleSenderOptionClick: function(event) {
        var $toggleButton = $(event.currentTarget),
            fieldName = $toggleButton.data(\'toggle-field\');

        this.toggleSenderOption(fieldName);
        this.resizeEditor();
    },

    /**
     * Show/hide a field section on the form
     *
     * @param {string} fieldName Name of the field to show/hide
     * @param {boolean} show Whether to show or hide the field
     * @private
     */
    _toggleFieldVisibility: function(fieldName, show) {
        var field = this.getField(fieldName);
        if (field) {
            field.$el.closest(this.FIELD_PANEL_BODY_SELECTOR).toggleClass(\'hide\', !show);
        }
    },

    /**
     * Cancel and close the drawer
     */
    cancel: function() {
        app.drawer.close();
    },

    /**
     * Get the attachments from the model and format for the API
     *
     * @return {Array} array of attachments or empty array if none found
     */
    getAttachmentsForApi: function() {
        var attachments = this.model.get(\'attachments\') || [];

        if (!_.isArray(attachments)) {
            attachments = [attachments];
        }

        return attachments;
    },

    /**
     * Get the individual related object fields from the model and format for the API
     *
     * @return {Object} API related argument as array with appropriate fields set
     */
    getRelatedForApi: function() {
        var related = {};
        var id = this.model.get(\'parent_id\');
        var type;

        if (!_.isUndefined(id)) {
            id = id.toString();
            if (id.length > 0) {
                related[\'id\'] = id;
                type = this.model.get(\'parent_type\');
                if (!_.isUndefined(type)) {
                    type = type.toString();
                }
                related.type = type;
            }
        }

        return related;
    },

    /**
     * Get the team information from the model and format for the API
     *
     * @return {Object} API teams argument as array with appropriate fields set
     */
    getTeamsForApi: function() {
        var teamName = this.model.get(\'team_name\') || [];
        var teams = {};
        teams.others = [];

        if (!_.isArray(teamName)) {
            teamName = [teamName];
        }

        _.each(teamName, function(team) {
            if (team.primary) {
                teams.primary = team.id.toString();
            } else if (!_.isUndefined(team.id)) {
                teams.others.push(team.id.toString());
            }
        }, this);

        if (teams.others.length == 0) {
            delete teams.others;
        }

        return teams;
    },

    /**
     * Build a backbone model that will be sent to the Mail API
     */
    initializeSendEmailModel: function() {
        var sendModel = new Backbone.Model(_.extend({}, this.model.attributes, {
            to_addresses: this.model.get(\'to_addresses\'),
            cc_addresses: this.model.get(\'cc_addresses\'),
            bcc_addresses: this.model.get(\'bcc_addresses\'),
            attachments: this.getAttachmentsForApi(),
            related: this.getRelatedForApi(),
            teams: this.getTeamsForApi()
        }));
        return sendModel;
    },

    /**
     * Save the email as a draft for later sending
     */
    saveAsDraft: function() {
        this.saveModel(
            \'draft\',
            app.lang.get(\'LBL_DRAFT_SAVING\', this.module),
            app.lang.get(\'LBL_DRAFT_SAVED\', this.module),
            app.lang.get(\'LBL_ERROR_SAVING_DRAFT\', this.module)
        );
    },

    /**
     * Send the email immediately or warn if user did not provide subject or body
     */
    send: function() {
        var sendEmail = _.bind(function() {
            this.saveModel(
                \'ready\',
                app.lang.get(\'LBL_EMAIL_SENDING\', this.module),
                app.lang.get(\'LBL_EMAIL_SENT\', this.module),
                app.lang.get(\'LBL_ERROR_SENDING_EMAIL\', this.module)
            );
        }, this);

        if (!this.isFieldPopulated(\'to_addresses\') &&
            !this.isFieldPopulated(\'cc_addresses\') &&
            !this.isFieldPopulated(\'bcc_addresses\')
        ) {
            this.model.trigger(\'error:validation:to_addresses\');
            app.alert.show(\'send_error\', {
                level: \'error\',
                messages: \'LBL_EMAIL_COMPOSE_ERR_NO_RECIPIENTS\'
            });
        } else if (!this.isFieldPopulated(\'subject\') && !this.isFieldPopulated(\'html_body\')) {
            app.alert.show(\'send_confirmation\', {
                level: \'confirmation\',
                messages: app.lang.get(\'LBL_NO_SUBJECT_NO_BODY_SEND_ANYWAYS\', this.module),
                onConfirm: sendEmail
            });
        } else if (!this.isFieldPopulated(\'subject\')) {
            app.alert.show(\'send_confirmation\', {
                level: \'confirmation\',
                messages: app.lang.get(\'LBL_SEND_ANYWAYS\', this.module),
                onConfirm: sendEmail
            });
        } else if (!this.isFieldPopulated(\'html_body\')) {
            app.alert.show(\'send_confirmation\', {
                level: \'confirmation\',
                messages: app.lang.get(\'LBL_NO_BODY_SEND_ANYWAYS\', this.module),
                onConfirm: sendEmail
            });
        } else {
            sendEmail();
        }
    },

    /**
     * Build the backbone model to be sent to the Mail API with the appropriate status
     * Also display the appropriate alerts to give user indication of what is happening.
     *
     * @param {string} status (draft or ready)
     * @param {string} pendingMessage message to display while Mail API is being called
     * @param {string} successMessage message to display when a successful Mail API response has been received
     * @param {string} errorMessage message to display when Mail API call fails
     */
    saveModel: function(status, pendingMessage, successMessage, errorMessage) {
        var myURL,
            sendModel = this.initializeSendEmailModel();

        this.setMainButtonsDisabled(true);
        app.alert.show(\'mail_call_status\', {level: \'process\', title: pendingMessage});

        sendModel.set(\'status\', status);
        myURL = app.api.buildURL(\'Mail\');
        app.api.call(\'create\', myURL, sendModel, {
            success: function() {
                app.alert.dismiss(\'mail_call_status\');
                app.alert.show(\'mail_call_status\', {autoClose: true, level: \'success\', messages: successMessage});
                app.drawer.close();
            },
            error: function(error) {
                var msg = {level: \'error\'};
                if (error && _.isString(error.message)) {
                    msg.messages = error.message;
                }
                app.alert.dismiss(\'mail_call_status\');
                app.alert.show(\'mail_call_status\', msg);
            },
            complete: _.bind(function() {
                if (!this.disposed) {
                    this.setMainButtonsDisabled(false);
                }
            }, this)
        });
    },

    /**
     * Is this field populated?
     * @param {string} fieldName
     * @return {boolean}
     */
    isFieldPopulated: function(fieldName) {
        var value = this.model.get(fieldName);

        if (value instanceof Backbone.Collection) {
            return value.length !== 0;
        } else {
            return !_.isEmpty($.trim(value));
        }
    },

    /**
     * Open the drawer with the EmailTemplates selection list layout. The callback should take the data passed to it
     * and replace the existing editor contents with the selected template.
     */
    launchTemplateDrawer: function() {
        app.drawer.open({
                layout: \'selection-list\',
                context: {
                    module: \'EmailTemplates\'
                }
            },
            this.templateDrawerCallback
        );
    },

    /**
     * Receives the selected template to insert and begins the process of confirming the operation and inserting the
     * template into the editor.
     *
     * @param {Data.Bean} model
     */
    templateDrawerCallback: function(model) {
        if (model) {
            var emailTemplate = app.data.createBean(\'EmailTemplates\', { id: model.id });
            emailTemplate.fetch({
                success: this.confirmTemplate,
                error: _.bind(function(error) {
                    this._showServerError(error);
                }, this)
            });
        }
    },

    /**
     * Presents the user with a confirmation prompt indicating that inserting the template will replace all content
     * in the editor. If the user confirms "yes" then the template will inserted.
     *
     * @param {Data.Bean} template
     */
    confirmTemplate: function(template) {
        if (this.disposed === true) return; //if view is already disposed, bail out
        app.alert.show(\'delete_confirmation\', {
            level: \'confirmation\',
            messages: app.lang.get(\'LBL_EMAILTEMPLATE_MESSAGE_SHOW_MSG\', this.module),
            onConfirm: _.bind(function() {
                this.insertTemplate(template);
            }, this)
        });
    },

    /**
     * Inserts the template into the editor.
     *
     * @param {Data.Bean} template
     */
    insertTemplate: function(template) {
        var subject,
            notes;

        if (_.isObject(template)) {
            subject = template.get(\'subject\');

            if (subject) {
                this.model.set(\'subject\', subject);
            }

            //TODO: May need to move over replaces special characters.
            if (template.get(\'text_only\') === 1) {
                this.model.set(\'html_body\', template.get(\'body\'));
            } else {
                this.model.set(\'html_body\', template.get(\'body_html\'));
            }

            notes = app.data.createBeanCollection(\'Notes\');

            notes.fetch({
                \'filter\': {
                    \'filter\': [
                        {\'parent_id\': {\'$equals\': template.id}}
                    ]
                },
                success: _.bind(function(data) {
                    if (this.disposed === true) return; //if view is already disposed, bail out
                    if (!_.isEmpty(data.models)) {
                        this.insertTemplateAttachments(data.models);
                    }
                }, this),
                error: _.bind(function(error) {
                    this._showServerError(error);
                }, this)
            });

            // currently adds the html signature even when the template is text-only
            this._updateEditorWithSignature(this._lastSelectedSignature);
        }
    },

    /**
     * Inserts attachments associated with the template by triggering an "add" event for each attachment to add to the
     * attachments field.
     *
     * @param {Array} attachments
     */
    insertTemplateAttachments: function(attachments) {
        this.context.trigger(\'attachments:remove-by-tag\', \'template\');
        _.each(attachments, function(attachment) {
            var filename = attachment.get(\'filename\');
            this.context.trigger(\'attachment:add\', {
                id: attachment.id,
                name: filename,
                nameForDisplay: filename,
                tag: \'template\',
                type: this.ATTACH_TYPE_TEMPLATE
            });
        }, this);
    },

    /**
     * Open the drawer with the SugarDocuments attachment selection list layout. The callback should take the data
     * passed to it and add the document as an attachment.
     */
    launchDocumentDrawer: function() {
        app.drawer.open({
                layout: \'selection-list\',
                context: {module: \'Documents\'}
            },
            this.documentDrawerCallback);
    },

    /**
     * Fetches the selected SugarDocument using its ID and triggers an "add" event to add the attachment to the
     * attachments field.
     *
     * @param {Data.Bean} model
     */
    documentDrawerCallback: function(model) {
        if (model) {
            var sugarDocument = app.data.createBean(\'Documents\', { id: model.id });
            sugarDocument.fetch({
                success: _.bind(function(model) {
                    if (this.disposed === true) return; //if view is already disposed, bail out
                    this.context.trigger(\'attachment:add\', {
                        id: model.id,
                        name: model.get(\'filename\'),
                        nameForDisplay: model.get(\'filename\'),
                        type: this.ATTACH_TYPE_SUGAR_DOCUMENT
                    });
                }, this),
                error: _.bind(function(error) {
                    this._showServerError(error);
                }, this)
            });
        }
    },

    /**
     * Hide attachment field row if no attachments, show when added
     *
     * @param {Array} attachments
     */
    toggleAttachmentVisibility: function(attachments) {
        var $row = this.$(\'.attachments\').closest(\'.row-fluid\');
        if (attachments.length > 0) {
            $row.removeClass(\'hidden\');
            $row.addClass(\'single\');
        } else {
            $row.addClass(\'hidden\');
            $row.removeClass(\'single\');
        }
        this.resizeEditor();
    },

    /**
     * Open the drawer with the signature selection layout. The callback should take the data passed to it and insert
     * the signature in the correct place.
     *
     * @private
     */
    launchSignatureDrawer: function() {
        app.drawer.open(
            {
                layout: \'selection-list\',
                context: {
                    module: \'UserSignatures\'
                }
            },
            this._updateEditorWithSignature
        );
    },

    /**
     * Fetches the signature content using its ID and updates the editor with the content.
     *
     * @param {Data.Bean} model
     */
    _updateEditorWithSignature: function(model) {
        if (model && model.id) {
            var signature = app.data.createBean(\'UserSignatures\', { id: model.id });

            signature.fetch({
                success: _.bind(function(model) {
                    if (this.disposed === true) return; //if view is already disposed, bail out
                    if (this._insertSignature(model)) {
                        this._lastSelectedSignature = model;
                    }
                }, this),
                error: _.bind(function(error) {
                    this._showServerError(error);
                }, this)
            });
        }
    },

    /**
     * Inserts the signature into the editor.
     *
     * @param {Data.Bean} signature
     * @return {Boolean}
     * @private
     */
    _insertSignature: function(signature) {
        if (_.isObject(signature) && signature.get(\'signature_html\')) {
            var signatureContent = this._formatSignature(signature.get(\'signature_html\')),
                emailBody = this.model.get(\'html_body\') || \'\',
                signatureOpenTag = \'<br class="signature-begin" />\',
                signatureCloseTag = \'<br class="signature-end" />\',
                signatureOpenTagForRegex = \'(<br\\ class=[\\\'"]signature\\-begin[\\\'"].*?\\/?>)\',
                signatureCloseTagForRegex = \'(<br\\ class=[\\\'"]signature\\-end[\\\'"].*?\\/?>)\',
                signatureOpenTagMatches = emailBody.match(new RegExp(signatureOpenTagForRegex, \'gi\')),
                signatureCloseTagMatches = emailBody.match(new RegExp(signatureCloseTagForRegex, \'gi\')),
                regex = new RegExp(signatureOpenTagForRegex + \'[\\\\s\\\\S]*?\' + signatureCloseTagForRegex, \'g\');

            if (signatureOpenTagMatches && !signatureCloseTagMatches) {
                // there is a signature, but no close tag; so the signature runs from open tag until EOF
                emailBody = this._insertSignatureTag(emailBody, signatureCloseTag, false); // append the close tag
            } else if (!signatureOpenTagMatches && signatureCloseTagMatches) {
                // there is a signature, but no open tag; so the signature runs from BOF until close tag
                emailBody = this._insertSignatureTag(emailBody, signatureOpenTag, true); // prepend the open tag
            } else if (!signatureOpenTagMatches && !signatureCloseTagMatches) {
                // there is no signature, so add the tag to the correct location
                emailBody = this._insertSignatureTag(
                    emailBody,
                    signatureOpenTag + signatureCloseTag, // insert both tags as one
                    (app.user.getPreference(\'signature_prepend\') == \'true\'));
            }

            this.model.set(\'html_body\', emailBody.replace(regex, \'$1\' + signatureContent + \'$2\'));

            return true;
        }

        return false;
    },

    /**
     * Inserts a tag into the editor to surround the signature so the signature can be identified again.
     *
     * @param {string} body
     * @param {string} tag
     * @param {string} prepend
     * @return {string}
     * @private
     */
    _insertSignatureTag: function(body, tag, prepend) {
        var preSignature = \'\',
            postSignature = \'\';

        prepend = prepend || false;

        if (prepend) {
            var bodyOpenTag = \'<body>\',
                bodyOpenTagLoc = body.indexOf(bodyOpenTag);

            if (bodyOpenTagLoc > -1) {
                preSignature = body.substr(0, bodyOpenTagLoc + bodyOpenTag.length);
                postSignature = body.substr(bodyOpenTagLoc + bodyOpenTag.length, body.length);
            } else {
                postSignature = body;
            }
        } else {
            var bodyCloseTag = \'</body>\',
                bodyCloseTagLoc = body.indexOf(bodyCloseTag);

            if (bodyCloseTagLoc > -1) {
                preSignature = body.substr(0, bodyCloseTagLoc);
                postSignature = body.substr(bodyCloseTagLoc, body.length);
            } else {
                preSignature = body;
            }
        }

        return preSignature + tag + postSignature;
    },

    /**
     * Formats HTML signatures to replace select HTML-entities with their true characters.
     *
     * @param {string} signature
     */
    _formatSignature: function(signature) {
        signature = signature.replace(/&lt;/gi, \'<\');
        signature = signature.replace(/&gt;/gi, \'>\');

        return signature;
    },

    /**
     * Show a generic alert for server errors resulting from custom API calls during Email Compose workflows. Logs
     * the error message for system administrators as well.
     *
     * @param {SUGAR.HttpError} error
     * @private
     */
    _showServerError: function(error) {
        app.alert.show(\'server-error\', {
            level: \'error\',
            messages: \'ERR_GENERIC_SERVER_ERROR\'
        });
        app.error.handleHttpError(error);
    },

    /**
     * When toggling to show/hide hidden panel, resize editor accordingly
     */
    handleMoreLessToggled: function() {
        this.resizeEditor();
    },

    /**
     * When TinyMCE has been completely initialized, go ahead and resize the editor
     */
    handleTinyMceInit: function() {
        this.resizeEditor();
    },

    _dispose: function() {
        if (app.drawer) {
            app.drawer.off(null, null, this);
        }
        app.alert.dismiss(\'email-client-status\');
        this._super(\'_dispose\');
    },

    /**
     * Register keyboard shortcuts.
     */
    registerShortcuts: function() {
        app.shortcuts.register(\'Compose:Action:More\', \'m\', function() {
            var $primaryDropdown = this.$(\'.btn-primary[data-toggle=dropdown]\');
            if ($primaryDropdown.is(\':visible\') && !$primaryDropdown.hasClass(\'disabled\')) {
                $primaryDropdown.click();
            }
        }, this);
        this._super(\'registerShortcuts\');
    },

    /**
     * Resize the html editor based on height of the drawer it is in
     *
     * @param {number} [drawerHeight] current height of the drawer or height the drawer will be after animations
     */
    resizeEditor: function(drawerHeight) {
        var $editor, headerHeight, recordHeight, showHideHeight, diffHeight, editorHeight, newEditorHeight;

        $editor = this.$(\'.mceLayout .mceIframeContainer iframe\');
        //if editor not already rendered, cannot resize
        if ($editor.length === 0) {
            return;
        }

        drawerHeight = drawerHeight || app.drawer.getHeight();
        headerHeight = this.$(\'.headerpane\').outerHeight(true);
        recordHeight = this.$(\'.record\').outerHeight(true);
        showHideHeight = this.$(\'.show-hide-toggle\').outerHeight(true);
        editorHeight = $editor.height();

        //calculate the space left to fill - subtracting padding to prevent scrollbar
        diffHeight = drawerHeight - headerHeight - recordHeight - showHideHeight - this.EDITOR_RESIZE_PADDING;

        //add the space left to fill to the current height of the editor to get a new height
        newEditorHeight = editorHeight + diffHeight;

        //maintain min height
        if (newEditorHeight < this.MIN_EDITOR_HEIGHT) {
            newEditorHeight = this.MIN_EDITOR_HEIGHT;
        }

        //set the new height for the editor
        $editor.height(newEditorHeight);
    },

    /**
     * Turn off logic from record view which handles clicking the cancel button
     * as it causes issues for email compose.
     *
     * TODO: Remove this when record view changes to use button events instead
     * of DOM based events
     */
    cancelClicked: $.noop
})
',
    ),
  ),
  'subpanel-for-contacthistory' => 
  array (
    'meta' => 
    array (
      'type' => 'subpanel-list',
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
              'label' => 'LBL_LIST_SUBJECT',
              'enabled' => true,
              'default' => true,
              'name' => 'name',
            ),
            1 => 
            array (
              'label' => 'LBL_LIST_STATUS',
              'enabled' => true,
              'default' => true,
              'name' => 'status',
            ),
            2 => 
            array (
              'label' => 'LBL_DATE_CREATED',
              'enabled' => true,
              'default' => true,
              'name' => 'date_entered',
              'readonly' => true,
            ),
            3 => 
            array (
              'label' => 'LBL_DATE_MODIFIED',
              'enabled' => true,
              'default' => true,
              'name' => 'date_modified',
              'readonly' => true,
            ),
            4 => 
            array (
              'name' => 'assigned_user_name',
              'target_record_key' => 'assigned_user_id',
              'target_module' => 'Employees',
              'label' => 'LBL_LIST_ASSIGNED_TO_NAME',
              'enabled' => true,
              'default' => true,
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
          'name' => 'panel_header',
          'label' => 'LBL_PANEL_1',
          'fields' => 
          array (
            0 => 
            array (
              'label' => 'LBL_LIST_SUBJECT',
              'enabled' => true,
              'default' => true,
              'name' => 'name',
              'link' => 'true',
            ),
            1 => 
            array (
              'label' => 'LBL_LIST_STATUS',
              'enabled' => true,
              'default' => true,
              'name' => 'status',
            ),
            2 => 
            array (
              'name' => 'parent_name',
              'label' => 'LBL_LIST_RELATED_TO',
              'dynamic_module' => 'PARENT_TYPE',
              'id' => 'PARENT_ID',
              'link' => true,
              'enabled' => true,
              'default' => true,
              'sortable' => false,
              'ACLTag' => 'PARENT',
              'related_fields' => 
              array (
                0 => 'parent_id',
                1 => 'parent_type',
              ),
            ),
            3 => 
            array (
              'label' => 'LBL_DATE_CREATED',
              'enabled' => true,
              'default' => true,
              'name' => 'date_entered',
            ),
            4 => 
            array (
              'label' => 'LBL_DATE_MODIFIED',
              'enabled' => true,
              'default' => false,
              'name' => 'date_modified',
            ),
            5 => 
            array (
              'name' => 'assigned_user_name',
              'target_record_key' => 'assigned_user_id',
              'target_module' => 'Employees',
              'label' => 'LBL_LIST_ASSIGNED_TO_NAME',
              'enabled' => true,
              'default' => false,
            ),
          ),
        ),
      ),
    ),
  ),
  'compose-addressbook-recipientscontainer' => 
  array (
    'meta' => 
    array (
      'template' => 'record',
      'panels' => 
      array (
        0 => 
        array (
          'name' => 'selected_recipients',
          'columns' => 1,
          'labels' => true,
          'labelsOnTop' => true,
          'placeholders' => true,
          'fields' => 
          array (
            0 => 
            array (
              'name' => 'compose_addressbook_selected_recipients',
              'type' => 'recipients',
              'label' => 'LBL_SELECTED_RECIPIENTS',
              'css_class_container' => 'controls-one btn-fit',
              'readonly' => true,
              'span' => 12,
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
 */
/**
 * @class View.Views.Base.Emails.ComposeAddressbookRecipientscontainerView
 * @alias SUGAR.App.view.views.BaseEmailsComposeAddressbookRecipientscontainerView
 * @extends View.Views.Base.RecordView
 */
({
    extendsFrom:         "RecordView",
    enableHeaderButtons: false,
    enableHeaderPane:    false,
    events:              {},

    initialize: function(options) {
        this._super("initialize", [options]);
        this.model.isNotEmpty = true;
    },

    /**
     * Override to remove unwanted functionality.
     *
     * @param prefill
     */
    setupDuplicateFields: function(prefill) {},

    /**
     * Override to remove unwanted functionality.
     */
    delegateButtonEvents: function() {},

    /**
     * Override to remove unwanted functionality.
     */
    initButtons: function() {
        this.buttons = {};
    },

    /**
     * Override to remove unwanted functionality.
     */
    showPreviousNextBtnGroup: function() {},

    /**
     * Override to remove unwanted functionality.
     */
    bindDataChange: function() {},

    /**
     * Override to remove unwanted functionality.
     *
     * @param isEdit
     */
    toggleHeaderLabels: function(isEdit) {},

    /**
     * Override to remove unwanted functionality.
     *
     * @param field
     */
    toggleLabelByField: function (field) {},

    /**
     * Override to remove unwanted functionality.
     *
     * @param e
     * @param field
     */
    handleKeyDown: function(e, field) {},

    /**
     * Override to remove unwanted functionality.
     *
     * @param state
     */
    setButtonStates: function(state) {},

    /**
     * Override to remove unwanted functionality.
     *
     * @param title
     */
    setTitle: function(title) {}
})
',
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
          'name' => 'panel_header',
          'label' => 'LBL_PANEL_1',
          'fields' => 
          array (
            0 => 
            array (
              'label' => 'LBL_LIST_SUBJECT',
              'enabled' => true,
              'default' => true,
              'name' => 'name',
              'link' => 'true',
            ),
            1 => 
            array (
              'label' => 'LBL_LIST_STATUS',
              'enabled' => true,
              'default' => true,
              'name' => 'status',
            ),
            2 => 
            array (
              'name' => 'parent_name',
              'label' => 'LBL_LIST_RELATED_TO',
              'dynamic_module' => 'PARENT_TYPE',
              'id' => 'PARENT_ID',
              'link' => true,
              'enabled' => true,
              'default' => true,
              'sortable' => false,
              'ACLTag' => 'PARENT',
              'related_fields' => 
              array (
                0 => 'parent_id',
                1 => 'parent_type',
              ),
            ),
            3 => 
            array (
              'label' => 'LBL_DATE_CREATED',
              'enabled' => true,
              'default' => true,
              'name' => 'date_entered',
            ),
            4 => 
            array (
              'label' => 'LBL_DATE_MODIFIED',
              'enabled' => true,
              'default' => false,
              'name' => 'date_modified',
            ),
            5 => 
            array (
              'name' => 'assigned_user_name',
              'target_record_key' => 'assigned_user_id',
              'target_module' => 'Employees',
              'label' => 'LBL_LIST_ASSIGNED_TO_NAME',
              'enabled' => true,
              'default' => false,
            ),
          ),
        ),
      ),
    ),
  ),
  'history' => 
  array (
    'templates' => 
    array (
      'row' => '
{{#with rowModel}}
    <li>
        {{#notEq attributes.type \'inbound\'}}
            <div class="pull-right"><span class="label">{{getDDLabel attributes.type \'dom_email_types\'}}</span></div>
        {{/notEq}}
        <p>
        {{#if attributes.assigned_user_id}}
            <a href="#{{buildRoute module=\'Employees\' id=attributes.assigned_user_id action=\'detail\'}}" class="pull-left avatar avatar-md" data-title="{{fieldValue this \'assigned_user_name\'}}">
                <img src="{{fieldValue this \'picture_url\'}}" alt="{{fieldValue this \'assigned_user_name\'}}">
            </a>
        {{else}}
            <span class="fa fa-stack pull-left">
                <i class="fa fa-user fa-stack-base"></i>
                <i class="fa fa-question-circle fa-light"></i>
            </span>
        {{/if}}
        <a href="#{{buildRoute model=this action=\'detail\'}}">
        {{#if this.attributes.name}}
            {{fieldValue this \'name\'}}
        {{else}}
            {{str \'LBL_NO_SUBJECT\' this.module}}
        {{/if}}
        </a>
        </p>
        <div class="details">
            {{#if attributes.assigned_user_id}}
                <a href="#{{buildRoute module=\'Employees\' id=attributes.assigned_user_id action=\'detail\'}}">
                    {{fieldValue this \'assigned_user_name\'}}&#44;
                </a>
            {{else}}
                {{str \'LBL_UNASSIGNED\' this.module}}&#44;
            {{/if}}
            {{relativeTime attributes.record_date class=\'date\'}}
        </div>
    </li>
{{/with}}
',
      'records' => '
<div class="tab-pane active">
    {{#if collection.length}}
        <ul class="unstyled listed" data-action="pagination-body">
            {{#each collection.models}}
                <li>
                    {{#notEq attributes.type "inbound"}}
                        <div class="pull-right"><span class="label">{{getDDLabel attributes.type "dom_email_types"}}</span></div>
                    {{/notEq}}
                    <p>
                    {{#if attributes.assigned_user_id}}
                        <a href="#{{buildRoute module="Employees" id=attributes.assigned_user_id action="detail"}}" class="pull-left avatar avatar-md" data-title="{{fieldValue this "assigned_user_name"}}">
                            <img src="{{fieldValue this "picture_url"}}" alt="{{fieldValue this "assigned_user_name"}}">
                        </a>
                    {{else}}
                        <span class="fa fa-stack pull-left">
                            <i class="fa fa-user fa-stack-base"></i>
                            <i class="fa fa-question-circle fa-light"></i>
                        </span>
                    {{/if}}
                    <a href="#{{buildRoute model=this action="detail"}}">
                    {{#if this.attributes.name}}
                        {{fieldValue this "name"}}
                    {{else}}
                        {{str \'LBL_NO_SUBJECT\' this.module}}
                    {{/if}}
                    </a>
                    </p>
                    <div class="details">
                        {{#if attributes.assigned_user_id}}
                            <a href="#{{buildRoute module="Employees" id=attributes.assigned_user_id action="detail"}}">
                                {{fieldValue this "assigned_user_name"}}&#44;
                            </a>
                        {{else}}
                            {{str "LBL_UNASSIGNED" this.module}}&#44;
                        {{/if}}
                        {{relativeTime attributes.record_date class="date"}}
                    </div>
                </li>
            {{/each}}
        </ul>
    {{else}}
        <div class="block-footer">{{#if ../collection.dataFetched}}{{str "LBL_NO_DATA_AVAILABLE" this.module}}{{else}}{{str "LBL_LOADING" this.module}}{{/if}}</div>
    {{/if}}
</div>
',
    ),
  ),
  'compose-addressbook-headerpane' => 
  array (
    'meta' => 
    array (
      'template' => 'headerpane',
      'fields' => 
      array (
        0 => 
        array (
          'name' => 'title',
          'type' => 'label',
          'default_value' => 'LBL_COMPOSE_ADDRESSBOOK',
        ),
      ),
      'buttons' => 
      array (
        0 => 
        array (
          'name' => 'cancel_button',
          'type' => 'button',
          'label' => 'LBL_CANCEL_BUTTON_LABEL',
          'css_class' => 'btn-invisible btn-link',
        ),
        1 => 
        array (
          'name' => 'done_button',
          'type' => 'button',
          'label' => 'LBL_DONE_BUTTON_LABEL',
          'css_class' => 'btn-primary',
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
 */
/**
 * @class View.Views.Base.Emails.ComposeAddressbookHeaderpaneView
 * @alias SUGAR.App.view.views.BaseEmailsComposeAddressbookHeaderpaneView
 * @extends View.Views.Base.HeaderpaneView
 */
({
    extendsFrom: "HeaderpaneView",

    events: {
        "click [name=done_button]":   "_done",
        "click [name=cancel_button]": "_cancel"
    },

     /**
      * The user clicked the Done button so trigger an event to add selected recipients from the address book to the
      * target field and then close the drawer.
      *
      * @private
      */
     _done: function() {
         var recipients = this.model.get("compose_addressbook_selected_recipients");

         if (recipients) {
             app.drawer.close(recipients);
         } else {
             this._cancel();
         }
     },

    /**
     * Close the drawer.
     *
     * @private
     */
    _cancel: function() {
        app.drawer.close();
    }
})
',
    ),
  ),
  'compose-addressbook-filter' => 
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
 */
/**
 * @class View.Views.Base.Emails.ComposeAddressbookFilterView
 * @alias SUGAR.App.view.views.BaseEmailsComposeAddressbookFilterView
 * @extends View.View
 */
({
    _moduleFilterList: [],
    _allModulesId:     \'All\',
    _selectedModule:   null,
    _currentSearch:    \'\',
    events: {
        \'keyup .search-name\':        \'throttledSearch\',
        \'paste .search-name\':        \'throttledSearch\',
        \'click .add-on.fa-times\': \'clearInput\'
    },
    /**
     * Converts the input field to a select2 field and adds the module filter for refining the search.
     *
     * @private
     */
    _render: function() {
        app.view.View.prototype._render.call(this);
        this.buildModuleFilterList();
        this.buildFilter();
    },
    /**
     * Builds the list of allowed modules to provide the data to the select2 field.
     */
    buildModuleFilterList: function() {
        var allowedModules = this.collection.allowed_modules;

        this._moduleFilterList = [
            {id: this._allModulesId, text: app.lang.get(\'LBL_MODULE_ALL\')}
        ];

        _.each(allowedModules, function(module) {
            this._moduleFilterList.push({
                id: module,
                text: app.lang.getModuleName(module, {plural: true})
            });
        }, this);
    },
    /**
     * Converts the input field to a select2 field and initializes the selected module.
     */
    buildFilter: function() {
        var $filter = this.getFilterField();
        if ($filter.length > 0) {
            $filter.select2({
                data:                    this._moduleFilterList,
                allowClear:              false,
                multiple:                false,
                minimumResultsForSearch: -1,
                formatSelection:         _.bind(this.formatModuleSelection, this),
                formatResult:            _.bind(this.formatModuleChoice, this),
                dropdownCss:             {width: \'auto\'},
                dropdownCssClass:        \'search-filter-dropdown\',
                initSelection:           _.bind(this.initSelection, this),
                escapeMarkup:            function(m) { return m; },
                width:                   \'off\'
            });
            $filter.off(\'change\');
            $filter.on(\'change\', _.bind(this.handleModuleSelection, this));
            this._selectedModule = this._selectedModule || this._allModulesId;
            $filter.select2(\'val\', this._selectedModule);
        }
    },
    /**
     * Gets the filter DOM field.
     *
     * @returns {Object} DOM Element
     */
    getFilterField: function() {
        return this.$(\'input.select2\');
    },
    /**
     * Gets the module filter DOM field.
     *
     * @returns {Object} DOM Element
     */
    getModuleFilter: function() {
        return this.$(\'div.choice-filter\');
    },
    /**
     * Destroy the select2 plugin.
     */
    unbind: function() {
        $filter = this.getFilterField();
        if ($filter.length > 0) {
            $filter.off();
            $filter.select2(\'destroy\');
        }
        this._super("unbind");
    },
    /**
     * Performs a search once the user has entered a term.
     */
    throttledSearch: _.debounce(function(evt) {
        var newSearch = this.$(evt.currentTarget).val();
        if (this._currentSearch !== newSearch) {
            this._currentSearch = newSearch;
            this.applyFilter();
        }
    }, 400),
    /**
     * Initialize the module selection with the value for all modules.
     *
     * @param el
     * @param callback
     */
    initSelection: function(el, callback) {
        if (el.is(this.getFilterField())) {
            var module = _.findWhere(this._moduleFilterList, {id: el.val()});
            callback({id: module.id, text: module.text});
        }
    },
    /**
     * Format the selected module to display its name.
     *
     * @param {Object} item
     * @return {String}
     */
    formatModuleSelection: function(item) {
        // update the text for the selected module
        this.getModuleFilter().html(item.text);
        return \'<span class="select2-choice-type">\'
            + app.lang.get(\'LBL_MODULE\')
            + \'<i class="fa fa-caret-down"></i></span>\';
    },
    /**
     * Format the choices in the module select box.
     *
     * @param {Object} option
     * @return {String}
     */
    formatModuleChoice: function (option) {
        return \'<div><span class="select2-match"></span>\' + option.text + \'</div>\';
    },
    /**
     * Handler for when the module filter dropdown value changes, either via a click or manually calling jQuery\'s
     * .trigger("change") event.
     *
     * @param {Object} evt jQuery Change Event Object
     * @param {string} overrideVal (optional) ID passed in when manually changing the filter dropdown value
     */
    handleModuleSelection: function(evt, overrideVal) {
        var module = overrideVal || evt.val || this._selectedModule || this._allModulesId;
        // only perform a search if the module is in the approved list
        if (!_.isEmpty(_.findWhere(this._moduleFilterList, {id: module}))) {
            this._selectedModule = module;
            this.getFilterField().select2(\'val\', this._selectedModule);
            this.getModuleFilter().css(\'cursor\', \'pointer\');
            this.applyFilter();
        }
    },
    /**
     * Triggers an event that makes a call to search the address book and filter the data set.
     */
    applyFilter: function() {
        var searchAllModules = (this._selectedModule === this._allModulesId),
            // pass an empty array when all modules are being searched
            module = searchAllModules ? [] : [this._selectedModule],
            // determine if the filter is dirty so the "clearQuickSearchIcon" can be added/removed appropriately
            isDirty = !_.isEmpty(this._currentSearch);
        this._toggleClearQuickSearchIcon(isDirty);
        this.context.trigger(\'compose:addressbook:search\', module, this._currentSearch);
    },
    /**
     * Append or remove an icon to the quicksearch input so the user can clear the search easily.
     * @param {Boolean} addIt TRUE if you want to add it, FALSE to remove
     */
    _toggleClearQuickSearchIcon: function(addIt) {
        if (addIt && !this.$(\'.add-on.fa-times\')[0]) {
            this.$(\'.filter-view.search\').append(\'<i class="add-on fa fa-times"></i>\');
        } else if (!addIt) {
            this.$(\'.add-on.fa-times\').remove();
        }
    },
    /**
     * Clear input
     */
    clearInput: function() {
        var $filter          = this.getFilterField();
        this._currentSearch  = \'\';
        this._selectedModule = this._allModulesId;
        this.$(\'.search-name\').val(this._currentSearch);
        if ($filter.length > 0) {
            $filter.select2(\'val\', this._selectedModule);
        }
        this.applyFilter();
    }
})
',
    ),
    'templates' => 
    array (
      'compose-addressbook-filter' => '
<div class="search-filter">
    <div class="control-group">
        <div class="filter controls">
            <div class="filter-view search">
                <div>
                    <input type="hidden" class="select2 search-filter" data-placeholder="{{str "LBL_MODULE"}}">
                    <div class="choice-filter"></div>
                    <input type="text" size=" " class="search-name" placeholder="{{str "LBL_BASIC_SEARCH"}}&hellip;">
                </div>
            </div>
        </div>
    </div>
</div>
',
    ),
  ),
  'compose-senderoptions' => 
  array (
    'templates' => 
    array (
      'compose-senderoptions' => '
<div class="compose-sender-options">
	<div class="btn-group">
		<a type="button" class="btn" data-toggle-field="cc_addresses" tabindex="-1"><span class="text">{{str "LBL_CC_BUTTON" this.module}}</span></a>
		<a type="button" class="btn" data-toggle-field="bcc_addresses" tabindex="-1"><span class="text">{{str "LBL_BCC_BUTTON" this.module}}</span></a>
	</div>
</div>
',
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
              'label' => 'LBL_LIST_SUBJECT',
              'enabled' => true,
              'default' => true,
              'name' => 'name',
              'link' => 'true',
            ),
            1 => 
            array (
              'label' => 'LBL_LIST_STATUS',
              'enabled' => true,
              'default' => true,
              'name' => 'status',
            ),
            2 => 
            array (
              'label' => 'LBL_DATE_CREATED',
              'enabled' => true,
              'default' => true,
              'name' => 'date_entered',
              'readonly' => true,
            ),
            3 => 
            array (
              'label' => 'LBL_DATE_MODIFIED',
              'enabled' => true,
              'default' => true,
              'name' => 'date_modified',
              'readonly' => true,
            ),
            4 => 
            array (
              'name' => 'assigned_user_name',
              'target_record_key' => 'assigned_user_id',
              'target_module' => 'Employees',
              'label' => 'LBL_LIST_ASSIGNED_TO_NAME',
              'enabled' => true,
              'default' => true,
            ),
          ),
        ),
      ),
      'rowactions' => 
      array (
        'actions' => 
        array (
        ),
      ),
    ),
  ),
  'subpanel-for-contacts' => 
  array (
    'meta' => 
    array (
      'type' => 'subpanel-list',
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
              'label' => 'LBL_LIST_SUBJECT',
              'enabled' => true,
              'default' => true,
              'name' => 'name',
            ),
            1 => 
            array (
              'label' => 'LBL_LIST_STATUS',
              'enabled' => true,
              'default' => true,
              'name' => 'status',
            ),
            2 => 
            array (
              'label' => 'LBL_DATE_CREATED',
              'enabled' => true,
              'default' => true,
              'name' => 'date_entered',
              'readonly' => true,
            ),
            3 => 
            array (
              'label' => 'LBL_DATE_MODIFIED',
              'enabled' => true,
              'default' => true,
              'name' => 'date_modified',
              'readonly' => true,
            ),
            4 => 
            array (
              'name' => 'assigned_user_name',
              'target_record_key' => 'assigned_user_id',
              'target_module' => 'Employees',
              'label' => 'LBL_LIST_ASSIGNED_TO_NAME',
              'enabled' => true,
              'default' => true,
            ),
          ),
        ),
      ),
    ),
  ),
  'compose-addressbook-list' => 
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
 */
/**
 * @class View.Views.Base.Emails.ComposeAddressbookListView
 * @alias SUGAR.App.view.views.BaseEmailsComposeAddressbookListView
 * @extends View.Views.Base.FlexListView
 */
({
    extendsFrom: \'FlexListView\',
    plugins: [\'ListColumnEllipsis\', \'ListRemoveLinks\', \'Pagination\'],
    /**
     * Removes the event listeners that were added to the mass collection.
     */
    unbindData: function() {
        var massCollection = this.context.get(\'mass_collection\');
        if (massCollection) {
            massCollection.off(null, null, this);
        }
        this._super("unbindData");
    },
    /**
     * Override to inject field names into the request when fetching data for the list.
     *
     * @param module
     * @returns {Array}
     */
    getFieldNames: function(module) {
        // id and module always get returned, so name and email just need to be added
        return [\'name\', \'email\'];
    },
    /**
     * Override to hook in additional triggers as the mass collection is updated (rows are checked on/off in
     * the actionmenu field). Also attempts to pre-check any rows when the list is refreshed and selected recipients
     * are found within the new result set (this behavior occurs when the user searches the address book).
     *
     * @private
     */
    _render: function() {
        this._super("_render");
        var massCollection              = this.context.get(\'mass_collection\'),
            selectedRecipientsFieldName = \'compose_addressbook_selected_recipients\';
        if (massCollection) {
            // get rid of any old event listeners on the mass collection
            massCollection.off(null, null, this);
            // add a new recipient to the selected recipients field as recipients are added to the mass collection
            massCollection.on(\'add\', function(model) {
                var existingRecipients = this.model.get(selectedRecipientsFieldName);
                if (model.id && existingRecipients instanceof Backbone.Collection) {
                    existingRecipients.add(model);
                }
            }, this);
            // remove a recipient from the selected recipients field as recipients are removed from the mass collection
            massCollection.on(\'remove\', function(model) {
                var existingRecipients = this.model.get(selectedRecipientsFieldName);
                if (model.id && existingRecipients instanceof Backbone.Collection) {
                    existingRecipients.remove(model);
                }
            }, this);
            // remove from the selected recipients field all recipients found in the current collection
            massCollection.on(\'reset\', function(newCollection, prevCollection) {
                var existingRecipients = this.model.get(selectedRecipientsFieldName);
                if (existingRecipients instanceof Backbone.Collection) {
                    if (newCollection.length > 0) {
                        //select all should be cumulative
                        newCollection.add(prevCollection.previousModels);
                    } else {
                        //remove all should only remove models that are visible in the list
                        newCollection.add(_.difference(prevCollection.previousModels, this.collection.models));
                    }
                    existingRecipients.reset(newCollection.models);
                }
            }, this);
            // find any currently selected recipients and add them to mass_collection so the checkboxes on the
            // corresponding rows are pre-selected
            var existingRecipients = this.model.get(selectedRecipientsFieldName);
            if (existingRecipients instanceof Backbone.Collection && existingRecipients.length > 0) {
                // only bother with adding, to mass_collection, recipients that are visible in the list view
                var recipientsToPreselect = existingRecipients.filter(_.bind(function(recipient) {
                    return (this.collection.where({id: recipient.get(\'id\')}).length > 0);
                }, this));
                if (recipientsToPreselect.length > 0) {
                    massCollection.add(recipientsToPreselect);
                }
            }
        }
    },
    /**
     * Override to force translation of the module names as columns are added to the list.
     *
     * @param field
     * @private
     */
    _renderField: function(field) {
        if (field.name == \'_module\') {
            field.model.set(field.name, app.lang.getModuleName(field.model.get(field.name), {plural: true}));
        }
        this._super("_renderField", [field]);
    }
})
',
    ),
    'meta' => 
    array (
      'template' => 'list',
      'selection' => 
      array (
        'type' => 'multi',
        'actions' => 
        array (
        ),
        'disable_select_all_alert' => true,
      ),
      'panels' => 
      array (
        0 => 
        array (
          'fields' => 
          array (
            0 => 
            array (
              'name' => 'name',
              'label' => 'LBL_LIST_NAME',
              'enabled' => true,
              'default' => true,
            ),
            1 => 
            array (
              'name' => 'email',
              'label' => 'LBL_LIST_EMAIL',
              'type' => 'email',
              'sortable' => true,
              'enabled' => true,
              'default' => true,
            ),
            2 => 
            array (
              'name' => '_module',
              'label' => 'LBL_MODULE',
              'sortable' => false,
              'enabled' => true,
              'default' => true,
            ),
          ),
        ),
      ),
      'rowactions' => 
      array (
        'css_class' => 'pull-right',
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
    ),
  ),
  'subpanel-for-queues' => 
  array (
    'meta' => 
    array (
      'type' => 'subpanel-list',
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
              'label' => 'LBL_LIST_SUBJECT',
              'enabled' => true,
              'default' => true,
              'name' => 'name',
            ),
            1 => 
            array (
              'target_record_key' => 'case_id',
              'target_module' => 'Cases',
              'label' => 'LBL_LIST_CASE',
              'enabled' => true,
              'default' => true,
              'name' => 'case_name',
            ),
            2 => 
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
  'subpanel-for-users' => 
  array (
    'meta' => 
    array (
      'type' => 'subpanel-list',
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
              'label' => 'LBL_LIST_SUBJECT',
              'enabled' => true,
              'default' => true,
              'name' => 'name',
            ),
            1 => 
            array (
              'label' => 'LBL_LIST_STATUS',
              'enabled' => true,
              'default' => true,
              'name' => 'status',
            ),
            2 => 
            array (
              'target_record_key' => 'contact_id',
              'target_module' => 'Contacts',
              'label' => 'LBL_LIST_CONTACT',
              'enabled' => true,
              'default' => true,
              'name' => 'contact_name',
            ),
            3 => 
            array (
              'enabled' => true,
              'default' => true,
              'name' => 'date_modified',
              'readonly' => true,
            ),
            4 => 
            array (
              'enabled' => true,
              'default' => true,
              'name' => 'date_entered',
              'readonly' => true,
            ),
            5 => 
            array (
              'name' => 'assigned_user_name',
              'target_record_key' => 'assigned_user_id',
              'target_module' => 'Employees',
              'label' => 'LBL_LIST_ASSIGNED_TO_NAME',
              'enabled' => true,
              'default' => true,
            ),
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
          'name' => 'panel_header',
          'label' => 'LBL_PANEL_1',
          'fields' => 
          array (
            0 => 
            array (
              'label' => 'LBL_LIST_SUBJECT',
              'enabled' => true,
              'default' => true,
              'name' => 'name',
              'link' => 'true',
            ),
            1 => 
            array (
              'label' => 'LBL_LIST_STATUS',
              'enabled' => true,
              'default' => true,
              'name' => 'status',
            ),
            2 => 
            array (
              'name' => 'parent_name',
              'label' => 'LBL_LIST_RELATED_TO',
              'dynamic_module' => 'PARENT_TYPE',
              'id' => 'PARENT_ID',
              'link' => true,
              'enabled' => true,
              'default' => true,
              'sortable' => false,
              'ACLTag' => 'PARENT',
              'related_fields' => 
              array (
                0 => 'parent_id',
                1 => 'parent_type',
              ),
            ),
            3 => 
            array (
              'label' => 'LBL_DATE_CREATED',
              'enabled' => true,
              'default' => true,
              'name' => 'date_entered',
            ),
            4 => 
            array (
              'label' => 'LBL_DATE_MODIFIED',
              'enabled' => true,
              'default' => false,
              'name' => 'date_modified',
            ),
            5 => 
            array (
              'name' => 'assigned_user_name',
              'target_record_key' => 'assigned_user_id',
              'target_module' => 'Employees',
              'label' => 'LBL_LIST_ASSIGNED_TO_NAME',
              'enabled' => true,
              'default' => false,
            ),
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
  '_hash' => '203893bb75e5a30c07291a26f9dd436f',
);

