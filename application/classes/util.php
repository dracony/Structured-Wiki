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
        
        // Make it html safe
        $text = htmlentities($text, ENT_QUOTES, "UTF-8");
        
        // Add a newline after headers
        // so paragraphs work properly. Should figure out regex so it doesn't
        // add an extra \n if its not needed
        $text = preg_replace('{(^|\n)([=]+)(.*?)(\n)}', "$0\n", $text);
            

        // Paragraphs
        // Ignore header lines
        $text = preg_replace_callback(
            '/(\n\n|^)(?=([^=][^=][^=][^=][^=][^=][^=]))((.|\n.)+)(?=(\n\n|$))/',
            function ($match) {
                $content = trim($match[0]);
                if (strlen($content) > 0) {
                    return "\n<div class='para'>" . $content . "</div>\n";
                } else {
                    return "";
                }
            },
            $text
        );

        // Headers
        // This works, but is there a cleaner way to go about it
        $text = preg_replace_callback(
            '/(^|\n)([=]+)(.*?)(\n|$)/',
            function ($match) {
                $num = min(intval(strlen($match[2])) + 2, 6);
                return "\n<h" . $num . ">" . trim($match[3]) . "</h" . $num .">\n";
            },
            $text
        );
        
        // Bold
        $text = preg_replace('{([*])(.*?)([*])}', '<strong>$2</strong>', $text);
        
        // Italic
        $text = preg_replace('{([_])(.*?)([_])}', '<em>$2</em>', $text);
        
        // mono
        $text = preg_replace('{([`])(.*?)([`])}', "<span style='font-family:monospace;'>$2</span>", $text);
        
        // bar
        $text = preg_replace('{(\n|^)([-]+)(\n|$)}', "<hr />", $text);

//        print "\n\n\n\n[" . $text . ']';
        
        return "\n" . trim($text) . "\n";
    }    
    
    public static function cleanup($text) {
        $text = preg_replace('{^\xEF\xBB\xBF|\x1A}', '', $text);
        $text = preg_replace('{\r\n?}', "\n", $text);
        $text = trim($text);
        $text .= "\n";
        return $text;
    }
}



