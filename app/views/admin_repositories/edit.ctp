<?php
$title = "Edit Repository";	
$this->viewVars['title_for_layout'] = $title;
$this->Html->addCrumb('Repositories', '/admin_repositories');
$this->Html->addCrumb($title);
?>


<?php echo $this->Html->image('admin.png',array('class' => 'imgicon')) ; ?><h1 class="h1icon" style="margin-top: 15px;"><?php echo $title; ?></h1>
<div class="clearicon"></div>

<?php echo 
	   $this->element('menu_administrar', array(
		 'isLogged' => $this->Session->check('User.id'), 
		 'isAdmin' => $this->Session->check('User.esAdmin'),
		 'isExpert' => false, //$this->Session->check('User.esExperto'),
         'current' => $current
	   ));       
?> 

<?php echo $this->Form->create(); ?>

<?php echo $this->Form->input('id', array('type' => 'hidden')); ?>

<?php echo $this->Form->input('user_id', array('type' => 'hidden')); ?>

<?php echo $this->Form->input('name'); ?>

<?php echo $this->Form->input('url', array('label' => 'URL of this repository: ______.repositorium.cl')); ?>

<?php echo $this->Form->input('description'); ?>

<?php //echo $this->Form->input('min_points', array('label' => 'Minimum points assigned to each new user of this repository')); ?>

<?php echo $this->Form->input('download_cost', array('label' => 'Cost (in points) of each document to be downloaded')); ?>

<?php echo $this->Form->input('upload_cost', array('label' => 'Cost (in points) of each document to be uploaded')); ?>

<?php echo $this->Form->input('documentpack_size', array('label' => 'Size of each pack of documents for document download')); ?>

<?php //echo $this->Form->input('challenge_reward', array('label' => 'Amount of points to be rewarded after passing successfuly a challenge')); ?>

<br /><br />
<div name="ponderation_div" class="yui-u padded"> 
<label for="ponderation_div"> <strong>Duplicate Data Control</strong> </label>
<label for="ponderation_elements">Score given for each new document if a similar entry already exists in this Repositorium. The document is considered to be a duplicated and labeled as such upon reaching a score of 100.
<?php echo $this->Form->input('pdr_tittle', array('label' => 'Points added if similar title exists')); ?>
<?php echo $this->Form->input('pdr_tags', array('label' => 'Points added for identical tags')); ?>
<?php echo $this->Form->input('pdr_text', array('label' => 'Points added if similar content exists')); ?>
<?php echo $this->Form->input('pdr_files', array('label' => 'Points added for each file already in repository')); ?>
</div>
<br />

<?php echo $this->Form->end('Done'); ?>
