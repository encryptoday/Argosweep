<?php
require_once('simple_html_dom.php');
use parallel\Runtime;

$f = fopen('products.csv', 'w');
$file = fopen('url.csv', 'r');
$tasks = [];

// Prepare an array of URLs
while (($link = fgetcsv($file)) !== false) {
    $tasks[] = $link[0];
}
fclose($file);

// Function to process each URL
function process_url($url)
{
    require_once('simple_html_dom.php');
    $result = [];
    $html = file_get_html($url);

    if ($html === FALSE) {
        return ["Error: 404 NOT FOUND"];
    }

    $title = trim($html->find('span.breadcrumb-last', 0)->text());
    $price = 0;
    if (!is_null($html->find('p.price span', 0))) {
        $price = substr(trim($html->find('p.price span', 0)->text()), 4);
    }
    $image = $html->find('figure.woocommerce-product-gallery__image a', 0)->href;
    $description = trim($html->find('div.wc-tab-inner', 0)->text());
    $category = [];

    foreach ($html->find('span.posted_in a') as $el) {
        $category[] = $el->text();
    }

    $cat = implode(',', $category);
    $result = [$title, $cat, $price, $image, $description];
    return $result;
}

// Create threads and execute in parallel
$runtimes = [];
$results = [];
$maxThreads = 5; // Limit the number of threads
$chunks = array_chunk($tasks, $maxThreads);

foreach ($chunks as $chunk) {
    foreach ($chunk as $url) {
        $runtime = new Runtime();
        $runtimes[] = $runtime;
        $results[] = $runtime->run('process_url', [$url]);
    }

    // Collect results and write to CSV
    foreach ($results as $result) {
        fputcsv($f, $result->value());
    }

    // Clean up runtime threads
    foreach ($runtimes as $runtime) {
        $runtime->close();
    }

    $runtimes = [];
    $results = [];
}

fclose($f);
?>
