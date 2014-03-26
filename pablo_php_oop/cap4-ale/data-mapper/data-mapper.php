<?php


/*
 * class Produto
 * representa um Produto a ser vendido
 */
final class Produto {

    private $descricao;     // descricao do produto
    private $estoque;       // estoque atual
    private $preco_custo;   // preço de custo

    public function __construct($descricao, $estoque, $preco_custo) {
        $this->descricao = $descricao;
        $this->estoque = $estoque;
        $this->preco_custo = $preco_custo;
    }

    public function getDescricao() {
        return $this->descricao;
    }

}



/*
 * classe Venda
 * representa uma Venda de Produtos
 */
final class Venda {

    private $id;
    private $itens; // itens da cesta

    function __construct($id) {
        $this->id = $id;
    }

    function getID() {
        return $this->id;
    }

    public function addItem($quantidade, Produto $produto) {
        $this->itens[] = array($quantidade, $produto);
    }

    public function getItens() {
        return $this->itens;
    }

}



/*
 * class Venda Mapper
 * Implementa Data Mapper para a classe Venda
 */
final class VendaMapper {

    function insert(Venda $venda) {
        
        $id = $venda->getID();
        
        date_default_timezone_set('America/Sao_Paulo');
        $date = date("Y-m-d");

        // insere a venda no banco de dados
        $sql = "INSERT INTO venda (id, data) values ('$id', '$date')";
        echo $sql . "<br>\n";

        // percorre os itens vendidos
        foreach ($venda->getItens() as $item) {
            $quantidade = $item[0];
            $produto = $item[1];
            $descricao = $produto->getDescricao();

            // insere os itens da venda no banco de dados
            $sql = "INSERT INTO venda_items (ref_venda, produto, quantidade)" .
                    " values ('$id', '$descricao', '$quantidade')";
            echo $sql . "<br>\n";
        }
    }

}

/**
 * Implementação
 */
$venda = new Venda(1000);
$venda->addItem(3, new Produto('Vinho', 10, 15));
$venda->addItem(2, new Produto('Salame', 20, 20));
$venda->addItem(1, new Produto('Queijo', 30, 10));

VendaMapper::insert($venda);
?>
