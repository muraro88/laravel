<html>
<head>
<meta http-equiv="refresh" content="300">
<!--[if IE]><link rel="shortcut icon" href="/favicon.ico"><![endif]-->
<link rel="icon" href="/favicon.png" />
<title>APP-SC</title>
<style type="text/css">
<!--
body{background-color:grey;color:white;font-size:32pt}

table{
	width:100%
}

td{font-size:24pt;text-align:left}


#azul{background-color:blue}
#verde{background-color:green}
#amarelo{background-color:yellow;color:black}

#preto{background-color:grey;color:black;font-size:18pt}
#branco{background-color:grey;color:write;font-size:22pt}

#azul2{background-color:blue;font-size:22pt}
#verde2{background-color:green;font-size:22pt}
#amarelo2{background-color:yellow;color:black;font-size:22pt}


-->
</style>



 
</head>
<?php
	error_reporting(0); //desabilita os erros
/*
		
	//Busca o resultado da busca 
	$handle = @fopen('capture.txt','r') or die ('erro 15 </b></center>');;
	//enquanto houver resutados ele exibe na tela para o ajax
	while (!feof ($handle)) {
	   $buffer = fgets( $handle , 4096 );
	   if (strpos($buffer,'SBSC')>0) {$conteudo = $buffer;};	   
	}
	//procura fim do arquivo [25;1H
	if (!strpos($conteudo,"[25;1H")>0) {
	fclose ( $handle );
	$handle = @fopen('teste.txt','r');
	while (!feof ($handle)) {
	   $buffer = fgets( $handle , 4096 );
	   if (strpos($buffer,'SBSC')>0) {$conteudo = $buffer;};	   
	};
	}
	
	
	//fecha a URL solicitada
	fclose ( $handle );
	
	$nprimetable = strrpos($conteudo,'Hobeco');
	$fechatable = strlen($conteudo);
    $quantopula = $fechatable - $nprimetable ;
	$conteudo = substr($conteudo, $nprimetable ,$quantopula);
	
	$fp = fopen("teste.txt", "w"); 
	fwrite($fp, $conteudo);
	fclose($fp);
	
	function monta($texto,$codigo,$tamanho,$soma){
		if (strpos($texto,$codigo)>0){		
		$inicio = strpos($texto,$codigo)+$soma;
		return substr($texto,$inicio,$tamanho);
		} else {
			return "";
		}
	}

	
 parametros
data 10.5		1;64H	26/03/2011 
hora 5.5		1;76H	22:16
Vento 3.25		5;1H	#6D.Vento(graus).:  243ñ07 
vento 4.9		5;26H	#6 229ñ07
Metar 4.9		5;34H	#6 241ñ09
Vento		6;1H	#6V.Vento(kts)...:   005.0
Vento		6;27H	#6 004.2
Metar		6;35H	#6 005.1
Pico		7;1H	#6Pico Vento(kts):   006.0
Pico		7;26H	#6  005.6
Metar		7;34H	#6  007.6
QNH			9;18H	#6 1013.0
QNH			9;34H	#6 1012.9
Temp		11;16H	#6  23.9
pista		11;22H	#6/  25.0
metar		11;35H	#6  24.0
PO			12;19H	#6  22.0
metar		12;35H	#6  21.9 

	$data = monta($conteudo,"1;64H",10,5);
	$hora = monta($conteudo,"1;76H",5,5);
	$vento23G = monta($conteudo,"5;1H",3,25);
	$vento05G = monta($conteudo,"5;26H",3,9);
	$metarG = monta($conteudo,"5;34H",3,9);
	$vento23G1 = monta($conteudo,"5;1H",2,29);
	$vento05G1 = monta($conteudo,"5;26H",2,13);
	$metarG1 = monta($conteudo,"5;34H",2,13);
	$vento23K = monta($conteudo,"6;1H",5,26);
	$vento05K = monta($conteudo,"6;27H",5,9);
	$metarK = monta($conteudo,"6;35H",5,9);
	$Pico23 = monta($conteudo,"7;1H",5,26);
	$Pico05 = monta($conteudo,"7;26H",5,10);
	$metarP = monta($conteudo,"7;34H",5,10);
	$QNH = monta($conteudo,"9;18H",6,9);
	$metarQNH = monta($conteudo,"9;34H",6,9);
	$Temp = monta($conteudo,"11;16H",4,11);
	$metarT = monta($conteudo,"11;35H",4,11);
        $Capp= "app1";
        $teste="teste"; 
	
*/	

	//Busca o resultado da busca	 
	$METAR = "SBSC";
