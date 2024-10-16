<?php
session_start();
$verticalDir = 'images/';
$horizontalDir = 'images/Horizontal-images/';

$verticalImages = glob($verticalDir . '*.jpg');
$horizontalImages = glob($horizontalDir . '*.jpg');

if (!isset($_SESSION['verti_index_1'])) {
    $_SESSION['verti_index_1'] = 0;
}
if (!isset($_SESSION['verti_index_2'])) {
    $_SESSION['verti_index_2'] = 1; 
}
if (!isset($_SESSION['hori_index'])) {
    $_SESSION['hori_index'] = 0;
}

if (isset($_POST['direction'])) {
    if ($_POST['direction'] === 'next') {
        $_SESSION['verti_index_1'] = ($_SESSION['verti_index_1'] + 1) % count($verticalImages);
        $_SESSION['verti_index_2'] = ($_SESSION['verti_index_2'] + 1) % count($verticalImages);
        $_SESSION['hori_index'] = ($_SESSION['hori_index'] + 1) % count($horizontalImages);
    } elseif ($_POST['direction'] === 'previous') {
        $_SESSION['verti_index_1'] = ($_SESSION['verti_index_1'] - 1 + count($verticalImages)) % count($verticalImages);
        $_SESSION['verti_index_2'] = ($_SESSION['verti_index_2'] - 1 + count($verticalImages)) % count($verticalImages);
        $_SESSION['hori_index'] = ($_SESSION['hori_index'] - 1 + count($horizontalImages)) % count($horizontalImages);
    }
}

$currentVertiImage1 = $verticalImages[$_SESSION['verti_index_1']];
$currentVertiImage2 = $verticalImages[$_SESSION['verti_index_2']];
$currentHoriImage = $horizontalImages[$_SESSION['hori_index']];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Collage</title>
</head>
<body>
    <div class="collage">
        <div id="verti-images">
            <div id="image-1"><img src="<?php echo $currentVertiImage1; ?>" alt=""></div>
            <div id="image-2"><img src="<?php echo $currentVertiImage2; ?>" alt=""></div>
        </div>
        <div id="hori-images">
            <img src="<?php echo $currentHoriImage; ?>" alt="">
        </div>
    </div>
    <div>
        <form class="buttons" method="POST">
            <div id="button">
                <button name="previous">Previous</button>
            </div>
            <div id="button">
                <button name="next">Next</button>
            </div>
        </form>
    </div>
    <script>
        const previousButton = document.querySelector('button[name="previous"]');
        const nextButton = document.querySelector('button[name="next"]');

        previousButton.addEventListener('click', function(event) {
            event.preventDefault();
            rotateImages('previous');
        });

        nextButton.addEventListener('click', function(event) {
            event.preventDefault();
            rotateImages('next');
        });

        function rotateImages(direction) {
            const vertiImages = document.querySelectorAll('#verti-images img');
            const horiImage = document.querySelector('#hori-images img');

            if (direction === 'next') {
                vertiImages.forEach(img => {
                    img.classList.add('rotate');
                    img.style.transformOrigin = 'left';
                });
                horiImage.classList.add('rotate');
                horiImage.style.transformOrigin = 'center';
            } else {
                vertiImages.forEach(img => {
                    img.classList.add('rotate');
                    img.style.transformOrigin = 'right';
                });
                horiImage.classList.add('rotate');
                horiImage.style.transformOrigin = 'center';
            }

            setTimeout(() => {
                const form = document.createElement('form');
                form.method = 'POST';
                form.innerHTML = `
                    <input type="hidden" name="direction" value="${direction}">
                `;
                document.body.appendChild(form);
                form.submit();
            }, 500);
        }
    </script>
</body>
</html>
