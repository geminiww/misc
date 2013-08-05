<?php
/**
 * Solution to Eight Queen Puzzle
 * 
 * Solution to Eight Queen => N-queens problem, using backtracking without distiguishing symmetry ones
 * 
 * @author     Wei Wu <geminiwyn@hotmail.com>
 * @version    1.0
 * @copyright  2013 Wei Wu
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 */

/**
 * Define puzzle size for n queen
 */
define('PUZZLE_SIZE', 8);

/**
 * Initializes variables - all in global scope
 */

$solutions_array = array();             // for all solutions
$queens = array();                      // for queens positions during process $queens[y] = x;

// start from line 1, position 1
$line = 1;                              // line - y, global
$position = 1;                          // position - x, global

$all_searched = false;                  // loop flag - although not quite necessary (line > 0)
$loop_count = 0;                        // loop count; for stop halfway when a large PUZZLE_SIZE is given
define('MAX_LOOP_COUNT', 100000);

/**
 * Try place queen at (line, position) till tracking back to line < 1
 */

while (!$all_searched) {

  if (++$loop_count > MAX_LOOP_COUNT) break;      // stop when needed
  if ($line < 1) {                                // tracking back to before the first line - all searched and stop
    // - All done -
    $all_searched = true;                         // set flag and stop at the begining of next loop
    continue;
  }
  if ($position > PUZZLE_SIZE) {                  // if reaches the last position on board - move up a line
      // - Move up -
      $position = $queens[$line - 1] + 1;
      $line --;
      continue;
  }

  // Try place a queen
  $queens[$line] = $position;

  if (has_conflict($line)) {                      // Test for confilict
    $position ++;                                 // Try next position
    continue;
  }
  if ($line < PUZZLE_SIZE) {                      // More queens to place, try next line
    // - Move down -
    $line ++;
    $position = 1;
    continue;
  }

  // In last line and solution found
  $solutions_array[] = $queens;                   // save solution
  $position ++;                                   // keep going

  //tep_output();                                 // display the solution on the way

}

/**
 * Display all solutions
 */
$count = 0;
foreach ($solutions_array as $solution) {
  $count ++;                                      // just counter
  echo "<br /> -- Solution # $count -- <br /> ";
  foreach ($solution as $line => $queen) {
    echo "$queen ";
  }
  echo "<br />";
}


// ---- Utility Functions ----

/**
 * Function for testing if a conflict has occured
 */

function has_conflict($curreny_line) {            // testing each line from, current backwards to the first
  global $queens;
  $current_position = $queens[$curreny_line];
  for ($line = $curreny_line - 1; $line >= 1; $line --) {
    $compare_position = $queens[$line];
    if ($compare_position == $current_position or 
        abs($compare_position - $current_position) == $curreny_line - $line ) {
      return true;                                // conflict detected
    }
  }
  return false;
}

/**
 * Function output result
 */

function tep_output() {
  global $queens;
  foreach ($queens as $queen) {
    echo "$queen ";
  }
  echo "<br />";
}
