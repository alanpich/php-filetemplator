<?php
namespace AlanPich\FileTemplator;

class Skeleton
{
    protected $directories = array();
    protected $files = array();
    protected $paramPostfix;
    protected $paramPrefix;

    public function __construct($paramPrefix,$paramPostfix)
    {
        $this->paramPrefix = $paramPrefix;
        $this->paramPostfix = $paramPostfix;
    }

    public function addDirectory($path)
    {
        $this->directories[] = $path;
    }

    public function addFile($path,$srcPath)
    {
        $this->files[$path] = $srcPath;
    }


    public function output($rootPath,$params = array())
    {
        if(!is_dir($rootPath))
            mkdir($rootPath,0755,true);

        // Output directories first
        foreach($this->directories as $dir)
        {
            $dirPath = $rootPath .DIRECTORY_SEPARATOR. $this->replace($dir,$params);
            if(!is_dir($dirPath))
                mkdir($dirPath,0755,true);
        }

        // Now do files
        foreach($this->files as $relPath => $absPath)
        {
            $filePath = $rootPath .DIRECTORY_SEPARATOR. $this->replace($relPath,$params);
            $content = $this->replace(file_get_contents($absPath),$params);
            file_put_contents($filePath,$content);
        }
    }


    protected function replace($str, array $params)
    {
        foreach($params as $key => $val)
        {
            $key = $this->paramPrefix.$key.$this->paramPostfix;
            $str = str_replace($key,$val,$str);
        }
        return $str;
    }
} 