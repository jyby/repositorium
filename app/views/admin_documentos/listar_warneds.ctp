<?php App::import('Sanitize'); ?>
<script type="text/javascript">
var document1="";		//id Selected document that may be duplicated (left table)
var document2="";		//id Selected document that triggered duplicate warning (right table)
	$(document).ready(function() {		
		$("#select-all").click(function() {
			var checked = this.checked;
			$(".adm-checkbox-form").each(function() {
				this.checked = checked;
				update_checked($(this));
			}).button("refresh");
		});		
		$("#adm-mass-reset").click(function(e) {			
			 e.preventDefault();
			 $("#ActionMassAction").val("reset");
			 var form = $(this).parent("form");
			 var ok = confirm("Are you sure to reset stats of selected documents?");
			 if(ok)
			 	form.submit();			 
		});
		$("#adm-mass-validate").click(function(e) {			
			 e.preventDefault();
			 $("#ActionMassAction").val("validate");
			 var form = $(this).parent("form");
			 var ok = confirm("Are you sure to (in)validate the selected documents?");
			 if(ok)
			 	form.submit();			 
		});
		$("#adm-mass-delete").click(function(e) {			
			 e.preventDefault();
			 $("#ActionMassAction").val("delete");
			 var form = $(this).parent("form");
			 var ok = confirm("Are you sure to delete selected documents?");
			 if(ok)
			 	form.submit();			 
		});

		//Add Style the checkboxes
		$("#select-all, .adm-checkbox-form").button({icons: {
		                primary: "ui-icon-check"
				            }, text: false}).addClass("adm-checkbox-form");
				            
		//Add Hover functions to rows		
		$("#tabla_documentos tbody tr").hover(hover_tr, hover_tr_out);
		
		$('#tabla_documentos tbody :checkbox').click(function() {
			update_checked($(this));
		});
		
	});

	function hover_tr(){
		$(this).addClass("table-hover");
	}
	
	function hover_tr_out(){
		$(this).removeClass("table-hover");
	}

	function update_checked(item){	
		if(item.attr("checked"))	
			item.parent().parent().parent().addClass('table-hover-checked');
		else
			item.parent().parent().parent().removeClass('table-hover-checked');
	}
	/*
			<?php
		echo'function update_warned_table(document_id){';
		echo "\n";
		//echo '<br/>' . "\n";
		echo 'var right_table = document.getElementById("tabla_documentos_2_body").value;';
		echo "\n";
		//echo 'var select_comuna = document.getElementById("Comuna");';
		echo "\n";
		$sql= "SELECT * FROM region";		
	  	$result=pg_query($db, $sql);
		
  				if  (!$result) {
   				echo "query 1 did not execute";
  				}		
				while ($row = pg_fetch_assoc($result)) {
					$id_region=$row['id'];
					$nombre_region=$row['nombre'];
					echo "if(region == \"$id_region\") {";
					echo "\n";
			$sql2= "SELECT comuna.nombre , comuna.id
				FROM comuna
				WHERE comuna.region='$id_region';
 				";
				$result2=pg_query($db,$sql2);
				$i=0;
				echo'select_comuna.options.length = 1;';
				while($row2 = pg_fetch_assoc($result2)){
					//new Option('$row2['nombre']', '$row2['nombre']');";
					echo "\n";
					echo "select_comuna.options[$i] = "; 
					$nombre_comuna=$row2['nombre'];
					$id_comuna=$row2['id'];
					echo "new Option(\"$nombre_comuna\"";
					echo ",\"$id_comuna\"); ";
					$i++;
					}
					echo'}';
					echo "\n";
}
		echo'}';
		?>
		*/
	function update_right_table(){
	if(document1!=""){
	document.getElementById("tabla_documentos_2_body").innerHTML='<tr><td>'+document1+'</td></tr>';
	}
	else{document.getElementById("tabla_documentos_2_body").innerHTML='';}
	}
	function select(tr,document_id){
	if(document1!=document_id){
	if(document1!=""){
	//tr-table-left
	document.getElementById("created-by-"+document1).setAttribute("class", "created-by");
	document.getElementById("tr-table-left-"+document1).setAttribute("class", "");
	update_right_table();
	}
	document1=document_id;
	tr.setAttribute("class", "warned-doc");
	document.getElementById("created-by-"+document_id).setAttribute("class", "created-by-selected");
	update_right_table();
	/*
	<?php $warneds= $this->requestAction('/admin_documentos/set_warned_table/document_id');
	//echo '<pre>';
	echo 'alert('.$warneds.');';
	//echo '</pre>';
	?>
	*/
	//alert(<?php echo $this->requestAction('/admin_documentos/set_warned_table/document_id');?> );
	}
	else{
	document1="";
	tr.setAttribute("class", "");
	document.getElementById("created-by-"+document_id).setAttribute("class", "created-by");
	update_right_table();
	}
	//tr.setAttribute("class", "warned-doc");
	//alert(document_id);
	
	}
