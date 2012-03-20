<?php App::import('Sanitize'); ?>
<script type="text/javascript">
var document1="";		//id Selected document that may be duplicated (left table)
var document2="";		//id Selected document that triggered duplicate warning (right table)
var w_ids=new Array();
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
	
	function update_right_table(){
	if(document1!=""){

	<?php 
  	foreach($data_table_right as $key => $d):
		echo 'var warned_list_'.$key.'=new Array();';	//lista array
		echo 'warned_list_'.$key.'_id=new Array();';
		echo 'warned_list_'.$key.'_content=new Array();';
		echo 'warned_list_'.$key.'_created=new Array();';
		echo 'warned_list_'.$key.'_nombre_autor=new Array();';
		$i = 0;
		foreach($d as $doc):
		echo 'warned_list_'.$key.'['.$i.']="'. $doc["Document"]["title"].'";';
		echo 'warned_list_'.$key.'_id['.$i.']="'. $doc["Document"]["id"].'";';
		echo 'warned_list_'.$key.'_content['.$i.']="'. $doc["Document"]["content"].'";';
		echo 'warned_list_'.$key.'_created['.$i.']="'. $doc["Document"]["created"].'";';
		echo 'warned_list_'.$key.'_nombre_autor['.$i.']="'. $doc["Document"]["nombre_autor"].'";';	
		$i += 1;
		endforeach;
		echo "\n";
	
  	endforeach;
	echo 'document.getElementById("tabla_documentos_2_body").innerHTML="";';
	echo "\n";
	$j=0;
	foreach($data_table_right as $key => $d):
	$tmp_ids=explode(',',$aux[$key]);
	echo 'if(document1=='.$key.'){';
	echo "\n";
	echo 'var i=0;';
	echo 'for(i=0;i<warned_list_'.$key.'.length;i++){';
	echo "\n";
	echo 'w_ids[i]= warned_list_'.$key.'_id[i];';
	echo 'var aux = warned_list_'.$key.'_id[i];';
	echo 'var aux1 = "tr-table-right-aux"+i;';
	echo "\n";
	echo "document.getElementById('tabla_documentos_2_body').innerHTML+='<tr id=";
	echo "tr-table-right-aux";
	echo '>';
	echo '<td><span class=';
	echo '"admin-doc-titulo"';
	echo "><a href=";
	//echo '"/admin_documentos/edit/id/criterio/0"';
	echo '"/admin_documentos/edit"';
	echo ">'";
	//echo "+warned_list_".$key."[i]+'</a></span>";
	echo "+warned_list_".$key."[i]+'</a></span>";
	
	echo '<div class=';
	echo '"admin-doc-texto"';
	echo ">'";
	echo "+warned_list_".$key."_content[i]+'</div>";
	echo '<div class=';
	echo '"created-by"';
	echo ">";
	echo "Created on '";
	echo "+warned_list_".$key."_created[i]+' by '+warned_list_".$key."_nombre_autor[i]+'</div>";
	echo "</td>";
	/*
	echo '<td><div class=';
	echo '"admin-doc-edit"';
	echo "><a href=";
	echo '"/admin_documentos/edit"';
	echo ">'";
	echo "+'Edit</a>";
	echo '&nbsp; | &nbsp;';
	echo "<a href=";
	echo '"/admin_documentos/remove"';
	echo ">'";
	echo "+'Remove</a>";
	echo "</div>";
	*/
	echo "</tr>';";	
	$j += 1;
	echo '}';
	echo '}';
	echo "\n";
	endforeach;
  ?>
$( "#tabla_documentos_2 tbody tr").each(
	function( intIndex ){
	$( this ).bind (
	"click",
	function(){
	select_right($(this),w_ids[intIndex]);
	});
	$(this).attr("id","tr-table-right-"+w_ids[intIndex]);
	});
$( "#tabla_documentos_2 tbody div").each(
	function( intIndex ){
	//if((intIndex-1)%3==0){
	if((intIndex-1)%2==0){
	$(this).attr("id","created-by-right-"+w_ids[(intIndex-1)/2]);
	}
	});
	//alert($(this));
	$("#tabla_documentos_2 tbody tr").hover(hover_tr, hover_tr_out);
	}	//if
	else{document.getElementById("tabla_documentos_2_body").innerHTML='';}
	}
	
	function select(tr,document_id){
	if(document1!=document_id){
	if(document1!=""){
	document.getElementById("created-by-"+document1).setAttribute("class", "created-by");
	document.getElementById("tr-table-left-"+document1).setAttribute("class", "");
	}
	document1=document_id;
	tr.setAttribute("class", "warned-doc");
	document.getElementById("created-by-"+document_id).setAttribute("class", "created-by-selected");
	update_right_table();
	//alert(<?php echo $this->requestAction('/admin_documentos/set_warned_table/document_id');?> );
	}
	else{
	document1="";
	tr.setAttribute("class", "");
	document.getElementById("created-by-"+document_id).setAttribute("class", "created-by");
	update_right_table();
	disable_cmp();
	}
	}
	function set_cmp_link(doc_left_id,doc_right_id){
	var cmp=document.getElementById("form_button");
	//cmp.setAttribute("action","http://www.u-cursos.cl");
	cmp.setAttribute("action","/admin_documentos/edit/"+document1+"/"+<?php echo $criterio_n;?>+"/1/"+document1+"/"+document2);
	}
	function enable_cmp(){
	var cmp_button=document.getElementById("compare_button");
	$(cmp_button).removeAttr("disabled");
	$(cmp_button).removeAttr("aria-disabled");
	$(cmp_button).removeClass("ui-button-disabled");
	$(cmp_button).removeClass("ui-state-disabled");
	$(cmp_button).hover(
	function () {
    $(this).addClass("ui-state-hover");
		},
	function () {
    $(this).removeClass("ui-state-hover");
		}
	);
	set_cmp_link(document1,document2);
	}
	function disable_cmp(){
	var cmp_button=document.getElementById("compare_button");
	cmp_button.setAttribute("disabled","disabled");
	cmp_button.setAttribute("aria-disabled","true");
	$(cmp_button).addClass("ui-button-disabled ui-state-disabled");
	}
	function select_right(tr,document_id){

	if(document2!=document_id){
	if(document2!=""){
	document.getElementById("created-by-right-"+document2).setAttribute("class", "created-by");
	document.getElementById("tr-table-right-"+document2).setAttribute("class", "");
	}
	document2=document_id;
	$(tr).addClass("warned-doc");
	document.getElementById("created-by-right-"+document_id).setAttribute("class", "created-by-selected");
	enable_cmp();
	}
	else{
	disable_cmp();
	document2="";
	$(tr).removeClass("warned-doc");
	document.getElementById("created-by-right-"+document_id).setAttribute("class", "created-by");
	}
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
<?php
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
  ?>
  </tbody>
</table>
<!-- end core table -->
<?php 
//echo $this->Html->link('Edit both documents', array('action' => 'edit', $id, $criterio_n,1)); 
$one=1;
echo $this->Form->create(null, array('url' => '/admin_documentos/edit/'.$id.'/'.$criterio_n.'/'.$one,'name' => 'Compare'));
echo $this->Form->end();
//echo $this->Form->create(null, array('url' => '/admin_documentos/edit_select_criteria/'.$id, 'id' => 'adm-form-criteria'));
?>


<table id="tabla_documentos_2" class="ui-widget ui-widget-content tabla" style="width: 40% ;float:right">
  <thead>
	<tr class="ui-widget-header">
	  <th width="55%">Document</th>
	  <!--<th width="15%">Options</th>-->
	</tr>
  </thead>
  <tbody id="tabla_documentos_2_body">
</tbody>
</table>
<form id="form_button" method="post" action="/admin_documentos/edit/<?php echo $id;?>/<?php echo $criterio_n;?>/1" accept-charset="utf-8">	
<button type="submit"  style="width: 20%" id="compare_button" disabled="disabled" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button"><span class="ui-button-text">Compare selected documents</span></button></form>
</div>
</form>