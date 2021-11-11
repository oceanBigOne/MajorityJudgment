<?php
require_once "loader.php";

use oceanBigOne\MajorityJudgment\Entity\Election;
use oceanBigOne\MajorityJudgment\Entity\Proposal;
use oceanBigOne\MajorityJudgment\Entity\Vote;
use oceanBigOne\MajorityJudgment\Service\GradeService;
use oceanBigOne\MajorityJudgment\Service\CountElectionService;

//services
$gradeService = new GradeService();
$countElectionService = new CountElectionService();

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
for ($i = 0; $i < 1000; $i++) {
    $vote = new Vote($election);
    $vote->setName("Voter " . $i);
    foreach ($proposals as $proposal) {
        $grade = $grades[random_int(0, count($grades) - 1)];
        $vote->setGrade($proposal, $grade);
    }
    $votes[] = $vote;
}

//countElection
$result = $countElectionService->count($election);




