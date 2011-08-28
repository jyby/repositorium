<?php $this->viewVars['title_for_layout'] = 'Repositorium'; ?>
Hay, anon!

<?php echo $this->Html->link('Create new Repository', array('controller' => 'repositories', 'action' => 'create')); ?>

<ul>
<?php foreach($data as $r) { ?>

	<li><?php echo $this->Html->link($r['Repository']['name'], array('controller' => 'repositories', 'action' => 'index', $r['Repository']['url'])); ?></li>


<?php } ?>
</ul>