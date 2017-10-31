<html>
<header>
<title>ENADE Avalia&ccedil;&atilde;o de desempenho</title>
</header>
<body>
<!--  Bem vindo!
      Este codigo possui diversos comentarios que registram como 
	  o programa funciona para a coleta de resultados dos alunos 
	  enadistas. 
	  
	  Neste codigo, para fins de teste foram declaradas cinco
	  respostas para coleta.

	  Ajuste no bloco ENADISTAS, o numero de questoes que deseja
	  coletar alterando o laco "FOR", ajustando "$x" para o numero
	  de questoes desejado (neste codigo o numero de questoes <= 5);
	  
	  Ajuste tambem o bloco "ENADISTAS addgab" a quantidade de "$qN"
	  que recebem os parametros do formulario e a $string, cujos
	  dados sao salvos no arquivo.csv
      
-->
<?php
// Definicoes de arquivos do programa
// --- Arquivo com o nome de arquivo de dados CPF do coletor
$filename='./filename.txt';
// --- Arquivo onde as respostas do gabarito oficial sao salvas
$gabarito='./gabarito.txt';
// Gestao dos parametros de controle do programa
// index.php?admin=value
if (empty ($_GET["admin"])) {
    $admin=""; // comando administrativo nao definido
} else {
    $admin=$_GET ["admin"]; // comando administrativo definido
}
// index.php?acao=value
if (empty ($_GET["acao"])) {
    $acao="";  // sem acao definida, mostra status
} else {
    $acao=$_GET ["acao"]; // acao definida para execucao
    //   echo $acao;
}

if (empty ($_POST["cpf"])) {
    $CPF=""; // comando administrativo nao definido
} else {
    $CPF=$_POST["cpf"]; // comando administrativo definido
}


// index.php?admin=sanitize
if ( $admin == 'sanitize' ) {
    $admin="";
    // apaga todos os registros
    //$filename="./filename.txt";
    if (file_exists($filename)) {
        echo "<script>alert('Removendo arquivos de dados'); </script>";
        $lines=file($filename, FILE_IGNORE_NEW_LINES);
        $filename="{$lines[0]}.csv";
        unlink ("./$filename");
        unlink ("./filename.txt");
		
	} else {
		echo "<script>alert('ERRO! Arquivo de gestão ausente! \\n\\nA limpeza não foi executada.'); </script>";
    }
	if (file_exists($gabarito)) {
		echo "<script>alert('Removendo gabarito oficial'); </script>";
		unlink ("./gabarito.txt");
	} else {
		echo "<script>alert('ERRO! Gabarito oficial ausente!'); </script>";
	}
}
// ===================================================================
// Inicio do programa - A acao escolhida eh colocada em destaque
// ---- STATUS ----
if ( $acao == '' || $acao == 'status' ) {
   echo "<b>Status</b>  | ";
   $acao='status';
} else {
   echo "<a href='./index.php?acao=status'>Status</a> | ";
}
// ---- ENADISTAS ----
   if (file_exists($filename) && ($acao == '' || $acao == 'status')) {
      //echo "<a href='./insere_dados.php'>Enadistas</a> | ";
	  echo "<a href='./index.php?acao=enadistas'>Enadistas</a> | ";
   } elseif ( $acao == 'enadistas' ){
      echo "<b>Enadistas</b> | ";
   } else {
      echo "Enadistas | ";
   }
// ---- GABARITO ----   
   if (file_exists($gabarito)) {
      echo "<a href='./index.php?acao=vergab'>Gabarito</a> | ";
} else {
      echo "Gabarito | ";
}
?>
Processar Resultados
<!-- Linha que separa o menu principal da tela com a funcao escolhida -->
<hr>

