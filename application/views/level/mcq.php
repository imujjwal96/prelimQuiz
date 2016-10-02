<div class="view hm-black-light">
    <div class="full-bg-img flex-center" >
        <div class="card">
            <form action="/level/submit" method="POST">
                <div class="card-block">
                    <h4 class="card-title"><?= $this->question->statement; ?></h4>
                    <hr />
                    <div class="row" style="color: black;">
                        <div class="col-md-6">
                            <label class="btn btn-primary">
                                <input type="radio" name="input" id="a" value="a" /> <?= $this->question->options->a; ?>
                            </label>
                        </div>
                        <div class="col-md-6">
                            <label class="btn btn-primary">
                                <input type="radio" name="input" id="b" value="b" /> <?= $this->question->options->b; ?>
                            </label>
                        </div>
                    </div>
                    <div class="row" style="color: black;">
                        <div class="col-md-6">
                            <label class="btn btn-primary">
                                <input type="radio" name="input" id="c" value="c" /> <?= $this->question->options->c; ?>
                            </label>
                        </div>
                        <div class="col-md-6">
                            <label class="btn btn-primary">
                                <input type="radio" name="input" id="d" value="d" /> <?= $this->question->options->d; ?>
                            </label>
                        </div>
                    </div>
                    <hr />
                    <button type="submit" class="btn btn-elegant">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
