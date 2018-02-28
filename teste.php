

<script type="text/javascript" src="https://js.iugu.com/v2"></script>

<script>
    Iugu.setAccountID("e13a52d09b9130be7f47819b2df54b8d"); //acessando plataforma iugu
    Iugu.setTestMode(true); //ativando modo de teste
    Iugu.setup();
    
    //validando número do cartão de ccrretito
    //Iugu.utils.validateCreditCardNumber("4111111111111111"); // Retorna true
    
    //validando némro de segurança
    //Iugu.utils.validateCVV("123", "visa"); // Retorna true
    //Iugu.utils.validateCVV("1234", "amex"); // Retorna true
    //Iugu.utils.validateCVV("3213", "mastercard"); // Retorna false
    
    //criando um objeto de acrtão de crédito
    cc = Iugu.CreditCard("4111111111111111", 
                     "12", "2017", "Nome", 
                     "Sobrenome", "123");
                     
    Iugu.createPaymentToken(cc, function(response) {
    if (response.errors) {
            alert("Erro salvando cartão");
    } else {
            alert("Token criado:" + response.id);
    }	
});
                     
</script>



<hr/>
<?php

require './lib/Iugu.php';


echo '<h1> teste com a IUGU </h1>';

echo Iugu::setApiKey("e13a52d09b9130be7f47819b2df54b8d"); // Ache sua chave API no Painel

Iugu_Charge::create(
    [
        "token"=> "TOKEN QUE VEIO DO IUGU.JS OU CRIADO VIA BIBLIOTECA",
        "email"=>"your@email.test",
        "items" => [
            [
                "description"=>"Item Teste",
                "quantity"=>"1",
                "price_cents"=>"1000"
            ]
        ]
    ]
);