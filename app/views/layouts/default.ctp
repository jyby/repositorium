<?php
/**
 * default.ctp
 * 
 * layout principal del sitio
 * 
 * @package   views
 * @author    Mauricio Quezada <mquezada@dcc.uchile.cl>
 */
?>
<!DOCTYPE html>
<html>
<head>
  <?php echo $this->Html->charset(); ?>
  <title><?php echo $title_for_layout; ?></title>
  <?php 
	  echo $this->Html->meta('icon');
      //echo $this->Html->css('reset');
      //echo $this->Html->css('style');
      //echo $this->Html->css('tabla');
      echo $this->Html->css('reset-fonts-grids.css');      
      //Include JQuery & JQueryUI
      echo $this->Html->script('jquery.min');
      echo $this->Html->script('jquery-ui-1.8.13.custom.min');
      echo $this->Html->css('anchors');
      echo $this->Html->css('jqueryui');
	  echo $this->Html->css('style2');
	  
      echo $scripts_for_layout;
      //Include TextBoxList
      echo $this->Html->script('GrowingInput');
      echo $this->Html->script('TextboxList');
      echo $this->Html->css('TextboxList');
      echo $this->Html->script('TextboxList.Autocomplete');
 ?>
  <script type="text/javascript" language="javascript">
  	$(document).ready(function() {
  		$('.textboxlist-autocomplete-results').hide();
  	});
  	
	function add_textboxlist(selector){ 
		$("" + selector).textboxlist({
			unique : true,
			bitsOptions : {
				editable : {
					addOnBlur : true, 
					addKeys : [188]					
					}},
			plugins: {
				autocomplete: {
					minLength: 3,
					queryRemote: true,
					remote: {
						url: '<?php echo $this->Html->url(array('controller' => 'tags', 'action' => 'autocomplete')); ?>'					
					}
			}}});
	}
	
	//Improve the flashMessage
	$("#flashMessage").addClass("ui-state-highlight ui-corner-all flash-style");

	//Convert submit buttons to JQueryUI buttons
	$(function () {
		$(":submit").button();
		//add classes to textboxes
		$(":text, :password, textarea, select").addClass("text ui-widget-content ui-corner-all");
		//$(".textboxlist").addClass("");
		$("#flashMessage").addClass("ui-state-highlight ui-corner-all flash-style");	
});
  </script>
</head>
<body>
    <div id="doc3">
        <div id="hd">
            <div class="header">
                <div class="logo">
                    <?php echo $this->Repo->normal_link($this->Html->image('logo2.png'), '/', array('escape'=>false)); ?>
                    <?php
                    	if($this->Session->read('Repository.name')) {
                    ?> 
                   		<span class="repo-span"><?php echo $this->Repo->link(ucwords($this->Session->read('Repository.name')) . ' repository', $this->Session->read('Repository.current'));?></span>                    		
                    <?php } ?>
                </div>
                <div class="box userbox">
                    <ul class="nav topmenu">
                        <?php if(!$this->Session->check('User.id')) { ?>
                        <li><?php echo $this->Html->link('Sign up', array('controller' => 'register'), array('escape' => false)); ?></li>
                        <li><?php echo $this->Html->link('Log in', array('controller' => 'login'), array('escape' => false)); ?></li>
                        <?php } else {
                            $nombre = $this->Session->read('User.first_name');
                            $points = $this->Session->read('User.points');
                        ?>
                        <li>Hey, <?php echo $nombre.'!' . $points;?></li>
                        <li><?php echo $this->Html->link('Edit profile', array('controller' => 'users', 'action' => 'edit')); ?></li>
                        <li><?php echo $this->Html->link('Logout', '/logout'); ?></li>
                        <?php } ?>
                        &nbsp;&nbsp;
                    </ul>
                </div>
                <div class="box optionsbox">
                    <!--<div class="nav form">                    	
                        &nbsp;&nbsp;&nbsp;
                    </div>-->
                    <ul class="nav subtopmenu">
                        <?php if($this->Session->read('User.esExperto')): ?>
	                    <li><?php echo $this->Html->link('Manage Repository', array('controller' => 'admin_documentos'));?></li>
                    	<?php endif; ?>
                    	
                    	<?php if($this->Session->read('User.esAdmin')): ?>
	                    <li><?php echo $this->Html->link('Manage Site', array('controller' => 'admin_repositories'));?></li>
                    	<?php endif; ?>
                    	
                    	<li><?php echo $this->Html->link('Search', array('controller' => 'tags', 'action' => 'index')); ?></li>
                    	
                        <li><?php echo $this->Html->link('Add document', array('controller' => 'documents', 'action' => 'upload'));?></li>
                        <?php if($this->Session->check('User.id') and $this->Session->read('User.id') > 1): ?>
                        <li><?php echo $this->Html->link('Earn points', array('controller' => 'points', 'action' => 'earn')); ?></li>
                        <?php endif; ?>
                        &nbsp;&nbsp;
                    </ul>                    
                </div>
            </div>
        </div>

        <div id="bd">   
            <div class="content">
	          <!-- real content -->
	          <div id="breadcrumb"><?php echo $this->Html->getCrumbs(' > ','Home'); ?></div>
			  <?php echo $this->Session->flash(); ?>
	          <?php echo $content_for_layout; ?>
	          <?php if(Configure::read('debug') > 0) { ?>
		          <!-- debug -->
		          <h1><a onclick="javascript:$('#debugbox').toggle()" style="cursor: pointer">Toggle Debug</a></h1>
	          	  <h1><a onclick="javascript:$('#sqlbox').toggle()" style="cursor: pointer">Toggle SQL</a></h1>
		          <div class="debug" id="sqlbox" style="display:none">
			        <?php echo $this->element('sql_dump'); ?>
		          </div>
	          <?php
         		   echo '<div class="debug" id="debugbox" style="display:none">';
		           $vars = $this->getVars();
		           foreach($vars as $var) { 
	                 pr($var); pr($$var);
	               }
		           echo '</div>';
		         }
	           ?>
            </div>
    	</div>

        <div id="ft">
            <div class="footer">
            	<div class="box footerbox">
            		<ul class="footernav">
            			<li><a href="http://github.com/jyby/repositorium/issues/new" target="_blank">Report a bug</a></li>
            		</ul>
            	</div>
            </div>
        </div>
    </div>
</body>
</html>
