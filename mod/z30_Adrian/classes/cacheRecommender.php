
<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of cacheRecommender
 *
 * @author addry
 */
class cacheRecommender extends UBItem {
    /**
     * @const string SUBTYPE Elgg entity SUBTYPE for this class
     */

    const SUBTYPE = "cacheRecommender";
    const RANGE_MEDIA = 0.25;
    const RATING_COMPARATOR = 3.5;
    const TAG_RATING = 0.75;

    public $user = 0;
    public $activity = 0;
    public $same_users = array();
    public $videos_same_activity = array();
    public $videos_other_activities = array();
    public $videos_all_activities = array();
    public $are_videos = 0;
    public $videos_better_ranking_less_one = array();
    public $videos_better_ranking_less_two = array();
    public $videos_better_ranking_less_three = array();
    public $videos_better_ranking_less_four = array();
    public $videos_better_ranking_less_five = array();

    protected function copy_from_elgg($elgg_entity) {
        parent::copy_from_elgg($elgg_entity);
        $this->same_users = (array) $elgg_entity->get("same_users");
        $this->videos_same_activity = (array) $elgg_entity->get("videos_same_activity");
        $this->videos_other_activities = (array) $elgg_entity->get("videos_other_activities");
        $this->videos_all_activities = (array) $elgg_entity->get("videos_all_activities");
        $this->user = (int) $elgg_entity->get("user");
        $this->activity = (int) $elgg_entity->get("activity");
        $this->are_videos = (int) $elgg_entity->get("are_videos");
        $this->videos_better_ranking_less_one = (array) $elgg_entity->get("videos_better_ranking_less_one");
        $this->videos_better_ranking_less_two = (array) $elgg_entity->get("videos_better_ranking_less_two");
        $this->videos_better_ranking_less_three = (array) $elgg_entity->get("videos_better_ranking_less_three");
        $this->videos_better_ranking_less_four = (array) $elgg_entity->get("videos_better_ranking_less_four");
        $this->videos_better_ranking_less_five = (array) $elgg_entity->get("videos_better_ranking_less_five");
    }

    /**
     * Copy $this object parameters into an Elgg entity.
     *
     * @param ElggEntity $elgg_entity Elgg object instance to save $this to
     */
    protected function copy_to_elgg($elgg_entity) {
        parent::copy_to_elgg($elgg_entity);
        $elgg_entity->set("same_users", (array) $this->same_users);
        $elgg_entity->set("videos_same_activity", (array) $this->videos_same_activity);
        $elgg_entity->set("videos_other_activities", (array) $this->videos_other_activities);
        $elgg_entity->set("videos_all_activities", (array) $this->videos_all_activities);
        $elgg_entity->set("user", (int) $this->user);
        $elgg_entity->set("activity", (int) $this->activity);
        $elgg_entity->set("are_videos", (int) $this->are_videos);
        $elgg_entity->set("videos_better_ranking_less_one", (array) $this->videos_better_ranking_less_one);
        $elgg_entity->set("videos_better_ranking_less_two", (array) $this->videos_better_ranking_less_two);
        $elgg_entity->set("videos_better_ranking_less_three", (array) $this->videos_better_ranking_less_three);
        $elgg_entity->set("videos_better_ranking_less_four", (array) $this->videos_better_ranking_less_four);
        $elgg_entity->set("videos_better_ranking_less_five", (array) $this->videos_better_ranking_less_five);
    }

    static function get_by_user_activity($user) {
//        $instance = array_pop(static::get_by_owner(array($user)));
//        return $instance;
        $all = static::get_all();
        foreach ($all as $instance) {
            if ($user == $instance->user)
            //($activity == $instance->activity))
                return $instance;
        }
    }
    
    static function is_list() {
        $all = static::get_all();
        foreach ($all as $instance) {
            if ($instance->are_videos == 1) {
                return $instance;
            }
        }
    }

