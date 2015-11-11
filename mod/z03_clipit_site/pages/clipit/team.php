<?php
/**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   2/09/14
 * Last update:     2/09/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
// Team members description
$spanish = array(
    'team:estefania' => 'Profesor contratado doctor de la Universidad Rey Juan Carlos. Sus intereses son el aprendizaje a través de las tecnologías, los sistemas de recomendación y las TIC para personas con discapacidad.',
    'team:pablollinas' => 'Ingeniero informático por la Universidad Autónoma de Madrid (España). Sus intereses son la programación, las redes, la aplicación de nuevas tecnologías en la vida cotidiana, y el análisis de big data.',
    'team:miguelangel' => 'Técnico Superior en desarrollo de aplicaciones web. Interesado en proyectos Open Source, cultura digital y nuevas tecnologias web.',
    'team:isidoro' => 'Doctor por la Universidad Rey Juan Carlos. Sus intereses se centran en la innovación docente y el desarrollo de software educativo para la enseñanza de la programación (informática educativa).',
    'team:jaime' => 'Profesor contratado doctor de la Universidad Rey Juan Carlos. Sus intereses de investigación son la enseñanza de informática, los sistemas interactivos y el aprendizaje a través de las tecnologías.',
    'team:manuel' => 'Profesor Titular de la Universidad Rey Juan Carlos. Interesado en las nuevas formas expresivas y de aprendizaje que permiten las tecnologías emergentes. ',
    'team:gemma' => 'Diseñadora gráfica y artista multidisciplinar licenciada en Bellas Artes. Su trabajo se desarrolla en las áreas de diseño editorial, imagen corporativa, cartelería e ilustración. Colabora en múltiples proyectos relacionados con las nuevas tecnologías aplicadas a la educación.',
    'team:phaya' => 'Doctor en Informática e Ing. de Telecomunicación. Apasionado de la innovación tecnológica y su aplicación a la educación y las redes sociales. Actualmente trabaja en el Instituto de Ingeniería del Conocimiento (Madrid, España).',
    'team:jorge' => 'Profesor de secundaria de la especialidad de informática de la Comunidad de Madrid. También ha trabajado como profesor asociado de la Universidad Rey Juan Carlos.',
    'team:ulrich' => 'Catedrático de la Universidad Duisburg-Essen y presidente del Rhine-Ruhr Institute for Applied Systeminnovation e.V.. Sus intereses incluyen el análisis, modelado y soporte de procesos de aprendizaje interactivos y colaborativos así como el análisis de redes sociales y comunidades.',
    'team:nils' => 'Director de tecnología e investigador en el Rhine-Ruhr Institute for Applied Systeminnovation e.V. Sus intereses incluyen el análisis, modelado y soporte de procesos de aprendizaje interactivos y colaborativos dentro de comunidades.',
    'team:oliver' => 'Ingeniero software e investigador junior en el Rhine-Ruhr Institute for Applied Systeminnovation e.V. Sus intereses se centran en los sistemas de recomendación para entornos de aprendizaje.',
);
add_translation('es', $spanish);
$english = array(
    'team:estefania' => 'Associate professor at Universidad Rey Juan Carlos, Spain. Her interests are focused on e-learning, recommender systems and ICT for people with disabilities.',
    'team:pablollinas' => 'Computer Engineer by the Universidad Autónoma de Madrid (Spain). His interests are programming, networking, new technology integration in daily life, and big data analysis.',
    'team:miguelangel' => 'Bachelor Degree in Web development. He is interested in Open Source projects, digital culture and last trends in Web technologies.',
    'team:isidoro' => 'PhD by Universidad Rey Juan Carlos. His interests are educational innovation and the development of educational software for teaching programming.',
    'team:jaime' => 'Associate professor at Universidad Rey Juan Carlos, Spain. His main research interests are CS education, interactive systems and technology enhanced learning.',
    'team:manuel' => 'Professor at the Rey Juan Carlos University. His interests are focused in how the emerging technologies improve the learning and the creativity.',
    'team:gemma' => 'Graphic designer, and multidisciplinary artist with a degree in Fine Arts. Her work specializes in editorial design, corporate identity, posters, and illustration. She collaborates in multiple projects related to new technologies applied in the field of education.',
    'team:phaya' => 'PhD in Computer Science and Telecommunication Engineer. He is a passionate about technology innovation and its application in learning and social networks. He is currently working at Instituto de Ingeniería del Conocimiento (Madrid, Spain).',
    'team:jorge' => 'Jorge Castellanos works at a secondary school computer science teacher for the Comunidad de Madrid government. He has also been working as associate professor at Universidad Rey Juan Carlos.',
    'team:ulrich' => 'Full professor at University Duisburg-Essen and Chairman of the Rhine-Ruhr Institute for Applied Systeminnovation e.V.. His research interests include analysis, modelling, and intelligent support of interactive and collaborative learning processes as well as social network analysis and community support.',
    'team:nils' => 'Chief Technology Officer and researcher at Rhine-Ruhr Institute for Applied Systeminnovation e.V. His interests include analysis, modelling, and intelligent support of interactive and collaborative learning processed esp. within communities.',
    'team:oliver' => 'Software engineer and junior researcher at  Rhine-Ruhr Institute for Applied Systeminnovation e.V. His research interests are focussed on recommender systems for learning environments.',
);
add_translation('en', $english);
// Internships description
$spanish = array(
    'internship:virginia' => 'Graduada en Ingeniería del Software por la Universidad Rey Juan Carlos. Ha desarrollado un sistema de recomendación basado en contenido.',
    'internship:angel' => 'Estudiante del Grado en Ingeniería Informática en la Universidad Rey Juan Carlos. Está desarrollando la versión de Clipit para dispositivos móviles.',
    'internship:rocio' => 'Estudiante de Ingeniería del Software de la Universidad Rey Juan Carlos. Ha desarrollado una herramienta para incluir preguntas.',
);
add_translation('es', $spanish);

$english = array(
    'internship:virginia' => 'Computer Software Engineer by Universidad Rey Juan Carlos. She has developed a content-based recommender system.',
    'internship:angel' => 'Computer Engineering student at Universidad Rey Juan Carlos. He is developing the mobile version.',
    'internship:rocio' => 'Undergraduate student of Computer Software Engineering at Universidad Rey Juan Carlos. She has developed a quizzes tool.',
);
add_translation('en', $english);

$images_dir = "mod/z03_clipit_site/z03_clipit_site/team/";

$team_members = array(
    'blue' => array(
        array(
            'name' => 'Estefanía Martín',
            'image' => "estefania.png",
            'position' => elgg_echo('position:li:es'),
            'description' => elgg_echo('team:estefania'),
            'social' => array(
                'twitter' => 'EstefaniaURJC',
                'youtube' => 'channel/UCAZfYqqx1pGvpyUaxikBlTw',
                'linkedin' => 'pub/estefania-martin/4/2a9/90a'
            )
        ),
        array(
            'name' => 'Pablo llinás',
            'image' => "llinas.png",
            'position' => elgg_echo('position:tpm'),
            'description' => elgg_echo('team:pablollinas'),
            'social' => array(
                'twitter' => 'pebs74',
                'youtube' => 'channel/UC9hkD-wj4pQiSnyKjN0FSng',
                'linkedin' => 'pub/pablo-llin%C3%A1s-arnaiz/4b/b43/b36'
            )
        ),
        array(
            'name' => 'Miguel A. Gutiérrez',
            'image' => "miguel.png",
            'position' => elgg_echo('position:swd'),
            'description' => elgg_echo('team:miguelangel'),
            'social' => array(
                'twitter' => 'miguelangelgm91',
                'youtube' => 'channel/UCAZfYqqx1pGvpyUaxikBlTw',
                'linkedin' => 'pub/miguel-%C3%A1ngel-guti%C3%A9rrez-moreno/8b/311/24b'
            )
        ),
        array(
            'name' => 'Isidoro Hernán',
            'image' => "isi.png",
            'position' => elgg_echo('position:researcher'),
            'description' => elgg_echo('team:isidoro'),
            'social' => array(
                'youtube' => 'channel/UCAZfYqqx1pGvpyUaxikBlTw',
                'linkedin' => 'pub/isidoro-hern%C3%A1n/1b/12b/254'
            )
        )
    ),
    'yellow' => array(
        array(
            'name' => 'Jaime Urquiza',
            'image' => "jaime.png",
            'position' => elgg_echo('position:researcher'),
            'description' => elgg_echo('team:jaime'),
            'social' => array(
                'twitter' => 'jaimeurquizaf',
                'youtube' => 'channel/UCAZfYqqx1pGvpyUaxikBlTw',
                'linkedin' => 'pub/jaime-urquiza-fuentes/50/8a0/711'
            )
        ),
        array(
            'name' => 'Manuel Gertrudix',
            'image' => "manuel.png",
            'position' => elgg_echo('position:researcher'),
            'description' => elgg_echo('team:manuel'),
            'social' => array(
                'twitter' => 'gertrudix',
                'youtube' => 'user/pantropia',
                'linkedin' => 'pub/manuel-g%C3%A9rtrudix-barrio/16/191/44b'
            )
        ),
        array(
            'name' => 'Gemma de Castro',
            'image' => "gemma.png",
            'position' => elgg_echo('position:gd'),
            'description' => elgg_echo('team:gemma'),
            'social' => array(
                'web' => 'http://www.gemmayuscula.com/',
                'linkedin' => 'pub/gemma-de-castro/22/987/427'
            )
        ),
        array(
            'name' => 'Pablo A. Haya',
            'position' => elgg_echo('position:ra'),
            'image' => "pabloh.png",
            'description' => elgg_echo('team:phaya'),
            'social' => array(
                'twitter' => 'pablohaya',
                'web' => 'http://pablohaya.com',
                'linkedin' => 'pub/pablo-haya/5/90b/536'
            )
        )
    ),
    'red' => array(
        array(
            'name' => 'Jorge J. Castellanos',
            'image' => "jorge.png",
            'position' => elgg_echo('position:ta'),
            'description' => elgg_echo('team:jorge'),
            'social' => array(
                'twitter' => 'jorgejjcv',
                'linkedin' => 'pub/jorge-castellanos-vega/65/514/969'
            )
        ),
        array(
            'name' => 'H. Ulrich Hoppe',
            'image' => "hoppe.png",
            'position' => elgg_echo('position:li:de'),
            'description' => elgg_echo('team:ulrich'),
            'cartoon' => false,
            'social' => array(
                'web' => 'http://www.rias-institute.eu',
            )
        ),
        array(
            'name' => 'Nils Malzahn',
            'image' => "malzahn.png",
            'position' => elgg_echo('position:researcher'),
            'description' => elgg_echo('team:nils'),
            'cartoon' => false,
            'social' => array(
                'web' => 'http://www.rias-institute.eu',
            )
        ),
        array(
            'name' => 'Oliver Daems',
            'image' => "oliver.png",
            'position' => elgg_echo('position:researcher'),
            'description' => elgg_echo('team:oliver'),
            'cartoon' => false,
            'social' => array(
                'web' => 'http://www.rias-institute.eu',
                'twitter' => 'ODaems'
            )
        )
    )
);

$internship_members = array(
    array(
        array(
            'name' => 'Virginia del Castillo',
            'image' => "virginia.png",
            'description' => elgg_echo('internship:virginia'),
        ),
        array(
            'name' => 'Ángel F. Sánchez',
            'image' => "angel.png",
            'description' => elgg_echo('internship:angel'),
        ),
        array(
            'name' => 'Rocío Blanco',
            'image' => "rocio.png",
            'description' => elgg_echo('internship:rocio'),
        )
    ),
);

$params = array(
    'content' => elgg_view('clipit/team', array('team' => $team_members, 'images_dir' => $images_dir)),
    'title'     => elgg_echo('team'),
    'filter'    => '',
    'class'     => 'clipit-sections team',

);
$internships = array('internships' => elgg_view('clipit/internships', array('internships' => $internship_members, 'images_dir' => $images_dir)));
$body = elgg_view_layout('one_column', $params);
echo elgg_view_page('', $body, 'team', $internships);