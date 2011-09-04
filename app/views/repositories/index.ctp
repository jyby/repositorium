<?php $r = $repository['Repository']; ?>
<script type="text/javascript">
	$(document).ready(function() {
		$("#repo-watch").click(function(e) {
			e.preventDefault();
			$(window.location).attr('href', '<?php echo $this->Html->url(array('controller' => 'repositories', 'action' => 'watch', $r['id']));?>');
		});	
		$("#repo-search").click(function(e) {
			e.preventDefault();
			$(window.location).attr('href', '<?php echo $this->Html->url(array('controller' => 'tags', 'action' => 'index'));?>');
		});	
	});	
</script>

<h1 class="h1icon"><?php echo ucwords($r['name']) . ' Repository'; ?></h1>

<div id="expert-tools">
	<div class="adm-mass">
		<?php
		if(!is_null($watching)) :
			if($watching)
				$msg = 'Remove from watchlist';
			else
				$msg = 'Add to watchlist';
			echo $this->Form->button($msg, array('id' => 'repo-watch'));
		endif;
		echo '&nbsp;&nbsp;&nbsp;';			
		echo $this->Form->button('Search a Document', array('id' => 'repo-search'));
		?>
	</div>
</div>


<p style="padding: 1em;">  <?php echo str_replace('\n', '<br />', Sanitize::html(ucfirst($r['description']))); ?> </p>

