# Majority judgment PHP 

Simple class PHP of majority judgment. See more details on [Wikipedia](https://en.wikipedia.org/wiki/Majority_judgment).

# How to install ?

``` composer require oceanbigone/majorityjudgment ``` 

# How to use ?

See how to use with ``demo/index.php``.
You can see result here : [demo page](http://majority-judgement-demo.garrot.org)

```php
require "../vendor/autoload.php";

//start Ballot
$ballot= new Ballot();

//create Mention
$excellent  = new Mention("Excellent");
$good       = new Mention("Good");
$prettyGood = new Mention("Pretty good");
[...]

//create Candidate
$candidate1 = new Candidate("Mrs ABCDE");
$candidate2 = new Candidate("Mr FGHIJ");

//add Mentions -- from the best to the worst (order is important) !!!!
$ballot->addMention($excellent);
$ballot->addMention($good);
$ballot->addMention($prettyGood);
[...]

//add some Candidats
$ballot->addCandidate($candidate1);
$ballot->addCandidate($candidate2);
[...]


//add votes (keep in mind that each participation need a vote for each candidate !)
$ballot->addVote(new Vote($candidate1,$excellent));
$ballot->addVote(new Vote($candidate2,$prettyGood));

$ballot->addVote(new Vote($candidate1,$good));
$ballot->addVote(new Vote($candidate2,$excellent));
[...]

//get an array of candidate sorted by Majority Jugement, if there is full ex-aequo (even after index added) then they are ordered by name.
$sortedCandidates=$ballot->proceedElection();
var_dump($sortedCandidates);

//details with MeritProfile object
foreach($sortedCandidates as $candidate){
    
    $meritProfil=new MeritProfile();
    
    //get merit profil as Array of Merit object (Merit is an object with two property : mention and percent of this mention) 
    $merits=$meritProfil->getAsMeritArray($candidate,$ballot->getVotes(),$ballot->getMentions());
    
    //display majority mention
    echo $meritProfil->processMajorityMention($candidate,$ballot->getVotes(),$ballot->getMentions()))->getLabel();
    
    //display percent of majority mention
    echo $meritProfil->processPercentOfMajorityMention($candidate,$ballot->getVotes(),$ballot->getMentions()));
        
}

//clear mentions
$ballot->clearMentions();

//clear candidates
$ballot->clearCandidates();

//clear Votes
$ballot->clearVotes();
```

# Versions

### 2.1.6
- Add `demo/fixture02-bug.php` to test a bug

### 2.1.5
- Fix bug when perfect exaequo

### 2.1.4
- Update this file (remove beta warning)

### 2.1.3
- Majority mention strictly superior 50%
- add a fixture

### 2.1.2
- remove var_dump

### 2.1.1
- Check ex-eaquo with the full key (not only current path)

## 2.1.0
- New algorithm (no more ex-aequo)

### 2.0.4
- Fix : bug when process worse percent than majority percent 

### 2.0.3
- Remove key in result array 

### 2.0.2
- fix : format key

### 2.0.1
- Add some help in Readme

## 2.0.0
- Return objects instead of associative array  
**warning : This version is not compatible with older version**

### 1.2.8
- License

### 1.2.7
- Finalize the algorithm and add an explanation

### 1.2.6
- fix results error

### 1.2.5
- fix precision round value for generate sorting key (in result array)

### 1.2.4
- fix result error

### 1.2.3
- sign error in ex-aequo results

### 1.2.2
- sign error in ex-aequo results

### 1.2.1
- update Readme

## 1.2.0
- function getMeritProfile is now private
- clean comment in code
- add some documentation

## 1.1.0
- function getMeritProfile is now public
- function getAsMeritArray is now proceedElection

### 1.0.3
- fix composer.json 

### 1.0.2
- add install information on Readme

### 1.0.1
- corrections for packagist

# 1.0.0
- Initial commit






