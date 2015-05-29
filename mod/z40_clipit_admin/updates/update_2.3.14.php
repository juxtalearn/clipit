<?php
// Adapt Performance Items to new format
switch(get_config("language")){
    case "en":
        $pos = 0;
        break;
    case "es":
        $pos = 1;
        break;
    case "de":
        $pos = 2;
        break;
    case "pt":
        $pos = 3;
        break;
    case "sv":
        $pos = 4;
        break;
    default:
        $pos = 0;
}

$perf_items = ClipitPerformanceItem::get_all();

foreach($perf_items as $perf_item){
    $elgg_object = new ElggObject($perf_item->id);
    $elgg_object->name = (string)$elgg_object->item_name[$pos];
    $elgg_object->description = (string)$elgg_object->item_description[$pos];
    $elgg_object->example = (string)$elgg_object->example[$pos];
    $elgg_object->category = (string)$elgg_object->category[$pos];
    $elgg_object->category_description = (string)$elgg_object->category_description[$pos];
    $elgg_object->save();
}
