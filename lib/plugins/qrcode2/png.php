<?php
    require_once('phpqrcode.php');
    // outputs image directly into browser, as PNG stream
    QRcode::png($_GET['id']); 
?>
