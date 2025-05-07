Ótimo, a tela de instalação do GLPI reconheceu o container mysql com sucesso!

Agora basta preencher assim:

## Endereço do servidor SQL: mysql
## Usuário SQL: glpi_user
## Senha SQL: glpi

Clique em “Continuar”, e na próxima tela escolha o banco de dados glpidb.
Se você quiser, posso gerar um script start-glpi.sh que faz todo o processo de subir os containers automaticamente com docker-compose. Deseja isso?


produção: http://host.docker.internal:5678/webhook/b917d3cd-fbbc-4245-bcdd-c5048d7696b1
teste: http://host.docker.internal:5678/webhook-test/b917d3cd-fbbc-4245-bcdd-c5048d7696b1
http://host.docker.internal

{
    "input":{
  "name": {{ $json.output }},
    "content": "DENKE ARENTINA\nPINORIUM\nTEMPLY: MAR SOLUCIO",
    "_users_id_requester": 123,
     "requester": "email@usuario.com", 
    "urgency": 3,
    "impact": 2,
    "priority": 4,
    "itilcategories_id": 1,
    "type": 1,
    "status": 1,
    "requesttypes_id": 1
    }
} 