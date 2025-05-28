<?php

class Produto {
    // Propriedades
    private string $nome;
    private float $preco;
    private int $quantidade;

    // Construtor
    public function __construct(string $nome, float $preco, int $quantidade) {
        $this->nome = $nome;
        $this->preco = $preco;
        $this->quantidade = $quantidade;
    }

    // Getters
    public function getNome(): string {
        return $this->nome;
    }

    public function getPreco(): float {
        return $this->preco;
    }

    public function getQuantidade(): int {
        return $this->quantidade;
    }

    // Setters
    public function setNome(string $nome): void {
        $this->nome = $nome;
    }

    public function setPreco(float $preco): void {
        if ($preco >= 0) {
            $this->preco = $preco;
        }
    }

    public function setQuantidade(int $quantidade): void {
        if ($quantidade >= 0) {
            $this->quantidade = $quantidade;
        }
    }

    // Método para calcular o valor total em estoque
    public function calcularValorTotal(): float {
        return $this->preco * $this->quantidade;
    }

    // Exibe as informações do produto
    public function exibirProduto(): void {
        echo "Produto: {$this->nome}\n";
        echo "Preço: R$ " . number_format($this->preco, 2, ',', '.') . "\n";
        echo "Quantidade em estoque: {$this->quantidade}\n";
        echo "Valor total em estoque: R$ " . number_format($this->calcularValorTotal(), 2, ',', '.') . "\n";
    }
}

// Exemplo de uso
$produto = new Produto("Relogio", 6000.00, 5);
$produto->exibirProduto();

?>
