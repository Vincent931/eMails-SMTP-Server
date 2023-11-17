<?php
namespace App\Services;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class FileUploader
{
    public function upload($uploadDir, $file, $filename)
    {
        
        try {  
            
            $file->move($uploadDir, $filename);           

        } catch (FileException $e){
            //dd($e->getMessage());
            return $e->getMessage();
        }
    }
}
