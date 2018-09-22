<?php
/**
 * Project : MajorityJudgment
 * File : Mention.php
 */

namespace oceanBigOne\MajorityJudgment;


class Mention
{
    /**
     * @var string
     */
    protected $label;

    /**
     * Mention constructor.
     * @param string $label
     */
    public function __construct(string $label)
    {
        $this->label = $label;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param string $label
     * @return Mention
     */
    public function setLabel(string $label): Mention
    {
        $this->label = $label;
        return $this;
    }


}