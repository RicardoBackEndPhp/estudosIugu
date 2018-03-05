<?php
/**
 * Description of Iugur
 *
 * @author Ricardo
 */
class Iugur 
{
    public $msgErro;
    public $idRetorno;
    public $respRetorno;
    
    /** 
     * Pattern Singleton
     * @var Iugur */
    private static $singletonLogs;
    


    protected function __construct() {
        require_once './lib/Iugu.php';
        
        //setando o ApiKey do qual pega na plataforma da iugu
        Iugu::setApiKey('e13a52d09b9130be7f47819b2df54b8d');
    }
    protected function __wakeup() {}
    protected function __clone() {}
		
    
    public function curl($args) 
    {
        //argumentos
        $args = array(
        'email' => $_POST['datanozesvia'],
        'name' => 'novo nome'
        );
        //cabeçalho, onde passo o ApiKey q vem no Iugu 
        $headers = array(
        'Authorization: Basic ' . base64_encode("e13a52d09b9130be7f47819b2df54b8d"),
        'Content-Type: multipart/form-data'
        );
        // usando a biblioteca cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.iugu.com/v1/customers/'.$idcaboco);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, array_map('utf8_encode', $args));
        $result = json_decode(curl_exec($ch));
        echo '<pre>';
        print_r($result);
        echo '</pre>';
    }
    
    //recebe o objeto Iugu e retorna o erro em forma de lista
    public function retErro($obj) 
    {
        //recebendo uma lista de erros encontrados
        $this->msgErro = '<ol>';
        $veterro = (array) $obj->errors;
        foreach ($veterro as $key => $value) 
        {
            $this->msgErro .= "<li><b>$key:</b> $value[0] </li>";
        }
        $this->msgErro .= '</ol>';
    }
    
    //Pattern Singleton
    public static function getInstance() 
    {
        if (self::$singletonLogs === null) 
        {
            self::$singletonLogs = new Iugur();
            //echo 'Nova instancia da classe SingletonLogs<br>';
        } 
        else 
        {
            //echo 'A classe já foi instanciada!<br>';
        }

        return self::$singletonLogs;
    }
    
    
    
    /**
     * ****************************************
     * **********      Clientes      **********
     * ****************************************
     */
    
    //Cadastrar um cliente na Iugu
    public function criaCliente($vet) 
    {
        /*            
            array(
                "email" => $_POST['email_cria_cliente'],
                "name" => $_POST['nome_cria_cliente'],
                "cpf_cnpj" => $_POST['cpfcnpj_cria_cliente'],
                "zip_code" => $_POST['cep_cria_cliente'],
                "number" => $_POST['numero_cria_cliente'],
                "street" => $_POST['rua_cria_cliente'],
                "city" => $_POST['cidade_cria_cliente'],
                "state" => $_POST['uf_cria_cliente'],
                "district" => $_POST['bairro_cria_cliente'],
                "complement" => $_POST['complemento_cria_cliente'],
                "custom_variables" => Array(
                    Array(
                        "name" => 'id_cliente',
                        "value" => 123
                    )
                )
            );
        */
        $resp = $retorno = Iugu_Customer::create($vet);
        
        if(isset($resp['id']) && !empty($resp['id']))
        {
            //Criado com sucesso!
            $this->idRetorno = $resp->id;
            $this->respRetorno = $resp;
            return TRUE;
        }
        else
        {
            $this->retErro($resp);
            return FALSE;
        }
    }
    
    //Busca de clientes
    public function buscaAllCliente() 
    {
        //iniciando variável de resposta
        $cliente = array();
        
        //puxando dados do clientes cadastrados na Iugu
        $busca = Iugu_Customer::search()->results();
                
        //transformando o resultado em um vetor decente
        foreach ($busca as $key => $value) 
        {
            $transforma = (array) $value;
            foreach ($transforma as $chave => $valor)
            {
                if(count($valor) > 0)
                {
                    $cliente[] = $valor;
                }
            }
        }
        
        return $cliente;
    }
    
    //Pesquisa clientes da Iugu por Key
    public function buscaCliente($keyIugu, $vet = 0) //Caso queira a resposta como vetor passe o "$vet" como 1
    {
        $resp = Iugu_Customer::fetch($keyIugu);
        
        //transformo o objeto em vetor
        if(!empty($vet))
        {
            foreach ( (array)$resp as $key => $value) 
            {
                foreach ($value as $chave => $valor)
                {
                    $vetor[$chave] = $valor;
                }
            }
            
            $resp = $vetor;
        }
        
        return $resp;
    }
    
