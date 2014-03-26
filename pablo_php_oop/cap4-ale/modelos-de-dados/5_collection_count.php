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
class Aluno extends TRecord
{
    const TABLENAME = 'aluno';
}
class Turma extends TRecord
{
    const TABLENAME = 'turma';
}

// conta objetos do banco de dados
try
{
    // inicia transa��o com o banco 'pg_livro'
    TTransaction::open('pg_livro');
    
    // define o arquivo para LOG
    TTransaction::setLogger(new TLoggerTXT('/tmp/log8.txt'));
    
    // primeiro exemplo, conta todos alunos de Porto Alegre #
    TTransaction::log("** Conta Alunos de Porto Alegre");
    
    // instancia um crit�rio de sele��o
    $criteria = new TCriteria;
    $criteria->add(new TFilter('cidade', '=', 'Porto Alegre'));
    
    // instancia um reposot�rio de Alunos
    $repository = new TRepository('Aluno');
    
    // obt�m o total de alunos que satisfazem o crit�rio
    $count = $repository->count($criteria);
    
    // exibe o total na tela
    echo "Total de alunos de Porto Alegre: {$count} <br>\n";
    
    // segundo exemplo, Contar todas as turmas com aula na sala
    // "100" no turno da Tarde OU na "200" pelo turno da manha.
    TTransaction::log("** Conta Turmas");
    
    // instancia um crit�rio de sele��o
    // sala "100" e turno "T" (tarde)
    $criteria1 = new TCriteria;
    $criteria1->add(new TFilter('sala', '=', '100'));
    $criteria1->add(new TFilter('turno', '=',   'T'));
    
    // instancia um crit�rio de sele��o
    // sala "200" e turno "M" (manha)
    $criteria2 = new TCriteria;
    $criteria2->add(new TFilter('sala', '=', '200'));
    $criteria2->add(new TFilter('turno', '=',     'M'));
    
    // instancia um crit�rio de sele��o
    // com OU para juntar os crit�rios anteriores
    $criteria = new TCriteria;
    $criteria->add($criteria1, TExpression::OR_OPERATOR);
    $criteria->add($criteria2, TExpression::OR_OPERATOR);
    
    // instancia um reposit�rio de Turmas
    $repository = new TRepository('Turma');
    
    // retorna quantos objetos satisfazem o crit�rio
    $count = $repository->count($criteria);
    echo "Total de turmas: {$count} <br>\n";
    
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