<?php

namespace oceanBigOne\MajorityJudgment\Service;

use oceanBigOne\MajorityJudgment\Entity\Election;
use oceanBigOne\MajorityJudgment\Entity\Proposal;
use oceanBigOne\MajorityJudgment\Entity\Vote;

class CountElectionService
{

    public function __construct()
    {

    }

    public function count(Election $election): array
    {
        $result = [];
        $proposals = $election->getProposals();
        $meritProfiles = [];
        foreach ($proposals as $proposal) {
            $meritProfiles[$proposal->getSlug()] = $this->getMeritProfiles($election, $proposal);
        }

        foreach ($meritProfiles as $proposalSlug => $meritProfile) {
            $pcSum = 0;
            $medianGradeSlug = "";
            foreach ($meritProfile as $gradeSlug => $pc) {
                $pcSum += $pc;
                if ($pcSum >= 50 && $medianGradeSlug == "") {
                    $medianGradeSlug = $gradeSlug;
                }
            }
            $result[$proposalSlug] = $medianGradeSlug;
        }


        var_dump($result);

        return $result;

    }


    public function getMeritProfiles(Election $election, Proposal $proposal)
    {
        $votes = $election->getVotes();
        $grades = $election->getGrades();
        $counter = [];
        $meritProfile = [];
        foreach ($grades as $grade) {
            $counter[$grade->getSlug()] = 0;
        }
        $total = 0;
        foreach ($votes as $vote) {
            /**
             * @var Vote $vote
             */
            $gradeForThisProposal = $vote->getGrade($proposal)->getSlug();
            if ($gradeForThisProposal) {
                $counter[$gradeForThisProposal] += 1;
                $total++;
            }
        }
        foreach ($counter as $slug => $value) {
            $meritProfile[$slug] = $value * 100 / $total;

        }

        return $meritProfile;
    }

}