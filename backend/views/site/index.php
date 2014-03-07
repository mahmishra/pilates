<div id='wrap'>
    <div id="page-heading">
        <h1>Dashboard</h1>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-3 col-xs-12 col-sm-6">
                        <a class="info-tiles tiles-toyo" href="<?= Yii::$app->urlManager->createUrl('business/index') ?>">
                            <div class="tiles-heading">Businesses</div>
                            <div class="tiles-body-alt">
                                <i class="fa fa-bar-chart-o"></i>
                                <div class="text-center"><?= $totalBusiness ?></div>
                                <small><?= $percentageBusiness ?>% from last period</small>
                            </div>
                            <div class="tiles-footer">manage business</div>
                        </a>
                    </div>
                    <div class="col-md-3 col-xs-12 col-sm-6">
                        <a class="info-tiles tiles-orange" href="<?= Yii::$app->urlManager->createUrl('member/index') ?>">
                            <div class="tiles-heading">Members</div>
                            <div class="tiles-body-alt">
                                <i class="fa fa-group"></i>
                                <div class="text-center"><?= $totalMembers ?></div>
                                <small><?= $percentageMember ?>% from last period</small>
                            </div>
                            <div class="tiles-footer">manage members</div>
                        </a>
                    </div>
                    <div class="col-md-3 col-xs-12 col-sm-6">
                        <a class="info-tiles tiles-success" href="#">
                            <div class="tiles-heading">Points</div>
                            <div class="tiles-body-alt">
                                <!--i class="fa fa-money"></i-->
                                <div class="text-center"><span class="text-top">$</span>22.7<span class="text-smallcaps">k</span></div>
                                <small>-13.5% from last week</small>
                            </div>
                            <div class="tiles-footer">go to loyalty</div>
                        </a>
                    </div>
                    <div class="col-md-3 col-xs-12 col-sm-6">
                        <a class="info-tiles tiles-alizarin" href="#">
                            <div class="tiles-heading">Revenue</div>
                            <div class="tiles-body-alt">
                                <i class="fa fa-money"></i>
                                <div class="text-center">237K</div>
                                <small>+23% from last week</small>
                            </div>
                            <div class="tiles-footer">go to accounting</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-info">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12 clearfix">
                                <h4 class="pull-left" style="margin: 0 0 20px;">Member Report <small>(weekly)</small></h4>
                                <div class="btn-group pull-right">
                                    <a href="javascript:;" class="btn btn-default btn-sm active">this week</a>
                                    <a href="javascript:;" class="btn btn-default btn-sm ">previous week</a>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div id="site-statistics" style="height:250px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-grape">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12 clearfix">
                                <h4 class="pull-left" style="margin: 0 0 20px;">Point &amp; Sales <small>(by quarter)</small></h4>
                                <div class="btn-group pull-right">
                                    <a href="javascript:;" class="btn btn-default btn-sm active">2012</a>
                                    <a href="javascript:;" class="btn btn-default btn-sm ">2011</a>
                                    <a href="javascript:;" class="btn btn-default btn-sm ">2010</a>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div id="budget-variance" style="height:250px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12 clearfix">
                                <h4 class="pull-left" style="margin:0 0 10px">Member Reports <small>(overview)</small></h4>
                                <div class="pull-right">
                                    <button class="btn btn-default" id="daterangepicker2">
                                        <i class="fa fa-calendar-o"></i> 
                                        <span class="hidden-xs hidden-sm">October 28, 2013 - November 27, 2013</span> <b class="caret"></b>
                                    </button>
                                    <a href='#' class="btn btn-default dropdown-toggle" data-toggle='dropdown'><i class="fa fa-cloud-download"></i><span class="hidden-xs hidden-sm hidden-md"> Export as</span> <span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">Text File (*.txt)</a></li>
                                        <li><a href="#">Excel File (*.xlsx)</a></li>
                                        <li><a href="#">PDF File (*.pdf)</a></li>
                                    </ul>
                                    <a href="javascript:;" class="btn btn-default-alt btn-sm"><i class="fa fa-refresh"></i></a>
                                    <a href="javascript:;" class="btn btn-default-alt btn-sm"><i class="fa fa-wrench"></i></a>
                                    <a href="javascript:;" class="btn btn-default-alt btn-sm"><i class="fa fa-cog"></i></a>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-2">
                                <div id="indexvisits" style="width: 90px; margin: 0 auto; padding: 10px 0 6px;"><canvas width="90" height="45" style="display: inline-block; width: 90px; height: 45px; vertical-align: top;"></canvas></div>
                                <h3 style="text-align: center; margin: 0; color: #808080;">7,451</h3>
                                <p style="text-align: center; margin: 0;">Visits</p>
                                <hr class="hidden-md hidden-lg">
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-2">
                                <div id="indexpageviews" style="width: 90px; margin: 0 auto; padding: 10px 0 6px;"><canvas width="90" height="45" style="display: inline-block; width: 90px; height: 45px; vertical-align: top;"></canvas></div>
                                <h3 style="text-align: center; margin: 0; color: #808080;">35,711</h3>
                                <p style="text-align: center; margin: 0;">Page Views</p>
                                <hr class="hidden-md hidden-lg">
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-2">
                                <div id="indexpagesvisit" style="width: 90px; margin: 0 auto; padding: 10px 0 6px;"><canvas width="90" height="45" style="display: inline-block; width: 90px; height: 45px; vertical-align: top;"></canvas></div>
                                <h3 style="text-align: center; margin: 0; color: #808080;">6.92</h3>
                                <p style="text-align: center; margin: 0;">Pages / Visit</p>
                                <hr class="hidden-md hidden-lg">
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-2">
                                <div id="indexavgvisit" style="width: 90px; margin: 0 auto; padding: 10px 0 6px;"><canvas width="90" height="45" style="display: inline-block; width: 90px; height: 45px; vertical-align: top;"></canvas></div>
                                <h3 style="text-align: center; margin: 0; color: #808080;">00:04:17</h3>
                                <p style="text-align: center; margin: 0;">Average Visit Time</p>
                                <hr class="hidden-md hidden-lg">
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-2">
                                <div id="indexnewvisits" style="width: 90px; margin: 0 auto; padding: 10px 0 6px;"><canvas width="90" height="45" style="display: inline-block; width: 90px; height: 45px; vertical-align: top;"></canvas></div>
                                <h3 style="text-align: center; margin: 0; color: #808080;">71.27%</h3>
                                <p style="text-align: center; margin: 0;">New Visits</p>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-2">
                                <div id="indexbouncerate" style="width: 90px; margin: 0 auto; padding: 10px 0 6px;"><canvas width="90" height="45" style="display: inline-block; width: 90px; height: 45px; vertical-align: top;"></canvas></div>
                                <h3 style="text-align: center; margin: 0; color: #808080;">31.08%</h3>
                                <p style="text-align: center; margin: 0;">Bounce Rate</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-inverse">
                    <div class="panel-heading">
                        <h4><i class="icon-highlight fa fa-calendar"></i> Calendar</h4>
                        <div class="options">
                            <a href="javascript:;"><i class="fa fa-cog"></i></a>
                            <a href="javascript:;"><i class="fa fa-wrench"></i></a> 
                            <a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
                        </div>
                    </div>
                    <div class="panel-body" id="calendardemo">
                        <div id='calendar-drag'></div>
                    </div>
                </div>
            </div>
        </div>

    </div> <!-- container -->

</div> <!--wrap -->
