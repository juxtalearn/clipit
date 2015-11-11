<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   24/04/14
 * Last update:     24/04/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$option = elgg_extract('options', $vars);
?>
<?php if(!empty($option)):?>
<script>
    $(function(){
        $('.select-all').click(function(){
            var form = $(this).closest("form");
            var table= $('.table');
            $('input:checkbox', form).prop('checked',this.checked);
            if($('input:checkbox', form).prop("checked") == true){
                $(".select-options").prop("disabled", false);
            } else {
                $(".select-options").prop("disabled", true);
            }
        });
        $('.select-simple').click(function(){
            var that = $(this);
            $('.select-simple').each(function(){
                if($(this).prop("checked") == true || that.prop("checked") == true){
                    $(".select-options").prop("disabled", false);
                } else {
                    $(".select-options").prop("disabled", true);
                }
            });
        });
        $(".select-options").on("change", function(){
            if($(this).val().length > 0){
                $(this).closest("form").submit();
            }
        });
    });
</script>
<div style="margin-bottom: 30px;color #999;margin-left: 15px;margin-top: 10px;">
    <?php if($option['options_values']):?>
        <div class="checkbox" style=" display: inline-block;margin: 0;">
            <label>
                <input type="checkbox" class="select-all"> <?php echo elgg_echo("selectall"); ?>
            </label>
        </div>
        <div style=" display: inline-block; margin-left: 10px; ">
            <?php
            $options_dropdown = array(
                'disabled' => 'disabled',
                'class' => 'form-control select-options',
                'name'  => 'set-option',
                'style' => 'height: 20px;padding: 0;',
                'options_values' => $option['options_values']
            );
            echo elgg_view("input/dropdown", $options_dropdown); ?>
        </div>
    <?php endif; ?>
    <?php if($option['search']):?>
        <div class="pull-right search-box">
            <input type="text" placeholder="<?php echo elgg_echo('search');?>">
            <div class="input-group-btn">
                <span></span>
                <button type="submit">
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php endif;?>