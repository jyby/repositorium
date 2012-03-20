<?php
function porcentaje($q,$tot) {
	if($tot == 0)
		return 0;
	  return 100*$q/($tot);
}
		
	echo $this->Html->script('https://www.google.com/jsapi');
	echo $this->Html->script('piecharts');	
	//pr($this->data);
	//data tiene a Document.
	//echo '<pre>';
	//echo $this->id_wdoc1;
	//echo $this->id_wdoc2;
	//echo $id_wdoc1;
	//echo $id_wdoc2;
	//echo '</pre>';
	$id = $this->data['Document']['id'];
	$en_valid=true;
	//$en_valid = ($this->data['CriteriasDocument']['validated'] == 1) ? true : false;
	$current = 	($en_valid ? 'validados' : 'no_validados');
	$title = "Edit warned documents";	
	$this->viewVars['title_for_layout'] = $title;
	$this->Html->addCrumb($repo['Repository']['name'], '/repositories/'.$repo['Repository']['url']);
	$this->Html->addCrumb('Manage', '/manage/');
	$this->Html->addCrumb(($en_valid ? 'Validated Documents' : 'Pending validation'), $current);
	$this->Html->addCrumb($title);
?>
<script type="text/javascript">
$(document).ready(function() {
	$('.adm-save').click(function(e) {
		e.preventDefault();
		var form = $("#edit-form");
		form.submit();
	});
	
	$('.adm-cancel').click(function(e) {
		e.preventDefault();
		$(window.location).attr('href','<?php echo $this->Html->url(array('controller' => 'admin_documentos', 'action' => ($en_valid ? 'validados' : 'no_validados'))); ?>');
	});
	
	$('.adm-validate').click(function(e) {
		e.preventDefault();
		var ok = confirm("Are you sure to (in)validate this document?");
		if(ok)
			$(window.location).attr('href', '<?php echo $this->Html->url(array('controller' => 'admin_documentos', 'action' => 'validate_document', $id, $criterios_n)); ?>');
	});
	
	$('.adm-reset').click(function(e) {
		e.preventDefault();
		var ok = confirm("Are you sure to reset this document's statistics?");
		if(ok)
			$(window.location).attr('href', '<?php echo $this->Html->url(array('controller' => 'admin_documentos', 'action' => 'reset_only/'. $id . '/' . $criterios_n)); ?>');
	});
	
	$('.adm-delete').click(function(e) {
		e.preventDefault();
		var ok = confirm("Are you sure to delete this document?");
		if(ok)
			$(window.location).attr('href', '<?php echo $this->Html->url(array('controller' => 'admin_documentos', 'action' => 'remove', $id)); ?>');
	});
	//deshabilita el boton de save
	var cmp_button=document.getElementById("save_button");
	cmp_button.setAttribute("disabled","disabled");
	cmp_button.setAttribute("aria-disabled","true");
	$(cmp_button).addClass("ui-button-disabled ui-state-disabled");
	/*
	$('.adm-select-criteria').change(function() {
		var value = $('.adm-select-criteria option:selected').val();
		$('#ActionSelect').attr('value', value);
		$('#adm-form-criteria').submit();
	});
	*/
});
</script>

<?php 
// #adm-form-criteria
echo $this->Form->create(null, array('url' => '/admin_documentos/edit_select_criteria/'.$id, 'id' => 'adm-form-criteria'));
echo $this->Form->hidden('Action.select');
echo $this->Form->end(); 
?>

<?php echo $this->Html->image('docs.png',array('class' => 'imgicon')) ; ?>
<h1 class="h1icon" style="margin-top: 15px;"><?php echo $title; ?></h1>
<div class="clearicon"></div>

<?php //echo 
	   $this->element($menu, array(
         'current' => $current
	   ));       
?> 

<!-- expert tools -->
<div id="expert-tools" style="float: right; height: 29px; width: 100%">		
	<!-- mass edit -->
	<div class="adm-mass">	
		<!--<span class="adm-opt">Instant actions: </span>-->
		<?php			
			echo "&nbsp;&nbsp;&nbsp;";
			//echo $this->Form->button('Save and return', array('class' => 'adm-save'));
			echo '&nbsp;&nbsp;&nbsp;';
			//echo $this->Form->button('Reset stats', array('id' => 'adm-mass-reset'));
			//echo '&nbsp;&nbsp;&nbsp;';
			//echo $this->Form->button(($en_valid ? 'Inv' : 'V' ). 'alidate', array('class' => 'adm-validate'));
			echo '&nbsp;&nbsp;&nbsp;';
			//echo $this->Form->button('Delete document', array('class' => 'adm-delete'));
		?>
	</div>
	<!-- end mass edit-->	
</div>
<!-- end expert tools -->

