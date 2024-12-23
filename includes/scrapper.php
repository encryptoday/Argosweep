<?php
	function scrapper(){
		
		$f = fopen(dirname(__DIR__).'/base/products.csv','w');
		$file = fopen(dirname(__DIR__).'/base/links.csv','r');
		$dat = array();
		$i = 0;

		while(($link = fgetcsv($file)) !== false){
			$lnk = $link[0];

			$i++;
			echo "Product ".$i." --> ";
//			echo "\t";
//			echo $lnk;
			echo "\t";

			$url = $lnk;
			$html = file_get_html($url);

			if($html === FALSE)
			{
				echo "*** 404 NOT FOUND ***";
				echo "\n \n";
	//			usleep(rand(70000000,20000000));
				continue;
			}
			
			$title = trim($html->find('span.breadcrumb-last',0)->text());
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

	//		array_push($dat,array($title,$cat,$price,$image,$description));
			fputcsv($f,array($title,$cat,$price,$image,$description));
			echo "*** DONE ***";
			echo "\n \n";
	//		usleep(rand(7000000,2000000));
		}

		fclose($f);
		fclose($file);
	}
?>
