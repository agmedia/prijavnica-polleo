
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));

const app = new Vue({
    el: '#app',
    data() {
        return {
            socket: '',
            host: 'ws://localhost:5331/serial',
            timeLeft: 300,
        }
    },
    mounted() {
        setInterval(this.CountDown, 1000)

        // Resets interval on every input focus
        let inputs = document.getElementsByTagName('input');
        for (let i = 0; i < inputs.length; i++) {
            inputs[i].addEventListener('focus', () => {
                this.timeLeft = 300
            });
        }

        this.socket = new WebSocket(this.host);
    },
    methods: {
        CountDown() {
            if (this.timeLeft == -1) {
                location = '/';
            } else {
                if (document.getElementById('secs')) {
                    document.getElementById('secs').innerHTML = '<h1>' + this.timeLeft + '</h1>'
                    this.timeLeft--
                }
            }
        },
        CardOut() {
            this.socket.send('card_out');
        }
    }
});




var socket;
var host = "ws://localhost:5331/serial";

$(document).ready(function() {

    function connect () {
        try {
            socket = new WebSocket(host);
            var in_string;
            message('<p class="event">Socket Status: '+socket.readyState);

            socket.onopen = function() {
                message('<p class="event">Socket Status: '+socket.readyState+' (open)');
            }

            socket.onmessage = function(msg) {
                var in_string = new String(msg.data);
                message('<p class="message">Response from serial : ' + in_string );
            }

            socket.onclose = function(){
                message('<p class="event">Socket Status: '+socket.readyState+' (Closed)');
                socket.close();
            }

        } catch(exception){
            message('<p>Error'+exception);
        }
    }


    function send () {
        var text = $('#text').val();

        if (text == "") return;

        try {
            socket.send(text);
            message('<p class="event">Sent: '+text);
            $('#text').val("");

        } catch (exception) {
            message('<p class="warning">Connection problem.</p>');
        }
    }


    function message (msg) {
        $('#dataLog').append( msg + "<br />" );
        $("#dataLog").animate({ scrollTop: $("#dataLog").attr("scrollHeight") }, 250);
    }



    $('#text').keypress(function(event) {
        if (event.keyCode == '13') {
            send();
        }
    });

    $('#send').click(function(){
        send();
    });

    $('#disconnect').click(function(){
        message( "Disconnecting " + "<br />" );
        socket.close();

    });

    $('#connect').click(function(){
        message( "Connecting " + "<br />" );
        connect();
    });


});
