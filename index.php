<?php
    session_start();
    require('classes/SessionControl.php');
    $sessionI = new SessionControl(0);
    $_SESSION['nosearch'] = rand(1, 6);
    
    // ustawia jezyk
    if(!isset($_SESSION['language']))
        if(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) == "pl")
            $sessionI->setLanguage("PL");
        else
            $sessionI->setLanguage("UA");  
    else if(isset($_POST["chage_lang"]))
        if($_SESSION['language'] == "UA")
            $sessionI->setLanguage("PL");
        else 
            $sessionI->setLanguage("UA");

    require('classes/Content.php');
    $contentI = new Content('Intro', $sessionI->langFolder(), 0);
    $contentI->printIntroPageContent();
    echo $_SESSION['nosearch'];
?>
