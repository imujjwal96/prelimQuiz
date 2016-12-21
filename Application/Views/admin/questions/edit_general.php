<div class="container-fluid">
    <div class="row"  >
        <div class="col-md-12">
            <div class="card" style="margin:80px 80px;color:#aaa;">
                <div class="card-block">
                    <h4 class="card-title"><strong>Edit Question</strong></h4>
                    <hr />
                    <form role="form" method="POST" action="" enctype="multipart/form-data">
                        <div class="form-group">
                            <label class="control-label" for="question_statement">Statement:</label>
                            <input type="text" class="form-control" name="question_statement" id="question_statement" placeholder="Statement of the Question" value="<?= $this->question->statement; ?>">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="question_cover">Cover:</label>
                            <input type="file" class="form-control" name="question_cover" id="question_cover" placeholder="Cover">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="answer">Answer: </label>
                            <input type="text" class="form-control" name="answer" id="answer" value="<?= $this->question->answer; ?>">
                        </div>
                        <button type="submit" name = "mcq" class="btn btn-default">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
