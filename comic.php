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
        $comic_id = $_GET['id'];
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
        "https://gateway.marvel.com:443/v1/public/comics/" . $comic_id  . "?" . http_build_query($query)
    );

    $result = json_decode(curl_exec($curl), true);

    curl_close($curl);

    json_encode($result);

    $nombre = $result["data"]["results"][0]["title"];
    $description = $result["data"]["results"][0]["description"];
    $image = $result["data"]["results"][0]["thumbnail"]["path"];
    $date = $result["data"]["results"][0]["dates"][0]["date"];
    $price = $result["data"]["results"][0]["prices"][0]["price"];
    $creators = $result["data"]["results"][0]["creators"]["available"];
    $characters = $result["data"]["results"][0]["characters"]["available"];
    ?>

    <div class="comic-page">
        <section class="header3">
            <a href="index.php">home</a>
            <!--<a href="superhero_x_name.php">characters</a>
            <a>comics</a>
            <a>creators</a>-->
        </section>
        <section class="comic-information">
            <div class="comic-img">
                <img src="<?php echo $image ?>.jpg" height="100px" width="100px">
            </div>
            <div class="comic-info">
                <div class="info-content">
                    <h1><?php echo $nombre ?></h1>
                    <h2>Publication date: <?php echo $date ?></h2>
                    <!--<h3> <?php //echo $description ?></h3>-->
                    <h3>Price: <?php echo $price ?></h3>

                    <div class="title-creators">
                        <h2>Creators</h2>
                    </div>
                    

                    <div class="comic-creators">
                        <?php
                        $i = 0;
                        while ($i < $creators) {
                            $creator_name = $result["data"]["results"][0]["creators"]["items"][$i]["name"];
                            $creator_role = $result["data"]["results"][0]["creators"]["items"][$i]["role"];
                        ?>
                            <div>
                                <h2><?php echo $creator_name ?></h2>
                                <h3><?php echo $creator_role ?></h3>
                            </div>
                        <?php
                            $i++;
                        }

                        ?>
                    </div>
                </div>

            </div>
        </section>
    </div>



</body>

</html>