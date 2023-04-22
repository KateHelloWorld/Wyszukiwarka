<?php
    session_start();
    // kontrola sesji
    require('classes/SessionControl.php');
    $sessionO = new SessionControl(0);
    $sessionO->stopTimer();
    $sessionO->completeTask();

    require('classes/Content.php');
    $contentO = new Content('Outro', $sessionO->langFolder(), 0);
    $contentO->printOutroPageContent(15.35, 45, 75);
    $sessionO->completeAll();
?>