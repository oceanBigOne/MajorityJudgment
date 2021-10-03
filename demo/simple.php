<?php

use oceanBigOne\MajorityJudgment\Entity\Election;
use oceanBigOne\MajorityJudgment\Entity\Proposal;
use oceanBigOne\MajorityJudgment\Entity\Vote;
use oceanBigOne\MajorityJudgment\Service\GradeService;

//services
$gradeService = new GradeService();

//init grades
$grades = $gradeService->getDefaultGrades();

//init proposals
$proposalA = new Proposal("AAAA");
$proposalB = new Proposal("BBBB");
$proposalC = new Proposal("CCCC");
$proposalD = new Proposal("DDDD");
$proposals = [$proposalA, $proposalB, $proposalC, $proposalD];

//init election
$election = new Election($grades, $proposals);

// voting
$votes = [];
for ($i = 0; $i < 100; $i++) {
    $votes[$i] = new Vote($election);
    $votes[$i]->setName("Voter " . $i);
    foreach ($proposals as $proposal) {
        $grade = $grades[random_int(0, count($grades) - 1)];
        $votes[$i]->setValue($proposal, $grade);
    }
}

//countElection



