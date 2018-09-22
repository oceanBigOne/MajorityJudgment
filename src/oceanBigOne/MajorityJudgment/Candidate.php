<?php
/**
 * Project : MajorityJudgment
 * File : Candidate.php
 */

namespace oceanBigOne\MajorityJudgment;


class Candidate
{
    /**
     * @var string
     */
    protected $name;




    /**
     * Candidate constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
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
     * @return Candidate
     */
    public function setName(string $name): Candidate
    {
        $this->name = $name;
        return $this;
    }



}