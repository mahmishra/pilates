<?php

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use backend\assets\AppAsset;
use common\models\Role;

/**
 * @var \yii\web\View $this
 * @var string $content
 */
appAsset::register($this);
//var_dump(Yii::$app->user->identity);exit;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <?php $this->head() ?>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <title><?= Html::encode($this->title) ?></title>
        <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600' rel='stylesheet' type='text/css'>
        <link href='<?= Yii::$app->homeUrl ?>demo/variations/default.css' rel='stylesheet' type='text/css' media='all' id='styleswitcher'> 
        <link href='<?= Yii::$app->homeUrl ?>demo/variations/default.css' rel='stylesheet' type='text/css' media='all' id='headerswitcher'> 
        <link rel='stylesheet' type='text/css' href='<?= Yii::$app->homeUrl ?>plugins/form-daterangepicker/daterangepicker-bs3.css' /> 
        <link rel='stylesheet' type='text/css' href='<?= Yii::$app->homeUrl ?>plugins/fullcalendar/fullcalendar.css' /> 
        <link rel='stylesheet' type='text/css' href='<?= Yii::$app->homeUrl ?>plugins/form-markdown/css/bootstrap-markdown.min.css' /> 
        <link rel='stylesheet' type='text/css' href='<?= Yii::$app->homeUrl ?>plugins/codeprettifier/prettify.css' /> 
        <link rel='stylesheet' type='text/css' href='<?= Yii::$app->homeUrl ?>plugins/form-toggle/toggles.css' /> 
        <link rel='stylesheet' type='text/css' href='<?= Yii::$app->homeUrl ?>plugins/datatables/dataTables.css' /> 
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <script type='text/javascript' src='<?= Yii::$app->homeUrl ?>js/jquery-2.0.3.min.js'></script> 
        <script type='text/javascript' src='<?= Yii::$app->homeUrl ?>js/bootstrap.min.js'></script> 
        <script type='text/javascript' src='<?= Yii::$app->homeUrl ?>js/enquire.js'></script> 
        <script type='text/javascript' src='<?= Yii::$app->homeUrl ?>js/jquery.cookie.js'></script> 
        <script type='text/javascript' src='<?= Yii::$app->homeUrl ?>js/jquery.nicescroll.min.js'></script> 
        <script type='text/javascript' src='<?= Yii::$app->homeUrl ?>plugins/codeprettifier/prettify.js'></script> 
        <script type='text/javascript' src='<?= Yii::$app->homeUrl ?>plugins/easypiechart/jquery.easypiechart.min.js'></script> 
        <script type='text/javascript' src='<?= Yii::$app->homeUrl ?>plugins/sparklines/jquery.sparklines.min.js'></script> 
        <script type='text/javascript' src='<?= Yii::$app->homeUrl ?>plugins/form-toggle/toggle.min.js'></script> 
        <script type='text/javascript' src='<?= Yii::$app->homeUrl ?>plugins/fullcalendar/fullcalendar.min.js'></script>
        <script type='text/javascript' src='<?= Yii::$app->homeUrl ?>plugins/pulsate/jQuery.pulsate.min.js'></script> 
        <script type='text/javascript' src='<?= Yii::$app->homeUrl ?>js/placeholdr.js'></script>
        <script type='text/javascript' src='<?= Yii::$app->homeUrl ?>js/application.js'></script>
        <!--<script type='text/javascript' src='<?= Yii::$app->homeUrl ?>demo/demo.js'></script>-->
        <link rel="stylesheet" href="<?= Yii::$app->homeUrl ?>css/styles.css?=120">
    </head>

    <body>
        <?php $this->beginBody() ?>
        <div id="headerbar">
            <div class="container">
                <div class="row">
                    <div class="col-xs-6 col-sm-2">
                        <a href="#" class="shortcut-tiles tiles-brown">
                            <div class="tiles-body">
                                <div class="pull-left"><i class="fa fa-pencil"></i></div>
                            </div>
                            <div class="tiles-footer">Create Post</div>
                        </a>
                    </div>
                    <div class="col-xs-6 col-sm-2">
                        <a href="#" class="shortcut-tiles tiles-grape">
                            <div class="tiles-body">
                                <div class="pull-left"><i class="fa fa-group"></i></div>
                                <div class="pull-right"><span class="badge">2</span></div>
                            </div>
                            <div class="tiles-footer">Contacts</div>
                        </a>
                    </div>
                    <div class="col-xs-6 col-sm-2">
                        <a href="#" class="shortcut-tiles tiles-primary">
                            <div class="tiles-body">
                                <div class="pull-left"><i class="fa fa-envelope-o"></i></div>
                                <div class="pull-right"><span class="badge">10</span></div>
                            </div>
                            <div class="tiles-footer">Messages</div>
                        </a>
                    </div>
                    <div class="col-xs-6 col-sm-2">
                        <a href="#" class="shortcut-tiles tiles-inverse">
                            <div class="tiles-body">
                                <div class="pull-left"><i class="fa fa-camera"></i></div>
                                <div class="pull-right"><span class="badge">3</span></div>
                            </div>
                            <div class="tiles-footer">Gallery</div>
                        </a>
                    </div>
                    <div class="col-xs-6 col-sm-2">
                        <a href="#" class="shortcut-tiles tiles-midnightblue">
                            <div class="tiles-body">
                                <div class="pull-left"><i class="fa fa-cog"></i></div>
                            </div>
                            <div class="tiles-footer">Settings</div>
                        </a>
                    </div>
                    <div class="col-xs-6 col-sm-2">
                        <a href="#" class="shortcut-tiles tiles-orange">
                            <div class="tiles-body">
                                <div class="pull-left"><i class="fa fa-wrench"></i></div>
                            </div>
                            <div class="tiles-footer">Plugins</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <header class="navbar navbar-inverse navbar-fixed-top" role="banner">
            <a id="leftmenu-trigger" class="tooltips" data-toggle="tooltip" data-placement="right" title="Toggle Sidebar"></a>
            <a id="rightmenu-trigger" class="tooltips" data-toggle="tooltip" data-placement="left" title="Toggle Infobar"></a>

            <div class="navbar-header pull-left">
                <a class="navbar-brand" href="<?= Yii::$app->homeUrl ?>">Ebizu</a>
            </div>

            <ul class="nav navbar-nav pull-right toolbar">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle username" data-toggle="dropdown">
                        <span class="hidden-xs"><?php echo $usr_name = Yii::$app->user->identity->username   ?> <i class="fa fa-caret-down"></i></span>
                        <img src="<?= Yii::$app->homeUrl ?>demo/avatar/dangerfield.png" alt="Dangerfield" />
                    </a>
                    <ul class="dropdown-menu userinfo arrow">
                        <li class="username">
                            <a href="#">
                                <div class="pull-left"><img class="userimg" src="<?= Yii::$app->homeUrl ?>demo/avatar/dangerfield.png" alt="Jeff Dangerfield"/></div>
                                <div class="pull-right">
                                    <h5>Howdy, <?php echo $usr_name ?>!</h5>
                                    <small>Logged in as <span><?php echo Yii::$app->user->identity->username   ?></span></small>
                                </div>
                            </a>
                        </li>
                        <li class="userlinks">
                            <ul class="dropdown-menu">
                                <li><a href="<?= Yii::$app->urlManager->createUrl('user/profile', ['id' => 3]) ?>">Edit Profile <i class="pull-right fa fa-pencil"></i></a></li>
                                <li><a href="<?= Yii::$app->urlManager->createUrl('user/account', ['id' => 3]) ?>">Account <i class="pull-right fa fa-cog"></i></a></li>
                                <li><a href="<?= Yii::$app->urlManager->createUrl('help/index') ?>">Help <i class="pull-right fa fa-question-circle"></i></a></li>
                                <li class="divider"></li>
                                <li><a href="<?= Yii::$app->urlManager->createUrl('site/logout') ?>" class="text-right">Sign Out</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="hasnotifications dropdown-toggle" data-toggle='dropdown'><i class="fa fa-bell"></i><span class="badge system-count">0</span></a>
                    <ul class="dropdown-menu messages arrow">
                        <li class="dd-header">
                            <span>You have <i id="system-count">0</i> new notify</span>
                            <span><a href="#">Mark all Done</a></span>
                        </li>
                        <div id="system-list" class="scrollthis">
                            <li class="dd-footer"><a href="<?= Yii::$app->urlManager->createUrl('system/index') ?>">View All Notification</a></li>
                        </div>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="hasnotifications dropdown-toggle" data-toggle='dropdown'>
                        <i class="fa fa-check"></i><span class="badge task-count">0</span>
                    </a>
                    <ul class="dropdown-menu messages arrow">
                        <li class="dd-header">
                            <span>You have <i id="task-count">0</i> new task(s)</span>
                            <span><a href="#">Mark all Done</a></span>
                        </li>
                        <div id="task-list" class="scrollthis">
                        </div>
                        <li class="dd-footer"><a href="<?= Yii::$app->urlManager->createUrl('task/index') ?>">View All Task</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="hasnotifications dropdown-toggle" data-toggle='dropdown'><i class="fa fa-envelope"></i><span class="badge message-count">0</span></a>
                    <ul class="dropdown-menu messages arrow">
                        <li class="dd-header">
                            <span>You have <i class="message-count">0</i> new message(s)</span>
                            <span><a href="#">Mark all Read</a></span>
                        </li>
                        <div id="message-list" class="scrollthis">
                        </div>
                        <li class="dd-footer"><a href="<?= Yii::$app->urlManager->createUrl('message/index') ?>">View All Messages</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="hasnotifications dropdown-toggle" data-toggle='dropdown'><i class="fa fa-bug"></i><span class="badge bug-count">0</span></a>
                    <ul class="dropdown-menu notifications arrow">
                        <li class="dd-header">
                            <span>You have <i class="bug-count">0</i> new bug(s)</span>
                            <span><a href="#">Mark all Done</a></span>
                        </li>
                        <div id="bug-list" class="scrollthis">
                        </div>
                        <li class="dd-footer"><a href="<?= Yii::$app->urlManager->createUrl('bug/index') ?>">View All Bugs</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#" id="headerbardropdown"><span><i class="fa fa-level-down"></i></span></a>
                </li>
                <li class="dropdown demodrop">
                    <a href="#" class="dropdown-toggle tooltips" data-toggle="dropdown"><i class="fa fa-magic"></i></a>
                    <ul class="dropdown-menu arrow dropdown-menu-form" id="demo-dropdown">
                        <li>
                            <label for="demo-header-variations" class="control-label">Header Colors</label>
                            <ul class="list-inline demo-color-variation" id="demo-header-variations">
                                <li><a class="color-black" href="javascript:;"  data-headertheme="header-black.css"></a></li>
                                <li><a class="color-dark" href="javascript:;"  data-headertheme="default.css"></a></li>
                                <li><a class="color-red" href="javascript:;" data-headertheme="header-red.css"></a></li>
                                <li><a class="color-blue" href="javascript:;" data-headertheme="header-blue.css"></a></li>
                            </ul>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <label for="demo-color-variations" class="control-label">Sidebar Colors</label>
                            <ul class="list-inline demo-color-variation" id="demo-color-variations">
                                <li><a class="color-lite" href="javascript:;"  data-theme="default.css"></a></li>
                                <li><a class="color-steel" href="javascript:;" data-theme="sidebar-steel.css"></a></li>
                                <li><a class="color-lavender" href="javascript:;" data-theme="sidebar-lavender.css"></a></li>
                                <li><a class="color-green" href="javascript:;" data-theme="sidebar-green.css"></a></li>
                            </ul>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <label for="fixedheader">Fixed Header</label>
                            <div id="fixedheader" style="margin-top:5px;"></div> 
                        </li>
                    </ul>
                </li>
            </ul>
        </header>

        <div id="page-container">
            <!-- BEGIN SIDEBAR -->
            <nav id="page-leftbar" role="navigation">
                <!-- BEGIN SIDEBAR MENU -->
                <ul class="acc-menu" id="sidebar">
                    <li id="search">
                        <a href="javascript:;"><i class="fa fa-search opacity-control"></i></a>
                        <form>
                            <input type="text" class="search-query" placeholder="Search...">
                            <button type="submit"><i class="fa fa-search"></i></button>
                        </form>
                    </li>
                    <li class="divider"></li>
                    <?php 
                    switch (Yii::$app->user->identity->role_id){
                        case Role::ADMIN :
                            echo Yii::$app->controller->renderPartial('//layouts/menu-admin');
                            break;
                        case Role::BRANCH :
                            echo Yii::$app->controller->renderPartial('//layouts/menu-branch');
                            break;
                    }
                    ?>
                </ul>
                <!-- END SIDEBAR MENU -->
            </nav>

            <!-- BEGIN RIGHTBAR -->
            <div id="page-rightbar">

                <div id="chatbar" class="widget">
                    <div class="widget-heading">
                        <a href="javascript:;" data-toggle="collapse" data-target="#chatbody"><h4>Online Contacts <small>( <span class="user-count">0</span> )</small></h4></a>
                    </div>
                    <div class="widget-body collapse in" id="chatbody">
                        <ul id="chat-users" class="chat-users">
                        </ul>
                        <span class="more"><a href="#">See all</a></span>
                    </div>
                </div>

            </div>
            <!-- END RIGHTBAR -->

            <div id="page-content">

                <?= $content ?>

            </div>

            <footer role="contentinfo">
                <div class="clearfix">
                    <ul class="list-unstyled list-inline pull-left">
                        <li>Ebizu &copy; 2013 - <?= date("Y") ?></li>
                    </ul>
                    <button class="pull-right btn btn-inverse-alt btn-xs hidden-print" id="back-to-top"><i class="fa fa-arrow-up"></i></button>
                </div>
            </footer>

        </div> <!-- page-container -->
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>