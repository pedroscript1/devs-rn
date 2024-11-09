# devs-rn
# Associação Devs do RN - Sistema de Gerenciamento de Associados

Este é um sistema de gerenciamento de associados desenvolvido para a associação "Devs do RN". O software permite o cadastro e gestão de associados e anuidades, além de facilitar o controle de pagamentos.

## 📋 Funcionalidades

- Cadastro de associados (Nome, E-mail, CPF e Data de filiação)
- Cadastro de anuidades (Ano e Valor)
- Cobrança e pagamento de anuidades
- Identificação de associados com pagamentos em dia ou em atraso
- Edição e exclusão de associados e anuidades

## 🛠️ Tecnologias Utilizadas

- PHP
- MySQL
- HTML/CSS
- JavaScript (opcional, se você tiver usado)
- XAMPP (ou outro servidor local)

## 🚀 Instalação

### 1. Pré-requisitos

Antes de começar, certifique-se de ter as seguintes ferramentas instaladas:

- [XAMPP](https://www.apachefriends.org/index.html) ou outro servidor local (Apache + MySQL)
- [Git](https://git-scm.com/)
- Editor de código, como [Visual Studio Code](https://code.visualstudio.com/)

### 2. Clone o Repositório

```bash
git clone https://github.com/seu-usuario/associacao.git
cd associacao

### 3. Configuração do banco de dados

- Abra o phpMyAdmin em http://localhost/phpmyadmin.

- Crie um novo banco de dados chamado associacao.

- Importe o arquivo meu_database.sql disponível na raiz do projeto:

- No phpMyAdmin, clique na aba Importar, selecione o arquivo meu_database.sql e clique em Executar.

### 4. Configuração do Arquivo config.php

- Abra o arquivo config.php na raiz do projeto.

- Configure as credenciais do banco de dados:

<?php
$host = 'localhost';
$dbname = 'associacao';
$username = 'root';
$password = '';

5. Iniciar o Servidor
- Abra o XAMPP e inicie o Apache e MySQL.
- Acesse o projeto em http://localhost/associacao.

📝 Como Usar:

- Acesse a página de associados para cadastrar novos membros.
- Acesse a página de anuidades para definir os valores de cada ano.
- Realize cobranças e pagamentos de anuidades na página de checkout.
- Verifique o status de pagamento dos associados.

🗂️ Estrutura do Projeto:

associacao/
├── config.php
├── meu_database.sql
├── associados.php
├── adicionar_associado.php
├── editar_associado.php
├── excluir_associado.php
├── anuidades.php
├── adicionar_anuidade.php
├── editar_anuidade.php
├── excluir_anuidade.php
├── checkout.php
├── pagamento.php
├── pagamentos.php
├── status_pagamento.php/


📧 Contato
Desenvolvedor: Pedro Henrique
E-mail: pedrohen1501@gmail.com





