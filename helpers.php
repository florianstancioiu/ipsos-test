<?php

function get_xml_regions() : array {
    $xml = new DOMDocument();
    $xml->load('countries.xml');
    $countries = $xml->getElementsByTagName("country");

    $regions = [];
    foreach ($countries as $country) {
        $regions[] = $country->getAttribute("zone");
    }

    return array_unique($regions);
}

function get_xml_records() : array {
    $xml = new DOMDocument();
    $xml->load('countries.xml');
    $xml_data = $xml->getElementsByTagName("country");
    $region = isset($_GET['region']) ? (string) $_GET['region'] : '';
    $regions = [];
    $countries = [];

    // Filter data by $_GET['region']
    if (is_string($region) && strlen($region) > 0) {
        $query = "/countries/country[contains(@zone, '$region')]";
        $xpath = new DOMXPath($xml);
        $xml_data = $xpath->query($query);
    }
    
    foreach ($xml_data as $country) {
        $region = $country->getAttribute("zone");
        $name = $country->getElementsByTagName("name")->item(0);
        $language = $country->getElementsByTagName("language")->item(0);
        $currency = $country->getElementsByTagName("currency")->item(0);
        $map_url = $country->getElementsByTagName("map_url")->item(0)->nodeValue;

        // Retrieve latitude and longitude
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
    }

    return $countries;
}

function get_euro_countries() : array {
    $xml = new DOMDocument();
    $xml->load('countries.xml');
    $xml_data = $xml->getElementsByTagName("country");
    $euro_countries = [];

    $query = "/countries/country/currency[contains(@code, 'EUR')]/../name";
    $xpath = new DOMXPath($xml);
    $xpath_results = $xpath->query($query);
    foreach($xpath_results as $result) {
        $euro_countries[] = $result->nodeValue;
    }

    return $euro_countries;
}
