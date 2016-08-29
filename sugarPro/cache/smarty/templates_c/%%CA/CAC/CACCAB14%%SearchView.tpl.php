<?php /* Smarty version 2.6.11, created on 2016-08-26 06:31:59
         compiled from include/SugarFields/Fields/Enum/SearchView.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'include/SugarFields/Fields/Enum/SearchView.tpl', 13, false),array('function', 'sugarvar', 'include/SugarFields/Fields/Enum/SearchView.tpl', 14, false),)), $this); ?>
{*
/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
*}
<?php ob_start();  echo ((is_array($_tmp=@$this->_tpl_vars['displayParams']['size'])) ? $this->_run_mod_handler('default', true, $_tmp, 6) : smarty_modifier_default($_tmp, 6));  $this->_smarty_vars['capture']['display_size'] = ob_get_contents();  $this->assign('size', ob_get_contents());ob_end_clean(); ?>
{html_options id='<?php echo $this->_tpl_vars['vardef']['name']; ?>
' name='<?php echo $this->_tpl_vars['vardef']['name']; ?>
[]' options=<?php echo smarty_function_sugarvar(array('key' => 'options','string' => true), $this);?>
 size="<?php echo $this->_tpl_vars['size']; ?>
" style="width: 150px" <?php if ($this->_tpl_vars['size'] > 1): ?>multiple="1"<?php endif; ?> selected=<?php echo smarty_function_sugarvar(array('key' => 'value','string' => true), $this);?>
}