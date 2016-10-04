<div class="view hm-black-light">
    <div class="full-bg-img flex-center" >
        <div class="card">
            <form action="/level/submit" method="POST">
                <div class="card-block">
                    <h4 class="card-title">Question <?= $this->question->id . '/' . $this->total;?>: <strong> <?= $this->question->statement; ?></strong></h4>
                    <hr />
                    <?php if (isset($this->question->image) && !empty($this->question->image)) {
                        echo '<img src="'. $this->question->image . '"/>';
                    } ?>
                    <div class="row" style="color: black;">
                        <div class="col-md-6">
                        <label class="radio">
                            <input type="radio" name="input" id="a" value="a" /> 
                            <span class="outer"><span class="inner"></span></span><?= $this->question->options->a; ?>
                        </label>
                        </div>
                        <div class="col-md-6">
                            <label class="radio">
                            <input type="radio" name="input" id="b" value="b" />
                            <span class="outer"><span class="inner"></span></span><?= $this->question->options->b; ?>
                            </label>
                        </div>
                    </div>
                    <div class="row" style="color: black;">
                        <div class="col-md-6">
                            <label class="radio">
                            <input type="radio" name="input" id="c" value="c" />
                            <span class="outer"><span class="inner"></span></span><?= $this->question->options->c; ?>
                            </label>
                        </div>
                        <div class="col-md-6">
                            <label class="radio">
                            <input type="radio" name="input" id="d" value="d" />
                            <span class="outer"><span class="inner"></span></span><?= $this->question->options->d; ?>
                            </label>
                        </div>
                    </div>
                    <hr />
                    <button type="submit" class="btn btn-default">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
