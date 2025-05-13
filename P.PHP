<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Library Sign</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    /* Triangle container for proper positioning */
    .triangle-container {
      position: relative;
      width: 250px;
      height: 250px;
      margin: 0 auto;
    }
    
    /* Triangular shape */
    .triangle {
      position: absolute;
      width: 0;
      height: 0;
      border-left: 125px solid transparent;
      border-right: 125px solid transparent;
      border-bottom: 216px solid #4B8BBE;
      top: 0;
      left: 0;
    }

    /* Text styling for the triangle */
    .triangle-text {
      position: absolute;
      font-size: 18px;
      font-weight: bold;
      text-align: center;
      color: white;
      text-transform: uppercase;
    }

    /* Text position for "General Library Head" */
    .text-1 {
      top: 25px; /* Adjust vertical position */
      left: 50%;
      transform: translateX(-50%);
    }

    /* Text position for "عمومی کتابتون" */
    .text-2 {
      top: 140px;
      left: 10%;
      transform: translateX(-50%) rotate(-60deg);
      width: 80%;
    }

    /* Text position for "آمریت او آمریت کتابخانه عمومی" */
    .text-3 {
      top: 140px;
      left: 90%;
      transform: translateX(-50%) rotate(60deg);
      width: 80%;
    }
  </style>
</head>
<body class="bg-gray-100 flex justify-center items-center min-h-screen">

  <!-- Triangular Library Sign with Multiple Texts -->
  <div class="triangle-container">
    <!-- Triangle -->
    <div class="triangle"></div>

    <!-- Texts positioned around the triangle -->
    <div class="triangle-text text-1">
      General Library Head
    </div>
    <div class="triangle-text text-2">
      عمومی کتابتون
    </div>
    <div class="triangle-text text-3">
      آمریت او آمریت کتابخانه عمومی
    </div>
  </div>

</body>
</html>
