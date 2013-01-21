/*
 * # fancywebsocket.js
 *
 * Frontendfunktionalitäten für Sockethandhabung mit PHP-Server.
 * Die Funktionalitäten sind so geschrieben, dass sie mit socket.io-Funktionen übereinstimmen. Somit kann das Frontend einheitlich die selben Funktionsnamen nutzen.
 *
 * auf Grundlage von: https://github.com/Flynsarmy/PHPWebSocket-Chat
 */

var FancyWebSocket = function(url)
{
	var callbacks = {};

	var ws_url = url;
	var conn;

	this.on = function(event_name, callback){
		callbacks[event_name] = callbacks[event_name] || [];
		callbacks[event_name].push(callback);
		return this;
	};

	this.emit = function(event_name, event_data){
		var data = {event_name: event_name, content: event_data};

		this.conn.send(JSON.stringify(data));
		return this;
	};

	this.connect = function() {
		if ( typeof(MozWebSocket) == 'function' )
			this.conn = new MozWebSocket(url);
		else
			this.conn = new WebSocket(url);

		this.conn.onmessage = function(evt){
			console.log(evt.data);
			var data = JSON.parse(evt.data);

			dispatch(data.event_name, data.content);
		};

		this.conn.onclose = function(){dispatch('close',null)}
		this.conn.onopen = function(){dispatch('open',null)}
	};

	this.disconnect = function() {
		this.conn.close();
	};

	var dispatch = function(event_name, message){
		var chain = callbacks[event_name];
		if(typeof chain == 'undefined') return;
		for(var i = 0; i < chain.length; i++){
			chain[i]( message )
		}
	}
};

// Verbindung des Frontends mit entsprechenden PHP-Socket-Server
var socket;
socket = new FancyWebSocket('ws://127.0.0.1:9300');
socket.connect();