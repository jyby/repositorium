<?php
$title = (isset($title) ? $title : 'Users');
$this->viewVars['title_for_layout'] = "Manage $title";

/* breadcrumbs */
$this->Html->addCrumb('Manage', '/manage/');
$this->Html->addCrumb($title);
/* end breadcrumbs */ 
?>
<script type="text/javascript">
	$(document).ready(function() {
		<?php if(!isset($add_button) || $add_button == true): ?>
		$("#adm-new-user").click(function(e) {
			e.preventDefault();
			$(window.location).attr('href', '<?php echo $this->Html->url(array('controller' => 'admin_usuarios', 'action' => 'add'));?>');
		});
		<?php endif; ?>
		
		<?php if(isset($collaborator_button)): ?>
		$("#adm-new-expert").click(function(e) {
			e.preventDefault();
			$(window.location).attr('href', '<?php echo $this->Html->url(array('controller' => 'experts', 'action' => 'add'));?>');
		});
		<?php endif; ?>
	});	
</script>
<?php echo $this->Html->image('admin.png',array('class' => 'imgicon')) ; ?><h1 class="h1icon" style="margin-top: 15px;"><?php echo $title; ?></h1>
<div class="clearicon"></div>

<?php echo
	$this->element($menu, array(
		'current' => $current
    ));      
?>

<br/>
<div style="text-align : left; float : left; width : 70%">
	<?php echo $this->element('paginator_info'); ?>	
</div>

<!-- expert tools -->
<div id="expert-tools">
	<!-- mass edit -->
	<div class="adm-mass">
		<!--<span class="adm-opt">Selected Documents: </span>-->
		<?php
			if(isset($collaborator_button))
				echo $this->Form->button('Add a collaborator', array('id' => 'adm-new-expert'));
			echo '&nbsp;&nbsp;&nbsp;';
			if(!isset($add_button) || $add_button == true)
				echo $this->Form->button('Add new user', array('id' => 'adm-new-user'));
		?>
	</div>
	<!-- end mass edit-->	
</div>
<!-- end expert tools -->

<div style="clear:both;"></div>
<div style="text-align:left">
<table class="ui-widget ui-widget-content tabla" style="width: 100%">
  <thead>
	<tr class="ui-widget-header"> 
	  <th width="10"><?php echo $this->Paginator->sort('Id', 'User.id');?></th>
	  <th><?php echo $this->Paginator->sort('E-mail', 'User.email'); ?></th>
	  <th><?php echo $this->Paginator->sort('First name', 'User.first_name'); ?></th>
	  <th><?php echo $this->Paginator->sort('Last name', 'User.last_name'); ?></th>
	  <th width="200">Options</th>
	</tr>
  </thead>
  <tbody>
	<?php foreach($this->data as $u): 
			$ast = false;
			if(isset($cond)) {
				if(strcmp($cond, 'admin') == 0) {
					$ast = $u['User']['is_administrator'];
				} else if(strcmp($cond, 'owner') == 0) {
					$ast = $u['User']['id'] == $repo['Repository']['user_id'];
				}
			}
	?>
	<tr>
	  <td><?php echo $u['User']['id']; ?></td>
	  <td><?php echo $this->Html->link($u['User']['email'], array('controller' => 'admin_usuarios', 'action' => 'edit', $u['User']['id'])) . ($ast ? '*' : ''); ?></td>
	  <td><?php echo $u['User']['first_name']; ?></td>
	  <td><?php echo $u['User']['last_name']; ?></td>
	  <td>
	  <?php if(strcmp($current,'experts') == 0): ?>
	  	<div class="admin-doc-edit">
	  	  <?php if($u['User']['id'] != $this->Session->read('User.id')) 
	  	  			echo $this->Html->link('Remove member', array('controller' => 'experts', 'action' => 'remove', $u['User']['id']), null, 'Are you sure?');
	  	  		else
	  	  			echo 'Owner'; 
	  	  ?>
		</div>
	  <?php else: ?>
	  	<div class="admin-doc-edit">
	  	  <?php echo $this->Html->link('See repositories', array('controller' => 'admin_usuarios', 'action' => 'repositories', $u['User']['id'])); ?>
	  	  &nbsp; | &nbsp;
		  <?php echo $this->Html->link('Edit', array('controller' => 'admin_usuarios', 'action' => 'edit' , $u['User']['id'])); ?>
		  &nbsp; | &nbsp;
		  <?php echo $this->Html->link('Remove', array('controller' => 'admin_usuarios', 'action' => 'remove' , $u['User']['id']), null, 'Are you sure?'); ?>
		</div>
	  <?php endif; ?>
	  </td>
	</tr>
	<?php endforeach; ?>
  </tbody>
</table>
</div>

<?php if(isset($footnotes)) {
		$i = 1; 
		foreach($footnotes as $f): ?>
<span><?php for($j=0; $j<$i; $j++) echo '*';?> <em><?php echo $f; ?></em></span>
<?php 
		$i++;
		endforeach; 
	  } ?>

 <?php echo $this->element('paginator'); ?>

<script type="text/javascript">
	$(function(){
		$("#lnk_add").button({ icons : {primary : "ui-icon-plus"} });
	};
</script>
