<p style="padding-left: 420px; text-align: right;">{$smarty.now|date_format:"%e %B %Y"}</p>
<p><span style="font-size: medium; color: #ff6600;"><strong>School Information:&nbsp;</strong></span></p>
<table style="height: 101px; width: 883px;" border="0">
<tbody>
<tr>
<td><span style="font-size: small;">School Name</span></td>
<td><span style="font-size: small;">{$fields.name}</span></td>
</tr>
<tr>
<td><span style="font-size: small;">City</span></td>
<td><span style="font-size: small;">{$fields.city}</span></td>
</tr>
<tr>
<td><span style="font-size: small;">Country</span></td>
<td><span style="font-size: small;">{$fields.country}</span></td>
</tr>
<tr>
<td><span style="font-size: small;">Principal Name&nbsp;</span></td>
<td><span style="font-size: small;">{$fields.principal_c}&nbsp;</span></td>
</tr>
<tr>
<td><span style="font-size: small;">Assigned User</span></td>
<td><span style="font-size: small;">{$fields.assigned_user_link.first_name}</span></td>
</tr>
</tbody>
</table>
<p>&nbsp;</p>
<p><span style="font-size: small;"><strong>Staff Members:</strong></span></p>
<p><span style="font-size: small;">{foreach from=$staffs item=foo}</span></p>
<p><span style="font-size: small;">Role: {$foo.name}</span></p>
<p><span style="font-size: small;">{/foreach}</span></p>
<p>&nbsp;</p>
<p><span style="font-size: small;"><strong>Students:</strong></span></p>
<p><span style="font-size: small;">{foreach from=$students item=student}</span></p>
<p><span style="font-size: small;">Name: {$student.first_name} {$student.last_name}</span></p>
<p><span style="font-size: small;">{/foreach}</span></p>
<pre class="lang-php prettyprint prettyprinted"><span style="font-size: small;"><code><span style="font-size: small;">&nbsp;</span></code></span></pre>
<pre class="lang-php prettyprint prettyprinted"><code><span style="font-size: small;"><span style="font-size: small;">&nbsp;</span></span></code></pre>
<p><span style="font-size: small;">Thats all folks!&nbsp;</span></p>