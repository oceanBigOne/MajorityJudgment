<?php

namespace oceanBigOne\MajorityJudgment\Entity;

class Proposal
{
    protected string $slug;

    /**
     * @param string $slug
     */
    public function __construct(string $slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     * @return Proposal
     */
    public function setSlug(string $slug): Proposal
    {
        $this->slug = $slug;
        return $this;
    }


}