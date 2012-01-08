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

<?php echo $this->Form->input('url', array('label' => 'URL of this repository: ______.repositorium.cl')); ?>

<?php echo $this->Form->input('description'); ?>

<!-- source types for repo -->
<div class="select required">
	<label for="constituent_id">Select some modifiers for this Repository</label>
	<input type="hidden" name="data[Repository][Constituents][0]" value="0" id="RepositoryConstituents0">
	<?php
	# cgajardo: fix to persist "content" selection even when it's actually disabled, using javascript
	$constituents[0] = array(
		'name' => $constituents[0]." (required)",
		'value' => '0',
		'onClick' => 'this.checked=true'
	);
	echo $this->Form->input("Constituents", array("type"=>"select", "multiple"=>"checkbox", "default"=>"0", "options"=>$constituents));
	?>
</div> 

<?php //echo $this->Form->input('min_points', array('label' => 'Minimum points assigned to each new user of this repository')); ?>

<?php echo $this->Form->input('download_cost', array('label' => 'Cost (in points) of each document to be downloaded')); ?>

<?php echo $this->Form->input('upload_cost', array('label' => 'Cost (in points) of each document to be uploaded')); ?>

<?php echo $this->Form->input('documentpack_size', array('label' => 'Size of each pack of documents for document download')); ?>

<?php //echo $this->Form->input('challenge_reward', array('label' => 'Amount of points to be rewarded after passing successfuly a challenge')); ?>
<br /><br />
<div name="ponderation_div" class="yui-u padded"> 
<label for="ponderation_div"> <strong>Duplicate Data Control</strong> </label>
<label for="ponderation_elements">Score given to each new document if there is already a similar entry in this Repositorium. Upon reaching a score of 100 the document is considered to be a duplicate and labeled as such.</label>
<?php echo $this->Form->input('pdr_tittle', array('label' => 'Points added if title is similar')); ?>
<?php echo $this->Form->input('pdr_tags', array('label' => 'Points added when is identical tags')); ?>
<?php echo $this->Form->input('pdr_text', array('label' => 'Points added when text is similar')); ?>
<?php echo $this->Form->input('pdr_files', array('label' => 'Points added for each file already on the repository')); ?>
</div>
<br />
<?php echo $this->Form->end('Done'); ?>


