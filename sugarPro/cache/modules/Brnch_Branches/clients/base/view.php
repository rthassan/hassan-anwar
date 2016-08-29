<?php
$clientCache['Brnch_Branches']['base']['view'] = array (
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
            0 => 'website',
            1 => 'phone_office',
            2 => 'employees',
            3 => 'phone_alternate',
            4 => 'email',
            5 => 'phone_fax',
            6 => 
            array (
              'name' => 'billing_address',
              'type' => 'fieldset',
              'css_class' => 'address',
              'label' => 'LBL_BILLING_ADDRESS',
              'fields' => 
              array (
                0 => 
                array (
                  'name' => 'billing_address_street',
                  'css_class' => 'address_street',
                  'placeholder' => 'LBL_BILLING_ADDRESS_STREET',
                ),
                1 => 
                array (
                  'name' => 'billing_address_city',
                  'css_class' => 'address_city',
                  'placeholder' => 'LBL_BILLING_ADDRESS_CITY',
                ),
                2 => 
                array (
                  'name' => 'billing_address_state',
                  'css_class' => 'address_state',
                  'placeholder' => 'LBL_BILLING_ADDRESS_STATE',
                ),
                3 => 
                array (
                  'name' => 'billing_address_postalcode',
                  'css_class' => 'address_zip',
                  'placeholder' => 'LBL_BILLING_ADDRESS_POSTALCODE',
                ),
                4 => 
                array (
                  'name' => 'billing_address_country',
                  'css_class' => 'address_country',
                  'placeholder' => 'LBL_BILLING_ADDRESS_COUNTRY',
                ),
              ),
            ),
            7 => 
            array (
              'name' => 'shipping_address',
              'type' => 'fieldset',
              'css_class' => 'address',
              'label' => 'LBL_SHIPPING_ADDRESS',
              'fields' => 
              array (
                0 => 
                array (
                  'name' => 'shipping_address_street',
                  'css_class' => 'address_street',
                  'placeholder' => 'LBL_SHIPPING_ADDRESS_STREET',
                ),
                1 => 
                array (
                  'name' => 'shipping_address_city',
                  'css_class' => 'address_city',
                  'placeholder' => 'LBL_SHIPPING_ADDRESS_CITY',
                ),
                2 => 
                array (
                  'name' => 'shipping_address_state',
                  'css_class' => 'address_state',
                  'placeholder' => 'LBL_SHIPPING_ADDRESS_STATE',
                ),
                3 => 
                array (
                  'name' => 'shipping_address_postalcode',
                  'css_class' => 'address_zip',
                  'placeholder' => 'LBL_SHIPPING_ADDRESS_POSTALCODE',
                ),
                4 => 
                array (
                  'name' => 'shipping_address_country',
                  'css_class' => 'address_country',
                  'placeholder' => 'LBL_SHIPPING_ADDRESS_COUNTRY',
                ),
                5 => 
                array (
                  'name' => 'copy',
                  'label' => 'NTC_COPY_BILLING_ADDRESS',
                  'type' => 'copy',
                  'mapping' => 
                  array (
                    'billing_address_street' => 'shipping_address_street',
                    'billing_address_city' => 'shipping_address_city',
                    'billing_address_state' => 'shipping_address_state',
                    'billing_address_postalcode' => 'shipping_address_postalcode',
                    'billing_address_country' => 'shipping_address_country',
                  ),
                ),
              ),
            ),
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
            0 => 'twitter',
            1 => 
            array (
              'name' => 'description',
              'span' => 12,
            ),
            2 => 'brnch_branches_type',
            3 => 'industry',
            4 => 'annual_revenue',
            5 => 'ticker_symbol',
            6 => 'ownership',
            7 => 'rating',
            8 => 'assigned_user_name',
            9 => 
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
            10 => 'team_name',
            11 => 
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
  'twitter' => 
  array (
    'meta' => 
    array (
      'dashlets' => 
      array (
        0 => 
        array (
          'name' => 'LBL_TWITTER_NAME',
          'description' => 'LBL_TWITTER_DESCRIPTION',
          'config' => 
          array (
            'limit' => '20',
          ),
          'preview' => 
          array (
            'title' => 'LBL_TWITTER_MY_ACCOUNT',
            'twitter' => 'sugarcrm',
            'limit' => '3',
          ),
        ),
      ),
      'config' => 
      array (
        'fields' => 
        array (
          0 => 
          array (
            'name' => 'limit',
            'label' => 'LBL_TWITTER_DISPLAY_ROWS',
            'type' => 'enum',
            'options' => 
            array (
              5 => 5,
              10 => 10,
              15 => 15,
              20 => 20,
              50 => 50,
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
          'label' => 'LBL_PANEL_DEFAULT',
          'fields' => 
          array (
            0 => 
            array (
              'name' => 'name',
              'label' => 'LBL_ACCOUNT_NAME',
              'link' => true,
              'default' => true,
              'enabled' => true,
            ),
            1 => 
            array (
              'name' => 'billing_address_city',
              'label' => 'LBL_CITY',
              'default' => true,
              'enabled' => true,
            ),
            2 => 
            array (
              'name' => 'phone_office',
              'label' => 'LBL_PHONE',
              'default' => true,
              'enabled' => true,
            ),
            3 => 
            array (
              'name' => 'brnch_branches_type',
              'label' => 'LBL_TYPE',
              'default' => false,
              'enabled' => true,
            ),
            4 => 
            array (
              'name' => 'industry',
              'label' => 'LBL_INDUSTRY',
              'default' => false,
              'enabled' => true,
            ),
            5 => 
            array (
              'name' => 'annual_revenue',
              'label' => 'LBL_ANNUAL_REVENUE',
              'default' => false,
              'enabled' => true,
            ),
            6 => 
            array (
              'name' => 'phone_fax',
              'label' => 'LBL_PHONE_FAX',
              'default' => false,
              'enabled' => true,
            ),
            7 => 
            array (
              'name' => 'billing_address_street',
              'label' => 'LBL_BILLING_ADDRESS_STREET',
              'default' => false,
              'enabled' => true,
            ),
            8 => 
            array (
              'name' => 'billing_address_state',
              'label' => 'LBL_BILLING_ADDRESS_STATE',
              'default' => false,
              'enabled' => true,
            ),
            9 => 
            array (
              'name' => 'billing_address_postalcode',
              'label' => 'LBL_BILLING_ADDRESS_POSTALCODE',
              'default' => false,
              'enabled' => true,
            ),
            10 => 
            array (
              'name' => 'billing_address_country',
              'label' => 'LBL_BILLING_ADDRESS_COUNTRY',
              'default' => false,
              'enabled' => true,
            ),
            11 => 
            array (
              'name' => 'shipping_address_street',
              'label' => 'LBL_SHIPPING_ADDRESS_STREET',
              'default' => false,
              'enabled' => true,
            ),
            12 => 
            array (
              'name' => 'shipping_address_city',
              'label' => 'LBL_SHIPPING_ADDRESS_CITY',
              'default' => false,
              'enabled' => true,
            ),
            13 => 
            array (
              'name' => 'shipping_address_state',
              'label' => 'LBL_SHIPPING_ADDRESS_STATE',
              'default' => false,
              'enabled' => true,
            ),
            14 => 
            array (
              'name' => 'shipping_address_postalcode',
              'label' => 'LBL_SHIPPING_ADDRESS_POSTALCODE',
              'default' => false,
              'enabled' => true,
            ),
            15 => 
            array (
              'name' => 'shipping_address_country',
              'label' => 'LBL_SHIPPING_ADDRESS_COUNTRY',
              'default' => false,
              'enabled' => true,
            ),
            16 => 
            array (
              'name' => 'phone_alternate',
              'label' => 'LBL_PHONE_ALT',
              'default' => false,
              'enabled' => true,
            ),
            17 => 
            array (
              'name' => 'website',
              'label' => 'LBL_WEBSITE',
              'default' => false,
              'enabled' => true,
            ),
            18 => 
            array (
              'name' => 'ownership',
              'label' => 'LBL_OWNERSHIP',
              'default' => false,
              'enabled' => true,
            ),
            19 => 
            array (
              'name' => 'employees',
              'label' => 'LBL_EMPLOYEES',
              'default' => false,
              'enabled' => true,
            ),
            20 => 
            array (
              'name' => 'ticker_symbol',
              'label' => 'LBL_TICKER_SYMBOL',
              'default' => false,
              'enabled' => true,
            ),
            21 => 
            array (
              'name' => 'email1',
              'label' => 'LBL_EMAIL_ADDRESS',
              'link' => true,
              'default' => true,
              'enabled' => true,
            ),
            22 => 
            array (
              'name' => 'team_name',
              'label' => 'LBL_TEAM',
              'default' => true,
              'enabled' => true,
            ),
            23 => 
            array (
              'name' => 'assigned_user_name',
              'label' => 'LBL_ASSIGNED_TO_NAME',
              'default' => true,
              'enabled' => true,
            ),
            24 => 
            array (
              'name' => 'date_modified',
              'enabled' => true,
              'default' => true,
            ),
            25 => 
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
            ),
            1 => 
            array (
              'label' => 'LBL_INDUSTRY',
              'enabled' => true,
              'default' => true,
              'name' => 'industry',
            ),
            2 => 
            array (
              'label' => 'LBL_PHONE_OFFICE',
              'enabled' => true,
              'default' => true,
              'name' => 'phone_office',
            ),
            3 => 
            array (
              'name' => 'assigned_user_name',
              'target_record_key' => 'assigned_user_id',
              'target_module' => 'Employees',
              'label' => 'LBL_ASSIGNED_USER',
              'enabled' => true,
              'default' => true,
            ),
          ),
        ),
      ),
    ),
  ),
  '_hash' => 'e391e315904ed9647ead0db10a1af562',
);

