<?php

namespace AppBundle\Entity\Jira;


class JiraStory
{
    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $issueType;

    /**
     * @var \DateTime
     */
    private $timeCreated;

    /**
     * @var array
     */
    private $labels;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $summary;

    /**
     * @var array
     */
    private $comments;

    /**
     * @var string
     */
    private $teamName;

    /**
     * @param \Jira_Api_Result $jiraApiResult
     */
    public function __construct($jiraApiResult)
    {
        $this->description = $jiraApiResult['fields']['description'];
        $this->issueType = $jiraApiResult['fields']['issuetype']['name'];
        $this->timeCreated = $jiraApiResult['fields']['created'];
        $this->labels = $jiraApiResult['fields']['labels'];
        $this->status = $jiraApiResult['fields']['status']['name'];
        $this->summary = $jiraApiResult['fields']['summary'];
        $this->comments = $jiraApiResult['fields']['comment']['comments'];
        $this->teamName = $jiraApiResult['fields']['customfield_12300']['0']['value'];
    }
}