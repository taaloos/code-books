<?php
/*
 * classe Repository
 * esta classe provê os métodos necessários para manipular coleções de objetos.
 * 
 * A classe que implementar um repository deve aceitar especificações como as estudadas no capítulo anterior (3),
 * que permitam selecionar um determinado grupo de objetos de forma flexível.
 * 
 * Os objetos devem ser selecionados, excluídos e retornados a partir de uma classe Repository,
 * por meio das especificações de critérios,
 * 
 */
abstract class Repository {


    /*
     * método load()
     * Recuperar um conjunto de objetos (collection) da base de dados
     * através de um critério de seleção, e instanciá-los em memória
     */
    /**
     * Função que retorna um array de objetos.
     *
     * getArrObjectos();
     * obtem um array neste formato:
     *      array(
     *          $obj1,
     *          $obj2,
     *          $obj3,
     *          etc...)
     *
     * getArrObjectos(null, "nome-do-campo-da-tabela");
     * obtem um array neste formato
     *      array(
     *          $obj1->campo,
     *          $obj2->campo,
     *          $obj3->campo,
     *          etc...)
     *
     * getArrObjectos("nome-do-campo-da-tabela");
     * obtem um array neste formato
     *      array(
     *          $obj1->campo => $obj1,
     *          $obj2->campo => $obj2,
     *          $obj3->campo => $obj3,
     *          etc...)
     *
     *
     * getArrObjectos("nome-do-campo-da-tabela", "nome-do-campo-da-tabela");
     * Obtem um array neste formato
     *      array(
     *          $obj1->campo_chave => $obj1->campo_valor,
     *          $obj2->campo_chave => $obj2->campo_valor,
     *          $obj3->campo_chave => $obj3->campo_valor
     *          etc...)
     *
     *
     */
    function load($criterio=null, $chave=null, $valor=null) {
        // executa a consulta no banco de dados
        $sql = "SELECT * FROM $criterio";
        $result= $conn->Query($sql);

        $results = array();
        if ($result)
        {
            // armazena no array $results;
            if($chave && $valor){
                while( $obj = $this->result->fetch_object() )
                    $results[$obj->$chave] = $obj->$valor;
            }
            elseif($chave){
                while( $obj = $this->result->fetch_object() )
                    $results[$obj->$chave] = $obj;
            }
            elseif($valor){
                while( $obj = $this->result->fetch_object() )
                    $results[]             = $obj->$valor;
            }
            else {
                while( $obj = $this->result->fetch_object() )
                    $results[]             = $obj;
            }
        }
        return $results;
    }

    
    
    
    /*
     * método delete()
     * Excluir um conjunto de objetos (collection) da base de dados
     * através de um critério de seleção.
     * @param $criteria = objeto do tipo TCriteria
     */
    function delete($criterio) {
        // executa instrução de DELETE
        $sql = "DELETE FROM tabela $criterio";
        $result = $conn->exec($sql);
        return $result;
    }
    
    
}