    static function get_videos_better_rating($media = 5) {
        $instance = static::is_list();
        if (empty($instance)) {
            $prop_value_array = array();
            $prop_value_array["are_videos"] = 1;
            $videos_refund = array();
            $videos = ClipitVideo::get_all();
            $videos_better_rating = array();
            for ($rating = 1; $rating <= 5; $rating++) {
                foreach ($videos as $video) {
                    if (($rating - 1) < $video->performance_rating_average) {
                        if ($video->performance_rating_average < $rating) {
                            if (!in_array($video->id, $videos_better_rating)) {
                                $videos_better_rating[$rating][] = $video->id;
                            }
                        }
                    }
                }
                switch ($rating) {
                    case 1:
                        $prop_value_array["videos_better_ranking_less_one"] = $videos_better_rating[$rating];
                        break;
                    case 2:
                        $prop_value_array["videos_better_ranking_less_two"] = $videos_better_rating[$rating];
                        break;
                    case 3:
                        $prop_value_array["videos_better_ranking_less_three"] = $videos_better_rating[$rating];
                        break;
                    case 4:
                        $prop_value_array["videos_better_ranking_less_four"] = $videos_better_rating[$rating];
                        break;
                    case 5:
                        $prop_value_array["videos_better_ranking_less_five"] = $videos_better_rating[$rating];
                        break;
                }
                if ($rating == $media)
                    $videos_refund = $videos_better_rating[$rating];
            }
            if (empty($instance)) static::create($prop_value_array);
            else static::set_properties($instance->id, $prop_value_array);
            return $videos_refund;
        } else {
            switch ($media) {
                case 1:
                    return $instance->videos_better_ranking_less_one;
                    break;
                case 2:
                    return $instance->videos_better_ranking_less_two;
                    break;
                case 3:
                    return $instance->videos_better_ranking_less_three;
                    break;
                case 4:
                    return $instance->videos_better_ranking_less_four;
                    break;
                case 5:
                    return $instance->videos_better_ranking_less_five;
                    break;
            }
        }
    }

    static function get_videos_same_activity($user) {
        $instance = static::get_by_user_activity($user);
        if (empty($instance->videos_same_activity)) {
            $videos_same_activity = array();
            $users = ClipitUser::get_all();
            $videos = ClipitVideo::get_all(); // Cojo todos los videos
            $same_users = static::get_users_same_opinion($user, $users, $videos);
            for ($i = 0; $i < count($same_users); $i++) {
                //foreach ($this->same_users as $user_id) { // Recorro la lista de usuarios afines
                // Para cada usuario recorro todos los videos que hay
                foreach ($videos as $videoComparator) {
                    // Como es posible que ya se haya entrado en ese video por otro usuario, ponemos
                    // esta condicion para no gastar recursos
                    if (!in_array($videoComparator->id, $videos_same_activity)) {
                        // Solo vamos a recomendar videos de rating superiores a RATING_COMPARATOR
                        if ($videoComparator->performance_rating_average >= static::RATING_COMPARATOR) {
                            if ($videoComparator->tag_rating_average >= static::TAG_RATING) {
                                $performanceRatingUser = ClipitPerformanceRating::get_average_user_rating_for_target($same_users[$i], $videoComparator->id);
                                $tagRatingUser = ClipitTagRating::get_average_user_rating_for_target($same_users[$i], $videoComparator->id);
                                // A parte de que el video tenga una valoracion mayor a RATING_COMPARATOR, nos interesa
                                // saber que valoracion le ha dado el usuario a comparar, puesto que si es
                                // mala no sera un video recomendable, vuelvo a usar el RATING_COMPARATOR como comienzo
                                if ($performanceRatingUser >= static::RATING_COMPARATOR) {
                                    if ($tagRatingUser >= static::TAG_RATING) {
                                        // Si todo se cumple sera un video a recomendar
                                        $videos_same_activity[] = $videoComparator->id;
                                    }
                                } // if
                            }
                        } // if
                    } // if
                } // foreach
            } // foreach
            $prop_value_array = array();
            $prop_value_array["same_users"] = $same_users;
            $prop_value_array["videos_same_activity"] = $videos_same_activity;
            if (empty($instance)) {
                $prop_value_array["user"] = $user;
                static::create($prop_value_array);
            } // if
            else
                static::set_properties($instance->id, $prop_value_array);
            return $videos_same_activity;
        } // if
        else
            return $instance->videos_same_activity;
    } // get_videos_same_activity

    static function get_videos_other_activities($user) {
        $instance = static::get_by_user_activity($user);
        if (empty($instance->videos_other_activities)) {
            $videos_by_tags = array();
            $activities = ClipitActivity::get_from_user($user);
            $videos = ClipitVideo::get_all();
            foreach ($videos as $video) {
                foreach ($activities as $act) {
                    $activityByVideo = ClipitVideo::get_activity($video->id);
                    if ($act->id != $activityByVideo) {
                        $tags_user = static::get_tags_by_user($user, $videos);
                        $tags_video = ClipitVideo::get_tags($video->id);
                        for ($i = 0; $i < count($tags_user); $i++) {
                            for ($j = 0; $j < count($tags_video); $j++) {
                                if ($tags_user[$i] == $tags_video[$j])
                                    if ($video->performance_rating_average > static::RATING_COMPARATOR)
                                        if ($video->tag_rating_average > static::TAG_RATING)
                                            if (!in_array($video->id, $videos_by_tags))
                                                $videos_by_tags[] = $video->id;
                            } // for
                        } // for
                    } // if
                } // foreach
            } // foreach
            $prop_value_array = array();
            $prop_value_array["videos_other_activities"] = $videos_by_tags;
            if (empty($instance)) {
                $prop_value_array["user"] = $user;
                static::create($prop_value_array);
            } // if
            else
                static::set_properties($instance->id, $prop_value_array);
            return $videos_by_tags;
        } // if
        else
            return $instance->videos_other_activities;
    } // get_videos_other_activities

