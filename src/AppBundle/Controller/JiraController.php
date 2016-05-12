<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Jira\JiraManager;
use AppBundle\Entity\Jira\JiraStory;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Response;

class JiraController extends Controller
{
    /**
     * @param string $story
     * @return JiraStory Response
     */
    public function fetchStoryDetailsAction($story)
    {
        $jiraUri = $this->container->getParameter('uri.jira');
        $jiraManager = new JiraManager($jiraUri);

        try {
            $response = [
                'storyData' => $jiraManager->getJiraStory($story)->toArray(),
            ];
        } catch (Exception $ex) {
            $response = [
                'message' => $ex->getMessage(),
            ];
        }

        return new Response(json_encode($response));
    }
}