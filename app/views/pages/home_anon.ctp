<?php $this->viewVars['title_for_layout'] = 'Repositorium'; ?>

<div class="yui-g">
<!--	<div class="yui-u first">
		<h1 class="getstarted">Get Started</h1>
		<div class="padded">
			<span>Welcome to Repositorium</span>
		</div>			
	</div> -->
	<div class="bordered">
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