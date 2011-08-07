<?php echo $this->Html->image('users.png',array('class' => 'imgicon')) ; ?><h1 class="h1icon">Edit user - <?php echo $this->data['User']['email'];?></h1>
<div class="clearicon"></div>
<div class="pointsprofile">
<?php //	You have <?php echo $this->data['User']['puntos']; points. ?>
</div>
<?php echo $this->Form->create('User', array('url' => '/usuarios/edit/'. $this->data['User']['id']));?>
<?php echo $this->Form->input('id', array('type' => 'hidden')); ?>
<?php echo $this->Form->input('first_name', array('label' => 'Name')); ?><br/>
<?php echo $this->Form->input('last_name', array('label' => 'Last Name')); ?><br/>
<?php echo $this->Form->input('tmp_password', array('type' => 'password', 'label' => 'New Password (leave in blank if you don\'t want to change it)'));?><br/>
<?php echo $this->Form->input('tmp_password2', array('type' => 'password', 'label' => 'Repeat New Password'));?><br/>
<?php echo $this->Form->end('Save Changes'); ?> 
