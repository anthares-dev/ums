<?php
// Helpers
$orderDirClass = $orderDir;
$orderDir = $orderDir === 'ASC' ? 'DESC' : 'ASC';

?>


<table class="table table-striped table-dark table-bordered">

    <thead>
        <tr>
            <th colspan="8" class="text-center">TOTAL USERS <?=$totalUsers?> - Page <?=$page?> of <?=$numPages?>
            </th>
        </tr>
        <tr>
            <th class="<?=$orderBy === 'id' ? $orderDirClass : ''?>">
                <a href="<?=$pageUrl?>?<?=$orderByQueryString?>&orderDir=<?=$orderDir?>&orderBy=id">
                    ID</a>
            </th>
            <th class="<?=$orderBy === 'username' ? $orderDirClass : ''?>">
                <a href="<?=$pageUrl?>?<?=$orderByQueryString?>&orderDir=<?=$orderDir?>&orderBy=username">
                    NAME
                </a>
            </th>
            <th class="<?=$orderBy === 'roletype' ? $orderDirClass : ''?>">
                <a href="<?=$pageUrl?>?<?=$orderByQueryString?>&orderDir=<?=$orderDir?>&orderBy=roletype">
                    ROLE</a>
            </th>
            <th>
                AVATAR
            </th>
            <th class="<?=$orderBy === 'fiscalcode' ? $orderDirClass : ''?>">
                <a href="<?=$pageUrl?>?<?=$orderByQueryString?>&orderDir=<?=$orderDir?>&orderBy=fiscalcode">
                    FISCAL CODE</a>
            </th>
            <th class="<?=$orderBy === 'email' ? $orderDirClass : ''?>">
                <a href="<?=$pageUrl?>?<?=$orderByQueryString?>&orderDir=<?=$orderDir?>&orderBy=email">
                    EMAIL
                </a>
            </th>
            <th class="<?=$orderBy === 'age' ? $orderDirClass : ''?>">
                <a href="<?=$pageUrl?>?<?=$orderByQueryString?>&orderDir=<?=$orderDir?>&orderBy=age">
                    AGE
                </a>
            </th>

            <th>&nbsp;</th>
        </tr>
    </thead>

    <tbody>
        <?php
if ($users) {

    $webAvatarDir = getConfig('webAvatarDir');
    $avatarDir = getConfig('avatarDir');
    $thumbWidth = getConfig('thumbNail_width');

    foreach ($users as $user) {
        $avatarThumbImg = $user['avatar'] && file_exists($avatarDir . 'thumb_' . $user['avatar']) ? $webAvatarDir . 'thumb_' . $user['avatar'] : $webAvatarDir . 'placeholder.jpg';
        $avatarPreviewImg = $user['avatar'] && file_exists($avatarDir . 'preview_' . $user['avatar']) ? $webAvatarDir . 'preview_' . $user['avatar'] : '';
        $avatarBigImg = $user['avatar'] && file_exists($avatarDir . $user['avatar']) ? $webAvatarDir . $user['avatar'] : '';

        ?>
        <tr>
            <td><?=$user['id']?></td>
            <td><?=$user['username']?></td>
            <td><?=$user['roletype']?></td>
            <td>
                <?php if ($avatarBigImg): ?>
                <a href="<?=$avatarBigImg?>" target="_blank" class="thumbnail">
                    <img src="<?=$avatarThumbImg?>" alt="" width="80" class="avatar" />
                    <?php if ($avatarPreviewImg): ?>
                    <span><img src="<?=$avatarPreviewImg?>" alt="" class="avatar" /></span>
                    <?php endif;?>
                </a>
                <?php else: ?><img src="<?=$avatarThumbImg?>" alt="" width="80" />
                <?php endif;?>

            </td>
            <td><?=$user['fiscalcode']?></td>
            <td> <a href="mailto:<?=$user['email']?>"><?=$user['email']?></a> </td>
            <td><?=$user['age']?></td>
            <td>
                <div class="row">
                    <?php if (userCanUpdate()): ?>
                    <div class="col-6">
                        <a class="btn btn-success"
                            href="<?=$updateUrl?>?<?=$navOrderByQueryString?>&page=<?=$page?>&id=<?=$user['id']?>&action=update">
                            <i class="fa fa-pen"></i>
                            UPDATE
                        </a>
                    </div>
                    <?php endif;?>

                    <?php if (userCanDelete()): ?>
                    <div class="col-6">
                        <a onclick="return confirm('DELETE USER?')" class=" btn btn-danger"
                            href="
                            <?=$deleteUserUrl?>?<?=$navOrderByQueryString?>&page=<?=$page?>&id=<?=$user['id']?>&action=delete">
                            <i class="fa fa-trash"></i>
                            DELETE
                        </a>
                    </div>
                    <?php endif;?>
                </div>

            </td>
        </tr>
        <?php
}
    ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="6" class="text-center">
                <?php
require_once 'navigation.php';
    ?>
        </tr>
        </td>
    </tfoot>
    <?php
} else {
    echo '<tr>
        <td colspan="6" class="text-center">
            <h4> No Records found</h4>
        </td>
    </tr>';
}
?>

</table>