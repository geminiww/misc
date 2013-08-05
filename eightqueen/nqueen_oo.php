<?php
/**
 * Solution to Eight Queen Puzzle - Object version
 * 
 * Solution to Eight Queen => N-queens problem, using backtracking without distiguishing symmetry ones
 * 
 * @author     Wei Wu <geminiwyn@hotmail.com>
 * @version    1.0
 * @copyright  2013 Wei Wu
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 */

/**
 * Load the solver class    
 */
require_once('NQueens.cls.php');

/**
 * get solver object & get the result    
 */

$solver = NQueenSolver::getInstance();

$results = $solver->getSolutions();


/**
 * Display all solutions    
 */

$count = 0;
foreach($results as $solution) {
  $count ++;                                      // just counter 
  echo "<br /> -- Solution # $count -- <br /> ";
  foreach($solution as $line => $queen){
    echo "$queen ";
  }
  echo "<br />";

}

if ($solver->isSolvedPartially()) {               // display if not all posibility have been searched
  echo "<br />";
  echo "Possible More Solution ...";
  echo "<br />";
}
