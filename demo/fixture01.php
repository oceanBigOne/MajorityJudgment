<?php
/**
 * Project : MajorityJudgment
 * File : fixture01.php
 */

namespace oceanBigOne\MajorityJudgment;

$fixture=[];

$fixture["candidates"]=["H.A","S.S","D.B","L.E.G","L.T","M.O","C.S","M.L","M.T","H.F","T.R","S.G","Y.N","A.S","J.B.L","C.M","I.E"];
$fixture["mentions"]=["Excellent","Très Bien","Bien","Assez Bien","Passable","Insuffisant"];


$fixture["votes"]=[];

$fixture["votes"]["H.A"]    =["Excellent"=>4,"Très Bien"=>5,"Bien"=>7,"Assez Bien"=>0,"Passable"=>2,"Insuffisant"=>0];
$fixture["votes"]["S.S"]    =["Excellent"=>4,"Très Bien"=>4,"Bien"=>7,"Assez Bien"=>1,"Passable"=>1,"Insuffisant"=>1];
$fixture["votes"]["D.B"]    =["Excellent"=>4,"Très Bien"=>5,"Bien"=>1,"Assez Bien"=>2,"Passable"=>4,"Insuffisant"=>2];
$fixture["votes"]["L.E.G"]  =["Excellent"=>3,"Très Bien"=>2,"Bien"=>6,"Assez Bien"=>4,"Passable"=>2,"Insuffisant"=>1];
$fixture["votes"]["L.T"]    =["Excellent"=>3,"Très Bien"=>3,"Bien"=>4,"Assez Bien"=>5,"Passable"=>2,"Insuffisant"=>1];
$fixture["votes"]["M.O"]    =["Excellent"=>3,"Très Bien"=>5,"Bien"=>2,"Assez Bien"=>3,"Passable"=>4,"Insuffisant"=>1];
$fixture["votes"]["C.S"]    =["Excellent"=>6,"Très Bien"=>4,"Bien"=>4,"Assez Bien"=>2,"Passable"=>1,"Insuffisant"=>1];
$fixture["votes"]["M.L"]    =["Excellent"=>6,"Très Bien"=>3,"Bien"=>4,"Assez Bien"=>1,"Passable"=>3,"Insuffisant"=>1];
$fixture["votes"]["M.T"]    =["Excellent"=>4,"Très Bien"=>3,"Bien"=>6,"Assez Bien"=>2,"Passable"=>2,"Insuffisant"=>1];
$fixture["votes"]["H.F"]    =["Excellent"=>6,"Très Bien"=>2,"Bien"=>5,"Assez Bien"=>1,"Passable"=>2,"Insuffisant"=>2];
$fixture["votes"]["T.R"]    =["Excellent"=>17,"Très Bien"=>1,"Bien"=>0,"Assez Bien"=>0,"Passable"=>0,"Insuffisant"=>0];
$fixture["votes"]["S.G"]    =["Excellent"=>5,"Très Bien"=>7,"Bien"=>3,"Assez Bien"=>2,"Passable"=>0,"Insuffisant"=>1];
$fixture["votes"]["Y.N"]    =["Excellent"=>10,"Très Bien"=>4,"Bien"=>1,"Assez Bien"=>1,"Passable"=>2,"Insuffisant"=>0];
$fixture["votes"]["A.S"]    =["Excellent"=>7,"Très Bien"=>5,"Bien"=>1,"Assez Bien"=>3,"Passable"=>1,"Insuffisant"=>1];
$fixture["votes"]["J.B.L"]  =["Excellent"=>4,"Très Bien"=>11,"Bien"=>1,"Assez Bien"=>0,"Passable"=>1,"Insuffisant"=>1];
$fixture["votes"]["C.M"]    =["Excellent"=>1,"Très Bien"=>5,"Bien"=>6,"Assez Bien"=>3,"Passable"=>2,"Insuffisant"=>1];
$fixture["votes"]["I.E"]    =["Excellent"=>12,"Très Bien"=>3,"Bien"=>0,"Assez Bien"=>2,"Passable"=>0,"Insuffisant"=>1];



require "../vendor/autoload.php";

//start Ballot
$ballot= new Ballot();

foreach($fixture["mentions"]as $label){
    $ballot->addMention(new Mention($label));
}

foreach($fixture["candidates"]as $name){
    $ballot->addCandidate(new Candidate($name));
}

foreach($ballot->getCandidates() as $index=>$candidate){
    foreach($fixture["votes"][$candidate->getName()] as $arrayVote ){
        $indexMention=0;
        foreach($fixture["mentions"]as $label){
            for($i=0;$i<$fixture["votes"][$candidate->getName()][$label];$i++){
                $ballot->addVote(new Vote($candidate, $ballot->getMentions()[$indexMention]));
            }
            $indexMention++;
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




