<?php
$activity_id = get_input("activity_id");
$group_id = get_input("group_id");
$widget_id = get_input("widget_id");
?>
<head><link rel="stylesheet" type="text/css"
            href="http://ajax.googleapis.com/ajax/libs/dojo/1.10.4/dojo/resources/dojo.css"/>
    <link rel="stylesheet" type="text/css"
          href="http://ajax.googleapis.com/ajax/libs/dojo/1.10.4/dijit/themes/dijit.css"/>
    <link rel="stylesheet" type="text/css"
          href="http://ajax.googleapis.com/ajax/libs/dojo/1.10.4/dijit/themes/claro/claro.css"/>
    <script src="http://ajax.googleapis.com/ajax/libs/dojo/1.10.4/dojo/dojo.js"></script>
	</head>
<body class="claro">

<?php echo elgg_view("dojovis/progresscomparison",array('activity_id'=>$activity_id, 'group_id'=>$group_id,'widget_id'=>$widget_id)); ?>
</body>