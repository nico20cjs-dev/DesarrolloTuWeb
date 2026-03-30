<?php
/**
 * Build/Minification Script for Production
 * 
 * Usage:
 *   php backend/build.php              # Generate minified assets
 *   php backend/build.php --watch      # Watch mode (requires entr or similar)
 *   php backend/build.php --clean      # Remove minified files
 * 
 * Set environment before running:
 *   SET APP_ENV=production && php backend/build.php     (Windows)
 *   APP_ENV=production php backend/build.php            (Linux/Mac)
 */

require_once 'config.php';
require_once 'minify.php';

class BuildScript {
    
    public static function run() {
        $args = $GLOBALS['argv'] ?? [];
        $command = $args[1] ?? 'build';
        
        switch ($command) {
            case '--watch':
                self::watchMode();
                break;
            case '--clean':
                self::cleanMinified();
                break;
            case '--info':
                self::showInfo();
                break;
            default:
                self::build();
        }
    }
    
    /**
     * Generate minified assets
     */
    public static function build() {
        echo "🔨 Building minified assets...\n";
        echo "Environment: " . (IS_PRODUCTION ? "PRODUCTION" : "DEVELOPMENT") . "\n\n";
        
        // Minify CSS
        echo "📝 Minifying CSS... ";
        if (AssetMinifier::generateMinifiedCSS()) {
            $originalSize = filesize(ROOT_PATH . 'styles.css');
            $minifiedSize = filesize(ROOT_PATH . 'styles.min.css');
            $reduction = number_format((1 - $minifiedSize / $originalSize) * 100, 2);
            echo "✓ Done ({$reduction}% reduction)\n";
        } else {
            echo "✗ Failed\n";
        }
        
        // Minify JavaScript
        echo "📝 Minifying JavaScript... ";
        if (AssetMinifier::generateMinifiedJS()) {
            $originalSize = filesize(ROOT_PATH . 'script.js');
            $minifiedSize = filesize(ROOT_PATH . 'script.min.js');
            $reduction = number_format((1 - $minifiedSize / $originalSize) * 100, 2);
            echo "✓ Done ({$reduction}% reduction)\n";
        } else {
            echo "✗ Failed\n";
        }
        
        echo "\n✨ Build complete!\n";
    }
    
    /**
     * Watch mode for development
     */
    public static function watchMode() {
        echo "👀 Watch mode enabled. Press Ctrl+C to exit.\n";
        echo "Monitoring files for changes...\n\n";
        
        $lastCSSmtime = 0;
        $lastJSmtime = 0;
        
        while (true) {
            $cssFile = ROOT_PATH . 'styles.css';
            $jsFile = ROOT_PATH . 'script.js';
            
            $cssMtime = file_exists($cssFile) ? filemtime($cssFile) : 0;
            $jsMtime = file_exists($jsFile) ? filemtime($jsFile) : 0;
            
            if ($cssMtime > $lastCSSmtime) {
                echo "[" . date('H:i:s') . "] CSS changed, regenerating...\n";
                AssetMinifier::generateMinifiedCSS();
                $lastCSSmtime = $cssMtime;
            }
            
            if ($jsMtime > $lastJSmtime) {
                echo "[" . date('H:i:s') . "] JS changed, regenerating...\n";
                AssetMinifier::generateMinifiedJS();
                $lastJSmtime = $jsMtime;
            }
            
            sleep(2);
        }
    }
    
    /**
     * Clean up minified files
     */
    public static function cleanMinified() {
        echo "🧹 Cleaning minified files...\n";
        
        $files = [
            ROOT_PATH . 'styles.min.css',
            ROOT_PATH . 'script.min.js'
        ];
        
        foreach ($files as $file) {
            if (file_exists($file)) {
                unlink($file);
                echo "  Removed: " . basename($file) . "\n";
            }
        }
        
        echo "✓ Cleanup complete\n";
    }
    
    /**
     * Show build information
     */
    public static function showInfo() {
        echo "DesarrolloTuWeb - Build System\n";
        echo "==============================\n\n";
        
        echo "Commands:\n";
        echo "  php backend/build.php              Build minified assets\n";
        echo "  php backend/build.php --watch      Watch files for changes\n";
        echo "  php backend/build.php --clean      Remove minified files\n";
        echo "  php backend/build.php --info       Show this information\n\n";
        
        echo "Environment: " . (IS_PRODUCTION ? "PRODUCTION" : "DEVELOPMENT") . "\n";
        echo "Asset Paths:\n";
        echo "  CSS: " . CSS_PATH . "\n";
        echo "  CSS Min: " . CSS_MIN_PATH . "\n";
        echo "  JS: " . JS_PATH . "\n";
        echo "  JS Min: " . JS_MIN_PATH . "\n\n";
        
        // Show file sizes if they exist
        if (file_exists(CSS_PATH)) {
            echo "Current Sizes:\n";
            echo "  styles.css: " . round(filesize(CSS_PATH) / 1024, 2) . " KB\n";
        }
        if (file_exists(CSS_MIN_PATH)) {
            echo "  styles.min.css: " . round(filesize(CSS_MIN_PATH) / 1024, 2) . " KB\n";
        }
    }
}

// Run the build script
BuildScript::run();
?>
