Ótimo, a tela de instalação do GLPI reconheceu o container mysql com sucesso!

Agora basta preencher assim:

## Endereço do servidor SQL: mysql
## Usuário SQL: glpi_user
## Senha SQL: glpi

Clique em “Continuar”, e na próxima tela escolha o banco de dados glpidb.
Se você quiser, posso gerar um script start-glpi.sh que faz todo o processo de subir os containers automaticamente com docker-compose. Deseja isso?


produção: http://host.docker.internal:5678/webhook/b917d3cd-fbbc-4245-bcdd-c5048d7696b1
teste: http://host.docker.internal:5678/webhook-test/b917d3cd-fbbc-4245-bcdd-c5048d7696b1