$hitURL="https://api.weatheranalytics.com/v1/forecast/[".$syslat.",".$syslong."]?startDate=".$frm_date."&endDate=".$todate."&interval=hourly&units=imperial&format=json&time=gmt&userKey=".$apikey;
	$contents = file_get_contents($hitURL);
	$contents=json_decode($contents);
	$result=$contents->weatherData->hourly->hours;
	
	$values=array();
	foreach($result as $key=>$val)
	{
		$values[$val->dateHrGmt]=(array) $val;
	}
	$resultfinal=array();
	foreach($values as $k => $v)
        $resultfinal[explode(" ", $k)[0]][] = $v;
	
	$this->renderpartial('weather-forcast',array('forecast'=>$resultfinal));
	
	} 
	
	
	
	
	//html 
	
	
	<html>
<head>
<style type="text/css">
.active-forcast {
    background: none repeat scroll 0 0 #1caf9a;
}
</style>
</head>
</html>
<h4 class="acs1">7 Day Weather Forecast</h4>
	
	<div class="forecast">
		<ul>
		<?
		//echo json_encode($forecast);
		$day=1;
		foreach($forecast as $key=>$weather)
		{		
			//print_r($weather);
			$day==1? $active= "active-forcast" : $active='' ;
			echo "<li alt='day".$day."' class='".$active." weather-forcast'>
						<div class='day'>".date('D',strtotime($key))."</div>
						<div class=''></div>	
					</li>";
		$day++;
		}?>	
		</ul>
		<?	
		$i=1;		
		foreach($forecast as $key=>$weather)
		{ 
			
			echo '<div class="weatherdata day'.$i.'">';?>

			<div class="weather-info" style="width: 20%;border-left: 1px solid #e2e2e2;">
				<div class="heading">Time</div>
				<div class="heading">Rain (Inches)</div>
				<div class="heading">wind speed (km/Hr)</div>
				<div class="heading">Temperature (c)</div>
				<div class="heading">Humidity</div>
			</div>
			<?
			$hours=1;
			foreach($weather as $keyn=>$dayweather) 
			{ ?>
				<div class="weather-info hours<? echo $hours; ?>">
					<div class="time"><? echo date('H:i',strtotime($dayweather['dateHrGmt'])); ?></div>
					<div class="time"><? echo round($dayweather['rainInches'],3); ?></div>
					<div class="wind-spd"> <? echo round($dayweather['windSpeedMph']*1.609,2); // convert mph to kph ?></div>
					<div class="wind-dir"> <? echo round(($dayweather['surfaceTemperatureFahrenheit'] - 32)*5/9,2); ?></div>
					<div class="pressure"><? echo $dayweather['relativeHumidity']; ?></div>
				</div>
			<?
			$hours++;			
			}
			echo "</div>";
			$i++; 
		 } ?>
		
		
	</div>
<script type="text/javascript" >
$(document).ready(function()
{
	$('.weather-forcast').click(function()
	{
		$('.weather-forcast').removeClass('active-forcast');
		$(this).addClass('active-forcast');
		var act_class='.'+$(this).attr('alt');
		$('.weatherdata').hide();
		$(act_class).show();
	})
	
});


</script>
