
<html>
<head>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<script type="text/javascript">
$(document).ready(function() {
    $('#submitBtn').click(function () {
        var tt = $('#tt').val();
        var sb1 = $('#sb1').val();
        var sb2 = $('#sb2').val();
        var sb3 = $('#sb3').val();
        $.post('ajax/view/recommendation/tricky_topic', {action: 'getRecommendation', tt: tt, sb1: sb1, sb2: sb2, sb3: sb3}, function(data,status) {
            document.write(data);
            elgg.system_message(data);
        });
    })
    $('#submitAllBtn').click(function () {
        var tt = $('#tt').val();
        var sb1 = $('#sb1').val();
        var sb2 = $('#sb2').val();
        var sb3 = $('#sb3').val();
        $.post('ajax/view/recommendation/tricky_topic', {action: 'getAllRecommendation', tt: tt, sb1: sb1, sb2: sb2, sb3: sb3}, function(data,status) {
            elgg.system_message(data);
            //document.write(data);
        });
    })
    $('#getQuizQuestionBtn').click(function () {
        var tt = $('#tt').val();
        var sb1 = $('#sb1').val();
        var sb2 = $('#sb2').val();
        var sb3 = $('#sb3').val();
        $.post('ajax/view/recommendation/tricky_topic', {action: 'getAllQuizQuestions', tt: tt, sb1: sb1, sb2: sb2, sb3: sb3}, function(data,status) {
            elgg.system_message(data);
            //document.write(data);
        });
    })
})
</script>
</head>
<body>

<div class="form-group">
    <label class="text-muted"><?php echo elgg_echo('Hier Tricky Topic eingeben');?></label>
    <?php echo elgg_view("input/text", array(
        'name' => 'tt',
        'id' => 'tt',
        'class' => 'form-control',
        'style' => 'padding: 0;height: 30px; width: 200px',
        'value' => '',
    ));?>

    <label class="text-muted"><?php echo elgg_echo('Und hier die Stumbling Blocks');?></label>
     <?php echo elgg_view("input/text", array(
        'name' => 'sb1',
        'id' => 'sb1',
        'class' => 'form-control',
        'style' => 'padding: 0;height: 30px; width: 200px',
        'value' => '',
    ));
      echo elgg_view("input/text", array(
        'name' => 'sb2',
        'id' => 'sb2',
        'class' => 'form-control',
        'style' => 'padding: 0;height: 30px; width: 200px',
        'value' => '',
    ));
     echo elgg_view("input/text", array(
         'name' => 'sb3',
         'id' => 'sb3',
         'class' => 'form-control',
         'style' => 'padding: 0;height: 30px; width: 200px',
         'value' => '',
     ));
    ?>
</div>

<div class="text-left">
    <?php echo elgg_view('input/submit', array(
        'class' => 'btn btn-primary btn-sm',
        'value'  => elgg_echo('Recommend for TT above'),
        'id' => 'submitBtn',
    ));
    ?>
</div>

<div class="text-left">
    <?php echo elgg_view('input/submit', array(
        'class' => 'btn btn-primary btn-sm',
        'value'  => elgg_echo('GetQuizQuestions'),
        'id' => 'getQuizQuestionBtn',
    ));
    ?>
</div>

<div class="text-left">
    <?php echo elgg_view('input/submit', array(
        'class' => 'btn btn-primary btn-sm',
        'value'  => elgg_echo('Recommendations for all my TTs'),
        'id' => 'submitAllBtn',
    ));
    ?>
</div>

</body>

