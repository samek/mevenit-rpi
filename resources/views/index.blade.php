<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="img/favicon.ico">

    <title>MEVEN.IT | Device Setup</title>

    <!-- Bootstrap core CSS -->
    <link href="css/style.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>>
    <![endif]-->
</head>

<body>

<nav class="navbar navbar-default navbar-fixed-top br-none">
    <div class="navbar-header text-center">
        <a class="navbar-brand visible-xs" href="#">
            DEVICE <strong>SETUP</strong>
        </a>
    </div>
    <div id="navbar" class=" navbar-collapse">
        <div class="navbar-head">
            <div class="row">
                <div class="col-sm-5 hidden-xs">
                    <h1 class="m-none">DEVICE <strong>SETUP</strong></h1>
                </div>
                @if ($connected === 1)
                    <div class="col-sm-7">
                        <div class="text-center visible-xs">
                            <strong class="text-success"><i class="icon-check ml-10 mr-10"></i>Your device is connected</strong>
                        </div>
                        <div class="mt-5 text-right hidden-xs">
                            <span class="text-muted">Status:</span> <strong class="text-success text-150"><i class="icon-check ml-10 mr-10"></i>Your device is connected</strong>
                        </div>
                    </div>
                @else
                    <div class="col-sm-7">
                        <div class="text-center visible-xs">
                            <strong class="text-warning"><i class="fa fa-close ml-10 mr-10"></i>Your device is not connected</strong>
                        </div>
                        <div class="mt-5 text-right hidden-xs">
                            <span class="text-muted">Status:</span> <strong class="text-warning text-150"><i class="fa fa-close ml-10 mr-10"></i>Your device is not connected</strong>
                        </div>
                    </div>
                @endif




            </div>
        </div>
    </div>
</nav>

<div class="container">
    <div class="device-options clearfix">
        <div class="pull-left">
            <h4 class="m-none">
						<span>
							WiFi IP: <strong>{{ $wlan0 }}</strong>
						</span>
						<span class="ml-10">
							LAN IP: <strong>{{ $eth0 }}</strong>
						</span>
            </h4>
        </div>
        <hr class="visible-sm visible-xs" />
        <div class="pull-right">
            <a class="btn btn-default round" href=""><i class="fa fa-info mr-5 hidden-xs"></i>
                Info</a>
            <a class="btn btn-default round" href=""><i class="fa fa-refresh mr-5 hidden-xs"></i>
                Reboot Device</a>
            <a class="btn btn-default round" href=""><i class="fa fa-upload mr-5 hidden-xs"></i>
                Update Device</a>
            <a class="btn btn-default round" href=""><i class="fa fa-globe mr-5 hidden-xs"></i>
                Reset Network</a>
            <a class="btn btn-primary round" href=""><i class="fa fa-exclamation-triangle mr-5 hidden-xs"></i>
                Factory Reset</a>
        </div>
    </div>
    <hr class="mb-60" />
    <div class="row">
        <div class="col-xs-8 col-xs-offset-2">
            <div class="row">
                <div class="col-md-6">
                    <div>
                        <div class="row mb-20">
                            <div class="col-sm-8">
                                <h3 class="m-none"><strong>Wired</strong> Network</h3>
                            </div>
                            <hr class="visible-xs" />
                            <div class="col-sm-4 cleafix">
                                <div class="clearfix pull-right">
                                    <div class="pull-left">
                                        <small class="text-primary mr-5">Enabled</small>
                                    </div>
                                    <label class="i-switch pull-left">
                                        <input type="checkbox" id="eth0_enabled" checked="">
                                        <i></i>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <hr class="visible-xs" />
                        <form class="form-horizontal">
                            <div class="form-group">
                                <label for="" class="col-sm-4 control-label text-light">DHCP</label>
                                <div class="col-sm-8">
                                    <small>If you use dhcp leave the rest empty</small>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="col-sm-4 control-label text-light">IP</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="eth0_ip" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-4 control-label text-light">Netmask</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="eth0_netmask" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-4 control-label text-light">Gateway</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="eth0_gateway" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-4 control-label text-light">Dns1</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="eth0_dns1" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-4 control-label text-light">Dns2</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="eth0_dns2" placeholder="">
                                </div>
                            </div>
                        </form>
                    </div>
                    <hr class="mt-40 mb-40" />
                    <div>
                        <div class="row mb-20">
                            <div class="col-sm-8">
                                <h3 class="m-none"><strong>Wireless</strong> Network</h3>
                            </div>
                            <hr class="visible-xs" />
                            <div class="col-sm-4 cleafix">
                                <div class="clearfix pull-right">
                                    <div class="pull-left">
                                        <small class="text-muted mr-5">Disabled</small>
                                    </div>
                                    <label class="i-switch pull-left">
                                        <input type="checkbox">
                                        <i></i>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <hr class="visible-xs" />
                        <form class="form-horizontal">
                            <div class="form-group">
                                <label for="" class="col-sm-4 control-label text-light">Wireless</label>
                                <div class="col-sm-8">
                                    <div class="btn-group text-left">
                                        <button type="button" class="btn btn-default dropdown-toggle form-control" data-toggle="dropdown">
                                            Choose your network <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="#">Kukulele</a></li>
                                            <li><a href="#">Kukulele</a></li>
                                            <li><a href="#">Kukulele</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-4 control-label text-light">Network</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="#" placeholder="" disabled="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-4 control-label text-light">WP</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="#" placeholder="" disabled="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-4 control-label text-light">Password</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="#" placeholder="" disabled="">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-8 col-sm-offset-4">
                                    <div class="checkbox">
                                        <label class="i-checks">
                                            <input type="checkbox"><i></i> <small>Show password while typing</small>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <hr class="visible-xs" />
                <div class="col-md-5 col-md-offset-1">
                    <h3 class="m-none mb-20">Your <strong>Account</strong></h3>
                    <p>Coonect device with Your meven.it account.</p>
                    <a class="btn btn-primary" href="#"><i class="icon-user mr-5"></i>Connect Your account</a>
                </div>
                <hr class="visible-xs mt-40" />
            </div>
        </div>
    </div>
</div>

<footer class="footer">
    <div class="footer-content clearfix">
        <div class="pull-left hidden-xs">
            <small class="text-muted block mt-20">
                ©2015 <strong>meven</strong>.it
            </small>
        </div>
        <div class="pull-right">
            <a class="btn btn-default" href="#"><i class="fa fa-close mr-5"></i>CANCEL</a><a class="btn btn-primary ml-10" href="#"><i class="fa fa-check mr-5"></i>SAVE</a>
        </div>
    </div>
</footer>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="js/ie10-viewport-bug-workaround.js"></script>
</body>
</html>