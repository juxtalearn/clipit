<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   14/10/2015
 * Last update:     14/10/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$entity = elgg_extract('entity', $vars);
$scope_entity = elgg_extract('scope_entity', $vars);
echo elgg_view("input/hidden", array(
    'name' => 'entity-id',
    'value' => $entity->id,
));
echo elgg_view("input/hidden", array(
    'name' => 'scope-id',
    'value' => $scope_entity->id,
));
?>
<div class="form-group">
    <label for="title"><?php echo elgg_echo("title");?></label>
    <?php echo elgg_view("input/text", array(
        'name' => 'title',
        'value' => $entity->name,
        'class' => 'form-control',
        'autofocus' => true,
        'required' => true,
    ));?>
</div>
<div class="form-group">
    <label for="url"><?php echo elgg_echo("url");?> <small><?php echo elgg_echo('optional');?></small></label>
    <?php echo elgg_view("input/text", array(
        'name' => 'url',
        'id' => 'url',
        'value' => $entity->name,
        'class' => 'form-control',
        'placeholder' => 'http://www.website.com',
    ));?>
    <div class="url-data-info margin-top-15" style="display: none;"></div>
</div>
<script>
$(function(){
    $(document).on('keyup', '#url', function(){
        var $that = $(this),
            container = $that.parent('.form-group').find('.url-data-info');
        var urlRegex = /(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig;
        // Filtering URL from the content using regular expressions
        var url= $that.val().match(urlRegex);
        if(url && url.length>0) {
            container.html('<i class="fa fa-spinner fa-spin fa-2x"/>').fadeIn('slow');
            elgg.action('multimedia/texts/extract', {
                data: {
                    q: $that.val()
                },
                success: function (data) {
                    console.log(data);
                    if (data.output) {
                        container.html(data.output);
                    }
                }
            });
        }
    });
});
</script>
<div>
    <div id="lessoncup">

        <div id="data">

            <div class="btn" id="btn">POST</div>

            <div id="result" class="result"></div>

        </div>

    </div>

</div>
<div class="form-group">
    <label for="description"><?php echo elgg_echo("description");?></label>
    <?php echo elgg_view("input/plaintext", array(
        'name'  => 'description',
        'value' => $entity->description,
        'id'    => 'edit-'.$entity->id,
        'class' => 'form-control mceEditor',
        'rows'  => 6,
    ));?>
</div>
<script>

    $(document).ready(function(){


        $('#btn').click(function(){

            var text = $('#url').val();

            $('#result').fadeIn(400);

            $("#result").oembed(text,
                {
                    embedMethod: "append", // you can use .. fill , auto , replace
                    maxWidth: 600,
                    maxHeight: 350,
                });


            $('#url').val("");


        });

    });

</script>
<script src="http://rawgit.com/nfl/jquery-oembed-all/master/jquery.oembed.js"></script>