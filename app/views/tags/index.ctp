<?php 
$title = 'Search'; 
$this->viewVars['title_for_layout'] = $title; 
?>

<?php echo $this->Html->image('docs.png',array('class' => 'imgicon')) ; ?>
<h1 class="h1icon" style="margin-top: 15px;"><?php echo $title; ?></h1>
<div class="clearicon"></div>

<?php echo $this->Form->create('Tag', array('action' => 'process')); ?>

<?php echo $this->Form->input('search', array('label' => false));?>	  

<?php if(!empty($criterias)): ?>
<div class="input select">
	<label for="CriteriaId">Choose quality criteria which will be used to determine the quality of the documents searched:</label>
	<input type="hidden" name="data[Criteria][id]" value="" id="CriteriaId">
	<?php foreach($criterias as $c): $c = $c['Criteria']; ?>
	<div class="checkbox"><input type="checkbox" name="data[Criteria][id][]" value="<?php echo $c['id']; ?>" id="CriteriaId<?php echo $c['id']; ?>"><label class="search-criteria-option" for="CriteriaId<?php echo $c['id']; ?>"><?php echo $c['question']; ?></label></div>
	<?php endforeach; ?>
</div>
<?php else: ?>
<span>There aren't any quality criteria in this repository yet. The quality of the searched and/or downloaded documents is not guaranteed.</span>
<?php endif; ?>

<?php echo $this->Form->end('Search'); ?> 


<script language="javascript" type="text/javascript">
	add_textboxlist("#TagSearch");
</script>