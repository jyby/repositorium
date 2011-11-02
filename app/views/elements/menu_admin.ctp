<?php

if(isset($current))
  if(strcmp($current, 'usuarios') == 0) {
	$classes['usr'] = 'current';
  } else if(strcmp($current, 'repositories') == 0) {
	$classes['var'] = 'current';
  }
?>
<div class="admin-menu">
<?php	
							
echo $this->Form->radio('radiomenu',
        					array('usuarios' => 'Users'),
							array(
								'value' => $current , 
								'onClick' => 'document.location="'.$this->Html->url(array('controller' => 'admin_usuarios', 'action' => 'listar')) .'";'));
echo $this->Form->radio('radiomenu',
							array('repositories' => 'Repositories'),
							array(
								'value' => $current , 
								'onClick' => 'document.location="'.$this->Html->url(array('controller' => 'admin_repositories', 'action' => 'index')) .'";'));

?>
</div>
<script>
	$(".admin-menu").buttonset();
</script>
