<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Plant Recommendation</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-image: url('gard_stuffs/bg_rec.webp');
      background-size: cover; 
      background-position: center center; 
      background-repeat: no-repeat; 
      background-attachment: fixed; 
      color: #333;
      margin: 0;
      padding: 20px;
      height: 100vh; 
    }

    h2 {
      text-align: center;
      color: #1b5e20;
    }

    form {
      background-color: rgba(255, 255, 255, 0.6); 
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      max-width: 600px;
      margin: 0 auto;
      backdrop-filter: blur(5px); 
    }

    .form-group {
      display: flex;
      flex-direction: column;
      margin-bottom: 15px;
    }

    label {
      font-weight: bold;
      color: #1b5e20;
      margin-bottom: 5px;
    }

    input[type="text"],
    input[type="number"] {
      padding: 10px;
      border: 2px solid #1b5e20;
      border-radius: 5px;
      font-size: 16px;
      width: 100%;
      box-sizing: border-box;
    }

    input[type="submit"] {
      background-color: #1b5e20;
      color: white;
      border: none;
      border-radius: 5px;
      padding: 12px;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    input[type="submit"]:hover {
      background-color: #388e3c;
    }

    .form-group input[type="text"]:focus,
    .form-group input[type="number"]:focus {
      outline: none;
      border-color: #388e3c;
      box-shadow: 0 0 5px #66bb6a;
    }

    #result {
      margin-top: 20px;
      padding: 15px;
      background-color: #e8f5e9;
      border: 1px solid #1b5e20;
      color: #1b5e20;
      font-weight: bold;
      border-radius: 5px;
      display: none; 
    }

    img {
      width: 100px;
      margin: 10px;
    }
  </style>
</head>
<body>
  <div>
    <h2>Plant Recommendation Form</h2>
    <form method="POST" action="">
      <div class="form-group">
        <label for="plant_type">Plant Type:</label>
        <input type="text" id="plant_type" name="plant_type" required>
      </div>
      <div class="form-group">
        <label for="temperature">Temperature (°C):</label>
        <input type="number" id="temperature" name="temperature" required>
      </div>
      <div class="form-group">
        <label for="humidity">Humidity (%):</label>
        <input type="number" id="humidity" name="humidity" required>
      </div>
      <div class="form-group">
        <label for="watering_frequency">Watering Frequency:</label>
        <input type="text" id="watering_frequency" name="watering_frequency" required>
      </div>
      <div class="form-group">
        <label for="sunlight_requirement">Sunlight Requirement:</label>
        <input type="text" id="sunlight_requirement" name="sunlight_requirement" required>
      </div>
      <div class="form-group">
        <label for="soil_type">Soil Type:</label>
        <input type="text" id="soil_type" name="soil_type" required>
      </div>
      <div class="form-group">
        <label for="seasons">Seasons:</label>
        <input type="text" id="seasons" name="seasons" required>
      </div>
      <div class="form-group">
        <label for="thane_location">Thane Location:</label>
        <input type="text" id="thane_location" name="thane_location" required>
      </div>
      <div class="form-group">
        <input type="submit" value="Get Recommendation">
      </div>
    </form>

    <div id="result"></div>
  </div>

  <?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // Retrieve user input from form
      $plant_type = trim($_POST['plant_type']);
      $temperature = trim($_POST['temperature']);
      $humidity = trim($_POST['humidity']);
      $watering_frequency = trim($_POST['watering_frequency']);
      $sunlight_requirement = trim($_POST['sunlight_requirement']);
      $soil_type = trim($_POST['soil_type']);
      $seasons = trim($_POST['seasons']);
      $thane_location = trim($_POST['thane_location']);

      // Prepare the command to run the Python script with properly escaped arguments
      $command = escapeshellcmd("python recommend_plant.py") . " " . 
                escapeshellarg($plant_type) . " " . 
                escapeshellarg($temperature) . " " . 
                escapeshellarg($humidity) . " " . 
                escapeshellarg($watering_frequency) . " " . 
                escapeshellarg($sunlight_requirement) . " " . 
                escapeshellarg($soil_type) . " " . 
                escapeshellarg($seasons) . " " . 
                escapeshellarg($thane_location);

      // Execute the Python command and capture both stdout and stderr for debugging
      $output = shell_exec($command . " 2>&1");
      
      // Display the recommendation and images
      if ($output !== null) {
          $recommendedPlant = trim($output);
          echo "<script>document.getElementById('result').style.display = 'block';</script>";
          echo "<script>document.getElementById('result').innerHTML = 'Recommended Plant: " . htmlspecialchars($recommendedPlant) . "';</script>";

          // Log the recommended plant for debugging
          error_log("Recommended Plant: " . $recommendedPlant); // Check this in your server logs

          // Fetch images related to the recommended plant using Google Custom Search API
          $searchUrl = "https://www.googleapis.com/customsearch/v1?key=AIzaSyBz9Nn5iF-zNkZkV2fVd8a-JNvnpwCCe0o&cx=56d8a45b68c584bf8&q=" . urlencode($recommendedPlant) . "&searchType=image";

          // Make the request to fetch the images
          $response = file_get_contents($searchUrl);

          // Check if the response is valid
          if ($response === FALSE) {
              echo "<p>Error: Unable to fetch images from Google Custom Search API.</p>";
              return;
          }

          $data = json_decode($response, true);

          // Check for errors in the response
          if (isset($data['error'])) {
              echo "<p>Error: " . htmlspecialchars($data['error']['message']) . "</p>";
              return;
          }

          // Display images
          if (!empty($data['items'])) {
              echo "<h3>Images of $recommendedPlant:</h3>";
              foreach ($data['items'] as $item) {
                  echo "<img src='{$item['link']}' alt='{$item['title']}'>";
              }
          } else {
              echo "<p>No images found for " . htmlspecialchars($recommendedPlant) . ".</p>";
          }
      } else {
          echo "<p>Error: Python script execution failed.</p>";
      }
  }
  ?>
</body>
</html>
