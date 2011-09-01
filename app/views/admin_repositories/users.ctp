<?php
$title = "Users collaborators of '{$repo['Repository']['name']}' Repository";
$this->viewVars['title_for_layout'] = "Manage $title";

/* breadcrumbs */
$this->Html->addCrumb('Manage', '/manage/');
$this->Html->addCrumb($title);
/* end breadcrumbs */ 
?>
<script type="text/javascript">
	$(document).ready(function() {
		$("#adm-new-user").click(function(e) {
			e.preventDefault();
			$(window.location).attr('href', '<?php echo $this->Html->url(array('controller' => 'admin_usuarios', 'action' => 'add'));?>');
		});	
	});	
</script>
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
			echo '&nbsp;&nbsp;&nbsp;';
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
			$owner = false;
			if($u['User']['id'] == $repo['Repository']['user_id'])
				$owner = true;
	?>
	<tr>
	  <td><?php echo $u['User']['id']; ?></td>
	  <td><?php echo $this->Html->link($u['User']['email'], array('controller' => 'admin_usuarios', 'action' => 'edit', $u['User']['id'])) . ($owner ? '*' : ''); ?></td>
	  <td><?php echo $u['User']['first_name']; ?></td>
	  <td><?php echo $u['User']['last_name']; ?></td>
	  <td>
	  	<div class="admin-doc-edit">
	  	  <?php echo $this->Html->link('See repositories', array('controller' => 'admin_usuarios', 'action' => 'repositories', $u['User']['id'])); ?>
	  	  &nbsp; | &nbsp;
		  <?php echo $this->Html->link('Edit', array('controller' => 'admin_usuarios', 'action' => 'edit' , $u['User']['id'])); ?>
		  &nbsp; | &nbsp;
		  <?php echo $this->Html->link('Remove', array('controller' => 'admin_usuarios', 'action' => 'remove' , $u['User']['id']), null, 'Are you sure?'); ?>
		</div>
	  </td>
	</tr>
	<?php endforeach; ?>
  </tbody>
</table>
</div>

<span>* <em>Repository owner (only 1)</em></span>

 <?php echo $this->element('paginator'); ?>

<script type="text/javascript">
	$(function(){
		$("#lnk_add").button({ icons : {primary : "ui-icon-plus"} });
	};
</script>
