<?php

namespace Lifestutor\PhotoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PhotoController extends Controller
{
    /**
     * Stream a photo
     * 
     * @param  string $filename Filename of the photo in the filesystem.
     * 
     * @return stream
     */
    public function streamAction($filename)
    {
        $response = new StreamedResponse();
        $response->setCallback(function () use ($filename) {
            $path = $this->get('kernel')->getRootDir() . '/../web' . $this->getRequest()->getBasePath() . '/uploads/book_photos';
            echo readfile("{$path}/{$filename}");
            flush();
        });
        return $response->send();
    }
}
