<?php require_once "helpers.php"; ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Ipsos Test</title>
        <style media="screen">
            .table {
                width: 100%;
                margin-bottom: 20px;
                float: left;
            }
            .table .header {
                font-weight: bold;
            }
            .table .header div {
                width: 180px;
                float: left;
                display: block;
                border: 1px solid #222;
                border-left: 0px;
                padding: 5px 10px;
            }
            .table .header div:first-child {
                border-left: 1px solid #222;
            }
            .table .record {
                float: left;
                clear: both;
            }
            .table .record div {
                width: 180px;
                float: left;
                display: block;
                border: 1px solid #222;
                border-left: 0px;
                padding: 5px 10px;
            }
            .table .record div:first-child {
                border-left: 1px solid #222;
            }
        </style>
    </head>
    <body>

        <div>
            <a href="?">No Region</a>
            <?php foreach(get_xml_regions() as $region): ?>
                <a href="?region=<?= $region ?>"><?= ucfirst($region) ?></a>
            <?php endforeach; ?>
        </div>

        <div class="table">
            <div class="header">
                <div>Region</div>
                <div>Country</div>
                <div>Language</div>
                <div>Currency</div>
                <div>Latitude</div>
                <div>Longitude</div>
            </div>

            <?php foreach(get_xml_records() as $country): ?>
                <div class="record">
                    <div><?= $country['region']; ?></div>
                    <div><?= $country['name']; ?> (<?= $country['native_name']; ?>)</div>
                    <div><?= $country['language']; ?> (<?= $country['native_language']; ?>)</div>
                    <div><?= $country['currency']; ?> (<?= $country['currency_code']; ?>)</div>
                    <div><?= $country['latitude']; ?></div>
                    <div><?= $country['longitude']; ?></div>
                </div>
            <?php endforeach; ?>

        </div>

        <div>
            <?= implode(", ", get_euro_countries()); ?>
        </div>
    </body>
</html>
