<?php

namespace AppBundle\Controller;

use AppBundle\Entity\MediaObject;
use AppBundle\Form\MediaObjectType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
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
        $manager = $this->get('query.manager');
        $mainEntity = $manager->getFeaturedResult();
        $trainingEntities = $manager->getResultByType('Training');
        $popularEntities = $manager->getPopularResults();        

        return $this->render('default/index.html.twig', [
            'mainEntity' => (!empty($mainEntity)) ? $mainEntity[0] : null,
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
    public function addObjectAction(Request $request)
    {
        $mediaObject = new MediaObject();

        $form = $this->createForm(MediaObjectType::class, $mediaObject);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->get('query.manager');

            $manager->saveEntity($mediaObject);

            $entity = $manager->getEntityByColumn('mediaName', $mediaObject->getMediaName());

            return $this->redirectToRoute('_view_object',
                [
                    'id' => $entity->getId()
                ]
            );
        }

        return $this->render(
            'default/object.add.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }

    public function editObjectAction(Request $request, $id)
    {
        $entity = $this->get('query.manager')->getEntityById($id);

        $form = $this->createForm(MediaObjectType::class, $entity);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->get('query.manager')->saveEntity($entity);

            return $this->redirectToRoute('_view_object', ['id' => $id]);
        }

        return $this->render(
            'default/object.add.html.twig',
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
    public function viewObjectAction($id)
    {
        $manager = $this->get('query.manager');
        $em = $manager->getEntityManager();
        $entity = $manager->getEntityById($id);

        $helper = $this->get('vich_uploader.templating.helper.uploader_helper');
        $path = $helper->asset($entity, 'mediaFile');

        $entity->setViews($entity->getViews() + 1);
        $em->flush();

        return $this->render('default/object.view.html.twig',
            [
                'path' => $path,
                'entity' => $entity,
                'tags' => explode(',', $entity->getTags()),
            ]
        );
    }

    /**
     * @param $searchTerm
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function searchAction($searchTerm)
    {
        $result = $this->get('query.manager')->getSearchResults($searchTerm);

        return $this->render('default/search.results.html.twig',
            [
                'result' => $result,
                'searchresult' => $searchTerm,
            ]
        );
    }

    /**
     * @param $id
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteObjectAction($id)
    {
        $manager = $this->get('query.manager');
        $entity = $manager->getEntityById($id);

        if (!$entity) {
            return new JsonResponse(['deleted' => false]);
        }

        $manager->deleteEntity($entity);

        return new JsonResponse(['deleted' => true]);
    }
}
