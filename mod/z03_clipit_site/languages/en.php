<?php
/**
 * Clipit theme English language file.
 *
 */

$english = array(
    'locale' => 'en_GB',

    'read_more' => 'Read more',
    'read_less' => 'Less',
    'event:timeline' => 'Event timeline',
    'name' => 'Name',
    'activities:active:none' => 'There are no ongoing activities',
    'saved' => 'Saved',
    'date' => 'Date',
    'mine' => 'Mine',
    'field:required' => 'Field required',
    'menu' => 'Menu',
    'show' => 'Show',
    'showing' => 'Showing',
    'to' => 'to',
    'of' => 'of',
    'select' => 'Select',
    'pages' => 'Pages',
    'next' => 'Next',
    'prev' => 'Prev',
    'or' => 'Or',
    'true' => 'True',
    'false' => 'False',
    'closed' => 'Closed',
    'admin:page' => 'Administration',
    'clipit:site' => 'ClipIt',
    'loading' => 'loading',
    'loading:content' => 'Loading content',
    'loading:charts' => 'Loading charts',
    'follow_us' => 'Follow us',
    'clipit:slogan' => 'Create, learn and share',
    'clipit:slogan:create' => 'Create',
    'clipit:slogan:learn' => 'Learn',
    'clipit:slogan:share' => 'Share',

    // ERROR
    'error:404' => "Sorry. We could not find the page that you requested.",
    'view_all' => 'View all',
    'view_more' => 'View more',
    'view_as' => 'View as',
    'me'    => "Me",
    'options' => 'Options',
    'home' => 'home',
    'selectall' => 'Select all',
    'apply' => 'Apply',
    // Validation
    'validation:required' =>  "This field is required.",
    'validation:remote' =>  "Please fix this field.",
    'validation:email' =>  "Please enter a valid email address.",
    'validation:url' =>  "Please enter a valid URL.",
    'validation:date' =>  "Please enter a valid date.",
    'validation:dateISO' =>  "Please enter a valid date (ISO).",
    'validation:number' =>  "Please enter a valid number.",
    'validation:digits' =>  "Please enter only digits.",
    'validation:creditcard' =>  "Please enter a valid credit card number.",
    'validation:equalTo' =>  "Please enter the same value again.",
    'validation:accept' =>  "Please enter a value with a valid extension.",
    'validation:maxlength' =>  "Please enter no more than {0} characters.",
    'validation:minlength' =>  "Please enter at least {0} characters.",
    'validation:rangelength' =>  "Please enter a value between {0} and {1} characters long.",
    'validation:range' =>  "Please enter a value between {0} and {1}.",
    'validation:max' =>  "Please enter a value less than or equal to {0}.",
    'validation:min' =>  "Please enter a value greater than or equal to {0}.",
    'validation:login_normalize' =>  "Use a valid username.",
    'validation:extension' =>  "Extension invalid.",

    // Menu footer
    'menu:footer_clipit:header:clipit' => 'Clipit
<small style="color: #fff;font-size: 68%;">
'.(get_config('clipit_version')?'v':'').''.get_config('clipit_version').'</small>',
    'menu:footer_clipit:header:help' => 'Help',
    'menu:footer_clipit:header:tutorials' => 'User guides',
    'menu:footer_clipit:header:legal' => 'Legal',
    'send:email_to_site' => 'Send email to site',

    'about' => 'About',
    'team' => 'Team',
    'internship' => 'Internship',
    'internships' => 'Internships',
    'developers' => 'Developers',
    'support_center' => 'Support Center',
    'basics' => 'Basics',
    'privacy' => 'Privacy Policy',
    'terms' => 'Terms and conditions',
    'community_guidelines' => 'Community Guidelines',

    // Form no login
    'loginusername' => 'Username you signed up with',
    'user:password:lost' => 'Forgot password',
    'new_user' => 'New user?',
    'user:notfound' => 'Username not found.',
    'user:register' => 'Sign up',
    'user:username:login' => 'Login',
    'user:login' => 'Log in',
    'user:forgotpassword' => 'Forgot your password?',
    'passwordagain' => 'Repeat password please',
    'user:forgotpassword:ok' => 'Check your email to confirm your password reset.',
    // New password
    'user:resetpassword:newpassword' => 'New password',
    'user:resetpassword:newpasswordagain' => 'New password (again for verification)',
    // Widgets
    // Autocomplete
    'autocomplete:hint' => "Type in a search term",
    'autocomplete:noresults' => "No results",
    'autocomplete:searching' => "Searching...",
    // Time (future)
    'friendlytime:next:justnow' => "just now",
    'friendlytime:next:minutes' => "%s minutes",
    'friendlytime:next:minutes:singular' => "a minute",
    'friendlytime:next:hours' => "%s hours",
    'friendlytime:next:hours:singular' => "an hour",
    'friendlytime:next:days' => "%s days",
    'friendlytime:next:days:singular' => "tomorrow",

    // Positions
    'position:li:es' => 'Lead Investigator - Spain',
    'position:li:de' => 'Lead Investigator - Germany',
    'position:tpm' => 'Technical Project Manager',
    'position:swd' => 'Senior Web Developer',
    'position:researcher' => 'Researcher',
    'position:gd' => 'Graphic Designer',
    'position:ra' => 'Research Advisor',
    'position:ta' => 'Technical Advisor',

    // jQuery fileupload
    'fileupload:maxnumber' => 'Maximum number of files exceeded',
    'fileupload:acceptfiles' => 'File type not allowed',
    'fileupload:maxfile' => 'File is too large',
    'fileupload:minfile' => 'File is too small',
);

add_translation('en', $english);
