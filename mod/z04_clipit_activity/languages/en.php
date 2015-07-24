<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   22/04/14
 * Last update:     22/04/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$english = array(
    'optional' => 'Optional',
    'options:advanced' => 'Advanced options',
    'refresh' => 'Refresh',
    'ok' => 'Ok',
    'change' => 'Change',
    'created' => 'Created',
    'calendar' => 'Calendar',
    'list' => 'List',
    'selected' => 'Selected',
    'unselected' => 'Not selected',
    'review' => 'Review',
    'add:more' => 'Add more',
    'check:all_none'=> 'Select all/none',
    'select:type'=> 'Select type',
    'stats' => 'Stats',
    'students' => 'Students',
    'groups' => 'Groups',
    'search:btn' => 'Search',
    'status' => 'Status',
    'send:to_site' => 'Publish to Site',
    'send:to_global' => 'Publish also to Global site',
    'time' => 'Time',
    'time:days' => 'Days',
    'time:hours' => 'Hours',
    'time:minutes' => 'Minutes',

    // Roles
    'teacher' => 'Teacher',
    'student' => 'Student',
    'admin' => 'Administrator',

    'change_to' => 'Change to',
    'current_status' => 'Current status',
    'exit:page:confirmation' => '...Data you have entered may not be saved...',
    'users:none' => 'No users',
    'start' => 'Start',
    'end' => 'End',
    'expand:all' => 'Expand all',
    'collapse:all' => 'Collapse all',
    'click_add' => 'Click to add',
    'view'  => 'View',
    'bulk_actions' => 'Bulk actions',
    // Activity
    'activity' => 'Activity',
    'activity:join' => 'Join',
    'activity:joined' => 'Joined',
    'activity:status' => 'Activity status',
    'activity:title' => 'Activity name',
    'activity:description' => 'Activity description',
    'activity:start' => 'Activity start',
    'activity:end' => 'Activity end',
    'activity:select:tricky_topic' => 'Tricky topic',
    'activity:overview' => 'Activity overview',
    'activity:edit' => 'Edit Activity',
    'activity:admin' => 'Activity admin',
    'activity:register:title' => 'Activity registration',
    'activity:register:info' => 'Any student will be able to join the activity before it starts.',
    'activity:register:students_per_group' => 'Students per group',
    'activity:register:max_students' => 'Max. number of students in the activity',
    'activity:register:max_students:info' => '0 = unlimited students',
    'activity:register:open' => 'Open',
    'activity:register:closed' => 'Closed',
    'my_activities' => 'My activities',
    'my_activities:active' => 'Ongoing activities',
    'my_activities:none' => 'No ongoing activities',
    'activities' => 'Activities',
    'activities:open' => 'Public activities',
    'activities:none' => 'There are no activities...',
    'explore' => 'Explore',
    'activity:delete' => 'Remove activity',
    'activity:create' => 'Create activity',
    'activity:create:info:title' => 'To create an activity you will need to specify',
    'activity:create:info:step:1' => '<b>Tricky Topic</b>: one per activity',
    'activity:create:info:step:2' => '<b>Activity information</b>: name, description and dates',
    'activity:create:info:step:3' => '<b>Tasks</b> contained: description, type and dates',
    'activity:create:info:step:3:details' => '
        <p>Some tasks require previously authored resources using the "Authoring tools", e.g.: "quiz" tasks need to be linked to a quiz, and "view teacher materials" tasks need the activity Tricky Topic to contain teaching materials.</p>
        <p>Please open the "Authoring tools" to make sure you have authored all necessary teacher resources before creating these tasks.</p>
        <p>You can also create an activity without some tasks, and add them later on, when the necessary resources have been created using the "Authoring tools".</p>
    ',
    'activity:create:info:step:4' => '<b>Students</b> participating: accounts and how they will group',

    'activity:profile' => 'Activity home',
    'activity:progress' => 'Activity progress',
    'activity:groups' => 'Groups',
    'activity:discussion' => 'Discussion',
    'activity:stas' => 'Teacher materials',
    'activity:publications' => 'Publications',
    'activity:button:join' => 'Join activity',
    'activity:group:join' => 'Join group',
    'activity:upcoming_tasks' => 'Upcoming tasks',
    'activity:pending_tasks' => 'Pending tasks',
    'activity:next_deadline' => 'Next task',
    'activity:quiz' => 'Activity Quiz',
    'activity:teachers' => 'Teachers',
    'activity:invited' => 'Invited to activity',
    // Activity status
    'status:enroll' => 'Enrolling',
    'status:active' => 'Active',
    'status:closed' => 'Finished',
    'status:change_to:active:tooltip' => 'The start date will be set as today. Set the desired end date manually. Click Save to accept changes.',
    'status:change_to:closed:tooltip' => 'The end date will be set as today. Click Save to accept changes.',

    'group' => 'Group',
    'my_group:progress' => 'My group progress',
    'my_group:none' => 'You are not in any group.',
    'group:free_slot' => '<strong><u>%s</u></strong> free slot',
    'group:assign_sb' => 'Assign Stumbling Blocks',
    'group:graph' => 'Group graph',
    'group:max_size' => 'Max students per group',
    'group:ungrouped' => 'Ungrouped',
    'group:activity' => 'Group effort',
    'group:name' => 'Group name',
    'group:create' => 'Group create',
    'group:join' => 'Join',
    'group:leave' => 'Leave',
    'group:full' => 'Full',
    'group:leave:me' => 'Leave group',
    'group:cantcreate' => 'You can not create a group.',
    'group:created' => 'Group created',
    'group:joined' => 'Successfully joined group!',
    'group:cantjoin' => 'Can not join group',
    'group:left' => 'Successfully left group',
    'group:cantleave' => 'Could not leave group',
    'group:member:remove' => 'Remove from group',
    'group:member:cantremove' => 'Cannot remove user from group',
    'group:member:removed' => 'Successfully removed %s from group',
    'group:added' => 'Group added to activity',
    'groups:none' => 'No groups',
    // Quizz
    'quiz' => 'Quiz',

    // Group tools
    'group:menu' => 'Group menu',
    'group:tools' => 'Group tools',
    'group:discussion' => 'Discussion',
    'group:files' => 'Repository',
    'group:home' => 'Group home',
    'group:activity_log' => 'Activity log',
    'group:progress' => 'Group progress',
    'group:timeline' => 'Timeline',
    'group:members' => 'Members',
    'group:students' => 'Group students',
    // Discussion
    'discussions:none' => 'No discussions',
    'discussion:start' => 'Start a discussion',
    'discussion:multimedia:go' => 'Go to discussion',
    'discussion:create' => 'Create a new topic',
    'discussion:created' => 'Discussion created',
    'discussion:deleted' => 'Discussion removed',
    'discussion:cantdelete' => 'Discussion can not remove',
    'discussion:cantcreate' => 'You can not create a discussion',
    'discussion:cantedit' => 'You can not update the discussion',
    'discussion:edited' => 'Discussion updated',
    'discussion:edit' => 'Edit topic',
    'discussion:title_topic' => 'Topic title',
    'discussion:text_topic' => 'Topic text',
    'discussion:last_post_by' => 'Last post by',
    'discussion:created_by' => 'Created by',
    // Multimedia
    'url'   => 'Url',
    'multimedia:files' => 'Files',
    'multimedia:file_uploaded' => 'File uploaded',
    'multimedia:videos' => 'Videos',
    'multimedia:links' => 'Interesting links',
    'multimedia:attach' => 'Attach resources',
    'multimedia:attach_files' => 'Attach files',
    'multimedia:uploaded_by' => 'Uploaded by',
    'multimedia:delete' => 'Delete',
    'multimedia:processing' => 'Processing',
    'multimedia:attachments' => 'repository attachments',
    'multimedia:attachment' => 'repository attachment',
    'attachments' => 'attachment(s)',
    // Files
    'files' => 'Files',
    'file' => 'File',
    'file:download' => 'Download',
    'file:uploaded' => 'File uploaded',
    'multimedia:file:name' => 'File name',
    'multimedia:file:description' => 'Description',
    'multimedia:files:add' => 'Add files',
    'file:delete' => 'Delete files',
    'file:nofile' => 'No file',
    'file:removed' => 'File %s removed',
    'file:cantremove' => 'Can not remove file',
    'file:edit' => 'Edit file',
    'file:edited' => 'File edited',
    'file:added' => 'File added',
    'file:none' => "No files",
    'files:none' => "No files",
    /* File types */
    'file:general' => 'File',
    'file:document' => 'Document',
    'file:image' => 'Image',
    'file:video' => 'Video',
    'file:audio' => 'Audio',
    'file:compressed' => 'Compressed file',
    // Videos
    'videos' => 'Videos',
    'video' => 'Video',
    'videos:recommended' => 'Recommended videos',
    'videos:recommended:none' => 'There are no recommended videos',
    'videos:related' => 'Related videos',
    'videos:none' => 'No videos',
    'video:url:error' => 'Incorrect url or video not found',
    'video:edit' => 'Edit video',
    'video:edited' => 'Video edited',
    'video:add' => 'Add video',
    'video:added' => 'Video added',
    'video:deleted' => 'Video deleted',
    'video:cantadd' => 'Can not add video',
    'video:add:to_youtube' => 'Upload video to Youtube',
    'video:add:paste_url' => 'Paste URL from YouTube or Vimeo',
    'video:link:youtube_vimeo' => 'URL from Youtube or Vimeo',
    'video:uploading:youtube' => 'Uploading to Youtube',
    'video:url' => 'Video url',
    'video:upload' => 'Video upload',
    'video:uploaded' => 'Video uploaded',
    'video:title' => 'Video title',
    'video:tags' => 'Video Stumbling Blocks',
    'video:description' => 'Video description',
    // Tricky Topic
    'tricky_topic' => 'Tricky Topic',
    'tricky_topic:none' => 'Not tricky Topic',
    'tricky_topic:tool' => 'Tricky Topic tool',
    'tricky_topic:select' => 'Select Tricky Topic',
    'tricky_topic:created_by_me' => 'Created by me',
    'tricky_topic:created_by_others' => 'Others',
    // Publications
    'publish:none' => 'There are no published',
    'publications:no_evaluated' => 'Not evaluated',
    'publications:evaluated' => 'Evaluated',
    'publications:rating' => 'Rating',
    'publications:rating:name' => '%s\'s Rating',
    'publications:rating:list' => 'All feedback',
    'publications:rating:edit' => 'Edit feedback',
    'publications:rating:votes' => 'VOTES',
    'publications:rating:my_evaluation' => 'My evaluation',
    'publications:rating:stars' => 'Please score the video between 1 and 5 for performance',
    'publications:starsrequired' => 'Stars rating required',
    'publications:cantrating' => 'Can not rating',
    'publications:rated' => 'Successfully evaluated',
    'publications:my_rating' => 'My rating',
    'publications:evaluate' => 'Evaluate',
    'publications:question:tricky_topic' => 'Does this publication help you understand the %s Tricky Topic?',
    'publications:question:sb' => 'Why is/isn\'t this Stumbling Block correctly covered?',
    'publications:question:if_covered' => 'Check if each Stumbling Block was correcty covered in this publication, and explain why:',
    'publications:view_scope' => 'View scope',
    'publications:review:info' => 'Review your work and click on Select',
    'publications:select:tooltip' => 'Click to review your work and select it for the task',
    'ratings:none' => 'No feedback',
    'rating:stars:1' => '',
    'rating:stars:2' => '',
    'rating:stars:3' => '',
    'rating:stars:4' => '',
    'rating:stars:5' => '',
    'input:no' => 'No',
    'input:yes' => 'Yes',
    'input:ok' => 'Ok',
    'publish'   => 'Publish',
    'published'   => 'Published',
    'publish:to_activity'   => 'Publish %s in %s',
    'publish:video'   => 'Publish video',
    // Labels
    'label' => 'Label',
    'labels' => 'Labels',
    'labels:none' => 'No labels added',
    'labels:added' => 'Labels added',
    'labels:cantadd' => 'You can not add label/s',
    'labels:cantadd:empty' => 'You can not add an empty label',
    // Tags
    'tag' => 'Stumbling Block',
    'tags' => 'Stumbling Blocks',
    'tags:add' => 'Add stumbling blocks',
    'tags:assign' => 'Assign stumbling blocks',
    'tags:none' => 'Not Stumbling Blocks',
    'tags:recommended' => 'Related Stumbling Blocks',
    'tags:commas:separated' => 'Separated by commas',
    // Performance items
    'performance_item' => 'Performance item',
    'performance_items' => 'Performance items',
    'performance_item:select' => 'Select performance items',
    // Tasks
    'activity:tasks' => 'Tasks',
    'activity:task' => 'Task',
    'task:title' => 'Task title',
    'task:title:page' => '%s task',
    'task:add' => 'Add task',
    'task:remove' => 'Remove task',
    'task:remove_video' => 'Remove video',
    'task:remove_file' => 'Remove file',
    'task:added' => 'Added task',
    'task:updated' => 'Updated task',
    'task:created' => 'Task created',
    'task:removed' => 'Tarea removed',
    'task:cantupdate' => 'You can not update task',
    'task:cantcreate' => 'You can not create a task',
    'task:template:title' => 'Use template',
    'task:template:select' => 'Select template',
    'task:user' => 'Individual task',
    'task:group' => 'Group task',
    'task:select' => 'Select task',
    'task:select:task_type' => 'Select task type',
    'task:task_type' => 'Task type',
    'task:resource_download' => 'View teacher materials',
    'task:feedback' => 'Task feedback',
    'task:feedback:linked' => 'Link to',
    'task:feedback:check' => 'Check to create a feedback task',
    'tasks:none' => 'No tasks',
    'task:completed' => 'Completed',
    'task:not_completed' => 'Not completed',
    'task:next' => 'Upcoming tasks',
    'task:pending' => 'Pending',
    'task:my_video' => 'My video',
    'task:other_videos' => 'Other videos',
    'task:my_file' => 'My file',
    'task:other_files' => 'Other files',
    'task:not_actual' => 'There are no pending tasks',
    'task:video_upload' => 'Add video',
    'task:file_upload' => 'Add file',
    'task:file_uploaded' => 'Dateien uploaded',
    'task:quiz_answer' => 'Take quiz',
    'task:quiz_take:select' => 'You must select a Quiz. <br>(If there are no Quizzes for the Tricky Topic, you must add one first)',
    'quiz:result:finish' => '',
    'task:video_feedback' => 'Video feedback',
    'task:file_feedback' => 'File feedback',
    'task:other' => 'Other',
    'task:videos:none' => 'Add a video to select',
    'task:file:none' => 'Add a file to select',
    'repository:group' => 'group repository',
    'task:create' => 'Create new task',
    'task:edit' => 'Edit task',
    'task:group:needed' => 'You need to join in a group to do the task, please contact your teacher/s',
    /// Task status
    'task:locked' => 'Task locked',
    'task:active' => 'Task open',
    'task:finished' => 'Task finished',
    'rating:none' => 'No rating',
    // Create activity
    'or:create' => 'or create a',
    'activity:site:students' => 'Site students',
    'activity:students' => 'Activity students',
    'activity:select' => 'Select activity',
    'finish' => 'Finish',
    'teachers:add' => 'Add teachers',
    'students:add' => 'Add students',
    'users:create' => 'Create users',
    'teacher:addedresource' => 'Teacher added resource',
    'called:students:add' => 'Create students',
    'called:students:add:from_excel' => 'Upload from Excel file',
    'called:students:insert_to_site' => 'Upload to site',
    'called:students:insert_to_activity' => 'Upload to activity',
    'activity:grouping_mode' => 'Grouping mode',
    'activity:grouping_mode:teacher' => 'Teacher makes groups',
    'activity:grouping_mode:teacher:desc' => 'After creating the Activity, you can add Students into Groups from the Activity Admin page',
    'activity:grouping_mode:student' => 'Students make groups',
    'activity:grouping_mode:system' => 'Create random groups',
    'activity:download:excel_template' => 'Download Excel template',
    'called:students:excel_template' => 'Excel template',
    'called:students:add_from_site' => 'Add from site',
    'called:students:add_from_excel' => 'Add from Excel file',
    'called:students:add_from_excel:waiting' => 'Please wait while students are uploading to the system',
    'activity:created' => 'Activity %s created',
    'search:filter' => 'Filter',
    // Activity admin
    'activity:deleted' => 'Activity deleted',
    'activity:cantdelete' => 'Activity can not remove',
    'activity:admin:info' => 'Information',
    'activity:admin:task_setup' => 'Tasks',
    'activity:admin:groups' => 'Students',
    'activity:admin:setup' => 'Setup',
    'activity:admin:options' => 'Options',
    'activity:admin:videos' => 'Student videos',
    'groups:select:move' => 'move to group...',
    'clipit:or' => 'or',
    'activity:updated' => 'Activity updated',
    'activity:cantupdate' => 'Cannot update activity',

    // Quiz
    'quiz:teacher_annotation' => 'Teacher\'s feedback',
    'quiz:data:none' => 'No data',
    'quiz:tricky_topic:danger' => 'If you change Tricky Topic questions will be deleted',
    'quiz:not_finished' => 'Not finished',
    'difficulty' => 'Difficulty',
    'quiz:select:from_tag' => 'Add existing questions',
    'quiz:question' => 'Question',
    'quiz:questions' => 'Questions',
    'quiz:question:add' => 'Create a question',
    'quiz:not_started' => 'Not started',
    'quiz:finished' => 'Finished',
    'quiz:time:to_do' => 'Time to do the quiz',
    'quiz:time:finish' => 'Ends at',
    'quiz:question:not_answered' => 'Not answered',
    'quiz:question:annotate' => 'Add annotation',
    'quiz:question:results' => 'Results',
    'quiz:question:result:add' => 'Add answer',
    'quiz:question:answer' => 'Answer',
    'quiz:question:type' => 'Possible answers',
    'quiz:question:statement' => 'Question',
    'quiz:question:additional_info' => 'Additional information',
    'quiz:question:add_video' => 'Add link to video',
    'quiz:question:add_image' => 'Attach image',
    'quiz:question:remove_image' => 'Remove image',
    'quiz:question:add_image:valid_extension' => 'Valid extensions',
    'quiz:questions:answered' => 'Questions answered',
    'quiz:questions:answers:correct' => 'correct answers',
    'quiz:answer:solution' => 'Solution',
    'quiz:results:stumbling_block' => 'Results by Stumbling Block',
    'quiz:out_of' => 'out of',
    'calendar:month_names'=> json_encode(array("January","February","March","April","May","June","July","August","September","October","November","December")),
    'calendar:month_names_short'=> json_encode(array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec")),
    'calendar:day_names'=> json_encode(array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday")),
    'calendar:day_names_short'=> json_encode(array("Sun","Mon","Tue","Wed","Thu","Fri","Sat")),
    'calendar:day_names_min'=> json_encode(array("Su","Mo","Tu","We","Th","Fr","Sa")),
    'calendar:month' => 'Month',
    'calendar:day' => 'Day',
    'calendar:week' => 'Week',
    'calendar:list' => 'Agenda',
);

add_translation('en', $english);
