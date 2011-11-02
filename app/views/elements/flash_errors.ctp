<?php 
	if(strcmp(gettype($message), "string") == 0):
?>
<div class="errormessage" style="margin-bottom:4px;">
	<div class="ui-widget" style="margin-bottom:2px;">
		<div class="ui-state-error ui-corner-all" style="padding: 4px .7em;">
			<p>
				<span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
				<strong>Error:</strong>
				<span><?php echo $message; ?></span>		
			</p>
		</div>
	</div>	
</div>
<?php		
	elseif(strcmp(gettype($message), "array") == 0):
?>
	<div class="errormessage" style="margin-bottom:4px;">	
		<div class="ui-widget" style="margin-bottom:2px;">
			<div class="ui-state-error ui-corner-all" style="padding: 4px .7em;"> 
				<p>
					<span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span> 
					<strong>Error:</strong>
					<ul>
					<?php foreach($message as $m=>$v) { ?>
						<li><?php echo $v; ?></li>
					<?php } ?>
					</ul> 					
				</p>
			</div>
		</div>	
	</div>
<?php 
	endif;
?>

