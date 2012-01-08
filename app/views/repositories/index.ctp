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
		// echo $this->Form->button('Search a Document', array('id' => 'repo-search'));
		?>
	</div>
</div>
<div class="yui-u padded">
	<h1 class="getstarted"><?php echo ucwords($r['name']) . ' Repository'; ?></h1>
	<span class="gray" style="padding-bottom: 1em; display: block">About:</span>
	<p><?php echo str_replace("\n", '<br />', Sanitize::html(ucfirst($r['description']))); ?> </p>
	<div class="padded">
		<ul>
			<li><span class="gray">Creator:</span> <?php echo $creator['User']['first_name'] . ' ' . $creator['User']['last_name']; ?></li>
			<li><span class="gray">Documents:</span> <?php echo $documents; ?></li>
			<li><span class="gray">Quality criteria:</span> <?php echo $criterias; ?></li>
			<li><span class="gray">Different tags:</span> <?php echo $tags; ?></li>			
		</ul>
	</div>	
	<script src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/js/swfobject.js" type="text/javascript"></script>
	<div id="tagCloudId" style="text-align: center;">Your browser does not support Flash or Javascript!</div>
	<p>
	<script type="text/javascript">
		var so = new SWFObject("http://<?php echo $_SERVER['HTTP_HOST']; ?>/swf/tagcloud.swf", "tagcloud", "750", "400", "9", "#ffffff");
		so.addVariable("mode", "tags");
		so.addVariable("tcolor", "0x333333");
		so.addVariable("tcolor2", "0x009900");
		so.addVariable("hicolor", "0xff0000");
		so.addVariable("tspeed", "100");
		so.addVariable("distr", "true");
		so.addVariable("tagcloud", "<?php echo $cloud_data; ?>");
		so.write("tagCloudId");
	</script>
	</p>
</div>
