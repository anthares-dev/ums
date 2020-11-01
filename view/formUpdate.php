<form enctype="multipart/form-data" id="updateForm" action="controller/updateRecord.php?<?=$defaultParams?>"
    method="post">
    <div class="form-group row">
        <input type="hidden" name="id" value="<?=$user['id']?>">
        <input type="hidden" name="action" value="<?=$user['id'] ? 'store' : 'save'?>">

        <label for="username" class="col-sm-2 col-form-label">Username</label>
        <div class="col-sm-10">
            <input type="text" class="form-control form-control-lg" name="username" id="username" placeholder="Username"
                value="<?=$user['username']?>" required>
        </div>
    </div>
    <div class="form-group row">
        <label for="email" class="col-sm-2 col-form-label">Email</label>
        <div class="col-sm-10">
            <input type="email" class="form-control form-control-lg" name="email" id="email" placeholder="Email"
                value="<?=$user['email']?>" required>
        </div>
    </div>
    <div class="form-group row">
        <label for="fiscalcode" class="col-sm-2 col-form-label">Fiscal Code</label>
        <div class="col-sm-10">
            <input type="text" class="form-control form-control-lg" name="fiscalcode" id="fiscalcode"
                placeholder="Fiscal Code" value="<?=$user['fiscalcode']?>" required>
        </div>
    </div>
    <div class="form-group row">
        <label for="age" class="col-sm-2 col-form-label">Age</label>
        <div class="col-sm-10">
            <input type="number" min="0" max="120" class="form-control form-control-lg" name="age" id="age"
                value="<?=$user['age']?>" required>
        </div>
    </div>

    <div class="form-group row">
        <label for="avatar" class="col-sm-2 col-form-label">Avatar</label>
        <div class="col-sm-10">
            <input type="hidden" name="MAX_FILE_SIZE" value="<?=getConfig('maxFileUpload')?>" />
            <input onchange="previewFile()" type="file" class="form-control form-control-lg" name="avatar" id="avatar"
                accept="image/*" required />
        </div>
    </div>

    <div class="form-group row">
        <label for="avatar" class="col-sm-2 col-form-label">Upload preview</label>
        <?php
$webAvatarDir = getConfig('webAvatarDir');
$avatarDir = getConfig('avatarDir');
$thumbWidth = getConfig('thumbNail_width');
$avatarImg = file_exists($avatarDir . 'thumb_' . $user['avatar']) ? $webAvatarDir . 'thumb_' . $user['avatar'] : $webAvatarDir . 'placeholder.jpg';
?>
        <div class="col-sm-10">
            <img src="<?=$avatarImg?>" width="<?=$thumbWidth?>" alt="" id="thumbnail" />
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-2">

        </div>
        <div class="col-sm-2">
            <button class="btn btn-success">

                <i class="fa fa-pen"></i>
                <?=$user['id'] ? 'UPDATE' : 'INSERT'?>

            </button>
        </div>
        <div class="col-sm-2">
            <?php
if ($user['id']) {
    ?>
            <a href="<?=$deleteUserUrl?>?id=<?=$user['id']?>&action=delete" onclick="return confirm('DELETE USER?')"
                class="btn btn-danger">
                <i class="fa fa-trash"></i>
                DELETE
            </a>
            <?php
}
?>

        </div>
    </div>
</form>