/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//separa nome de sobrenome
function SeparaNS(nomeCompleto) 
{
    var valor     = nomeCompleto.split(" ");
    var nome      = valor.shift();
    var sobrenome = valor.join(" ");

    //alert("O nome é : " + nome);
    //alert("O sobrenome é : " + sobrenome);
    
    sessionStorage.cartao_nome = nome;
    sessionStorage.cartao_sobrenome = sobrenome;
}


//Ajax que manda informações para criação de fatura
function ajaxEnviaPost()
{
    console.log(sessionStorage);

    //transformando o sessionStorage em string formato json
    var queryString = JSON.stringify(sessionStorage);

    console.log(queryString);

    //AJAX enviando a string formato json
    $.post('fatura.php', {jsonUP: queryString}, function(data, textStatus, xhr){

        if (xhr.status == 200) 
        {
            console.log(data);
            //var obj = JSON.parse(data);
            
            $("#respay").html(data);
        } 
        else
        {
            $.confirm({
                title: 'Falha ao consultar!',
                content: 'Ocorreu um erro interno no servidor',
                type: 'red',
                typeAnimated: true,
                buttons: {
                    tryAgain: {
                        text: 'OK',
                        btnClass: 'btn-red',
                        action: function(){
                        }
                    }
                }
            });
        }   

    });
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
            cc = Iugu.CreditCard(
                sessionStorage.cartao_num, 
                sessionStorage.cartao_mes, 
                sessionStorage.cartao_ano, 
                sessionStorage.cartao_nome, 
                sessionStorage.cartao_sobrenome, 
                sessionStorage.cartao_cvv
            );

            //se não existir o token do cartão na sessionstorage
            if(!sessionStorage.tokenCartaoCredito)
            {
                //função iugu para criar o token
                Iugu.createPaymentToken(cc, function(response) {
                    if (response.errors) {
                        //tratando o erro recebido
                        var errou = erroTokenCc(response.errors);
                        console.log(errou);
                        $("#respay").html(errou);
                    } 
                    else {
                        //salvando o token
                        sessionStorage.tokenCartaoCredito = response.id;
                        
                        //se existir este token, então manda ajax
                        if (sessionStorage.tokenCartaoCredito)
                        {
                            console.log('token gerado');
                            $("#token").val( sessionStorage.tokenCartaoCredito );
                            ajaxEnviaPost();
                        }
                    }   
                });
            }
        }
        else if(sessionStorage.tipoPagamento == "Boleto")
        {
            //se for pelo boleto bancário não é preciso o token
            sessionStorage.removeItem('tokenCartaoCredito');
            console.log('Boleto');
            $("#token").val( 'Boleto' );
            ajaxEnviaPost();
        }
        else
        {
            alert('Falha ao consultar! Tipo de pagamento não identificado');
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

//método para mostrar de maneira decente o erro da Api da Iugu
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
    
    var resp = "<ul>";
    
    Object.keys(obj).forEach(function(key) {
        resp += "<li>"+person[key]+"</li>";
    });
    resp += "</ul>";
    
    return resp;
}


/////////////////////////////////////////////////////////
//    Gestão e modificações das faturas
/////////////////////////////////////////////////////////

function cancelaFatura(id)
{
    
}

function reembolsaFatura(id)
{
    
}

function listaFatura()
{
    
}

