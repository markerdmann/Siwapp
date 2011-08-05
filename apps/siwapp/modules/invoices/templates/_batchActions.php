<?php echo gButton_to_function(__("Delete"), "", array('class'=>'batch delete action-clear', 'confirm'=>__('Are you sure?'), 'rel'=>'batch:delete')) ?>
<?php echo gButton_to_function(__("Print"), "", 'class=batch print action-clear rel=print:html') ?>
<?php echo gButton_to_function(__("PDF"), "", 'class=batch pdf action-clear rel=print:pdf') ?>
<?php echo gButton_to_function(__("Send"), "", 'class=batch send action-clear rel=batch:email') ?>