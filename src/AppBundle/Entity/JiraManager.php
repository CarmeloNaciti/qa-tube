<?php
/**
 * This file is part of the MiWay Insurance Application.
 *
 * @author      MiWay Development Team
 * @copyright   Copyright (c) 2014-2016 MiWay Insurance Ltd
 */

namespace AppBundle\Entity;

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

    public function getStoryDetails($storyNumber)
    {
        /** @var Jira_Api_Result $story */
        $story = $this->jiraApi->getIssue($storyNumber);

        return $storyDescription = $story->getResult()['fields']['description'];
    }
}