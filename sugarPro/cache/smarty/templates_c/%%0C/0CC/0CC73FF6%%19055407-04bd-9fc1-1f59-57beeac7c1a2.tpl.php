<?php /* Smarty version 2.6.11, created on 2016-08-26 07:25:00
         compiled from cache/modules/PdfManager/tpls/19055407-04bd-9fc1-1f59-57beeac7c1a2.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'cache/modules/PdfManager/tpls/19055407-04bd-9fc1-1f59-57beeac7c1a2.tpl', 1, false),)), $this); ?>
<p style="padding-left: 420px; text-align: right;"><?php echo ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, "%e %B %Y") : smarty_modifier_date_format($_tmp, "%e %B %Y")); ?>
</p>
<p><span style="font-size: medium; color: #ff6600;"><strong>School Information:&nbsp;</strong></span></p>
<table style="height: 101px; width: 883px;" border="0">
<tbody>
<tr>
<td><span style="font-size: small;">School Name</span></td>
<td><span style="font-size: small;"><?php echo $this->_tpl_vars['fields']['name']; ?>
</span></td>
</tr>
<tr>
<td><span style="font-size: small;">City</span></td>
<td><span style="font-size: small;"><?php echo $this->_tpl_vars['fields']['city']; ?>
</span></td>
</tr>
<tr>
<td><span style="font-size: small;">Country</span></td>
<td><span style="font-size: small;"><?php echo $this->_tpl_vars['fields']['country']; ?>
</span></td>
</tr>
<tr>
<td><span style="font-size: small;">Principal Name&nbsp;</span></td>
<td><span style="font-size: small;"><?php echo $this->_tpl_vars['fields']['principal_c']; ?>
&nbsp;</span></td>
</tr>
<tr>
<td><span style="font-size: small;">Assigned User</span></td>
<td><span style="font-size: small;"><?php echo $this->_tpl_vars['fields']['assigned_user_link']['first_name']; ?>
</span></td>
</tr>
</tbody>
</table>
<p>&nbsp;</p>
<p><span style="font-size: small;"><strong>Staff Members:</strong></span></p>
<p><span style="font-size: small;"><?php $_from = $this->_tpl_vars['staffs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['foo']):
?></span></p>
<p><span style="font-size: small;">Role: <?php echo $this->_tpl_vars['foo']['name']; ?>
</span></p>
<p><span style="font-size: small;"><?php endforeach; endif; unset($_from); ?></span></p>
<p>&nbsp;</p>
<p><span style="font-size: small;"><strong>Students:</strong></span></p>
<p><span style="font-size: small;"><?php $_from = $this->_tpl_vars['students']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['student']):
?></span></p>
<p><span style="font-size: small;">Name: <?php echo $this->_tpl_vars['student']['first_name']; ?>
 <?php echo $this->_tpl_vars['student']['last_name']; ?>
</span></p>
<p><span style="font-size: small;"><?php endforeach; endif; unset($_from); ?></span></p>
<pre class="lang-php prettyprint prettyprinted"><span style="font-size: small;"><code><span style="font-size: small;">&nbsp;</span></code></span></pre>
<pre class="lang-php prettyprint prettyprinted"><code><span style="font-size: small;"><span style="font-size: small;">&nbsp;</span></span></code></pre>
<p><span style="font-size: small;">Thats all folks!&nbsp;</span></p>