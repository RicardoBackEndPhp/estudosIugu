
<?php 
    require("./lib/Iugu.php"); 
    require_once './connect.php';
    require_once './Iugur.php';
    
    //setando o ApiKey do qual pega na plataforma da iugu
    Iugu::setApiKey("e13a52d09b9130be7f47819b2df54b8d");
    
        if(isset($_POST['criar_cliente']) && !empty($_POST['criar_cliente']))
        {            
            //criando o cliente lá na iugu
            $vetCli = array(
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
            
            $retorno = Iugur::getInstance();
            
            if($retorno->criaCliente($vetCli))
            {
                echo "Criado com sucesso! ID: ".$retorno->idRetorno;
                
                echo "<pre>";
                print_r($retorno->respRetorno);
                echo "</pre>";

                $vetDados = $_POST;
                $vetDados['id_iugu'] = $retorno->idRetorno;

                //colocando os dados do cliente em nosso banco de dados e também salvando o idiugu
                $criar = Connect::getInstance();
                if($criar->salvaClienteIugu($vetDados))
                {
                    echo "<h1>Cliente cadastrado e nois</h1>";
                }
            }
            else
            {
                echo "<h4>Falha no cadastro: </h4>";
                echo $retorno->msgErro;
            }
        }
        
        
        //teste
        $customers = Iugur::getInstance();
        $idIugur = '69595E841715422599DFA9EE7CEF0144';
        $cliente = $customers->buscaCliente($idIugur,1);
        
        echo '<pre>';
        print_r($cliente);
        echo '</pre><hr/>';
        

        //////////////////////////////////////////////////
        //Puxando dados do cliente e editando
        //////////////////////////////////////////////////
        
        //puxando todos os clientes da conta ApiKey lá no iugu
//        $customers = Iugur::getInstance();
//
//        $idIugur = '69595E841715422599DFA9EE7CEF0144';
//        $cliente = $customers->buscaCliente($idIugur,1);
//        
//        echo '<pre>';
//        print_r($cliente);
//        echo '</pre><hr/>';
//        
//        $vetteste = array(
//            'name'=>'Rogerinho do Ínga',
//            'email'=>'malandrodeborest@gmail.com',
//            'cpf_cnpj'=>'81866168371'
//        );
//        
//        
//        if($customers->alteraCliente($idIugur, $vetteste))
//        {
//            echo "<h5>Cliente alterado com sucesso!</h5>";
//            $muda = $customers->buscaCliente($idIugur,1);
//            echo '<pre>';
//            print_r($muda);
//            echo '</pre><hr/>';
//        }
//        else
//        {
//            echo "<h5>Falha ao editar dados do cliente</h5>";
//            
//            echo $customers->msgErro;
//        }        

?>

<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="https://js.iugu.com/v2"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/formatter.js/0.1.5/formatter.min.js"></script>

<!-- Configuração IUGU -->
<!-- Aqui eu seto o ID account que pega na plataforma da IUGU -->
<script type="text/javascript">
	Iugu.setAccountID("EAD81E94E0F747E1B968F709BC73064B");
	Iugu.setTestMode(true);
</script>

 	<h2>Criação de cliente</h2>

	<br>
	<form method="POST" action="">
		<span>dados inicial</span><br>
		<input type="email" name="email_cria_cliente"><label>Email</label><br>
		<input type="text" name="nome_cria_cliente"><label>Nome</label><br>
		<input type="text" name="cpfcnpj_cria_cliente"><label>CPF/CNPJ</label><br>
		<br>
		<span>endereço</span><br>
		<input type="text" name="cep_cria_cliente"><label>CEP</label><br>
		<input type="text" name="cidade_cria_cliente"><label>Cidade</label><br>
		<input type="text" name="uf_cria_cliente"><label>UF</label><br>
		<input type="text" name="rua_cria_cliente"><label>Rua</label><br>
		<input type="text" name="numero_cria_cliente"><label>Número</label><br>
		<input type="text" name="bairro_cria_cliente"><label>Bairro</label><br>
		<input type="text" name="complemento_cria_cliente"><label>Complemento</label><br>
		<input type="submit" name="criar_cliente" value="Criar Cliente">
	</form>
 