function tempo($METAR)
{
    $handle ="Erro conexão";
    $ID_REDEMET ="1";
	$TAF = "";
	$ACAO = "consulta";
	$LOCAL = "www.redemet.aer.mil.br";  // 200.252.241.45 internet
	//$fp = fsockopen($LOCAL,80,$errno, $errstr, 30);

//if(!fsockopen($LOCAL, 80)) {
//	$LOCAL="200.252.241.45";}

//if ($fp){

	if (!$handle = fopen( "http://".$LOCAL."/?i=produtos&p=consulta-de-mensagens-opmet&msg_localidade=".$METAR."&acao=localidade&tipo_msg[]=metar",'r'))
       {$handle = fopen( $METAR.".txt",'r');
         while (!feof ($handle)) {
	           $texto = fgets( $handle , 4096 );
	           };
         fclose ( $texto );
        echo '<style type="text/css">
<!--
body{background-color:red;color:white;font-size:32pt}

-->
</style>';

    } else {
	//enquanto houver resutados ele exibe na tela para o ajax
//	$handle = @fopen("http://".$LOCAL."/consulta_msg/consulta_de_mensagem_rapida.php?ID_REDEMET=".$ID_REDEMET."&METAR=".$METAR."&TAF=".$TAF."&ACAO=".$ACAO,'r') or die ('<center>Erro na conexao<br><b>tente F5 para atualizar </b></center>');;
	while (!feof ($handle)) {
	   $buffer = fgets( $handle , 4096 );
	   if (strpos($buffer,'METAR '.$METAR)>0) {$texto = $buffer;};
	   if (strpos($buffer,'SPECI '.$METAR)>0) {$texto = $buffer;};
	};
	//fecha a URL solicitada
	fclose ( $handle );

	$nprimetable = strrpos($texto,$METAR);
	$fechatable = strlen($texto);
    $quantopula = $fechatable - $nprimetable ;

	$texto = substr($texto, $nprimetable ,$quantopula-8);
	};
	$fp = fopen($METAR.".txt", "w");
	fwrite($fp, $texto);
	fclose($fp);
	return $texto;
//	} else {
//		return $METAR.' - Sem conex��o com a REDEMET';
//	}

}
function fechado($cond){
	$cor = "verde";
	if (strpos($cond,'CAVOK')>0) {
	    $cor = "azul";		
	} else {
	$bkn=100;$ovc=100;$visual = 9999;
	if (strpos($cond,'KT')>0){$visual = substr($cond,strpos($cond,'KT')+3,4);}
	if (strpos($cond,'BKN')>0){$bkn = substr($cond,strpos($cond,'BKN')+3,3);}
	if (strpos($cond,'OVC')>0){$ovc = substr($cond,strpos($cond,'OVC')+3,3);}
  	if (strpos($visual,'V')>0){$visual = substr($cond,strpos($cond,'KT')+11,4);}
	//echo $cond.$visual.$bkn.$ovc;
	if (($visual<5000)or($bkn<15)or($ovc<15)){ $cor="amarelo";	}
	}
	return $cor;
}
//teste
function fechado2($cond){
	$cor = "verde";
	if (strpos($cond,'CAVOK')>0) {
	    $cor = "azul";		
	} else {
	$bkn=100;$ovc=100;$visual = 9999;
	if (strpos($cond,'KT')>0){$visual = substr($cond,strpos($cond,'KT')+3,4);}
	if (strpos($cond,'BKN')>0){$bkn = substr($cond,strpos($cond,'BKN')+3,3);}
	if (strpos($cond,'SCT')>0){$ovc = substr($cond,strpos($cond,'SCT')+3,3);}
	//echo $cond.$visual.$bkn.$ovc;
	if (($visual<5000)or($bkn<15)or($ovc<15)){ $cor=$cond.$visual.$bkn.$ovc;	}
	}
	return $cond.$visual.$bkn.$ovc;
}

//Vento

