<?php
namespace Produto;

use Endereco\Endereco;

class Produto {
    private $id;
    private $codBarras;
    private $nome;
    private $quantidade;
    private $validade;
    private $endereco;

    public function __construct($codBarras, $nome, $quantidade, $validade, Endereco $endereco, $id = -1) {
        $this->id = $id;
        $this->codBarras = $codBarras;
        $this->nome = $nome;
        $this->quantidade = $quantidade;
        $this->validade = $validade;
        $this->endereco = $endereco;
    }

    public function getIdProduto() {
        return $this->id;
    }

    public function setIdProduto($novoId) {
        $this->id = $novoId;
    }
    public function getCodBarras() {
        return $this->codBarras;
    }

    public function setCodBarras($codBarras) {
        $this->codBarras = $codBarras;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function getQuantidade() {
        return $this->quantidade;
    }

    public function setQuantidade($quantidade) {
        $this->quantidade = $quantidade;
    }

    public function getValidade() {
        return $this->validade;
    }

    public function setValidade($validade) {
        $this->validade = $validade;
    }

    public function getEndereco() {
        return $this->endereco;
    }

    public function getEnderecoId() {
        return $this->endereco->getId();
    }

    public function getEnderecoStrg(){
        return $this->endereco->getEnderecoStrg();
    }

    public function setEndereco(Endereco $endereco) {
        $this->endereco = $endereco;
    }

    public function __toString() {
        return "Produto: {$this->nome}<br>
        Código de Barras: {$this->codBarras}<br>
        Quantidade: {$this->quantidade}<br>
        Validade: {$this->validade}<br>
        Localização: {$this->getEndereco()}";
    }
}

?>