<?php
$clientCache['Calls']['base']['view'] = array (
  'recordlist' => 
  array (
    'meta' => 
    array (
      'selection' => 
      array (
        'type' => 'multi',
        'actions' => 
        array (
          0 => 
          array (
            'name' => 'edit_button',
            'type' => 'button',
            'label' => 'LBL_MASS_UPDATE',
            'primary' => true,
            'events' => 
            array (
              'click' => 'list:massupdate:fire',
            ),
            'acl_action' => 'massupdate',
          ),
          1 => 
          array (
            'name' => 'calc_field_button',
            'type' => 'button',
            'label' => 'LBL_UPDATE_CALC_FIELDS',
            'events' => 
            array (
              'click' => 'list:updatecalcfields:fire',
            ),
            'acl_action' => 'massupdate',
          ),
          2 => 
          array (
            'name' => 'delete_button',
            'type' => 'button',
            'label' => 'LBL_DELETE',
            'acl_action' => 'delete',
            'primary' => true,
            'events' => 
            array (
              'click' => 'list:massdelete:fire',
            ),
          ),
          3 => 
          array (
            'name' => 'export_button',
            'type' => 'button',
            'label' => 'LBL_EXPORT',
            'acl_action' => 'export',
            'primary' => true,
            'events' => 
            array (
              'click' => 'list:massexport:fire',
            ),
          ),
        ),
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
          1 => 
          array (
            'type' => 'rowaction',
            'name' => 'edit_button',
            'label' => 'LBL_EDIT_BUTTON',
            'event' => 'list:editrow:fire',
            'acl_action' => 'edit',
          ),
          2 => 
          array (
            'type' => 'closebutton',
            'name' => 'record-close',
            'label' => 'LBL_LIST_CLOSE',
            'closed_status' => 'Held',
            'acl_action' => 'edit',
          ),
          3 => 
          array (
            'type' => 'follow',
            'name' => 'follow_button',
            'event' => 'list:follow:fire',
            'acl_action' => 'view',
          ),
          4 => 
          array (
            'type' => 'rowaction',
            'name' => 'delete_button',
            'event' => 'list:deleterow:fire',
            'label' => 'LBL_DELETE_BUTTON',
            'acl_action' => 'delete',
          ),
          5 => 
          array (
            'type' => 'deleterecurrencesbutton',
            'name' => 'delete_recurrence_button',
            'label' => 'LBL_REMOVE_ALL_RECURRENCES',
            'acl_action' => 'delete',
          ),
        ),
      ),
    ),
  ),
  'preview' => 
  array (
    'meta' => 
    array (
      'panels' => 
      array (
        0 => 
        array (
          'name' => 'panel_header',
          'fields' => 
          array (
            0 => 
            array (
              'name' => 'picture',
              'type' => 'avatar',
              'size' => 'large',
              'dismiss_label' => true,
              'readonly' => true,
            ),
            1 => 'name',
            2 => 
            array (
              'name' => 'status',
              'type' => 'event-status',
              'enum_width' => 'auto',
              'dropdown_width' => 'auto',
              'dropdown_class' => 'select2-menu-only',
              'container_class' => 'select2-menu-only',
            ),
          ),
        ),
        1 => 
        array (
          'name' => 'panel_body',
          'fields' => 
          array (
            0 => 
            array (
              'name' => 'duration',
              'type' => 'duration',
              'label' => 'LBL_START_AND_END_DATE_DETAIL_VIEW',
              'dismiss_label' => true,
              'inline' => true,
              'show_child_labels' => true,
              'fields' => 
              array (
                0 => 
                array (
                  'name' => 'date_start',
                  'time' => 
                  array (
                    'disable_text_input' => true,
                    'step' => 15,
                  ),
                  'readonly' => false,
                ),
                1 => 
                array (
                  'type' => 'label',
                  'default_value' => 'LBL_START_AND_END_DATE_TO',
                ),
                2 => 
                array (
                  'name' => 'date_end',
                  'time' => 
                  array (
                    'disable_text_input' => true,
                    'step' => 15,
                    'duration' => 
                    array (
                      'relative_to' => 'date_start',
                    ),
                  ),
                  'readonly' => false,
                ),
              ),
              'span' => 9,
              'related_fields' => 
              array (
                0 => 'duration_hours',
                1 => 'duration_minutes',
              ),
            ),
            1 => 
            array (
              'name' => 'repeat_type',
              'span' => 3,
              'related_fields' => 
              array (
                0 => 'repeat_parent_id',
              ),
            ),
            2 => 'direction',
            3 => 
            array (
              'name' => 'description',
              'span' => 12,
              'rows' => 3,
            ),
            4 => 'parent_name',
            5 => 
            array (
              'name' => 'invitees',
              'type' => 'participants',
              'label' => 'LBL_INVITEES',
              'span' => 12,
              'fields' => 
              array (
                0 => 'name',
                1 => 'accept_status_calls',
                2 => 'picture',
              ),
            ),
            6 => 'assigned_user_name',
            7 => 'team_name',
          ),
        ),
        2 => 
        array (
          'name' => 'panel_hidden',
          'hide' => true,
          'fields' => 
          array (
            0 => 
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
          ),
        ),
      ),
    ),
  ),
  'record' => 
  array (
    'meta' => 
    array (
      'buttons' => 
      array (
        0 => 
        array (
          'type' => 'button',
          'name' => 'cancel_button',
          'label' => 'LBL_CANCEL_BUTTON_LABEL',
          'css_class' => 'btn-invisible btn-link',
          'showOn' => 'edit',
        ),
        1 => 
        array (
          'type' => 'actiondropdown',
          'name' => 'save_dropdown',
          'primary' => true,
          'switch_on_click' => true,
          'showOn' => 'edit',
          'buttons' => 
          array (
            0 => 
            array (
              'type' => 'rowaction',
              'event' => 'button:save_button:click',
              'name' => 'save_button',
              'label' => 'LBL_SAVE_BUTTON_LABEL',
              'css_class' => 'btn btn-primary',
              'acl_action' => 'edit',
            ),
            1 => 
            array (
              'type' => 'save-and-send-invites-button',
              'event' => 'button:save_button:click',
              'name' => 'save_invite_button',
              'label' => 'LBL_SAVE_AND_SEND_INVITES_BUTTON',
              'acl_action' => 'edit',
            ),
          ),
        ),
        2 => 
        array (
          'type' => 'actiondropdown',
          'name' => 'main_dropdown',
          'primary' => true,
          'showOn' => 'view',
          'buttons' => 
          array (
            0 => 
            array (
              'type' => 'rowaction',
              'event' => 'button:edit_button:click',
              'name' => 'edit_button',
              'label' => 'LBL_EDIT_BUTTON_LABEL',
              'acl_action' => 'edit',
            ),
            1 => 
            array (
              'type' => 'editrecurrencesbutton',
              'event' => 'button:edit_recurrence_button:click',
              'name' => 'edit_recurrence_button',
              'label' => 'LBL_EDIT_ALL_RECURRENCES',
              'acl_action' => 'edit',
            ),
            2 => 
            array (
              'type' => 'shareaction',
              'name' => 'share',
              'label' => 'LBL_RECORD_SHARE_BUTTON',
              'acl_action' => 'view',
            ),
            3 => 
            array (
              'type' => 'pdfaction',
              'name' => 'download-pdf',
              'label' => 'LBL_PDF_VIEW',
              'action' => 'download',
              'acl_action' => 'view',
            ),
            4 => 
            array (
              'type' => 'pdfaction',
              'name' => 'email-pdf',
              'label' => 'LBL_PDF_EMAIL',
              'action' => 'email',
              'acl_action' => 'view',
            ),
            5 => 
            array (
              'type' => 'divider',
            ),
            6 => 
            array (
              'type' => 'rowaction',
              'event' => 'button:duplicate_button:click',
              'name' => 'duplicate_button',
              'label' => 'LBL_DUPLICATE_BUTTON_LABEL',
              'acl_module' => 'Calls',
              'acl_action' => 'create',
            ),
            7 => 
            array (
              'type' => 'divider',
            ),
            8 => 
            array (
              'type' => 'rowaction',
              'event' => 'button:delete_button:click',
              'name' => 'delete_button',
              'label' => 'LBL_DELETE_BUTTON_LABEL',
              'acl_action' => 'delete',
            ),
            9 => 
            array (
              'type' => 'deleterecurrencesbutton',
              'name' => 'delete_recurrence_button',
              'label' => 'LBL_REMOVE_ALL_RECURRENCES',
              'acl_action' => 'delete',
            ),
            10 => 
            array (
              'type' => 'closebutton',
              'name' => 'record-close-new',
              'label' => 'LBL_CLOSE_AND_CREATE_BUTTON_LABEL',
              'closed_status' => 'Held',
              'acl_action' => 'edit',
            ),
            11 => 
            array (
              'type' => 'closebutton',
              'name' => 'record-close',
              'label' => 'LBL_CLOSE_BUTTON_LABEL',
              'closed_status' => 'Held',
              'acl_action' => 'edit',
            ),
          ),
        ),
        3 => 
        array (
          'name' => 'sidebar_toggle',
          'type' => 'sidebartoggle',
        ),
      ),
      'panels' => 
      array (
        0 => 
        array (
          'name' => 'panel_header',
          'header' => true,
          'fields' => 
          array (
            0 => 
            array (
              'name' => 'picture',
              'type' => 'avatar',
              'size' => 'large',
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
            4 => 
            array (
              'name' => 'status',
              'type' => 'event-status',
              'enum_width' => 'auto',
              'dropdown_width' => 'auto',
              'dropdown_class' => 'select2-menu-only',
              'container_class' => 'select2-menu-only',
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
            0 => 
            array (
              'name' => 'duration',
              'type' => 'duration',
              'label' => 'LBL_START_AND_END_DATE_DETAIL_VIEW',
              'dismiss_label' => true,
              'inline' => true,
              'show_child_labels' => true,
              'fields' => 
              array (
                0 => 
                array (
                  'name' => 'date_start',
                  'time' => 
                  array (
                    'disable_text_input' => true,
                    'step' => 15,
                  ),
                  'readonly' => false,
                ),
                1 => 
                array (
                  'type' => 'label',
                  'default_value' => 'LBL_START_AND_END_DATE_TO',
                ),
                2 => 
                array (
                  'name' => 'date_end',
                  'time' => 
                  array (
                    'disable_text_input' => true,
                    'step' => 15,
                    'duration' => 
                    array (
                      'relative_to' => 'date_start',
                    ),
                  ),
                  'readonly' => false,
                ),
              ),
              'span' => 9,
              'related_fields' => 
              array (
                0 => 'duration_hours',
                1 => 'duration_minutes',
              ),
            ),
            1 => 
            array (
              'name' => 'repeat_type',
              'span' => 3,
              'related_fields' => 
              array (
                0 => 'repeat_parent_id',
              ),
            ),
            2 => 
            array (
              'name' => 'recurrence',
              'type' => 'recurrence',
              'span' => 12,
              'inline' => true,
              'show_child_labels' => true,
              'fields' => 
              array (
                0 => 
                array (
                  'label' => 'LBL_CALENDAR_REPEAT_INTERVAL',
                  'name' => 'repeat_interval',
                  'type' => 'enum',
                  'options' => 'repeat_interval_number',
                  'required' => true,
                ),
                1 => 
                array (
                  'label' => 'LBL_CALENDAR_REPEAT_DOW',
                  'name' => 'repeat_dow',
                  'type' => 'repeat-dow',
                  'options' => 'dom_cal_day_of_week',
                  'isMultiSelect' => true,
                ),
                2 => 
                array (
                  'label' => 'LBL_CALENDAR_REPEAT_UNTIL_DATE',
                  'name' => 'repeat_until',
                  'type' => 'repeat-until',
                ),
                3 => 
                array (
                  'type' => 'label',
                  'default_value' => 'LBL_LOWER_OR',
                ),
                4 => 
                array (
                  'label' => 'LBL_CALENDAR_REPEAT_COUNT',
                  'name' => 'repeat_count',
                  'type' => 'repeat-count',
                ),
              ),
            ),
            3 => 'direction',
            4 => 
            array (
              'name' => 'reminders',
              'type' => 'fieldset',
              'inline' => true,
              'equal_spacing' => true,
              'show_child_labels' => true,
              'fields' => 
              array (
                0 => 'reminder_time',
                1 => 'email_reminder_time',
              ),
            ),
            5 => 
            array (
              'name' => 'description',
              'span' => 12,
              'rows' => 3,
            ),
            6 => 'parent_name',
            7 => 
            array (
              'name' => 'invitees',
              'type' => 'participants',
              'label' => 'LBL_INVITEES',
              'span' => 12,
              'fields' => 
              array (
                0 => 'name',
                1 => 'accept_status_calls',
                2 => 'picture',
              ),
            ),
            8 => 'assigned_user_name',
            9 => 'team_name',
          ),
        ),
        2 => 
        array (
          'name' => 'panel_hidden',
          'label' => 'LBL_RECORD_SHOWMORE',
          'columns' => 2,
          'hide' => true,
          'labelsOnTop' => true,
          'placeholders' => true,
          'fields' => 
          array (
            0 => 
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
({
    extendsFrom: \'RecordView\',

    /**
     * @inheritdoc
     */
    initialize: function(options) {
        this.plugins = _.union(this.plugins || [], [\'EditAllRecurrences\', \'AddAsInvitee\']);
        this._super(\'initialize\', [options]);
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
          'name' => 'panel_header',
          'label' => 'LBL_PANEL_1',
          'fields' => 
          array (
            0 => 
            array (
              'label' => 'LBL_LIST_SUBJECT',
              'enabled' => true,
              'default' => true,
              'link' => true,
              'name' => 'name',
            ),
            1 => 
            array (
              'label' => 'LBL_STATUS',
              'enabled' => true,
              'default' => true,
              'name' => 'status',
              'type' => 'event-status',
              'css_class' => 'full-width',
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
              'label' => 'LBL_LIST_DATE',
              'enabled' => true,
              'default' => true,
              'name' => 'date_start',
            ),
            4 => 
            array (
              'label' => 'LBL_DATE_END',
              'enabled' => true,
              'default' => false,
              'name' => 'date_end',
            ),
            5 => 
            array (
              'name' => 'assigned_user_name',
              'target_record_key' => 'assigned_user_id',
              'target_module' => 'Employees',
              'label' => 'LBL_LIST_ASSIGNED_TO_NAME',
              'enabled' => true,
              'default' => false,
              'sortable' => false,
            ),
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
          'name' => 'panel_header',
          'label' => 'LBL_PANEL_1',
          'fields' => 
          array (
            0 => 
            array (
              'label' => 'LBL_LIST_SUBJECT',
              'enabled' => true,
              'default' => true,
              'link' => true,
              'name' => 'name',
              'related_fields' => 
              array (
                0 => 'repeat_type',
              ),
            ),
            1 => 
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
            2 => 
            array (
              'name' => 'date_start',
              'label' => 'LBL_LIST_DATE',
              'type' => 'datetimecombo-colorcoded',
              'completed_status_value' => 'Held',
              'enabled' => true,
              'default' => true,
              'readonly' => true,
              'related_fields' => 
              array (
                0 => 'status',
              ),
            ),
            3 => 
            array (
              'name' => 'date_end',
              'link' => false,
              'default' => false,
              'enabled' => true,
            ),
            4 => 
            array (
              'enabled' => true,
              'default' => true,
              'name' => 'status',
              'type' => 'event-status',
              'css_class' => 'full-width',
            ),
            5 => 
            array (
              'enabled' => true,
              'default' => true,
              'name' => 'direction',
            ),
            6 => 
            array (
              'name' => 'assigned_user_name',
              'target_record_key' => 'assigned_user_id',
              'target_module' => 'Employees',
              'label' => 'LBL_LIST_ASSIGNED_USER',
              'enabled' => true,
              'default' => true,
              'sortable' => true,
            ),
            7 => 
            array (
              'name' => 'date_entered',
              'enabled' => true,
              'default' => true,
              'readonly' => true,
            ),
          ),
        ),
      ),
    ),
  ),
  'create' => 
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
    extendsFrom: \'CreateView\',

    /**
     * @inheritdoc
     */
    initialize: function(options) {
        this.plugins = _.union(this.plugins || [], [\'AddAsInvitee\']);
        this._super(\'initialize\', [options]);
    }
})
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
              'link' => true,
              'name' => 'name',
            ),
            1 => 
            array (
              'label' => 'LBL_STATUS',
              'enabled' => true,
              'default' => true,
              'name' => 'status',
              'type' => 'event-status',
              'css_class' => 'full-width',
            ),
            2 => 
            array (
              'label' => 'LBL_LIST_DATE',
              'enabled' => true,
              'default' => true,
              'name' => 'date_start',
              'readonly' => true,
            ),
            3 => 
            array (
              'label' => 'LBL_DATE_END',
              'enabled' => true,
              'default' => true,
              'name' => 'date_end',
            ),
            4 => 
            array (
              'name' => 'assigned_user_name',
              'target_record_key' => 'assigned_user_id',
              'target_module' => 'Employees',
              'label' => 'LBL_LIST_ASSIGNED_TO_NAME',
              'enabled' => true,
              'default' => true,
              'sortable' => false,
            ),
          ),
        ),
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
            'allow_bwc' => false,
          ),
          1 => 
          array (
            'type' => 'rowaction',
            'name' => 'edit_button',
            'icon' => 'fa-pencil',
            'label' => 'LBL_EDIT_BUTTON',
            'event' => 'list:editrow:fire',
            'acl_action' => 'edit',
            'allow_bwc' => true,
          ),
          2 => 
          array (
            'type' => 'unlink-action',
            'icon' => 'fa-chain-broken',
            'label' => 'LBL_UNLINK_BUTTON',
          ),
          3 => 
          array (
            'type' => 'closebutton',
            'icon' => 'fa-times-circle',
            'name' => 'record-close',
            'label' => 'LBL_CLOSE_BUTTON_TITLE',
            'closed_status' => 'Held',
            'acl_action' => 'edit',
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
              'link' => true,
              'name' => 'name',
            ),
            1 => 
            array (
              'label' => 'LBL_STATUS',
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
              'label' => 'LBL_LIST_DATE',
              'enabled' => true,
              'default' => true,
              'name' => 'date_start',
            ),
            4 => 
            array (
              'label' => 'LBL_DATE_END',
              'enabled' => true,
              'default' => false,
              'name' => 'date_end',
            ),
            5 => 
            array (
              'name' => 'assigned_user_name',
              'target_record_key' => 'assigned_user_id',
              'target_module' => 'Employees',
              'label' => 'LBL_LIST_ASSIGNED_TO_NAME',
              'enabled' => true,
              'default' => false,
              'sortable' => false,
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
 * @class View.Views.Base.Calls.ResolveConflictsListView
 * @alias SUGAR.App.view.views.BaseCallsResolveConflictsListView
 * @extends View.Views.Base.ResolveConflictsListView
 */
({
    extendsFrom: \'ResolveConflictsListView\',

    /**
     * @inheritdoc
     *
     * The invitees field should not be displayed on list views. It is removed
     * before comparing models so that it doesn\'t get included.
     */
    _buildFieldDefinitions: function(modelToSave, modelInDb) {
        modelToSave.unset(\'invitees\');
        this._super(\'_buildFieldDefinitions\', [modelToSave, modelInDb]);
    }
})
',
    ),
  ),
  'create-actions' => 
  array (
    'meta' => 
    array (
      'template' => 'record',
      'buttons' => 
      array (
        0 => 
        array (
          'name' => 'cancel_button',
          'type' => 'button',
          'label' => 'LBL_CANCEL_BUTTON_LABEL',
          'css_class' => 'btn-invisible btn-link',
          'events' => 
          array (
            'click' => 'button:cancel_button:click',
          ),
        ),
        1 => 
        array (
          'name' => 'restore_button',
          'type' => 'button',
          'label' => 'LBL_RESTORE',
          'css_class' => 'btn-invisible btn-link',
          'showOn' => 'select',
          'events' => 
          array (
            'click' => 'button:restore_button:click',
          ),
        ),
        2 => 
        array (
          'type' => 'actiondropdown',
          'name' => 'main_dropdown',
          'primary' => true,
          'switch_on_click' => true,
          'showOn' => 'create',
          'buttons' => 
          array (
            0 => 
            array (
              'type' => 'rowaction',
              'name' => 'save_button',
              'label' => 'LBL_SAVE_BUTTON_LABEL',
              'events' => 
              array (
                'click' => 'button:save_button:click',
              ),
            ),
            1 => 
            array (
              'type' => 'save-and-send-invites-button',
              'name' => 'save_invite_button',
              'label' => 'LBL_SAVE_AND_SEND_INVITES_BUTTON',
              'events' => 
              array (
                'click' => 'button:save_button:click',
              ),
            ),
            2 => 
            array (
              'type' => 'rowaction',
              'name' => 'save_view_button',
              'label' => 'LBL_SAVE_AND_VIEW',
              'events' => 
              array (
                'click' => 'button:save_view_button:click',
              ),
            ),
            3 => 
            array (
              'type' => 'rowaction',
              'name' => 'save_create_button',
              'label' => 'LBL_SAVE_AND_CREATE_ANOTHER',
              'events' => 
              array (
                'click' => 'button:save_create_button:click',
              ),
            ),
          ),
        ),
        3 => 
        array (
          'type' => 'actiondropdown',
          'name' => 'duplicate_dropdown',
          'primary' => true,
          'showOn' => 'duplicate',
          'buttons' => 
          array (
            0 => 
            array (
              'type' => 'rowaction',
              'name' => 'save_button',
              'label' => 'LBL_IGNORE_DUPLICATE_AND_SAVE',
              'events' => 
              array (
                'click' => 'button:save_button:click',
              ),
            ),
          ),
        ),
        4 => 
        array (
          'type' => 'actiondropdown',
          'name' => 'select_dropdown',
          'primary' => true,
          'showOn' => 'select',
          'buttons' => 
          array (
            0 => 
            array (
              'type' => 'rowaction',
              'name' => 'save_button',
              'label' => 'LBL_SAVE_BUTTON_LABEL',
              'events' => 
              array (
                'click' => 'button:save_button:click',
              ),
            ),
          ),
        ),
        5 => 
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
({
    extendsFrom: \'CreateActionsView\',

    /**
     * @inheritdoc
     */
    initialize: function(options) {
        this.plugins = _.union(this.plugins || [], [\'AddAsInvitee\']);
        this._super(\'initialize\', [options]);
    }
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
              'link' => true,
              'name' => 'name',
            ),
            1 => 
            array (
              'label' => 'LBL_STATUS',
              'enabled' => true,
              'default' => true,
              'name' => 'status',
            ),
            2 => 
            array (
              'target_record_key' => 'contact_id',
              'target_module' => 'Contacts',
              'label' => 'LBL_LIST_CONTACT',
              'link' => true,
              'enabled' => true,
              'default' => true,
              'name' => 'contact_name',
              'related_fields' => 
              array (
                0 => 'contact_id',
              ),
            ),
            3 => 
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
            4 => 
            array (
              'label' => 'LBL_LIST_DATE',
              'enabled' => true,
              'default' => false,
              'name' => 'date_start',
            ),
            5 => 
            array (
              'label' => 'LBL_DATE_END',
              'enabled' => true,
              'default' => false,
              'name' => 'date_end',
            ),
            6 => 
            array (
              'name' => 'assigned_user_name',
              'target_record_key' => 'assigned_user_id',
              'target_module' => 'Employees',
              'label' => 'LBL_LIST_ASSIGNED_TO_NAME',
              'enabled' => true,
              'default' => false,
              'sortable' => false,
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
  '_hash' => '0c995cebce0dfdb3819051a4d56634c3',
);