function pista($pis,$pis2){
	if (($pis>136 and $pis<316) and ($pis2>136 and $pis2<316)){
		return "p23";
	} else {
		if ($pis2<136 and $pis2>316){return "p05";};
	};
}
 $metarsc = tempo("SBSC");
 $metargl = tempo("SBGL");
 $metarco = tempo("SBCO");
 $metarmn = tempo("SBMN");
 $metarpv = tempo("SBPV");
 $metarbv = tempo("SBBV");
 $metarbe = tempo("SBBE");
 $metarcg = tempo("SBCG");
 $metargr = tempo("SBGR");
 $metarsm = tempo("SBSM");
 $metarrb = tempo("SBRB");

 $corbe = fechado($metarbe);
 $corbv = fechado($metarbv);
 $corsc = fechado($metarsc);
 $corgl = fechado($metargl);
 $cormn = fechado($metarmn);
 $corco = fechado($metarco);
 $corpv = fechado($metarpv);
 $corcg = fechado($metarcg);
 $corgr = fechado($metargr);
 $corsm = fechado($metarsm);
 $corrb = fechado($metarrb);
// $rwy = pista($metarG);
 $horaUTC = $hora+3;
// $teste = fechado2($metarsc);


//checando data e hora

function horacerta($dataS,$horaS){

$DS=explode("/",$dataS);
$HS=explode(":",$horaS);
$sistema = "$HS[0],$HS[1],00,$DS[1],$DS[0],$DS[2]";


$data_c=mktime(date('H,i,s,m,d,Y')); //computador
$data_s=@mktime($sistema); //sistema

$teste=$data_c." - ".$data_s;

if (($data_c-$data_s) < 12000){
   return true;
	} else {
   return false;
};
}

// Online??

$online=horacerta($data,$hora);


if(!$online){
	$vento23G = "";
	$vento05G = "";
	$metarG = "";
	$vento23G1 = "";
	$vento05G1 = "";
	$metarG1 = "";
	$vento23K = "";
	$vento05K = "";
	$metarK = "";
	$Pico23 = "";
	$Pico05 = "";
	$metarP = "";
	$QNH = "";
	$metarQNH = "";
	$Temp = "";
	$metarT = "";
        $Capp= "app2";


};


//teste


function teste2($dataS,$horaS){

$DS=explode("/",$dataS);
$HS=explode(":",$horaS);
$sistema = "$HS[0],$HS[1],00,$DS[1],$DS[0],$DS[2]";


$data_c=mktime(date('H,i,s,m,d,Y')); //computador
$data_s=@mktime($sistema); //sistema

$teste=$data_c." - ".$data_s."-".$sistema."-".date('H,i,s,m,d,Y');
$teste="";
return $teste;
}

$teste=teste2($data,$hora);

?>

<body>
<?php echo $teste; ?>
<!--
<table class=<?php echo $Capp; ?> ><tr>
<td align="left">Data:<?php echo $data; ?></td><td align="center">APP-SC</td><td align="right">Hora:<?php echo $hora.$horaUT; ?></td>
</tr></table>

