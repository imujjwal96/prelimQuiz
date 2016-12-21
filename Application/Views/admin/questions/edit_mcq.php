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
                        <h4 class="card-title"><strong> <?= $this->question->statement; ?></strong></h4>
                        <hr />
                        <form name="mcq" id="mcq" role="form" method="POST" action="" enctype="multipart/form-data"">

                            <div class="form-group">
                                <label class="control-label" for="question_statement">Statement:</label>
                                <input type="text" class="form-control" name="question_statement" id="question_statement" placeholder="Statement of the Question" value="<?= $this->question->statement; ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="question_cover">Cover:</label>
                                <input type="file" class="form-control" name="question_cover" id="question_cover" placeholder="Cover">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="option_a">Option A: </label>
                                <input type="text" class="form-control" name="option_a" id="option_a" placeholder="First Option">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="option_b">Option B: </label>
                                <input type="text" class="form-control" name="option_b" id="option_b" placeholder="Second Option">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="option_c">Option C: </label>
                                <input type="text" class="form-control" name="option_c" id="option_c" placeholder="Third Option">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="option_d">Option D: </label>
                                <input type="text" class="form-control" name="option_d" id="option_d" placeholder="Fourth Option">
                            </div>
                            <label for="answer">Answer: </label>
                            <select class="form-control" name="answer" id="answer">
                                <option value="" selected disabled>Choose Answer: </option>
                                <option value="a">A</option>
                                <option value="b">B</option>
                                <option value="c">C</option>
                                <option value="d">D</option>
                            </select>
                            <button type="submit" name = "mcq" class="btn btn-default">Submit</button>
                        </form>
                        <?php if (isset($this->question->cover) && !empty($this->question->cover)) {
                            echo '<img src="data:jpeg;base64,' . base64_encode($this->question->cover->getData()) . '" />';
                        }?>
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
