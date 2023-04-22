<?php
class SessionControl{

    function __construct($taskNumber){
        $_SESSION['curretTaskNumber'] = $taskNumber;  
        $_SESSION['task'.$_SESSION['curretTaskNumber']] = 
        array('completed'=>false, 'time'=>"", 'answer'=>"");
    }
    public function completeTask(){
        if(isset($_GET['choise'])){ 
            $_SESSION['task'.$_SESSION['curretTaskNumber']]['answer'] = $_GET['choise'];
            $_SESSION['task'.$_SESSION['curretTaskNumber']]['completed'] = true;
        }
        //else
            //$this->noAnswerAlert();
    }
    public function startTimer(){
        if(!isset($_SESSION['timerSet'])){
            $_SESSION['time'] = microtime(true);
            $_SESSION['task'.$_SESSION['curretTaskNumber']]['time'] = microtime(true) - $_SESSION['time'];
            $_SESSION['timerSet'] = true;
        }
    }
    public function getTime(){
        return round(microtime(true) - $_SESSION['time'], 0);
    }
    public function stopTimer(){
        $_SESSION['task'.$_SESSION['curretTaskNumber']]['time'] = $this->getTime();
        unset($_SESSION['timerSet']);
    }
    public function completeAll(){
        @$db = new mysqli ('localhost', 'wyszukiwarka', 'root', "test" );
        $query= "INSERT INTO odpowiedzi (ID, odp1, czas1, odp2, czas2, odp3, czas3, nosearch) 
                 VALUES (NULL, '".$_SESSION['task1']['answer']."', '".$_SESSION['task1']['time']."', '".
                                  $_SESSION['task2']['answer']."', '".$_SESSION['task2']['time']."', '".
                                  $_SESSION['task3']['answer']."', '".$_SESSION['task3']['time']."', '".
                                  $_SESSION['nosearch']."')";

        $result = $db->query($query);
        if($result)
            echo "<br><b>Zapisano do bazy danych pomyslnie</b><br>";
        else 
            echo "<br><b>Blad zapisu odpowiedzi</b><br>";
        session_abort();
        session_unset();
    }
    public function setLanguage($lang){
        if($lang == "UA") 
            $_SESSION['language'] = "UA";
        else if ($lang == "PL")
            $_SESSION['language'] = "PL";
    }
    public function langFolder(){
        if(!isset($_SESSION['language']))
            $this->setLanguage("PL");
        if($_SESSION['language'] == "PL")
            return "polish_texts";
        else 
            return "ukrainian_texts";
        
    }
    private function sessionOk(){
        if(isset($_SESSION['tasks'])) 
            return true;
        sessionNotOkAlert();
        return false;
    }
}
?>