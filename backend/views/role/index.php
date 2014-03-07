<?php

use yii\helpers\Html;
use yii\grid\GridView;


$this->title = 'Roles';
$this->params['breadcrumbs'][] = $this->title;
?>

<div id='wrap'>
    <div class="container">
        <div class="mall-index" ng-app="pageindex" ng-controller="pageCtrl">
            <h1><i class="fa fa-home"></i> Role</h1>
            <p>
                <?= Html::a('<i class="fa fa-plus-square"></i> Create Role', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-indigo">
                        <div class="panel-heading">
                            <h4><i class="fa fa-home"></i> Role List</h4>
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
                                            						<td>Id</td> 
						<td>Identity</td> 
						<td>Name</td> 
						<td>Action</td> 
                                            <th style="width:65px">&nbsp;</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-hover">
                                        <tr ng-repeat="row in rows | filter:search">
                                            						<td>{{ row.id }}</td> 
						<td>{{ row.identity }}</td> 
						<td>{{ row.name }}</td> 
						<td>{{ row.action }}</td> 
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
                                                                    <td>Identity</td>
                                                                    <td>{{ detail.identity }}</td>
                                                                 </tr> 
<tr>
                                                                    <td>Name</td>
                                                                    <td>{{ detail.name }}</td>
                                                                 </tr> 
<tr>
                                                                    <td>Action</td>
                                                                    <td>{{ detail.action }}</td>
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
<script>
    $('a.panel-collapse').click(function() {
        $(this).children().toggleClass('fa-chevron-down fa-chevron-up');
        $(this).closest('.panel-heading').next().slideToggle({duration: 200});
        $(this).closest('.panel-heading').toggleClass('rounded-bottom');
        return false;
    });

    var app = angular.module('pageindex', ['ngTouch', 'xeditable']).controller('pageCtrl', function($scope, $http) {

        $http.get('<?= Yii::$app->urlManager->createUrl("role/lists/") ?>').success(function(data) {
            $scope.rows = data;
        });
        $scope.view = function(id) {
            $http.get('<?= Yii::$app->urlManager->createUrl("role/view/") ?>' + id + '/').success(function(data) {
                $scope.detail = data;
            });
        };
        $scope.update = function(id) {
            document.location.href = '<?= Yii::$app->urlManager->createUrl("role/update/") ?>' + id + '/';
        };
        $scope.delete = function(id) {
            if (window.confirm('Are you wanna delete this data?')) {
                $http.get('<?= Yii::$app->urlManager->createUrl("role/delete/") ?>' + id + '/').success(function(data) {
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
