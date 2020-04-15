var app = new Vue({
    el: '#app',
    data: {
        started: false,
        robot: {
            state: 'stopped',
            direction: 'forward',
            turning: 100,
            speed: 5
        },
        webcam: {
            x: 90,
            y: 90
        },
        logs: []
    },
    methods: {
        go: function() {
            this.robot.state = 'running';
            this.sync();
        },
        stop: function() {
            this.robot.state = 'stopped';
            this.sync();
        },
        toggleDirection: function() {
            this.robot.direction = this.robot.direction == 'forward' ? 'backward' : 'forward';
            this.sync();
        },
        reset: function() {
            this.robot.turning = 100;
            this.robot.speed = 5;
            this.robot.direction = 'forward';
            this.robot.state = 'stopped';
            this.logs = [];
        },
        sync: function() {
            var self = this;
            self.log('Syncing...');
            axios.post('/api/sync', {
                state: this.robot.state,
                speed: (this.robot.speed - 1) * 30,
                turning: this.robot.turning,
                direction: this.robot.direction,
                webcam: {
                    x: this.webcam.x,
                    y: this.webcam.y
                }
            })
            .then(function (response) {
                self.log('Sync successful');
            })
            .catch(function (error) {
                self.log('Sync failed')
            });
        },
        setup: function() {
            var self = this;
            self.log('Sending setup commands...');
            axios.post('/api/setup')
            .then(function (response) {
                self.log('Setup successful');
                self.started = true;
            })
            .catch(function (error) {
                self.log('Setup failed');
            });
        },
        moveWebcam: function(direction) {
            var addX = 0;
            var addY = 0;
            switch (direction) {
                case 'up':
                    addY += this.webcam.y == 0 ? 0 : -15;
                    break;
                case 'down':
                    addY += this.webcam.y == 180 ? 0 : 15;
                    break;
                case 'left':
                    addX += this.webcam.x == 0 ? 0 : -15;
                    break;
                case 'right':
                    addX += this.webcam.x == 180 ? 0 : 15;
                    break;
                default:
                    break;
            }
            this.webcam.x += addX;
            this.webcam.y += addY;
            this.sync();
        },
        log: function(message) {
            this.logs.push('[' + moment().format() + '] - ' + message);
            if (this.logs.length > 4) {
                this.logs.splice(0, 1);
            }
        }
    }
})