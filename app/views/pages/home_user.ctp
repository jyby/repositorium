<?php $this->viewVars['title_for_layout'] = 'Repositorium'; ?>

<div class="yui-g">
    <div class="yui-g first">
        <div class="yui-u first">
        	<div class="padded">
				<strong class="mini-header">Your created Repositories</strong>
				<?php if(count($your_repos) > 0): ?>
				<ul>
					<?php foreach($your_repos as $r) { ?>
					<li><?php echo $this->Repo->link($r['Repository']['name'], $r['Repository']['url']); ?></li>
					<?php } ?>
				</ul>
				<?php else: ?>
				<div style="text-align: center; font-style: italic; color: #777;"><span>There aren't repositories here</span></div>
				<?php endif; ?>
			</div> 
	    </div>
        <div class="yui-u">
        	<div class="padded">
				<strong class="mini-header">Repositories you're a collaborator</strong>
				<?php if(count($collaborator_repos) > 0): ?>
				<ul>
					<?php foreach($collaborator_repos as $r) { ?>
					<li><?php echo $this->Repo->link($r['Repository']['name'], $r['Repository']['url']); ?></li>
					<?php } ?>
				</ul>
				<?php else: ?>
				<div style="text-align: center; font-style: italic; color: #777;"><span>There aren't repositories here</span></div>
				<?php endif; ?>
			</div>			
	    </div>
    </div>
    <div class="yui-g">
        <div class="yui-u first">
        	<div class="padded">
				<strong class="mini-header">Repositories in your watchlist</strong>
				<?php if(count($watched_repos) > 0): ?>
				<ul>
					<?php foreach($watched_repos as $r) { ?>
					<li><?php echo $this->Repo->link($r['Repository']['name'], $r['Repository']['url']); ?></li>
					<?php } ?>
				</ul>
				<?php else: ?>
				<div style="text-align: center; font-style: italic; color: #777;"><span>There aren't repositories here</span></div>
				<?php endif; ?>
			</div>
	    </div>
        <div class="yui-u">
	        <div class="padded">
				<strong class="mini-header">Newest repositories</strong>
				<?php if(count($latest_repos) > 0): ?>
				<ul>
					<?php foreach($latest_repos as $r) { ?>
					<li><?php echo $this->Repo->link($r['Repository']['name'], $r['Repository']['url']); ?></li>
					<?php } ?>
				</ul>
				<?php else: ?>
				<div style="text-align: center; font-style: italic; color: #777;"><span>There aren't repositories here</span></div>
				<?php endif; ?>
			</div>
	    </div>
    </div>
</div>