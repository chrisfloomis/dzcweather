var express = require('express');

var app = express();
var handlebars = require('express-handlebars').create({defaultLayout:'main'});
var bodyParser = require('body-parser');
//var owm = require('./owm.js');
var request = require('request');

app.engine('handlebars', handlebars.engine);
app.set('view engine', 'handlebars');
app.set('port', 3000);
app.use(bodyParser.urlencoded({ extended: false }));
app.use(bodyParser.json());
app.use(express.static('public'));

app.get('/',function(req,res){
	var context = {};
	request('http://api.openweathermap.org/data/2.5/forecast/daily?q=corvallis&units=imperial&cnt=7&APPID=ac8c02ef8cf7667fb84c8c8dc20ec383', get7Day);

	function get7Day(err, response, body){
		var response = JSON.parse(body);
		if(!err && response.statusCode < 400){
			var params = [];
			var day = 1;
			
			params.push({'daynum':day,'temp':response.list.temp.day});
			
			//for(q in body.list){
				//params.push(
					//{'daynum': ++day,'temp':});
					 //'temp':body.list[q].temp.day,
					 //'hum':body.list[q].humidity,
					 //'des':body.list[q].weather.description,
					 //'icon':body.list[q].weather.icon});
				//day++;
			//}
			
			context.city = "Corvallis, OR";
			context.forecast = params;
			context.test = body;
			res.render('7Day',context);
		}
		else{
			console.log(err);
			console.log(response.statusCode);
		}
	}
});

app.use(function(req,res){
  res.status(404);
  res.render('404');
});

app.use(function(err, req, res, next){
  console.error(err.stack);
  res.type('plain/text');
  res.status(500);
  res.render('500');
});

app.listen(app.get('port'), function(){
  console.log('Express started on http://localhost:' + app.get('port') + '; press Ctrl-C to terminate.');
});