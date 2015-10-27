<?php
/**
 * Created by PhpStorm.
 * User: cs
 * Date: 06.08.15
 * Time: 11:40
 */
$user = elgg_extract('user', $vars);
$userLanguage = $user->language;

if(strcmp($userLanguage, "en") == 0){
    $title = "Recommendations by Relevance: ";

}elseif(strcmp($userLanguage, "de") == 0){
    $title = "Empfehlungen nach Relevanz: ";

}elseif(strcmp($userLanguage, "es") == 0){
    $title = "Recomendaciones de relevancia: ";

}elseif(strcmp($userLanguage, "sv") == 0){
    $title = "Rekommendationer efter relevans: ";

}elseif(strcmp($userLanguage, "pt") == 0){
    $title = "Recomendacoes por relevância: ";
}


?>
<div class='module-tags'>
    <div id='tagDiv'>

        <br>
        <br>
        <div id='title'>


            <h4><?php echo $title ?></h4>
        </div>

        <div class='wrapper separator'>

            <div id='loading-spinner' class="wrapper separator loading-block" style="display:none">
                <div>
                    <i class="fa fa-spinner fa-spin blue-lighter" ></i>
                </div>
            </div>

            <ul class='tag-cloud' id='recommendations' >

            </ul>


        </div>
    </div>
</div>