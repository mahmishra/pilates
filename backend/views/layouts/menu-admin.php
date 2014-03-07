<li><a href="<?= Yii::$app->homeUrl ?>dashboard/index/"><i class="fa fa-home"></i> <span>Dashboard</span></a></li>
<li>
    <a href="#"><i class="fa fa-plane"></i> <span>Users</span></a>
    <ul class="acc-menu">
        <li><a href="<?= Yii::$app->urlManager->createUrl('user/index'); ?>"><span>All</span></a></li>
        <li><a href="<?= Yii::$app->urlManager->createUrl('user/admin'); ?>"><span>Admin</span></a></li>
        <li><a href="<?= Yii::$app->urlManager->createUrl('user/branch'); ?>"><span>Branch</span></a></li>
        <li><a href="<?= Yii::$app->urlManager->createUrl('user/instructure'); ?>"><span>Instructure</span></a></li>
        <li><a href="<?= Yii::$app->urlManager->createUrl('role/index'); ?>"><span>Roles</span></a></li>
    </ul>
</li>