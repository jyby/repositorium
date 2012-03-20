<?php
echo $javascript->link('checker.js',false);
?>
<?php
$title = "Add new document";	
$this->viewVars['title_for_layout'] = $title;
$this->Html->addCrumb($title);
?>
<script type="text/javascript">
$(document).ready(function() {
	add_textboxlist("#DocumentTags");
});
</script>

<?php echo $this->Html->image('add_doc.png',array('class' => 'imgicon')) ; ?><h1 class="h1icon" style="margin-top: 15px;"><?php echo $title;?></h1>
<div class="clearicon"></div>

<fieldset class="datafields">
<?php echo $this->Form->create(null, array('url' => '/documents/upload', 'type' => 'file', 'inputDefaults' => array('error' => false)));?>
<?php echo $this->Form->input('Document.title', array('class' => 'ingresar-documento', 'label' => 'Title', 'default' => '', 'size' => 50, 'onChange'=>"CheckTitle(DocumentTitle.value)"));?> 
<?php echo $ajax->div('checked_title'); 
	  echo $ajax->divEnd('checked_title'); ?>
<?php
	foreach($constituents as $constituent){
		echo $this->element($constituent."/form", array('flag' => 'value'));
		
		if ($constituent=='content'){
			
			echo("<div id='checked_content'></div>");
		}
		if ($constituent=='attachFile'){
			
			echo("<div id='checked_attachFile'></div>");
		}
	}
	//DocumentFileAttach.value
	//echo '<input type="button" id="file_aux_button" name="file_aux_button" value="Check files"  OnClick="CheckFile(DocumentTitle.value)" />';
?>
<div style="width:400px">
	<?php echo $this->Form->input('Document.tags', array('class' => 'ingresar-documento', 'size' => 100,'onChange'=>"CheckTag(DocumentTitle.value)", 'label' => 'Tags (You may add more tags separating them by commas (,))'));?>     
</div>
<?php echo $ajax->div('checked_tags'); 
	  echo $ajax->divEnd('checked_tags');
	echo '<input type="button" id="tag_aux_button" name="tag_aux_button" value="Check tags"  OnClick="CheckTag(DocumentTags.value)" />';	  
?>
	  
<?php echo $this->Form->end('Done'); ?>
</fieldset>

<br />

<!-- 
<div class="ui-widget">
	<div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 10px .7em;"> 
		<p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
		<strong>Hey!</strong> You may add more tags separating them by commas (,)</p>
	</div>
</div>
-->