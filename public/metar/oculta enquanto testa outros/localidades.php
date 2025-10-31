<html>
<head>
<meta http-equiv="refresh" content="300">
<!--[if IE]><link rel="shortcut icon" href="/favicon.ico"><![endif]-->
<link rel="icon" href="/favicon.png" />
<title>METAR BRASIL</title>

<style type="text/css">
<!--
body{background-color:grey;color:white;font-size:32pt}

table{
	width:100%
}

td{font-size:32pt;text-align:left}


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

	$METAR = "SBSC";

function tempo($METAR)
{
    $handle ="Erro conexÃ£o";
    $ID_REDEMET ="1";
	$TAF = "";
	$ACAO = "consulta";
	$LOCAL = "www.redemet.aer.mil.br";  // 200.252.241.45 internet
	//$fp = fsockopen($LOCAL,80,$errno, $errstr, 30);
	

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
//		return $METAR.' - Sem conexção com a REDEMET';
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

 $metarct = tempo("SBCT");
 $metargl = tempo("SBGL");
 $metarrj = tempo("SBRJ");
 $metarsm = tempo("SBSM");
 $metaraf = tempo("SBAF");
 $metarak = tempo("KOAK");
 $metarsp = tempo("SBSP");
 $metarjv = tempo("SBJV");
 $metarsj = tempo("SBSJ");
 $metargr = tempo("SBGR");
 $metar01 = tempo("SBNT");
 $metar02 = tempo("SBSG");

 $corjv = fechado($metarjv);
 $corsp = fechado($metarsp);
 $corct = fechado($metarct);
 $corgl = fechado($metargl);
 $corsm = fechado($metarsm);
 $corrj = fechado($metarrj);
 $coraf = fechado($metaraf);
 $corsj = fechado($metarsj);
 $corgr = fechado($metargr);
 $corak = fechado($metarak);
 $cor01 = fechado($metar01);
 $cor02 = fechado($metar02);

 ?>

<body>


<table>
<tr><td>
<div id="<?php echo $cor01; ?>"><?php echo $metar01; ?></div>
</td></tr>
<tr><td>
<div id="<?php echo $cor02; ?>"><?php echo $metar02; ?></div>
</td></tr>
<tr><td>
<div id="<?php echo $corgl; ?>"><?php echo $metargl; ?></div>
</td></tr>
<tr><td>
<div id="<?php echo $corrj; ?>"><?php echo $metarrj; ?></div>
</td></tr>
<tr><td>
<div id="<?php echo $corct; ?>"><?php echo $metarct; ?></div>
</td></tr>
<tr><td>
<div id="<?php echo $corsm; ?>"><?php echo $metarsm; ?></div>
</td></tr>
<tr><td>
<div id="<?php echo $coraf; ?>"><?php echo $metaraf; ?></div>
</td></tr>
<tr><td>
<div id="<?php echo $corak; ?>"><?php echo $metarak; ?></div>
</td></tr>
<tr><td>
<div id="<?php echo $corsp; ?>"><?php echo $metarsp; ?></div>
</td></tr>
<tr><td>
<div id="<?php echo $corgr; ?>"><?php echo $metargr; ?></div>
</td></tr>
<tr><td>
<div id="<?php echo $corjv; ?>"><?php echo $metarjv; ?></div>
</td></tr>
<tr><td>
<div id="<?php echo $corsj; ?>"><?php echo $metarsj; ?></div>
</td></tr>
</table>

</body>
</html>	

