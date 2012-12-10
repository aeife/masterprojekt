var FancyWebSocket = function(url)
{
	var callbacks = {};

	var ws_url = url;
	var conn;

	this.on = function(event_name, callback){
		//console.log("ON");
		//console.log(callbacks);
		callbacks[event_name] = callbacks[event_name] || [];
		callbacks[event_name].push(callback);
		//callbacks['message'][1] = event_name;
		//console.log(callback);
		return this;// chainable
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

		// dispatch to the right handlers
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
		//console.log("DISPATCH");
		//console.log(callbacks);
		var chain = callbacks[event_name];
		if(typeof chain == 'undefined') return; // no callbacks for this event
		for(var i = 0; i < chain.length; i++){
			chain[i]( message )
		}
	}
};

var socket;
socket = new FancyWebSocket('ws://127.0.0.1:9300');
socket.connect();