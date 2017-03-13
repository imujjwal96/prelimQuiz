<div class="container">
    <div class="row"  >
        <div class="col-md-12">
            <div class="card" style="color: black;margin:70px 80px;">
                <h4 class="card-title animated tada infinite_text" style="padding: 30px 2px 10px 2px;font-weight: 400;">Delete Questions</h4>
                <table class = "table table-hover text-xs-center">
                    <thead>
                    <tr>
                        <th style = "text-align: center">Question No.</th>
                        <th style = "text-align: center">Statement</th>
                        <th style = "text-align: center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $i = 1;
                    if ($this->questions) {
                        foreach ($this->questions as $question) {
                            echo '<tr>
                                    <td>' . $i++ . '</td>
                                    <td>' . $question->statement . '</td>
                                    <td>
                                        <form action="/admin/question/delete" method="POST">
                                            <input type="hidden" value="' . $question->_id . '" name="question_id" />
                                            <input type="hidden" name="token" id="token" value="' . $this->request_token . '"/>
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>        
                                    </td>
                              </tr>';
                        }
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>