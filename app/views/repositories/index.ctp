<?php $r = $repository['Repository']; ?>
<script type="text/javascript">
	$(document).ready(function() {
		$("#repo-watch").click(function(e) {
			e.preventDefault();
			$(window.location).attr('href', '<?php echo $this->Html->url(array('controller' => 'repositories', 'action' => 'watch', $r['id']));?>');
		});	
	});	
</script>

<h1 class="h1icon"><?php echo ucwords($r['name']) . ' Repository'; ?></h1>

<?php if(!is_null($watching)) : ?>
<div id="expert-tools">
	<div class="adm-mass">
		<?php
			if($watching)
				$msg = 'Remove from watchlist';
			else
				$msg = 'Add to watchlist';
				
			echo '&nbsp;&nbsp;&nbsp;';			
			echo $this->Form->button($msg, array('id' => 'repo-watch'));
		?>
	</div>
</div>
<?php endif; ?>


<p style="padding: 1em;">  <?php echo str_replace('\n', '<br />', Sanitize::html(ucfirst($r['description']))); ?> </p>

