<?php

if(isset($current)) {
  if(strcmp($current, 'no_validados') == 0) {
	$classes['nv'] = 'current';
  } else if(strcmp($current, 'validados') == 0) {
	$classes['v'] = 'current';
  } else if(strcmp($current, 'criterios') == 0) {
	$classes['cr'] = 'current';
  } else if(strcmp($current, 'usuarios') == 0) {
	$classes['usr'] = 'current';
  }else if(strcmp($current, 'repositories') == 0) {
	$classes['var'] = 'current';
  }
}
?>
<div class="admin-menu">
<?php

if($isExpert) {

echo $this->Form->radio('radiomenu',
        					array('no_validados' => 'Pending validation'),
							array(
								'value' => $current , 
								'onClick' => 'document.location="'.Router::url('/', true).'/admin_documentos/no_validados";'));
								
								
echo $this->Form->radio('radiomenu',
        					array('validados' => 'Validated documents'),
							array(
								'value' => $current , 
								'onClick' => 'document.location="'.Router::url('/',true).'/admin_documentos/validados";'));

echo $this->Form->radio('radiomenu',
        					array('all' => 'All documents'),
							array(
								'value' => $current , 
								'onClick' => 'document.location="'.Router::url('/',true).'/admin_documentos/all";'));
								
echo $this->Form->radio('radiomenu',
	        					array('criterios' => 'Criteria'),
								array(
									'value' => $current , 
									'onClick' => 'document.location="'.Router::url('/',true).'/criterias/index";'));						
} if($isAdmin) {			
								
	echo $this->Form->radio('radiomenu',
	        					array('usuarios' => 'Users'),
								array(
									'value' => $current , 
									'onClick' => 'document.location="'.Router::url('/',true).'/admin_usuarios/listar";'));
	echo $this->Form->radio('radiomenu',
								array('repositories' => 'Repositories'),
								array(
									'value' => $current , 
									'onClick' => 'document.location="'.Router::url('/',true).'/admin_repositories/index";'));
}
?>
</div>
<script>
	$(".admin-menu").buttonset();
</script>
