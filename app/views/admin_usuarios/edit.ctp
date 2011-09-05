<?php
/* breadcrumbs */
$this->Html->addCrumb('Manage', '/manage/');
$this->Html->addCrumb('Users', '/admin_usuarios');
$this->Html->addCrumb('Edit user');
/* end breadcrumbs */ 
?>


<?php echo $this->Html->image('users.png',array('class' => 'imgicon')) ; ?><h1 class="h1icon">Edit user - <?php echo $this->data['User']['email'];?></h1>
<div class="clearicon"></div>
<?php echo 
	   $this->element($menu, array(
         'current' => $current
	   ));       
?> 

 <?php echo $this->Form->create('User', array('url' => '/admin_usuarios/edit/' . $this->data['User']['id']));?>
 <?php echo $this->Form->input('id', array('type' => 'hidden')); ?>
 <?php echo $this->Form->input('first_name', array('label' => 'First name')); ?>
 <?php echo $this->Form->input('last_name', array('label' => 'Last name')); ?>
 <?php echo $this->Form->input('tmp_password', array('type' => 'password', 'label' => 'New Password (leave in blank if you don\'t want to change it)'));?>
 <?php echo $this->Form->input('tmp_password2', array('type' => 'password', 'label' => 'Repeat New Password'));?>
 <label for="UserIsAdministrator">Promote to Site Administrator?</label>
 <?php echo $this->Form->input('User.is_administrator', array('label' => false ));?>

 
 <?php echo $this->Form->end('Save'); ?>
