/**
 * Solution to Eight Queen Puzzle - Javascipt Version
 * 
 * Solution to Eight Queen => N-queens problem, using backtracking without distiguishing symmetry ones
 * 
 * @author     Wei Wu <geminiwyn@hotmail.com>
 * @version    1.1
 * @copyright  2013 Wei Wu
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @todo       refactor solve loop for showing each queen placement - too quick to be seen currently
 */
 
/**
 * Initialise - all variable in global scope
 */
var puzzle_size = 8;                              // puzzle size
var solutions = new Array();
var queens = new Array();
var counter = 0;

// ---- Main ----

$(document).ready(function(){
  drawBoard();                                    // draw the puzzle board
  drawStart();                                    // provide a start button
});

// ---- Functions ----

/**
 * Function to draw puzzle board
 */
function drawBoard() {
  var html_output = '<table id="board" cellpadding="0" cellspacing="0" border="0">';
  for (i = 1; i <= puzzle_size; i++) {            // for each line
    html_output += '<tr>';
    for (j = 1; j <= puzzle_size; j++) {          // for each cell
      if ( (i + j) % 2 == 0 ) style_color = 'color-0';
      else  style_color = 'color-1';
      html_output += '<td id="cell-' + i + '-' + j + '" class="' + style_color + '">';
      html_output += '<img class="board-cell" src="img/empty.png">';
      html_output += '</td>';      
    }
    html_output += '</tr>';
  }
  html_output += '</table>';
  $('#puzzle-wrapper').html(html_output);
}

/**
 * Function to draw & remove start button
 */
function drawStart() {
  $('#puzzle-wrapper').append('<p id="start-link"><a href="#" onClick="startSolve();">Click to start</a></p>');
}
function removeStart() {
  $('#start-link').remove();
}

/**
 * Function to draw & erase queen on board
 */
function drawPlaceQueen(ty, tx) {
  $('#cell-' + ty + '-' + tx).find('img').attr("src","img/queen.png");
  
}
function drawRemoveQueen(ty, tx) {
  $('#cell-' + ty + '-' + tx).find('img').attr("src","img/empty.png");
}

/**
 * Function to start solve - wrapper
 */
function startSolve() {
  if (counter < 1 ) {
    removeStart();
    solve();
  }
}

/**
 * Function to solve - the loop
 */

function solve(){
  y = 1; x = 1;                                   // start from (1, 1)
  while (y > 0) {
    //...
    if (x > puzzle_size) {                        // if reaches the last position on board - move up a line
      // - Move up -
      x = queens[y - 1] + 1;
      y --;
      drawRemoveQueen(y, x - 1);                  // erase the last queen
      continue;
    }
    // Try place a queen
    queens[y] = x;
    d_y = y; d_x = x;                             // note down the last draw
    drawPlaceQueen(d_y, d_x);                     // draw the queen on board
    if (hasConflict(y)) {                         // Test for confilict
      drawRemoveQueen(d_y, d_x);
      x ++;                                       // Try next position
      continue;
    }
    if (y < puzzle_size) {                        // More queens to place, try next line
      // - Move down -
      y ++;
      x = 1;
      continue;
    }
    findSolution();                               // In last line and solution found
    drawRemoveQueen(d_y, d_x);                    // erase the queen - conflict
    x ++;                                         // keep going
  }
}

/**
 * Function to test conflict
 */
function hasConflict(y) {
  x = queens[y];
  for (t_y = 1; t_y < y ; t_y ++) {
    t_x = queens[t_y];
    if (t_x == x ||
        Math.abs(t_x - x) == Math.abs(t_y - y)) {
        // conflict detected
        return true;
    }
  }
  return false;
}

/**
 * Function for record each solution
 */
function findSolution() {
  counter ++;                                     // increase counter
  var ouput = '';
  for (var i = 1; i <= puzzle_size; i++) {
    ouput += queens[i] + ' ';
  }
  //alert('Solution: ' + counter + ' : ' + ouput);
  queen_clone = queens.slice(0);                  // trick to copy array by value
  solutions[counter] = queen_clone;
  // append to solution panel
  $("#solution-wrapper").append( '<div class="solution" >' +
                                 '<a href="#" onClick="showSolution(' + counter + ');" class="solution-link">' +
                                 '&dash;&gt;&nbsp;# ' + counter + ' : ' + ouput + '</a></div>' );
}

/**
 * Function for showing each solution after click from solution panel
 */
function showSolution(index){
  tmp_queens = solutions[index];
  $('#board  tr  td').find('img').attr("src","img/empty.png");
  for (var ty = 1; ty <= puzzle_size; ty++) {
    var tx = tmp_queens[ty];
    $('#cell-' + ty + '-' + tx).find('img').attr("src","img/queen.png");
  }
  return false;
}
