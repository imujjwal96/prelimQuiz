<div class="view hm-black-light">
    <div class="full-bg-img flex-center" >
        <form type="form" method="POST" action="/level/submit">
        <div class="card" style="color: black">
            <div class="card-block">
                <h4 class="card-title">Question <?= $this->question->id . '/' . $this->total;?>: <strong> <?= $this->question->statement; ?></strong></h4>
                <hr />
                <div class="row" style="color: black;">
                    <div class="col-md-6 offset-md-3" >
                        <input type="text" name="input" />
                    </div>
                </div>
                <hr />
                <button type="submit" class="btn btn-default">Submit</button>
            </div>
        </div>
        </form>
    </div>
</div>
