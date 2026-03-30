<?php
/**
 * Minification utilities for CSS and JavaScript
 */

class AssetMinifier {
    
    /**
     * Minify CSS
     */
    public static function minifyCSS($css) {
        // Remove comments
        $css = preg_replace('!/\*[^*]*\*+(?:[^/*][^*]*\*+)*/!', '', $css);
        
        // Remove whitespace
        $css = preg_replace('/\s+/', ' ', $css);
        
        // Remove spaces around special characters
        $css = preg_replace('/\s*([{}:;,>+~])\s*/', '$1', $css);
        
        // Remove unnecessary last semicolon
        $css = preg_replace('/;}/', '}', $css);
        
        return trim($css);
    }
    
    /**
     * Minify JavaScript (basic)
     * For production, consider using a proper JS minifier like UglifyJS
     */
    public static function minifyJS($js) {
        // Remove single-line comments
        $js = preg_replace('|//.*?$|m', '', $js);
        
        // Remove multi-line comments
        $js = preg_replace('!/\*.*?\*/!s', '', $js);
        
        // Remove whitespace (but preserve space after keywords)
        $js = preg_replace('/\s+/', ' ', $js);
        
        // Remove spaces around special characters
        $js = preg_replace('/\s*([{}():;,=\[\]<>+\-*/%!&|?:])\s*/', '$1', $js);
        
        return trim($js);
    }
    
    /**
     * Generate minified CSS file
     */
    public static function generateMinifiedCSS() {
        $cssFile = ROOT_PATH . 'styles.css';
        $minFile = ROOT_PATH . 'styles.min.css';
        
        if (file_exists($cssFile)) {
            $css = file_get_contents($cssFile);
            $minified = self::minifyCSS($css);
            file_put_contents($minFile, $minified);
            return true;
        }
        return false;
    }
    
    /**
     * Generate minified JavaScript file
     */
    public static function generateMinifiedJS() {
        $jsFile = ROOT_PATH . 'script.js';
        $minFile = ROOT_PATH . 'script.min.js';
        
        if (file_exists($jsFile)) {
            $js = file_get_contents($jsFile);
            $minified = self::minifyJS($js);
            file_put_contents($minFile, $minified);
            return true;
        }
        return false;
    }
    
    /**
     * Generate all minified assets
     */
    public static function generateAllMinified() {
        return self::generateMinifiedCSS() && self::generateMinifiedJS();
    }
}
?>