<!-- STATUS -->
<?php
if ( $acao == 'status' ) {
   echo "
   <table cellspacing=0 cellpadding=0 width=480 height=150>
   <tr>
      <td colspan=3><center><b>S T A T U S</b></td></center>
   </tr>
   <tr>
      <td><li></td>
      <td>Arquivo de dados <br>(gabarito dos enadistas)</td>
      <td>";
        //$filename='./filename.txt';
         if (file_exists($filename)) {
            echo "<b>Definido</b><br>Arquivo: ";
            $lines=file($filename, FILE_IGNORE_NEW_LINES);
            $datafile="{$lines[0]}.csv";
            echo $datafile;
         } else {
            echo "<b>Inexistente</b>";
            echo "<br><a href='./index.php?acao=datafile'>Criar arquivo agora</a>";
         }
      
      echo "</td>
   </tr>
   <tr>
      <td><li></li></td>
	  <td>Gabarito Oficial:</td>
	  <td>";
      
         //$gabarito='./gabarito.txt';
         if (file_exists($gabarito)) {
            echo "<b>Cadastrado</b>";
         } else {
            echo "<b>Inexistente</b>";
            echo "<br><a href='./index.php?acao=gabarito'>Inserir Gabarito</a>";
         }
      
      echo "</td>
   </tr>
</table>";
}
?>
<!-- Fim do STATUS -->

<!-- DATAFILE :: Nome do arquivo de dados -->
<?php
if ( $acao == 'datafile' ) {
   echo "<form action='./index.php?acao=datafilec' method='post'>
         <br>Informe seu CPF: <input type='text' name='cpf' value='' size='11'>
         <br>N&atilde;o use pontos ou traços
         <br>Exemplo: 11122233344
         <p><input type='submit' value='Criar arquivo de dados'>
         </form>
         <hr>
         <b>Orienta&ccedil;&otilde;es:</b> 
         <br>Clique no bot&atilde;o <b>criar arquivo de dados</b> 
			 para criar um arquivo onde ser&atilde;o salvos os 
			 gabaritos dos alunos enadistas.
         <p>Esse arquivo ser&aacute; nomeado com o n&uacute;mero
             do CPF informado.
		 <br>EXEMPLO: 11122233344.csv</p>
		 <p>&Eacute; importante informar SEU n&uacute;mero de CPF
            pois posteriormente todas as coletas de dados ser&atilde;o
            reunidas e contabilizadas.</p>
   "; 
}
?>
<!-- Fim do DATAFILE -->
<!-- DATAFILEC :: Criacao do arquivo de dados -->
<?php
if ( $acao == 'datafilec' ) {
   //echo "<b>Cria&ccedil;&atilde;o de arquivos de dados</b>";
   //$CPF=$_POST ["cpf"];
   //echo $CPF;
   // cria o arquivo filename.txt
   $datafilec='./filename.txt';
   $fp = fopen($datafilec, "a");
   fwrite ($fp,  $CPF);
   fclose($fp);
   //echo "<p>Indice gerado com sucesso!</p>";
   // Cria arquivo de dados
   $fp=fopen ("./{$CPF}.csv", "a");
   fclose ($fp);
   echo "<script>alert('CRIACAO DE ARQUIVOS \\n\\n[OK] Indice gerado. \\n\\n[OK] Arquivo de dados criado.'); </script>";
   //echo "<p>Arquivo de dados criado!</p>";
   //echo "<hr><a href='./index.php?acao='>Retornar &agrave; p&aacute;gina inicial </a>";
   $page = $_SERVER['PHP_SELF'];
   $sec = "2";
   //header("Refresh: $sec; url='./index.php?acao='status'");
   header("Refresh: url='./index.php?acao='status'");
}
?>
<!-- Fim de DATAFILEC -->

<!-- ENADISTAS -->
<?php
if ( $acao == 'enadistas' ) {
   echo"<p><b>Incluir Respostas</b>
        <form action='./index.php?acao=addgab' method='post'>
        <br>RA: <input type='text' name='ra' value='' size='10'> Exemplo 1510012345
        <br>CURSO: <input type='text' name='curso' value='' > ADS, BSI, CCO, ENGCOMP
   ";
   for ($x = 1; $x <= 5; $x++) {
      echo "<p>Quest&atilde;o $x 
            <input type='radio' name='q$x' value='A' checked> A | 
            <input type='radio' name='q$x' value='B'> B | 
            <input type='radio' name='q$x' value='C'> C | 
            <input type='radio' name='q$x' value='D'> D | 
            <input type='radio' name='q$x' value='E'> E
			<br><hr>";
   }
   echo "<input type='submit' value='Salvar Respostas'>
         </form>";
   echo "<form action='./index.php?acao=status' method='get'>
         <input type='submit' value='Cancelar cadastro'>
         </form>";
}
?>
<!-- Fim de ENADISTAS -->

