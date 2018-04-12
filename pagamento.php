
<style>
    /* Non Credit Card Form */
body,html { padding:0px;margin:0px; }
body { padding: 40px;font-family: Arial;font-size: 14px; background: #FFF }

/* Credit Card Form */
.usable-creditcard-form, .usable-creditcard-form * {
    font-size: 13px;
}
.usable-creditcard-form {
    position: relative;
    padding: 0px;
    width: 300px;
    margin-left: auto;
    margin-right: auto;
}
.usable-creditcard-form .wrapper {
    border: 1px solid #CCC;
    border-top: 1px solid #AAA;
    border-right: 1px solid #AAA;
    height: 74px;
    width: 300px;
    position: relative;
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    border-radius: 5px;
}
.usable-creditcard-form .input-group {
    position: absolute;
    top: 300px;
}
.usable-creditcard-form .input-group.nmb_a {
    position: absolute;
    width: 200px;
    top: 0px;
    left: 0px;
}
.usable-creditcard-form .input-group.nmb_b {
    position: absolute;
    width: 100px;
    top: 0px;
    right: 0px;
}
.usable-creditcard-form .input-group.nmb_b input,
.usable-creditcard-form .input-group.nmb_d input {
    text-align: center;
}
.usable-creditcard-form .input-group.nmb_c {
    position: absolute;
    width: 200px;
    top: 37px;
    left: 0px;
}
.usable-creditcard-form .input-group.nmb_d {
    position: absolute;
    width: 100px;
    top: 37px;
    right: 0px;
}
.usable-creditcard-form input {
    background: none;
    display: block;
    width: 100%;
    padding: 10px;
    -moz-box-sizing: border-box;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    margin:0px;
    padding-left: 35px;
    border: none;
}
.usable-creditcard-form .input-group .icon {
    position: absolute;
    width: 22px;
    height: 22px;
    background: #CCC;
    left: 8px;
    top: 7px;
}
.usable-creditcard-form .input-group.nmb_a input {
    border-right: 1px solid #ECECEC;
}
.usable-creditcard-form .input-group.nmb_c input {
    border-top: 1px solid #ECECEC;
    border-right: 1px solid #ECECEC;
}

.usable-creditcard-form input::-webkit-input-placeholder {
    font-size: 12px;
    text-transform: none;
}
.usable-creditcard-form .input-group.nmb_d input {
    border-top: 1px solid #ECECEC;
}

.usable-creditcard-form .input-group.nmb_c input {
    text-transform: uppercase;
}
.usable-creditcard-form .accept {
    color: #999;
    font-size: 11px;
    margin-bottom: 5px;
}
.usable-creditcard-form .footer {
    margin-top: 3px;
    position: relative;
    margin-left: 5px;
    margin-right: 5px;
}
.usable-creditcard-form .footer img {
    padding: 0px;
    margin: 0px;
}
.usable-creditcard-form .iugu-btn {
    position: absolute;
    top: 0px;
    right: 0px;
}

/* Do not forget to store your images in a secure server */
.usable-creditcard-form .input-group .icon.ccic-name {
    background: url("http://storage.pupui.com.br/9CA0F40E971643D1B7C8DE46BBC18396/assets/ccic-name.1cafa1882fdd56f8425de54a5a5bbd1e.png") no-repeat;
}
.usable-creditcard-form .input-group .icon.ccic-exp {
    background: url("http://storage.pupui.com.br/9CA0F40E971643D1B7C8DE46BBC18396/assets/ccic-exp.05e708b1489d5e00c871f20ba33bbff3.png") no-repeat;
}
.usable-creditcard-form .input-group .icon.ccic-brand {
    background: url("http://storage.pupui.com.br/9CA0F40E971643D1B7C8DE46BBC18396/assets/ccic-brands.48dba03883007f86e118f683dcfc4297.png") no-repeat;
}
.usable-creditcard-form .input-group .icon.ccic-cvv { background: url("http://storage.pupui.com.br/9CA0F40E971643D1B7C8DE46BBC18396/assets/ccic-cvv.1fe78dcc390427094bdc14dedea10f34.png") no-repeat; }

.usable-creditcard-form .input-group .icon.ccic-cvv,
.usable-creditcard-form .input-group .icon.ccic-brand
{
    -webkit-transition:background-position .2s ease-in;
    -moz-transition:background-position .2s ease-in;
    -o-transition:background-position .2s ease-in;
    transition:background-position .2s ease-in;
}

.amex .usable-creditcard-form .input-group .icon.ccic-cvv {
    background-position: 0px -22px;
}

.amex .usable-creditcard-form .input-group .icon.ccic-brand {
    background-position: 0px -110px;
}

.visa .usable-creditcard-form .input-group .icon.ccic-brand {
    background-position: 0px -22px;
}

.diners .usable-creditcard-form .input-group .icon.ccic-brand {
    background-position: 0px -88px;
}

.mastercard .usable-creditcard-form .input-group .icon.ccic-brand {
    background-position: 0px -66px;
}

/* Non Credit Card Form - Token Area */
.token-area {
    margin-top: 20px;
    margin-bottom: 20px;
    border: 1px dotted #CCC;
    display: block;
    padding: 20px;
    background: #EFEFEF;
}
</style>

<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="https://js.iugu.com/v2"></script>
<script type="text/javascript" src="iugu.js"></script>

<script>
    Iugu.setAccountID("EAD81E94E0F747E1B968F709BC73064B"); //acessando plataforma iugu
    Iugu.setTestMode(true); //ativando modo de teste
    //Iugu.setup();
    
    
    jQuery(function($) 
    {
        
        //Submit do formulário
        //Aqui começa a parte de Pagamento, assim que o usuário preenche os dados e clica no botão
        $('#payment-form').submit(function(evt) {
            
            //trava a atualização da página, no caso não redireciona para  a "action"
            evt.preventDefault();
            
            //dados do usuário
            
            //recebendo e "explodindo" o valor de data do cartão, para separar mês e ano
            var expir = $("#cart_data").val().split("/");                   
            sessionStorage.cartao_mes = expir[0]; //"10";
            sessionStorage.cartao_ano = expir[1]; //"2018";
            
            
            //setando campos do cartão para gerar o token
            sessionStorage.cartao_num = $("#cart_numero").val();   //"4111111111111111";
            sessionStorage.cartao_cvv = $("#cart_cvv").val(); //"411";
            
            //função que recebe o nome completo, separa nome de sobrenome
            // e já insere na sessionStorage
            SeparaNS($("#cart_nome").val());
            
            //setando a session manualmente
            //sessionStorage.tipoPagamento = "Cartão";
            //sessionStorage.tipoPagamento = "Boleto";
            
            if($("input[name='cart_tipo']:checked").val() == 1)
            {
                sessionStorage.tipoPagamento = "Boleto";
            }
            else
            {
                sessionStorage.tipoPagamento = "Cartão";
            }
            
            //id de cliente da IUGU, caso o usuário já esteja cadastrado
            var chaveClienteIugu = $("#cart_cliente").val();
            
            var idCliente;
            var nomeCliente;
            
            //Gambiarra para pegar o id (banco de dados interno) e nome do usuário no select
            $( "#cart_cliente option:selected" ).each(function() {
                idCliente = $( this ).attr('data-identificador');
                nomeCliente = $( this ).text();
            });
            
            //salvando os dados na sessionStorage
            sessionStorage.chaveClienteIugu = chaveClienteIugu;   //Id do cliente na iugu
            sessionStorage.idCliente        = idCliente;         // id do cliente no meu sistema
            sessionStorage.nomeCliente      = nomeCliente;      // nome do cliente no meu sistema
            
            //console.log("Chave: "+chaveClienteIugu+" Id: "+idCliente+" Nome: "+nomeCliente); //teste
            
            //função que confere os dados da session
            //gera o token
            //e manda os dados para o arquivo "fatura.php" via ajax (POST)
            getTokenCreditCard();
            
        });
    });
    
    
    //validando número do cartão de ccrretito
    //Iugu.utils.validateCreditCardNumber("4111111111111111"); // Retorna true
    
    //validando número de segurança
    //Iugu.utils.validateCVV("123", "visa"); // Retorna true
    //Iugu.utils.validateCVV("1234", "amex"); // Retorna true
    //Iugu.utils.validateCVV("3213", "mastercard"); // Retorna false
    
    //criando um objeto de cartão de crédito
//    cc = Iugu.CreditCard("4111111111111111", 
//                     "12", "2017", "Nome", 
//                     "Sobrenome", "123");
//                     
//    Iugu.createPaymentToken(cc, function(response) {
//        if (response.errors) {
//                alert("Erro salvando cartão");
//        } else {
//                alert("Token criado:" + response.id);
//        }	
//    });
                     
</script>

<hr/>

<?php 
    require_once './connect.php';
    
    $sel = Connect::getInstance();
            
    $select = $sel->dadosCliente('all', 1);
?>

<form id="payment-form" target="_blank" action="https://<-- seu servico -->" method="POST">
    
    <label>Serviço: </label>
        <input type="radio" class="cart_tipo" name="cart_tipo" id="bol" value="1"><label for="bol">Boleto</label>
        <input type="radio" class="cart_tipo" name="cart_tipo" id="cc" value="2" checked=""><label for="cc">Cartão de Crédito</label>
    <br><br>
    <select id="cart_cliente" name="cart_cliente">
        <?php 
            echo $select;
        ?>
    </select>
    <br/><br/>
    <div class="usable-creditcard-form">            
        <div class="wrapper">
            <div class="input-group nmb_a">
                <div class="icon ccic-brand"></div>
                <input autocomplete="off" class="credit_card_number" name="cart_numero" id="cart_numero" data-iugu="number" placeholder="Número do Cartão" type="text" value="" />
            </div>
            <div class="input-group nmb_b">
                <div class="icon ccic-cvv"></div>
                <input autocomplete="off" class="credit_card_cvv" name="cart_cvv" id="cart_cvv" data-iugu="verification_value" placeholder="CVV" type="text" value="" />
            </div>
            <div class="input-group nmb_c">
                <div class="icon ccic-name"></div>
                <input class="credit_card_name" data-iugu="full_name" name="cart_nome" id="cart_nome" placeholder="Titular do Cartão" type="text" value="" />
            </div>
            <div class="input-group nmb_d">
                <div class="icon ccic-exp"></div>
                <input autocomplete="off" class="credit_card_expiration" name="cart_data" id="cart_data" data-iugu="expiration" placeholder="MM/AA" type="text" value="" />
            </div>
        </div>
        <div class="footer">
            <img src="http://storage.pupui.com.br/9CA0F40E971643D1B7C8DE46BBC18396/assets/cc-icons.e8f4c6b4db3cc0869fa93ad535acbfe7.png" alt="Visa, Master, Diners. Amex" border="0" />
            <a class="iugu-btn" href="http://iugu.com" tabindex="-1"><img src="http://storage.pupui.com.br/9CA0F40E971643D1B7C8DE46BBC18396/assets/payments-by-iugu.1df7caaf6958f1b5774579fa807b5e7f.png" alt="Pagamentos por Iugu" border="0" /></a>
        </div>
    </div>

    <div class="token-area">
        <label for="token">Token do Cartão de Crédito - Enviar para seu Servidor</label>
        <input type="text" name="token" id="token" value="" readonly="" size="64" style="text-align:center" />
    </div>
       
    <div>
        <button type="submit">Salvar</button>
    </div>
            
  </form>

<div id="respay"></div>