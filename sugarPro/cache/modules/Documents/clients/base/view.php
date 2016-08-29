<?php
$clientCache['Documents']['base']['view'] = array (
  'record' => 
  array (
    'meta' => 
    array (
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
            1 => 
            array (
              'name' => 'filename',
              'displayParams' => 
              array (
                'link' => 'filename',
                'id' => 'document_revision_id',
              ),
              'readonly' => true,
              'span' => 12,
              'label' => '',
            ),
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
          'labelsOnTop' => true,
          'placeholders' => true,
          'fields' => 
          array (
            0 => 'document_name',
            1 => 'status',
            2 => 'revision',
            3 => 'template_type',
            4 => 'is_template',
            5 => 'active_date',
            6 => 'category_id',
            7 => 'exp_date',
            8 => 'subcategory_id',
            9 => 'description',
            10 => 'related_doc_name',
            11 => 'related_doc_rev_number',
            12 => 'assigned_user_name',
            13 => 'team_name',
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
            0 => 'last_rev_created_name',
            1 => 'last_rev_create_date',
          ),
        ),
      ),
    ),
  ),
  'subpanel-for-contracttype' => 
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
              'name' => 'document_name',
              'label' => 'LBL_LIST_DOCUMENT_NAME',
              'enabled' => true,
              'default' => true,
              'link' => true,
            ),
            1 => 
            array (
              'name' => 'is_template',
              'label' => 'LBL_LIST_IS_TEMPLATE',
              'enabled' => true,
              'default' => true,
            ),
            2 => 
            array (
              'name' => 'template_type',
              'label' => 'LBL_LIST_TEMPLATE_TYPE',
              'enabled' => true,
              'default' => true,
            ),
            3 => 
            array (
              'name' => 'latest_revision',
              'label' => 'LBL_LATEST_REVISION',
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
          'label' => 'LBL_PANEL_1',
          'fields' => 
          array (
            0 => 
            array (
              'name' => 'document_name',
              'label' => 'LBL_LIST_DOCUMENT_NAME',
              'enabled' => true,
              'default' => true,
              'link' => true,
              'type' => 'name',
            ),
            1 => 
            array (
              'name' => 'filename',
              'label' => 'LBL_LIST_FILENAME',
              'enabled' => true,
              'default' => true,
            ),
            2 => 
            array (
              'name' => 'category_id',
              'label' => 'LBL_LIST_CATEGORY',
              'enabled' => true,
              'default' => true,
            ),
            3 => 
            array (
              'name' => 'doc_type',
              'label' => 'LBL_LIST_DOC_TYPE',
              'enabled' => true,
              'default' => true,
            ),
            4 => 
            array (
              'name' => 'status_id',
              'label' => 'LBL_LIST_STATUS',
              'enabled' => true,
              'default' => false,
            ),
            5 => 
            array (
              'name' => 'active_date',
              'label' => 'LBL_LIST_ACTIVE_DATE',
              'enabled' => true,
              'default' => false,
            ),
          ),
        ),
      ),
    ),
  ),
  'modulelist' => 
  array (
    'templates' => 
    array (
      'favorites' => '
{{#each models}}
    <li>
        <a tabindex="-1" class="favoriteLink actionLink" href="#{{buildRoute model=this}}" data-route="#{{buildRoute model=this}}">
            <i class="fa fa-favorite active"></i>{{getFieldValue this "document_name"}}
        </a>
    </li>
{{/each}}
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
          'label' => 'LBL_PANEL_1',
          'fields' => 
          array (
            0 => 
            array (
              'name' => 'document_name',
              'label' => 'LBL_LIST_DOCUMENT_NAME',
              'enabled' => true,
              'default' => true,
              'link' => true,
              'type' => 'name',
            ),
            1 => 
            array (
              'name' => 'filename',
              'label' => 'LBL_LIST_FILENAME',
              'enabled' => true,
              'default' => true,
            ),
            2 => 
            array (
              'name' => 'category_id',
              'label' => 'LBL_LIST_CATEGORY',
              'enabled' => true,
              'default' => true,
            ),
            3 => 
            array (
              'name' => 'doc_type',
              'label' => 'LBL_LIST_DOC_TYPE',
              'enabled' => true,
              'default' => true,
            ),
            4 => 
            array (
              'name' => 'status_id',
              'label' => 'LBL_LIST_STATUS',
              'enabled' => true,
              'default' => true,
            ),
            5 => 
            array (
              'name' => 'active_date',
              'label' => 'LBL_LIST_ACTIVE_DATE',
              'enabled' => true,
              'default' => true,
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
              'name' => 'document_name',
              'label' => 'LBL_LIST_DOCUMENT_NAME',
              'enabled' => true,
              'default' => true,
              'link' => true,
            ),
            1 => 
            array (
              'name' => 'filename',
              'label' => 'LBL_LIST_FILENAME',
              'enabled' => true,
              'default' => true,
              'readonly' => true,
            ),
            2 => 
            array (
              'name' => 'category_id',
              'label' => 'LBL_LIST_CATEGORY',
              'enabled' => true,
              'default' => true,
            ),
            3 => 
            array (
              'name' => 'doc_type',
              'label' => 'LBL_LIST_DOC_TYPE',
              'enabled' => true,
              'default' => true,
              'readonly' => true,
            ),
            4 => 
            array (
              'name' => 'status_id',
              'label' => 'LBL_LIST_STATUS',
              'enabled' => true,
              'default' => true,
            ),
            5 => 
            array (
              'name' => 'active_date',
              'label' => 'LBL_LIST_ACTIVE_DATE',
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
          0 => 
          array (
            'type' => 'rowaction',
            'name' => 'edit_button',
            'icon' => 'fa-pencil',
            'label' => 'LBL_EDIT_BUTTON',
            'event' => 'list:editrow:fire',
            'acl_action' => 'edit',
            'allow_bwc' => true,
          ),
          1 => 
          array (
            'type' => 'unlink-action',
            'icon' => 'fa-chain-broken',
            'label' => 'LBL_UNLINK_BUTTON',
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
              'name' => 'document_name',
              'label' => 'LBL_LIST_DOCUMENT_NAME',
              'enabled' => true,
              'default' => true,
              'link' => true,
              'type' => 'name',
            ),
            1 => 
            array (
              'name' => 'filename',
              'label' => 'LBL_LIST_FILENAME',
              'enabled' => true,
              'default' => true,
            ),
            2 => 
            array (
              'name' => 'category_id',
              'label' => 'LBL_LIST_CATEGORY',
              'enabled' => true,
              'default' => true,
            ),
            3 => 
            array (
              'name' => 'doc_type',
              'label' => 'LBL_LIST_DOC_TYPE',
              'enabled' => true,
              'default' => true,
            ),
            4 => 
            array (
              'name' => 'status_id',
              'label' => 'LBL_LIST_STATUS',
              'enabled' => true,
              'default' => false,
            ),
            5 => 
            array (
              'name' => 'active_date',
              'label' => 'LBL_LIST_ACTIVE_DATE',
              'enabled' => true,
              'default' => false,
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
          'label' => 'LBL_PANEL_1',
          'fields' => 
          array (
            0 => 
            array (
              'name' => 'document_name',
              'label' => 'LBL_LIST_DOCUMENT_NAME',
              'enabled' => true,
              'default' => true,
              'link' => true,
              'type' => 'name',
            ),
            1 => 
            array (
              'name' => 'filename',
              'label' => 'LBL_LIST_FILENAME',
              'enabled' => true,
              'default' => true,
            ),
            2 => 
            array (
              'name' => 'category_id',
              'label' => 'LBL_LIST_CATEGORY',
              'enabled' => true,
              'default' => true,
            ),
            3 => 
            array (
              'name' => 'doc_type',
              'label' => 'LBL_LIST_DOC_TYPE',
              'enabled' => true,
              'default' => true,
            ),
            4 => 
            array (
              'name' => 'status_id',
              'label' => 'LBL_LIST_STATUS',
              'enabled' => true,
              'default' => false,
            ),
            5 => 
            array (
              'name' => 'active_date',
              'label' => 'LBL_LIST_ACTIVE_DATE',
              'enabled' => true,
              'default' => false,
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
  '_hash' => '2b9521ec640c90c18efb94d435eac865',
);

