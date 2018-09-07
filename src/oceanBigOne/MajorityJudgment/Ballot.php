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
     * @var array
     */
    protected $candidates=[];

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
        $this->mentions=["Excellent","Good","Pretty good","Fair","Insufficient","To Reject"];
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
     * @return array
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
     * @param string $mention
     * @return Ballot
     */
    public function addMention(string $mention): Ballot{
        $this->mentions[]=$mention;
        return $this;
    }

    /**
     * @param string $candidate
     * @return Ballot
     */
    public function addCandidate(string $candidate): Ballot{
        $this->candidates[]=$candidate;
        return $this;
    }

    /**
     * @param int $index_of_candidate
     * @param int $index_of_mention
     * @return Ballot
     * @throws Exception
     */
    public function addVote(int $index_of_candidate,int $index_of_mention): Ballot{
        $error=0;

        if(!isset($this->mentions[$index_of_mention])){
            throw new Exception("mentions[".$index_of_mention."] doesn't exist");
        }
        if(!isset($this->candidates[$index_of_candidate])){
            throw new Exception("candidate[".$index_of_mention."] doesn't exist");
        }


        if($error===0){

            if(!isset($this->votes[$index_of_candidate])){
                $this->votes[$index_of_candidate]=[];
            }
            if(!isset($this->votes[$index_of_candidate][$index_of_mention])){
                $this->votes[$index_of_candidate][$index_of_mention]=0;
            }
            $this->votes[$index_of_candidate][$index_of_mention]++;

            return $this;
        }

    }


    /**
     * @param Ballot $ballot
     * @return array
     */
    static public function getResult(Ballot $ballot){

        $result=[];

        //for each candidates
        $candidates=$ballot->getCandidates();
        $mentions=$ballot->getMentions();
        $votes=$ballot->getVotes();

        $meritProfiles=[];

        foreach($candidates as $index_of_candidate=>$candidate){
            //reset merit profile
            $meritProfiles[$index_of_candidate]=self::getMeritProfile($votes[$index_of_candidate],$mentions);

        }


        //sort profile by mention with a note

        //Foreach merit profile
        foreach($meritProfiles as $index_of_candidate=>$profile){
            $note=0;
            //check if there is more percent better than percent worse
            if($meritProfiles[$index_of_candidate]["pc-better"]>=$meritProfiles[$index_of_candidate]["pc-worse"]){
                //nuance value is set with negative value of percent better
                $nuanceValue=-round(($meritProfiles[$index_of_candidate]["pc-better"])/100,6);
            }else{
                //nuance value is set with positive value of percent better
                $nuanceValue=round($meritProfiles[$index_of_candidate]["pc-worse"]/100,6);
            }
            //create a note with majority mention and nuance value
            $note=$profile["majority-mention"]+$nuanceValue;

            //Create an integer key;
            $sortKeyValue=round($note*1000);
            //add candidate to an array with $sortKey as a key
            $resultKey[str_pad($sortKeyValue,8,"0",STR_PAD_LEFT)."-".str_pad($index_of_candidate,8,"0",STR_PAD_LEFT)]=["candidate"=>$index_of_candidate,"values"=>$profile];
        }
        //sort array with this key
        ksort($resultKey);
        $position=1;
        foreach($resultKey as $key=>$candidatesValues){
            $candidatesValues["position"]=$position;
            $aKey=explode("-",$key);
            $candidatesValues["note"]=intval($aKey[0])/1000; //retrieve key
            $result[$candidatesValues["candidate"]]=$candidatesValues;
            $position++;
        }

        return $result;
    }



    /**
     * @param array $votes
     * @param array $mentions
     * @return array
     */
    static private function getMeritProfile(array $votes,array $mentions):array{

        $result=["merit-profile"=>[],"majority-mention"=>0,"pc-worse"=>0,"pc"=>0,"pc-better"=>0];

        $meritAsPercent=[];

        $totalVotes=0;

        foreach($votes as $index_of_mention=>$vote_value){
            $totalVotes+=$vote_value;
        }

        foreach($mentions as $index_of_mention=>$mention){
            $meritAsPercent[$index_of_mention]=0;
        }

        if( $totalVotes > 0) {
            foreach ($votes as $index_of_mention=>$vote_value) {

                $meritAsPercent[$index_of_mention] = round($vote_value*100/$totalVotes,6);
            }
        }
        $result["merit-profile"]=$meritAsPercent;

        $percent=0;
        $majorityMention=0;
        $pc=0;
        for($i=0;$i<count($result["merit-profile"]);$i++){
            $percent+=$result["merit-profile"][$i];
            if($percent>=50 ){
                $majorityMention=$i;
                $pc=$percent;
                $pcMention=$result["merit-profile"][$i];
                break;
            }
        }
        $percent=0;
        $pcBetter=0;
        $pcWorse=0;
        for($i=0;$i<count($result["merit-profile"]);$i++){
            $percent+=$result["merit-profile"][$i];

            if($percent<$pc){
                $pcWorse=$percent;
            }
            if($percent>$pc){
                $pcBetter=$percent-$pcWorse-$result["merit-profile"][$majorityMention];
            }
        }

        $result["majority-mention"]=$majorityMention;
        $result["pc-worse"]=$pcWorse;
        $result["pc"]=$pcMention;
        $result["pc-better"]=$pcBetter;

        return $result;
    }




}