# emitirNFE

## INSTALANDO O nfephp

Primeiramente instale o composer pelo site https://getcomposer.org/. Eu instalei o cmder que é um emulador de terminal um pouco mais conveniente de se trabalhar no windows. 

Pelo cmder use composer 

![All text](https://github.com/jhonatanvpi/projetoNfe/blob/master/images/1.PNG)

Vá na pasta do nfe conforme o caminho na imagem e use "composer update"

![All text](https://github.com/jhonatanvpi/projetoNfe/blob/master/images/2.PNG)

Agora você pode acessar no servidor a pasta install do nfephp
Em meu caso : 
http://localhost/vpigestao/fwk/nfe/vendor/nfephp-org/nfephp/install/

Crie as pastas 

C:\server\htdocs\vpigestao\fwk\uploadNFE\homologacao\entradas
C:\server\htdocs\vpigestao\fwk\uploadNFE\homologacao\assinadas

C:\server\htdocs\vpigestao\fwk\uploadCTE\homologacao\entradas

![All text](https://github.com/jhonatanvpi/projetoNfe/blob/master/images/3.PNG)

![All text](https://github.com/jhonatanvpi/projetoNfe/blob/master/images/4.PNG)


## Após a configuração do arquivo .json

### 1 - Criar XML 
#### Atenção!!! Essa é a parte mais importante do processo, preste atenção ao preencher todos os dados, caso algum dado não esteja correto, o lote não será enviado, caso os dados que tiverem no programa não estiverem na nota fiscal apague a informação e deixe a variável limpa, e.g teste=""

#### Agora começando 

Use esse arquivo para criar sua XML

http://localhost/vpigestao/fwk/nfe/vendor/nfephp-org/nfephp/exemplos/NFe/4.00testaMakeNFe.php

Arrume o caminho para a pasta onde será salvo , essa variável se encontra no final do código

$filename = "C:\\server\\htdocs\\vpigestao\\fwk\\uploadNFE\\homologacao\\entradas\\nfe.xml";
Altere os dados como cUF = "52" por cUF = "42" assim por diante. Arrumar dados do emitente e destinatário

### 2 - Assinar XML 

Vamos usar o código, certifique-se de alterar os valores da chave, que você pode ver na nota fiscal gerada e o caminho para a NFE de entrada

http://localhost/vpigestao/fwk/nfe/vendor/nfephp-org/nfephp/exemplos/NFe/4.00testaAssinaNFe.php

Vai ser gerada uma chave, essa chave será o nome do XML gerado da nota fiscal, nesse caso se encontra em C:\server\htdocs\vpigestao\fwk\uploadNFE\homologacao\entradas


Troque o valor da variável $chave e $filename

$filename = "C:\\server\\htdocs\\vpigestao\\fwk\\uploadNFE\\homologacao\\entradas\\{$chave}-nfe.xml";

Depois temos outra variável que vai ter o XML assinado, também deve ser trocado o nome dessa variável, você deve criar o diretório homologacao\assinadas

$filename = "C:\\server\\htdocs\\vpigestao\\fwk\\uploadNFE\\homologacao\\assinadas\\{$chave}-nfe.xml";


### 3 - Validar XML 

Agora precisamos validar o XML, vamos usar o código 

http://localhost/vpigestao/fwk/nfe/vendor/nfephp-org/nfephp/exemplos/NFe/4.00

Erro : Undefined $nfeTools, substitua por $nfe

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

Novo erro arrumando as configurações do XML na parte de criação do XML 
Elemento 'CEST': [Erro 'Layout'] O valor '2345' nÃ£o Ã© aceito para o padrÃ£o. '[0-9]{7}'. Elemento 'CEST': '2345' nÃ£o Ã© um valor vÃ¡lido. Elemento 'CEST': [Erro 'Layout'] O valor '9999' nÃ£o Ã© aceito para o padrÃ£o. '[0-9]{7}'. Elemento 'CEST': '9999' nÃ£o Ã© um valor vÃ¡lido. 

A fins de teste comentei a variável 
//$nfe->tagCEST(1, ...);

Se tudo der certo você deve ver NFE Válida

Apenas para podermos ter certeza que o xml é válido de acordo com as regras do negócio vá em https://www.sefaz.rs.gov.br/nfe/nfe-val.aspx

abra a xml ASSINADA e coloque no campo e aperte validar, se tudo estiver correto você deverá ter algo mais ou menos nesse padrão 

![All text](https://github.com/jhonatanvpi/projetoNfe/blob/master/images/5.PNG)


### 4 - Enviar Lote NFE para Sefaz 
Agora que o xml foi validado devemos enviar o lote para a sefaz com o código,  certifique-se de alterar os valores da chave, que você pode ver na nota fiscal assinada e o caminho para a NFE de assinada em file_get_contentshttp://127.0.0.1/vpigestao/fwk/nfe/vendor/nfephp-org/nfephp/exemplos/NFe/4.00testaEnviaLote.php


se tudo der certo você deve ver essa imagem, caso não e der erro de schema volte a sua criação da NFE, algo deve estar errado!! 


![All text](https://github.com/jhonatanvpi/projetoNfe/blob/master/images/6.PNG)


### 5 - Buscar o resultado da análise 
Pelo exemplo anterior foi recebido direto o número do protocolo

### 6 - Caso aprovado adicionar protocolo de autorização 
Agora podemos usar http://localhost/vpigestao/fwk/nfe2/vendor/nfephp-org/nfephp/exemplos/NFe/4.00testaAddProt.php

O Número do recebi estará na pasta C:\server\htdocs\vpigestao\fwk\uploadNFE\homologacao\temporarias\201708

Se tudo der certo agora teremos um novo caminho 

C:\server\htdocs\vpigestao\fwk\uploadNFE\homologacao\enviadas\aprovadas\201708

com uma nova NFE com final protNFe.xml

### 7 - Imprimir DANFE
Agora modificamos os caminhos do código http://localhost/vpigestao/fwk/nfe2/vendor/nfephp-org/nfephp/exemplos/NFe/4.00testaDanfe.php
E assim teremos a DANFE gerada

### Link do Projeto no github - criptografado
Link: https://github.com/jhonatanvpi/projetoNfe
