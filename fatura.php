<?php

    require("./lib/Iugu.php"); 
    require_once './connect.php';
    require_once './Iugur.php';
    
    $dados = isset($_POST['jsonUP'])? json_decode($_POST['jsonUP']):'';
    
    print_r($dados);
    

    if(!empty($dados) && is_object($dados))
    {
        //print_r($dados);
        
        $fatura = Iugur::getInstance();
        
        if(!empty($dados->tokenCartaoCredito)) //cartão de credito
        {
            $exemplo = Array(
                "token"=> $dados->tokenCartaoCredito,
                "email" => 'malandrodeborest@gmail.com', //E-mail do cliente
                //"months" => 6, //(opcional) Número de Parcelas (2 até 12), não é necessário passar 1
                "discount_cents" => 1000, //(opcional) Valor dos Descontos em centavos.
                "items" => Array(
                    Array(
                        "description" => 'Certidão de casamento', //Descrição do Item
                        "quantity" => "1", //	Quantidade
                        "price_cents" => 25500, //Preço em Centavos. Valores negativos entram como desconto no total
                    ),
                    Array(
                        "description" => 'Apostilamento de Haia', //Descrição do Item
                        "quantity" => "1", //	Quantidade
                        "price_cents" => 20500, //Preço em Centavos. Valores negativos entram como desconto no total
                    )
                ),
                "customer_id" => $dados->chaveClienteIugu //'544F65FCFAE4482BA15946FF3E282EB9' //id do cliente da Iugu
            );
            
            if($fatura->pagamentoCartao($exemplo))
            {
                echo "Fatura {$fatura->idRetorno} criada com sucesso!<hr/><pre>";
                print_r($fatura->respRetorno);
                echo '</pre>';
            }
            else 
            {
                echo 'Falha ao gerar a fatura do cartão.<br/>'.$fatura->msgErro;
            }
        }
        else //Boleto
        {
            //quando o cliente já se encontra cadastrado na Iugu
            $exemplo = Array(
                "method" => "bank_slip", //método de pagamento com boleto direto
                "email" => 'malandrodeborest@gmail.com',  //E-mail do cliente
                "discount_cents  " => 1000, //(opcional) Valor dos Descontos em centavos.
                "bank_slip_extra_days   " => 15, //(opcional) Define o prazo em dias para o pagamento do boleto. Caso não seja enviado, aplica-se o prazo padrão de 3 dias.
                "items" => Array(
                    Array(
                        "description" => 'Certidão de nascimento',
                        "quantity" => "1",
                        "price_cents" => 28000
                    )
                ),
                "customer_id" => $dados->chaveClienteIugu //'544F65FCFAE4482BA15946FF3E282EB9' //id de cliente da Iugu Renan
            );
            
            //fatura simples da iugu
//            $exemplo = Array(
//                "email" => $cliente['email'],
//                "due_date" => $prazo,
//                "items" => Array(
//                    Array(
//                        "description" => utf8_encode($servico['tipo']),
//                        "quantity" => "1",
//                        "price_cents" => $valorServico
//                    )
//                ),
//                "customer_id" => $cliente['id_iugu']
//            );
            
            if($fatura->pagamentoBoleto($exemplo))
            {
                echo "Fatura {$fatura->idRetorno} criada com sucesso!<hr/><h5>clique no botão para acessar seu boleto: <button><a href='{$fatura->respRetorno->url}' target='_blank'>Clique aqui</a></button></h5><pre>";
                print_r($fatura->respRetorno);
                echo '</pre>';
            }
            else 
            {
                echo 'Falha ao gerar a fatura.<br/>'.$fatura->msgErro;
            }
        }
    }
    else
    {
        echo "nada";
    }