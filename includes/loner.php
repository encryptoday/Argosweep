<?php
	function loner($url){
		set_time_limit(500);
		
		$html = file_get_html("$url");
		$title =  trim($html->find('h1.product_title',0)->text());
		$price = 0;
		if(!is_null($html->find('p.price span',0))){
			$price =  substr(trim($html->find('p.price span',0)->text()),4);	
		}

		$image =  $html->find('figure.woocommerce-product-gallery__image a',0)->href;
		$description =  trim($html->find('div.wc-tab-inner',0)->text());

		$category = array();
		foreach($html->find('span.posted_in a') as $el)
			array_push($category,$el->text());
		
		$cat = '';
		for($k =0 ; $k< count($category) ;$k++)
			if($k==count($category)-1)
				$cat = $cat.$category[$k];
			else
				$cat = $cat.$category[$k].',';	

		$f = fopen(dirname(__DIR__)."/base/products.csv","w");
		fputcsv($f,array($title,$cat,$price,$image,$description));
		fclose($f);
	}
?>
