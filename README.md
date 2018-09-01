# Majority judgment PHP 

## Work in progress - In test phase !

Simple class PHP of majority judgment. See more details on [Wikipedia](https://en.wikipedia.org/wiki/Majority_judgment).

Explanation of ex-aequo method found here sciencetonnante (in french) : [sciencetonnante](https://sciencetonnante.wordpress.com/2016/10/21/reformons-lelection-presidentielle/)

# How to install ?

``` composer require oceanbigone/majorityjudgment ``` 

# How to use ?

see how to use with ``demo/index.php``.
You can see result here : [demo page](http://majority-judgement-demo.garrot.org)

``clearVotes`` : Clear stack of Votes

``clearCandidates`` : Clear stack of Candidates

``clearMentions`` : Clear stack of Mentions

``addVote(int $index_of_candidate,int $index_of_mention)`` : Add a vote with an index of candidate and an index of mention

``addCandidate(string $candidate)`` : Add a candidate with a string (for example : his name)

``addMention(string $mention)`` : Add a mention

``Ballot::getResult(Ballot $ballot)`` : static function get result of Ballot

This function return an associativa array (sorted) for each candidat. The winner is the first item in array.
```
array (size=6)
  'merit-profile' => 
    array (size=6)
      0 => float percent of vote for the first mention
      1 => float percent of vote for the second mention
      2 => float percent of vote for the third mention
      3 => float ...
      4 => float ...
      5 => float ...
  'majority-mention' => int index of the majority mention
  'pc-worse' => float percent of vote worse than majority mention
  'pc' => float percent of the majority mention ( = merit-profile[majority-mention])
  'pc-better' => float percent of vote better than majority mention
  'majority-mention-weighting' => int interne value used only in case of ex-aequo result
```


# Versions

## 1.2.0
- function getMeritProfile is now private
- clean comment in code
- add some documentation

## 1.1.0
- function getMeritProfile is now public
- function get is now getResult

### 1.0.3
- fix composer.json 

### 1.0.2
- add install information on Readme

### 1.0.1
- corrections for packagist

## 1.0.0
- Initial commit






