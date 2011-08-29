<?php $this->viewVars['title_for_layout'] = 'Repositorium'; ?>

Hay, user!

<div class="yui-g"> 
	<div class="yui-u first"> 
		<strong>Your Repositories</strong>
		<ul>
			<?php foreach($my as $r) { ?>
			<li><?php echo $this->Repo->link($r['Repository']['name'], $r['Repository']['url']); ?></li>
			<?php } ?>
		</ul> 
	</div> 
	<div class="yui-u">
		<strong>Featured</strong>
	 	<ul>
	 		<?php foreach($feat as $r) { ?>
			<li><?php echo $this->Repo->link($r['Repository']['name'], $r['Repository']['url']); ?></li>
			<?php } ?>
	 	</ul>
	</div> 
</div> 