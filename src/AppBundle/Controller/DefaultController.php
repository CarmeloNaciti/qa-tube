<?php

namespace AppBundle\Controller;

use AppBundle\Entity\MediaObject;
use AppBundle\Form\MediaObjectType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DefaultController
 *
 * @package AppBundle\Controller
 */
class DefaultController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $mainRepository = $this->getDoctrine()
            ->getRepository('AppBundle:MediaObject');

        $query = $mainRepository->createQueryBuilder('p')
            ->where('p.type = :views')
            ->setParameter('views', 'New Feature')
            ->orderBy('p.timestamp', 'DESC')
            ->getQuery();

        $mainEntity = $query->getResult();

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
            'mainEntity' => $mainEntity[0],
            'latestEntities' => $mainEntity,
            'trainingEntities' => $trainingEntities,
            'popularEntities' => $popularEntities,
        ]);
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addMediaObjectAction(Request $request)
    {
        $mediaObject = new MediaObject();

        $form = $this->createForm(MediaObjectType::class, $mediaObject);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $originalName = $mediaObject->getMediaFile()->getClientOriginalName();

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($mediaObject);
            $manager->flush();

            $this->addFlash('notice', 'Upload successful');

            $entity = $this->getDoctrine()
                ->getRepository('AppBundle:MediaObject')
                ->findOneBy(['mediaName' => $originalName]);

            return $this->redirectToRoute('_view_object',
                [
                    'id' => $entity->getId()
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

    /**
     * @param $id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewMediaObjectAction($id)
    {
        $entity = $this->getDoctrine()
            ->getRepository('AppBundle:MediaObject')
            ->find($id);

        $helper = $this->get('vich_uploader.templating.helper.uploader_helper');
        $path = $helper->asset($entity, 'mediaFile');

        return $this->render('default/addSuccess.html.twig',
            [
                'path' => $path,
                'title' => $entity->getTitle(),
                'description' => $entity->getDescription(),
                'tags' => explode(',', $entity->getTags()),
                'user' => $entity->getUser() . ' (' . $entity->getTeam() . ')',
                'story' => $entity->getStory() . ' on ' . $entity->getEnvironment() . ' (' . $entity->getType() . ')',
                'date' => $entity->getTimestamp(),
            ]
        );
    }

    public function searchAction($searchterm)
    {
        $repository = $this->getDoctrine()
            ->getRepository('AppBundle:MediaObject');

        $query = $repository->createQueryBuilder('p')
            ->where('LOWER(p.title) LIKE :searchterm')
            ->setParameter('searchterm', '%'.$searchterm.'%')
            ->orderBy('p.title', 'ASC')
            ->getQuery();

        $result = $query->getResult();

        return $this->render('default/search.html.twig',
            [
                'result' => $result,
                'searchresult' => $searchterm,
            ]
        );
    }
}
