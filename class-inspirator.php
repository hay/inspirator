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

    private function parseTemplate($template, $options) {
        preg_match_all("!\{([^{]*)\}!", $template, $matches);

        $replacements = array();
        for ($i = 0; $i < count($matches[1]); $i++) {
            $key = $matches[1][$i];
            if (isset($options[$key])) {
                $val = $matches[0][$i];
                $template = str_replace($val, $options[$key], $template);
            }
        }

        return $template;
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
            $sentence = str_replace($m, $words[$i], $sentence);
        }

        echo $sentence;
    }
}