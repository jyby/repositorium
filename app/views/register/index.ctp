<?php echo $this->Html->image('users.png',array('class' => 'imgicon')) ; ?>

<h1 class="h1icon">  
	Sign In
</h1>
<div class="clearicon"></div>
<?php
echo $this->Form->create(null, array('action' => '/', 'inputDefaults' => array('error' => false)));
echo $this->Form->input('User.email');
echo $this->Form->input('User.first_name');
echo $this->Form->input('User.last_name');
echo $this->Form->input('User._password', array('label' => 'Password', 'type' => 'password'));
echo $this->Form->input('User._password2', array('label' => 'Repeat Password', 'type' => 'password'));
echo $this->Form->end('Sign In');

?>
