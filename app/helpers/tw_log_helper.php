<?php

if (!function_exists('get_tw_logs_path')) {
    function get_tw_logs_path() {
        $configPath = defined('CONFIG_INI_PATH') ? CONFIG_INI_PATH : '';
        if (!empty($configPath)) {
            $configDir = dirname($configPath);
            if (basename($configDir) === '.secrets') {
                // If config.ini is inside .secrets/ folder, app_logs is at the same level as .secrets/
                return dirname($configDir) . DIRECTORY_SEPARATOR . 'app_logs' . DIRECTORY_SEPARATOR . 'tw_logs.text';
            }
        }
        
        // Otherwise (localhost/fallback), look for APPROOT or fallback to project root.
        if (defined('APPROOT')) {
            $projectRoot = APPROOT;
            // APPROOT is app/. Go one level up to project root.
            return dirname($projectRoot) . DIRECTORY_SEPARATOR . 'app_logs' . DIRECTORY_SEPARATOR . 'tw_logs.text';
        }
        
        $documentRoot = isset($_SERVER['DOCUMENT_ROOT']) ? rtrim($_SERVER['DOCUMENT_ROOT'], DIRECTORY_SEPARATOR) : '';
        if (!empty($documentRoot)) {
            if (basename($documentRoot) === 'public') {
                return dirname($documentRoot) . DIRECTORY_SEPARATOR . 'app_logs' . DIRECTORY_SEPARATOR . 'tw_logs.text';
            }
            return $documentRoot . DIRECTORY_SEPARATOR . 'app_logs' . DIRECTORY_SEPARATOR . 'tw_logs.text';
        }
        
        return dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'app_logs' . DIRECTORY_SEPARATOR . 'tw_logs.text';
    }
}

if (!function_exists('tw_file_put_contents')) {
    function tw_file_put_contents($filename, $data, $flags = 0, $context = null) {
        $basename = basename($filename);
        $logFiles = ['conexionError.txt', 'receiving.txt', 'cnnerror22.txt', 'stepLog.txt', 'error_log'];
        
        // Check if the filename matches a log file, or has a .txt / .text extension
        if (in_array($basename, $logFiles) || preg_match('/\.tex?t$/i', $basename)) {
            $logPath = get_tw_logs_path();
            $logDir = dirname($logPath);
            if (!is_dir($logDir)) {
                @mkdir($logDir, 0755, true);
            }
            
            $timestamp = date('Y-m-d H:i:s');
            $logMessage = "[$timestamp] [File: $filename] " . (is_string($data) ? $data : print_r($data, true));
            if (substr($logMessage, -1) !== "\n") {
                $logMessage .= "\n";
            }
            
            return file_put_contents($logPath, $logMessage, FILE_APPEND);
        }
        
        // Otherwise, it is a binary/normal file output (e.g. images, PDFs), write to the original path
        $dir = dirname($filename);
        if (!empty($dir) && !is_dir($dir)) {
            @mkdir($dir, 0755, true);
        }
        return file_put_contents($filename, $data, $flags, $context);
    }
}

if (!function_exists('write_tw_log')) {
    function write_tw_log($data, $filename = 'tw_logs.text') {
        return tw_file_put_contents($filename, $data);
    }
}
