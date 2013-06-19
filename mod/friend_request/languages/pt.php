<?php

/*

                    jjj      
          jjjj     jjjjj     
          jjjj     jjjjj     
         jjjjjj    jjjjj     
         jjjjjj    jjjjj     
  jj      jjjjj    jjjjj     
tjjjj     jjjjj    jjjj      
jjjjjj     jjjj    jjj       
jjjjjjj     jj    jjj        
jjjjjjjj          jj         
 jjjjjjjj         jj         
  jjjjjjjj       jj          
     jjjjjj    tjjj          
         jjjjjjjjjj          
           jjjjjjjj          
            jjjjjjj          
            jjjjjjjj         
             jjjjjjj         
             jjjjjjjj        
             jjjjjjjjjj      
             jjjj    jjjjjjj 
             jj       jjjjjjj
             j         jjjjjjj
            jj          jjjjjj
           jjj           jjjjj
          jjj             jjj
         jjjj              j 
        jjjjj                        Desenvolvido por:                                  
        jjjjj                        Open Solutions - http://www.opensolutions.pt
       jjjjjj                
       jjjjjj                
        jjjjj                
         jjj           


*/

	$portugues = array(
		'friend_request' => "Pedido de amizade",
		'friend_request:menu' => "Pedidos de amizade",
		'friend_request:title' => "Pedidos de amizade para: %s",
	
		'friend_request:new' => "Novo pedido de amizade",
		
		'friend_request:friend:add:pending' => "Pedidos de amizade pendentes",
		
		'friend_request:newfriend:subject' => "%s quer adicioná-lo como amigo!",
		'friend_request:newfriend:body' => "%s quer adicioná-lo como amigo! No entanto terá de aprovar o seu pedido... Autentique-se agora para que possa aprová-lo!

Poderá ver os seus pedidos de amizade pendentes em:

%s

Deverá estar autenticado na rede antes de carregar no endereço, caso contrário será redireccionado para a página de login.

(Por favor não responda a este email.)",
		
		// Acções
		// Criar pedido
		'friend_request:add:failure' => "Não foi possível completar o seu pedido. Por favor, tente novamente.",
		'friend_request:add:successful' => "Enviou um pedido de amizade a %s. Ele(a) deverá aprová-lo para que possa aparecer na sua lista de amigos.",
		'friend_request:add:exists' => "Já enviou um pedido de amizade a %s.",
		
		// Aprovar pedido
		'friend_request:approve' => "Aprovar",
		'friend_request:approve:successful' => "%s é agora seu amigo",
		'friend_request:approve:fail' => "Ocorreu um erro ao criar a relação de amizade com %s",
	
		// Rejeitar pedido
		'friend_request:decline' => "Rejeitar",
		'friend_request:decline:subject' => "%s rejeitou o seu pedido de amizade",
		'friend_request:decline:message' => "Caro(a) %s,

%s rejeitou o seu pedido de amizade.",
		'friend_request:decline:success' => "Pedido de amizade rejeitado com sucesso",
		'friend_request:decline:fail' => "Ocorreu um erro ao rejeitar o pedido de amizade. Por favor, tente novamente",
		
		// Cancelar pedido
		'friend_request:revoke' => "Cancelar",
		'friend_request:revoke:success' => "Pedido de amizade cancelado com sucesso",
		'friend_request:revoke:fail' => "Ocorreu um erro ao cancelar o pedido de amizade. Por favor, tente novamente",
	
		// Vistas
		// Recebidos
		'friend_request:received:title' => "Pedidos de amizade recebidos",
		'friend_request:received:none' => "Não tem pedidos de amizade pendentes",
	
		// Enviados
		'friend_request:sent:title' => "Pedidos de amizade enviados",
		'friend_request:sent:none' => "Não existem pedidos de amizade enviados pendentes",
	);
					
	add_translation("pt", $portugues);
?>
