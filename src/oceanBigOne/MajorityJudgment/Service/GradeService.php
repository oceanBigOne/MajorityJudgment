<?php

namespace oceanBigOne\MajorityJudgment\Service;

use oceanBigOne\MajorityJudgment\Entity\Election;
use oceanBigOne\MajorityJudgment\Entity\Grade;

class GradeService
{
    public function __construct()
    {
    }

    public function getDefaultGrades(): array
    {
        $slugs = Election::DEFAULT_GRADES_CONFIG;
        $grades = [];
        foreach ($slugs as $slug) {
            $grades = $this->getGradeFromSlug($slug);
        }
        return $grades;
    }

    /**
     * @param string $slug
     * @return Grade
     */
    public function getGradeFromSlug(string $slug): Grade
    {
        return new Grade($slug, $slug);
    }

}