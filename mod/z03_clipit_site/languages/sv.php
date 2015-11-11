<?php
/**
 * Clipit theme Swedish language file.
 *
 */

$swedish = array(
    'locale' => 'sv_SE',

    'read_more' => 'Läs mer',
    'read_less' => 'Mindre',
    'event:timeline' => 'Tidslinje för händelse',
    'name' => 'Namn',
    'activities:active:none' => 'Det finns pågående aktiviteter',
    'saved' => 'Sparad',
    'date' => 'Datum',
	
	'mine' => 'Min',
    'field:required' => 'Obligatoriskt fält',
    'menu' => 'Meny',
    'show' => 'Visa',
    'showing' => 'Visar',
    'to' => 'till',
    'of' => 'av',
    'select' => 'Välj',
    'pages' => 'Sidor',
    'next' => 'Nästa',
    'prev' => 'Föregående',
    'or' => 'Eller',
    'true' => 'Sant',
    'false' => 'Falskt',
    'closed' => 'Stängd',
    'admin:page' => 'Admin',
    'clipit:site' => 'Clipit',
    'loading' => 'laddar',
    'loading:content' => 'Laddar innehåll',
    'loading:charts' => 'Laddar grafer',
    'follow_us' => 'Följ oss',
    'clipit:slogan' => 'Skapa, lär och dela',
    'clipit:slogan:create' => 'Skapa',
    'clipit:slogan:learn' => 'Lär',
    'clipit:slogan:share' => 'Dela',
    'clipit:foot:mail' => 'E-post',

    // ERROR
    'error:404' => "Tyvärr! Vi kunde inte hitta sidan du letade efter.",
    'view_all' => 'Se alla',
    'view_as' => 'Se som',
    'me'    => "Jag",
    'options' => 'Alternativ',
    'home' => 'hem',
    'selectall' => 'Välj allt',
    'apply' => 'Använd',
    // Validation
    'validation:required' =>  "Det här fältet är obligatoriskt.",
    'validation:remote' =>  "Var vänlig och rätta till detta fält.",
    'validation:email' =>  "Var vänlig och ange en korrekt emailadress.",
    'validation:url' =>  "Var vänlig fyll i en giltig url.",
    'validation:date' =>  "Var vänlig fyll i ett giltigt datum.",
    'validation:dateISO' =>  "Var vänlig fyll i ett giltigt datum (ISO).",
    'validation:number' =>  "Var vänlig fyll i ett giltigt nummer.",
    'validation:digits' =>  "Vänligen använd enbart siffror.",
    'validation:creditcard' =>  "Vänligen fyll i ett giltigt kreditkortsnummer.",
    'validation:equalTo' =>  "Vänligen fyll i samma värde igen.",
    'validation:accept' =>  "Vänligen fyll i ett värde med en giltigt anslutning.",
    'validation:maxlength' =>  "Vänligen fyll ej i fler än {0} tecken.",
    'validation:minlength' =>  "Vänligen fyll i åtminstone {0} tecken.",
    'validation:rangelength' =>  "Vänligen fyll i ett värde mellan {0} och {1} tecken långt.",
    'validation:range' =>  "Vänligen fyll i ett värde mellan {0} och {1}.",
    'validation:max' =>  "Vänligen fyll i ett värde mindre än eller lika med {0}.",
    'validation:min' =>  "Vänligen fyll i ett värde större än eller lika med {0}.",

    // Menu footer
    'menu:footer_clipit:header:clipit' => 'Clipit',
    'menu:footer_clipit:header:help' => 'Hjälp',
    'menu:footer_clipit:header:legal' => 'Juridik',
    'send:email_to_site' => 'Skicka email till webbplatsen',

    'about' => 'Om',
    'team' => 'Team',
    'internship' => 'Praktik',
    'internships' => 'Praktikplatser',
    'developers' => 'Utvecklare',
    'support_center' => 'Supportcenter',
    'basics' => 'Grundläggande',
    'privacy' => 'Sekretesspolicy',
    'terms' => 'Villkor och bestämmelser',
    'community_guidelines' => 'Förhållningsregler',

    // Form no login
    'loginusername' => 'Användarnamn eller email du registrerade dig med',
    'user:password:lost' => 'Glömt lösenord',
    'new_user' => 'Ny användare?',
    'user:notfound' => 'Användarnamn eller email hittades ej.',
    'user:register' => 'Registrera dig',
    'user:username:login' => 'Logga in',
    'user:login' => 'Logga in',
    'user:forgotpassword' => 'Glömt lösenord?',
    'passwordagain' => 'Skriv lösenordet igen',
    'user:forgotpassword:ok' => 'Kolla din email för att bekräfta ändring av lösenord.',
    // New password
    'user:resetpassword:newpassword' => 'Nytt lösenord',
    'user:resetpassword:newpasswordagain' => 'Nytt lösenord (igen för bekräftning)',
    // Widgets
    // Autocomplete
    'autocomplete:hint' => "Skriv in en sökterm",
    'autocomplete:noresults' => "Inga resultat",
    'autocomplete:searching' => "Söker...",
    // Time (future)
    'friendlytime:next:justnow' => "precis nu",
    'friendlytime:next:minutes' => "%s minuter",
    'friendlytime:next:minutes:singular' => "en minut",
    'friendlytime:next:hours' => "%s timmar",
    'friendlytime:next:hours:singular' => "en timme",
    'friendlytime:next:days' => "%s dagar",
    'friendlytime:next:days:singular' => "i morgon",

    // Positions
    'position:li:es' => 'Huvudansvarig - Spanien',
    'position:li:de' => 'Huvudansvarig - Tyskland',
    'position:tpm' => 'Teknisk projektledare',
    'position:swd' => 'Senior Web Developer',
    'position:researcher' => 'Forskare',
    'position:gd' => 'Grafisk designer',
    'position:ra' => 'Forskningsrådgivare',
    'position:ta' => 'Teknisk rådgivare',
);

add_translation('sv', $swedish);
