<?php
    session_start();
    // kontrola sesji
    require('classes/SessionControl.php');
    $sessionD = new SessionControl(0);
    require('classes/Content.php');
    $contentD = new Content('Demo', $sessionD->langFolder(), 0);
    $contentD->printDemoTaskPageContent(true);
?>