<?php echo $this->Form->create(null, array('id' => 'edit-form', 'url' => '/admin_documentos/edit/' . $id. '/' . $criterios_n.'/1/'. $id.'/'.$id_wdoc2 )); ?>
<?php echo $this->Form->hidden('Action.current', array('value' => $current)); ?>
<div class="yui-g">
	<div class="yui-u first">
		<!-- basics -->
		<div class="adm-edit-doc">
			<h2>Warned document's Basics</h2>
			<div style="clear: both; height: 10px;"></div>
			<?php								
				echo $this->Form->input('Document.title', array(
				  'label' => 'Document title ',
				  'class' => 'edit',
				  'style' => 'width: 90%;',
				));
				echo '<div style="clear: both; height: 10px;"></div>';
				
				echo "<div style='width: 90%'>";
				echo $this->Form->input('Document.tags', array(
				  'label' => 'Tags <span style="font-size: .9em; font-style: italic; color: #777">(Separate tags with commas)</span>',
				  'class' => 'edit',
				  'style' => 'width: 90%;',
				));
				echo "</div>";
				
				echo '<div style="clear: both; height: 10px;"></div>';
	
				echo $this->Form->input('Document.content', array(
				  'label' => 'Content ',
				  'value' => stripslashes(str_replace('\n',"\n",$this->data['Document']['content'])),
				  'style' => 'width: 90%; height: 300px;'
				  //'rows' => 14,
				  //'cols' => 60,
					));
				
				
				// cgajardo: attach edit snippets for each repo-component
				foreach($constituents as $constituent){
					echo $this->element($constituent['Constituent']['sysname'].'/edit', array("folios"=>$folios));
				}
				
					
			?>
				<div class="created-by">
					<span>Created by <?php echo $this->Text->autoLinkEmails($this->data['User']['autor']); ?> on <?php echo $this->data['Document']['created']; ?></span> 
				</div>
			<script type="text/javascript">
				add_textboxlist("#DocumentTags");
			</script>
		</div>
		
	</div>
	<div class="yui-u first">
		<!-- basics -->
		<div class="adm-edit-doc">
			<h2>Document's Basics</h2>
			<div style="clear: both; height: 10px;"></div>
			<?php								
				echo $this->Form->input('Document2.title', array(
				  'label' => 'Document title ',
				  'class' => 'edit',
				  'style' => 'width: 90%;',
				));
				echo '<div style="clear: both; height: 10px;"></div>';
				
				echo "<div style='width: 90%'>";
				echo $this->Form->input('Document2.tags', array(
				  'label' => 'Tags <span style="font-size: .9em; font-style: italic; color: #777">(Separate tags with commas)</span>',
				  'class' => 'edit',
				  'id' => 'DocumentTags2',
				  'style' => 'width: 90%;',
				));
				echo "</div>";
				
				echo '<div style="clear: both; height: 10px;"></div>';
	
				echo $this->Form->input('Document.content', array(
				  'label' => 'Content ',
				  'value' => stripslashes(str_replace('\n',"\n",$this->data['Document2']['content'])),
				  'style' => 'width: 90%; height: 300px;'
				  //'rows' => 14,
				  //'cols' => 60,
					));
				
				
				// cgajardo: attach edit snippets for each repo-component
				foreach($constituents as $constituent){
					echo $this->element($constituent['Constituent']['sysname'].'/edit', array("folios"=>$folios));
				}
				
					
			?>
				<div class="created-by">
					<span>Created by <?php echo $this->Text->autoLinkEmails($this->data['User']['autor2']); ?> on <?php echo $this->data['Document2']['created']; ?></span> 
				</div>
			<script type="text/javascript">
				add_textboxlist("#DocumentTags2");
			</script>
		</div>
		
	</div>
		
</div>
<?php echo $this->Form->end(); ?>

<div class="adm-buttons">
	<?php
	// delete 
	//echo $this->Form->create(null, array('url' => '/admin_documentos/remove/'.$id));
	//echo $this->Form->end('Remove document');
	
	// (in)validate		
	//echo $this->Form->create(null, array('url' => '/admin_documentos/set_field/confirmado'.$id.'/'.$value));
	//echo $this->Form->end();
	
	$value = ($en_valid) ? 0 : 1;
	echo "&nbsp;&nbsp;&nbsp;";
	//Boton deshabilitado pq no esta haciendo lo que deberia
	echo $this->Form->button('Save and return', array('class' => 'adm-save disabled','id'=> 'save_button'));
	echo "&nbsp;&nbsp;&nbsp;";
	echo $this->Form->button('Cancel', array('class' => 'adm-cancel'));
	
	//echo $this->Form->button(($en_valid ? 'Invalidate' : 'Validate') . ' document', array('class' => 'adm-validate'));
	
	//echo "&nbsp;&nbsp;&nbsp;";
	//echo $this->Form->button('Delete document', array('class' => 'adm-delete'));

	?>
</div>



