# Desafio Revvo - Felipe Travassos

## Introdução

Este é o repositório do Desafio Revvo, desenvolvido por Felipe Travassos.

## Visualização do Exemplo

Você pode visualizar um exemplo do Desafio Revvo em [https://desafiorevvo.felipetravassos.com](https://desafiorevvo.felipetravassos.com).


## Instruções de Configuração

1. Execute o arquivo `desafio_revvo.sql` no seu banco de dados SQL para criar as tabelas necessárias.
2. Verifique se a extensão GD está ativada no seu servidor PHP, pois é necessária para o processamento de imagens.
3. Configure as informações de URL e Banco de Dados no arquivo `.env` conforme as configurações do seu ambiente.
4. Aponte o subdomínio para a pasta `dist/` para garantir o correto funcionamento da aplicação.
5. **Aviso:** O login padrão do usuário é "email@user.com" e a senha padrão é "pass".

## Observações

- Devido à estrutura de cursos, um botão "Veja mais cursos" foi adicionado ao layout, abaixo do módulo "Meus Cursos".
- O controle de URL amigável pode ser observado no arquivo 'includes/modules.php'.

## Estrutura de Pastas

- `dist/`: Contém os arquivos estáticos da aplicação, incluindo HTML, CSS, JavaScript, imagens, etc.
- `includes/`: Contém arquivos PHP incluídos pela aplicação, como funções auxiliares, configurações, etc.
- `modules/`: Contém arquivos PHP que podem ser importados visualmente em outros módulos.
- `uploads/`: Pasta onde os uploads de imagens são armazenados.

## Tecnologias Utilizadas

- HTML
- CSS (Bootstrap 5)
- JavaScript (Bootstrap 5, AJAX)
- PHP (PDO, MySQL)
