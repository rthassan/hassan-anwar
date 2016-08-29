<?php
$clientCache['Notes']['base']['view'] = array (
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
          'type' => 'rowaction',
          'event' => 'button:save_button:click',
          'name' => 'save_button',
          'label' => 'LBL_SAVE_BUTTON_LABEL',
          'css_class' => 'btn btn-primary',
          'showOn' => 'edit',
          'acl_action' => 'edit',
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
              'type' => 'shareaction',
              'name' => 'share',
              'label' => 'LBL_RECORD_SHARE_BUTTON',
              'acl_action' => 'view',
            ),
            2 => 
            array (
              'type' => 'pdfaction',
              'name' => 'download-pdf',
              'label' => 'LBL_PDF_VIEW',
              'action' => 'download',
              'acl_action' => 'view',
            ),
            3 => 
            array (
              'type' => 'pdfaction',
              'name' => 'email-pdf',
              'label' => 'LBL_PDF_EMAIL',
              'action' => 'email',
              'acl_action' => 'view',
            ),
            4 => 
            array (
              'type' => 'divider',
            ),
            5 => 
            array (
              'type' => 'rowaction',
              'event' => 'button:duplicate_button:click',
              'name' => 'duplicate_button',
              'label' => 'LBL_DUPLICATE_BUTTON_LABEL',
              'acl_action' => 'create',
            ),
            6 => 
            array (
              'type' => 'rowaction',
              'event' => 'button:audit_button:click',
              'name' => 'audit_button',
              'label' => 'LNK_VIEW_CHANGE_LOG',
              'acl_action' => 'view',
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
          'labels' => true,
          'labelsOnTop' => true,
          'placeholders' => true,
          'fields' => 
          array (
            0 => 'contact_name',
            1 => 'parent_name',
            2 => 
            array (
              'name' => 'description',
              'rows' => 5,
            ),
            3 => 'team_name',
            4 => 
            array (
              'name' => 'filename',
              'related_fields' => 
              array (
                0 => 'file_mime_type',
              ),
            ),
            5 => 'assigned_user_name',
          ),
        ),
        2 => 
        array (
          'name' => 'panel_hidden',
          'label' => 'LBL_RECORD_SHOWMORE',
          'hide' => true,
          'columns' => 2,
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
            2 => 'portal_flag',
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
              'name' => 'name',
              'label' => 'LBL_LIST_SUBJECT',
              'link' => true,
              'enabled' => true,
              'default' => true,
            ),
            1 => 
            array (
              'name' => 'contact_name',
              'label' => 'LBL_LIST_CONTACT',
              'link' => true,
              'id' => 'CONTACT_ID',
              'module' => 'Contacts',
              'enabled' => true,
              'default' => true,
              'ACLTag' => 'CONTACT',
              'related_fields' => 
              array (
                0 => 'contact_id',
              ),
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
              'name' => 'filename',
              'label' => 'LBL_LIST_FILENAME',
              'enabled' => true,
              'default' => true,
              'type' => 'file',
              'related_fields' => 
              array (
                0 => 'file_url',
                1 => 'id',
                2 => 'file_mime_type',
              ),
              'displayParams' => 
              array (
                'module' => 'Notes',
              ),
            ),
            4 => 
            array (
              'name' => 'created_by_name',
              'type' => 'relate',
              'label' => 'LBL_CREATED_BY',
              'enabled' => true,
              'default' => false,
              'related_fields' => 
              array (
                0 => 'created_by',
              ),
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
              'name' => 'name',
              'label' => 'LBL_LIST_SUBJECT',
              'link' => true,
              'enabled' => true,
              'default' => true,
            ),
            1 => 
            array (
              'name' => 'contact_name',
              'label' => 'LBL_LIST_CONTACT',
              'link' => true,
              'id' => 'CONTACT_ID',
              'module' => 'Contacts',
              'enabled' => true,
              'default' => true,
              'ACLTag' => 'CONTACT',
              'related_fields' => 
              array (
                0 => 'contact_id',
              ),
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
              'name' => 'filename',
              'label' => 'LBL_LIST_FILENAME',
              'enabled' => true,
              'default' => true,
              'type' => 'file',
              'related_fields' => 
              array (
                0 => 'file_url',
                1 => 'id',
                2 => 'file_mime_type',
              ),
              'displayParams' => 
              array (
                'module' => 'Notes',
              ),
            ),
            4 => 
            array (
              'name' => 'created_by_name',
              'type' => 'relate',
              'label' => 'LBL_CREATED_BY',
              'enabled' => true,
              'default' => true,
              'related_fields' => 
              array (
                0 => 'created_by',
              ),
            ),
            5 => 
            array (
              'name' => 'date_modified',
              'enabled' => true,
              'default' => true,
            ),
            6 => 
            array (
              'name' => 'date_entered',
              'enabled' => true,
              'default' => true,
            ),
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
          'name' => 'panel_header',
          'label' => 'LBL_PANEL_1',
          'fields' => 
          array (
            0 => 
            array (
              'name' => 'name',
              'label' => 'LBL_LIST_SUBJECT',
              'link' => true,
              'enabled' => true,
              'default' => true,
            ),
            1 => 
            array (
              'name' => 'contact_name',
              'label' => 'LBL_LIST_CONTACT',
              'link' => true,
              'id' => 'CONTACT_ID',
              'module' => 'Contacts',
              'enabled' => true,
              'default' => true,
              'ACLTag' => 'CONTACT',
              'related_fields' => 
              array (
                0 => 'contact_id',
              ),
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
              'name' => 'filename',
              'label' => 'LBL_LIST_FILENAME',
              'enabled' => true,
              'default' => true,
              'type' => 'file',
              'related_fields' => 
              array (
                0 => 'file_url',
                1 => 'id',
                2 => 'file_mime_type',
              ),
              'displayParams' => 
              array (
                'module' => 'Notes',
              ),
            ),
            4 => 
            array (
              'name' => 'created_by_name',
              'type' => 'relate',
              'label' => 'LBL_CREATED_BY',
              'enabled' => true,
              'default' => false,
              'related_fields' => 
              array (
                0 => 'created_by',
              ),
            ),
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
              'label' => 'LBL_LIST_SUBJECT',
              'enabled' => true,
              'default' => true,
              'name' => 'name',
              'link' => true,
            ),
            1 => 
            array (
              'label' => 'LBL_LIST_DATE_MODIFIED',
              'enabled' => true,
              'default' => true,
              'name' => 'date_modified',
            ),
            2 => 
            array (
              'label' => 'LBL_LIST_DATE_ENTERED',
              'enabled' => true,
              'default' => true,
              'name' => 'date_entered',
            ),
            3 => 
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
              'name' => 'name',
              'label' => 'LBL_LIST_SUBJECT',
              'link' => true,
              'enabled' => true,
              'default' => true,
            ),
            1 => 
            array (
              'name' => 'contact_name',
              'label' => 'LBL_LIST_CONTACT',
              'link' => true,
              'id' => 'CONTACT_ID',
              'module' => 'Contacts',
              'enabled' => true,
              'default' => true,
              'ACLTag' => 'CONTACT',
              'related_fields' => 
              array (
                0 => 'contact_id',
              ),
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
              'name' => 'filename',
              'label' => 'LBL_LIST_FILENAME',
              'enabled' => true,
              'default' => true,
              'type' => 'file',
              'related_fields' => 
              array (
                0 => 'file_url',
                1 => 'id',
                2 => 'file_mime_type',
              ),
              'displayParams' => 
              array (
                'module' => 'Notes',
              ),
            ),
            4 => 
            array (
              'name' => 'created_by_name',
              'type' => 'relate',
              'label' => 'LBL_CREATED_BY',
              'enabled' => true,
              'default' => false,
              'related_fields' => 
              array (
                0 => 'created_by',
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
  '_hash' => '0fbdb173bc325aa29aa99179572c403f',
);

