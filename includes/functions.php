<?php
	function drawHeader(){
		echo "++++++++++++++++++++++++++++++++++++++++++++++++++";
		echo "\n";
		echo "             Welcome to Argosweep";
		echo "\n";
		echo "         Designed and Dveloped by MMM";
		echo "\n";
		echo "++++++++++++++++++++++++++++++++++++++++++++++++++";
		echo "\n";
	}

	function disclaimer(){
		echo "\n";
		echo "WARNING\t: BEFORE GOING ANY FURTHER, MAKE SURE \nYOU HAVE THE RIGHT PERMISSION FROM THE AUTHORITY";
		echo "\n\n";
	}

	function taskSelector(){
		echo "1. Single Page Retrival";
		echo "\n";
		echo "2. Bulk Retrival";
		echo "\n\n";

		echo "Select your retrival mode : ";
		$option = trim(fgets(STDIN));
		
		if($option == 1)
			singleRetrival();
		elseif($option == 2)
			bulkRetrival();
		else
			wrongInput();
	}

	function singleRetrival(){
		echo "\n";
		echo "Enter product url : ";
		$url = trim(fgets(STDIN));
		echo "\n";
		echo "Retriving product ... \t";
		loner($url);
		echo "DONE";
		echo "\n\n";
		echo "Product details are saved in ./base/products.csv";
		echo "\n\n";
	}

	function bulkRetrival(){
		echo "\n";
		echo "Enter sitemap url : ";
		$sitemap = trim(fgets(STDIN));
		echo "\n";
		echo "Collecting links ... \t";
		$n = collector($sitemap);
		echo "DONE";
		echo "\n\n";
		echo "$n products are saved in ./base/links.csv";
		echo "\n\n";
		scrapper();
	}

	function wrongInput(){
		echo "wrong";
	}
?>