<?php
class RecommendationEngine {
    public static function get_recommended_items($entity_id, $item_types = ["video", "file", "storyboard", "resource"], $number_of_items = 5) {
        $items = array();
        foreach ($item_types as $type) {
            $new_items = RecommendationEngine::calculate_recommendations($entity_id, $type, $number_of_items);
            $items = array_merge($new_items, $items);
        }
        RecommendationEngine::order_and_limit_results($items, $number_of_items);
        return $items;
    }

    public static function get_recommended_lsd_videos($entities, $number_of_items = 5) {
        $results = array();
        foreach ($entities as $entity_id) {
            $item_types = ["public_video"];
            $videos = RecommendationEngine::get_recommended_items($entity_id, $item_types, $number_of_items);
            $results = array_merge($results, $videos);
        }
        $results = RecommendationEngine::order_and_limit_results($results, $number_of_items);
        return $results;
    }

    public static function get_recommended_videos($entity_id, $number_of_items = 5) {
        $item_types = ["video"];
        return RecommendationEngine::get_recommended_items($entity_id, $item_types, $number_of_items);
    }
    public static function get_recommended_files($entity_id, $number_of_items = 5) {
        $item_types = ["file"];
        return RecommendationEngine::get_recommended_items($entity_id, $item_types, $number_of_items);
    }
    public static function get_recommended_storyboards($entity_id, $number_of_items = 5) {
        $item_types = ["storyboard"];
        return RecommendationEngine::get_recommended_items($entity_id, $item_types, $number_of_items);
    }
    public static function get_recommended_resources($entity_id, $number_of_items = 5) {
        $item_types = ["resource"];
        return RecommendationEngine::get_recommended_items($entity_id, $item_types, $number_of_items);
    }
    public static function get_recommended_users($entity_id, $number_of_items = 5) {
        $item_types = ["user"];
        return RecommendationEngine::get_recommended_items($entity_id, $item_types, $number_of_items);
    }

    public static function calculate_recommendations($entity_id, $type, $number_of_items) {
        $results = array();
        $global_items = array();
        $public_items = array();
        $private_items = array();
        //The first step is retrieving the user profile
        $entity_profile = KnowledgeRepresentationComponent::get_user_profile($entity_id);

        //The next step is to collect all public items
        switch ($type) {
            case "video":
                $private_items = array();
            case "public_video":
                $global_items = ClipitSite::get_pub_videos();
                $public_items = ClipitSite::get_videos();
                break;
            case "file":
                $global_items = ClipitSite::get_pub_files();
                $public_items = ClipitSite::get_files();
                break;
            case "storyboard":
                $global_items = ClipitSite::get_pub_storyboards();
                $public_items = ClipitSite::get_storyboards();
                break;
            case "resource":
                $global_items = ClipitSite::get_pub_resources();
                $public_items = ClipitSite::get_resources();
                break;
            case "user":
                $public_items = ClipitUser::get_all();
                break;
        }
        $items = array_merge($public_items, $private_items, $global_items);
        foreach ($items as $item) {
            $item_profile = KnowledgeRepresentationComponent::get_item_profile($item);
            $similarity = RecommendationEngine::calculate_similarity($entity_profile, $item_profile);
            $results[] = ['entity_id' => $item, 'type' => $type, 'rating' => $similarity];
        }

        $results = RecommendationEngine::order_and_limit_results($results, $number_of_items);
        return $results;
    }

    public static function calculate_similarity($user_profile, $item_profile) {
        $common_profile_value = 0;
        $length_user_profile = count($user_profile);
        //$length_item_profile = count($item_profile);
        $common_profile = array();
        if (!empty($item_profile)) {
            foreach ($user_profile as $key => $value) {
                if (array_key_exists($item_profile, $key)) {
                    $common_profile[] = array($key => $value);

                    /*  $common_profile_value is the aggregated value of all common items, valued by the stored expertise
                        in the user profile. If his expertise is 1, nothing is added. If his expertise is -1 instead we
                        add 2. No previous knowledge means valueing it at 1
                    */
                    $common_profile_value = $common_profile_value + (1 - $value);
                }
            }
        }
        $common_profile_length = count($common_profile);
        if ($length_user_profile != 0) {
            $similarity = $common_profile_value * ($common_profile_length / $length_user_profile);
        }
        else {
            $similarity = 0;
        }
        $similarity = 10 / rand(10,20);
        return $similarity;
    }

    public static function order_and_limit_results($results, $number_of_items) {
        //First we need to remove duplicates (items can occur in more than one scope...
        $results = RecommendationEngine::remove_duplicates($results);
        //Then we need to check if $results contains at least $number_of_items
        if (!(sizeof($results) >= $number_of_items)) {
            $number_of_items = sizeof($results);
        }
        foreach ($results as $key => $row) {
            if (array_key_exists('rating', $row)) {
                $rating[$key] = $row['rating'];
            }
            else {
                $rating[$key] = 0;
            }
        }
        array_multisort($rating, SORT_DESC, SORT_NUMERIC, $results);
        $filtered_results = array_slice($results, 0, $number_of_items);
        return $filtered_results;
    }

    public static function remove_duplicates($results) {
        $item_ids = array();
        foreach ($results as $index => $item) {
            if (in_array($item['entity_id'], $item_ids)) {
                unset($results[$index]);
            }
            else {
                $item_ids[] = $item['entity_id'];
            }
        }
        return $results;
    }
}
