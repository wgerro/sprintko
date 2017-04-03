<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>Install - sprintKO</title>

        <!-- Fonts -->
        <link href='http://fonts.googleapis.com/css?family=Amiko&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Styles -->
        <link rel="stylesheet" type="text/css" href="{{ asset('css/install.css') }}">
    </head>
    <body>
    <div id="app">
    <form id="formularz" class="form-horizontal" method="POST" action="{{ route('install') }}">
            {{ csrf_field() }}
        <div id="pierwszy-krok" >
            <div  class="container text-center" >
                <img src="{{ asset('nowe_logo_p.png') }}" >
                <h1 class="text-center tytul-database" ><i class="fa fa-database"></i> DATABASE</h1>
                <div class="col-xs-12 col-md-4 col-md-offset-4 col-sm-12 boxik" >
                    
                        <!-- Text input-->
                        <div class="form-group">
                          <label class="col-md-4 control-label" for="textinput">Host</label>  
                          <div class="col-md-8">
                          <input id="textinput" name="host" type="text" placeholder="host" class="form-control input-md">
                          </div>
                        </div>

                        <!-- Text input-->
                        <div class="form-group">
                          <label class="col-md-4 control-label" for="textinput">Port</label>  
                          <div class="col-md-8">
                          <input id="textinput" name="port" type="text" placeholder="port" class="form-control input-md">
                          </div>
                        </div>

                        <!-- Text input-->
                        <div class="form-group">
                          <label class="col-md-4 control-label" for="textinput">Database</label>  
                          <div class="col-md-8">
                          <input id="textinput" name="database" type="text" placeholder="database" class="form-control input-md">
                          </div>
                        </div>

                        <!-- Text input-->
                        <div class="form-group">
                          <label class="col-md-4 control-label" for="textinput">User</label>  
                          <div class="col-md-8">
                          <input id="textinput" name="user" type="text" placeholder="root" class="form-control input-md">
                          </div>
                        </div>

                        <!-- Text input-->
                        <div class="form-group">
                          <label class="col-md-4 control-label" for="textinput">Password</label>  
                          <div class="col-md-8">
                          <input id="textinput" name="db_password" type="password" placeholder="" class="form-control input-md">
                          </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12 text-center">
                                <button class="btn btn-primary" @click="check" ><i class="fa fa-spinner fa-spin fa-fw"></i> Check</button>
                            </div>
                            <div class="alert alert-success col-xs-12" v-if="status == 1" style="background:#1A5500; color:white; margin-top:15px; border-radius:0px;">
                              <strong>Success!</strong> Connection success !
                            </div>
                            <div class="alert alert-danger col-xs-12" v-if="status == 0" style="background:#AB0000; color:white; margin-top:15px; border-radius:0px;">
                              <strong>Warning!</strong> Connection failed !
                            </div>
                        </div>

                    

                </div>
            </div>
        </div>
        <div id="drugi-krok" >
        <div  class="container ukryj-drugi-krok-div" >
                <h1 class="text-center tytul-database" ><i class="fa fa-user"></i> CREATE ADMIN</h1>
                <div class="col-xs-12 col-md-4 col-md-offset-4 col-sm-12 boxik" style="background:white;">
                        <!-- Text input-->
                        <div class="form-group">
                          <label class="col-md-4 control-label" for="textinput">Login</label>  
                          <div class="col-md-8">
                          <input id="textinput" name="login" type="text" placeholder="login" class="form-control input-md" v-model="login">
                            <div v-if="login" style="padding-top: 10px;">
                              <span class="help-block" style="color:green; " v-if="login"><i class="fa fa-check"></i> Elegantly </span>
                              <span class="help-block" style="color:red;" v-if="!login"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> It must be login</span>
                            </div>
                          </div>
                        </div>

                        <!-- Text input-->
                        <div class="form-group">
                          <label class="col-md-4 control-label" for="textinput">Email</label>  
                          <div class="col-md-8">
                          <input id="textinput" name="email" type="email" placeholder="email" class="form-control input-md" v-model="email">
                            <div v-if="email" style="padding-top: 10px;">
                              <span class="help-block" style="color:green; " v-if="isEmailValid"><i class="fa fa-check"></i> Elegantly </span>
                              <span class="help-block" style="color:red; " v-if="!isEmailValid"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> It must be email</span>
                            </div>
                          </div>
                          
                        </div>

                        <!-- Text input-->
                        <div class="form-group">
                          <label class="col-md-4 control-label" for="textinput">Password</label>  
                          <div class="col-md-8">
                          <input id="textinput" name="password" type="password" placeholder="" class="form-control input-md" v-model="password">
                          </div>
                        </div>

                        <!-- Text input-->
                        <div class="form-group">
                          <label class="col-md-4 control-label" for="textinput">Confirm password</label>  
                          <div class="col-md-8">
                          <input id="textinput" name="confirm_password" type="password" placeholder="" class="form-control input-md" v-model="password_conf">
                          <div  v-if="password_conf" style="padding-top:10px;">
                            <span class="help-block" style="color:green; " v-if="password == password_conf"><i class="fa fa-check"></i> Elegantly </span>
                            <span class="help-block" style="color:red; " v-if="password != password_conf"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> The two passwords are not the same </span>
                          </div>
                          </div>
                        </div>


                        <div class="form-group">
                            <div class="col-xs-12 text-center">
                                <button :disabled="(isEmailValid && (password == password_conf) && password && password_conf && login) ? false : true" type="submit" class="btn btn-primary" data-toggle="modal" href='#loading'>INSTALL</button>
                            </div>
                        </div>

                    

                </div>
                </div>
                </form>
                <div class="modal fade" id="loading" data-keyboard="false" data-backdrop="static">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Installing sprintKO</h4>
                      </div>
                      <div class="modal-body text-center" >
                        <div class="text-center" style="text-align: center;">
                          <i class="fa fa-spinner fa-spin fa-3x fa-fw" style="display: inline-block !important; text-align: right;"></i> 
                        </div>
                        <div class="text-center" style="margin-top:20px;">
                          Loading...
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
        </div>
        </div>
        <script src="https://code.jquery.com/jquery-2.2.1.min.js"></script>    
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
        <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.26/vue.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/1.0.2/vue-resource.js"></script>
        <script src="{{asset('js/vue/install.js')}}"></script>
    </body>
</html>
