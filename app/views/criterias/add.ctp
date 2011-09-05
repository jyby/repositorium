<?php
$this->viewVars['title_for_layout'] = $title;
/* breadcrumbs */
$this->Html->addCrumb($repo['Repository']['name'], '/repositories/'.$repo['Repository']['url']);
$this->Html->addCrumb('Manage', '/manage/');
$this->Html->addCrumb($title);
/* end breadcrumbs */ 

function op($label, $before = null, $after = null, $between = null, $style = null, $error = false) {
	return compact('label', 'before', 'after', 'between', 'style', 'error');
} 
?>

<?php echo $this->Html->image('admin.png',array('class' => 'imgicon')) ; ?><h1 class="h1icon"><?php echo $title; ?></h1>
<div class="clearicon"></div>

<?php echo 
	   $this->element($menu, array(
         'current' => $current
	   ));       
?> 

<div style="clear: both; height: 20px;"></div>

<div class="form-div">
<?php
	echo $this->Form->create('Criteria');
	echo $this->Form->input('question', op('Question to measure', null, null, null, 'width: 500px; height: 40px;'));
	
	echo "<br />";
	
	echo $this->Form->hidden('answer_1', array('value' => 'No'));
	echo $this->Form->hidden('answer_2', array('value' => 'Yes'));
	
	//echo $this->Form->input('documentpack_size', op('Quantity of documents to give after passing a challenge'));
	
	//echo "<br />";
	
	//echo $this->Form->input('documentpack_2', op('How many points the user must earn or spend to download documents'));
	
	//echo "<br />";
	
	//echo $this->Form->input('documentupload_cost', op('How many points the user must earn or spend to add new documents'));
	
	//echo "<br />";
	
	echo $this->Form->input('challenge_reward', op('How many points the user will receive after passing a challenge given by this criteria'));
	
	echo "<br />";
	
	echo $this->Form->input('documentvalidation_reward', op('How many points the user will receive after his uploaded document was validated under this criteria'));
	
	echo "<br />";
	
	echo $this->Form->input('minchallenge_size',op('Minimum quantity of questions in challenge'));
	
	echo "<br />";
	
	echo $this->Form->input('maxchallenge_size',op('Maximum quantity of questions in challenge'));
	
	echo "<br />";
	
	echo $this->Form->label(null, 'Let <span style="font-family: Monospace; font-size: 1.4em">c(i)</span> be the actual number of questions at a challenge. ' .
			'<br />If a user <span style="font-weight: bold">passes</span> the challenge, the new number of questions will be <span style="font-family: Monospace; font-size: 1.4em">c(i+1) = a*c(i)+b</span>, where');
	
	echo $this->Form->input('depenalization_a',op(false, '<span style="font-family: Monospace; font-size: 1.4em">a = </span>', '<div style="height:10px;"></div>'));
	
	echo $this->Form->input('depenalization_b',op(false, '<span style="font-family: Monospace; font-size: 1.4em">b = </span>'));
	
	echo "<br />";
	
	echo $this->Form->label(null, 'Let <span style="font-family: Monospace; font-size: 1.4em">c(i)</span> be the actual number of questions at a challenge. ' .
			'<br />If a user <span style="font-weight: bold">fails</span> at the challenge, the new number of questions will be <span style="font-family: Monospace; font-size: 1.4em">c(i+1) = a*c(i)+b</span>, where');
	
	echo $this->Form->input('penalization_a',op(false, '<span style="font-family: Monospace; font-size: 1.4em">a = </span>', '<div style="height:10px;"></div>'));
	
	echo $this->Form->input('penalization_b',op(false, '<span style="font-family: Monospace; font-size: 1.4em">b = </span>'));
	
	echo "<br />";
	
	echo $this->Form->end('Save');
?>
</div>