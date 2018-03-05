<?php

class Connect 
{

    /** 
     * Pattern Singleton
     * @var Connect */
    private static $singletonLogs;
    
    /**
     * var PDO
     */
    protected $pdo;


    protected function __construct() {
        
        try 
        {
            $this->pdo = new PDO("mysql:dbname=iugu;host=localhost;charset=utf8", 'root', '');
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } 
        catch (Exception $exc) 
        {
            echo $exc->getMessage();
        }
    }
    protected function __wakeup() {}
    protected function __clone() {}
		
    //Pattern Singleton
    public static function getInstance() 
    {
        if (self::$singletonLogs === null) 
        {
            self::$singletonLogs = new Connect();
            //echo 'Nova instancia da classe SingletonLogs<br>';
        } 
        else 
        {
            //echo 'A classe já foi instanciada!<br>';
        }

        return self::$singletonLogs;
    }
    
    //exemple for return the objeto PDO
    public function prepare($query) 
    {
        return $this->pdo->prepare($query);
    }
    
    
    //Access direct the database
    public function query($query) 
    {
        $access = $this->pdo->query($query);
        return $access->fetchAll();
    }
    
    //salva os dados do cliente no nosso banco de dados
    public function salvaClienteIugu($vet) 
    {
        $query = "INSERT INTO teste_cliente_iugu (email,nome,cpf_cnpj,zip_code,number,street,city,state,district,complement,id_iugu) VALUES (:email,:nome,:cpf,:cep,:num,:rua,:cidade,:uf,:bairro,:complemento,:idiugu)";
        
        //colocando os dados do cliente em nosso banco de dados e também salvando o idiugu
        $sql = $this->pdo->prepare($query);
        $sql->bindValue(":email",$vet['email_cria_cliente']);
        $sql->bindValue(":nome",$vet['nome_cria_cliente']);
        $sql->bindValue(":cpf",$vet['cpfcnpj_cria_cliente']);
        $sql->bindValue(":cep",$vet['cep_cria_cliente']);
        $sql->bindValue(":num",$vet['numero_cria_cliente']);
        $sql->bindValue(":rua",$vet['rua_cria_cliente']);
        $sql->bindValue(":cidade",$vet['cidade_cria_cliente']);
        $sql->bindValue(":uf",$vet['uf_cria_cliente']);
        $sql->bindValue(":bairro",$vet['bairro_cria_cliente']);
        $sql->bindValue(":complemento",$vet['complemento_cria_cliente']);
        $sql->bindValue(":idiugu",$vet['id_iugu']);
        $sql->execute();
        if($sql->rowCount() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    
    
    //pega o id da iugu
    public function dadosCliente($id, $select = 0) 
    {
        if($id == 'all')
        {
            $query = "SELECT * FROM teste_cliente_iugu";
        
            $puxa = $this->pdo->prepare($query);
        }
        else
        {
            $query = "SELECT * FROM teste_cliente_iugu WHERE id = :id ";
        
            $puxa = $this->pdo->prepare($query);
            $puxa->bindValue(':id', $id, PDO::PARAM_INT);
        }
        
        $puxa->execute();
        
        $sele = "<option value=''>Selecione...</option>";
        
        if($puxa->rowCount()> 0)
        {
            $rsp = $puxa->fetchAll();
            
            foreach ($rsp as $value) 
            {
                $sele .= "<option class='cli' data-identificador='".$value['id']."' value='".$value['id_iugu']."'>{$value['nome']}</option>";
            }
        }
        
        if(empty($select))
        {
            return $puxa->fetch();
        }
        else
        {
            return $sele;
        }
    }
    
    
    //salva o id de fatura que vem da Iugu e cria um serviço na tabela
    public function criaFatura($idC, $idF) 
    {
        $query = "INSERT INTO teste_servico_iugu SET 
                    id_cliente = :idCli,
                    tipo       = 'certidao',
                    id_fatura  = :idF
        ";
        
        $fatura = $this->pdo->prepare($query);
        $fatura->bindValue(':idCli', $idC);
        $fatura->bindValue(':idF', $idF);
        $fatura->execute();
        
        if($fatura->rowCount() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    
}
