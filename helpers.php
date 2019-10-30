<?php

$xml = new DOMDocument();
$xml->load('countries.xml');
$regions = [];
$countries = [];

// Retrieve XML data
foreach ($xml->getElementsByTagName("country") as $xml_country) {
    $region = $xml_country->getAttribute("zone");
    $name = $xml_country->getElementsByTagName("name")->item(0);
    $language = $xml_country->getElementsByTagName("language")->item(0);
    $currency = $xml_country->getElementsByTagName("currency")->item(0);
    $map_url = $xml_country->getElementsByTagName("map_url")->item(0)->nodeValue;

    // retrieve latitude and longitude
    $pattern = '|^https://www.google.ro/maps/place/[\w]+/@([\d.,-]+),|';
    preg_match($pattern, $map_url, $matches);
    $coordinates = explode(",", $matches[1]);

    $countries[] = [
        'region' => $region,
        'name' => $name->nodeValue,
        'native_name' => $name->getAttribute("native"),
        'language' => $language->nodeValue,
        'native_language' => $language->getAttribute("native"),
        'currency' => $currency->nodeValue,
        'currency_code' => $currency->getAttribute("code"),
        'latitude' => $coordinates[0],
        'longitude' => $coordinates[1]
    ];
    $regions[] = $region;
}

$regions = array_unique($regions);

var_dump($countries, $regions);
die();
