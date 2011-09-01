<?php 
$title = ucwords($current);
$this->viewVars['title_for_layout'] = $title;
/* breadcrumbs */
$this->Html->addCrumb('Manage', '/manage/');
$this->Html->addCrumb($title);
/* end breadcrumbs */ 
?>

<?php echo $this->Html->image('admin.png',array('class' => 'imgicon')) ; ?><h1 class="h1icon" style="margin-top: 15px;"><?php echo $title; ?></h1>
<div class="clearicon"></div>
<?php echo 
	   $this->element('menu_administrar', array(
		 'isLogged' => $this->Session->check('User.id'), 
		 'isAdmin' => $this->Session->check('User.esAdmin'),
		 'isExpert' => false, //$this->Session->check('User.esExperto'),
         'current' => $current
	   ));       
?> 


<?php echo $this->element('paginator_info'); ?>
<!-- core table -->
<table id="tabla_documentos" class="ui-widget ui-widget-content tabla" style="width: 100%">
  <thead>
	<tr class="ui-widget-header">
	  <th width="20%"><?php echo $this->Paginator->sort('Name', 'Repository.name'); ?></th>
	  <th width="20%" title=""><?php echo $this->Paginator->sort('URL', 'Repository.url'); ?></th>
	  <th width="40%"><?php echo $this->Paginator->sort('Description', 'Repository.description');?></th>
	  <th width="20%">Options</th>
	</tr>
  </thead>
  <tbody>
  	<?php
  		foreach($this->data as $cr):
  	?>
  		<tr>
  			<td><?php echo $this->Html->link($cr['Repository']['name'], array('action' => 'edit', $cr['Repository']['id']));?></td>
  			<td><?php echo $this->Repo->link($this->Repo->url($cr['Repository']['url']), $cr['Repository']['url']);?></td>
  			<td>  			
	  			<div class="admin-doc-texto">
	  			<?php  
	  				echo $this->Text->truncate(
	  					str_replace(
	  							'\n', 
	  							'<br />', 
	  							Sanitize::html($cr['Repository']['description'])),
	  							100,
	  							array(
	  								'ending' => $this->Repo->link('...', $cr['Repository']['url']), 
	  								'exact' => false, 
	  								'html' => true)); 
	  			?>
	  			</div>
  			</td>
  			<td>
  				<!-- options -->
				<div class="admin-doc-edit">
					<?php echo $this->Html->link('Edit', array('action' => 'edit', $cr['Repository']['id'])); ?>
					&nbsp; | &nbsp;   
					<?php echo $this->Html->link('Remove', array('action' => 'remove', $cr['Repository']['id']), array(), "Are you sure to delete this repository!?"); ?>
				</div>  				
  			</td>
  		</tr>
  	<?php
  		endforeach;
  	?>
  </tbody>
</table>
<!-- end core table-->


<?php echo $this->element('paginator'); ?> 