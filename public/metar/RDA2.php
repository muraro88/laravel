<html>

<head>

<title>RDA2</title>

<meta http-equiv="refresh" content="300">

<link rel="icon" href="/favicon.png" />

<style type="text/css">
<!--
body { background-color:grey; color:white; font-size:32pt; }

table { width:100%; }

td { font-size:24pt; text-align:left; }

#azul{background-color:blue}
#verde{background-color:green}
#amarelo{background-color:yellow;color:black}
#ambar{background-color:orange;color:black}
#vermelho{background-color:red}

#preto{background-color:grey;color:black;font-size:18pt}
#branco{background-color:grey;color:write;font-size:22pt}

#azul2{background-color:blue;font-size:22pt}
#verde2{background-color:green;font-size:22pt}
#amarelo2{background-color:yellow;color:black;font-size:22pt}
-->
</style>

<style type="text/css">
<!--
/* Elegant Aero */
.elegant-aero {
    margin-left: auto;
    margin-right: auto;
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

.elegant-aero textarea {
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

.elegant-aero .button {
    padding: 10px 30px 10px 30px;
    background: #66C1E4;
    border: none;
    color: #FFF;
    box-shadow: 1px 1px 1px #4C6E91;
    -webkit-box-shadow: 1px 1px 1px #4C6E91;
    -moz-box-shadow: 1px 1px 1px #4C6E91;
    text-shadow: 1px 1px 1px #5079A3;
}

.elegant-aero input[type="submit"] {
    padding: 5px 20px 5px 20px;
    background: #66C1E4;
    border: none;
    color: #000;
    box-shadow: 1px 1px 1px #4C6E91;
    -webkit-box-shadow: 1px 1px 1px #4C6E91;
    -moz-box-shadow: 1px 1px 1px #4C6E91;
    text-shadow: 1px 1px 1px #5079A3;
}

.elegant-aero .button:hover {
    background: #3EB1DD;
}
-->
</style>

</head>

<?php
	error_reporting(1); //desabilita os erros

	//Busca o resultado da busca	 
	$METAR = "SBSC";

function tempo($METAR)
{
    $handle = "Erro conexão";
    $ID_REDEMET = "1";
	$TAF = "";
	$ACAO = "consulta";
	//$LOCAL = "www.redemet.intraer/old";  // 200.252.241.45 internet
	$LOCAL = "redemet.decea.mil.br/old";  // 200.252.241.45 internetdecea
	$echo("https://".$LOCAL."/?i=produtos&p=consulta-de-mensagens-opmet&msg_localidade=".$METAR."&acao=localidade&tipo_msg[]=metar");

	if (!$handle = fopen( "https://".$LOCAL."/?i=produtos&p=consulta-de-mensagens-opmet&msg_localidade=".$METAR."&acao=localidade&tipo_msg[]=metar",'r'))
	{
		$handle = fopen($METAR . ".txt", 'r');

		while (!feof($handle))
		{
			$texto = fgets($handle , 4096);
		}

		fclose($texto);
        echo '<style type="text/css">';
        echo '<!--';
        echo 'body{background-color:red;color:white;font-size:32pt}';
        echo '-->';
        echo '</style>';
	}
	else
	{
		//enquanto houver resutados ele exibe na tela para o ajax
		while (!feof($handle))
		{
			$buffer = fgets($handle, 4096);
			if (strpos($buffer, 'METAR ' . $METAR) > 0) { $texto = $buffer; }
			if (strpos($buffer, 'SPECI ' . $METAR) > 0) { $texto = $buffer; }
		};

		//fecha a URL solicitada
		fclose($handle);

		$nprimetable = strrpos($texto,$METAR);
		$fechatable = strlen($texto);
		$quantopula = $fechatable - $nprimetable ;
		$texto = substr($texto, $nprimetable, $quantopula - 8);
	}

	$fp = fopen($METAR . ".txt", "w");
	fwrite($fp, $texto);
	fclose($fp);
	return $texto;
}

function fechado($cond)
{
	$cor = "azul";

	if (strpos($cond,'CAVOK') === FALSE)
	{
		$bkn = 100; $ovc = 100; $visual = 9999;
		if (strpos($cond,   'KT')  > 0) {$visual = substr($cond, strpos($cond,'KT')  +  3, 4);}
		if (strpos($cond,   'BKN') > 0) {$bkn    = substr($cond, strpos($cond,'BKN') +  3, 3);}
		if (strpos($cond,   'OVC') > 0) {$ovc    = substr($cond, strpos($cond,'OVC') +  3, 3);}
		if (strpos($visual, 'V')   > 0) {$visual = substr($cond, strpos($cond,'KT')  + 11, 4);}

		if (($visual <  9999) or ($bkn < 50) or ($ovc < 50)) { $cor = "verde"; }
		if (($visual <  5000) or ($bkn < 15) or ($ovc < 15)) { $cor = "amarelo"; }
		if (($visual == 1000) or ($bkn == 2) or ($ovc == 2)) { $cor = "ambar"; }
		if (($visual <  1000) or ($bkn <  2) or ($ovc <  2)) { $cor = "vermelho"; }
	}
	
	return $cor;
}

//teste
function fechado2($cond)
{
	$cor = "verde";

	if (strpos($cond, 'CAVOK') > 0)
	{
		$cor = "azul";		
	}
	else
	{
		$bkn = 100;
		$ovc = 100;
		$visual = 9999;

		if (strpos($cond, 'KT') > 0) { $visual = substr($cond, strpos($cond,'KT') + 3, 4); }
		if (strpos($cond, 'BKN') > 0) { $bkn = substr($cond, strpos($cond,'BKN') + 3, 3); }
		if (strpos($cond, 'SCT') > 0) { $ovc = substr($cond, strpos($cond,'SCT') + 3, 3); }
		if (($visual < 5000) or ($bkn < 15) or ($ovc < 15)) { $cor = $cond . $visual . $bkn . $ovc; }
	}

	return $cond . $visual . $bkn . $ovc;
}

//Vento

function pista($pis, $pis2)
{
	if (($pis>136 and $pis<316) and ($pis2>136 and $pis2<316))
	{
		return "p23";
	}
	else
	{
		if ($pis2<136 and $pis2>316) { return "p05"; }
	}
}

$metarco = tempo("SBCO"); $corco = fechado($metarco);
$metarpa = tempo("SBPA"); $corpa = fechado($metarpa);
$metarsm = tempo("SBSM"); $corsm = fechado($metarsm);
$metarfl = tempo("SBFL"); $corfl = fechado($metarfl);
$metarsc = tempo("SBSC"); $corsc = fechado($metarsc);
$metargl = tempo("SBGL"); $corgl = fechado($metargl);
$metarrj = tempo("SBRJ"); $corrj = fechado($metarrj);
$metaraf = tempo("SBAF"); $coraf = fechado($metaraf);
$metares = tempo("SBES"); $cores = fechado($metares);
$metarsj = tempo("SBSJ"); $corsj = fechado($metarsj);
$metargr = tempo("SBGR"); $corgr = fechado($metargr);
$metarsp = tempo("SBSP"); $corsp = fechado($metarsp);
$metarcg = tempo("SBCG"); $corcg = fechado($metarcg);
$metardn = tempo("SBDN"); $cordn = fechado($metardn);
$metardo = tempo("SBDO"); $cordo = fechado($metardo);
$metarca = tempo("SBCA"); $corca = fechado($metarca);
$metarlo = tempo("SBLO"); $corlo = fechado($metarlo);
$metarcr = tempo("SBCR"); $corcr = fechado($metarcr);
$metarpp = tempo("SBPP"); $corpp = fechado($metarpp);
$metarfi = tempo("SBFI"); $corfi = fechado($metarfi);
$metarmg = tempo("SBMG"); $cormg = fechado($metarmg);
$metarch = tempo("SBCH"); $corch = fechado($metarch);
$metarbi = tempo("SBBI"); $corbi = fechado($metarbi);
$metarct = tempo("SBCT"); $corct = fechado($metarct);


// $rwy = pista($metarG);
 $horaUTC = $hora+3;
// $teste = fechado2($metarsc);


//checando data e hora
function horacerta($dataS, $horaS)
{
	$DS=explode("/", $dataS);
	$HS=explode(":", $horaS);
	$sistema = "$HS[0],$HS[1],00,$DS[1],$DS[0],$DS[2]";
	$data_c=mktime(date('H,i,s,m,d,Y')); //computador
	$data_s=@mktime($sistema); //sistema
	$teste = $data_c . " - " . $data_s;

	if (($data_c - $data_s) < 12000)
	{
		return true;
	}
	else
	{
		return false;
	}
}

// Online??

$online=horacerta($data,$hora);


if (!$online){
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


function teste2($dataS, $horaS)
{
	$DS=explode("/",$dataS);
	$HS=explode(":",$horaS);
	$sistema = "$HS[0],$HS[1],00,$DS[1],$DS[0],$DS[2]";
	$data_c=mktime(date('H,i,s,m,d,Y')); //computador
	$data_s=@mktime($sistema); //sistema
	$teste=$data_c." - ".$data_s."-".$sistema."-".date('H,i,s,m,d,Y');
	$teste="";
	return $teste;
}

$teste=teste2($data, $hora);

?>

<body>

<table class="elegant-aero">
<tr><td align="center">
	<h1>RDA2 - Cor Meteorol&oacute;gica</h1>
</td></tr>
</table>

<table>
<tr><td>
<div id="<?php echo $corco; ?>"><?php echo $metarco; ?></div>
</td></tr>
<tr><td>
<div id="<?php echo $corpa; ?>"><?php echo $metarpa; ?></div>
</td></tr>
<tr><td>
<div id="<?php echo $corsm; ?>"><?php echo $metarsm; ?></div>
</td></tr>
<tr><td>
<div id="<?php echo $corfl; ?>"><?php echo $metarfl; ?></div>
</td></tr>
<tr><td>
<div id="<?php echo $corsc; ?>"><?php echo $metarsc; ?></div>
</td></tr>
<tr><td>
<div id="<?php echo $corgl; ?>"><?php echo $metargl; ?></div>
</td></tr>
<tr><td>
<div id="<?php echo $corrj; ?>"><?php echo $metarrj; ?></div>
</td></tr>
<tr><td>
<div id="<?php echo $coraf; ?>"><?php echo $metaraf; ?></div>
</td></tr>
<tr><td>
<div id="<?php echo $cores; ?>"><?php echo $metares; ?></div>
</td></tr>
<tr><td>
<div id="<?php echo $corsj; ?>"><?php echo $metarsj; ?></div>
</td></tr>
<tr><td>
<div id="<?php echo $corgr; ?>"><?php echo $metargr; ?></div>
</td></tr>
<tr><td>
<div id="<?php echo $corsp; ?>"><?php echo $metarsp; ?></div>
</td></tr>
<tr><td>
<div id="<?php echo $corcg; ?>"><?php echo $metarcg; ?></div>
</td></tr>
<tr><td>
<div id="<?php echo $cordn; ?>"><?php echo $metardn; ?></div>
</td></tr>
<tr><td>
<div id="<?php echo $cordo; ?>"><?php echo $metardo; ?></div>
</td></tr>
<tr><td>
<div id="<?php echo $corca; ?>"><?php echo $metarca; ?></div>
</td></tr>
<tr><td>
<div id="<?php echo $corlo; ?>"><?php echo $metarlo; ?></div>
</td></tr>
<tr><td>
<div id="<?php echo $corcr; ?>"><?php echo $metarcr; ?></div>
</td></tr>
<tr><td>
<div id="<?php echo $corpp; ?>"><?php echo $metarpp; ?></div>
</td></tr>
<tr><td>
<div id="<?php echo $corfi; ?>"><?php echo $metarfi; ?></div>
</td></tr>
<tr><td>
<div id="<?php echo $cormg; ?>"><?php echo $metarmg; ?></div>
</td></tr>
<tr><td>
<div id="<?php echo $corch; ?>"><?php echo $metarch; ?></div>
</td></tr>
<tr><td>
<div id="<?php echo $corbi; ?>"><?php echo $metarbi; ?></div>
</td></tr>
<tr><td>
<div id="<?php echo $corct; ?>"><?php echo $metarct; ?></div>
</td></tr>
</table>

<table class="elegant-aero">
<tr>
	<td align="center">
		<h1>LINKS</h1>
		<ul>
			<form action="http://publicacoes.decea.intraer/" target="_blank" id="cartas" method="get">
				<input id="cartas" type="submit" value="AISWEB-Publica&ccedil;&otilde;es" />
			</form>
			<form action="http://www.redemet.intraer/old/?i=produtos&p=consulta-de-mensagens-opmet#" target="_blank" id="metar" method="post">
				<input id="metar" type="submit" value="METAR:" />
				<input type="text" name="msg_localidade" maxlength="4" onBlur="this.value=this.value.toUpperCase()" style='text-transform: uppercase;' size="2" />
				<input type="hidden" name="acao" value="localidade" />
				<input type="hidden" name="tipo_msg[]" value="metar" />
			</form>
			<form action="http://aisweb.decea.intraer/?i=aerodromos" target="_blank" id="rotaer" method="get">
				<input id="rotaer" type="submit" value="AISWEB-Aerodromos" />
				<input type="text" name="codigo" maxlength="4" onchange="this.value=this.value.toUpperCase()" style='text-transform: uppercase;' size="2" />
				<input type="hidden" name="lingua" value="pt-br" />
				<input type="hidden" name="i" value="aerodromos" />
			</form>
			<form action="http://aisweb.decea.intraer/?i=notam" target="_blank" id="notam" method="post">
				<input id="enviar" type="submit" value="NOTAM:" />
				<input type="text" name="icaocode" maxlength="4" onBlur="this.value=this.value.toUpperCase()" style='text-transform: uppercase;' size="2" />
				<input type="hidden" name="busca" value="localidade" />
				<input type="hidden" name="tipo" value="N" />
			</form>
		</ul>
	</td>
</tr>
</table>

</body>
</html>	
