<ul class="dropdown-menu menudesplegable">
<?php
foreach ( $edificios as $edificio ) :
?>
	<li><a href="#"><?=$edificio->nombre?></a></li>
<?php	endforeach; ?>
</ul>