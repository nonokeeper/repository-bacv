<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\MediaType;

class MediaController extends AbstractController
{
    /**
     * @Route("/medias", name="medias")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $base = $_GET['base'] ?? 'images/medias';
        if (strlen($base) < 13) { $base = 'images/medias'; }
        $dossierParent = substr($base, 0, strrpos($base, '/'));
        $form = $this->createForm(MediaType::class, $base);
        $form->handleRequest($request);

        $content = $this->arbo($base);
        $images = $this->testImages($base);

        return $this->render('medias/index.html.twig', [
            'content'   => $content,
            'images'    => $images,
            'base'      => $base,
            'parent'    => $dossierParent,
        ]);
    }

    private function testImages($base)
    {
        if (!is_dir($base))
            return 1;
        else {
            $dh = opendir($base);
            $dirs = array($base);
            $dir = array_pop($dirs);
            while( false !== ($file = readdir($dh)))
            {
                if ($file !== '.' && $file !== '..' && $file !== '.DS_Store')
                {
                    $path = $dir . '/' . $file;
                    if (is_dir($path)) {
                        return 0;
                    } else {
                        return 1;
                    }
                }
            }
        }
    }

    private function arbo($base)
    {
        if(! is_dir($base))
            return false;
    
        $files = [];
        $dirs = array($base);
        while( NULL !== ($dir = array_pop($dirs)))
        {
            #echo $dir;
            if( $dh = opendir($dir))
            {
                $small = '';
                $big ='';
                $tmp = '';
                while( false !== ($file = readdir($dh)) )
                {
                    if ( $file !== '.' && $file !== '..' )
                    {
                        if ($dir == $base && $file !== '.DS_Store') {
                            $path = $dir . '/' . $file;

                            // Gestion Répertoire
                            if (is_dir($path)) {
                                $files[] = $file;
                            }
                            // Gestion Images : hypothèse d'avoir le nom de la miniature = la grande + '_small'
                            // Et la même extension (format Image png/gif/jpg)
                            else { // On traite uniquement les miniatures
                                if( strstr($file, '_small')) { // Si l'image miniature est trouvée
                                    $small = $file;
                                    $big = explode('_small',$file)[0].'.'.explode('.',$file)[1];
                                    $files[] = array($small,$big);
                                }
                            }
                        }
                        $tmp = $file;
                    } 
                }
                closedir($dh);
            }
        }
        return $files;
    }
}
