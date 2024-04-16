# Desafio Revvo - Felipe Travassos

## Contato

- **Email:** contato@felipetravassos.com
- **Site:** [https://felipetravassos.com](https://felipetravassos.com)
- **Telefone/Whatsapp:** (81) 9 9827.7376

## Introdução

Este é o repositório do Desafio Revvo, desenvolvido por Felipe Travassos.

Foram seguidas diretrizes disponíveis nesse [repositório](https://bitbucket.org/leolearningbrasil/desafio-revvo) do BitBucket

## Visualização do Exemplo

Você pode visualizar um exemplo [aqui](https://desafiorevvo.felipetravassos.com).

## Instruções de Configuração

1. Execute o arquivo `desafio_revvo.sql` no seu banco de dados SQL para criar as tabelas necessárias.
2. Verifique se a extensão GD está ativada no seu servidor PHP, pois é necessária para o processamento de imagens.
3. Renomeie o arquivo `.env.example` para  `.env`.
4. Gere uma chave de acesso ao [TinyMCE](https://www.tiny.cloud).
5. Configure as informações de URL, Banco de Dados e a chave de acesso do TinyMCE no arquivo `.env` conforme as configurações do seu ambiente.
6. O login padrão do usuário é **email@user.com** e a senha padrão é **pass**.

## Observações

- Devido à estrutura de cursos, um botão "Veja mais cursos" foi adicionado ao layout, abaixo do módulo "Meus Cursos".
- O controle de URL amigável pode ser observado no arquivo 'includes/modules.php'.
- O formulário de pesquisa redireciona para uma página `search` que procura o que foi pesquisado no título, resumo ou no conteúdo do curso.
- Adicionei uma tela de gerenciamento de perfil `profile`, onde é possível alterar o avatar, gênero, nome e senha do usuário.

## Estrutura de Pastas

- `dist/`: Contém os arquivos estáticos da aplicação, incluindo HTML, CSS, JavaScript, imagens, etc.
- `includes/`: Contém arquivos PHP incluídos pela aplicação, como funções auxiliares, configurações, etc.
- `modules/`: Contém arquivos PHP que podem ser importados visualmente em outros módulos.

## Tecnologias Utilizadas

### Front-end:
- HTML5
- CSS3 (Bootstrap 5, SCSS)
- JavaScript (Bootstrap 5,AJAX)

### Back-end:
- PHP (PDO, Apache)
- SQL(MariaDB)

### Ferramentas:
- Gulp

## Bibliotecas CDN Utilizadas

- **Bootstrap** ^5.2.3
- **FontAwesome** ^5.15.4
- **Tiny MCE** ^5.10.9

## Dependências

### Dependências de Produção

- **gulp:** ^5.0.0
- **gulp-clean-css:** ^4.3.0

### Dependências de Desenvolvimento

- **gulp-autoprefixer:** ^9.0.0
- **gulp-concat:** ^2.6.1
- **gulp-sass:** ^5.1.0
- **gulp-uglify:** ^3.0.2
- **node-sass:** ^9.0.0
- **sass:** ^1.75.0
