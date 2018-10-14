<?php

namespace oceanBigOne\MajorityJudgment;

require "../vendor/autoload.php";

//start Ballot
$ballot= new Ballot();

//add Mentions -- from the best to the worst (order is important) !!!!
$ballot->addMention(new Mention("Excellent"));
$ballot->addMention(new Mention("Good"));
$ballot->addMention(new Mention("Pretty good"));
$ballot->addMention(new Mention("Fair"));
$ballot->addMention(new Mention("Insufficient"));
$ballot->addMention(new Mention("To Reject"));

//or init with default mentions;
$ballot->initDefaultMentions();

//add some Candidats
$ballot->addCandidate(new Candidate("Mrs ABCDE"));
$ballot->addCandidate(new Candidate("Mr FGHIJ"));
$ballot->addCandidate(new Candidate("Mrs KLMNO"));
$ballot->addCandidate(new Candidate("Mr VWXYZ"));


//add 30 participations
for($i=0;$i<10000;$i++){
    //For each participations, add a vote for each candidate
    foreach($ballot->getCandidates() as $index=>$candidate){
        try{
            $ballot->addVote(new Vote($candidate,$ballot->getMentions()[rand(0,count($ballot->getMentions())-1)]));
        }catch(\Exception $e){
            echo $e->getMessage();
        }
    }
}

//result
echo "<h3>Result : </h3>";
$sortedCandidates=$ballot->proceedElection();
foreach($sortedCandidates as $candidate){
    $meritProfil=new MeritProfile();
    $merits=$meritProfil->getAsMeritArray($candidate,$ballot->getVotes(),$ballot->getMentions());
    echo "<br />-".$candidate->getName()." - ".($meritProfil->processMajorityMention($candidate,$ballot->getVotes(),$ballot->getMentions()))->getLabel();
}

//details
echo "<h3>Merit Profiles : </h3>";

foreach($sortedCandidates as $candidate){
    echo "<hr />";
    $meritProfil=new MeritProfile();
    $merits=$meritProfil->getAsMeritArray($candidate,$ballot->getVotes(),$ballot->getMentions());
    echo "<h4>".$candidate->getName()."</h4>";
    echo "<table border='1' cellpadding='15' cellspacing='0'><tr><td>Mention</td><td>Percent of vote</td></tr>";
    foreach($merits as $merit){
        echo "<tr><td>".$merit->getMention()->getLabel()."</td><td>".round($merit->getPercent(),2)."%</td></tr>";
    }
    echo "</table>";
    echo "<br />Majority mention is : <b>".($meritProfil->processMajorityMention($candidate,$ballot->getVotes(),$ballot->getMentions()))->getLabel()."</b>";
}

//clear mentions
$ballot->clearMentions();

//clear candidates
$ballot->clearCandidates();

//clear Votes
$ballot->clearVotes();





