<?php
include_once(elgg_get_plugins_path() . "a02_krc/lib/phpSesame.php");
include_once(elgg_get_plugins_path() . "a02_krc/lib/ItemProfile.php");
foreach (glob(elgg_get_plugins_path() . "a02_krc/lib/ARC2/*.php") as $filename)
{
    include $filename;
}

class KnowledgeRepresentationComponent
{
    const CONTEXT = "http://www.juxtalearn.org";
    const QUIZ_RATING = "quiz_rating";
    const VIDEO_RATING = "video_rating";
    const STORYBOARD_RATING = "storyboard_rating";
    const FILE_RATING = "file_rating";


    const JXL_CONTEXT = "jxl";
    const WIKIPEDIA = "";
    const TRICKY_TOPICS = "";

    const USERS = "";

    public $connected = false;
    private $store_url = "";
    private $repo_name = "";
    private $sesame_store;

    public function __construct() {
        global $sesame_store;
        $entities = elgg_get_entities(array("types" => "object", "subtypes" => "modkrc", "owner_guids" => '0', "order_by" => "", "limit" => 0));
        if (isset($entities[0]) && isset($_SESSION['user']) && ($_SESSION['user'] instanceof ElggUser)) {
            $entity = $entities[0];
            $store_url = $entity->store_url;
            $repo_name = $entity->repo_name;
            $this->store_url = $store_url;
            $this->repo_name = $repo_name;
            try {
                if (is_null($sesame_store)) {
                    $sesame_store = new phpSesame($store_url);
                    //This is just to verify a valid connection:
                    $sesame_store->listRepositories();
                    $sesame_store->setRepository($repo_name);
                    $sesame_store->setNS("jxl", CONTEXT);
                    $context_test = $sesame_store->getNS("jxl");

                    if ($context_test != CONTEXT) {
                        register_error("Unable to get correct NS.");
                        return false;
                    }
                    global $krc_connected;
                    $krc_connected = true;
                    $this->connected = true;
                    $this->sesame_store = $sesame_store;
                }
            } catch (Exception $e) {
                register_error('Exception: ' . elgg_echo('krc:noconnection'));
                $this->connected = false;
            }
        }
    }

    public static function get_item_profile($item_id)
    {
        $profile = new ItemProfile($item_id);
        return $profile;
    }

    public static function store_rating($user_id, $stumbling_block_id, $type, $rating)
    {
        global $krc_connected;

        $user_profile = KnowledgeRepresentationComponent::get_item_profile($user_id);
        //Check if user profile exists, else create it:
        if (empty($user_profile)) {
            create_user_profile($user_id);
        }
        //Then we need to insert/update the rating:
        KnowledgeRepresentationComponent::update_rating($user_id, $stumbling_block_id, $type, $rating);
    }

    private function retrieve_rating($user_id, $stumbling_block_id, $type)
    {

    }

    private function update_item_profile($item_id, $stumbling_block_id)
    {

    }


    private function update_rating($user_id, $stumbling_block_id, $type, $new_value)
    {
        //First check whether there is a rating stored:
        $current_rating = retrieve_rating($user_id, $stumbling_block_id, $type);

        switch ($type) {
            case QUIZ_RATING:
                //(Value found in user profile * 0.5 + new result) / 1.5
                if (!($current_rating === false)) {
                    $new_rating = ($current_rating * 0.5 + $new_value) / 1.5;
                } else {
                    $new_rating = $new_value;
                }
                break;
            case VIDEO_RATING:
            case STORYBOARD_RATING:
            case FILE_RATING:
                if (!($current_rating === false)) {
                    $new_rating = $current_rating + $new_value;
                } else {
                    $new_rating = $new_value;
                }
                break;
        }

        KnowledgeRepresentationComponent::store_rating($user_id, $stumbling_block_id, $type, $new_rating);
        return $new_rating;
    }

    private static function update_quiz_rating($user_id, $stumbling_block_id, $type, $new_value)
    {
        $current_rating = retrieve_rating($user_id, $stumbling_block_id, $type);
        $new_rating = ($current_rating * 0.5 + $new_value) / 1.5;
        KnowledgeRepresentationComponent::store_rating($user_id, $stumbling_block_id, QUIZ_RATING, $new_rating);
        return $new_rating;
    }

    private static function create_user_profile($user_id)
    {
        //First we need to load the elgg entity / verify there is a user with this id:
        $user = get_entity($user_id);
        if ($user instanceof ElggEntity && $user->getSubtype() == ClipitUser::SUBTYPE) {

        } else {
            register_error("Tried to create a user profile for non-existing user. Clipit doesn't contain a user with id " . $user_id);
        }
    }

    public static function checkWriteAccess()
    {
        $krc = new KnowledgeRepresentationComponent();
        $test_triple = array("http://www.example.com/users/joe_bloggs" => array(
            "foaf:name" => array("Joe Bloggs"),
            "foaf:age" => array(21),
            "foaf:knows" => array("http://www.example.com/users/mary_smith")
        ));
        if ($krc->storeTriple($test_triple) && $krc->removeTriple($test_triple)) {
            return true;
        } else {
            return false;
        }
    }

    public static function getKRC() {
        global $krc;
        if (is_null($krc)) {
            $krc = new KnowledgeRepresentationComponent();
        }
        return $krc;
    }

    public function removeTriple($triple)
    {
        return true;
    }

    public function storeTriple($triple)
    {
        global $krc_connected;
        $sesame_store = $this->sesame_store;
        if ($krc_connected) {
            $conf = array('ns' => array('rdf' => 'http://www.w3.org/1999/02/22-rdf-syntax-ns#', 'owl' => 'http://www.w3.org/2002/07/owl#'));
            $serializer = ARC2::getRDFXMLSerializer($conf);

            $rdfxml = $serializer->getSerializedIndex($triple);
            error_log("");
            error_log("");
            error_log("");
            error_log($rdfxml);
            $inputFormat = phpSesame::RDFXML; // Optional - defaults to RDFXML
            $store_url = $this->store_url;
            $repo_name = $this->repo_name;

            $sesame_store = new phpSesame($store_url);
            //This is just to verify a valid connection:
            $sesame_store->listRepositories();
            $sesame_store->setRepository($repo_name);
            $sesame_store->setNS("jxl", KnowledgeRepresentationComponent::CONTEXT);
            $sesame_store->append($rdfxml, KnowledgeRepresentationComponent::CONTEXT, $inputFormat);
            return true;
        } else {
            register_error("Couldn't store RDF triple to RDF Store. Please check your store and your connection to the store.");
            return false;
        }
    }

}
