<?php
/**
 * Project : MajorityJudgment
 * File : MeritProfile.php
 */

namespace oceanBigOne\MajorityJudgment;


class MeritProfile
{


    /**
     * @param Candidate $candidate
     * @param Vote[] $votes
     * @param Mention[] $mentions
     * @return Merit[]
     */
    private function process(Candidate $candidate,array $votes,array $mentions):array
    {
        $stack=[];
        foreach($mentions as $mention){
            $total=0;
            $count=0;
            foreach($votes as $vote) {
                if( $vote->getCandidate()->getName()==$candidate->getName()) {
                    $total++;
                }
                if($vote->getMention()->getLabel()==$mention->getLabel() && $vote->getCandidate()->getName()==$candidate->getName()) {
                    $count++;
                }
            }
            $merit=new Merit($mention,$count*100/$total);
            $stack[]=$merit;
        }

        return $stack;
    }

    /**
     * @param Candidate $candidate
     * @param array $votes
     * @param array $mentions
     * @return $mention
     */
    public function processMajorityMention(Candidate $candidate, array $votes, array $mentions):Mention{
        $stack=$this->process($candidate,$votes,$mentions);
        $nPercent=0;
        $majorityMention="";
        foreach($stack as $merit){

            $nPercent+=$merit->getPercent();

            if($nPercent>50 && $majorityMention===""){
                $majorityMention=$merit->getMention();
                break;
            }
        }
        return $majorityMention;
    }

    /**
     * @param Candidate $candidate
     * @param array $votes
     * @param array $mentions
     * @return float
     */
    public function processPercentOfMajorityMention(Candidate $candidate, array $votes, array $mentions):float{
        $stack=$this->process($candidate,$votes,$mentions);
        $nPercent=0;
        $percentOfMajorityMention=-1;
        foreach($stack as $merit){
            $nPercent+=$merit->getPercent();
            if($nPercent>50 && $percentOfMajorityMention==-1){
                $percentOfMajorityMention=$nPercent;
                break;
            }
        }
        return $percentOfMajorityMention;
    }


    /**
     * @param Candidate $candidate
     * @param array $votes
     * @param array $mentions
     * @return float
     */
    public function processPercentOfBetterThanMajorityMention(Candidate $candidate, array $votes, array $mentions):float{
        $stack=$this->process($candidate,$votes,$mentions);
        $nPercent=0;
        $percentOfBetterThanMajorityMention=-1;
        foreach($stack as $merit){
            $nPercent+=$merit->getPercent();
            if($nPercent>50  && $percentOfBetterThanMajorityMention==-1){
                $percentOfBetterThanMajorityMention=$nPercent-$merit->getPercent();
                break;
            }
        }
        return $percentOfBetterThanMajorityMention;
    }

    /**
     * @param Candidate $candidate
     * @param array $votes
     * @param array $mentions
     * @return float
     */
    public function processPercentOfWorseThanMajorityMention(Candidate $candidate, array $votes, array $mentions):float{
        $stack=$this->process($candidate,$votes,$mentions);
        $stack=array_reverse($stack);
        $nPercent=0;
        $percentOfWorseThanMajorityMention=-1;
        foreach($stack as $merit){
            $nPercent+=$merit->getPercent();
            if($nPercent>50 && $percentOfWorseThanMajorityMention==-1){
                $percentOfWorseThanMajorityMention=$nPercent-$merit->getPercent();
                break;
            }
        }
        return $percentOfWorseThanMajorityMention;
    }

    /**
     * @param Candidate $candidate
     * @param array $votes
     * @param array $mentions
     * @return Merit[]
     */
    public function getAsMeritArray(Candidate $candidate, array $votes, array $mentions){
        return $this->process($candidate,$votes,$mentions);
    }


    /**
     * @param Candidate $candidate
     * @param array $votes
     * @param array $mentions
     * @return float
     */
    public function processPercentOfMention(Mention $mention,Candidate $candidate, array $votes, array $mentions){
      $merits=$this->getAsMeritArray( $candidate,  $votes,  $mentions);
      $percent=0;
      foreach($merits as $merit){
          if($merit->getMention()->getLabel()==$mention->getLabel()){
              $percent=$merit->getPercent();
              break;
          }
      }
      return $percent;
    }




}