</script>
<?php
	function porcentaje($q,$tot) {
		if($tot == 0)
			return 0;
		  return 100*$q/($tot);
		}
	function consenso($a,$b){
		if(($a + $b) == 0)
		  return 0;
		return 100*abs($a-$b)/($a+$b);
	}

	$en_valid = (strcmp($current,'no_validados') == 0) ? false : true; 

	if(!$en_valid) {
		$title = 'Pending validation documents';
	} else {
		if(strcmp($current,'all') == 0)
			$title = 'All documents';
		else{
			if(strcmp($current,'validados') == 0)
				$title = 'Validated Documents';
				else{$title = 'Warned Documents';}
			}
	}
	if(!$en_valid)
		$rest = 'no_validado';
	else
		$rest = 'como_desafio';

	$this->viewVars['title_for_layout'] = "Administer $title";
	
	/* breadcrumbs */
	$this->Html->addCrumb($repo['Repository']['name'], '/repositories/'.$repo['Repository']['url']);
	$this->Html->addCrumb('Manage', '/manage/');	
	$this->Html->addCrumb($title);
	/* end breadcrumbs */ 
	 

?>
<?php echo $this->Html->image('admin.png',array('class' => 'imgicon')) ; ?><h1 class="h1icon"><?php echo $title; ?></h1>
<div class="clearicon"></div>
<?php echo 
	   $this->element($menu, array(
         'current' => $current
	   ));       
?> 

