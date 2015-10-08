<?php
namespace VCOMedia\PhpCommon\Utility;

class FileUtility {

    public static function formatRawSize ($bytes) {
        // CHECK TO MAKE SURE A NUMBER WAS SENT
        if (! empty($bytes)) {
            
            // SET TEXT TITLES TO SHOW AT EACH LEVEL
            $s = array(
                'bytes',
                'KB',
                'MB',
                'GB',
                'TB',
                'PB'
            );
            $e = floor(log($bytes) / log(1024));
            return sprintf('%.0f', ($bytes / pow(1024, floor($e)))) . $s[$e];
        } else {
            return 0;
        }
    }

    public static function getLastFileModifiedTimeRecursive ($folderPath) {
        $iterator = new RecursiveDirectoryIterator($folderPath);
        
        $mtime = - 1;
        $file = null;

        foreach (new RecursiveIteratorIterator($iterator) as $fileinfo) {
            if ($fileinfo->isFile()) {
                if ($fileinfo->getMTime() > $mtime) {
                    $file = $fileinfo->getFilename();
                    $mtime = $fileinfo->getMTime();
                }
            }
        }
        return $mtime;
    }
    
    public static function rmdirRecursive($dir) {
       if (is_dir($dir)) {
         $objects = scandir($dir);
         foreach ($objects as $object) {
           if ($object != "." && $object != "..") {
             if (filetype($dir."/".$object) == "dir"){
                rrmdir($dir."/".$object);
             }else{ 
                unlink($dir."/".$object);
             }
           }
         }
         reset($objects);
         rmdir($dir);
      }
    }
    
    public static function secure_tmpname($postfix = '.tmp', $prefix = 'tmp', $dir = null) {
        // validate arguments
        if (! (isset($postfix) && is_string($postfix))) {
            return false;
        }
        if (! (isset($prefix) && is_string($prefix))) {
            return false;
        }
        if (!isset($dir)) {
            $dir = sys_get_temp_dir();
        }
    
        // find a temporary name
        $tries = 1;
        do {
            // get a known, unique temporary file name
            $sysFileName = tempnam($dir, $prefix);
            if ($sysFileName === false) {
                return false;
            }
    
            // tack on the extension
            $newFileName = $sysFileName . $postfix;
            if ($sysFileName == $newFileName) {
                return $sysFileName;
            }
    
            // move or point the created temporary file to the new filename
            // NOTE: these fail if the new file name exist
            $newFileCreated = (static::isWindows() ? @rename($sysFileName, $newFileName) : @link($sysFileName, $newFileName));
            
            if ($newFileCreated) {
                return $newFileName;
            }
    
            unlink ($sysFileName);
            $tries++;
        } while ($tries <= 5);
    
        return false;
    }
    
    public static function isWindows() {
        return (DS == '\\' ? true : false);
    }
}