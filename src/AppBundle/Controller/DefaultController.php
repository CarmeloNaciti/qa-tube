<?php

namespace AppBundle\Controller;

use AppBundle\Entity\MediaObject;
use AppBundle\Form\MediaObjectType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        echo 'Index';
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
        ]);
    }

    public function addMediaObjectAction(Request $request)
    {
        $mediaObject = new MediaObject();

        $form = $this->createForm(MediaObjectType::class, $mediaObject);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($mediaObject);
            $manager->flush();

            return $this->redirectToRoute('_media_add_success');
        }

        return $this->render(
            'default/addMediaObject.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }

    public function succussfullyAddedMediaAction()
    {
        return $this->render('default/addSuccess.html.twig');
    }
}
