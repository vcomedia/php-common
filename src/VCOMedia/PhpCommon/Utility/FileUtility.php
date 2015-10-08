<?php
namespace VCOMedia\PhpCommon\Utility;

class FileUtility {
    public static function getSHA1Filename ($filename) {
        $filename = sha1(uniqid(rand(), true)) . '.' . pathinfo($filename, PATHINFO_EXTENSION);
        return $filename;
    }
    
    public static function sanitize_file_name ($filename) {
        $filename_raw = $filename;
        $special_chars = array("?" , "[" , "]" , "/" , "\\" , "=" , "<" , ">" , ":" , ";" , "," , "'" , "\"" , "&" , "$" , "#" , "*" , "(" , ")" , "|" , "~" , "`" , "!" , "{" , "}" , chr(0));
        $filename = str_replace($special_chars, '', $filename);
        $filename = StringUtility::removeAccents($filename);
        $filename = preg_replace('/[\s-]+/', '-', $filename);
        $filename = trim($filename, '.-_');
        $filename = StringUtility::convert_smart_quotes($filename);
        
        // Split the filename into a base and extension[s]
        $parts = explode('.', $filename);
        // Return if only one extension
        if (count($parts) <= 2)
            return $filename;
            // Process multiple extensions
        $filename = array_shift($parts);
        $extension = array_pop($parts);
        $mimes = static::get_allowed_mime_types();
        // Loop over any intermediate extensions.  Munge them with a trailing underscore if they are a 2 - 5 character
        // long alpha string not in the extension whitelist.
        foreach ((array) $parts as $part) {
            $filename .= '.' . $part;
            if (preg_match("/^[a-zA-Z]{2,5}\d?$/", $part)) {
                $allowed = false;
                foreach ($mimes as $ext_preg => $mime_match) {
                    $ext_preg = '!(^' . $ext_preg . ')$!i';
                    if (preg_match($ext_preg, $part)) {
                        $allowed = true;
                        break;
                    }
                }
                if (! $allowed)
                    $filename .= '_';
            }
        }
        $filename .= '.' . $extension;
        return $filename;
    }
    
    private static function get_allowed_mime_types() {
        $mimes = array(
        'jpg|jpeg|jpe' => 'image/jpeg',
        'gif' => 'image/gif',
        'png' => 'image/png',
        'bmp' => 'image/bmp',
        'tif|tiff' => 'image/tiff',
        'ico' => 'image/x-icon',
        'asf|asx|wax|wmv|wmx' => 'video/asf',
        'avi' => 'video/avi',
        'divx' => 'video/divx',
        'flv' => 'video/x-flv',
        'mov|qt' => 'video/quicktime',
        'mpeg|mpg|mpe' => 'video/mpeg',
        'txt|c|cc|h' => 'text/plain',
        'rtx' => 'text/richtext',
        'css' => 'text/css',
        'htm|html' => 'text/html',
        'mp3|m4a' => 'audio/mpeg',
        'mp4|m4v' => 'video/mp4',
        'ra|ram' => 'audio/x-realaudio',
        'wav' => 'audio/wav',
        'ogg' => 'audio/ogg',
        'mid|midi' => 'audio/midi',
        'wma' => 'audio/wma',
        'rtf' => 'application/rtf',
        'js' => 'application/javascript',
        'pdf' => 'application/pdf',
        'doc|docx' => 'application/msword',
        'pot|pps|ppt|pptx' => 'application/vnd.ms-powerpoint',
        'wri' => 'application/vnd.ms-write',
        'xla|xls|xlsx|xlt|xlw' => 'application/vnd.ms-excel',
        'mdb' => 'application/vnd.ms-access',
        'mpp' => 'application/vnd.ms-project',
        'swf' => 'application/x-shockwave-flash',
        'class' => 'application/java',
        'tar' => 'application/x-tar',
        'zip' => 'application/zip',
        'gz|gzip' => 'application/x-gzip',
        'exe' => 'application/x-msdownload',
        // openoffice formats
        'odt' => 'application/vnd.oasis.opendocument.text',
        'odp' => 'application/vnd.oasis.opendocument.presentation',
        'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
        'odg' => 'application/vnd.oasis.opendocument.graphics',
        'odc' => 'application/vnd.oasis.opendocument.chart',
        'odb' => 'application/vnd.oasis.opendocument.database',
        'odf' => 'application/vnd.oasis.opendocument.formula',
        );

        return $mimes;
    }
    
    public static function formatRawSize ($bytes) {
        if (! empty($bytes)) {
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
        $iterator = new \RecursiveDirectoryIterator($folderPath);
        
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