<?php
/*
 * fun��o __autoload()
 * carrega uma classe quando ela � necess�ria,
 * ou seja, quando ela � instancia pela primeira vez.
 */
function __autoload($classe)
{
    if (file_exists("app.ado/{$classe}.class.php"))
    {
        include_once "app.ado/{$classe}.class.php";
    }
}

/*
 * classe Inscricao, filha de TRecord
 * persiste uma Inscricao no banco de dados
 */
class Inscricao extends TRecord
{
    const TABLENAME = 'inscricao';
}

// obt�m objetos do banco de dados
try
{
    // inicia transa��o com o banco 'pg_livro'
    TTransaction::open('pg_livro');
    
    // define o arquivo para LOG
    TTransaction::setLogger(new TLoggerTXT('/tmp/log7.txt'));
    TTransaction::log("** seleciona inscri��es da turma 2");
    
    // instancia crit�rio de sele��o de dados
    // seleciona todas inscri��es da turma "2"
    $criteria = new TCriteria;
    $criteria->add(new TFilter('ref_turma', '=',      2));
    $criteria->add(new TFilter('cancelada', '=', FALSE));
    
    // instancia reposit�rio de Inscri��o
    $repository = new TRepository('Inscricao');
    
    // retorna todos objetos que satisfazem o crit�rio
    $inscricoes = $repository->load($criteria);
    
    // verifica se retornou alguma inscri��o
    if ($inscricoes)
    {
        TTransaction::log("** altera as inscri��es");
        
        // percorre todas inscri��es retornadas
        foreach ($inscricoes as $inscricao)
        {
            // altera algumas propriedades
            $inscricao->nota       = 8;
            $inscricao->frequencia = 75;
            
            // armazena o objeto no banco de dados
            $inscricao->store();
        }
    }
    
    // finaliza a transa��o
    TTransaction::close();
}
catch (Exception $e) // em caso de exce��o
{
    // exibe a mensagem gerada pela exce��o
    echo '<b>Erro</b>' . $e->getMessage();
    
    // desfaz todas altera��es no banco de dados
    TTransaction::rollback();
}
?>