<nav class="navbar navbar-dark navbar-fixed-top scrolling-navbar bg-transparent">
    <button class="navbar-toggler hidden-sm-up" type="button" data-toggle="collapse" data-target="#collapseEx2">
        <i class="fa fa-bars"></i>
    </button>
    <div class="container">
        <div class="collapse navbar-toggleable-xs" id="collapseEx2">
            <a class="navbar-brand" href="/" style="font-weight: 100"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i>&nbsp Back </a>
            <a class="navbar-brand" style="float: right;font-weight: 100 " href="/index/instructions"><i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp Instruction</a>
        </div>
    </div>
</nav>
<div class="view hm-black-light">
    <div class="full-bg-img flex-center" >
        <form action="/login/action" method="POST">
            <ul  style="margin: 40px">
                <li>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="md-form">
                                <input type="text" id="form1" class="form-control" name="username">
                                <label for="form1">Username</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="md-form">
                                <input type="password" id="form2" class="form-control" name="password">
                                <label for="form2">Password</label>
                                <input type="hidden" name="token" id="token" value="<?= $this->token; ?>"/>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="md-form">
                        <button type="submit" class="btn btn-default btn-rounded">Login</button>
                    </div>
                </li>
            </ul>
        </form>
    </div>
</div>