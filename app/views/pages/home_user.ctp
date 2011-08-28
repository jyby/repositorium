<?php $this->viewVars['title_for_layout'] = 'Repositorium'; ?>

Hay, user!

<div class="yui-g"> 
	<div class="yui-u first"> 
		<strong>Your Repositories</strong>
		<ul>
			<?php foreach($my as $r) { ?>
			<li><?php echo $this->Html->link($r['Repository']['name'], array('controller' => 'repositories', 'action' => 'index', $r['Repository']['url'])); ?></li>
			<?php } ?>
		</ul> 
	</div> 
	<div class="yui-u">
		<strong>Featured</strong>
	 	<ul>
	 		<?php foreach($feat as $r) { ?>
			<li><?php echo $this->Html->link($r['Repository']['name'], array('controller' => 'repositories', 'action' => 'index', $r['Repository']['url'])); ?></li>
			<?php } ?>
	 	</ul>
	</div> 
</div> 