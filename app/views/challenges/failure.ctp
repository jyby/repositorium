<?php echo $this->Html->image('warning.png',array('class' => 'imgicon')) ; ?>

<h1 class="h1icon">  
	Challenge Incorrect :(
</h1>
<div class="clearicon"></div>

<span class="sorry">Sorry, you didn't answer the challenge correctly. <?php echo $this->Html->link('Maybe you want to try again?', array('controller' => 'documents', 'action' => $this->Session->read('Action.type'))); ?></span>
