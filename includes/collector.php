<?php
	function collector($sitemap){
		set_time_limit(500);

		$xml = file_get_html("$sitemap");
		$xml = simplexml_load_string($xml);

		$links = [];
		    foreach ($xml->url as $url) {
		        $links[] = (string) $url->loc; // Add each URL to the array
		    }

		$f = fopen(dirname(__DIR__)."/base/links.csv", "w");
		foreach($links as $l)
			fputcsv($f,array($l));
		fclose($f);

		return count($links);
	}
?>
