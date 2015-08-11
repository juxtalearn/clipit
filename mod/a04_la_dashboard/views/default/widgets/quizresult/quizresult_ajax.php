<?php
extract($_GET);
$activity = array_pop(ClipitActivity::get_by_id(array($activity_id)));



//$group = ClipitGroup::get_by_id(array($group_id));
$quiz = array_pop(ClipitQuiz::get_by_id(array($quiz_id)));
$spider_colors = array("FF0000", "00FF00", "0000FF", "FFFF00", "FF00FF", "00FFFF", "000000",
    "800000", "008000", "000080", "808000", "800080", "008080", "808080",
    "C00000", "00C000", "0000C0", "C0C000", "C000C0", "00C0C0", "C0C0C0",
    "400000", "004000", "000040", "404000", "400040", "004040", "404040",
    "200000", "002000", "000020", "202000", "200020", "002020", "202020",
    "600000", "006000", "000060", "606000", "600060", "006060", "606060",
    "A00000", "00A000", "0000A0", "A0A000", "A000A0", "00A0A0", "A0A0A0",
    "E00000", "00E000", "0000E0", "E0E000", "E000E0", "00E0E0", "E0E0E0");
?>
<head>
    <link rel="stylesheet" type="text/css"
          href="http://ajax.googleapis.com/ajax/libs/dojo/1.10.4/dojo/resources/dojo.css"/>
    <link rel="stylesheet" type="text/css"
          href="http://ajax.googleapis.com/ajax/libs/dojo/1.10.4/dijit/themes/dijit.css"/>
    <link rel="stylesheet" type="text/css"
          href="http://ajax.googleapis.com/ajax/libs/dojo/1.10.4/dijit/themes/claro/claro.css"/>
    <script src="http://ajax.googleapis.com/ajax/libs/dojo/1.10.4/dojo/dojo.js"></script>
</head>
<body class="Claro">
<?php
$options = array('question_or_stumbling_block' => $question_or_stumbling_block, 'activity' => $activity, 'quiz' => $quiz, 'scale' => $scale, 'group_id' => $group_id, 'taskname' => $taskname, 'widget_id' => $widget_id, 'spider_colors'=>$spider_colors);

switch ($question_or_stumbling_block) {
    case ClipitTag::SUBTYPE:
        echo elgg_view('widgets/quizresult/content_sb', $options);

        break;
    case ClipitQuizQuestion::SUBTYPE:
        echo elgg_view('widgets/quizresult/content_quest', $options);
        break;
} ?>
</body>

