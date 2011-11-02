<?php
	$this->viewVars['title_for_layout'] = $title;
	/* breadcrumbs */
	$this->Html->addCrumb($repo['Repository']['name'], '/repositories/'.$repo['Repository']['url']);
	$this->Html->addCrumb('Manage', '/manage/');
	$this->Html->addCrumb($title);
	/* end breadcrumbs */ 
?>
<script type="text/javascript">
	$(document).ready(function() {
		$("#adm-new-criteria").click(function(e) {
			e.preventDefault();
			$(window.location).attr('href', '<?php echo $this->Html->url(array('controller' => 'criterias', 'action' => 'add'));?>');
		});	
	});	
</script>

<?php echo $this->Html->image('admin.png',array('class' => 'imgicon')) ; ?><h1 class="h1icon" style="margin-top: 15px;"><?php echo $title; ?></h1>
<div class="clearicon"></div>
<?php echo 
	   $this->element($menu, array(
         'current' => $current
	   ));       
?> 

<!-- expert tools -->
<div id="expert-tools">
	<!-- number of items -->
	<div class="adm-limit" style="float: left">
		<?php echo $this->Form->create(null, array('url' => '/criterias/', 'name' => 'select_limit')); ?>
		<span class="adm-opt">Show: </span>
		<?php			 
			$options = array(
				'5' => '5 criteria',
				'10' => '10 criteria',
				'20' => '20 criteria',
				'50' => '50 criteria' 
			);
			echo $this->Form->select('Criteria.limit', $options, $limit, array('empty' => false, 'onChange' => 'select_limit.submit()'));			   
		?>
		</form>
	</div>
	<!-- end number of items -->
	
	<!-- mass edit -->
	<div class="adm-mass">
		<!--<span class="adm-opt">Selected Documents: </span>-->
		<?php		
			echo '&nbsp;&nbsp;&nbsp;';
			echo $this->Form->button('Add new criteria', array('id' => 'adm-new-criteria'));
		?>
	</div>
	<!-- end mass edit-->	
</div>
<!-- end expert tools -->

<!-- core table -->
<table id="tabla_documentos" class="ui-widget ui-widget-content tabla" style="width: 100%">
  <thead>
	<tr class="ui-widget-header">
	  <!--<th width="10" style="text-align:center;font-size:9px"><input type="checkbox" id="select-all" /><label for="select-all">select</label></th>--> 
	  <th width="550"><?php echo $this->Paginator->sort('Question', 'Criteria.question'); ?></th>
	  <th width="220" title=""><?php echo $this->Paginator->sort('Bonus by passing a challenge', 'Criteria.challenge_reward'); ?></th>
	  <th width="220"><?php echo $this->Paginator->sort('Bonus by validated document', 'Criteria.documentvalidation_reward');?></th>
	  <!--<th width="220"><?php //echo $this->Paginator->sort();?></th> -->
	  <th width="100">Options</th>
	</tr>
  </thead>
  <tbody>
  	<?php
  		foreach($this->data as $cr):
  	?>
  		<tr>
  			<td><?php echo $this->Html->link(Sanitize::html($cr['Criteria']['question']), array('action' => 'edit', $cr['Criteria']['id']));?></td>
  			<td><?php echo $cr['Criteria']['challenge_reward'];?></td>
  			<td><?php echo $cr['Criteria']['documentvalidation_reward'];?></td>
  			<td>
  				<!-- options -->
				<div class="admin-doc-edit">
					<?php echo $this->Html->link('Edit', array('action' => 'edit', $cr['Criteria']['id'])); ?>
					&nbsp; | &nbsp;   
					<?php echo $this->Html->link('Remove', array('action' => 'remove', $cr['Criteria']['id']), array(), "Are you sure to delete this criteria?"); ?>
				</div>  				
  			</td>
  		</tr>
  	<?php
  		endforeach;
  	?>
  </tbody>
</table>
<!-- end core table-->
<?php echo $this->element('paginator_info'); ?>

<?php echo $this->element('paginator'); ?> 