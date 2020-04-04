var app = new Vue({
    el: '#app',
    data: {
        started: false,
        robot: {
            state: 'stopped',
            direction: 'forward',
            turning: 100,
            speed: 50
        },
        logs: []
    },
    methods: {
        go: function() {
            console.log('Go');
            this.robot.state = 'running';
            this.update();
        },
        stop: function() {
            console.log('Stop');
            this.robot.state = 'stopped';
            this.update();
        },
        toggleDirection: function() {
            this.robot.direction = this.robot.direction == 'forward' ? 'backward' : 'forward';
            this.update();
        },
        reset: function() {
            this.robot.turning = 100;
            this.robot.speed = 50;
        },
        update: function() {
            var self = this;
            self.log('Sending command...');
            axios.post('/api/execute', {
                state: this.robot.state,
                speed: this.robot.speed,
                turning: this.robot.turning,
                direction: this.robot.direction
            })
            .then(function (response) {
                self.log('Command successfully sent');
            })
            .catch(function (error) {
                self.log('Command failed to send')
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
                self.log('Error during successful');
            });
        },
        log: function(message) {
            this.logs.push('[' + moment().format() + '] - ' + message);
            if (this.logs.length > 4) {
                this.logs.splice(0, 1);
            }
        }
    }
})