    static function get_videos_all_activities($user) {
        $instance = static::get_by_user_activity($user);
        if (empty($instance->videos_all_activities)) {
            $same_activity = array();
            $other_activities = array();
            if (empty($instance->videos_same_activity)) {
                $same_activity = static::get_videos_same_activity($user);
            } else {
                $same_activity = $instance->videos_same_activity;
            } // if-else
            if (empty($instance->videos_other_activities)) {
                $other_activities = static::get_videos_other_activities($user);
            } else {
                $other_activities = $instance->videos_other_activities;
            } // if-else
            $videos_all = array_unique(array_merge($other_activities, $same_activity));
            $prop_value_array = array();
            $prop_value_array["videos_all_activities"] = $videos_all;
            static::set_properties($instance->id, $prop_value_array);
            return $videos_all;
        } // if
        else
            return $instance->videos_all_activities;
    } // get_videos_all_activities

    static function get_users_same_opinion($user, $users, $videos) {
        $same_users = array();
        foreach ($videos as $video) {
            foreach ($users as $userFunction) {
                if ($userFunction->id != $user) { // Si no es el mismo usuario
                    if (!in_array($userFunction->id, $same_users)) { // Si ese usuario no esta metido
                        // media del usuario
                        $media = ClipitPerformanceRating::get_average_user_rating_for_target($user, $video->id);
                        // media del usuario a comparar
                        $mediaCompare = ClipitPerformanceRating::get_average_user_rating_for_target($userFunction->id, $video->id);
                        $rango_inferior = $media - static::RANGE_MEDIA;
                        $rango_superior = $media + static::RANGE_MEDIA;
                        if (($mediaCompare > $rango_inferior) && ($mediaCompare < $rango_superior))
                            if ($media != 0) // Y si es mayor a 0
                                $same_users[] = $userFunction->id; // Opinan mas o menos lo mismo      
                    } // if
                } // if
            } // foreach $usersFunction
        } // foreach $videos

        return $same_users;
    }

// get_users_same_opinion
    
    // Obtiene todos los tags de los videos votados por el usuario
    static function get_tags_by_user($user, $videos) {
        $tags_videos = array();
        foreach ($videos as $video) {
            $rating = ClipitPerformanceRating::get_average_user_rating_for_target($user, $video->id);
            if ($rating > 0) {
                $tags = ClipitVideo::get_tags($video->id);
                for ($i = 0; $i < count($tags); $i++) {
                    if (!in_array($tags[$i], $tags_videos)) {
                        $tags_videos[] = $tags[$i];
                    }
                }
            }
        }
        return $tags_videos;
    }

    static function recommended_upload() {
        $users = ClipitUser::get_all();
        $videos = ClipitVideo::get_all();
        foreach ($users as $user) {
            static::upload_users($user->id, $users, $videos);     
        } // foreach
        static::upload_videos_better_rankings($videos);
    }

// recommended_upload

