<?php


use Phinx\Seed\AbstractSeed;

class InitialSeeder extends AbstractSeed
{
    public function run()
    {
        $this->execute("
            INSERT INTO madeira_faq.tags VALUES 
            (1,'Trocas e Devoluções','trocas-e-devolucoes','2019-12-13 18:55:03','2019-12-13 18:55:03',1),
            (2,'Entrega e Prazo','entrega-e-prazo','2019-12-13 18:55:37','2019-12-13 18:55:37',1);
            
            INSERT INTO madeira_faq.questions VALUES
            (1,1,'Como fazer a devolução ou troca de produto','como-fazer-a-devolucao-ou-troca-de-produto','Caso o produto ainda não tenha sido enviado o cancelamento será automático\nCaso o produto já tenha sido enviado é necessário que você ou a pessoa responsável pelo recebimento recuse o produto no momento da entrega pela transportadora ou pelos Correios. \n\nApós o cancelamento, a MadeiraMadeira possibilitará a você as seguintes alternativas: \n\nEscolher outro produto efetuando o pagamento da diferença ou recebendo a restituição da diferença, se houver\nUtilizar o valor da compra como crédito para a aquisição de outros produtos \nOptar pela devolução dos valores\nPara solicitar o cancelamento clique aqui  , para acessar a sua área de cliente, selecione o pedido desejado e depois a opção Atendimento ao Cliente.','2019-12-13 18:56:57','2019-12-13 18:56:57',1),
            (2,1,'O que fazer se o pedido chegar incompleto','o-que-fazer-se-o-pedido-chegar-incompleto','No ato da entrega: fazer uma ressalva no comprovante da transportadora e fazer a solicitação clicando aqui  , para acessar a sua área de cliente, selecione o pedido desejado e depois a opção Atendimento ao Cliente, em até 7 (sete) dias corridos a partir do recebimento. \n\nApós entrega: caso você tenha recebido o produto e não tenha feito a ressalva no comprovante da transportadora, você pode fazer a solicitação clicando aqui  , para acessar a sua área de cliente, selecione o pedido desejado e depois a opção Atendimento ao Cliente,  em até 7 (sete) dias corridos a partir do recebimento. \n\n*As solicitações estão sujeitas a aprovação de nossa equipe após análise.','2019-12-13 18:57:54','2019-12-13 18:57:54',1);
        ");
    }
}
