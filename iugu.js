/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function ajaxEnviaPost()
{
    console.log(sessionStorage);

    //transformando o sessionStorage em string formato json
    var queryString = JSON.stringify(sessionStorage);

    console.log(queryString);

    //AJAX enviando a string formato json
//    $.post('solicitacaoPagamento', {jsonUP: queryString}, function(data, textStatus, xhr){
//
//        if (xhr.status == 200) 
//        {
//            //var obj = JSON.parse(data);
//            console.log(data);
//        } 
//        else
//        {
//            $.confirm({
//                title: 'Falha ao consultar!',
//                content: 'Ocorreu um erro interno no servidor',
//                type: 'red',
//                typeAnimated: true,
//                buttons: {
//                    tryAgain: {
//                        text: 'OK',
//                        btnClass: 'btn-red',
//                        action: function(){
//                        }
//                    }
//                }
//            });
//        }   
//
//    });
}

//função para pegar o token do cartão de crédito e salva no sessionStorage
function getTokenCreditCard()
{
    if(sessionStorage.length > 0)
    {
        //caso o pagamento escolhido for cartão, preciso gerar o Token
        if(sessionStorage.tipoPagamento == "Cartão")
        {
            //passar os dados do cartão de crédito aqui
            //seguindo a ordem de parâmetros
            //1 [number] = numero do cartao sem espaço
            //2 [expiration] = mês de vencimento (Ex: 05)
            //3 [expiration] = ano de vencimento (Ex: 2021)
            //4 [first_name] = nome do titular
            //5 [last_name] = sobrenome do titular
            //6 [verification_value] = código do cartão CVV (Ex: 372)
            cc = Iugu.CreditCard("4111111111111111", 
                             "10", "2018", "Nome", 
                             "Sobrenome", "45");

            //se não existir o token do cartão na sessionstorage
            if(!sessionStorage.tokenCartaoCredito)
            {
                //função iugu para criar o token
                Iugu.createPaymentToken(cc, function(response) {
                    if (response.errors) {
                        //tratando o erro recebido
                        var errou = erroTokenCc(response.errors);
                        alert(errou);
                    } else {
                        //alert("Token criado:" + response.id);
                        //$("#token").val(response.id);
                        //salvando o token
                        sessionStorage.tokenCartaoCredito = response.id;
                        //console.log(response.id);
                        //se existir este token, então manda ajax
                        if (sessionStorage.tokenCartaoCredito)
                        {
                            //ajaxEnviaPost();
                            console.log('token gerado');
                            $("#token").val( sessionStorage.tokenCartaoCredito );
                        }
                    }   
                });
            }
        }
        else
        {
            //se for pelo boleto bancário não é preciso o token
            //ajaxEnviaPost();
            sessionStorage.removeItem('tokenCartaoCredito');
            console.log('Boleto');
            $("#token").val( 'Boleto' );
        }
    }
    else
    {
        alert('Falha ao consultar!');
//        $.confirm({
//            title: 'Falha ao consultar!',
//            content: 'Ocorreu um erro interno no servidor',
//            type: 'red',
//            typeAnimated: true,
//            buttons: {
//                tryAgain: {
//                    text: 'OK',
//                    btnClass: 'btn-red',
//                    action: function(){
//                    }
//                }
//            }
//        });
    }
}

function erroTokenCc(obj)
{
     //1 [number] = numero do cartao sem espaço
    //2 [expiration] = mês de vencimento (Ex: 05)
    //3 [expiration] = ano de vencimento (Ex: 2021)
    //4 [first_name] = nome do titular
    //5 [last_name] = sobrenome do titular
    //6 [verification_value] = código do cartão CVV (Ex: 372)
    //criando objeto de erros
    var person = {
        number:"Número de cartão inválido", 
        expiration:"Cartão expirado, data vencida", 
        first_name:"Nome do propritário do cartão não foi encontrado", 
        last_name:"Sobrenome do propritário do cartão não foi encontrado", 
        verification_value:"Número de segurança inválido"
    };
    
    var chave;
    
    Object.keys(obj).forEach(function(key) {
        chave = key;
    });
    
    return person[chave];
}