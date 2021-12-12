<?php
    
    $weather = "";
    $error = "";
    
    if (isset($_GET['city'])) {
      
      $city = str_replace(' ' ,'-', $_GET['city']);
      
      
      $url= "http://www.weather-forecast.com/locations/".$city."/forecasts/latest";
      $headers = @get_headers($url);
      if(!$headers || $headers[0] == 'HTTP/1.1 404 Not Found') {
          $error="That city could not be found1.";
      }
       else {
        $forecastPage = file_get_contents("http://www.weather-forecast.com/locations/".$city."/forecasts/latest");
         
        //split string
        
        $pagerray=explode('for-small days-summaries js-day-summary"><th></th><td class="b-forecast__table-description-cell--js" colspan="9"><div class="b-forecast__table-description-title">',$forecastPage);
        if (sizeof($pagerray) > 1) {
        
          $secondPageArray=explode('</span></p></td><td class="b-forecast__table-description-cell--js" colspan="9"><div class="b-forecast__table-description-title"><h2>'.$city.' Weather (4&ndash;7 days)</h2></div><p class="b-forecast__table-description-content"><span class="phrase">',$pagerray[1]);
            
                if (sizeof($secondPageArray) > 1) {

                    $weather_whole = $secondPageArray[0];
                    $weather_main=explode('</div>',$weather_whole);
                    $weather_abc= $weather_main[0];
                    $weather_xyz= $weather_main[1];
                    $weatherb=$weather_abc.'<hr class="new5">';
                    $weather=$weatherb.$weather_xyz;
                    
                } else {
                    
                    $error = "That city could not be found!";
                    
                }
            
            } else {
            
                $error = "That city could not be found!";}

    }
    
  
   }
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags always come first -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

      <title>Weather Scraper</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/css/bootstrap.min.css" integrity="sha384-y3tfxAZXuh4HwSYylfB+J125MxIs6mR5FOHamPBG064zB+AFeWH94NdvaCBm8qnd" crossorigin="anonymous">
      
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <div class="container">
      <h1>What's The Weather?</h1>
      <form method="GET">
      <fieldset class="form-group">
      <label for="city">Enter the name of a city.</label>
      <input type="text" class="form-control" name="city" id="city" placeholder="Eg. Nagpur,Mumbai" value = "<?php if (isset($_GET['city'])) {echo "\"".$_GET['city']."\"";}?>">
      </fieldset>
      <button type="submit" class="btn btn-primary">Submit</button>
      </form>
      <div class="c_weather">
        <?php
        if($weather)
        {
          echo'<div class="alert alert-success" role="alert">'.$weather.'</div>';
        }
        else if ($error) {
          /*echo '<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
          
          <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 14">
            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
          </symbol>
        </svg>
        
          <div class="alert alert-danger d-flex align-items-center" role="alert">
          <svg class="bi flex-shrink-0 me-2" width="24" height="20" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>'
          .$error.
        '</div>';*/
        echo'<div class="alert alert-danger" role="alert">'.$error.'</div>';
      }
        ?>
      </div>

    <!-- jQuery first, then Bootstrap JS. -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/js/bootstrap.min.js" integrity="sha384-vZ2WRJMwsjRMW/8U7i6PWi6AlO1L79snBrmgiDpgIWJ82z8eA5lenwvxbMV1PAh7" crossorigin="anonymous"></script>
  </body>
</html>