<?php

declare(strict_types=1);


namespace App\Core;

class Config
{
    public static function getEnv(): array
    {
        $env = __DIR__ . '/../../.env';

        $config = [];

        $file_handle = fopen($env, "r");
        while (!feof($file_handle)) {
            $line = trim(fgets($file_handle));
            if ($line !== '') {
                list($key, $value) = explode('=', $line);
                $config[$key] = $value;
            }
        }
        fclose($file_handle);

        return $config;
    }

    public static function getEnvValue(string $envKey)
    {
        $config = self::getEnv();
        return $config[$envKey] ?? "Enviroinments value not found";
    }
}