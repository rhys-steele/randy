var app = new Vue({
    el: '#app',
    data: {
        robot: {
            state: 'stopped',
            direction: 100,
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
        reset: function() {
            this.robot.direction = 100;
            this.robot.speed = 50;
        },
        update: function() {
            var self = this;
            self.log('Sending command...');
            axios.post('/api/execute', {
                state: this.robot.state,
                speed: this.robot.speed,
                direction: this.robot.direction
            })
            .then(function (response) {
                self.log('Command successfully sent');
            })
            .catch(function (error) {
                self.log('Command failed to send')
            });
        },
        log: function(message) {
            this.logs.push('[' + moment().format() + '] - ' + message);
            if (this.logs.length > 8) {
                this.logs.splice(0, 1);
            }
        }
    }
})