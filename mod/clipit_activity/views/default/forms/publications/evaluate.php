<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   14/05/14
 * Last update:     14/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
elgg_load_js("jquery:raty");
?>
<style>
.input-radios-horizontal{
    margin-bottom: 0;
}
.fa-star.empty{
    color: #bae6f6;
}
.rating .fa-star{
    cursor: pointer;
}
.rating i.fa-star:hover:before, .rating i.fa-star:hover ~ i.fa-star:before {
    content: "\f005";
    color: #e7d333;
}
#my-rating .rating .fa-star{
    position: relative;
    overflow: hidden;
}
#my-rating .rating .fa-star input[type=radio]{
    position: absolute;
    top: 0;
    left: 0;
    opacity: 0;
    cursor: pointer;
}
#my-rating .rating_test{
    width: auto !important;
}
</style>
<script>
    $(function(){

        $('div.rating_test').raty({
            width: "",
            starOff : 'fa-star fa empty',
            starOn  : 'fa-star fa'
        });

//        $("#my-rating .fa-star").click(function(){
//            var check = $(this).find("input[type=radio]:checked");
//            var index = $(this).index();
//            var index = check.val();
//            var rating = $(this).closest(".rating");
//            console.log(index);
//            rating.find(".fa-star").slice(0, index).removeClass("empty");
////            $("#my-rating .rating .fa-star").each(function(i, val){
////                $(this).val();
////            });
//        });
//        $("#my-rating .fa-star").hover(function(){
//            $(this).removeClass("empty");
//        },function(){
//            $(this).addClass("empty");
//        });
    });
</script>
<div class="row">
    <div class="col-md-8">
        <span class="show">
            Does this video help you to understand Tricky Topic?
        </span>
        <?php echo elgg_view('input/radio', array(
            'name' => 'tricky-understand',
            'options' => array(elgg_echo("input:yes"), elgg_echo("input:no")),
            'class' => 'input-radios-horizontal blue',
        )); ?>
        <span class="show">
            Check topics covered in this video, and explain why:
        </span>
        <div style="margin-top: 5px;">
            <label style="display: inline-block">Trabajo y potencia</label>
            <?php echo elgg_view('input/radio', array(
                'name' => "admin",
                'options' => array(elgg_echo("input:yes"), elgg_echo("input:no")),
                'class' => 'input-radios-horizontal blue pull-right',
            )); ?>
        </div>
        <?php echo elgg_view("input/plaintext", array(
                'name'  => 'file-description',
                'class' => 'form-control',
                'placeholder' => 'Why is/isn\'t this SB correctly covered?',
                'required' => true,
                'rows'  => 1,
            ));
        ?>
        <div style="margin-top: 5px;">
        <label style="display: inline-block">Cinética</label>
        <?php echo elgg_view('input/radio', array(
            'name' => "admin",
            'options' => array(elgg_echo("input:yes"), elgg_echo("input:no")),
            'class' => 'input-radios-horizontal blue pull-right',
        )); ?>
        <?php echo elgg_view("input/plaintext", array(
            'name'  => 'file-description',
            'class' => 'form-control',
            'placeholder' => 'Why is/isn\'t this SB correctly covered?',
            'required' => true,
            'onclick' => '',
            'onclick'   => '$(this).addClass(\'mceEditor\');tinymce_setup();',
            'rows'  => 1,
        ));
        ?>
        </div>
    </div>
    <div class="col-md-4">
        <div class="pull-right" id="my-rating">
            <h4>
                <strong>My rating</strong>
            </h4>
            <div style="margin: 10px 0;">
                <div class="rating" style="color: #e7d333;float: right;font-size: 18px;;margin: 0 10px;direction: rtl;">
                    <i class="fa fa-star empty"><input type="radio" name="rating[]" value="5"></i>
                    <i class="fa fa-star empty"><input type="radio" name="rating[]" value="4"></i>
                    <i class="fa fa-star empty"><input type="radio" name="rating[]" value="3"></i>
                    <i class="fa fa-star empty"><input type="radio" name="rating[]" value="2"></i>
                    <i class="fa fa-star empty"><input type="radio" name="rating[]" value="1"></i>
                </div>
                <span class="text-truncate" style="padding-top: 2px;">Innovation</span>
            </div>
            <div style="margin: 10px 0;">
                <div class="rating_test" style="color: #e7d333;float: right;font-size: 18px;margin: 0 10px;">
                </div>
                <span class="text-truncate" style="padding-top: 2px;">TEST</span>
            </div>
            <div style="margin: 10px 0;">
                <div class="rating" style="color: #e7d333;float: right;font-size: 18px;;margin: 0 10px;direction: rtl;">
                    <i class="fa fa-star empty"></i>
                    <i class="fa fa-star empty"></i>
                    <i class="fa fa-star empty"></i>
                    <i class="fa fa-star empty"></i>
                    <i class="fa fa-star empty"></i>
                </div>
                <span class="text-truncate" style="padding-top: 2px;">Design</span>
            </div>
            <div style="margin: 10px 0;">
                <div class="rating" style="color: #e7d333;float: right;font-size: 18px;margin: 0 10px;direction: rtl;">
                    <i class="fa fa-star empty"></i>
                    <i class="fa fa-star empty"></i>
                    <i class="fa fa-star empty"></i>
                    <i class="fa fa-star empty"></i>
                    <i class="fa fa-star empty"></i>
                </div>
                <span class="text-truncate" style="padding-top: 2px;">Learning</span>
            </div>
        </div>
    </div>
</div>
<div style="margin-top: 20px;">
<?php echo elgg_view('input/submit',
    array(
        'value' => elgg_echo('submit'),
        'class' => "btn btn-primary"
    ));
?>
</div>