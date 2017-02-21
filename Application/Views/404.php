<?php
    $Config = new \PQ\Core\Config();
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title><?= $Config->get('QUIZ_NAME');?></title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.1.1/css/mdb.min.css" rel="stylesheet">
    <link rel="icon" href="images/favicon.png">
    <style>
        body {
            background: url("/images/404.jpg")no-repeat center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }
    </style>
</head>

<body>
<div class="container-fluid" style="margin-top:6em">
<p style="text-align: -webkit-center;margin-bottom:-18px;color:#969696">Sorry, We Could'nt find that page</p>
<h1 style="font-size: 50vh;text-align: -webkit-center;font-weight: 900;color: #678fff;">404</h1>
<a href="/" style="text-align: -webkit-center;"><p style="color:#fff"> GO TO HOMEPAGE </p></a>
</div>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


</body>

</html>