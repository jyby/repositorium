<?php echo $this->Html->image('users.png',array('class' => 'imgicon')) ; ?>

<h1 class="h1icon">  
	Registrarse
</h1>
<div class="clearicon"></div>
<?php
echo $this->Form->create(null, array('action' => '/', 'inputDefaults' => array('error' => false)));
echo $this->Form->input('email');
echo $this->Form->input('first_name');
echo $this->Form->input('last_name');
echo $this->Form->input('_password', array('label' => 'Password', 'type' => 'password'));
echo $this->Form->input('_password2', array('label' => 'Repeat Password', 'type' => 'password'));
echo $this->Form->end('Sign In');

?>
