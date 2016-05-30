<?php

namespace AppBundle\Entity\Jira;

use Jira_Api;
use Jira_Api_Authentication_Basic;
use Jira_Api_Result;
use Symfony\Component\Config\Definition\Exception\Exception;

class JiraManager
{
    /**
     * @var Jira_Api
     */
    private $jiraApi;

    /**
     * @param string $jiraUri
     */
    public function __construct($jiraUri)
    {
        $this->jiraApi = new Jira_Api($jiraUri, new Jira_Api_Authentication_Basic("le-rouxe", "Canb3rra3"));
    }

    /**
     * @param string $storyNumber
     *
     * @return JiraStory
     */
    public function getJiraStory($storyNumber)
    {
        /** @var Jira_Api_Result $story */
        $story = $this->jiraApi->getIssue($storyNumber)->getResult();

        if (isset($story['errors'])) {
            throw new Exception(implode('.', $story['errorMessages']));
        }

        return new JiraStory($story);
    }

    /**
     * @return mixed
     */
    public function getProjects()
    {
        return $this->jiraApi->getProjects();
    }

    /**
     * @param string $story
     * @param mixed  $params
     *
     * @return mixed
     */
    public function addJiraComment($story, $params)
    {
        return $this->jiraApi->addComment($story, $params);
    }
}