    //alterar dados de um cliente da iugu
    public function alteraCliente($keyIugu, $vetDados = array()) 
    {
        if(is_array($vetDados) && count($vetDados) > 0)
        {
            //identificando o cliente
            $customer = Iugu_Customer::fetch($keyIugu);

            //alterando dados de acordo como vetor recebido
            foreach ($vetDados as $key => $value) 
            {
                $customer->$key = $value;
            }
            
            //salvando alteração
            if($customer->save())
            {
                return TRUE;
            }
            else
            {
                //recebendo uma lista de erros encontrados
                $this->retErro($customer);
                return FALSE;
            }
        }
        else 
        {
            $this->msgErro = 'Favor passar um vetor como segundo parâmetro.';
            return FALSE;
        }
    }
    
    //Excluir um cliente na iugu
    public function excluirCliente($id) 
    {
        $customer = Iugu_Customer::fetch($id);
        if($customer->delete())
        {
            return TRUE;
        }
        else
        {
            //recebendo uma lista de erros encontrados
            $this->retErro($customer);
            return FALSE;
        }
    }
    
    
    /**
     * ****************************************
     * **********     Pagamentos     **********
     * ****************************************
     */
    
    //pagamento com cartão de crédito
    public function pagamentoCartao($vet) 
    {
        /*
            Array(
                "token" = > "123AEAE123EA0kEIEIJAEI",
                "email" = > "teste@teste.com",
                "items" = > Array(
                    Array(
                        "description" = > "Item Um",
                        "quantity" = > "1",
                        "price_cents" = > "1000"
                    )
                ) ,
         * se tiver o id do cliente na IUGU
        
                "customer_id" => $cliente['id_iugu'] 
         
         * se não tiver o id do cliente na IUGU
         
                "payer" = > Array(
                    "name" = > "Item Um",
                    "phone_prefix" = > "1",
                    "phone" = > "1000",
                    "email" => "teste@teste.com",
                    "address" => Array(
                        "street" => "Rua Tal",
                        "number" => "700",
                        "city" => "São Paulo",
                        "state" => "SP",
                        "country" => "Brasil",
                        "zip_code" => "12122-00" //(CEP)
                    )
                )
            )
        */
        
        $resp = Iugu_Charge::create($vet);
        
        if($resp->success)
        {
            //deu certim
            $this->idRetorno = $resp->invoice_id; //pegar id  da fatura
            $this->respRetorno = $resp;
            return TRUE;
        }
        else
        {
            //errou
            $this->retErro($resp);
            return FALSE;
        }
    }
    
    //pagamento com cartão de crédito
    public function pagamentoBoleto($vet) 
    {
        /*
            Array(
                "method" = > "bank_slip",
                "email" = > "teste@teste.com",
                "items" = > Array(
                    Array(
                        "description" = > "Item Um",
                        "quantity" = > "1",
                        "price_cents" = > "1000"
                    )
                ) ,
         * se tiver o id do cliente na IUGU
        
                "customer_id" => $cliente['id_iugu'] 
         
         * se não tiver o id do cliente na IUGU
         
                "payer" = > Array(
                    "cpf_cnpj" = > "12312312312",
                    "name" = > "Item Um",
                    "phone_prefix" = > "1",
                    "phone" = > "1000",
                    "email" => "teste@teste.com",
                    "address" => Array(
                        "street" => "Rua Tal",
                        "number" => "700",
                        "city" => "São Paulo",
                        "state" => "SP",
                        "country" => "Brasil",
                        "zip_code" => "12122-00", //(CEP)
                        "complement" => "bloco 3, ap. 32"
                    )
                )
            )
        */
        
        $resp = Iugu_Charge::create($vet);
        
        if($resp->success)
        {
            //deu certim
            $this->idRetorno = $resp->invoice_id; //pegar id  da fatura
            $this->respRetorno = $resp;
            return TRUE;
        }
        else
        {
            //errou
            $this->retErro($resp);
            return FALSE;
        }
    }
    
    //removendo uma fatura
    public function cancelaFatura($idFatura) 
    {
        $invoice = Iugu_Invoice::fetch($idFatura);
        $invoice->cancel();
        return $invoice;
    }
    
    //reembolsar uma fatura
    public function reembolso($idFatura) 
    {
        $invoice = Iugu_Invoice::fetch($idFatura);
        $invoice->refund();
        return $invoice;
    }
    
    //Listar faturas
    public function listaFaturas() 
    {
        $invoices = Iugu_Invoice::search()->results();
        return $invoices;
    }
}