<!-- expert tools -->
<div id="expert-tools">
	<div class="adm-first-row">
		<!-- number of items -->	
		<div class="adm-limit">
			<?php echo $this->Form->create(null, array('url' => '/admin_documentos/'.$current, 'name' => 'select_limit')); ?>
			<span class="adm-opt">Showing: </span>
			<?php			 
				$options = array(
					'5' => '5 documents',
					'10' => '10 documents',
					'20' => '20 documents',
					'50' => '50 documents' 
				);
				echo $this->Form->select('Document.limit', $options, $limit, array('empty' => false, 'onChange' => 'select_limit.submit()'));			   
			?>
			</form>
		</div>
		<!-- end number of items -->
		
		<!-- ordering -->
		<div class="adm-ordering">
			<?php echo $this->Form->create(null, array('url' => '/admin_documentos/'.$current, 'name' => 'ordering')); ?>
			<span class="adm-opt">Order by: </span>
			<?php
				$options = array(
					'more-ans' => 'More answers',
					'less-ans' => 'Less answers',
					'more-cs' => 'More consensus',
					'less-cs' => 'Less consensus'
				);						 
				echo $this->Form->select('CriteriasDocument.order', $options, $ordering, array('empty' => false, 'onChange' => 'ordering.submit()'));
				echo $this->Form->end(); 
			?>
		</div>
		<!-- end ordering -->
	</div>
	
	<div class="adm-second-row">
		<!-- select criteria -->
		<div class="adm-criteria">
			<?php echo $this->Form->create(null, array('url' => '/admin_documentos/'.$current, 'name' => 'select_criterio')); ?>
			<span class="adm-opt">Criteria: </span>
			<?php			 
				echo $this->Form->select('question', $criterio_list, $criterio_n, array('empty' => false, 'onChange' => 'select_criterio.submit()'));
				echo $this->Form->end(); 
			?>
		</div>
		<!-- end select criteria -->
		
		<!-- filter -->
		<div class="adm-filter">
			<?php echo $this->Form->create(null, array('url' => '/admin_documentos/'.$current, 'name' => 'select_filter')); ?>
			<span class="adm-opt">Filter by: </span>
			<?php
				$options = array(
					'all' => 'All documents',
					'app' => 'Documents with 50% or more approval',
					'dis' => 'Documents with 50% or more disapproval',
					'con' => 'Documents with 50% or more consensus',
					'don' => 'Documents with 50% or less consensus'
				);						 
				echo $this->Form->select('CriteriasDocument.filter', $options, $filter, array('empty' => false, 'onChange' => 'select_filter.submit()'));
				echo $this->Form->end(); 
			?>
		</div>
		<!-- end filter -->
				
		<!-- mass edit -->
		<div class="adm-mass">
		<?php echo $this->Form->create(null, array('id' => 'adm-process', 'url' => array('controller' => 'admin_documentos', 'action' => 'mass_edit', $criterio_n))); ?>	
			<span class="adm-opt">Selected Documents: </span>
			<?php		
				echo $this->Form->hidden('Action.mass_action');
				echo '&nbsp;&nbsp;&nbsp;';
				echo $this->Form->button('Reset stats', array('id' => 'adm-mass-reset'));
				echo '&nbsp;&nbsp;&nbsp;';
				echo $this->Form->button(($en_valid ? 'Inv' : 'V' ). 'alidate', array('id' => 'adm-mass-validate'));
				echo '&nbsp;&nbsp;&nbsp;';
				echo $this->Form->button('Delete', array('id' => 'adm-mass-delete'));
			?>
		</div>
		<!-- end mass edit-->	
	</div>
</div>
<!-- end expert tools -->
<?php
	echo '<pre>';
	echo print_r($aux);
	echo 'El data_table_right es:</br>';
	echo print_r($data_table_right);
	echo 'La variable $data tiene:</br>';
	echo print_r($data);
	foreach($data as $d):
	echo print_r($d['Document']);
	//echo print_r($data['Document']);
	endforeach;
	echo '</pre>'
	
	//<table id="tabla_documentos" class="ui-widget ui-widget-content tabla" style="width: 40% ;float:left margin-top: 10px;">
?>
<div id="DivContent"  style="margin-top: 30px;">
<!-- core table -->
<table id="tabla_documentos" class="ui-widget ui-widget-content tabla" style="width: 40% ;float:left ">
  <thead>
	<tr class="ui-widget-header">
	  <th width="55%">Document</th>
	  <th width="15%">Options</th>
	</tr>
  </thead>
  <tbody>
  <?php 
  	$i = 0;
  	foreach($data as $d):
  		$id = $d['Document']['id'];
//		class="warned-doc"
  ?>
	<tr class="" id="tr-table-left-<?php echo $id;?>" onclick="select((this),<?php echo $id;?>)">

		<td>
			<!-- doc -->
			<span class="admin-doc-titulo">
				<?php echo $this->Html->link(Sanitize::html($d['Document']['title']), array('action' => 'edit', $id, $criterio_n,0), array('escape' => false)) ;?>
			</span>
			<div class="admin-doc-texto">		
				<?php
				echo $this->Text->truncate(
					str_replace(
						'\n', 
						'<br />', 
						Sanitize::html($d['Document']['content'])), 
					350, 
					array(
						'ending' => '<a href="'.$this->Html->url(array('controller' => 'admin_documentos', 'action' => 'edit', $id, $criterio_n)).'">...</a>', 
						'exact' => false, 
						'html' => true));
						//if($d['Document']['warned_documents']==''){echo 'BLAAAAA';}
				?>				
			</div>
			<!-- <div class="created-by"> 
			<div class="created-by-selected">
			-->
			<div class="created-by" id="created-by-<?php echo $id;?>"> 
				Created on <?php echo $d['Document']['created']; ?> by <?php echo $d['Document']['nombre_autor']; ?>. 
			</div>
		</td>
		<td>
			<!-- options -->
			<div class="admin-doc-edit">
				<?php echo $this->Html->link('Edit', array('action' => 'edit', $id, $criterio_n,0)); ?>
				&nbsp; | &nbsp;   
				<?php echo $this->Html->link('Remove', array('action' => 'remove', $id), array(), "Are you sure?"); ?>
			</div>
		</td>
	</tr>  
  <?php 
  	$i += 1;
  	endforeach;
