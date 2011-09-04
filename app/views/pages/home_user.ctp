<?php $this->viewVars['title_for_layout'] = 'Repositorium'; ?>

<div class="yui-g">
    <div class="yui-g first">
        <div class="yui-u first">
			<strong>Your Repositories</strong>
			<ul>
				<?php foreach($your_repos as $r) { ?>
				<li><?php echo $this->Repo->link($r['Repository']['name'], $r['Repository']['url']); ?></li>
				<?php } ?>
			</ul> 
	    </div>
        <div class="yui-u">
			<strong>Repositories you're a collaborator</strong>
			<ul>
				<?php foreach($collaborator_repos as $r) { ?>
				<li><?php echo $this->Repo->link($r['Repository']['name'], $r['Repository']['url']); ?></li>
				<?php } ?>
			</ul>			
	    </div>
    </div>
    <div class="yui-g">
        <div class="yui-u first">
			<strong>Repositories in your watchlist</strong>
			<ul>
				<?php foreach($watched_repos as $r) { ?>
				<li><?php echo $this->Repo->link($r['Repository']['name'], $r['Repository']['url']); ?></li>
				<?php } ?>
			</ul>
	    </div>
        <div class="yui-u">
			<strong>Latest repositories</strong>
			<ul>
				<?php foreach($latest_repos as $r) { ?>
				<li><?php echo $this->Repo->link($r['Repository']['name'], $r['Repository']['url']); ?></li>
				<?php } ?>
			</ul>
	    </div>
    </div>
</div>