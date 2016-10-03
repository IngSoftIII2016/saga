<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>Sistema SAGA | Login</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url('assets/css/bootstrap.css') ?>" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        
    <!-- Custom styles for this template -->
    <link href="<?php echo base_url('assets/css/style.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/style-responsive.css') ?>" rel="stylesheet">
    
    <!-- start: Favicon -->
	<link rel="shortcut icon" href="<?php echo base_url('assets/img/favicon.ico') ?>">
	<!-- end: Favicon -->
    
</head>
<body>
	<div id="login-page">
		<div class="container">
	  		<form id="form-login" class="form-login" action="<?php echo base_url('/login'); ?>" method="POST">
		    	<h2 class="form-login-heading">SAGA - Ingreso</h2>
		        <div class="login-wrap">
		        	<input type="text" class="form-control" placeholder="Email" autofocus name="identity" value id="identity" required>
		            <br>
		            <input type="password" class="form-control" placeholder="Constraseña" name="password" value id="password" required>
		            <label class="checkbox">
						Recuédame 
						<?php echo form_checkbox('remember', '1', FALSE, 'id="remember"style="right: 200px;"');?>
						<span class="pull-right">
		                    <a data-toggle="modal" href="#myModal"> ¿Olvidó su contraseña?</a>
		                </span>

		            </label>
		           <?php echo "<span style=color:red;>".$message."</span>";?>
		            <button class="btn btn-theme btn-block" href="index.html" type="submit"><i class="fa fa-lock"></i> Iniciar Sesión</button>	            
				
			

				
				
		            <!--
		            
		            Casillero de login con redes sociales
		            
		            <div class="login-social-link centered">
		            	<p>o puede iniciar sesión también por</p>
		                <button class="btn btn-facebook" type="button"><i class="fa fa-facebook"></i> Facebook</button>
						<button class="btn btn-google" type="button"><i class="fa fa-google-plus"></i> Google</button>
		                <button class="btn btn-twitter" type="button"><i class="fa fa-twitter"></i> Twitter</button>
		            </div>
		            
		             -->
		            
		        </div>
			</form>	  	
		        <!-- Modal -->
		        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
			        <div class="modal-dialog">
		    	        <div class="modal-content">
		                	<div class="modal-header">
		                    	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		                        <h4 class="modal-title">¿Olvidó su contraseña?</h4>
		                    </div>
							<?php //echo form_open("auth/forgot_password");?>
		                    <div class="modal-body">
								<div id="infoMessage"><?php echo $message;?></div>
		                        <p>Función no disponible por el momento</p>
								<!--
								<p>Por favor, introduce tu Email para que podamos enviarte un email y  restablecer tu contraseña.</p>
		                        <input type="text" name="email" placeholder="Email" autocomplete="off" class="form-control placeholder-no-fix" value id="email">
		                    	-->
		                    </div>
		                    <div class="modal-footer">
		                        <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
		                        <button class="btn btn-theme" name="submit" type="submit">Submit</button>
		                	</div>
							<?php //echo form_close();?>
		            	</div>
		        	</div>
		        </div>		    		
		</div>
	</div>

    <!-- js placed at the end of the document so the pages load faster -->
    <!-- jQuery 2.1.4 -->
	<script src="<?php echo base_url('assets/plugins/jQuery/jQuery-2.1.4.min.js') ?>"></script>
    <!-- Bootstrap 3.3.5 -->
	<script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>

    <!--BACKSTRETCH-->
    <!-- You can use an image of whatever size. This script will stretch to fit in any screen size.-->
    <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.backstretch.min.js') ?>"></script>
    <script>
        $.backstretch("<?php echo base_url('assets/img/20years.jpg') ?>", {speed: 500, centeredX: true, centeredY: false});
    </script>


  </body>
</html>