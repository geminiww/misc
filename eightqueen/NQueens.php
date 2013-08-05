<?php
/**
 * Class: N Queen Puzzle Solver
 * 
 * Solution to N-queens problem, using backtracking without distiguishing symmetry ones
 * 
 * @author     Wei Wu <geminiwyn@hotmail.com>
 * @version    1.0
 * @copyright  2013 Wei Wu
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 */

/**
 * Define Consts
 */
define('PUZZLE_SIZE', 8);

define('SOLUTION_LIMIT', 100);                    // Stop after found (*) solutions - for large puzzle size

/**
 * Class NQueenSolver
 */
class NQueenSolver {

  private static $__puzzle_size = PUZZLE_SIZE;
  private static $__instance = null;

  private static $solved = false;
  private static $solutions = null;
  private static $solutions_count = 0;

  private static $partial_complete = false;       // indicator for stoppped before finishing all posibilities
  private static $queens = null;                  // just for convenience as class variable - for share between functions

  /**
   * Singleton Pattern for this class
   */
  private function __construct(){}
  public static function getInstance(){
    if (self::$__instance == null) self::$__instance = new NQueenSolver;
    return self::$__instance;
  }

  /**
   * Check if the puzzle has been solved
   */
  public function isSolved() {
    return self::$solved;
  }

  /**
   * Check if all posibilities have been tested
   */
  public function isSolvedPartially() {
    return self::$partial_complete;
  }

  /**
   * Return solutions results as muti-level array, work out the puzzle if haven't solved before
   */
  public function getSolutions() {
    if (self::$solved != true) self::_solve();
    return self::$solutions;
  }

  /**
   * Solve the puzzle and return count of solutions, not re-solve if done already
   */
  private function _solve() {
    if (self::$solved != true) {                  // try solve only if has not been completed before
      self::$solutions = array();
      self::$queens = array();
      $y = 1; $x = 1;                             // start from (1, 1)
      while ($y > 0) {
        if (self::$solutions_count == SOLUTION_LIMIT) { // Stop after found (*) solutions
          self::$partial_complete = true;
          break;
        }
        if ($x > PUZZLE_SIZE) {                   // if reaches the last position on board - move up a line
            // - Move up -
            $x = self::$queens[$y - 1] + 1;
            $y --;
            continue;
        }
        // Try place a queen
        self::$queens[$y] = $x;
        if (self::_isConflict($y)) {              // Test for confilict
          $x ++;                                  // Try next position
          continue;
        }
        if ($y < PUZZLE_SIZE) {                   // More queens to place, try next line
          // - Move down -
          $y ++;
          $x = 1;
          continue;
        }
        self::_recordSolution();                  // In last line and solution found
        $x ++;                                    // keep going
      }
    }
  }

  /**
   * Solve the puzzle and return count of solutions, not re-solve if done already
   */
  private function _isConflict($y) {
    $x = self::$queens[$y];
    for ($t_y = 1; $t_y < $y ; $t_y ++) {
      $t_x = self::$queens[$t_y];
      if ($t_x == $x or
          abs($t_x - $x) == abs($t_y - $y)) {
        // conflict detected
        return true;
      }
    }
    return false;
  }

  /**
   * code block for recording a solution
   */
  private function _recordSolution() {
    self::$solutions[] = self::$queens;           // save solution
    self::$solutions_count ++;                    // increase counter
  }

}
