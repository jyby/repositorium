<?php 
$title = 'Download Documents';
$this->viewVars['title_for_layout'] = $title; 
?>

<?php echo $this->Html->image('docs.png',array('class' => 'imgicon')) ; ?>

<h1 class="h1icon"><?php echo $title; ?></h1>
<div class="clearicon"></div>

<div style="padding: 1em 0"><span class="info">Congratulations! Here you have <?php echo count($docs); ?> documents to download: </span></div>
<div><span style="font-weight: bold; padding-right: 0.5em">Notice:</span><span>You just have this opportunity! if you reload this page, you will have to search and pass a challenge again (if you had to do it before to reach here)</span></div>
<br />
<?php foreach($docs as $d): ?>
<div class="bordered padded">
	<span style="font-weight:bold"  class="admin-doc-titulo">
		<?php echo $d['Document']['title'];?>
	</span>
	<div class="admin-doc-texto">	
		<?php 
		echo str_replace(
				"\n", 
				'<br />', 
				Sanitize::html($d['Document']['content']));
		?>
					
		</div>
		<div class="components">
		<?php
			foreach ($constituents as $constituent){
				echo $this->element($constituent['Constituent']['sysname'].'/show', array("files"=>$d['files']));
			} 
		?>
		</div>
		<div class="created-by">
			Created on <?php echo $d['Document']['created']; ?> by <?php echo $d['Document']['nombre_autor']; ?>. 
		</div>
	<hr />
</div>
<?php endforeach;?>

