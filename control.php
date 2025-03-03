<?php

require_once "autoloader.php";

use Endereco\Endereco;
use Produto\Produto;
use Usuario\Usuario;

use DbConnect\DbConnect;

use ModelClasses\ProdutoModel;
use ModelClasses\EnderecoModel;
use ModelClasses\UsuarioModel;

use Manager\SessionManager;


$db;
try {
    // Dados padrão do XAMPP
    $host = "localhost";
    $username = "root";
    $password = ""; // Senha vazia por padrão no XAMPP
    $database = "FastStok"; // Substitua pelo nome do seu banco de dados

    global $db;
    // Criando o objeto de conexão
    $db = new DbConnect($host, $username, $password, $database);
    
   // echo "Conexão bem-sucedida!";
} catch (Exception $e) {
    die("Erro: " . $e->getMessage());
}


// Declaração da variável global
$sessionManager = new SessionManager;
$usuarioModel = new UsuarioModel($db);

function checaLogin(){
    global $sessionManager;
    //$sessionControl->start();
    if(!$sessionManager->isLoggedIn()){
        return false;
    }
    return true;
}

function sessionLogin(string $login){
    global $sessionManager;

    //$sessionManager->start();
    
    $usuario = buscarUsuarioPorLogin($login);

    $sessionManager->login($usuario->getId(), $usuario->getLogin(), $usuario->getPermissao());
}

function sessionLogout(){
    global $sessionManager;

    $sessionManager->logout();
}

// Cadastrar um novo usuário
function cadastrarUsuario(Usuario $usuario, string $senha) {
    global $usuarioModel;
    return $usuarioModel->cadastrar($usuario, $senha);
}

//Lista os Usuarios Cadastrados
function listarUsuarios(): array{
    global $usuarioModel;
    return $usuarioModel->listar();
}

// Buscar usuário por ID
function buscarUsuarioPorId(int $id): ?Usuario {
    global $usuarioModel;
    return $usuarioModel->buscarPorId($id);
}

// Buscar usuário por login
function buscarUsuarioPorLogin(string $login): ?Usuario {
    global $usuarioModel;
    return $usuarioModel->buscarPorLogin($login);
}

// Validar login
function validarLogin(string $login, string $senha): bool {
    global $usuarioModel;
    return $usuarioModel->validarLogin($login, $senha);  // Utilizando a função interna
}

// Atualizar permissões de um usuário
function atualizarPermissoesDoUsuario(int $id, string $novaPermissao): bool {
    global $usuarioModel;
    return $usuarioModel->atualizarPermissoes($id, $novaPermissao);
}

// Deletar usuário
function excluirUsuarioPorId(int $id): bool {
    global $usuarioModel;
    return $usuarioModel->deletar($id);
}

// Declaração da variável global
$enderecoModel = new EnderecoModel($db);

// Cadastrar um novo endereço
function cadastrarEndereco(Endereco $endereco): bool {
    global $enderecoModel;
    return $enderecoModel->cadastrar($endereco); // Retorna true ou false
}

function buscarEnderecoPorDados(Endereco $endereco): ?Endereco{
    global $enderecoModel;
    return $enderecoModel->buscarPorDados($endereco);
}

// Listar todos os endereços
function listarEnderecos(): array {
    global $enderecoModel;
    return $enderecoModel->listar();  // Retorna um array de objetos Endereco
}

// Buscar endereço por ID
function buscarEnderecoPorId(int $id): ?Endereco {
    global $enderecoModel;
    return $enderecoModel->buscarPorId($id); // Retorna o objeto Endereco ou null
}

// Atualizar um endereço
function atualizarEndereco(Endereco $endereco): bool {
    global $enderecoModel;
    return $enderecoModel->atualizar($endereco); // Retorna true ou false
}

// Deletar um endereço
function deletarEndereco(Endereco $endereco): bool {
    global $enderecoModel;
    return $enderecoModel->deletar($endereco); // Retorna true ou false
}

// Declaração da variável global
$produtoModel = new ProdutoModel($db);

// Listar todos os produtos
function listarProdutos(): array {
    global $produtoModel;
    return $produtoModel->listar();  // Retorna um array de objetos Produto
}

function listarPorIdEstoque($id){
    global $produtoModel;
    return $produtoModel->listarPorIdEstoque($id);
}

// Listar todos os produtos
function listarProdutosValidadeProxima(): array {
    global $produtoModel;
    return $produtoModel->listarPorValidade();  // Retorna um array de objetos Produto próximos a validade
}

// Listar todos os produtos
function listarProdutosEstoqueBaixo(): array {
    global $produtoModel;
    return $produtoModel->listarPorEstoque();  // Retorna um array de objetos Produto próximos a validade
}


// Buscar produto por código de barras
function buscarProdutoPorCodigoDeBarras(string $codigoDeBarras): array {
    global $produtoModel;
    return $produtoModel->listarPorCodigoDeBarras($codigoDeBarras);  // Retorna o objeto Produto ou null
}

// Buscar produto por código de barras
function buscarProdutoPorId(int $id): ?Produto {
    global $produtoModel;
    return $produtoModel->listarPorId($id);  // Retorna o objeto Produto ou null
}

function buscarProdutosPorNome(string $nome): array {
    global $produtoModel;
    return $produtoModel->listarPorNome($nome);  // Retorna o objeto Produto ou null
}

// Cadastrar um novo produto
function cadastrarProduto(Produto $produto): bool {
    global $produtoModel;
    return $produtoModel->cadastrar($produto); // Retorna true ou false
}

function alterarEstoque(int $idProduto, int $quantidade): bool {
    global $produtoModel;
    return $produtoModel->alterarEstoque($idProduto, $quantidade); // Retorna true ou false
}

// Atualizar um produto existente
function atualizarProduto(Produto $produto): bool {
    global $produtoModel;
    return $produtoModel->atualizar($produto); // Retorna true ou false
}

// Deletar um produto
function deletarProduto(Produto $produto): bool {
    global $produtoModel;
    return $produtoModel->deletar($produto); // Retorna true ou false
}

function excluirProdutoPorEndereco(Endereco $Endereco): bool {
    global $produtoModel;
    return $produtoModel->excluirProdutoPorEndereco($Endereco); // Retorna true ou false
}

function atualizarEnderecoProdutos(Endereco $origem, Endereco $destino): bool {
    global $produtoModel;
    return $produtoModel->atualizarEnderecoProdutos($origem, $destino); // Retorna true ou false
}

// Atualizar o endereço de um produto
function atualizarEnderecoProduto(Produto $produto): bool {
    global $produtoModel;
    return $produtoModel->atualizarEndereco($produto); // Retorna true ou false
}