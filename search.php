<?php
/********************************************************************************
*                                                                               *
*   Copyright 2012 Nicolas CARPi (nicolas.carpi@gmail.com)                      *
*   http://www.elabftw.net/                                                     *
*                                                                               *
********************************************************************************/

/********************************************************************************
*  This file is part of eLabFTW.                                                *
*                                                                               *
*    eLabFTW is free software: you can redistribute it and/or modify            *
*    it under the terms of the GNU Affero General Public License as             *
*    published by the Free Software Foundation, either version 3 of             *
*    the License, or (at your option) any later version.                        *
*                                                                               *
*    eLabFTW is distributed in the hope that it will be useful,                 *
*    but WITHOUT ANY WARRANTY; without even the implied                         *
*    warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR                    *
*    PURPOSE.  See the GNU Affero General Public License for more details.      *
*                                                                               *
*    You should have received a copy of the GNU Affero General Public           *
*    License along with eLabFTW.  If not, see <http://www.gnu.org/licenses/>.   *
*                                                                               *
********************************************************************************/
// Search.php
require_once('inc/common.php');
$page_title='Search';
require_once('inc/head.php');
require_once('inc/menu.php');
require_once('inc/info_box.php');
?>
<!-- Advanced Search page begin -->
<div class='center item'>
    <div class='advanced_search_div align_left'>
        <form name="search" method="get" action="search.php">
            <!-- SUBMIT BUTTON -->
            <button class='submit_search_button' type='submit'>
                <img src='themes/<?php echo $_SESSION['prefs']['theme'];?>/img/submit.png' name='Submit' value='Submit' />
                <p>FIND</p>
            </button>
            <p class='inline'>Search in : </p>
            <select name='type'>
                <option value='experiments'>Experiments</option>
                <?php // Database items types
                $sql = "SELECT * FROM items_types";
                $req = $bdd->prepare($sql);
                $req->execute();
                while ($items_types = $req->fetch()) {
                    echo "<option value='".$items_types['id']."' name='type'";
                    // item get selected if it is in the search url
                    if($items_types['id'] == $_GET['type']) {
                        echo " selected='selected'";
                    }
                    echo ">".$items_types['name']."</option>";
                }
                ?>
            </select>
            <br />
            <br />
            <div id='search_inputs_div'>
                <p class='inline'>Date</p><input name='date' type='text' size='6' id='datepicker' class='search_inputs'/><br />
<br />
                <p class='inline'>Title</p><input name='title' type='text' class='search_inputs'/><br />
<br />
                <p class='inline'>Tags</p><input name='tags' type='text' class='search_inputs'/><br />
<br />
                <p class='inline'>Body</p><input name='body' type='text' class='search_inputs' /><br />
            </div>

            </div>
            </div>

        </form>
    </div>
</div>

<?php
// assign varaibles from get
if (isset($_GET['title']) && !empty($_GET['title'])) {
    $title =  filter_var($_GET['title'], FILTER_SANITIZE_STRING);
}
if (isset($_GET['date']) && !empty($_GET['date'])) {
    $date = check_date($_GET['date']);
}
if (isset($_GET['tags']) && !empty($_GET['tags'])) {
    $tags = filter_var($_GET['tags'], FILTER_SANITIZE_STRING);
}
if (isset($_GET['body']) && !empty($_GET['body'])) {
    $body = check_body($_GET['body']);
}

// Is there a search ?
if (isset($_GET)) {

    // EXPERIMENT ADVANCED SEARCH
    if($_GET['type'] === 'experiments') {
        $sql = "SELECT * FROM experiments WHERE userid = :userid AND title LIKE '%$title%' AND date LIKE '%$date%' AND body LIKE '%$tags%'";
        $req = $bdd->prepare($sql);
        $req->execute(array(
            'userid' => $_SESSION['userid']
        ));
        // This counts the number or results - and if there wasn't any it gives them a little message explaining that 
        $count = $req->rowCount();
        if ($count > 0) {
            // make array of results id
            $results_id = array();
            while ($get_id = $req->fetch()) {
                $results_id[] = $get_id['id'];
            }
            // construct string for links to export results
            foreach($results_id as $id) {
                $results_id_str .= $id."+";
            }
            // remove last +
            $results_id_str = substr($results_id_str, 0, -1);
?>

            <div id='export_menu'>
            <p class='inline'>Export this result : </p>
            <a href='make_zip.php?id=<?php echo $results_id_str;?>&type=exp'>
            <img src='themes/<?php echo $_SESSION['prefs']['theme'];?>/img/zip.gif' title='make a zip archive' alt='zip' /></a>

                <a href='make_csv.php?id=<?php echo $results_id_str;?>&type=exp'><img src='img/spreadsheet.png' title='Export in spreadsheet file' alt='Export in spreadsheet file' /></a>
            </div>
<?php
            if ($count == 1) {
            echo "<div id='search_count'>".$count." result</div>";
            } else {
            echo "<div id='search_count'>".$count." results</div>";
            }
            echo "<div class='search_results_div'>";
            // Display results
            echo "<hr>";
            foreach ($results_id as $id) {
                showXP($id, $_SESSION['prefs']['display']);
            }
        } else { // no results
            echo "<p>Sorry, I couldn't find anything :(</p><br />";
        }

    // DATABASE ADVANCED SEARCH
    } elseif (is_pos_int($_GET['type'])) {
        $sql = "SELECT * FROM items WHERE type = :type AND title LIKE '%$title%' AND date LIKE '%$date%' AND body LIKE '%$tags%'";
        $req = $bdd->prepare($sql);
        $req->execute(array(
            'type' => $_GET['type']
        ));
        $count = $req->rowCount();
        if ($count > 0) {
            // make array of results id
            $results_id = array();
            while ($get_id = $req->fetch()) {
                $results_id[] = $get_id['id'];
            }
            // construct string for links to export results
            foreach($results_id as $id) {
                $results_id_str .= $id."+";
            }
            // remove last +
            $results_id_str = substr($results_id_str, 0, -1);
?>

            <div id='export_menu'>
            <p class='inline'>Export this result : </p>
            <a href='make_zip.php?id=<?php echo $results_id_str;?>&type=items'>
            <img src='themes/<?php echo $_SESSION['prefs']['theme'];?>/img/zip.gif' title='make a zip archive' alt='zip' /></a>

                <a href='make_csv.php?id=<?php echo $results_id_str;?>&type=items'><img src='img/spreadsheet.png' title='Export in spreadsheet file' alt='Export in spreadsheet file' /></a>
            </div>
<?php
            if ($count == 1) {
            echo "<div id='search_count'>".$count." result</div>";
            } else {
            echo "<div id='search_count'>".$count." results</div>";
            }
            echo "<div class='search_results_div'>";
            // Display results
            echo "<hr>";
            foreach ($results_id as $id) {
                showDB($id, $_SESSION['prefs']['display']);
            }
        } else { // no results
            echo "<p>Sorry, I couldn't find anything :(</p><br />";
        }
    }
}

// FOOTER
require_once('inc/footer.php');
?>
<script>
$(document).ready(function(){
    // DATEPICKER
    $( "#datepicker" ).datepicker({dateFormat: 'ymmdd'});
});
</script>
