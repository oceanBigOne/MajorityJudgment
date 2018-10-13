<?php
/**
 * Project : MajorityJudgment
 * File : Ballot.php
 */

namespace oceanBigOne\MajorityJudgment;


use Exception;

class Ballot
{

    /**
     * Stack of mentions label
     * @var array
     */
    protected $mentions=[];

    /**
     * Stack of candidate names
     * @var Candidate[]
     */
    protected $candidates;

    /**
     * Stack of vote (associative array candidat=>mention)
     * @var array
     */
    protected $votes=[];


    /**
     * Ballot constructor.
     */
    public function __construct()
    {

    }

    /**
     * Set mentions width default values
     * @return Ballot
     */
    public function initDefaultMentions(): Ballot{
        $this->mentions=[new Mention("Excellent"),new Mention("Good"),new Mention("Pretty good"),new Mention("Fair"),new Mention("Insufficient"),new Mention("To Reject")];
        return $this;
    }

    /**
     * @return array
     */
    public function getMentions(): array
    {
        return $this->mentions;
    }

    /**
     * @param array $mentions
     * @return Ballot
     */
    public function setMentions(array $mentions): Ballot
    {
        $this->mentions = $mentions;
        return $this;
    }

    /**
     * @return Candidate[]
     */
    public function getCandidates(): array
    {
        return $this->candidates;
    }

    /**
     * @param array $candidates
     * @return Ballot
     */
    public function setCandidates(array $candidates): Ballot
    {
        $this->candidates = $candidates;
        return $this;
    }

    /**
     * @return array
     */
    public function getVotes(): array
    {
        return $this->votes;
    }

    /**
     * @param array $votes
     * @return Ballot
     */
    public function setVotes(array $votes): Ballot
    {
        $this->votes = $votes;
        return $this;
    }

    /**
     *  @return Ballot
     */
    public function clearVotes(): Ballot{
        $this->votes=[];
        return $this;
    }


    /**
     *  @return Ballot
     */
    public function clearCandidates(): Ballot{
        $this->candidates=[];
        return $this;
    }

    /**
     *  @return Ballot
     */
    public function clearMentions(): Ballot{
        $this->mentions=[];
        return $this;
    }

    /**
     * @param Mention $mention
     * @return Ballot
     */
    public function addMention(Mention $mention): Ballot{
        $this->mentions[]=$mention;
        return $this;
    }

    /**
     * @param Candidate $candidate
     * @return Ballot
     */
    public function addCandidate(Candidate $candidate): Ballot{
        $this->candidates[]=$candidate;
        return $this;
    }

    /**
     * @param Vote $vote
     * @return Ballot
     * @throws Exception
     */
    public function addVote(Vote $vote): Ballot{
        $index_of_mention=-1;
        $index_of_candidate=-1;

        $n=0;
        foreach($this->mentions as $mention){
            if($mention->getLabel()===$vote->getMention()->getLabel()){
                $index_of_mention=$n;
            }
            $n++;
        }

        $n=0;
        foreach($this->candidates as $candidate){
            if($candidate->getName()===$vote->getCandidate()->getName()){
                $index_of_candidate=$n;
            }
            $n++;
        }

        if($index_of_mention===-1){
            throw new Exception("mention doesn't exist");
        }
        if($index_of_candidate===-1){
            throw new Exception("candidate doesn't exist");
        }

        $this->votes[]=$vote;

        return $this;


    }


    /**
     * @param Mention $than
     * @return null|Mention
     */
    public function getBetterMention(Mention $than):?Mention{
        $n=0;
        $betterMention=null;
        foreach($this->mentions as $mention){
            if($mention->getLabel()===$than->getLabel()){
                if($n>0){
                    $betterMention=$this->mentions[$n-1];
                }
            }
            $n++;
        }
        return $betterMention;
    }


