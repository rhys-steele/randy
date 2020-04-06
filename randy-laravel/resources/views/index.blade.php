<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Randy</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
        <link href="css/randy.css" rel="stylesheet">

    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content" id="app">
                <div class="card text-center sub-title m-b-md">
                    <div class="card-header">
                        Robot
                    </div>
                    <div class="card-body">
                        <div v-if="!started">
                            <form>
                                <button type="button" class="btn btn-success btn-lg btn-block" v-on:click="setup">Setup</button>
                            </form>
                        </div>
                        <div v-if="started">
                            <form>
                                <div class="big-icon text-success" v-on:click="toggleDirection" v-show="robot.direction == 'forward'">
                                    <i class="fas fa-angle-double-up"></i>
                                    {{--  <i class="fas fa-angle-double-down" v-show="robot.direction == 'backward'"></i>  --}}
                                </div>
                                <div class="big-icon text-success" v-on:click="toggleDirection" v-show="robot.direction == 'backward'">
                                    <i class="fas fa-angle-double-down"></i>
                                </div>
                                <div class="form-group">
                                    <label for="direction-input">
                                        Turning: 
                                        @{{ robot.turning < 100 ? 'Left' : 'Right' }}
                                        @{{ robot.turning < 100 ? 100 - robot.turning : robot.turning - 100 }}%
                                    </label>
                                    <input type="range" class="form-control-range range-input" max="200" value="100" id="direction-input" v-on:change="update" v-model="robot.turning">
                                </div>
                                <div class="form-group">
                                    <label for="speed-input">Speed: @{{ robot.speed / 2 }}%</label>
                                    <input type="range" class="form-control-range range-input" max="200" id="speed-input" v-on:change="update" v-model="robot.speed">
                                </div>
                                <button type="button" class="btn btn-success btn-lg btn-block" v-show="robot.state == 'stopped'" v-on:click="go">Go</button>
                                <button type="button" class="btn btn-danger btn-lg btn-block" v-show="robot.state == 'running'" v-on:click="stop">Stop</button>
                                <button type="button" class="btn btn-warning btn-lg btn-block" v-on:click="reset">Reset</button>
                                <button type="button" class="btn btn-primary btn-lg btn-block" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">Logs</button>
                            </form>
                        </div>
                    </div>
                    <div class="card-footer text-muted">
                        @{{ this.robot.state.charAt(0).toUpperCase() + this.robot.state.slice(1) }}
                    </div>
                </div>
                <div class="collapse" id="collapseExample">
                    <div class="card card-body">
                        <p class="logs text-muted" v-for="log in logs.slice().reverse()">
                            @{{ log }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"></script>
    <script src="js/randy.js"></script>
</html>
