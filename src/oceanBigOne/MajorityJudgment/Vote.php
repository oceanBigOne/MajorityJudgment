<?php
/**
 * Project : MajorityJudgment
 * File : Vote.php
 */

namespace oceanBigOne\MajorityJudgment;


class Vote
{
    /**
     * @var Candidate
     */
    protected $candidate;

    /**
     * @var Mention
     */
    protected $mention;

    /**
     * Vote constructor.
     * @param Candidate $candidate
     * @param Mention $mention
     */
    public function __construct(Candidate $candidate, Mention $mention)
    {
        $this->candidate = $candidate;
        $this->mention = $mention;
    }

    /**
     * @return Candidate
     */
    public function getCandidate(): Candidate
    {
        return $this->candidate;
    }

    /**
     * @param Candidate $candidate
     * @return Vote
     */
    public function setCandidate(Candidate $candidate): Vote
    {
        $this->candidate = $candidate;
        return $this;
    }

    /**
     * @return Mention
     */
    public function getMention(): Mention
    {
        return $this->mention;
    }

    /**
     * @param Mention $mention
     * @return Vote
     */
    public function setMention(Mention $mention): Vote
    {
        $this->mention = $mention;
        return $this;
    }




}