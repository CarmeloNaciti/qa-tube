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
     * @var int
     */
    private $teamNumber;

    /**
     * @var string
     */
    private $assignee;

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
        $this->assignee = $jiraApiResult['fields']['assignee']['displayName'];
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getIssueType()
    {
        return $this->issueType;
    }

    /**
     * @return \DateTime
     */
    public function getTimeCreated()
    {
        return $this->timeCreated;
    }

    /**
     * @return array
     */
    public function getLabels()
    {
        return $this->labels;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * @return array
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @return string
     */
    public function getTeamName()
    {
        return $this->teamName;
    }

    /**
     * @return int
     */
    public function getTeamNumber()
    {
        return $this->teamNumber;
    }

    /**
     * @return string
     */
    public function getAssignee()
    {
        return $this->assignee;
    }

    public function toArray()
    {
        return [
            'description' => $this->description,
            'issueType' => $this->issueType,
            'timeCreated' => $this->timeCreated,
            'labels' => $this->labels,
            'status' => $this->status,
            'summary' => $this->summary,
            'comments' => $this->comments,
            'teamName' => $this->teamName,
            'assignee' => $this->assignee,
        ];
    }
}