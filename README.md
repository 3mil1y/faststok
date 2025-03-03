FastStok
Bem-vindo ao FastStok! Este é um projeto de gerenciamento de estoque desenvolvido em PHP. Esta é a versão inicial do projeto.

Estrutura do Projeto
A estrutura do projeto é a seguinte:

root/
    autoloader.php
    baixarProduto.php
    classes/
        Componentes/
        DbConnect/
        Endereco/
        Manager/
        ModelClasses/
        Produto/
        Usuario/
    control.php
    Controllers/
        enderecoControl.php
        produtoControl.php
        usuarioControl.php
    enderecamento/
        cadastro.php
        pesquisa.php
    fluxoAdmin.php/
    index.php
    login/
        login.php
        session_log.txt
    pinto/
        dump.sql
    TESTE.php
    randomizer.php
    relatorio/
        baixoEstoque.php
        validade.php
    tail.css
    transferencia/
        interna.php
        saida.php
    usuarios/
        cadastro.php
        edicao.php
        lista.php
    validacoes/
        cadastroUsuario.php
        edicaoUsuario.php
        login.php
        validarBaixaProduto.php
        validarEnderecamento.php
        validarPesquisa.php
        validarTransferenciaExt.php
        validarTransferenciaInt.php
    Views/

Funcionalidades

Gerenciamento de Usuários: Cadastro, edição, exclusão e listagem de usuários.
Gerenciamento de Produtos: Cadastro, edição, exclusão e listagem de produtos.
Endereçamento de Produtos: Cadastro e pesquisa de endereços de produtos.
Transferência de Produtos: Transferência interna e externa de produtos.
Relatórios: Relatórios de produtos com baixo estoque e produtos com validade próxima.
Autenticação: Login e logout de usuários.

Requisitos
PHP 7.4 ou superior
Servidor web (Apache, Nginx, etc.)
Banco de dados MySQL

Instalação
1 - Clone o repositório para o seu servidor web:

git clone https://github.com/seu-usuario/faststok.git

2 - Configure o banco de dados no arquivo control.php:

$host = "localhost";
$username = "root";
$password = "";
$database = "FastStok";

3 - Importe o banco de dados a partir do arquivo dump.sql.

4 - Acesse o projeto no navegador:

http://localhost/faststok

Autoload
O projeto utiliza um autoloader para carregar automaticamente as classes. O autoloader está definido no arquivo autoloader.php.

Contribuição
Contribuições são bem-vindas! Sinta-se à vontade para abrir issues e pull requests.

Nota: Esta é a versão inicial do projeto FastStok. Novas funcionalidades e melhorias serão adicionadas nas próximas versões.

Contato: Para mais informações, entre em contato com emillywaiandt@gmail.com.