emitirNFE

###INSTALANDO O nfephp

Primeiramente instale o composer pelo site https://getcomposer.org/. 

Eu instalei o cmder que é um emulador de terminal um pouco mais conveniente de se trabalhar no windows. 

Pelo cmder use composer :

composer require nfephp-org/nfephp na pasta onde deseja instalar.
![All text](https://github.com/jhonatanvpi/projetoNfe/blob/master/images/1.PNG)

Agora na pasta vendor você terá o pacote instalado. 

Vá na pasta do nfe e use "composer update"

![All text](https://github.com/jhonatanvpi/projetoNfe/blob/master/images/2.PNG)

Crie as pastas 

C:\server\htdocs\vpigestao\fwk\uploadNFE\homologacao\entradas
C:\server\htdocs\vpigestao\fwk\uploadCTE\homologacao\entradas

Agora você pode acessar no servidor a pasta install do nfephp
Em meu caso : 

http://localhost/vpigestao/fwk/nfe/vendor/nfephp-org/nfephp/install/

![All text](https://github.com/jhonatanvpi/projetoNfe/blob/master/images/3.PNG)
![All text](https://github.com/jhonatanvpi/projetoNfe/blob/master/images/4.PNG)


##Após a configuração do arquivo .json

###1 - Criar XML 

Use o arquivo para criar sua XML

http://localhost/vpigestao/fwk/nfe/vendor/nfephp-org/nfephp/exemplos/NFe/4.00testaMakeNFe.php

Arrume o caminho para a pasta onde será salvo , essa variável se encontra no final do código

$filename = "C:\\server\\htdocs\\vpigestao\\fwk\\uploadNFE\\homologacao\\entradas\\nfe.xml";
Altere os dados como cUF = "52" por cUF = "42" assim por diante. Arrumar dados do emitente e destinatário


###2 - Assinar XML 
Vamos usar o código

http://localhost/vpigestao/fwk/nfe/vendor/nfephp-org/nfephp/exemplos/NFe/4.00testaAssinaNFe.php

Vai ser gerada uma chave, essa chave será o nome do XML gerado da nota fiscal, nesse caso se encontra em C:\server\htdocs\vpigestao\fwk\uploadNFE\homologacao\entradas


Troque o valor da variável $chave e $filename

$filename = "C:\\server\\htdocs\\vpigestao\\fwk\\uploadNFE\\homologacao\\entradas\\{$chave}-nfe.xml";

Depois temos outra variável que vai ter o XML assinado, também deve ser trocado o nome dessa variável, você deve criar o diretório homologacao\assinadas

$filename = "C:\\server\\htdocs\\vpigestao\\fwk\\uploadNFE\\homologacao\\assinadas\\{$chave}-nfe.xml";




###3 - Validar XML 
Agora precisamos validar o XML, vamos usar o código 
http://localhost/vpigestao/fwk/nfe/vendor/nfephp-org/nfephp/exemplos/NFe/4.00

Erro atual : 

Fatal error: Uncaught exception 'NFePHP\Common\Exception\RuntimeException' with message 'NÃ£o houve retorno do Curl. error:14094418:SSL routines:SSL3_READ_BYTES:tlsv1 alert unknown ca' in C:\server\htdocs\vpigestao\fwk\nfe\vendor\nfephp-org\nfephp\libs\Common\Soap\CurlSoap.php:197 Stack trace: #0 C:\server\htdocs\vpigestao\fwk\nfe\vendor\nfephp-org\nfephp\libs\NFe\ToolsNFe.php(892): NFePHP\Common\Soap\CurlSoap->send('https://homolog...', 'http://www.port...', '<nfeCabecMsg xm...', '<nfeDadosMsg xm...', 'nfeConsulta2') #1 C:\server\htdocs\vpigestao\fwk\nfe\vendor\nfephp-org\nfephp\libs\NFe\ToolsNFe.php(536): NFePHP\NFe\ToolsNFe->sefazConsultaChave('521708766142540...', '2', Array) #2 C:\server\htdocs\vpigestao\fwk\nfe\vendor\nfephp-org\nfephp\exemplos\NFe\4.00testaValidaNFe.php(17): NFePHP\NFe\ToolsNFe->verificaValidade('C:\server\htdoc...', Array) #3 {main} thrown in C:\server\htdocs\vpigestao\fwk\nfe\vendor\nfephp-org\nfephp\libs\Common\Soap\CurlSoap.php on line 197

Possíveis erros : 

"""SEFAZ GO está exigindo que o certificado contenha a cadeia completa de certificação do seu certificado."""

Possível solução, testando conexão com webservice da SEFAZ, 
Caso você esteja utilizando o cmder você pode fazer uso do curl 

Vá na pasta dos certificados no meu caso C:\server\htdocs\vpigestao\fwk\nfe\vendor\nfephp-org\nfephp\certs

e use o comando 

curl -k -v -4 --cert "PASSE O NOME DO CERTIFICADO AQUI, GERALMENTE TEM FORMATO NÚMERO_certKey.pem"  --key "PASSE A CHAVE AQUI, GERALMENTE TEM FORMATO NÚMERO_privKEY.pem" 
 https://homologacao.nfe.fazenda.sp.gov.br/ws/nfestatusservico2.asmx?WSDL

Não resolvido.

Outra opção que não resolveu, forçar o protocolo de comunicação

use NFePHP\Common\Base\BaseTools;
$tools = new BaseTools('../../config/config.json');
$tools->setSSLProtocol('TLSv1.0');



Achei um erro ==> Em alguma parte do nfephp a UF está setada como GO, então uma solução temporária é forçar o uso de "SC"
Se você está usando o NetBeans, aperta ctr+botão-mouse na função "verificaValidade", depois em "sefazConsultaChave" e então na parte do código 
$cUF = substr($chNFe, 0, 2);
$cUF = "42";

Achei um possível erro, voltando para a criação da NFE




Validar XML  
Novo erro arrumando as configurações do XML na parte de criação do XML 
Elemento 'CEST': [Erro 'Layout'] O valor '2345' nÃ£o Ã© aceito para o padrÃ£o. '[0-9]{7}'. Elemento 'CEST': '2345' nÃ£o Ã© um valor vÃ¡lido. Elemento 'CEST': [Erro 'Layout'] O valor '9999' nÃ£o Ã© aceito para o padrÃ£o. '[0-9]{7}'. Elemento 'CEST': '9999' nÃ£o Ã© um valor vÃ¡lido. 

A fins de teste comentei a variável 
//$nfe->tagCEST(1, ...);


4 - Enviar Lote NFE para Sefaz 
Link: https://github.com/nfephp-org/nfephp/blob/master/libs/NFe/ToolsNFe.php


5 - Buscar o resultado da análise 
Link: https://github.com/nfephp-org/nfephp/blob/master/libs/NFe/ToolsNFe.php


6 - Caso aprovado adicionar protocolo de autorização 
Link: https://github.com/nfephp-org/nfephp/blob/master/libs/NFe/ToolsNFe.php


7 - Imprimir DANFE
Link: https://github.com/nfephp-org/nfephp/blob/master/libs/Extras/Danfe.php


Link do Projeto no github - criptografado
Link: https://github.com/jhonatanvpi/projetoNfe

