<?php
    session_start();
    require('classes/SessionControl.php');
    $session3 = new SessionControl(3);

    require('classes/Content.php');
    $content3 = new Content('Zadane Jana', $session3->langFolder(), 3);
    $session3->startTimer();
    $nosearch = ($_SESSION['nosearch'] == 1 || $_SESSION['nosearch'] == 3 || $_SESSION['nosearch'] == 5);
    $content3->printTaskPageContent(3, $nosearch, $session3->getTime());
?>