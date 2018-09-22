<?php
/**
 * Project : MajorityJudgment
 * File : Merit.php
 */

namespace oceanBigOne\MajorityJudgment;


class Merit
{
    /**
     * @var Mention
     */
    protected $mention;

    /**
     * @var float
     */
    protected $percent;

    /**
     * Merit constructor.
     * @param Mention $mention
     * @param float $percent
     */
    public function __construct(Mention $mention, float $percent=0)
    {
        $this->mention = $mention;
        $this->percent = $percent;
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
     * @return Merit
     */
    public function setMention(Mention $mention): Merit
    {
        $this->mention = $mention;
        return $this;
    }

    /**
     * @return float
     */
    public function getPercent(): float
    {
        return $this->percent;
    }

    /**
     * @param float $percent
     * @return Merit
     */
    public function setPercent(float $percent): Merit
    {
        $this->percent = $percent;
        return $this;
    }




}