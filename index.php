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
    <section class="inicio">
        <div class="header">
            <!--<a href="superhero_x_name.php">characters</a>
            <a>comics</a>
            <a>creators</a>-->
        </div>
        <div class="cont-inicio">
            <div class="cont-i">
                <form method="get">
                    <br>
                    <input type="text" name="name" placeholder="Search for the superhero by name... ">
                    <br>
                    <button name="btnBuscar">BUSCAR</button>
                </form>

            </div>
        </div>
    </section>

    <?php
    if (isset($_GET['btnBuscar'])) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $name_to_search = htmlentities(strtolower($_GET['name'])); // HuLk == hulk

        $ts = time();
        $public_key = '857ec41be95beeb1ac9cd5bb04b4aa7c';
        $private_key = '0dec56a8c6ef0e259c6190a7b3d828683636135f';
        $hash = md5($ts . $private_key . $public_key);

        $query = array(
            "name" => $name_to_search, // ""
            "orderBy" => "name",
            "limit" => "20",
            'apikey' => $public_key,
            'ts' => $ts,
            'hash' => $hash,
        );

        $marvel_url = 'https://gateway.marvel.com:443/v1/public/characters?' . http_build_query($query);

        curl_setopt($curl, CURLOPT_URL, $marvel_url);

        $result = json_decode(curl_exec($curl), true);

        curl_close($curl);

        json_encode($result);

        if ($result["data"]["results"] == []) {
            echo 'no funca';
        } else {
            $id = $result["data"]["results"][0]["id"];
            echo $id;
            echo "<script type='text/javascript'>window.location.href = 'superhero.php?id=$id';</script>";
        }
    }

    ?>
</body>

</html>