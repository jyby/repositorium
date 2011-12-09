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
<br />

<div class="clearicon"></div>

<fieldset class="datafields">




<?php echo $this->Form->create(null, array('url' => '/documents/upload', 'type' => 'file', 'inputDefaults' => array('error' => false)));?>
<?php echo $this->Form->input('Document.title', array('class' => 'ingresar-documento', 'label' => 'Title', 'default' => '', 'size' => 50, 'onChange'=>"CheckTitle(DocumentTitle.value); return false"));
 	echo $ajax->div('checked_title'); ?>
<?php echo $ajax->divEnd('checked_title'); ?>



<?php
	echo $this->Form->input('Document.content', array('class' => 'ingresar-documento', 'label' => 'Content', 'rows' => 14, 'cols' => 80, 'default' => '', 'onChange'=>"CheckText(DocumentContent.value); return false"));
	echo("<div id='checked_text'></div>");
	foreach($constituents as $constituent){
		if(!empty($constituent)){
			echo $this->element($constituent."/form", array('flag' => 'value'));;
		}
	}
	if(count($constituents)!=0){
		echo("<div id='checked_file'></div>");
		}
?>

<div style="width:400px">
	<?php echo $this->Form->input('Document.tags', array('class' => 'ingresar-documento', 'size' => 100, 'label' => 'Tags (You may add more tags separating them by commas (,))', 'onChange'=>'CheckTitle("Hola")')); ?>     
<?php echo $ajax->div('checked_tags'); ?>
<?php echo $ajax->divEnd('checked_tags')?>
<?php echo $this->Form->end('Done'); ?>
</fieldset>

<br />


<div class="ui-widget">
	<div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 10px .7em;"> 
		<p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
		<strong>Hey!</strong> You may add more tags separating them by commas (,)</p>
	</div>
</div>