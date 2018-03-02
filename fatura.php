<?php

    require("./lib/Iugu.php"); 
    require_once './connect.php';
    require_once './Iugur.php';
    
    $dados = isset($_POST['jsonUP'])? (array) json_decode($_POST['jsonUP']):'';
    
    if(!empty($dados))
    {
        //print_r($dados);
        
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
                        "price_cents" => 15500
                    )
                ),
                "customer_id" => '544F65FCFAE4482BA15946FF3E282EB9' //id do cliente da Iugu
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
        else
        {
            //quando o cliente já se encontra cadastrado na Iugu
            $exemplo = Array(
                "method" => "bank_slip",
                "email" => 'ti@souzanovaes.com.br',
                "items" => Array(
                    Array(
                        "description" => 'essa fatura está uma uva',
                        "quantity" => "2",
                        "price_cents" => 28000
                    )
                ),
                "customer_id" => '544F65FCFAE4482BA15946FF3E282EB9' //id de cliente da Iugu
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