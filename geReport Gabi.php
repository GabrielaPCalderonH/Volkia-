<pre>
<?php

$vendorID = $_GET['vendor'];
$siteID = $_GET['site'];

function getCategoryName($categoryID) {
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, "https://api.mercadolibre.com/categories/".$categoryID."");  
	curl_setopt($ch, CURLOPT_HEADER, 0);  
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
	
	$retJson = curl_exec($ch);
	
	curl_close($ch);  
	
	//echo "URL: "."https://api.mercadolibre.com/categories/".$categoryID."<br>";
	//echo "RET: ".$retJson."<br>";
	$CategInfo = json_decode($retJson);

	return $CategInfo->name;	
}

function getJsonString($sellerID, $siteID) {
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, "https://api.mercadolibre.com/sites/".$siteID."/search?seller_id=".$sellerID);  
	curl_setopt($ch, CURLOPT_HEADER, 0);  
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
	
	$retJson = curl_exec($ch);
	
	curl_close($ch);  
	
	return $retJson;
}

$jsonReval = getJsonString($vendorID,$siteID);
$RetInfo = json_decode($jsonReval);

// Descomentar la linea siguiente para ver todo lo retornado por el curl
//print_r($RetInfo);

$myfile = fopen("reporte_".$vendorID."_".$siteID.".txt", "w") or die("Unable to open file!");

fwrite($myfile,"Reporte de artículos para Seller [".$vendorID."] y Site [".$siteID."]\n");
fwrite($myfile,"Fecha: ". date("Y/m/d")."\n\n");

for($i=0;$i<count($RetInfo->results);$i++) {
		fwrite($myfile,"   Item ID:".$RetInfo->results[$i]->id."\n");
		fwrite($myfile,"     Title:".$RetInfo->results[$i]->title."\n");
		fwrite($myfile,"  Categ ID:".$RetInfo->results[$i]->category_id."\n");
		fwrite($myfile,"Categ Name:".getCategoryName($RetInfo->results[$i]->category_id)."\n");
		fwrite($myfile,"====================\n");
}
?>
Reporte Creado... <a href="https://micuatro.com/redirects/reporte_<?php echo $vendorID;?>_<?php echo $siteID;?>.txt">descargar aquí </a>
</pre>
