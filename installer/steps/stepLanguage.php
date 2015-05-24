<h2><?php echo $lang_strings['label_language']; ?></h2>

<div class="row">
    <div class="col-lg-2">
        <div class="form-group">
            <select name="language" id="language" class="form-control"
                    onchange="javascript:changeLang()">
                <?php
                if ($lang == "french") {
                    echo '<option value="French" selected>French</option>';
                } else {
                    echo '<option value="French">French</option>';
                }

                if ($lang == "english") {
                    echo '<option value="English" selected>English</option>';
                } else {
                    echo '<option value="English">English</option>';
                }
                ?>
            </select>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="text-center">
            <div style="margin-top: 20px">
                <i class="fa fa-sign-in" style="font-size: 180px;color: #e5e5e5 "></i>
            </div>
        </div>
    </div>
</div>