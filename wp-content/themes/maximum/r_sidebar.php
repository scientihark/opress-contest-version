<div id="r_sidebar">
<div class="sidebar-row blue">
<h4>Join Our Email List:</h4>
<table id="emailform" border="0" cellspacing="0" cellpadding="0" align="right">
		  <tr>
			<td><input name="s" type="text"  id="emailsubscribe" value="enter email address" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;"			
			 size="15" /></td>
			<td><input type="submit"  class="awesome orange small email-go" value="go" /></td>		   
		  </tr>
</table>
<div class="small">
Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet...
</div>

</div><!--blue-->

<div class="sidebar-row green">
<h3>Tag Cloud:</h3>
<ul>
<?php $args = array('smallest'=> 6,'largest'=> 16);?>
<?php wp_tag_cloud($args);?>
</ul>
</div><!--sidebar-row-->
<div class="sidebar-row white">
<h3>Just a White Box</h3>
<p>The API will generate the necessary CSS specific to the user's browser so you can use the font on your page.</p>
</div><!--blue-->


<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Right Sidebar") ) : ?>
<?php endif; ?>


</div><!--r_sidebar-->