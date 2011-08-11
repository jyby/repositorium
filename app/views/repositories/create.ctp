<?php
$title = "New Repository";	
$this->viewVars['title_for_layout'] = $title;
$this->Html->addCrumb('Repositories', '/repositories');
$this->Html->addCrumb($title);
?>


<?php echo $this->Html->image('admin.png',array('class' => 'imgicon')) ; ?><h1 class="h1icon" style="margin-top: 15px;"><?php echo $title; ?></h1>
<div class="clearicon"></div>

<?php echo $this->Form->create(); ?>

<?php echo $this->Form->input('name'); ?>

<?php echo $this->Form->input('description'); ?>


<?php echo $this->Form->end('Done'); ?>
