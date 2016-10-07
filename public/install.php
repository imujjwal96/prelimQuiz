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

        $config_file = fopen("../application/config/config.php", "w") or die("could not open file.");

        $content = '<?php
    return array(
        \'URL\' => \'http://\' . $_SERVER[\'HTTP_HOST\'] . str_replace(\'public\', \'\', dirname($_SERVER[\'SCRIPT_NAME\'])),

        \'PATH_CONTROLLER\' => realpath(dirname(__FILE__).\'/../../\') . \'/application/controllers/\',
        \'PATH_VIEW\' => realpath(dirname(__FILE__).\'/../../\') . \'/application/views/\',

        \'DEFAULT_CONTROLLER\' => \'index\',
        \'DEFAULT_ACTION\' => \'index\',

        \'DB_TYPE\' => "' . $db_type . '",
        \'DB_HOST\' => \'127.0.0.1\',
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
            header('Location: /');
        } else {
            die('couldnot write file.');
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

    <title>CodeRush2016</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.1.1/css/mdb.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h1>prelimQuiz</h1>
        <h4>Installation</h4>
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <form role="form" method="POST" action="install.php">
                    <hr />
                    <h4>Basic Quiz Information</h4>
                    <hr />
                    <div class="form-group">
                        <label class="control-label" for="quiz_name">Name of the Quiz</label>
                        <input type="text" class="form-control" name="quiz_name" id="quiz_name" placeholder="Quiz Name">
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
                    <h4>Database Information</h4>
                    <hr />
                    <div class="form-group">
                        <label class="control-label" for="db_name">Name of the Database</label>
                        <input type="text" class="form-control" name="db_name" id="db_name" placeholder="Database Name">
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