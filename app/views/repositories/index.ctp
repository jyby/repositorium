<?php $r = $repository['Repository']; ?>


<h1 class="h1icon"><?php echo ucwords($r['name']) . ' Repository'; ?></h1>

<p style="padding: 1em;">  <?php echo str_replace('\n', '<br />', Sanitize::html(ucfirst($r['description']))); ?> </p>