    static function upload_videos_better_rankings($videos) {
        $instance = static::is_list();
        $prop_value_array = array();
        $prop_value_array["are_videos"] = 1;
        $videos_better_rating = array();
        foreach ($videos as $video) {
            $rating = intval($video->performance_rating_average) + 1;
            if ($rating > 5)
                $rating = 5;
            if (($rating - 1) < $video->performance_rating_average)
                if ($video->performance_rating_average < $rating)
                    if (!in_array($video->id, $videos_better_rating))
                        switch ($rating) {
                            case 1:
                                $videos_better_rating[$rating][] = $video->id;
                                break;
                            case 2:
                                $videos_better_rating[$rating][] = $video->id;
                                break;
                            case 3:
                                $videos_better_rating[$rating][] = $video->id;
                                break;
                            case 4:
                                $videos_better_rating[$rating][] = $video->id;
                                break;
                            case 5:
                                $videos_better_rating[$rating][] = $video->id;
                                break;
                        } // switch
                        
        } // foreach
        switch ($rating) {
            case 1:
                $prop_value_array["videos_better_ranking_less_one"] = $videos_better_rating[$rating];
                break;
            case 2:
                $prop_value_array["videos_better_ranking_less_two"] = $videos_better_rating[$rating];
                break;
            case 3:
                $prop_value_array["videos_better_ranking_less_three"] = $videos_better_rating[$rating];
                break;
            case 4:
                $prop_value_array["videos_better_ranking_less_four"] = $videos_better_rating[$rating];
                break;
            case 5:
                $prop_value_array["videos_better_ranking_less_five"] = $videos_better_rating[$rating];
                break;
        } // switch
        $file = fopen("textoservidor.txt", "a");
        foreach ($prop_value_array as $lista){
            foreach ($lista as $num){
                fwrite($file, "$num".PHP_EOL);
            }
        }
        fclose($file);
        if (empty($instance))
            static::create($prop_value_array);
        else
            static::set_properties($instance->id, $prop_value_array);
        
        error_log("<p>Ranking Videos $instance->id actualizado</p>");
    } // upload_videos_better_rankings
    
    
    static function upload_users($user, $users, $videos) {
        $instance = static::get_by_user_activity($user);
        
        //CALCULO LOS VIDEOS DE LA MISMA ACTIVIDAD
        $videos_same_activity = array();
        $same_users = static::get_users_same_opinion($user, $users, $videos);
        for ($i = 0; $i < count($same_users); $i++) {
            // Para cada usuario recorro todos los videos que hay
            foreach ($videos as $videoComparator) {
                // Como es posible que ya se haya entrado en ese video por otro usuario, ponemos
                // esta condicion para no gastar recursos
                if (!in_array($videoComparator->id, $videos_same_activity)) {
                    // Solo vamos a recomendar videos de rating superiores a RATING_COMPARATOR
                    if ($videoComparator->performance_rating_average >= static::RATING_COMPARATOR) {
                        if ($videoComparator->tag_rating_average >= static::TAG_RATING) {
                            $performanceRatingUser = ClipitPerformanceRating::get_average_user_rating_for_target($same_users[$i], $videoComparator->id);
                            $tagRatingUser = ClipitTagRating::get_average_user_rating_for_target($same_users[$i], $videoComparator->id);
                            // A parte de que el video tenga una valoracion mayor a RATING_COMPARATOR, nos interesa
                            // saber que valoracion le ha dado el usuario a comparar, puesto que si es
                            // mala no sera un video recomendable, vuelvo a usar el RATING_COMPARATOR como comienzo
                            if ($performanceRatingUser >= static::RATING_COMPARATOR) {
                                if ($tagRatingUser >= static::TAG_RATING) {
                                    // Si todo se cumple sera un video a recomendar
                                    $videos_same_activity[] = $videoComparator->id;
                                }
                            } // if
                        }
                    } // if
                } // if
            } // foreach
        } // for
        
        // CALCULO LOS VIDEOS DE OTRAS ACTIVIDADES
        $videos_by_tags = array();
        $activities = ClipitActivity::get_from_user($user);
        foreach ($videos as $video) {
            foreach ($activities as $act) {
                $activityByVideo = ClipitVideo::get_activity($video->id);
                if ($act->id != $activityByVideo) {
                    $tags_user = static::get_tags_by_user($user, $videos);
                    $tags_video = ClipitVideo::get_tags($video->id);
                    for ($i = 0; $i < count($tags_user); $i++) {
                        for ($j = 0; $j < count($tags_video); $j++) {
                            if ($tags_user[$i] == $tags_video[$j]) 
                                if ($video->performance_rating_average > static::RATING_COMPARATOR)
                                    if ($video->tag_rating_average > static::TAG_RATING) 
                                        if (!in_array($video->id, $videos_by_tags))
                                            $videos_by_tags[] = $video->id; 
                        } // for
                    } // for
                } // if
            } // foreach
        } // foreach
        
        // CALCULO LOS VÍDEOS DE TODAS LAS ACTIVIDADES
        $videos_all = array_unique(array_merge($videos_same_activity, $videos_by_tags));
        
        // CREO O MODIFICO LA INSTANCIA
        $prop_value_array = array();
        $prop_value_array["user"] = $user;
        $prop_value_array["same_users"] = $same_users;
        $prop_value_array["videos_same_activity"] = $videos_same_activity;
        $prop_value_array["videos_other_activities"] = $videos_by_tags;
        $prop_value_array["videos_all_activities"] = $videos_all;
        $file = fopen("textoservidor.txt", "a");
        foreach ($prop_value_array as $lista){
            foreach ($lista as $num){
                fwrite($file, "$num".PHP_EOL);
            }
        }
        fclose($file);
        if (empty($instance)) static::create ($prop_value_array);
        else static::set_properties($instance->id, $prop_value_array);
        
error_log("<p>Usuario $instance->id actualizado</p>");
        
    } // upload

}

?>
