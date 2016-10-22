<nav class="navbar navbar-dark navbar-fixed-top scrolling-navbar bg-transparent">
    <button class="navbar-toggler hidden-sm-up" type="button" data-toggle="collapse" data-target="#collapseEx2">
        <i class="fa fa-bars"></i>
    </button>
    <div class="container">
        <div class="collapse navbar-toggleable-xs" id="collapseEx2">
			<a class="navbar-brand" style="font-weight: 100 " href="../../index/leaderboard"><i class="fa fa-trophy" aria-hidden="true"></i>&nbsp Leaderboard</a>
            <a class="navbar-brand" href="../../login/logout" style="float: right;font-weight: 100"><i class="fa fa-sign-out" aria-hidden="true"></i>&nbsp Quit</a>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row"  >
	<div class="col-md-12">
        <div class="card" style="margin:80px 80px;color:#aaa;">
        <form type="form" method="POST" action="/level/submit">
            <div class="card-block">
                <h4 class="card-title">Question <?= (UserModel::getUserLevel() + 1) . '/' . $this->total;?>: <strong> <?= $this->question->statement; ?></strong></h4>
                <hr />
                <div class="row" style="color: black;">
                    <div class="col-md-6 offset-md-3" >
                        <input type="text" name="input" />
                    </div>
                </div>
                <hr />
                <button type="submit" class="btn btn-default">Submit</button>
            </div>
			</form>
        </div>
        
    </div>
</div>
</div>
