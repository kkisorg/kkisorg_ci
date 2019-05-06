<!--// s-status-msgs //-->
<?php $perrors = @trim(validation_errors());?>

<?php if (!empty($error_message)) : ?>
<?php $perrors .= '<div>'.$error_message.'</div>'; ?>
<?php endif; ?>

<?php if ($this->session->flashdata('error_msg')) : ?>
<?php $perrors .= '<div>'.$this->session->flashdata('error_msg').'</div>'; ?>
<?php endif; ?>

<?php if (strlen($perrors) > 0) : ?>

<div class="alert alert-danger"> 
	<p class="cite"> 
	  <?= $perrors ?>
	</p>
</div>
	
<?php endif; ?>

<?php $psuccess=null; if ($this->session->flashdata('success_msg')) : ?>
<?php $psuccess .= '<div>'.$this->session->flashdata('success_msg').'</div>' ?>
<?php endif; ?>
<?php if (strlen($psuccess) > 0) : ?>

<div class="alert alert-success"> 
	<p class="cite"> 
		<?= $psuccess ?>
	</p>
</div>

<?php endif; ?>
<!--// e-status-msgs //-->