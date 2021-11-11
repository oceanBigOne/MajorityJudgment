<?php

namespace oceanBigOne\MajorityJudgment\Entity;

class Election
{

    const DEFAULT_GRADES_CONFIG = [
        "ToBeRejected",
        "Insufficient",
        "Fair",
        "FairlyGood",
        "Good",
        "VeryGood",
    ];

    /**
     * List of all proposals
     * @var array
     */
    protected array $proposals;

    /**
     * List of all votes
     * @var array
     */
    protected array $votes;

    /**
     * List of all grades
     * @var array
     */
    protected array $grades;


    public function __construct(array $grades, array $proposals, array $votes = [])
    {
        $this->grades = $grades;
        $this->proposals = $proposals;
        $this->votes = $votes;
    }

    /**
     * @return array
     */
    public function getProposals(): array
    {
        return $this->proposals;
    }

    /**
     * @param array $proposals
     * @return Election
     */
    public function setProposals(array $proposals): Election
    {
        $this->proposals = $proposals;
        return $this;
    }

    /**
     * @return array
     */
    public function getGrades(): array
    {
        return $this->grades;
    }

    /**
     * @param array $sortedGrades (array of Grades sorted from lower to higher)
     * @return Election
     */
    public function setGrades(array $sortedGrades): Election
    {
        $this->grades = $sortedGrades;
        return $this;
    }

    /**
     * @return array
     */
    public function getVotes(): array
    {
        return $this->votes;
    }

    /**
     * @param array $votes
     * @return Election
     */
    public function setVotes(array $votes): Election
    {
        $this->votes = $votes;
        return $this;
    }

    /**
     * @param Vote $vote
     * @return $this
     */
    public function addVote(Vote $vote): Election
    {
        $this->votes[] = $vote;
        return $this;
    }


}