//OnClick="CheckTag(DocumentTags.value)"	
  ?>
  </tbody>
</table>
<!-- end core table -->
<?php 
//echo $this->Html->link('Edit both documents', array('action' => 'edit', $id, $criterio_n,1)); 
$one=1;
echo $this->Form->create(null, array('url' => '/admin_documentos/edit/'.$id.'/'.$criterio_n.'/'.$one,'name' => 'Compare'));
//echo $this->Form->create(null, array('url' => '/admin_documentos/'.$current, 'name' => 'ordering'));         
//echo $this->Form->end('Compare selected documentsFORM');
echo $this->Form->end();
//echo $this->Form->create(null, array('url' => '/admin_documentos/edit_select_criteria/'.$id, 'id' => 'adm-form-criteria'));
?>
<form id="sadasdasd" method="post" action="/admin_documentos/edit/<?php echo $id;?>/<?php echo $criterio_n;?>/1" accept-charset="utf-8">	
<button type="submit" id="blabla" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button"><span class="ui-button-text">DeleteBLABLA</span></button></form>

<table id="tabla_documentos_2" class="ui-widget ui-widget-content tabla" style="width: 40% ;float:right">
  <thead>
	<tr class="ui-widget-header">
	  <th width="55%">Document</th>
	  <th width="15%">Options</th>
	</tr>
  </thead>
  <tbody id="tabla_documentos_2_body">
  <?php 
  	$i = 0;
  	foreach($data_table_right[90] as $d):
	//$id = $d[0]['Document']['id'];
  		$id = $d['Document']['id'];  	
  ?>
	<tr>
		<td>
			<!-- doc -->
			<span class="admin-doc-titulo">
				<?php echo $this->Html->link(Sanitize::html($d['Document']['title']), array('action' => 'edit', $id, $criterio_n,0), array('escape' => false)) ;?>
			</span>
			<div class="admin-doc-texto">		
				<?php
				echo $this->Text->truncate(
					str_replace(
						'\n', 
						'<br />', 
						Sanitize::html($d['Document']['content'])), 
					350, 
					array(
						'ending' => '<a href="'.$this->Html->url(array('controller' => 'admin_documentos', 'action' => 'edit', $id, $criterio_n)).'">...</a>', 
						'exact' => false, 
						'html' => true));
				?>				
			</div>
			<div class="created-by">
				Created on <?php echo $d['Document']['created']; ?> by <?php echo $d['Document']['nombre_autor']; ?>. 
			</div>
		</td>
		<td>
			<!-- options -->
			<div class="admin-doc-edit">
				<?php echo $this->Html->link('Edit', array('action' => 'edit', $id, $criterio_n,0)); ?>
				&nbsp; | &nbsp;   
				<?php echo $this->Html->link('Remove', array('action' => 'remove', $id), array(), "Are you sure?"); ?>
			</div>
		</td>
	</tr>  
  <?php 
  	$i += 1;
  	endforeach; 
  ?>
  

  
  
  </tbody>
</table>
</div>
</form>
<?php echo $this->element('paginator_info'); ?>

<?php echo $this->element('paginator'); ?> 
	

 
