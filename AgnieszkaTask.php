<?php
    session_start();
    require('classes/SessionControl.php');
    $session2 = new SessionControl(2);
    require('classes/Content.php');
    $content2 = new Content('Zadane Jana', $session2->langFolder(), 2);
    $session2->startTimer();
    $nosearch = ($_SESSION['nosearch'] == 2 || $_SESSION['nosearch'] == 3 || $_SESSION['nosearch'] == 6);
    $content2->printTaskPageContent(2, $nosearch, $session2->getTime());  
?>
                