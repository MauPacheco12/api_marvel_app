<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API MARVEL APP</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="icon" href="img/mini-comic.png">
</head>

<body>

    <?php
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    if (!isset($_GET['id'])) {
        echo "<script type='text/javascript'>window.location.href = 'index.php';</script>";
    } else {
        $character_id = $_GET['id'];
    }


    $ts = time();
    $public_key = '857ec41be95beeb1ac9cd5bb04b4aa7c';
    $private_key = '0dec56a8c6ef0e259c6190a7b3d828683636135f';
    $hash = md5($ts . $private_key . $public_key);

    $query = array(
        'format' => 'comic',
        'formatType' => 'comic',
        'apikey' => $public_key,
        'ts' => $ts,
        'hash' => $hash,
    );

    curl_setopt(
        $curl,
        CURLOPT_URL,
        "https://gateway.marvel.com:443/v1/public/characters/" . $character_id  . "?" . http_build_query($query)
    );

    $result = json_decode(curl_exec($curl), true);

    curl_close($curl);

    json_encode($result);

    $nombre = $result["data"]["results"][0]["name"];
    $description = $result["data"]["results"][0]["description"];
    $image = $result["data"]["results"][0]["thumbnail"]["path"];

    ?>

    <div class="content-pj">
        <section class="header2">
            <a href="index.php">home</a>
            <!--
            <a href="superhero_x_name.php">characters</a>
            <a>comics</a>
            <a>creators</a>-->
        </section>
        <section class="information">
            <div class="img">
                <img src="<?php echo $image ?>.jpg" height="100px" width="100px">
            </div>
            <div class="info">
                <div>
                    <h1><?php echo $nombre ?></h1>
                    <p> <?php echo $description ?></p>
                </div>

            </div>
        </section>

        <section class="comics">
            <h1>COMICS</h1>
            <?php
            curl_setopt(
                $curl,
                CURLOPT_URL,
                "https://gateway.marvel.com:443/v1/public/characters/" . $character_id . "/comics" . "?" . http_build_query($query)
            );

            $result = json_decode(curl_exec($curl), true);

            curl_close($curl);

            json_encode($result);
            $comics = $result["data"]["count"];

            ?>
            <div class="cont-comics">
                <?php
                $i = 0;
                while ($i < $comics) {
                    $comic_id = $result["data"]["results"][$i]["id"];
                    $comic_name = $result["data"]["results"][$i]["title"];
                    $comic_description = $result["data"]["results"][$i]["description"];
                    $comic_image = $result["data"]["results"][$i]["thumbnail"]["path"];
                ?>

                    <div class="cont-comic">
                        <div class="cont-text">
                            <h3><?php echo $comic_name ?></h3>
                        </div>

                        <div class="cont-img">
                            <img src="<?php echo $comic_image ?>.jpg">
                        </div>

                        <div class="cont-text2">
                            <a href="comic.php?id=<?php echo $comic_id?>">More</a>
                        </div>

                    </div>

                <?php
                    $i++;
                }

                ?>
            </div>
        </section>

        <section class="events">
            <h1>EVENTS</h1>

            <?php
            $query = array(
                'apikey' => $public_key,
                'ts' => $ts,
                'hash' => $hash,
            );

            curl_setopt(
                $curl,
                CURLOPT_URL,
                "https://gateway.marvel.com:443/v1/public/characters/" . $character_id . "/events" . "?" . http_build_query($query)
            );

            $result_event = json_decode(curl_exec($curl), true);

            curl_close($curl);

            json_encode($result_event);
            $events = $result_event["data"]["count"];

            ?>
            <div class="cont-events">
                <?php
                $i = 0;
                while ($i < $events) {
                    $event_name = $result_event["data"]["results"][$i]["title"];
                    $event_description = $result_event["data"]["results"][$i]["description"];
                    $event_image = $result_event["data"]["results"][$i]["thumbnail"]["path"];
                ?>
                    <div class="cont-event">
                        <img src="<?php echo $event_image ?>.jpg">
                        <div class="text-event">
                            <div>
                                <h3><?php echo $event_name ?></h3>
                                <p><?php echo $event_description ?></p>
                                <br>
                                <!--<a>More</a>-->
                            </div>
                        </div>
                    </div>

                <?php
                    $i++;
                }

                ?>
            </div>


        </section>

        <section class="series">
            <h1>SERIES</h1>
            <?php
            $query = array(
                'apikey' => $public_key,
                'ts' => $ts,
                'hash' => $hash,
            );

            curl_setopt(
                $curl,
                CURLOPT_URL,
                "https://gateway.marvel.com:443/v1/public/characters/" . $character_id . "/series" . "?" . http_build_query($query)
            );

            $result = json_decode(curl_exec($curl), true);

            curl_close($curl);

            json_encode($result);
            $comics = $result["data"]["count"];

            ?>
            <div class="cont-series">
                <?php
                $i = 0;
                while ($i < $comics) {
                    $series_name = $result["data"]["results"][$i]["title"];
                    $series_description = $result["data"]["results"][$i]["description"];
                    $series_image = $result["data"]["results"][$i]["thumbnail"]["path"];
                ?>
                    <div class="cont-serie">
                        <div>
                            <div class="cont-h3">
                                <h3><?php echo $series_name ?></h3>
                            </div>

                            <div class="cont-img">
                                <img src="<?php echo $series_image ?>.jpg">
                            </div>

                            <div class="cont-text">
                                <p><?php echo $description ?></p>
                                <br>
                                <!--<a>More</a>-->
                            </div>
                        </div>
                    </div>

                <?php
                    $i++;
                }

                ?>
            </div>

        </section>
    </div>



</body>

</html>