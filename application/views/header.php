<nav class="navbar navbar-dark bg-primary">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <a class="navbar-brand header" href="#">SAGA</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse bg-primary" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle header navclass" style=" font-size: medium;"data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Edificio <span class="caret"></span></a>
          <ul class="dropdown-menu menudesplegable">
				<?php
				foreach($edificios as $edificio):
				?>
					<li><a href="#"><?=$edificio->nombre?></a></li>
				<?php	endforeach; ?>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>