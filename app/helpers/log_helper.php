<?php

if (!function_exists('app_log_base_dir')) {
    function app_log_base_dir()
    {
        $configPath = defined('CONFIG_INI_PATH') ? CONFIG_INI_PATH : '';
        $isLocalhost = defined('IS_LOCALHOST') ? IS_LOCALHOST : false;

        if (!empty($configPath)) {
            if ($isLocalhost) {
                return dirname($configPath);
            }

            $configDir = dirname($configPath);
            if (basename($configDir) === '.secrets') {
                return dirname($configDir) . DIRECTORY_SEPARATOR . 'logs';
            }

            return $configDir . DIRECTORY_SEPARATOR . 'logs';
        }

        $documentRoot = isset($_SERVER['DOCUMENT_ROOT']) ? rtrim($_SERVER['DOCUMENT_ROOT'], DIRECTORY_SEPARATOR) : '';
        if (!empty($documentRoot)) {
            if ($isLocalhost) {
                return $documentRoot;
            }

            return dirname($documentRoot) . DIRECTORY_SEPARATOR . 'logs';
        }

        return dirname(dirname(__DIR__));
    }
}

if (!function_exists('app_log')) {
    function app_log($message, $fileName = 'stepLog.txt', $truncate = false)
    {
        $baseDir = app_log_base_dir();
        if (!is_dir($baseDir)) {
            @mkdir($baseDir, 0755, true);
        }

        $path = $baseDir . DIRECTORY_SEPARATOR . $fileName;
        $line = (string) $message;
        if ($line === '' || substr($line, -1) !== "\n") {
            $line .= "\n";
        }

        $flags = $truncate ? 0 : FILE_APPEND;
        return @file_put_contents($path, $line, $flags);
    }
}

if (!function_exists('step_log')) {
    function step_log($message, $truncate = false)
    {
        return app_log($message, 'stepLog.txt', $truncate);
    }
}
