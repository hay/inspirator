<?php
class Inspirator {
    private $data;

    function __construct() {
        $this->data = json_decode(file_get_contents("data.json"), true);
    }

    private function randword($subject) {
        $a = $this->data[$subject];
        return $a[array_rand($a)];
    }
    
    private function replaceOnce($needle, $replace, $haystack) {
        $pos = strpos($haystack, $needle); 
        if ($pos === false) { 
            // Nothing found 
            return $haystack; 
        } 
        return substr_replace($haystack, $replace, $pos, strlen($needle)); 
    }          

    public function getSentence() {
        $sentence = "" .
        "This {subject} is made of {production_method} {material}. " .
        "{situation_verb} {situation}. It was inspired by {inspiration} and ".
        "therefore it is {description}, {description} and {description}. " .
        "This {alternative_subject} {slogan}.";

        preg_match_all("!\{([^{]*)\}!", $sentence, $matches);

        $words = array_map(array($this, "randword"), $matches[1]);

        foreach ($matches[0] as $i => $m) {
            $sentence = $this->replaceOnce($m, $words[$i], $sentence);
        }

        echo $sentence;
    }
}