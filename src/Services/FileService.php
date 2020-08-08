<?php


namespace App\Services;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FileService extends  AbstractController
{

    public function uploadFile($file)
    {

        $uploads_directory = $this->getParameter('uploads_directory');
        $filename = md5(uniqid()) . '.' . $file->guessExtension();
        $file->move(
            $uploads_directory,
            $filename
        );
    }
}