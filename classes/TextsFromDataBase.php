<?php
class TextsFromDataBase{
    private $unsortedTexts;
    private $sortedTexts;
    private $keyWordsSearch;
    private $keyWordsNosearch; 
    private $NKMR; // negative key word match rate : float
    private $tableNumber;
    
    function __construct($tableNumber){
        $this->tableNumber = $tableNumber;

        // pobiera wartosci pol wyszukiwarek ze zmiennej $_POST
        if(isset($_POST['search'])) $search = $_POST['search'];
        else $search = " ";
        if(isset($_POST['nosearch'])) $nosearch = $_POST['nosearch'];
        else $nosearch = " ";

        $this->processKeyWords($search, $nosearch);
        $this->getUnsortedTexts();
    }
    private function processKeyWords($search, $nosearch){

        // robi wszystkie litery male, usuwa znaczniki html
        $search = trim(stripslashes($search));
        $nosearch = trim(stripslashes($nosearch));
        $search = strtolower(htmlspecialchars($search));
        $nosearch = strtolower(htmlspecialchars($nosearch));

        // usuwa interpukcje i niepotrzebne spacje
        $uselessWords = array(',', '.',' i ',' oraz ',' a ','  ','   ',' ');
        for($i=0; $i<count($uselessWords); $i++)
            $nosearch = str_replace($uselessWords[$i], ' ', $nosearch);
        for($i=0; $i<count($uselessWords); $i++)
            $search = str_replace($uselessWords[$i], ' ', $search);

        $this->keyWordsSearch = explode(" ", $search);
        $this->keyWordsNosearch = explode(" ", $nosearch);
    }
    private function getUnsortedTexts(){
        @$db = new mysqli ('localhost', 'wyszukiwarka', 'root', "test" );
        $result = $db->query("SELECT * FROM test".$this->tableNumber."_".$_SESSION['language']." ORDER BY Cena"); 

        $myrow = $result->fetch_assoc();
        $this->unsortedTexts = array();
        $this->sortedTexts = array();
        foreach($result as $row){
            $record = array(
                'priority' => 0,
                'name' => $row['Nazwa']."<br>".$row["Cena"].".99 zł",
                'text' => $row["Opis"]);
            array_push($this->unsortedTexts, $record);
            array_push($this->sortedTexts, $record );
        }
    }
    public function printUnsortedTexts(){
        foreach($this->unsortedTexts as $row)
            echo 
                '<div class="option">
                <div class="checkbox">
                    <div class="container">
                        <input type="radio" name="choise" required="required" value="'.explode('<br>', $row['name'])[0].'">
                        <img src = "pictures/checkbox.svg"/>
                    </div>
                </div>
                <div class="name">'.        $row['name'].'</div>'.
                '<div class="description">'.$row['text'].'</div>'.
                '</div>';
    }
    public function printSortedTexts(){
        $this->sortTexts();
        foreach($this->sortedTexts as $row)
            echo 
                '<div class="option">
                <div class="checkbox">
                    <div class="container">
                        <input type="radio" name="choise" required="required" value="'.explode('<br>', $row['name'])[0].'">
                        <img src = "pictures/checkbox.svg"/>
                    </div>
                </div>
                <div class="name">'.        $row['priority'].'<br>'.$row['name'].'</div>'.
                '<div class="description">'.$row['text'].'</div>'.
                '</div>';
    }
    private function sortTexts(){
        for($i=0; $i<count($this->unsortedTexts); $i++)
            $this->sortedTexts[$i]['priority'] = $this->getPriority($this->unsortedTexts[$i]['text']);   
        usort($this->sortedTexts, fn($a, $b) => $b['priority'] <=> $a['priority']);
    }
    private function getPriority($text){
        $keyWordsGen = 0;
        $search = 0;
        $nosearch = 0;
        $matchRatesS = array();
        $matchRatesN = array();
        $avgRateS = 0;
        $avgRateN = 0;  

        for($i=0; $i<count($this->keyWordsSearch); $i++){
            $this->NKMR = 0;
            $greatestRate = 
                $this->getGreatestMatchRate(
                    strtolower($text), 
                    $this->keyWordsSearch[$i]
                );
            if($this->NKMR != 0){
                $keyWordsGen ++;
                $nosearch ++;
                array_push($matchRatesN, $this->NKMR);
            }
            else if($greatestRate > 0){
                $keyWordsGen ++;
                $search ++;
                array_push($matchRatesS, $greatestRate);
            } 
        }     
        for($j=0; $j<count($this->keyWordsNosearch); $j++){
            $this->NKMR = 0;
            $greatestRate = 
                $this->getGreatestMatchRate(
                    strtolower($text), 
                    $this->keyWordsNosearch[$j]
                );
            if($this->NKMR != 0){
                $keyWordsGen ++;
                $search ++;
                array_push($matchRatesS, $this->NKMR);
            }
            else if($greatestRate > 0){
                $keyWordsGen ++;
                $nosearch ++;
                array_push($matchRatesN, $greatestRate);
            } 
        }
        if(count($matchRatesS)>0)
            $avgRateS = array_sum($matchRatesS)/count($matchRatesS);
        if(count($matchRatesN)>0)
            $avgRateN = array_sum($matchRatesN)/count($matchRatesN);

        return $keyWordsGen*($search*$avgRateS - $nosearch*$avgRateN);
    }
    private function getGreatestMatchRate($text, $keyWord){
        $greatestRate = 0;
        $words = explode(" ", $text);

        foreach($words as $word){
            $rate = $this->matchRate($word, $keyWord);

            if($rate != 0 && $this->contentsNegativePrefix($word, $keyWord)){
                if($this->NKMR==0 || $this->NKMR<$rate)
                    $this->NKMR = $rate;
            }else if($rate > $greatestRate)
                $greatestRate = $rate;
        }
        return $greatestRate;
    }
    private function matchRate($word, $keyWord){
        $lettersKeyWord = mb_strlen($keyWord, "utf-8");
        $matchedLetters = 0;
        $letterIndex = 0;

        for($i=0; $i<mb_strlen($word, "utf-8"); $i++)
            if(mb_substr($keyWord, $letterIndex, 1, "utf-8") ==
                mb_substr($word, $i, 1, "utf-8") &&
                mb_substr($word, $i, 1, "utf-8") != ','
            ){
                $matchedLetters ++;
                $letterIndex ++;
                if($letterIndex >= $lettersKeyWord) 
                    break;
            }

        if($lettersKeyWord > 0 && ($matchedLetters/$lettersKeyWord >= 0.7) && 
            (mb_strlen($word, "utf-8")/$lettersKeyWord <= 1.5))
                return $matchedLetters/$lettersKeyWord;
        else 
            return 0;
    }
    private function contentsNegativePrefix($word, $keyWord){
        // zwraca true, gdy $word zaczyna sie od przyrostka negatywnego, a $keyWord - nie
        $negativePrefixes = array(
            'a', 'an', 'anty', 'ant', 'bez', 'beze', 'dys', 'dyz', 'in', 'ir', 'im', 'kontr',
            'kontra','nie', 'ni','niedo','non','od','ode','poza','przeciw', 'roz','roze'
        );
        for($i=0; $i<count($negativePrefixes); $i++)
            if((strpos($word, $negativePrefixes[$i]) === 0) &&
            (strpos($keyWord, $negativePrefixes[$i]) !== 0))
                return true;
        return false;   
    }  
}
?>
