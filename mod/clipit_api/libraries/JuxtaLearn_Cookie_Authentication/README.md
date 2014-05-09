# JuxtaLearn cookie authentication

A simple shared library to authenticate via HTTP domain cookies.

Note, this PHP library really is actually quite generic!

Project:

* [JuxtaLearn: project, and ClipIt](http://juxtalearn.org)
* [JuxtaLearn: Tricky Topic tool](http://juxtalearn.net)
* [GitHub: JuxtaLearn code](https://github.com/juxtalearn)
* [GitHub: IET-OU code][ou-jxl]

## Usage – authentication master:

    <?php
    define( 'JXL_COOKIE_SECRET_KEY', '54321{ long, random and shared }' );
    define( 'JXL_COOKIE_DOMAIN', '.juxtalearn.example.org' );
    
    $auth = new JuxtaLearn_Cookie_Authentication();
    
    $auth->set_required_cookie( 'johndoe', 'teacher', $user_id = 999 );
    $auth->set_name_cookie( 'John A. Doe' );
    // ...

## Usage – authentication slave:

    <?php
    define( 'JXL_COOKIE_SECRET_KEY', '54321{ long, random and shared }' );
    
    $auth = new JuxtaLearn_Cookie_Authentication();
    
    $result = $auth->parse_cookies();
    if ($auth->is_authenticated()) {
        var_dump( $result[ 'user_login' ] );
        //...
    }

## License

License:  [GNU LGPL v2.1 onwards](http://gnu.org/licenses/lgpl-2.1.html).
Copyright © 2014 The Open University.


[ou-jxl]: https://github.com/IET-OU/oer-evidence-hub-org/tree/quiz/CR1/scaffold
[End]: http://example