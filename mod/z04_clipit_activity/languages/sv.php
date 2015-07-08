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
$swedish = array(
    'selected' => 'Vald',
    'unselected' => 'Inte vald',
    'review' => 'Lämna omdöme',
    'add:more' => 'Lägg till mer',
    'check:all_none'=> 'Välj alla/ingen',
    'select:type'=> 'Vält typ',
    'stats' => 'Statistik',
    'students' => 'Studenter',
    'groups' => 'Grupper',
    'search:btn' => 'Sök',
    'status' => 'Status',
    'send:to_site' => 'Publicera till webbplats',
    'time:days' => 'Dagar',
    'time:hours' => 'Timmar',
    'time:minutes' => 'Minuter',

	// Roles
    'teacher' => 'Lärare',
    'student' => 'Student',
    'admin' => 'Admin',

    'change_to' => 'Byt till',
    'current_status' => 'Nuvarande status',
    'exit:page:confirmation' => '...Data som du skrivit in kommer kanske inte att sparas..',
    'users:none' => 'Inga användare',
    'start' => 'Start',
    'end' => 'Slut',
    'expand:all' => 'Expandera alla',
    'collapse:all' => 'Komprimera alla',
    'click_add' => 'Klicka för att lägga till',
    'view'  => 'Se',
    'bulk_actions' => 'Åtgärda många',
    // Activity
    'activity' => 'Aktivitet',
    'activity:status' => 'Aktivitetsstatus',
    'activity:title' => 'Aktivitetsnamn',
    'activity:description' => 'Aktivitetsbeskrivning',
    'activity:start' => 'Aktivitetsstart',
    'activity:end' => 'Aktivitetsslut',
    'activity:select:tricky_topic' => 'Knepigt ämne',
    'activity:overview' => 'Aktivitetsöversikt',
    'activity:admin' => 'Aktivitetsadmin',
    'my_activities' => 'Mina aktiviteter',
	
	'my_activities:active' => 'Pågående aktiveter',
    'my_activities:none' => 'Inga aktiviteter igång',
    
	'activities' => 'Aktiviteter',
    'activities:none' => 'Det finns inga aktiviteter...',
    'explore' => 'Utforska',
	
	'activity:delete' => 'Ta bort aktivitet',
	
    'activity:create' => 'Skapa aktivitet',
	
    'activity:create:info:title' => 'För att skapa en aktivitet behöver du specificera',
    'activity:create:info:step:1' => 'Klurigt ämne (en per aktivitet)',
    'activity:create:info:step:2' => 'Aktivitetsinformation (namn, beskrivning och datum)',
    'activity:create:info:step:3' => 'Uppgifter som inkluderas (beskrivning, typ och datum)',
    'activity:create:info:step:3:details' => '
        <p>Några yuppgifter kräver lärarresurser som behöver godkännas med hjälp av "Skaparverktyg". "Gör quiz"-uppgiften behöver länkas till ett quiz, och "se lärarmaterial"-uppgiften behöver länkas till material som finns i Kluriga ämnen.</p>
        <p>Öppna "Skaparverktyg" för att säkerställa at du har skapat alla nödvändiga lärarresurser innan du skapar dessa uppgifter.</p>
        <p>Du kan även skapa en aktivitet utan dessa uppgifter, och lägga till dem senare när de länkade resurserna har skapats med "Authoring tool".</p>
    ',
    'activity:create:info:step:4' => 'Studenter som kommer att delta och deras grupper',
	
    'activity:profile' => 'Aktivitet, hem',
    'activity:progress' => 'Aktivitet, progression',
    'activity:groups' => 'Grupper',
    'activity:discussion' => 'Diskussion',
    'activity:stas' => 'Lärarresurser',
    'activity:publications' => 'Publikationer',
    'activity:join' => 'Gå med i aktivitet',
    'activity:group:join' => 'Gå med i grupp',
	
	'activity:upcoming_tasks' => 'Kommande uppgifter',
	
    'activity:pending_tasks' => 'Uppdrag i kö',
    'activity:next_deadline' => 'Nästa uppdrag',
    'activity:quiz' => 'Aktivitetsquiz',
    'activity:teachers' => 'Lärare',
    'activity:invited' => 'Inbjuden till aktivitet',
    // Activity status
    'status:enroll' => 'Inskrivning',
    'status:active' => 'Aktiv',
    'status:closed' => 'Avslutad',
	
    'status:change_to:active:tooltip' => 'Startdatut kommer att sättas till idag. Ställ in önskad slutdatum manuellt. Klicka spara för att acceptera ändringarna.',
    'status:change_to:closed:tooltip' => 'Startdatum kommer att sättas till idag. Klicka på spara för att acceptera ändringarna.',

    'group' => 'Grupp',
    'my_group:progress' => 'Min grupprogression',
    'group:free_slot' => '<strong><u>%s</u></strong> tom plats',
    'group:assign_sb' => 'Tilldela hinder',
    'group:graph' => 'Grupp-graf',
    'group:max_size' => 'Max antal studenter per grupp',
    'group:activity' => 'Gruppuppgift',
    'group:name' => 'Gruppnamn',
    'group:create' => 'Skapa grupp',
    'group:join' => 'Gå med',
    'group:leave' => 'Lämna',
    'group:full' => 'Fullständig',
    'group:leave:me' => 'Lämna grupp',
    'group:cantcreate' => 'Du kan inte skapa en grupp.',
    'group:created' => 'Grupp skapad',
    'group:joined' => 'Du gick med i gruppen!',
    'group:cantjoin' => 'Du kunde inte gå med i gruppen',
    'group:left' => 'Du har gått ur gruppen',
    'group:cantleave' => 'Det gick inte att gå ur gruppen',
    'group:member:remove' => 'Ta bort från gruppen',
    'group:member:cantremove' => 'Kan inte ta bort användare från gruppen',
    'group:member:removed' => 'Tog bort %s från gruppen',
    'group:added' => 'Grupp tillagd till aktivitet',
    'groups:none' => 'Inga grupper',
    // Quizz
    'quiz' => 'Quiz',

    // Group tools
    'group:menu' => 'Gruppmeny',
    'group:tools' => 'Gruppverktyg',
    'group:discussion' => 'Diskussion',
    'group:files' => 'Akriv',
    'group:home' => 'Grupp hem',
    'group:activity_log' => 'Aktivitetslog',
    'group:progress' => 'Grupprogression',
    'group:timeline' => 'Tidslinje',
    'group:members' => 'Medlemmar',
    'group:students' => 'Gruppens studenter',
    // Discussion
    'discussions:none' => 'Inga diskussioner',
    'discussion:start' => 'Starta en diskussion',
    'discussion:multimedia:go' => 'Gå till diskussion',
    'discussion:create' => 'Skapa ett nytt ämne',
    'discussion:created' => 'Diskussion skapad',
    'discussion:deleted' => 'Diskussion borttagen',
    'discussion:cantdelete' => 'Diskussionen kude inte tas bort',
    'discussion:cantcreate' => 'Du kan inte skapa en diskussion',
	
    'discussion:cantedit' => 'Du kan inte uppdatera diskussionen',
    'discussion:edited' => 'Diskussionen uppdaterad',
	
    'discussion:edit' => 'Redigera ämne',
    'discussion:title_topic' => 'Ämnestitel',
    'discussion:text_topic' => 'Ämnestext',
    'discussion:last_post_by' => 'Senaste post av',
    'discussion:created_by' => 'Skapad av',
    // Multimedia
    'url'   => 'Url',
    'multimedia:files' => 'Filer',
    'multimedia:file_uploaded' => 'Fil uppladdad',
    'multimedia:videos' => 'Videos',
    'multimedia:links' => 'Intressanta länkar',
    'multimedia:attach' => 'Bifoga Resurs',
    'multimedia:attach_files' => 'Bifoga fil',
    'multimedia:uploaded_by' => 'Uppladdad av',
    'multimedia:delete' => 'Ta bort',
    'multimedia:processing' => 'Under behandling',
    'multimedia:attachments' => 'Akrivbilagor',
    'multimedia:attachment' => 'Arkivbilaga',
    'attachments' => 'bilaga(or)',
    // Files
    'files' => 'Filer',
    'file' => 'Fil',
    'file:download' => 'Ladda ned',
    'file:uploaded' => 'Fil uppladdad',
    'multimedia:file:name' => 'Filnamn',
    'multimedia:file:description' => 'Beskrivning',
    'multimedia:files:add' => 'Lägg till filer',
    'file:delete' => 'Ta bort filer',
    'file:nofile' => 'Ingen fil',
    'file:removed' => 'Fil %s borttagen',
    'file:cantremove' => 'Kan inte ta bort fil',
    'file:edit' => 'Redigera fil',
    'file:none' => "Inga filer",
    /* File types */
    'file:general' => 'Fil',
    'file:document' => 'Dokument',
    'file:image' => 'Bild',
    'file:video' => 'Video',
    'file:audio' => 'Ljud',
    'file:compressed' => 'Komprimerad fil',
    // Videos
    'videos' => 'Videos',
    'video' => 'Video',
    'videos:recommended' => 'Rekommenderade videos',
    'videos:recommended:none' => 'Det finns inga rekommenderade videos',
    'videos:related' => 'Relaterade videos',
    'videos:none' => 'Inga videos',
    'video:url:error' => 'Inkorrekt url eller ingen video hittad',
    'video:edit' => 'Redigera video',
    'video:add' => 'Lägg till video',
    'video:added' => 'Video tillgad',
	
    'video:deleted' => 'Video borttagen	',
    'video:cantadd' => 'Kan inte ta bort video',
	
    'video:add:to_youtube' => 'Ladda upp video till Youtube',
    'video:add:paste_url' => 'Klistra in URL från YouTube eller Vimeo',
	
	'video:link:youtube_vimeo' => 'URL from Youtube or Vimeo',
	 
    'video:uploading:youtube' => 'Laddar upp till Youtube',
    'video:url' => 'Video url',
    'video:upload' => 'Videouppladdning',
    'video:uploaded' => 'Video uppladdad',
    'video:title' => 'Videotitel',
    'video:tags' => 'Video hinder',
    'video:description' => 'Video beskrivning',
    // Tricky Topic
    'tricky_topic' => 'Knepigt ämne',
    'tricky_topic:none' => 'Ej knepigt ämne',
    'tricky_topic:tool' => 'Knepigt ämne verktyg',
    'tricky_topic:select' => 'Välj knepigt ämne',
    'tricky_topic:created_by_me' => 'Skapat av mig',
    'tricky_topic:created_by_others' => 'Andra',
    // Publications
    'publish:none' => 'Det finns inga publicerade',
    'publications:no_evaluated' => 'Ej utvärderad',
    'publications:evaluated' => 'Utvärderad',
    'publications:rating' => 'Betyg',
    'publications:rating:name' => '%s\'s Betyg',
    
    'publications:rating:list' => 'All feedback',
    'publications:rating:edit' => 'Redigera feedback',
	
    'publications:rating:votes' => 'RÖSTER',
    'publications:rating:my_evaluation' => 'Min utvärdering',
	
	'publications:rating:stars' => 'Betygsätt videon mellan 1 och 5 för prestation',
	
    'publications:starsrequired' => 'Stjärnbetyg krävs',
    'publications:cantrating' => 'Kan inte betygsätta',
    'publications:rated' => 'Utvärdering genomförd',
    'publications:my_rating' => 'Min betygssättning',
    'publications:evaluate' => 'Utvärdera',
    'publications:question:tricky_topic' => 'Hjälper denna publikation dig att förstå %s kluriga ämne?',
    'publications:question:sb' => 'Varför är/är inte detta hinder behandlat?',
    'publications:question:if_covered' => 'Kolla om detta hinder behandlades i publikationen, och förklara varför:',
    'publications:view_scope' => 'Visa tillämpningområde',
	
    'publications:review:info' => 'Se över ditt arbete och klicka på Välj',
    'publications:select:tooltip' => 'Klicka för att se över ditt arbete och välj det för uppgiften',
    'ratings:none' => 'Ingen feedback',
	
    'input:no' => 'Nej',
    'input:yes' => 'Ja',
    'input:ok' => 'Ok',
    'publish'   => 'Publicera',
    'published'   => 'Publicerad',
    'publish:to_activity'   => 'Publicera %s i %s',
    'publish:video'   => 'Publicera video',
    // Labels
    'label' => 'Etikett',
    'labels' => 'Etiketter',
    'labels:none' => 'Ingen etikett tillagd',
	
	'labels:added' => 'Etiketter tillagda',
	
    // Tags
    'tag' => 'Hinder',
    'tags' => 'Hinder',
    'tags:add' => 'Lägg till tagg',
    'tags:assign' => 'Applicera tagg',
    'tags:none' => 'Ej hinder',
    'tags:recommended' => 'Relaterat hinder',
    'tags:commas:separated' => 'Separerat med komma',
    // Performance items
    'performance_item' => 'Prestantapost',
    'performance_items' => 'Prestandaposter',
    'performance_item:select' => 'Välj prestandapost',
    // Tasks
    'activity:tasks' => 'Uppgifter',
    'activity:task' => 'Uppgift',
    'task:title' => 'Uppgiftstitel',
    'task:add' => 'Lägg till uppgift',
	
    'task:remove' => 'Ta bort uppgift',
    'task:remove_video' => 'Ta bort video',
	
    'task:added' => 'Uppgift tillagd',
	
    'task:updated' => 'Uppdaterad uppgift',
    'task:cantupdate' => 'Du kan inte uppdatera uppgiften',
	
    'task:select' => 'Välj uppgift',
    'task:select:task_type' => 'Välj uppgiftstyp',
    'task:task_type' => 'Uppgiftstyp',
    
	'task:resource_download' => 'Se lärarmaterial',
	
    'task:feedback' => 'Uppgiftsfeedback',
    
	'task:feedback:linked' => 'Länka till',
	
    'task:feedback:check' => 'Fyll i för att skapa en feedbackuppgift',
    'tasks:none' => 'Inga uppgifter',
    'task:completed' => 'Färdigställd',
    'task:not_completed' => 'Ej färdigställd',
    'task:pending' => 'Väntar',
    'task:my_video' => 'Min video',
    'task:other_videos' => 'Andra videos',
    'task:my_file' => 'Mitt fil',
    'task:other_files' => 'Andra filer',
    'task:not_actual' => 'Det finns inga uppgifter som väntar',
    'task:video_upload' => 'Skapa video',
    'task:file_upload' => 'Skapa fil',
    'task:file_uploaded' => 'Fil uppladdat',
    
	'task:quiz_answer' => 'Gör Quiz',
	
    'task:video_feedback' => 'Video feedback',
    'task:file_feedback' => 'Fil feedback',
    'task:other' => 'Övrigt',
    'task:videos:none' => 'Lägg till video från din %s',
    'task:file:none' => 'Lägg till fil från din %s',
    'repository:group' => 'grupparkiv',
    'task:create' => 'Skapa ny uppgift',
    'task:edit' => 'Redigera uppgift',
    /// Task status
    'task:locked' => 'Uppgift låst',
    'task:active' => 'Uppgift öppen',
    'task:finished' => 'Uppgift slutförd',
    'rating:none' => 'Inget betyg',
    // Create activity
    'or:create' => 'eller skapa en',
    'activity:site:students' => 'Webbplatsstudenter',
    'activity:students' => 'Aktivitetsstudenter',
    'activity:select' => 'Välj aktivitet',
    'finish' => 'Avsluta',
    'teachers:add' => 'Lägg till lärare',
    'students:add' => 'Lägg till studenter',
    'users:create' => 'Skapa användare',
    'teacher:addedresource' => 'Lärartillagd resurs',
    'called:students:add' => 'Skapa student',
    'called:students:add:from_excel' => 'Ladda upp från excelfil',
    'called:students:insert_to_site' => 'Ladda upp till webbplats',
    'called:students:insert_to_activity' => 'Ladda upp till aktivitet',
    'activity:grouping_mode' => 'Grupperingsläge',
    'activity:grouping_mode:teacher' => 'Lärare gör grupper',
    'activity:grouping_mode:teacher:desc' => 'Efter att du skapat aktiviteten så kan du lägga till studenter från aktivitetsadminsidan',
    'activity:grouping_mode:student' => 'Studenter gör grupper',
    'activity:grouping_mode:system' => 'Skapa slumpmässig grupp',
    'activity:download:excel_template' => 'Ladda ned exceltemplate',
    'called:students:excel_template' => 'Exceltemplate',
    'called:students:add_from_site' => 'Lägg till från webbplats',
    'called:students:add_from_excel' => 'Lägg till från excelfil',
    'activity:created' => 'Aktivitet %s skapad',
    'search:filter' => 'Filter',
	
    // Activity admin
    'activity:deleted' => 'Aktivitet borttagen',
    'activity:cantdelete' => 'Aktivitet kan inte ta bort',
    'activity:admin:info' => 'Information',
	
    'activity:admin:task_setup' => 'Uppgift setup',
    'activity:admin:groups' => 'Grupper setup',
    'activity:admin:setup' => 'Aktivitet setup',
	
	'activity:admin:videos' => 'Studentvideos',
	
    'groups:select:move' => 'flytta till grupp...',
    'clipit:or' => 'eller',
    'activity:updated' => 'Aktivitet uppdaterad',
    'activity:cantupdate' => 'Kan inte uppdatera aktivitet',

    // Quiz
    'quiz:teacher_annotation' => 'Lärares feedback',
    'quiz:result:send' => 'Dina svar har sparats. Då det finns tid kvar kan du se över och ändra dina svar om du vill.',
    'quiz:data:none' => 'Inga data',
    'quiz:tricky_topic:danger' => 'Om du gör ändringar kommer Kluriga ämnen-frågor att tas bort',
    'quiz:not_finished' => 'Ej färdigt',
	
    'difficulty' => 'Svårighetsgrad',
    
	'quiz:select:from_tag' => 'Lägg till existerande fråga',
	
    'quiz:question' => 'Fråga',
	'quiz:questions' => 'Frågor',
    'quiz:question:add' => 'Skapa en fråga',
    'quiz:not_started' => 'Ej påbörjad',
    'quiz:finished' => 'Slutförd',
    'quiz:time:to_do' => 'Tid för att genomföra quizen',
    'quiz:time:finish' => 'Slutar vid',
    'quiz:question:not_answered' => 'Ej besvarad',
    'quiz:question:annotate' => 'Lägg till kommentar',
    'quiz:question:results' => 'Resultat',
    
	'quiz:question:result:add' => 'Lägg till svar',
    'quiz:question:answer' => 'Svar',
    'quiz:question:type' => 'Möjliga svar',
    'quiz:question:statement' => 'Frågor',
    'quiz:question:additional_info' => 'Extra information',
    'quiz:questions:answered' => 'Besvarade frågor',
    'quiz:questions:answers:correct' => 'rätta svar',
    'quiz:answer:solution' => 'Lösning',
    'quiz:results:stumbling_block' => 'Resultat sorterat efter hinder',
    'quiz:out_of' => 'sorterat efter',
    'calendar:month_names'=> json_encode(array("januari","februari","mars","april","maj","juni","juli","augusti","september","oktober","november","december")),
    'calendar:month_names_short'=> json_encode(array("jan","feb","mar","apr","maj","jun","jul","aug","sep","okt","nov","dec")),
    'calendar:day_names'=> json_encode(array("söndag","måndag","tisdag","onsdag","torsdag","fredag","lördag")),
    'calendar:day_names_short'=> json_encode(array("sön","mån","tis","ons","tor","fre","lör")),
    'calendar:day_names_min'=> json_encode(array("sö","må","ti","on","to","fr","lö")),
    'calendar:month' => 'mån',
    'calendar:day' => 'dag',
    'calendar:week' => 'vecka',
    'calendar:list' => 'lista',
	
);

add_translation('sv', $swedish);
