<?php

namespace AppBundle\Entity\Jira;

use Jira_Api;
use Jira_Api_Authentication_Basic;
use Jira_Api_Result;

class JiraManager
{
    /**
     * @var Jira_Api
     */
    private $jiraApi;

    public function __construct($jiraUri)
    {
        $this->jiraApi = new Jira_Api($jiraUri, new Jira_Api_Authentication_Basic("le-rouxe", "Password1"));
    }

    public function getJiraStory($storyNumber)
    {
        /** @var Jira_Api_Result $story */
        $story = $this->jiraApi->getIssue($storyNumber);

        return new JiraStory($story->getResult());
    }
}