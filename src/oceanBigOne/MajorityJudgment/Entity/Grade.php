<?php

namespace oceanBigOne\MajorityJudgment\Entity;

class Grade
{
    /**
     * Slug of grade (CamelCase)
     * @var string
     */
    protected string $slug;

    /**
     * @var string label of grade
     */
    protected string $label;

    /**
     * @var string color of grade in hexadecimal (ex : ff0000 for red )
     */
    protected string $hexadecimalColor;

    /**
     * @param string $slug
     * @param string $label
     * @param string|null $hexadecimalColor
     */
    public function __construct(string $slug, string $label, ?string $hexadecimalColor = null)
    {
        $this->slug = $slug;
        $this->label = $label;
        $this->hexadecimalColor = $hexadecimalColor ?? "000000";
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
     * @return Grade
     */
    public function setSlug(string $slug): Grade
    {
        $this->slug = $slug;
        return $this;
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
     * @return Grade
     */
    public function setLabel(string $label): Grade
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @return string
     */
    public function getHexadecimalColor(): string
    {
        return $this->hexadecimalColor;
    }

    /**
     * @param string $hexadecimalColor
     * @return Grade
     */
    public function setHexadecimalColor(string $hexadecimalColor): Grade
    {
        $this->hexadecimalColor = $hexadecimalColor;
        return $this;
    }


}