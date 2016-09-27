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
<script>
$( "table" ).addClass( "table" );
$("table").find("a").css( "color", "black" );
$("span.delete-icon").removeClass("delete-icon").addClass("glyphicon glyphicon-trash");
$("span.read-icon").removeClass("read-icon").addClass("glyphicon glyphicon-search");
$("span.edit-icon").removeClass("edit-icon").addClass("glyphicon glyphicon-pencil");
</script>
</html>
