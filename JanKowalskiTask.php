<?php
    session_start();
    require('classes/SessionControl.php');
    $session1 = new SessionControl(1);

    require('classes/Content.php'); 
    $content1 = new Content('Zadane Jana', $session1->langFolder(), 1);
    $session1->startTimer(); 
    $nosearch = ($_SESSION['nosearch'] == 4 || $_SESSION['nosearch'] == 5 || $_SESSION['nosearch'] == 6);
    $content1->printTaskPageContent(1, $nosearch, $session1->getTime()); 
?>