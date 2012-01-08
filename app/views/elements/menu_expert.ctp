<?php

if(isset($current)) {
  if(strcmp($current, 'no_validados') == 0) {
	$classes['nv'] = 'current';
  } else if(strcmp($current, 'validados') == 0) {
	$classes['v'] = 'current';
  } else if(strcmp($current, 'criteria') == 0) {
	$classes['cr'] = 'current';
  } else if(strcmp($current, 'usuarios') == 0) {
	$classes['usr'] = 'current';
  } else if(strcmp($current, 'experts') == 0) {
	$classes['usr'] = 'current';
  }
}
?>
<div class="admin-menu">
<?php
echo $this->Form->radio('radiomenu',
        					array('no_validados' => 'Pending validation'),
							array(
								'value' => $current , 
								'onClick' => 'document.location="'.$this->Html->url(array('controller' => 'admin_documentos', 'action' => 'no_validados')) .'";'));
								
								
echo $this->Form->radio('radiomenu',
        					array('validados' => 'Validated documents'),
							array(
								'value' => $current , 
								'onClick' => 'document.location="'.$this->Html->url(array('controller' => 'admin_documentos', 'action' => 'validados')) .'";'));

echo $this->Form->radio('radiomenu',
        					array('all' => 'All documents'),
							array(
								'value' => $current , 
								'onClick' => 'document.location="'.$this->Html->url(array('controller' => 'admin_documentos', 'action' => 'all')) .'";'));
								
echo $this->Form->radio('radiomenu',
	        					array('criteria' => 'Criteria'),
								array(
									'value' => $current , 
									'onClick' => 'document.location="'.$this->Html->url(array('controller' => 'criterias', 'action' => 'index')) .'";'));						
									
echo $this->Form->radio('radiomenu',
	        					array('experts' => 'Collaborators'),
								array(
									'value' => $current , 
									'onClick' => 'document.location="'.$this->Html->url(array('controller' => 'experts', 'action' => 'index')) .'";'));
echo $this->Form->radio('radiomenu',
								array('constituents' => 'Update Constituents'),
								array(
									'value' => $current , 
									'onClick' => 'document.location="'.$this->Html->url(array('controller' => 'constituents', 'action' => 'index')) .'";'));
echo $this->Form->radio('radiomenu',
								array('warned' => 'Warned Documents'),
								array(
									'value' => $current , 
									'onClick' => 'document.location="'.$this->Html->url(array('controller' => 'admin_documentos', 'action' => 'warneds')) .'";'));
									
?>
</div>
<script>
	$(".admin-menu").buttonset();
</script>
