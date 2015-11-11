<?php
/**
 * Clipit theme Portuguese language file.
 *
 */

$portuguese = array(
    'locale' => 'pt_PT',
    'user:profile:avatar'=> 'Avatar de usuário',
    'clipit:site' => 'Clipit',
    'loading' => 'Carregando',
    'loading:content' => 'Carregando o conteudo',
    'loading:charts' => 'Carregando graficos',
    'follow_us' => 'Segue-nos',
    'clipit:slogan' => 'Cria, aprende e partilha',
    'clipit:slogan:create' => 'Cria',
    'clipit:slogan:learn' => 'Aprende',
    'clipit:slogan:share' => 'Partilha',
    'clipit:foot:mail' => 'Correio eletrônico',

    // ERROR
    'error:404' => "Ficheiro nap encontrado.",
    'view_all' => 'Ver todos',
    'view_as' => 'Ver como',
    'me'    => "Eu",
    'options' => 'Opcoes',
    'home' => 'inicio',
    'selectall' => 'Selecionar tudo',
    'apply' => 'Aplicar',
    // Validation
    'validation:required' =>  "Campo obrigatorio.",
    'validation:remote' =>  "Por favor corrige este campo.",
    'validation:email' =>  "Por favor insira um email valido.",
    'validation:url' =>  "Por favor insira um URL valido.",
    'validation:date' =>  "Por favor insira uma data valida.",
    'validation:dateISO' =>  "Por favor insira uma data valida (ISO).",
    'validation:number' =>  "Por favor insira um numero valido.",
    'validation:digits' =>  "Por favor insira somente digitos.",
    'validation:creditcard' =>  "Por favor insira um numero de carta de credito valido.",
    'validation:equalTo' =>  "Por favor insira o mesmo valor novamente.",
    'validation:accept' =>  "Por favor insira um valor com uma extensão valida.",
    'validation:maxlength' =>  "Por favor não insira mais do que {0} caracteres.",
    'validation:minlength' =>  "Por favor insira pelo menos {0} caracteres.",
    'validation:rangelength' =>  "Por favor insira um valor entre {0} e {1} caracteres.",
    'validation:range' =>  "Por favor insira um valor entre {0} e {1}.",
    'validation:max' =>  "Por favor insira um valor menor ou igual a {0}.",
    'validation:min' =>  "Por favor insira um valor maior ou igual a {0}.",

    // Menu footer
    'menu:footer_clipit:header:clipit' => 'Clipit
<small style="color: #fff;font-size: 68%;">
'.(get_config('clipit_version')?'v':'').''.get_config('clipit_version').'</small>',
    'menu:footer_clipit:header:help' => 'Ajuda',
    'menu:footer_clipit:header:legal' => 'Legal',
    'send:email_to_site' => 'Enviar email para o site',

    'about' => 'Sobre',
    'team' => 'Equipa',
    'internship' => 'Colaborador',
    'internships' => 'Colaboradores',
    'developers' => 'Desenvolvedores',
    'support_center' => 'Support Center',
    'basics' => 'Essencial',
    'privacy' => 'Politica de privacidade',
    'terms' => 'Terms and conditions',
    'community_guidelines' => 'Diretrizes Comunitarias',

    // Form no login
    'loginusername' => 'Utilizador ou email para se identificar',
    'user:password:lost' => 'Password perdida',
    'new_user' => 'Novo utilizador?',
    'user:notfound' => 'Utilizador ou email não encontrado.',
    'user:register' => 'Registrar-se',
    'user:login' => 'Entrar',
    'user:forgotpassword' => 'Perdeu a password?',
    'passwordagain' => 'Repita a password por favor',
    'user:forgotpassword:ok' => 'verifique o seu email para confirmar a alteração da password.',
    // New password
    'user:resetpassword:newpassword' => 'Nova password',
    'user:resetpassword:newpasswordagain' => 'Nova password (novamente para confirmar)',
    // Widgets
    // Autocomplete
    'autocomplete:hint' => "Escreva um termo para pesquisa",
    'autocomplete:noresults' => "Sem resultados",
    'autocomplete:searching' => "Procurando...",
    // Time (future)
    'friendlytime:next:justnow' => "agora",
    'friendlytime:next:minutes' => "%s minutos",
    'friendlytime:next:minutes:singular' => "um minuto",
    'friendlytime:next:hours' => "%s horas",
    'friendlytime:next:hours:singular' => "uma hora",
    'friendlytime:next:days' => "%s dias",
    'friendlytime:next:days:singular' => "amanha",

    // Positions
    'position:li:es' => 'Investigador Principal - Portugal',
    'position:li:de' => 'Investigador Principal - Alemanha',
    'position:tpm' => 'Responsavel Tecnico do Projeto',
    'position:swd' => 'Senior Web Developer',
    'position:researcher' => 'Investigador',
    'position:gd' => 'Designer Grafico',
    'position:ra' => 'Consultor de Investigacao',
    'position:ta' => 'Consultor Tecnico',
);

add_translation('pt', $portuguese);