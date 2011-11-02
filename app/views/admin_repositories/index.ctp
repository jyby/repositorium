<?php 
$title = (isset($title) ? $title : ucwords($current));
$this->viewVars['title_for_layout'] = $title;
/* breadcrumbs */
$this->Html->addCrumb('Manage', '/manage/');
$this->Html->addCrumb($title);
/* end breadcrumbs */ 
?>

<?php echo $this->Html->image('admin.png',array('class' => 'imgicon')) ; ?><h1 class="h1icon" style="margin-top: 15px;"><?php echo (isset($message) ? $message : $title); ?></h1>
<div class="clearicon"></div>
<?php echo 
	   $this->element($menu, array(
         'current' => $current
	   ));       
?> 


<?php echo $this->element('paginator_info'); ?>
<!-- core table -->
<table id="tabla_documentos" class="ui-widget ui-widget-content tabla" style="width: 100%">
  <thead>
	<tr class="ui-widget-header">
	  <th width="10"><?php echo $this->Paginator->sort('Id', 'Repository.id'); ?> </th>
	  <th width="20%"><?php echo $this->Paginator->sort('Name', 'Repository.name'); ?></th>
	  <th width="20%" title=""><?php echo $this->Paginator->sort('URL', 'Repository.url'); ?></th>
	  <th width="40%"><?php echo $this->Paginator->sort('Description', 'Repository.description');?></th>
	  <th width="20%">Options</th>
	</tr>
  </thead>
  <tbody>
  	<?php
  		foreach($this->data as $cr):
  			$ast = false;
  			if(isset($cond)) {
  				if(strcmp($cond, 'owner') == 0) {
  					$ast = $user['User']['id'] == $cr['Repository']['user_id'];
  				}
  			}
  	?>
  		<tr>
  			<td><?php echo $cr['Repository']['id']; ?></td>
  			<td><?php echo $this->Html->link($cr['Repository']['name'], array('controller' => 'admin_repositories', 'action' => 'edit', $cr['Repository']['id'])) . ($ast ? '*' : '');?></td>
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
					<?php echo $this->Html->link('See users', array('controller' => 'admin_repositories', 'action' => 'users', $cr['Repository']['id'])); ?>
					&nbsp; | &nbsp;
					<?php echo $this->Html->link('Edit', array('controller' => 'admin_repositories','action' => 'edit', $cr['Repository']['id'])); ?>
					&nbsp; | &nbsp;   
					<?php echo $this->Html->link('Remove', array('controller' => 'admin_repositories','action' => 'remove', $cr['Repository']['id']), array(), "Are you sure to delete this repository!? WARNING: This also will delete ALL documents, criterias and points if this repository"); ?>
				</div>  				
  			</td>
  		</tr>
  	<?php
  		endforeach;
  	?>
  </tbody>
</table>
<!-- end core table-->

<?php if(isset($footnotes)) {
		$i = 1; 
		foreach($footnotes as $f): ?>
<span><?php for($j=0; $j<$i; $j++) echo '*';?> <em><?php echo $f; ?></em></span>
<?php 
		$i++;
		endforeach; 
	  } ?>

<?php echo $this->element('paginator'); ?> 