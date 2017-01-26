<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["quiz_name"], $_POST["quiz_type"], $_POST["db_name"], $_POST["db_type"],
        $_POST["db_user"], $_POST["db_pass"], $_POST["db_port"])) {
        $quiz_name = empty($_POST["quiz_name"]) ? "Prelim Quiz" : htmlspecialchars($_POST["quiz_name"]);
        $quiz_type = empty($_POST["quiz_name"]) ? "mcq" : htmlspecialchars($_POST["quiz_type"]);
        $db_name = empty($_POST["quiz_name"]) ? "prelim_quiz" : htmlspecialchars($_POST["db_name"]);
        $db_type = empty($_POST["quiz_name"]) ? "mysql" : htmlspecialchars($_POST["db_type"]);
        $db_user = empty($_POST["quiz_name"]) ? "root" : htmlspecialchars($_POST["db_user"]);
        $db_pass = empty($_POST["quiz_name"]) ? "" : htmlspecialchars($_POST["db_pass"]);
        $db_port = empty($_POST["quiz_name"]) ? "3306" : htmlspecialchars($_POST["db_port"]);

        $config_file = fopen("../Application/Config/config.php", "w") or die("could not open file.");

        $content = '<?php
    return array(
        \'URL\' => \'http://\' . $_SERVER[\'HTTP_HOST\'] . str_replace(\'public\', \'\', dirname($_SERVER[\'SCRIPT_NAME\'])),

        \'PATH_CONTROLLER\' => realpath(dirname(__FILE__).\'/../../\') . \'/Application/Controllers/\',
        \'PATH_VIEW\' => realpath(dirname(__FILE__).\'/../../\') . \'/Application/Views/\',

        \'DEFAULT_CONTROLLER\' => \'index\',
        \'DEFAULT_ACTION\' => \'index\',

        \'DB_TYPE\' => "' . $db_type . '",
        \'DB_HOST\' => \'mysqlhost\',
        \'DB_NAME\' => "' . $db_name . '",
        \'DB_USER\' => "' . $db_user . '",
        \'DB_PASS\' => "' . $db_pass . '",
        \'DB_PORT\' => ' . $db_port . ',
        \'DB_CHARSET\' => \'utf8\',

        \'COOKIE_RUNTIME\' => 1209600,
        \'COOKIE_PATH\' => \'/\',
        \'COOKIE_DOMAIN\' => "",
        \'COOKIE_SECURE\' => false,
        \'COOKIE_HTTP\' => true,
        \'SESSION_RUNTIME\' => 604800,

        \'QUIZ_NAME\' => "' . $quiz_name . '",
        \'QUIZ_TYPE\' => "' . $quiz_type . '"
    );
';
        if (fwrite($config_file, $content)) {
            $servername = "mysqlhost";
            $username = "username";
            $password = "password";
            $dbname = "myDB";

            $database = mysqli_connect($servername, $db_user, $db_pass);
            if (!$database) {
                die("Connection failed: " . mysqli_connect_error());
            }

            $create_db_query = "CREATE DATABASE " . $db_name;
            if (!mysqli_query($database, $create_db_query)) {
                die(mysqli_error($database));
            }

            $create_table_query = "CREATE TABLE {$db_name}.`info` ( `id` int(11) NOT NULL,
                                  `name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
                                  `email` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
                                  `username` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
                                  `phone` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
                                  `password` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
                                  `points` int(11) NOT NULL,
                                  `level` int(11) NOT NULL,
                                  `role` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
                                  `datetime` datetime NOT NULL
                                   ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
            if (!mysqli_query($database, $create_table_query)) {
                die(mysqli_error($database));
            }
            $table_update_query1 = "ALTER TABLE {$db_name}.`info`
                                   ADD PRIMARY KEY (`id`),
                                   ADD UNIQUE KEY `email` (`email`,`username`),
                                   ADD KEY `level` (`points`);";
            if (!mysqli_query($database, $table_update_query1)) {
                die(mysqli_error($database));
            }
            $table_update_query2 = " ALTER TABLE {$db_name}.`info`
                                   MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;";
            if (!mysqli_query($database, $table_update_query2)) {
                die(mysqli_error($database));
            }
            header('Location: /');
        } else {
            die('could not write file.');
        }
    } else {
        die("not set");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>prelimQuiz</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.1.1/css/mdb.min.css" rel="stylesheet">
    <link href="stylesheets/style.css" rel="stylesheet">
    <link rel="icon" href="images/favicon.png">
</head>

<body style="background: none;">
    <div class="container-fluid">

        <div class="row row-eq-height">
            <div class="col-md-6 left-side" style="background: #9601ff;text-align: center">
            	<div class="branding" >
            	<img src="images/logo.png" class="img-responsive" width="200px"/>
            	<h1 style="color: #ffffff;font-weight: 100;">An open source, self-hosted quiz script with the backend of Object Oriented PHP</h1>
            	<h1 ><a href="https://github.com/imujjwal96/prelimQuiz" style="color: #ffffff;"><i class="fa fa-github" aria-hidden="true"></i></a></h1>
            	</div>
            </div>
           <div class="col-md-6">
                <form role="form" method="POST" action="install.php" class="ss-form">
                    <hr />
                    <h4 style="text-align: center">Installation</h4>
                    <hr />
                    <div class="form-group">
                        <label class="control-label" for="quiz_name">Name of the Quiz</label>
                        <input type="text" class="form-control" name="quiz_name" id="quiz_name" placeholder="Quiz Name" required />
                    </div>
                    <div class="form-group">
                        <label for="quiz_type">Type of the Quiz</label>
                        <select class="form-control" name="quiz_type" id="quiz_type">
                            <option>General</option>
                            <option>MCQ</option>
                            <option>Mixed</option>
                        </select>
                    </div>
                    <hr />
                    <h4 style="text-align: center">Database Information</h4>
                    <hr />
                    <div class="form-group">
                        <label class="control-label" for="db_name">Name of the Database</label>
                        <input type="text" class="form-control" name="db_name" id="db_name" placeholder="Database Name" required />
                    </div>
                    <div class="form-group">
                        <label for="db_type">Type of the Database</label>
                        <select class="form-control" name="db_type" id="db_type">
                            <option>mysql</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="db_user">Name of the Database User</label>
                        <input type="text" class="form-control" name="db_user" id="db_user" placeholder="Database Username">
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="db_pass">Password of the Database</label>
                        <input type="password" class="form-control" name="db_pass" id="db_pass" placeholder="Database Password">
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="db_port">Port of the Database</label>
                        <input type="text" class="form-control" name="db_port" id="db_port" value="3306">
                    </div>
                    <button type="submit" class="btn btn-default">Submit</button>
                </form>

            </div>
        </div>
    </div>



<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


</body>

</html>