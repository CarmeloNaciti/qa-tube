<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Jira\JiraManager;
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
        $latestEntity = $manager->getLatestResult();
        $trainingEntities = $manager->getResultByType('Training');
        $popularEntities = $manager->getPopularResults();        

        return $this->render('default/index.html.twig', [
            'latestEntities' => $latestEntity,
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
            $entityId = $entity->getId();

            if ($mediaObject->getIsSignOff()) {
                $videoUri = $request->getHost() . $this->get('router')->generate('_view_object', [
                    'id' => $entityId
                ]);

                $jiraUri = $this->container->getParameter('uri.jira');
                $jiraManager = new JiraManager($jiraUri);

                $jiraManager->addJiraComment($mediaObject->getStory(), $mediaObject->getEnvironment() . " sign off link -> $videoUri");
            }

            return $this->redirectToRoute('_view_object',
                [
                    'id' => $entityId
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

    /**
     * @param Request $request
     * @param $id
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
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
        $searchTerm = urldecode($searchTerm);

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
