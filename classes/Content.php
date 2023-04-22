<?php
class Content{
    private $title;
    private $lFolder;
    private $taskNumber;

    function __construct($title, $lFolder, $taskNumber){
        $this->title = $title;
        $this->lFolder = $lFolder;
        $this->taskNumber = $taskNumber;
    }
    public function printIntroPageContent(){
        $this->showHead("io_style.css", "io_effects.js");
        $lang = $_SESSION['language'];
        $points = array( 
            file_get_contents("$this->lFolder/intro1.txt", true),
            file_get_contents("$this->lFolder/intro2.txt", true),
            file_get_contents("$this->lFolder/intro3.txt", true)
        );   
        echo 
        '<body>
            <img id="intro_logobar" src="pictures/intro_logobar.svg">';
        if($lang =="PL") echo
        '   <img src="pictures/lang_chosen.svg" class="lang" id="PL"> ';
        else if($lang =="UA") echo
        '   <img src="pictures/lang_chosen.svg" class="lang" id="UA"> ';
        echo       
        '   <img id="io1" src="pictures/intro_outro1.svg">
            <img id="io2" src="pictures/intro_outro2.svg">
            <img id="io3" src="pictures/intro_outro3.svg">
            
            <div class="io" id="i1">'.$points[0].'</div> 
            <div class="io" id="i2">'.$points[1].'</div>
            <div class="io" id="i3">'.$points[2].'</div>
            <p class="clickToProceed">';
        if($lang =="PL")
            echo 'Kliknij, aby kontynuować';
        else 
            echo 'Натисніть, щоб продовжити';  
        echo 
            '</p>
            <div id="circle"></div>
            <button id="next"></button>
            <form action="DemoTask.php" method="GET">
            <div class="button">
                <img src="pictures/button.svg"/>
                <button id="start">';
        if($lang =="PL")
            echo'Zobacz przykład';
        else 
            echo'Дивіться приклад';
        echo        '<img src="pictures/batton_arrow.svg">
                </button>
            </div>
            </form> 
            <form action = "Intro.php" method = "POST">'; 
        if($lang =="UA") echo
        '       <button class="lang" id="pl" value="submit"></button>';
        else if($lang =="PL") echo
        '       <button class="lang" id="ua" value="submit"></button>';
        echo
        '       <input type="hidden" name="chage_lang" value="true">
            </form>
        </body>
        </html>';
    }
    public function printTaskPageContent($taskNumber, $nosearch, $time){
        $lang = $_SESSION['language'];
        $this->showHead("task_page_style.css", "");
        echo
        '<body>';
        $this->showSearchField($nosearch);
        echo 
        '   <div class="task">';
        $this->showTask($time);
        echo
        '    </div>
            <form action="processTask.php" method="GET" id="table">
                <button id="next_task" value="submit">';
        if($lang =="PL")
            echo '  Zakończ zadanie';
        else
            echo '  Завершити завдання';
        echo        $this->taskNumber.'
                    <img src="pictures/batton_arrow.svg">
                </button>';
        $this->printTable();        
        echo    
            '</form>
            <div class ="vertical_line" id="top"></div>
            <div class ="vertical_line" id="bottom"></div>
        </body>
        </html>';
    }
    public function printDemoTaskPageContent($nosearch){
        $lang = $_SESSION['language'];
        $this->showHead("task_page_style.css", "demo_task_effects.js");
        echo
        '<body>';
        $this->showSearchField($nosearch);
        echo 
        '<div class="task">'.file_get_contents("$this->lFolder/demo_task.txt", true).'</div>
            <form action="JanKowalskiTask.php" method="GET" id="table">
                <button id="next_task" value="submit">';
        if($lang =="PL")
            echo  'Zakończ zadanie';
        else
            echo 'Завершити завдання';
        echo '      <img src="pictures/batton_arrow.svg">
                </button>';
        $this->printTable();        
        echo    
           '</form>
            <div class ="vertical_line" id="top"></div>
            <div class ="vertical_line" id="bottom"></div>
            <p class="clickToProceed">';
        if($lang =="PL")
            echo 'Kliknij, aby kontynuować';
        else 
            echo 'Натисніть, щоб продовжити'; 
        echo 
            '</p>
            <div id="circle"></div>
            <div id="white_rectangle"></div>
            <button id="next"></button>
            <img src="pictures/three_arrows.svg" id="three_arrows" />
        </body>
        </html>';
    }
    public function printOutroPageContent($avgPoints, $percentTime, $percentPoints){
        $avgTime = ($_SESSION['task1']['time']+$_SESSION['task2']['time']+$_SESSION['task3']['time'])/3;
        $lang = $_SESSION['language'];
        $this->showHead("io_style.css", "");
        echo 
        '<body>
            <img id="outro_bg" src="pictures/outro.svg">
            <div class="outro">
                <h1>';
            echo ($lang =="PL")?'Koniec':'Кiнець';
            echo '</h1>';
           /* echo    '<p>'.
                        file_get_contents("$this->lFolder/Outro.txt", true).
                    '</p>';*/

                                echo "Task number: ".$_SESSION['curretTaskNumber'];
                                echo "Nosearch number: ".$_SESSION['nosearch'];
                                echo "<br> Answer: ". $_SESSION['task'.$_SESSION['curretTaskNumber']]['answer'];
                                echo "<br> Completed: ";
                                if($_SESSION['task'.$_SESSION['curretTaskNumber']]['completed'])
                                    echo "true";
                                else 
                                    echo "false";
                                echo "<br><br>TASK1:<br>";
                                var_dump($_SESSION['task1']);
                                
                                if(isset($_SESSION['task2'])){
                                    echo "<br><br>TASK2:<br>";
                                    var_dump($_SESSION['task2']);
                                }
                                if(isset($_SESSION['task3'])){
                                    echo "<br><br>TASK3:<br>";
                                    var_dump($_SESSION['task3']);
                                }
        echo
        '   </div>  
            <h1 id="result">';
        echo ($lang =="PL")?'Twoj wynik':'Результат';
        echo
        '   </h1>
            <div class="interp" id="r_time">
                <p>';
            echo ($lang =="PL")?'Czas wykonania:':'Час виконання:';
        echo'   </p>
                <h3><b>';
        echo    $avgTime.'</b>';
        echo ($lang =="PL")?' sec':' с.';
        echo'   </h3>
            </div>

            <p class="interp" id="i_time">
                 Ukonczyles zadania srednio szybciej niz '.$percentTime.'% uczestnikow 
            </p>
            <img 
                class="bar" id="avg_time" 
                style="clip: rect(0px,'. 4*$percentTime.'px,5vh,0px);" 
                src="pictures/outro_bar.svg"
            />
            <div 
                class="bar_indicator" id="time" 
                style="transform: translate('. 4*$percentTime-35 .'px ,-1vh);"
            >'.
                $percentTime.'%
            </div>

            <div class="interp" id="r_points">
                <p>';
        echo ($lang =="PL")?'Poprawnosc:':'Правильність:';
        echo'   </p>
                <h3><b>';
        echo $avgPoints.'</b>';
        echo ($lang =="PL")?' pkt':' бал.';
        echo'   </h3>
            </div>
            <p class="interp" id="i_points"> 
                Dostales za zadania srednio wiecej punktow niz '.$percentPoints.'% uczestnikow 
            </p>
            <img 
                class="bar" id="avg_points" 
                style="clip: rect(0px,'. 4*$percentPoints.'px,5vh,0px);" 
                src="pictures/outro_bar.svg"
            />
            <div 
                class="bar_indicator" id="points" 
                style="transform: translate('. 4*$percentPoints-35 .'px ,-1vh);"
            >'.
                $percentPoints.'%
            </div>

            <form action="Intro.php" method="GET">
            <div class="button" id="outro">
                <img src="pictures/button.svg"/>
                <button id="start" value="submit">';
        echo ($lang =="PL")?'Zakończ i wyjdź':'Завершити i вийти';
        echo        '<img src="pictures/batton_arrow.svg">
                </button>
            </div>
            </form> 
        </body>
        </html>';
    } 
    private function printTable(){
        require('classes/TextsFromDataBase.php');
        $text = new TextsFromDataBase($this->taskNumber);
        if(isset($_POST['search']) || isset($_POST['nosearch']))
            $text->printSortedTexts();
        else 
            $text->printUnsortedTexts();
    }
    private function showHead($style, $jquery){
        echo   '<!DOCTYPE html>
                <html lang="pl">
                <head>
                <meta charset="UTF-8">
                <meta http-equiv="Content-type" content="text/html; charset=utf-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                	
                <link href="http://fonts.googleapis.com/css?family=Andika&subset=latin,latin-ext" rel="stylesheet" type="text/css">
                <link rel ="stylesheet" href="styles/';
        echo    $style;
        echo    '" type="text/css">';
        echo    $jquery != ""?    
                    '<script
                        src="https://code.jquery.com/jquery-3.5.1.min.js"
                        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
                        crossorigin="anonymous">
                    </script>
                    <script src ="classes/'.$jquery.'"></script>'
                :'';
        echo   '<title>'.$this->title.'</title>
                </head>';
    }
    private function showSearchField($nosearch){
        $taskLink = array("","JanKowalskiTask.php", 'AgnieszkaTask.php', 'BarbaraTask.php');
         
        echo '  <form action="'.$taskLink[$this->taskNumber].'" method="POST" id="search">
                    <div class="search">
                        <input type="text" name = "search" placeholder="search" autocomplete="off"';
        if(!$nosearch)echo ' style="width: 54.5vh;"';
        echo '          >
                    </div>
                    <button class="bSearch" value="submit"';
        if(!$nosearch)echo ' style="transform: translateX(57.3vh);"';
        echo '      > 
                        <img id="nosearch_icon" src = "pictures/magnifierP.svg">
                    </button>';
        if($nosearch) echo '  <div class="nosearch"><input type="text" name="nosearch" placeholder="nosearch" autocomplete="off"></div>';
        echo '  </form>';
    }
    private function showTask($time){
        $tasks = array( 
            file_get_contents("$this->lFolder/Introduction.txt", true),
            file_get_contents("$this->lFolder/Jan_Kowalski_task.txt", true),
            file_get_contents("$this->lFolder/Agnieszka_task.txt", true),
            file_get_contents("$this->lFolder/Barbara_task.txt", true)
        );   
        echo '  <p>'.$tasks[$this->taskNumber].'</p>';
        echo '  <p id="time">'.$time.'</p> 
                <script src="classes/timer.js"></script>';
    }
}
?>