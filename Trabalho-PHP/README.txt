===============================
SISTEMA DE CADASTRO DE FILMES
===============================

TRABALHO FINAL – PHP1  
Desenvolvido por: Eduardo Arruda e Adryan Portella

------------------------------------------
📌 Tema Escolhido:
Sistema de Gerenciamento de Filmes  
Com cadastro de usuários, login, inserção de filmes, listagem, edição e exclusão.

------------------------------------------
✅ RESUMO DO FUNCIONAMENTO:

1. Tela inicial (`index.php`) apresenta botões para Login e Cadastro.
2. Usuários podem se cadastrar com e-mail e senha.
3. O login verifica a senha criptografada.
4. Após login, o usuário pode:
   - Cadastrar novos filmes
   - Visualizar "Meus Filmes"
   - Editar e excluir filmes cadastrados
5. Cada usuário vê apenas seus filmes.

------------------------------------------
👨‍💻 USUÁRIO DE TESTE

E-mail: arruda@teste.com  
Senha: teste1

(Senha foi cadastrada com hash. Para novos testes, use `gerar_hash.php` para gerar o hash da senha desejada.)

------------------------------------------
📁 ESTRUTURA DE PASTAS

/Trabalho-PHP/
│
├── css/
│   └── style.css
│
├── includes/
│   ├── conexao.php
│   ├── funcoes.php
│   └── gerar_hash.php
│
├── sql/
│   └── criar_banco.sql
│
├── index.php
├── login.php
├── cadastro_USU.php
├── logout.php
│
├── inventario.php
├── formulario_filme.php
├── editar_filme.php
├── excluir_filme.php
├── processa_cadastro.php
├── autenticador.php
│
├── README.txt

------------------------------------------
💾 INSTALAÇÃO DO BANCO DE DADOS

1. Acesse o phpMyAdmin
2. Crie um novo banco de dados chamado: `filmes_db`
3. Importe o arquivo `sql/criar_banco.sql` (já cria as tabelas e insere um usuário de teste)
4. Verifique se o banco foi criado corretamente

------------------------------------------
🔒 OBSERVAÇÃO SOBRE SENHAS

O sistema usa `password_hash()` para criptografar senhas.
Use o script `gerar_hash.php` para gerar hashes de novas senhas.

------------------------------------------
📎 OBS: Este projeto foi desenvolvido para fins acadêmicos.
