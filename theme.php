<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Theme Page</title>
 <link rel="stylesheet" href="Theme.css"/>
</head>

<body>
<img  src="images/Logo.png" alt="Logo Picture">
<img id="back" src="images/cvstemplate.png" alt="Logo Picture">

<div class="container">
<div class="template-selection">
    <h1>Choisissez un Template</h1>

   <div class="template-options">
        <div class="template">
            <img class="blue" src="images/template2.png" alt="Template 1" onclick="selectTemplate('Blue_formulaire')">
            <button class="blue-button" onclick="selectTemplate('Blue_formulaire')">Bleustar</button>
        </div>
        <div class="template">
            <img class="black" src="images/template1.png" alt="Template 2" onclick="selectTemplate('Black_formulaire')">
            <button class="black-button" onclick="selectTemplate('Black_formulaire')">Blackstox</button>
        </div>
    </div> 

    <button id="nextButton" disabled onclick="nextPage()">Next</button>
</div>

<script src="theme.js"></script>
</div>

</body>
</html>
