-- MySQL dump 10.13  Distrib 8.0.13, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: madeira_faq
-- ------------------------------------------------------
-- Server version	8.0.18

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
 SET NAMES utf8 ;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `questions`
--

DROP TABLE IF EXISTS `questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tags_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `title_slug` varchar(255) NOT NULL,
  `answer` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `enabled` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_questions_tags_idx` (`tags_id`),
  FULLTEXT KEY `FULLTEXT` (`title`,`answer`),
  CONSTRAINT `fk_questions_tags` FOREIGN KEY (`tags_id`) REFERENCES `tags` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questions`
--

LOCK TABLES `questions` WRITE;
/*!40000 ALTER TABLE `questions` DISABLE KEYS */;
INSERT INTO `questions` VALUES (1,1,'Como fazer a devolução ou troca de produto','como-fazer-a-devolucao-ou-troca-de-produto','Caso o produto ainda não tenha sido enviado o cancelamento será automático\nCaso o produto já tenha sido enviado é necessário que você ou a pessoa responsável pelo recebimento recuse o produto no momento da entrega pela transportadora ou pelos Correios. \n\nApós o cancelamento, a MadeiraMadeira possibilitará a você as seguintes alternativas: \n\nEscolher outro produto efetuando o pagamento da diferença ou recebendo a restituição da diferença, se houver\nUtilizar o valor da compra como crédito para a aquisição de outros produtos \nOptar pela devolução dos valores\nPara solicitar o cancelamento clique aqui  , para acessar a sua área de cliente, selecione o pedido desejado e depois a opção Atendimento ao Cliente.','2019-12-13 18:56:57','2019-12-13 18:56:57',1),(2,1,'O que fazer se o pedido chegar incompleto','o-que-fazer-se-o-pedido-chegar-incompleto','No ato da entrega: fazer uma ressalva no comprovante da transportadora e fazer a solicitação clicando aqui  , para acessar a sua área de cliente, selecione o pedido desejado e depois a opção Atendimento ao Cliente, em até 7 (sete) dias corridos a partir do recebimento. \n\nApós entrega: caso você tenha recebido o produto e não tenha feito a ressalva no comprovante da transportadora, você pode fazer a solicitação clicando aqui  , para acessar a sua área de cliente, selecione o pedido desejado e depois a opção Atendimento ao Cliente,  em até 7 (sete) dias corridos a partir do recebimento. \n\n*As solicitações estão sujeitas a aprovação de nossa equipe após análise.','2019-12-13 18:57:54','2019-12-13 18:57:54',1);
/*!40000 ALTER TABLE `questions` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-12-13 16:01:28
