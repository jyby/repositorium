<?php
	$this->viewVars['title_for_layout'] = $title;
	/* breadcrumbs */
	$this->Html->addCrumb($repo['Repository']['name'], '/repositories/'.$repo['Repository']['url']);
	$this->Html->addCrumb('Manage', '/manage/');
	$this->Html->addCrumb($title);
	/* end breadcrumbs */ 
?>

<?php echo $this->Html->image('admin.png',array('class' => 'imgicon')) ; ?><h1 class="h1icon" style="margin-top: 15px;"><?php echo $title; ?></h1>
<div class="clearicon"></div>
<?php echo 
	   $this->element($menu, array('current' => $current));       
?> 

<?php echo $this->Form->create(); ?>

<!-- source types for repo -->
<div class="select required">
	<label for="constituent_id">Select some modifiers for this Repository</label>
	<input type="hidden" name="data[Repository][Constituents][0]" value="0" id="RepositoryConstituents0">
	<?php
	echo $this->Form->input("Constituents", array("type"=>"select", "multiple"=>"checkbox", "default"=>"0", "options"=>$constituents));
	?>
</div> 

<?php echo $this->Form->end('Update'); ?>