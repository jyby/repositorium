<?php

$title = "Add a collaborator";
/* breadcrumbs */
$this->Html->addCrumb('Manage', '/manage/');
$this->Html->addCrumb('Collaborators', array('controller' => 'experts'));
$this->Html->addCrumb($title);
/* end breadcrumbs */ 
$this->viewVars['title_for_layout'] = $title;
?>

<?php echo $this->Html->image('users.png',array('class' => 'imgicon')) ; ?><h1 class="h1icon" style="margin-top: 15px;"><?php echo $title; ?></h1>
<div class="clearicon"></div>
<?php echo
  $this->element($menu, array(
	'current' => $current
  ));      
       
?>
  <?php echo $this->Form->create(null, array('url' => array('controller' => 'experts', 'action' => 'add'))); ?>
  <?php echo $this->Form->input('User.email', array('label' => 'Email (the collaborator will be added automatically, if exists)'));?>
  <?php echo $this->Form->end('Add');?>
