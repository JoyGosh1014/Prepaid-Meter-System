<?php  
if (count($errors) > 0): ?>
	
		<?php foreach ($errors as $error) : ?>
			<div class="alert alert-danger" role="alert">
				<?php echo $error; ?>
			</div>
		<?php endforeach; ?>
	
<?php  endif ?> 

<?php  
if (count($successes) > 0): ?>
	
		<?php foreach ($successes as $success) : ?>
			<div class="alert alert-success" role="alert">
				<?php echo $success; ?>
			</div>
		<?php endforeach; ?>
	
<?php  endif ?>

<?php  
if (count($notification_errors) > 0): ?>
	
		<?php foreach ($notification_errors as $notification_error) : ?>
			<div class="alert alert-danger" role="alert">
				<?php echo $notification_error; ?>
			</div>
		<?php endforeach; ?>
	
<?php  endif ?>


<?php  
if (count($notification_successes) > 0): ?>
	
		<?php foreach ($notification_successes as $notification_success) : ?>
			<div class="alert alert-success" role="alert">
				<?php echo $notification_success; ?>
			</div>
		<?php endforeach; ?>
	
<?php  endif ?>