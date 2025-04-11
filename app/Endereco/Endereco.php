<?php
namespace Endereco;

use Exception;
class Endereco {
    private string $setor;
    private int $andar;
    private int $posicao;
    private int $id;

    public function __construct($setor, $andar, $posicao, $id = -1) {
        $this->setor = $setor;
        $this->andar = $andar;
        $this->posicao = $posicao;
        $this->id = $id;
    }

    public function getSetor() {
        return $this->setor;
    }

    public function setSetor($setor) {
        $this->setor = $setor;
    }

    public function getAndar() {
        return $this->andar;
    }

    public function setAndar($andar) {
        $this->andar = $andar;
    }

    public function getPosicao() {
        return $this->posicao;
    }

    public function setPosicao($posicao) {
        $this->posicao = $posicao;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($novoId) {
        if($this->id != -1){
            throw new Exception("O endereço já foi cadastrado, experimente recarregar a aplicação!");
        }
        $this->id = $novoId;
    }

    public function getEnderecoStrg() {
        return "{$this->setor}{$this->andar}-{$this->posicao}";
    }

    public function __toString() {
        return "Setor: {$this->setor}, Andar: {$this->andar}, Posição: {$this->posicao}";
    }
}
?>