<table border=2 frame="void" align="center">
<tr>
<td></td>
<td <?php if(pista($metarG,$vento23G)=="p23"){echo "class='rwy'";};?>>RWY 23</td>
<td <?php if(pista($metarG,$vento05G)=="p05"){echo "class='rwy'";};?>>RWY 05</td>
<td>METAR</td>
</tr>
<tr>
<td>Vento (Graus)</td><td><?php echo $vento23G."&#177;".$vento23G1; ?></td><td><?php echo $vento05G."&#177;".$vento05G1; ?></td><td><?php echo $metarG."&#177;".$metarG1; ?></td>
</tr>
<tr>
<td>Vento (Kts)</td><td><?php echo $vento23K; ?></td><td><?php echo $vento05K; ?></td><td><?php echo $metarK; ?></td>
</tr>
<tr>
<td>Pico Vento (Kts)</td><td><?php echo $Pico23; ?></td><td><?php echo $Pico05; ?></td><td><?php echo $metarP; ?></td>
</tr>
<tr>
<td>QNH (hPa)</td><td colspan="2" class="qnh"><?php echo $QNH; ?></td><td><?php echo $metarQNH; ?></td>
</tr>
<tr>
<td>Temperatura (&#176;C)</td><td colspan="2"><?php echo $Temp; ?></td><td><?php echo $metarT; ?></td>
</tr>
<tr>
<td colspan="4" class="met"> <?php echo $METARC; ?></td>
</tr>
</table>
-->
<!--     Legenda
<table width:50%>
<tr>
<td colspan=4>
<div id="branco">METAR dos principais AD da TMA-RJ e da TMA-SP</div>
</td>
</tr>
<tr>
<td>
<div id="branco">Legenda: </div>
</td>
<td>
<div id="azul2">CAVOK</div>
</td>
<td>
<div id="verde2">VMC</div>
</td>
<td>
<div id="amarelo2">IMC</div>
</td>
</tr>
</table>
-->

<table>
<tr><td>
<div id="<?php echo $corrb; ?>"><?php echo $metarrb; ?></div>
</td></tr>
<tr><td>
<div id="<?php echo $corgl; ?>"><?php echo $metargl; ?></div>
</td></tr>
<tr><td>
<div id="<?php echo $corsc; ?>"><?php echo $metarsc; ?></div>
</td></tr>
<tr><td>
<div id="<?php echo $corsm; ?>"><?php echo $metarsm; ?></div>
</td></tr>
<tr><td>
<div id="<?php echo $corpv; ?>"><?php echo $metarpv; ?></div>
</td></tr>
<tr><td>
<div id="<?php echo $corbv; ?>"><?php echo $metarbv; ?></div>
</td></tr>
<tr><td>
<div id="<?php echo $corgr; ?>"><?php echo $metargr; ?></div>
</td></tr>
<tr><td>
<div id="<?php echo $corbe; ?>"><?php echo $metarbe; ?></div>
</td></tr>
<tr><td>
<div id="<?php echo $cormn; ?>"><?php echo $metarmn; ?></div>
</td></tr>
<tr><td>
<div id="<?php echo $corcg; ?>"><?php echo $metarcg; ?></div>
</td></tr>
<tr><td>
<div id="<?php echo $corco; ?>"><?php echo $metarco; ?></div>
</td></tr>
</table>


</body>
</html>	
<head>
<meta http-equiv="refresh" content="300">
<!--[if IE]><link rel="shortcut icon" href="/favicon.ico"><![endif]-->
<link rel="icon" href="/favicon.png" />
<title>METAR APP-RJ</title>
<style type="text/css">
<!--
/* Elegant Aero */
.elegant-aero {
    margin-left:auto;
    margin-right:auto;
    border: 1px solid black;
    width: 100%;
    background: #66CDAA;
    font: 12px Arial, Helvetica, sans-serif;
    color: #666;

}

.elegant-aero td {
    vertical-align: top;
    border: 2px solid white;

}


.elegant-aero h1 {
    font: 24px "Trebuchet MS", Arial, Helvetica, sans-serif;
    padding: 10px 10px 10px 10px;
    display: block;
    background: #C0E1FF;
    border-bottom: 1px solid #B8DDFF;

}
.elegant-aero h1>span {
    display: block;
    font-size: 11px;
}

.elegant-aero label>span {
    float: left;
    margin-top: 5px;
    color: #5E5E5E;
}
.elegant-aero label {
    display: block;
    margin: 0px 0px 5px;
    font-size: 71px
}

.elegant-aero a {
    font-size: 16px
}

.elegant-aero label>span {
    float: left;
    width: 20%;
    text-align: right;
    padding-right: 5px;
    margin-top: 5px;
    font-weight: bold;
}
.elegant-aero input[type="text"], .elegant-aero input[type="email"], .elegant-aero textarea, .elegant-aero select {

    width: 15%;
    padding: 0px 0px 0px 0px;
    border: 1px solid #C5E2FF;
    background: #FBFBFB;
    outline: 0;
    -webkit-box-shadow:inset 0px 1px 6px #ECF3F5;
    box-shadow: inset 0px 1px 6px #ECF3F5;
    font: 200 12px/25px Arial, Helvetica, sans-serif;
    height: 30px;

}
.elegant-aero textarea{
    height:100px;
    padding: 5px 0px 0px 5px;
    width: 70%;
}
.elegant-aero select {
    background: #fbfbfb url('down-arrow.png') no-repeat right;
    background: #fbfbfb url('down-arrow.png') no-repeat right;
   appearance:none;
    -webkit-appearance:none;
   -moz-appearance: none;
    text-indent: 0.01px;
    text-overflow: '';
    width: 70%;
}
.elegant-aero .button{
    padding: 10px 30px 10px 30px;
    background: #66C1E4;
    border: none;
    color: #FFF;
    box-shadow: 1px 1px 1px #4C6E91;
    -webkit-box-shadow: 1px 1px 1px #4C6E91;
    -moz-box-shadow: 1px 1px 1px #4C6E91;
    text-shadow: 1px 1px 1px #5079A3;

}

.elegant-aero input[type="submit"]{
    padding: 5px 20px 5px 20px;
    background: #66C1E4;
    border: none;
    color: #000;

    box-shadow: 1px 1px 1px #4C6E91;
    -webkit-box-shadow: 1px 1px 1px #4C6E91;
    -moz-box-shadow: 1px 1px 1px #4C6E91;
    text-shadow: 1px 1px 1px #5079A3;

}

.elegant-aero .button:hover{
    background: #3EB1DD;
}


-->
</style>


</head>

<BODY>


<table class="elegant-aero">
<tr><td align="center">
<br>
</form>
<form action="http://www.aisweb.aer.mil.br/?i=aerodromos" target="_blank" id="rotaer" method="get">
<input id="rotaer" type="submit" value="AISWEB (ROTAER):" />
<input type="text" name="codigo" maxlength="4" onBlur="this.value=this.value.toUpperCase()" style='text-transform: uppercase;' size="4" />
<input type="hidden" name="lingua" value="pt-br" />
<input type="hidden" name="i" value="aerodromos" />
</form>
</form>
<form action="http://www.airnav.com/airports" target="_blank" id="airnav" method="get">
<input id="airnav" type="submit" value="AISWEB (AIRNAV USA):" />
<input type="text" name="codigo" maxlength="4" onBlur="this.value=this.value.toUpperCase()" style='text-transform: uppercase;' size="4" />
<input type="hidden" name="lingua" value="pt-br" />
<input type="hidden" name="i" value="airports" />
</form>
</form>
<form action="http://www.redemet.aer.mil.br/?i=produtos&p=consulta-de-mensagens-opmet#" target="_blank" id="metar" method="post">
<input id="metar" type="submit" value="METAR:" />
<input type="text" name="msg_localidade" maxlength="4" onBlur="this.value=this.value.toUpperCase()" style='text-transform: uppercase;' size="4" />
<input type="hidden" name="acao" value="localidade" />
<input type="hidden" name="tipo_msg[]" value="metar" />
</form>
<form action="http://www.aisweb.aer.mil.br/notam/rs.cfm#" target="_blank" id="notam" method="post">
<input id="enviar" type="submit" value="NOTAM:" />
<input type="text" name="codigo" maxlength="4" onBlur="this.value=this.value.toUpperCase()" style='text-transform: uppercase;' size="4" />
<input style="cursor:pointer;" maxlength="10" id="dt_i" class="dt_i tip" type="hidden" title="Data de início do intervalo" name="dt_i" />
<input style="cursor:pointer;" maxlength="10" id="dt_f" class="dt_f tip" type="hidden" title="Data de término do intervalo" name="dt_f" />
<input type="hidden" name="fonte" value="N" />
<input type="hidden" name="sup" value="1" />
<input type="hidden" name="rs" value="1" />
</form>
</td><td align="center">
<br>
<form action="RAZAO_DESCIDA_PAR.pdf" target="_blank" id="cartas" method="post">
<input id="cartas" type="submit" value="RAZAO DESCIDA PAR" />
</form>
<form action="/cartas" target="_blank" id="cartas" method="post">
<input id="cartas" type="submit" value="Procedimentos SBSC" />
</form>
<form action="tmarj.html" target="_blank" id="tmarj" method="post">
<input id="cartas" type="submit" value="TMA-RJ" />
</form>
</td><td>
   <h1>Documentos</h1>
   <ul>
 
   <li><a href="sbsc/Mod_Op_APPSC_2015.pdf" target="docs">Mod Op APPSC 2015</a> </li>
   <li><a href="sbsc/CIRCEA_100-22_2011.pdf" target="docs">CIRCEA 100-22 2011</a> </li>
   <li><a href="sbsc/CAOp_Marambaia_2013.pdf" target="docs">CAOp Marambaia 2013</a> </li>

   </ul>
</td></tr>
</table>
</BODY>
</HTML>

