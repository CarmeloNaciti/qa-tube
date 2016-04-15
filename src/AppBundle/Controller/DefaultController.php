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
        $latestEntities = $this->getDoctrine()
            ->getRepository('AppBundle:MediaObject')
            ->findBy(['type' => 'New Feature']);

        $popularRepository = $this->getDoctrine()
            ->getRepository('AppBundle:MediaObject');

        $query = $popularRepository->createQueryBuilder('p')
            ->where('p.views > :views')
            ->setParameter('views', '10')
            ->orderBy('p.views', 'ASC')
            ->getQuery();

        $popularEntities = $query->getResult();

        $trainingEntities = $this->getDoctrine()
            ->getRepository('AppBundle:MediaObject')
            ->findBy(['type' => 'Training']);

        return $this->render('default/index.html.twig', [
            'latestEntities' => $latestEntities,
            'trainingEntities' => $trainingEntities,
            'popularEntities' => $popularEntities,
            'mimeType' => "video/mp4",
        ]);
    }

    public function addMediaObjectAction(Request $request)
    {
        $mediaObject = new MediaObject();

        $form = $this->createForm(MediaObjectType::class, $mediaObject);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $originalName = $mediaObject->getMediaFile()->getClientOriginalName();
            $mimeType = $mediaObject->getMediaFile()->getMimeType();

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($mediaObject);
            $manager->flush();

            $this->addFlash('notice', 'Upload successful');

            $entity = $this->getDoctrine()
                ->getRepository('AppBundle:MediaObject')
                ->findOneBy(['mediaName' => $originalName]);

            return $this->redirectToRoute('_view_object',
                [
                    'id' => $entity->getId(),
                    'mimeType' => $mimeType,
                ]
            );
        }

        return $this->render(
            'default/addMediaObject.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }

    public function viewMediaObjectAction(Request $request, $id)
    {
        $mimeType = $request->get('mimeType');

        $entity = $this->getDoctrine()
            ->getRepository('AppBundle:MediaObject')
            ->find($id);

        $helper = $this->get('vich_uploader.templating.helper.uploader_helper');
        $path = $helper->asset($entity, 'mediaFile');

        return $this->render('default/addSuccess.html.twig',
            [
                'path' => $path,
                'mimeType' => $mimeType,
            ]
        );
    }
}
