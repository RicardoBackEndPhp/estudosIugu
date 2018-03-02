<?php

    require("./lib/Iugu.php"); 
    require_once './connect.php';
    require_once './Iugur.php';
    
    $dados = isset($_POST['jsonUP'])? (array) json_decode($_POST['jsonUP']):'';
    
    if(!empty($dados))
    {
        print_r($dados);
        
        $fatura = Iugur::getInstance();
        
        if(!empty($dados->tokenCartaoCredito)) //cartão de credito
        {
            $exemplo = Array(
                "token"=> $dados->tokenCartaoCredito,
                "email" => 'ti@souzanovaes.com.br',
                "items" => Array(
                    Array(
                        "description" => 'essa fatura está uma uva',
                        "quantity" => "1",
                        "price_cents" => 100000
                    )
                ),
                "customer_id" => '8AE190271F4849A0A4C9E09AA689D1EB' //id do cliente da Iugu
            );
            
            if($fatura->pagamentoCartao($exemplo))
            {
                var_dump($fatura->respRetorno);
            }
            else 
            {
                echo 'Falha ao gerar a fatura.';
            }
        }
        else
        {
            //quando o cliente já se encontra cadastrado na Iugu
            $exemplo = Array(
                "method" => "bank_slip",
                "email" => $cliente['email'],
                "items" => Array(
                    Array(
                        "description" => utf8_encode($servico['tipo']),
                        "quantity" => "1",
                        "price_cents" => $valorServico
                    )
                ),
                "customer_id" => $cliente['id_iugu'] //id de cliente da Iugu
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
                var_dump($fatura->respRetorno);
            }
            else 
            {
                echo 'Falha ao gerar a fatura.';
            }
        }
    }
    else
    {
        echo "nada";
    }