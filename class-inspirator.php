<?php
class Inspirator {
    private $data;
    private $saved = array();

    function __construct() {
        $this->data = json_decode(file_get_contents("data.json"), true);
    }

    private function randword($subject) {
        if ( ($subject == "subject") && isset($this->saved["subject"])) {
            $rand = rand(1,2);
            if ($rand == 1) {
                return $this->saved["subject"];
            } else {
                $a = $this->data["alternative_subject"];
                return $a[array_rand($a)];
            }
        }
        
        $a = $this->data[$subject];
        $word = $a[array_rand($a)];
        
        if ($subject == "subject")  {
            $this->saved["subject"] = $word;
        }
        
        return $word;
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
        $sentence = $this->randword("template");

        preg_match_all("!\{([^{]*)\}!", $sentence, $matches);

        $words = array_map(array($this, "randword"), $matches[1]);

        foreach ($matches[0] as $i => $m) {
            $sentence = $this->replaceOnce($m, $words[$i], $sentence);
        }

        echo $sentence;
    }
}