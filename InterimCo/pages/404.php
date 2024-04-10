<?php

$title = 'Page not found';
if(!isset($_SESSION['authenticated_user'])) {
    include(__DIR__ . '/../_public_header.php');
}else{
    include(__DIR__ . '/../_header.php');
}
?>
    <h1>Page not found</h1>
    <p>Sorry, we could not find the page you requested.</p>
<?php
include(__DIR__ . '/../_footer.php');