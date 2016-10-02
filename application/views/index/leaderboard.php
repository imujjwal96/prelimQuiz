

<nav class="navbar navbar-dark bg-transparent navbar-fixed-top scrolling-navbar top-nav-collapse">
    <button class="navbar-toggler hidden-sm-up" type="button" data-toggle="collapse" data-target="#collapseEx2">
        <i class="fa fa-bars"></i>
    </button>
    <div class="container">
        <div class="collapse navbar-toggleable-xs" id="collapseEx2">
            <a class="navbar-brand" href="/" style="font-weight: 100"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i>&nbsp Back </a>
        </div>
    </div>
</nav>
<div class="view hm-black-light">
    <div class="full-bg-img flex-center" >
        <div class="card col-md-8" style="color: black;">
            <table class = "table table-hover text-xs-center">
                <thead>
                <tr>
                    <th style = "text-align: center">Rank</th>
                    <th style = "text-align: center">Name</th>
                    <th style = "text-align: center">Username</th>
                    <th style = "text-align: center">Points</th>
                </tr>
                </thead>
                <tbody>
                <?php
                    $i = 1;
                    foreach ($this->users as $user) {
                        echo '<tr>
                                    <td>' . $i++ . '</td>
                                    <td>' . $user->name . '</td>
                                    <td>' . $user->username . '</td>
                                    <td>' . $user->points . '</td>
                              </tr>';
                    }

                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>