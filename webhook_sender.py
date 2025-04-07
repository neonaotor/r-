<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <title>Traum-Smartphone Generator</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f0f8ff;
      text-align: center;
      padding: 50px;
    }
    input, button {
      padding: 10px;
      font-size: 16px;
      margin: 10px;
    }
    #ergebnis {
      margin-top: 30px;
      font-size: 22px;
      font-weight: bold;
      color: #333;
    }
  </style>
</head>
<body>

  <h1>APA SMARTPHONE IMPIANMU?</h1>
  <p>Gib deinen Namen ein und erfahre dein Zufalls-Handy!</p>

  <input type="text" id="name" placeholder="Dein Name">
  <button onclick="zufall()">Los geht's!</button>

  <div id="ergebnis"></div>

  <script>
    function zufall() {
      const name = document.getElementById("name").value.trim();
      if (!name) {
        document.getElementById("ergebnis").innerText = "Bitte gib deinen Namen ein!";
        return;
      }

      const handys = [
        "iPhone 16 Ultramarine",
        "iPhone 12 Purple",
        "iPhone 15 Pro Max Natural Titanium",
        "Samsung Galaxy S23",
        "Xiaomi 14",
        "iPhone XS Max Gold",
        "Xiaomi 15"
      ];

      const zufallsIndex = Math.floor(Math.random() * handys.length);
      const gezogenesHandy = handys[zufallsIndex];

      document.getElementById("ergebnis").innerText =
        name + ", dein Traum-Smartphone ist: " + gezogenesHandy + "!";
    }
  </script>

</body>
</html>