// time
var timer = document.getElementById('time');
var loop;

function displayTime(){
	var now = new Date();
	var h = ('0'+now.getHours()).slice(-2);
	var m = ('0'+now.getMinutes()).slice(-2);
	var s = ('0'+now.getSeconds()).slice(-2);

	timer.innerHTML = h+'h:'+m+'m:'+s+'s';
}
loop = setInterval(displayTime, 1000);