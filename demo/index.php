<?php

namespace oceanBigOne\MajorityJudgment;

require "../vendor/autoload.php";

//start Ballot
$ballot= new Ballot();

//add Mentions -- from the best to the worst (order is important) !!!!
$ballot->addMention("Excellent");
$ballot->addMention("Good");
$ballot->addMention("Pretty good");
$ballot->addMention("Fair");
$ballot->addMention("Insufficient");
$ballot->addMention("To Reject");

//or init with default mentions;
$ballot->initDefaultMentions();

//add some Candidats
$ballot->addCandidate("Mrs ABCDE");
$ballot->addCandidate("Mr FGHIJ");
$ballot->addCandidate("Mrs KLMNO");
$ballot->addCandidate("Mr VWXYZ");


//add 1000 participations
for($i=0;$i<1000;$i++){
    //For each participations, add a vote for each candidate
    foreach($ballot->getCandidates() as $index=>$candidate){
        $ballot->addVote($index,rand(0,count($ballot->getMentions())-1));
    }
}

//process
$result= Ballot::get($ballot);

//display result

echo "<h3>Merit Profiles</h3>";
//show merit Profile for each Candidate
foreach($ballot->getCandidates() as $index_of_candidate=>$candidate){
    echo "<hr />";
    echo $candidate."[".$index_of_candidate."]";
    $resultCandidate=$result[$index_of_candidate]["values"];
    var_dump($resultCandidate);

    echo "<h4 style='margin:0'>Majority Mention : ".$ballot->getMentions()[$resultCandidate["majority-mention"]]."(".$resultCandidate["majority-mention"].")</h4>";
    echo "- ".$resultCandidate["pc-worst"]."% of vote are worse";
    echo "<br>- ".$resultCandidate["pc-better"]."% of vote are better";
}

echo "<hr />";
echo "<h3>Results</h3>";
echo "<hr />";
//show result (array_key format);
var_dump($result);

//clear mentions
$ballot->clearMentions();

//clear candidates
$ballot->clearCandidates();

//clear Votes
$ballot->clearVotes();