    /**
     * @param Mention $than
     * @return null|Mention
     */
    public function getWorseMention(Mention $than):?Mention{
        $n=0;
        $worseMention=null;
        foreach($this->mentions as $mention){
            if($mention->getLabel()===$than->getLabel()){
                if($n<(count($this->mentions)-1)){
                    $worseMention=$this->mentions[$n-1];
                }
            }
            $n++;
        }
        return $worseMention;
    }

    /**
     * @return Candidate[];
     */
    public function proceedBigElection():array{
        $sortedCandidates=[];
        //array of indexed Mentions
        $mentionToIndex=[];
        $n=0;
        foreach($this->getMentions() as $mention){
            $mentionToIndex[$mention->getLabel()]=$n;
            $n++;
        }
        //for each candidates
        foreach($this->getCandidates() as $candidate) {
            $meritProfil = new MeritProfile();
            //process values
            $majorityMention=$meritProfil->processMajorityMention($candidate, $this->getVotes(), $this->getMentions());
            $majorityMentionValue = $mentionToIndex[$majorityMention->getLabel()];
            $percentBetter= $meritProfil->processPercentOfBetterThanMajorityMention($candidate, $this->getVotes(), $this->getMentions());
            $percentWorse= $meritProfil->processPercentOfWorseThanMajorityMention($candidate, $this->getVotes(), $this->getMentions());
            if($percentBetter>=$percentWorse){
                $percentOne=$percentBetter/1000;
                $sign=-1;
            }else{
                $percentOne=$percentWorse/1000;
                $sign=1;
            }
            //create a key to sort candidates
            $keyValue=$majorityMentionValue+($sign*$percentOne);
            $keyFormat=number_format($keyValue,4,'','');
            $keystr=str_pad($keyFormat,10,"0", STR_PAD_LEFT)."-".$candidate->getName(); //add name in case of ex aequo
            $sortedCandidates[$keystr]=$candidate;
        }
        ksort($sortedCandidates);
        return array_values($sortedCandidates);
    }

    /**
     * @return Candidate[];
     */
    public function proceedElection():array{
        $sortedCandidates=[];


        //array of indexed Mentions
        $mentionToIndex=[];
        $n=0;
        foreach($this->getMentions() as $mention){
            $mentionToIndex[$mention->getLabel()]=$n;
            $n++;
        }
        //sort votes by candidates
        $votesByCandidates=[];
        foreach($this->getCandidates() as $candidate) {
            $votesByCandidates[$candidate->getName()]=[];
        }
        $votes=$this->getVotes();
        foreach($votes as $vote){
            $votesByCandidates[$vote->getCandidate()->getName()][]=$vote;
        }
        //for each candidates
        foreach($this->getCandidates() as $candidate) {
            $meritProfil = new MeritProfile();
            $votes=$votesByCandidates[$candidate->getName()];
            $nbParticipations=count($votes);
            $sortingKey="";
            for($i=0;$i<$nbParticipations;$i++){
                $majorityMention=$meritProfil->processMajorityMention($candidate, $votes, $this->getMentions());
                $votes=$this->removeAVote($votes,$candidate,$majorityMention);
                $majorityMentionValue = $mentionToIndex[$majorityMention->getLabel()];
                $sortingKey.=$majorityMentionValue;
            }

            $keystr=$sortingKey.$candidate->getName(); //add name in case of ex aequo

            $sortedCandidates[$keystr]=$candidate;

        }
        ksort($sortedCandidates);
        return array_values($sortedCandidates);

    }

    private function removeAVote(array $votes,Candidate $candidate,Mention $mention){
        $i=0;

        $indexToRemove=0;
        foreach($votes as $vote){
            if( $vote->getCandidate()->getName()===$candidate->getName() && $vote->getMention()->getLabel()===$mention->getLabel() ){
                $indexToRemove=$i;
                break;
            }
            $i++;
        }
        if(isset($votes[$indexToRemove])){
          //  unset($votes[$indexToRemove]);
            array_splice($votes, $indexToRemove, 1);
        }
        return  $votes;
    }




}