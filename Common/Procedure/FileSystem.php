<?php
declare(strict_types=1);

if (false === \function_exists('mkDir_R')) {
    /**
     * @param string $path
     *
     * @return string
     */
    function mk_file_if_not_exist(string $path): string
    {
        if (false === \is_file($path)) {
            $dir = \dirname($path);
            if (false === \is_dir($dir)) {
                \mkdir($dir, 0777, true);
            }

            \fclose(\fopen($path, 'w+'));
        }

        return $path;
    }
}