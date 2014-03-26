<?php
/*
 * classe TRecord
 * Esta classe prov� os m�todos necess�rios para persistir e
 * recuperar objetos da base de dados (Active Record)
 */
abstract class TRecord
{
    protected $data; // array contendo os dados do objeto
    
    /* m�todo __construct()
     * instancia um Active Record. Se passado o $id, j� carrega o objeto
     * @param [$id] = ID do objeto
     */
    public function __construct($id = NULL)
    {
        if ($id) // se o ID for informado
        {
            // carrega o objeto correspondente
            $object = $this->load($id);
            if ($object)
            {
                $this->fromArray($object->toArray());
            }
        }
    }
    
    /*
     * m�todo __clone()
     * executado quando o objeto for clonado.
     * limpa o ID para que seja gerado um novo ID para o clone.
     */
    public function __clone()
    {
        unset($this->id);
    }
    
    /*
     * m�todo __set()
     * executado sempre que uma propriedade for atribu�da.
     */
    public function __set($prop, $value)
    {
        // verifica se existe m�todo set_<propriedade>
        if (method_exists($this, 'set_'.$prop))
        {
            // executa o m�todo set_<propriedade>
            call_user_func(array($this, 'set_'.$prop), $value);
        }
        else
        {
            if ($value === NULL)
            {
                unset($this->data[$prop]);
            }
            else
            {
                // atribui o valor da propriedade
                $this->data[$prop] = $value;
            }
        }
    }
    
    /*
     * m�todo __get()
     * executado sempre que uma propriedade for requerida
     */
    public function __get($prop)
    {
        // verifica se existe m�todo get_<propriedade>
        if (method_exists($this, 'get_'.$prop))
        {
            // executa o m�todo get_<propriedade>
            return call_user_func(array($this, 'get_'.$prop));
        }
        else
        {
            // retorna o valor da propriedade
            if (isset($this->data[$prop]))
            {
                return $this->data[$prop];
            }
        }
    }
    
    /*
     * m�todo getEntity()
     * retorna o nome da entidade (tabela)
     */
    private function getEntity()
    {
        // obt�m o nome da classe
        $class = get_class($this);
        
        // retorna a constante de classe TABLENAME
        return constant("{$class}::TABLENAME");
    }
    
    /*
     * m�todo fromArray
     * preenche os dados do objeto com um array
     */
    public function fromArray($data)
    {
        $this->data = $data;
    }
    
    /*
     * m�todo toArray
     * retorna os dados do objeto como array
     */
    public function toArray()
    {
        return $this->data;
    }
    
    /*
     * m�todo store()
     * armazena o objeto na base de dados e retorna
     * o n�mero de linhas afetadas pela instru��o SQL (zero ou um)
     */
    public function store()
    {
        // verifica se tem ID ou se existe na base de dados
        if (empty($this->data['id']) or (!$this->load($this->id)))
        {
            // incrementa o ID
            if (empty($this->data['id']))
            {
                $this->id = $this->getLast() +1;
            }
            // cria uma instru��o de insert
            $sql = new TSqlInsert;
            $sql->setEntity($this->getEntity());
            // percorre os dados do objeto
            foreach ($this->data as $key => $value)
            {
                // passa os dados do objeto para o SQL
                $sql->setRowData($key, $this->$key);
            }
        }
        else
        {
            // instancia instru��o de update
            $sql = new TSqlUpdate;
            $sql->setEntity($this->getEntity());
            // cria um crit�rio de sele��o baseado no ID
            $criteria = new TCriteria;
            $criteria->add(new TFilter('id', '=', $this->id));
            $sql->setCriteria($criteria);
            // percorre os dados do objeto
            foreach ($this->data as $key => $value)
            {
                if ($key !== 'id') // o ID n�o precisa ir no UPDATE
                
                {
                    // passa os dados do objeto para o SQL
                    $sql->setRowData($key, $this->$key);
                }
                
            }
        }
        // obt�m transa��o ativa
        if ($conn = TTransaction::get())
        
        {
            // faz o log e executa o SQL
            TTransaction::log($sql->getInstruction());
            $result = $conn->exec($sql->getInstruction());
            // retorna o resultado
            return $result;
        }
        else
        {
            // se n�o tiver transa��o, retorna uma exce��o
            throw new Exception('N�o h� transa��o ativa!!');
        }
    }
    
    /*
     * m�todo load()
     * recupera (retorna) um objeto da base de dados
     * atrav�s de seu ID e instancia ele na mem�ria
     * @param $id = ID do objeto
     */
    public function load($id)
    {
        // instancia instru��o de SELECT
        $sql = new TSqlSelect;
        $sql->setEntity($this->getEntity());
        $sql->addColumn('*');
        
        // cria crit�rio de sele��o baseado no ID
        $criteria = new TCriteria;
        $criteria->add(new TFilter('id', '=', $id));
        
        // define o crit�rio de sele��o de dados
        $sql->setCriteria($criteria);
        
        // obt�m transa��o ativa
        if ($conn = TTransaction::get())
        {
            // cria mensagem de log e executa a consulta
            TTransaction::log($sql->getInstruction());
            $result= $conn->Query($sql->getInstruction());
            
            // se retornou algum dado
            if ($result)
            {
                // retorna os dados em forma de objeto
                $object = $result->fetchObject(get_class($this));
            }
            return $object;
        }
        else
        {
            // se n�o tiver transa��o, retorna uma exce��o
            throw new Exception('N�o h� transa��o ativa!!');
        }
    }
    
    /*
     * m�todo delete()
     * exclui um objeto da base de dados atrav�s de seu ID.
     * @param $id = ID do objeto
     */
    public function delete($id = NULL)
    {
        // o ID � o par�metro ou a propriedade ID
        $id = $id ? $id : $this->id;
        
        // instancia uma instru��o de DELETE
        $sql = new TSqlDelete;
        $sql->setEntity($this->getEntity());
        
        // cria crit�rio de sele��o de dados
        $criteria = new TCriteria;
        $criteria->add(new TFilter('id', '=', $id));
        
        // define o crit�rio de sele��o baseado no ID
        $sql->setCriteria($criteria);
        
        // obt�m transa��o ativa
        if ($conn = TTransaction::get())
        {
            // faz o log e executa o SQL
            TTransaction::log($sql->getInstruction());
            $result = $conn->exec($sql->getInstruction());
            // retorna o resultado
            return $result;
        }
        else
        {
            // se n�o tiver transa��o, retorna uma exce��o
            throw new Exception('N�o h� transa��o ativa!!');
        }
    }
    
    /*
     * m�todo getLast()
     * retorna o �ltimo ID
     */
    private function getLast()
    {
        // inicia transa��o
        if ($conn = TTransaction::get())
        {
            // instancia instru��o de SELECT
            $sql = new TSqlSelect;
            $sql->addColumn('max(ID) as ID');
            $sql->setEntity($this->getEntity());
            
            // cria log e executa instru��o SQL
            TTransaction::log($sql->getInstruction());
            $result= $conn->Query($sql->getInstruction());
            
            // retorna os dados do banco
            $row = $result->fetch();
            return $row[0];
        }
        else
        {
            // se n�o tiver transa��o, retorna uma exce��o
            throw new Exception('N�o h� transa��o ativa!!');
        }
    }
}
?>