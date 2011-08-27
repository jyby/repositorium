<?php $this->viewVars['title_for_layout'] = "Repositorium"; ?>

<?php if(!$this->Session->read('User.id')) {
		echo $this->Html->link('Sign in', array('controller' => 'register')) . '<br />';
		echo $this->Html->link('Log in', array('controller' => 'login')) . '<br />';
	}
?>
<?php echo $this->Html->link('Create a new Repository', array('controller' => 'repositories', 'action' => 'create')); ?>
