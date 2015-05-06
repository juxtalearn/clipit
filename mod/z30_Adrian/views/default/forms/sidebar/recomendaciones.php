<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<!--<img src="http://clipit.es/landing/mod/z03_clipit_global/graphics/icons/clipit_logo.png" alt="clipit_logo.png" width="303" height="42">-->
<h1>Filters</h1>
<!--Choose Recommender Type:<br />
<select name="filtertype">
    <option value="same">Same Activity</option>
    <option value="others">Others Activities</option>
    <option value="all">All Activities</option>
    <option value="none">None</option>
</select>
<br />
<input type="submit" value="Recommender">-->
<!--<br />
Choose Recommender Media:<br />
<select name="media">
    <option value="1">Menos de 1</option>
    <option value="2">Entre 1 y 2</option>
    <option value="3">Entre 2 y 3</option>
    <option value="4">Entre 3 y 4</option>
    <option value="5">Entre 4 y 5</option>
</select>
<input type="submit" value="Recommender">-->

<?php echo("<form action=\"".elgg_get_site_url()."action/uploaded_recommenders\">");?>
<font color=#2E9AFE><b>Choose Recommender Type:</b></font><br />
<input type="radio" name="filtertype" value="same" checked>Same Activity
<br>
<input type="radio" name="filtertype" value="others">Others Activities
<br>
<input type="radio" name="filtertype" value="all" checked>All Activities
<br>
<input type="radio" name="filtertype" value="none" checked>None
<br><br>
<font color=#2E9AFE><b>Choose Recommender Media:</b></font><br />
<input type="radio" name="media" value="1" checked>Menos de 1
<br>
<input type="radio" name="media" value="2">Entre 1 y 2
<br>
<input type="radio" name="media" value="3" checked>Entre 2 y 3
<br>
<input type="radio" name="media" value="4" checked>Entre 3 y 4
<br>
<input type="radio" name="media" value="5" checked>Entre 4 y 5
<br>
<small><i>This choice only works in NONE option</i></small><br><br>

<input type="submit" value="Recommender">
</form>