<!-- ENADISTAS addgab - Salvar dados do gabarito informado -->
<?php
if ( $acao == 'addgab' ) {
   $ra=$_POST ["ra"];
   $curso= $_POST ["curso"];
   $q1=$_POST ["q1"];
   $q2=$_POST ["q2"];
   $q3=$_POST ["q3"];
   $q4=$_POST ["q4"];
   $q5=$_POST ["q5"];
   // Recupera o nome do arquivo para salvar dados
   $lines=file($filename, FILE_IGNORE_NEW_LINES);
   $datafile="{$lines[0]}.csv";
   //$ncurso=
   if (file_exists($datafile)) {
      $fp = fopen($datafile, "a");
      $string="{$ra};{$q1};{$q2};{$q3};{$q4};{$q5};N respostas\r\n";
      fwrite ($fp,  $string); // salva dados
      fclose($fp); // fecha arquivo
      echo "Dados salvos!";
      echo "<br><a href='./index.php?acao=enadistas'>Inserir outro enadista </a>";
      echo "<br><a href='./index.php?acao=status'>Menu inicial</a>";
   } else {
      echo "O arquivo $filename não existe";
   }
}
?>
<!-- Fim de ENADISTAS addgab -->

<!-- GABARITO -->
<?php
if ( $acao == 'gabarito' ) {
   echo"<p><b>CADASTRAR GABARITO OFICIAL</b></p>
        <form action='./index.php?acao=gabof' method='post'>
   ";
   for ($x = 1; $x <= 5; $x++) {
      echo "<p>Quest&atilde;o $x 
            <input type='radio' name='q$x' value='A' checked> A | 
            <input type='radio' name='q$x' value='B'> B | 
            <input type='radio' name='q$x' value='C'> C | 
            <input type='radio' name='q$x' value='D'> D | 
            <input type='radio' name='q$x' value='E'> E
			<br><hr>";
   }
   echo "<input type='submit' value='Salvar Gabarito'>
         </form>";
}
?>
<!-- Fim de GABARITO -->
<!-- GABARITO :: gabof - salvar dados do gabarito oficial -->
<?php
if ( $acao == 'gabof' ) {
   $q1=$_POST ["q1"];
   $q2=$_POST ["q2"];
   $q3=$_POST ["q3"];
   $q4=$_POST ["q4"];
   $q5=$_POST ["q5"];

   if (file_exists('./gabarito.txt')) {
      echo "<script>alert('Ja existe um gabarito oficial cadastrado!'); </script>";
   } else {
      $fp = fopen('./gabarito.txt', "a");
      $string="{$q1};{$q2};{$q3};{$q4};{$q5};N respostas\r\n";
      fwrite ($fp,  $string); // salva dados
      fclose($fp); // fecha arquivo
      echo "<script>alert('GABARITO Salvo.'); </script>";
   }
   $page = $_SERVER['PHP_SELF'];
   $sec = "1";
   header("Refresh: $sec; url='./index.php?acao='status'");
}
?>
<!-- Fim de GABARITO - gabof -->
<!-- GABARITO vergab - visualizar respostas cadastradas -->
<?php
if ( $acao == 'vergab' ) {
   echo "<table cellspacing=0 cellpadding=0 width=480 height=150>
         <tr><td><center><b>G A B A R I T O</b></td></center></tr>
         </table>";
   if (file_exists('./gabarito.txt')) {
      $lines=file('./gabarito.txt', FILE_IGNORE_NEW_LINES);
      //$datafile="{$lines[0]}.csv";
	  echo "{$lines[0]}";
      echo "<br><a href='./index.php?acao=status'>Retornar ao menu inicial</a>";	  
   }
}
?>
<!-- Fim de GABARITO vergab -->


</html>

<!-- referencias
https://www.w3schools.com/css/css_list.asp
https://www.w3schools.com/css/tryit.asp?filename=trycss_list-style-image
   Exemplo: <img src='./arquivo.png' alt='LOGO' height='50' width='100'> <br>
https://www.w3schools.com/php/php_forms.asp
-->