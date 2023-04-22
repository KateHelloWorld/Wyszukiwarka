<?php
    session_start(); 
    require('classes/SessionControl.php');
    $session = new SessionControl($_SESSION['curretTaskNumber']);
    $session->stopTimer();
    $session->completeTask();

    $nextTaskLink = array('','AgnieszkaTask.php', 'BarbaraTask.php', 'Outro.php');
    header("Location: http://localhost/wyszukiwarka/".$nextTaskLink[$_SESSION['curretTaskNumber']]);
    exit();
?>