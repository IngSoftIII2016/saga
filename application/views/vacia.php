<!DOCTYPE html>
<html>
<head>
<?php 
$this->load->view ( 'css-script' );
foreach($css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
<?php foreach($js_files as $file): ?>
	<script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>
</head>
<body>
<?php 
$this->load->view ( 'header' );?>

    <div>
		<?php echo $output; ?>
    </div>
 
</body> 
</html>
