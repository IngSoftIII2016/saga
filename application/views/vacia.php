<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>SAGA</title>
<!-- Tell the browser to be responsive to screen width -->
<meta
	content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"
	name="viewport">
<!-- Bootstrap 3.3.5 -->
<link rel="stylesheet"
	href="<?php echo base_url('assets/css/bootstrap.min.css') ?>">
<!-- Font Awesome -->
<link rel="stylesheet"
	href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<!-- Ionicons -->
<link rel="stylesheet"
	href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<!-- Theme style -->
<link rel="stylesheet"
	href="<?php echo base_url('assets/css/AdminLTE.min.css') ?>">
<!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
<link rel="stylesheet"
	href="<?php echo base_url('assets/css/skins/_all-skins.min.css') ?>">
<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet"
	href="<?php echo base_url('assets/plugins/iCheck/all.css') ?>">

<!-- jvectormap -->
<link rel="stylesheet"
	href="<?php echo base_url('assets/plugins/jvectormap/jquery-jvectormap-1.2.2.css') ?>">

<!-- DataTables -->
<link rel="stylesheet"
	href="<?php echo base_url('assets/plugins/datatables/dataTables.bootstrap.css') ?>">
<link rel="stylesheet"
	href="https://cdn.datatables.net/buttons/1.1.0/css/buttons.dataTables.min.css" />

<!-- Sweet Alert Styles -->
<link
	href="<?php echo base_url('assets/plugins/sweetalert/sweetalert.css') ?>"
	rel="stylesheet">
<!-- end: CSS -->
<!-- start: Favicon -->
<link rel="shortcut icon"
	href="<?php echo base_url('assets/img/favicon.ico') ?>">
<!-- end: Favicon -->

<!-- jQuery 2.1.4 -->
<script
	src="<?php echo base_url('assets/plugins/jQuery/jQuery-2.1.4.min.js') ?>"></script>
<!-- jQuery UI 1.11.4 -->
<script
	src="<?php echo base_url('assets/plugins/jQueryUI/jquery-ui.min.js');?>">
</script>
<script
	src="<?php echo base_url('assets/plugins/slimScroll/jquery.slimscroll.min.js');?>">
</script>
<!-- Bootstrap 3.3.5 -->
<script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>
<script type="text/javascript"
	src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script
	src="<?php echo base_url('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js'); ?>">
</script>
<script
	src="<?php echo base_url('assets/js/jquery.sticky.js'); ?>">
</script>

<script
	src="<?php echo base_url('assets/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.es.js'); ?>"
	charset="UTF-8"></script>

<link rel="stylesheet" type="text/css"
	href="<?php echo base_url('assets/plugins/bootstrap-datepicker/css/datepicker.css'); ?>" />
<link rel="stylesheet"
	href="<?php echo base_url('assets/css/planilla.css') ?>">
<script type="text/javascript" >
	var base_url = "<?= base_url(); ?>"; // URL base, usada en buscador-and-modal.js
</script>
<meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php 
foreach($css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
<?php foreach($js_files as $file): ?>
	<script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>
</head>
<body>
 <?php $this->load->view ( 'header' );?>

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
