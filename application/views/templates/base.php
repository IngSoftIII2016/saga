<!DOCTYPE html>
<html>
<head>
    <?php
    $this->load->view ( 'css-script' );
     ?>
</head>
<body>
<?php
$this->load->view ( 'header' );?>

<div>
   <?php $this->load->view( $body, $data ) ?>
</div>

</body>
</html>
