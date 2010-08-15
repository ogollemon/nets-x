<?php

/**
* Here all the scoring rules can be scripted
*
*/

// ASSESSMENTS
define ('PS_ASSESSMENT', 50); // default score for a player submitted (PS) assessment:
define ('PS_ANSWER', 10); // each submitted answer gives additional scores
define ('PS_ASSESSMENT_EDIT', 25); // editing gives score only once!
define ('ASSESSMENT_CORRECT_ANSWER', 10); // default score for a correctly given answer in a self-assessment

// ADVENTURE QUESTIONS:
define ('PS_ADVENTURE_QUESTION', 50); // default score for a player submitted (PS) adventure question
define ('PS_ADVENTURE_ANSWER', 10); // each submitted answer gives additional scores
define ('PS_ADVENTURE_QUESTION_EDIT', 25); // editing gives score only once!
define ('ADVENTURE_CORRECT_ANSWER', 10); //default score for a correctly given answer in 2D adventure

define ('PS_WIKI_ARTICLE', 50); // default score for a player submitted (PS) wiki article:
define ('PS_WIKI_EDIT', 25); // less than a whole new article


?>