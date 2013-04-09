<?php
class Util {
    public static function TextToHtml($text) {
        $text = Util::cleanup($text);
	    $text = htmlspecialchars($text, ENT_COMPAT, "UTF-8");
	    $text = str_replace("\n", "<br />", $text);
	    return $text;
    }
    
    
    // Basic markup, based on markdown
    public static function MarkupToHtml($text) {
        $text = Util::cleanup($text);
        $text = preg_replace('/^[ ]+$/m', '', $text);
        
        // Headers
        preg_match_all ("/(^|\n)([=]+)(.*?)(\n)/", $text, $matches, PREG_SET_ORDER);
        foreach ($matches as $val) {
            $num = intval(strlen($val[2])) + 2;
            if ($num > 5) {
                $num = 5;
            }
            $text = preg_replace("/" . $val[0] . "/", "<h" . $num . ">" . trim($val[3]) . "</h" . $num .">", $text);
        }
        
        // Bold
        //preg_match_all ("([*])(.*?)([*])", $text, $matches, PREG_SET_ORDER);
        //foreach ($matches as $val) {
        //    $text = preg_replace("/" . $val[0] . "/", "<strong>" . trim($val[0]) . "</strong>", $text);
        //}
        
        
        return $text;
    }
    
    
    public static function cleanup($text) {
        $text = preg_replace('{^\xEF\xBB\xBF|\x1A}', '', $text);
        $text = preg_replace('{\r\n?}', "\n", $text);
        $text = trim($text);
        $text .= "\n\n";
        return $text;
    }
}



