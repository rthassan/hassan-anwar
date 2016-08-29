<?php
$clientCache['ProductTemplates']['base']['view'] = array (
  'selection-list' => 
  array (
    'meta' => 
    array (
      'favorites' => false,
      'panels' => 
      array (
        0 => 
        array (
          'name' => 'panel_header',
          'fields' => 
          array (
            0 => 
            array (
              'name' => 'name',
              'link' => true,
              'enabled' => true,
              'default' => true,
            ),
            1 => 
            array (
              'name' => 'type_name',
              'enabled' => true,
              'default' => true,
            ),
            2 => 
            array (
              'name' => 'category_name',
              'enabled' => true,
              'default' => true,
            ),
            3 => 
            array (
              'name' => 'status',
              'enabled' => true,
              'default' => true,
            ),
            4 => 
            array (
              'name' => 'qty_in_stock',
              'enabled' => true,
              'default' => false,
            ),
            5 => 
            array (
              'name' => 'cost_price',
              'type' => 'currency',
              'related_fields' => 
              array (
                0 => 'cost_usdollar',
                1 => 'currency_id',
                2 => 'base_rate',
              ),
              'currency_field' => 'currency_id',
              'base_rate_field' => 'base_rate',
              'enabled' => true,
              'default' => false,
            ),
            6 => 
            array (
              'name' => 'list_price',
              'type' => 'currency',
              'related_fields' => 
              array (
                0 => 'list_usdollar',
                1 => 'currency_id',
                2 => 'base_rate',
              ),
              'currency_field' => 'currency_id',
              'base_rate_field' => 'base_rate',
              'enabled' => true,
              'default' => false,
            ),
            7 => 
            array (
              'name' => 'discount_price',
              'type' => 'currency',
              'related_fields' => 
              array (
                0 => 'discount_usdollar',
                1 => 'currency_id',
                2 => 'base_rate',
              ),
              'currency_field' => 'currency_id',
              'base_rate_field' => 'base_rate',
              'enabled' => true,
              'default' => false,
            ),
          ),
        ),
      ),
      'dependencies' => 
      array (
        0 => 
        array (
          'name' => 'cost_usdollar',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'cost_price',
            1 => 'cost_price',
            2 => 'base_rate',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'cost_usdollar',
                'value' => 'ifElse(isNumeric($cost_price), currencyDivide($cost_price, $base_rate), "")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        1 => 
        array (
          'name' => 'discount_usdollar',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'discount_price',
            1 => 'discount_price',
            2 => 'base_rate',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'discount_usdollar',
                'value' => 'ifElse(isNumeric($discount_price), currencyDivide($discount_price, $base_rate), "")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        2 => 
        array (
          'name' => 'list_usdollar',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'list_price',
            1 => 'list_price',
            2 => 'base_rate',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'list_usdollar',
                'value' => 'ifElse(isNumeric($list_price), currencyDivide($list_price, $base_rate), "")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        3 => 
        array (
          'name' => 'readOnlycost_usdollar',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'cost_price',
            1 => 'cost_price',
            2 => 'base_rate',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'cost_usdollar',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        4 => 
        array (
          'name' => 'readOnlydiscount_usdollar',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'discount_price',
            1 => 'discount_price',
            2 => 'base_rate',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'discount_usdollar',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        5 => 
        array (
          'name' => 'readOnlylist_usdollar',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'list_price',
            1 => 'list_price',
            2 => 'base_rate',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'list_usdollar',
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
              'name' => 'name',
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
            0 => 'status',
            1 => 
            array (
              'name' => 'website',
              'type' => 'url',
            ),
            2 => 'date_available',
            3 => 'tax_class',
            4 => 'qty_in_stock',
            5 => 'category_name',
            6 => 'manufacturer_name',
            7 => 'mft_part_num',
            8 => 'vendor_part_num',
            9 => 'weight',
            10 => 'type_name',
            11 => 
            array (
              'name' => 'cost_price',
              'type' => 'currency',
              'related_fields' => 
              array (
                0 => 'cost_usdollar',
                1 => 'currency_id',
                2 => 'base_rate',
              ),
              'currency_field' => 'currency_id',
              'base_rate_field' => 'base_rate',
              'enabled' => true,
              'default' => true,
            ),
            12 => 'cost_usdollar',
            13 => 'date_cost_price',
            14 => 
            array (
              'name' => 'discount_price',
              'type' => 'currency',
              'related_fields' => 
              array (
                0 => 'discount_usdollar',
                1 => 'currency_id',
                2 => 'base_rate',
              ),
              'currency_field' => 'currency_id',
              'base_rate_field' => 'base_rate',
              'enabled' => true,
              'default' => true,
            ),
            15 => 'discount_usdollar',
            16 => 
            array (
              'name' => 'list_price',
              'type' => 'currency',
              'related_fields' => 
              array (
                0 => 'list_usdollar',
                1 => 'currency_id',
                2 => 'base_rate',
              ),
              'currency_field' => 'currency_id',
              'base_rate_field' => 'base_rate',
              'enabled' => true,
              'default' => true,
            ),
            17 => 'list_usdollar',
            18 => 
            array (
              'name' => 'pricing_formula',
              'related_fields' => 
              array (
                0 => 'pricing_factor',
              ),
            ),
            19 => 
            array (
              'name' => 'description',
              'span' => 12,
            ),
            20 => 'support_name',
            21 => 'support_description',
            22 => 'support_contact',
            23 => 'support_term',
          ),
        ),
      ),
      'dependencies' => 
      array (
        0 => 
        array (
          'name' => 'cost_usdollar',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'cost_price',
            1 => 'cost_price',
            2 => 'base_rate',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'cost_usdollar',
                'value' => 'ifElse(isNumeric($cost_price), currencyDivide($cost_price, $base_rate), "")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        1 => 
        array (
          'name' => 'discount_usdollar',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'discount_price',
            1 => 'discount_price',
            2 => 'base_rate',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'discount_usdollar',
                'value' => 'ifElse(isNumeric($discount_price), currencyDivide($discount_price, $base_rate), "")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        2 => 
        array (
          'name' => 'list_usdollar',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'list_price',
            1 => 'list_price',
            2 => 'base_rate',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'list_usdollar',
                'value' => 'ifElse(isNumeric($list_price), currencyDivide($list_price, $base_rate), "")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        3 => 
        array (
          'name' => 'readOnlycost_usdollar',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'cost_price',
            1 => 'cost_price',
            2 => 'base_rate',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'cost_usdollar',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        4 => 
        array (
          'name' => 'readOnlydiscount_usdollar',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'discount_price',
            1 => 'discount_price',
            2 => 'base_rate',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'discount_usdollar',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        5 => 
        array (
          'name' => 'readOnlylist_usdollar',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'list_price',
            1 => 'list_price',
            2 => 'base_rate',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'list_usdollar',
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
      'favorites' => false,
      'panels' => 
      array (
        0 => 
        array (
          'name' => 'panel_header',
          'fields' => 
          array (
            0 => 
            array (
              'name' => 'name',
              'link' => true,
              'enabled' => true,
              'default' => true,
            ),
            1 => 
            array (
              'name' => 'type_name',
              'enabled' => true,
              'default' => true,
            ),
            2 => 
            array (
              'name' => 'category_name',
              'enabled' => true,
              'default' => true,
            ),
            3 => 
            array (
              'name' => 'status',
              'enabled' => true,
              'default' => true,
            ),
            4 => 
            array (
              'name' => 'qty_in_stock',
              'enabled' => true,
              'default' => true,
            ),
            5 => 
            array (
              'name' => 'cost_price',
              'type' => 'currency',
              'related_fields' => 
              array (
                0 => 'cost_usdollar',
                1 => 'currency_id',
                2 => 'base_rate',
              ),
              'currency_field' => 'currency_id',
              'base_rate_field' => 'base_rate',
              'enabled' => true,
              'default' => true,
            ),
            6 => 
            array (
              'name' => 'list_price',
              'type' => 'currency',
              'related_fields' => 
              array (
                0 => 'list_usdollar',
                1 => 'currency_id',
                2 => 'base_rate',
              ),
              'currency_field' => 'currency_id',
              'base_rate_field' => 'base_rate',
              'enabled' => true,
              'default' => true,
            ),
            7 => 
            array (
              'name' => 'discount_price',
              'type' => 'currency',
              'related_fields' => 
              array (
                0 => 'discount_usdollar',
                1 => 'currency_id',
                2 => 'base_rate',
              ),
              'currency_field' => 'currency_id',
              'base_rate_field' => 'base_rate',
              'enabled' => true,
              'default' => true,
            ),
          ),
        ),
      ),
      'dependencies' => 
      array (
        0 => 
        array (
          'name' => 'cost_usdollar',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'cost_price',
            1 => 'cost_price',
            2 => 'base_rate',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'cost_usdollar',
                'value' => 'ifElse(isNumeric($cost_price), currencyDivide($cost_price, $base_rate), "")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        1 => 
        array (
          'name' => 'discount_usdollar',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'discount_price',
            1 => 'discount_price',
            2 => 'base_rate',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'discount_usdollar',
                'value' => 'ifElse(isNumeric($discount_price), currencyDivide($discount_price, $base_rate), "")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        2 => 
        array (
          'name' => 'list_usdollar',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'list_price',
            1 => 'list_price',
            2 => 'base_rate',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'list_usdollar',
                'value' => 'ifElse(isNumeric($list_price), currencyDivide($list_price, $base_rate), "")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        3 => 
        array (
          'name' => 'readOnlycost_usdollar',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'cost_price',
            1 => 'cost_price',
            2 => 'base_rate',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'cost_usdollar',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        4 => 
        array (
          'name' => 'readOnlydiscount_usdollar',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'discount_price',
            1 => 'discount_price',
            2 => 'base_rate',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'discount_usdollar',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        5 => 
        array (
          'name' => 'readOnlylist_usdollar',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'list_price',
            1 => 'list_price',
            2 => 'base_rate',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'list_usdollar',
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
      'favorites' => false,
      'panels' => 
      array (
        0 => 
        array (
          'name' => 'panel_header',
          'fields' => 
          array (
            0 => 
            array (
              'name' => 'name',
              'link' => true,
              'enabled' => true,
              'default' => true,
            ),
            1 => 
            array (
              'name' => 'type_name',
              'enabled' => true,
              'default' => true,
            ),
            2 => 
            array (
              'name' => 'category_name',
              'enabled' => true,
              'default' => true,
            ),
            3 => 
            array (
              'name' => 'status',
              'enabled' => true,
              'default' => true,
            ),
            4 => 
            array (
              'name' => 'qty_in_stock',
              'enabled' => true,
              'default' => false,
            ),
            5 => 
            array (
              'name' => 'cost_price',
              'type' => 'currency',
              'related_fields' => 
              array (
                0 => 'cost_usdollar',
                1 => 'currency_id',
                2 => 'base_rate',
              ),
              'currency_field' => 'currency_id',
              'base_rate_field' => 'base_rate',
              'enabled' => true,
              'default' => false,
            ),
            6 => 
            array (
              'name' => 'list_price',
              'type' => 'currency',
              'related_fields' => 
              array (
                0 => 'list_usdollar',
                1 => 'currency_id',
                2 => 'base_rate',
              ),
              'currency_field' => 'currency_id',
              'base_rate_field' => 'base_rate',
              'enabled' => true,
              'default' => false,
            ),
            7 => 
            array (
              'name' => 'discount_price',
              'type' => 'currency',
              'related_fields' => 
              array (
                0 => 'discount_usdollar',
                1 => 'currency_id',
                2 => 'base_rate',
              ),
              'currency_field' => 'currency_id',
              'base_rate_field' => 'base_rate',
              'enabled' => true,
              'default' => false,
            ),
          ),
        ),
      ),
      'dependencies' => 
      array (
        0 => 
        array (
          'name' => 'cost_usdollar',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'cost_price',
            1 => 'cost_price',
            2 => 'base_rate',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'cost_usdollar',
                'value' => 'ifElse(isNumeric($cost_price), currencyDivide($cost_price, $base_rate), "")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        1 => 
        array (
          'name' => 'discount_usdollar',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'discount_price',
            1 => 'discount_price',
            2 => 'base_rate',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'discount_usdollar',
                'value' => 'ifElse(isNumeric($discount_price), currencyDivide($discount_price, $base_rate), "")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        2 => 
        array (
          'name' => 'list_usdollar',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'list_price',
            1 => 'list_price',
            2 => 'base_rate',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'list_usdollar',
                'value' => 'ifElse(isNumeric($list_price), currencyDivide($list_price, $base_rate), "")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        3 => 
        array (
          'name' => 'readOnlycost_usdollar',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'cost_price',
            1 => 'cost_price',
            2 => 'base_rate',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'cost_usdollar',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        4 => 
        array (
          'name' => 'readOnlydiscount_usdollar',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'discount_price',
            1 => 'discount_price',
            2 => 'base_rate',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'discount_usdollar',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        5 => 
        array (
          'name' => 'readOnlylist_usdollar',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'list_price',
            1 => 'list_price',
            2 => 'base_rate',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'list_usdollar',
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
  'resolve-conflicts-list' => 
  array (
    'meta' => 
    array (
      'favorites' => false,
      'panels' => 
      array (
        0 => 
        array (
          'name' => 'panel_header',
          'fields' => 
          array (
            0 => 
            array (
              'name' => 'name',
              'link' => true,
              'enabled' => true,
              'default' => true,
            ),
            1 => 
            array (
              'name' => 'type_name',
              'enabled' => true,
              'default' => true,
            ),
            2 => 
            array (
              'name' => 'category_name',
              'enabled' => true,
              'default' => true,
            ),
            3 => 
            array (
              'name' => 'status',
              'enabled' => true,
              'default' => true,
            ),
            4 => 
            array (
              'name' => 'qty_in_stock',
              'enabled' => true,
              'default' => false,
            ),
            5 => 
            array (
              'name' => 'cost_price',
              'type' => 'currency',
              'related_fields' => 
              array (
                0 => 'cost_usdollar',
                1 => 'currency_id',
                2 => 'base_rate',
              ),
              'currency_field' => 'currency_id',
              'base_rate_field' => 'base_rate',
              'enabled' => true,
              'default' => false,
            ),
            6 => 
            array (
              'name' => 'list_price',
              'type' => 'currency',
              'related_fields' => 
              array (
                0 => 'list_usdollar',
                1 => 'currency_id',
                2 => 'base_rate',
              ),
              'currency_field' => 'currency_id',
              'base_rate_field' => 'base_rate',
              'enabled' => true,
              'default' => false,
            ),
            7 => 
            array (
              'name' => 'discount_price',
              'type' => 'currency',
              'related_fields' => 
              array (
                0 => 'discount_usdollar',
                1 => 'currency_id',
                2 => 'base_rate',
              ),
              'currency_field' => 'currency_id',
              'base_rate_field' => 'base_rate',
              'enabled' => true,
              'default' => false,
            ),
          ),
        ),
      ),
      'dependencies' => 
      array (
        0 => 
        array (
          'name' => 'cost_usdollar',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'cost_price',
            1 => 'cost_price',
            2 => 'base_rate',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'cost_usdollar',
                'value' => 'ifElse(isNumeric($cost_price), currencyDivide($cost_price, $base_rate), "")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        1 => 
        array (
          'name' => 'discount_usdollar',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'discount_price',
            1 => 'discount_price',
            2 => 'base_rate',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'discount_usdollar',
                'value' => 'ifElse(isNumeric($discount_price), currencyDivide($discount_price, $base_rate), "")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        2 => 
        array (
          'name' => 'list_usdollar',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'list_price',
            1 => 'list_price',
            2 => 'base_rate',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'list_usdollar',
                'value' => 'ifElse(isNumeric($list_price), currencyDivide($list_price, $base_rate), "")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        3 => 
        array (
          'name' => 'readOnlycost_usdollar',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'cost_price',
            1 => 'cost_price',
            2 => 'base_rate',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'cost_usdollar',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        4 => 
        array (
          'name' => 'readOnlydiscount_usdollar',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'discount_price',
            1 => 'discount_price',
            2 => 'base_rate',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'discount_usdollar',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        5 => 
        array (
          'name' => 'readOnlylist_usdollar',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'list_price',
            1 => 'list_price',
            2 => 'base_rate',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'list_usdollar',
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
          'name' => 'cost_usdollar',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'cost_price',
            1 => 'cost_price',
            2 => 'base_rate',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'cost_usdollar',
                'value' => 'ifElse(isNumeric($cost_price), currencyDivide($cost_price, $base_rate), "")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        1 => 
        array (
          'name' => 'discount_usdollar',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'discount_price',
            1 => 'discount_price',
            2 => 'base_rate',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'discount_usdollar',
                'value' => 'ifElse(isNumeric($discount_price), currencyDivide($discount_price, $base_rate), "")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        2 => 
        array (
          'name' => 'list_usdollar',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'list_price',
            1 => 'list_price',
            2 => 'base_rate',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'list_usdollar',
                'value' => 'ifElse(isNumeric($list_price), currencyDivide($list_price, $base_rate), "")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        3 => 
        array (
          'name' => 'readOnlycost_usdollar',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'cost_price',
            1 => 'cost_price',
            2 => 'base_rate',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'cost_usdollar',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        4 => 
        array (
          'name' => 'readOnlydiscount_usdollar',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'discount_price',
            1 => 'discount_price',
            2 => 'base_rate',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'discount_usdollar',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        5 => 
        array (
          'name' => 'readOnlylist_usdollar',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'list_price',
            1 => 'list_price',
            2 => 'base_rate',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'list_usdollar',
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
          'name' => 'cost_usdollar',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'cost_price',
            1 => 'cost_price',
            2 => 'base_rate',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'cost_usdollar',
                'value' => 'ifElse(isNumeric($cost_price), currencyDivide($cost_price, $base_rate), "")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        1 => 
        array (
          'name' => 'discount_usdollar',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'discount_price',
            1 => 'discount_price',
            2 => 'base_rate',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'discount_usdollar',
                'value' => 'ifElse(isNumeric($discount_price), currencyDivide($discount_price, $base_rate), "")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        2 => 
        array (
          'name' => 'list_usdollar',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'list_price',
            1 => 'list_price',
            2 => 'base_rate',
          ),
          'onload' => false,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'SetValue',
              'params' => 
              array (
                'target' => 'list_usdollar',
                'value' => 'ifElse(isNumeric($list_price), currencyDivide($list_price, $base_rate), "")',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        3 => 
        array (
          'name' => 'readOnlycost_usdollar',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'cost_price',
            1 => 'cost_price',
            2 => 'base_rate',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'cost_usdollar',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        4 => 
        array (
          'name' => 'readOnlydiscount_usdollar',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'discount_price',
            1 => 'discount_price',
            2 => 'base_rate',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'discount_usdollar',
                'value' => 'true',
              ),
            ),
          ),
          'notActions' => 
          array (
          ),
        ),
        5 => 
        array (
          'name' => 'readOnlylist_usdollar',
          'hooks' => 
          array (
            0 => 'all',
          ),
          'trigger' => 'true',
          'triggerFields' => 
          array (
            0 => 'list_price',
            1 => 'list_price',
            2 => 'base_rate',
          ),
          'onload' => true,
          'actions' => 
          array (
            0 => 
            array (
              'action' => 'ReadOnly',
              'params' => 
              array (
                'target' => 'list_usdollar',
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
  '_hash' => 'f814924aed3b51cd833ead0cc951291b',
);

