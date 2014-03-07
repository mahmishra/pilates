<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>

<div id='wrap'>
    <div class="container">
        <div class="mall-index" ng-app="pageindex" ng-controller="pageCtrl">
            <h1><i class="fa fa-home"></i> User</h1>
            <p>
                <?= Html::a('<i class="fa fa-plus-square"></i> Create User', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-indigo">
                        <div class="panel-heading">
                            <h4><i class="fa fa-home"></i> User List</h4>
                            <div class="options">
                                <a href="javascript:;"><i class="fa fa-cog"></i></a>
                                <a href="javascript:;"><i class="fa fa-wrench"></i></a>
                                <a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
                            </div>
                        </div>
                        <div class="panel-body collapse in">
                            <input type="text" ng-model="search">
                            <div style="max-height:500px;overflow:auto">
                                <table cellpadding="0" cellspacing="0" border="0" class="table table-striped" id="crudtable">
                                    <thead>
                                        <tr>
                                            <td>Role Id</td> 
                                            <td>Username</td> 
                                            <td>Email</td> 
                                            <td>Registered</td> 
                                            <td>Last Login</td> 
                                            <td>Modified Time</td> 
                                            <td>Is Logged</td> 
                                            <td>First Name</td> 
                                            <td>Last Name</td> 
                                            <th style="width:65px">&nbsp;</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-hover">
                                        <tr ng-repeat="row in rows | filter:search">
                                            <td>{{ row.role_id }}</td> 
                                            <td>{{ row.username }}</td> 
                                            <td>{{ row.email }}</td> 
                                            <td>{{ row.registered }}</td> 
                                            <td>{{ row.last_login }}</td> 
                                            <td>{{ row.modified_time }}</td> 
                                            <td>{{ row.is_logged }}</td> 
                                            <td>{{ row.first_name }}</td> 
                                            <td>{{ row.last_name }}</td> 
                                            <td style="width:90px">
                                                <a data-toggle="modal" href="#detail" class="btn btn-primary btn-xs" ng-click="view({{ row.id }})"><i class="fa fa-caret-square-o-down"></i></a>
                                                <a class="btn btn-primary btn-xs" title="Update" ng-click="update({{ row.id }})"><i class="fa fa-edit"></i></a>
                                                <a class="btn btn-danger btn-xs" ng-click="delete({{ row.id }})"><i class="fa fa-times"></i></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <!-- Modal -->
                                <div class="modal fade" id="detail" tabindex="-1" role="dialog" aria-labelledby="detail" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title">{{ detail.adm_name }}</h4>
                                            </div>
                                            <div class="modal-body">
                                                <table class="table-striped" style="margin-bottom:10px;width:535px">
                                                    <tr>
                                                        <td>Id</td>
                                                        <td>{{ detail.id }}</td>
                                                    </tr> 
                                                    <tr>
                                                        <td>Role Id</td>
                                                        <td>{{ detail.role_id }}</td>
                                                    </tr> 
                                                    <tr>
                                                        <td>Username</td>
                                                        <td>{{ detail.username }}</td>
                                                    </tr> 
                                                    <tr>
                                                        <td>Password</td>
                                                        <td>{{ detail.password }}</td>
                                                    </tr> 
                                                    <tr>
                                                        <td>Email</td>
                                                        <td>{{ detail.email }}</td>
                                                    </tr> 
                                                    <tr>
                                                        <td>Registered</td>
                                                        <td>{{ detail.registered }}</td>
                                                    </tr> 
                                                    <tr>
                                                        <td>Last Login</td>
                                                        <td>{{ detail.last_login }}</td>
                                                    </tr> 
                                                    <tr>
                                                        <td>Modified Time</td>
                                                        <td>{{ detail.modified_time }}</td>
                                                    </tr> 
                                                    <tr>
                                                        <td>Is Logged</td>
                                                        <td>{{ detail.is_logged }}</td>
                                                    </tr> 
                                                    <tr>
                                                        <td>First Name</td>
                                                        <td>{{ detail.first_name }}</td>
                                                    </tr> 
                                                    <tr>
                                                        <td>Last Name</td>
                                                        <td>{{ detail.last_name }}</td>
                                                    </tr> 
                                                    <tr>
                                                        <td>Address</td>
                                                        <td>{{ detail.address }}</td>
                                                    </tr> 
                                                    <tr>
                                                        <td>City</td>
                                                        <td>{{ detail.city }}</td>
                                                    </tr> 
                                                    <tr>
                                                        <td>Postcode</td>
                                                        <td>{{ detail.postcode }}</td>
                                                    </tr> 
                                                    <tr>
                                                        <td>Phone</td>
                                                        <td>{{ detail.phone }}</td>
                                                    </tr> 
                                                </table>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->
                            </div>
                            <!--end table-->
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

<link href="<?= Yii::$app->homeUrl ?>css/xeditable.css" rel="stylesheet">
<script src="<?= Yii::$app->homeUrl ?>js/angular.min.js"></script>
<script src="<?= Yii::$app->homeUrl ?>js/angular-touch.min.js"></script>
<script src="<?= Yii::$app->homeUrl ?>js/xeditable.js"></script>
<script type="text/javascript">
    $('a.panel-collapse').click(function() {
    $(this).children().toggleClass('fa-chevron-down fa-chevron-up');
    $(this).closest('.panel-heading').next().slideToggle({duration: 200});
    $(this).closest('.panel-heading').toggleClass('rounded-bottom');
    return false;
    });

    var app = angular.module('pageindex', ['ngTouch', 'xeditable']).controller('pageCtrl', function($scope, $http) {

    $http.get('<?= Yii::$app->urlManager->createUrl("user/lists/").$role ?>/').success(function(data) {
    $scope.rows = data;
    });
    $scope.view = function(id) {
    $http.get('<?= Yii::$app->urlManager->createUrl("user/view/") ?>' + id + '/').success(function(data) {
    $scope.detail = data;
    });
    };
    $scope.update = function(id) {
    document.location.href = '<?= Yii::$app->urlManager->createUrl("user/update/") ?>' + id + '/';
    };
    $scope.delete = function(id) {
    if (window.confirm('Are you wanna delete this data?')) {
    $http.get('<?= Yii::$app->urlManager->createUrl("user/delete/") ?>' + id + '/').success(function(data) {
    console.log(data);
    });
    $scope.rows.splice($scope.rows.indexOf(id), 1);
    }
    };
    }).directive('errSrc', function() {
    var fallback = {
    link: function(scope, elem, attrs) {
    elem.bind('error', function() {
    angular.element(this).attr('src', attrs.errSrc);
    });
    }
    };
    return fallback;
    }).run(function(editableOptions) {
    editableOptions.theme = 'bs3';
    });
</script>
