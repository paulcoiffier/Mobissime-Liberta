<h2><?php echo $lang_strings['title_database']; ?></h2>

<div class="row">
    <div class="col-lg-2">
        <div class="form-group">
            <label><?php echo $lang_strings['database_sgbd']; ?> *</label>
            <select class="form-control" name="database_sgbd" id="database_sgbd">
                <option value="mysql">MySQL</option>
                <option value="oracle">Oracle</option>
                <option value="sqlserver">SQL Server</option>
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-2">
        <div class="form-group">
            <label><?php echo $lang_strings['database_server']; ?> *</label>
            <input id="database_server" name="database_server" type="text" value="localhost"
                   class="form-control required">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-2">
        <div class="form-group">
            <label><?php echo $lang_strings['database_user']; ?> *</label>
            <input id="database_user" name="database_user" type="text" value="root"
                   class="form-control required">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-2">
        <div class="form-group">
            <label><?php echo $lang_strings['database_password']; ?> *</label>
            <input id="database_password" name="database_password" type="password" value="password"
                   class="form-control required">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-2">
        <div class="form-group">
            <label><?php echo $lang_strings['database_database']; ?> *</label>
            <input id="database_database" name="database_database" type="text" value="mycrm"
                   class="form-control required">
        </div>
    </div>
</div>
<div id="databaseError" name="databaseError"></div>