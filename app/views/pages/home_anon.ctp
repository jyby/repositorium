<?php $this->viewVars['title_for_layout'] = 'Repositorium'; ?>
Hay, anon!

<?php echo $this->Html->link('Create new Repository', array('controller' => 'repositories', 'action' => 'create')); ?>

<ul>
<?php foreach($data as $r) { ?>

	<li><?php echo $this->Repo->link($r['Repository']['name'], $r['Repository']['url']); ?></li>


<?php } ?>
</ul>