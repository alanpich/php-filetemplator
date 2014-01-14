<?php
namespace AlanPich\FileTemplator;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class FileTemplator
{
    protected $templatePath;

    protected $paramPrefix = '__';
    protected $paramPostfix = '__';

    /**
     * Parse a template folder to return a skeleton
     * object ready for writing to filesystem
     *
     * @param string $tplFolder Path to template folder relative to $templatePath
     * @return Skeleton
     */
    public function getSkeleton($tplFolder)
    {
        $skeleton = new Skeleton($this->paramPrefix,$this->paramPostfix);
        $fs = new Filesystem();
        $files = new Finder();

        $tplFolder = $fs->isAbsolutePath($tplFolder)? $tplFolder : $this->templatePath.DIRECTORY_SEPARATOR.$tplFolder;
        foreach($files->in($tplFolder) as $file)
        {
            /** @var SplFileInfo $file */
            $relativePath = $fs->makePathRelative($file->getPath(),$tplFolder).  $file->getFilename();
            $absolutePath = $file->getPath() .DIRECTORY_SEPARATOR. $file->getFilename();
            if($file->isDir()){
                $skeleton->addDirectory($relativePath);
            } else {
                $skeleton->addFile($relativePath,$absolutePath);
            }
        }


        return $skeleton;
    }






    /**
     * @param mixed $templatePath
     */
    public function setTemplatePath($templatePath)
    {
        $this->templatePath = $templatePath;
    }

    /**
     * @return mixed
     */
    public function getTemplatePath()
    {
        return $this->templatePath;
    }

    /**
     * @param string $paramPostfix
     */
    public function setParamPostfix($paramPostfix)
    {
        $this->paramPostfix = $paramPostfix;
    }

    /**
     * @return string
     */
    public function getParamPostfix()
    {
        return $this->paramPostfix;
    }

    /**
     * @param string $paramPrefix
     */
    public function setParamPrefix($paramPrefix)
    {
        $this->paramPrefix = $paramPrefix;
    }

    /**
     * @return string
     */
    public function getParamPrefix()
    {
        return $this->paramPrefix;
    }






} 