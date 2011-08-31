<?php $this->viewVars['title_for_layout'] = 'Repositorium'; ?>

<div class="yui-g"> 
	<div class="yui-u first"> 
		
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

<div class="yui-g">
    <div class="yui-g first">
        <div class="yui-u first">
			<strong>Your Repositories</strong>
	    </div>
        <div class="yui-u">
			<strong>Repositories you're a collaborator</strong>
	    </div>
    </div>
    <div class="yui-g">
        <div class="yui-u first">
			<strong>Repositories you used recently</strong>
	    </div>
        <div class="yui-u">
			<strong>Featured repositories</strong>
	    </div>
    </div>
</div>