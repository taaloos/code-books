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

/* cria as classes Active Record
   para manipular os registros das tabelas correspondentes */
class Turma extends TRecord
{
    const TABLENAME = 'turma';
}
class Inscricao extends TRecord
{
    const TABLENAME = 'inscricao';
}

// deleta objetos do banco de dados
try
{
    // inicia transa��o com o banco 'pg_livro'
    TTransaction::open('pg_livro');
    
    // define o arquivo para LOG
    TTransaction::setLogger(new TLoggerTXT('/tmp/log9.txt'));
    
    // primeiro exemplo, exclui todas turmas da tarde
    TTransaction::log("** exclui as turmas da tarde");
    
    // instancia um crit�rio de sele��o turno = 'T'
    $criteria = new TCriteria;
    $criteria->add(new TFilter('turno', '=', 'T'));
    
    // instancia reposit�rio de Turmas
    $repository = new TRepository('Turma');
    
    // retorna todos objetos que satisfazem o crit�rio
    $turmas = $repository->load($criteria);
    
    // verifica se retornou alguma turma
    if ($turmas)
    {
        // percorre todas turmas retornadas
        foreach ($turmas as $turma)
        {
            // exclui a turma
            $turma->delete();
        }
    }
    
    // segundo exemplo, exclui as inscri��es do aluno "1"
    TTransaction::log("** exclui as inscri��es do aluno '1'");
    
    // instancia crit�rio de sele��o de dados ref_aluno ='1'
    $criteria = new TCriteria;
    $criteria->add(new TFilter('ref_aluno', '=', 1));
    
    // instancia reposit�rio de Inscri��o
    $repository = new TRepository('Inscricao');
    
    // exclui todos objetos que satisfa�am este crit�rio de sele��o
    $repository->delete($criteria);
    echo "registros exclu�dos com sucesso <br>\n";
    
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