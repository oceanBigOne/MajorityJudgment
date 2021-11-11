<?php

namespace oceanBigOne\MajorityJudgment\Entity;

use DateTime;
use Exception;
use oceanBigOne\MajorityJudgment\Service\GradeService;

class Vote
{

    protected Election $election;

    protected string $name;

    protected DateTime $createdAt;

    protected array $values;

    /**
     * @param Election $election
     */
    public function __construct(Election $election)
    {
        $this->election = $election;
        $this->election->addVote($this);
        $this->name = "";
        $this->createdAt = new DateTime();
        $this->values = [];
    }

    public function setGrade(Proposal $proposal, Grade $grade)
    {
        $proposals = $this->election->getProposals();
        $grades = $this->election->getGrades();
        $isProposalFound = false;
        $isGradeFound = false;
        foreach ($proposals as $proposalFromElection) {
            if ($proposalFromElection->getSlug() == $proposal->getSlug()) {
                $isProposalFound = true;
            }
        }
        foreach ($grades as $gradeFromElection) {
            if ($gradeFromElection->getSlug() == $grade->getSlug()) {
                $isGradeFound = true;
            }
        }
        if (!$isProposalFound) {
            throw new Exception("Proposal " . $proposal->getSlug() . " doesn't exist");
        }
        if (!$isGradeFound) {
            throw new Exception("Grade " . $grade->getSlug() . " doesn't exist");
        }
        $this->values[$proposal->getSlug()] = $grade;
        return $this;
    }

    public function getGrade(Proposal $proposal): Grade
    {
        if (isset($this->values[$proposal->getSlug()])) {
            return $this->values[$proposal->getSlug()];
        } else {
            throw new Exception("Missing vote for " . $proposal->getSlug() . "");
        }
    }

    /**
     * @return Election
     */
    public function getElection(): Election
    {
        return $this->election;
    }

    /**
     * @param Election $election
     * @return Vote
     */
    public function setElection(Election $election): Vote
    {
        $this->election = $election;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Vote
     */
    public function setName(string $name): Vote
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     * @return Vote
     */
    public function setCreatedAt(DateTime $createdAt): Vote
    {
        $this->createdAt = $createdAt;
        return $this;
    }


}