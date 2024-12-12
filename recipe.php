<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

    // connect to database
    require_once 'database_connection.php';
    $connection = mysqli_connect($host, $user, $password, $database);

    // check if id is provided in url
    if (isset($_GET['id'])) {
        // get recipe id from url
        $recipeId = $_GET['id'];
        // prevent sql injection
        $recipeId = $connection->real_escape_string($recipeId);
        // query database to fetch recipe details by id
        $sql = "SELECT * FROM recipes WHERE id = $recipeId";
        $result = $connection->query($sql);

        if ($result->num_rows > 0) {
            // fetch recipe data
            $recipe = $result->fetch_assoc();
        } else {
            echo '<p>Recipe not found.</p>';
            exit;
        }
    } else {
        echo '<p>No recipe selected.</p>';
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php echo "<title>FORK'D | " . strtolower(htmlspecialchars($recipe['recipe_name'])) . "</title>"; ?>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <header class="navigation">
        <div class="links">
            <a href="index.php"><i class="fa fa-cutlery logo"></i></a>
            <a href="index.php">Home</a>
            <a class="active" href="recipes.php">Recipes</a>
            <a href="help.php">Help</a>
        </div>
    </header>
    <main>
        <?php    
            // recipe stats: title, hero image, cook time, servings, description
            echo '<section class="recipe-stats">
                <h3>' . htmlspecialchars($recipe['recipe']) . '</h3>
                <h4>' . htmlspecialchars($recipe['subtitle']) . '</h4>
                <div class="cook-time">
                    <i class="fa fa-clock-o"></i>
                    <p>' . htmlspecialchars($recipe['cook_time']) . '</p>
                </div>
                <p>' . htmlspecialchars($recipe['servings']) . '</p>';
                if (!empty($recipe['hero_image'])) {
                    echo '<img src="' . htmlspecialchars($recipe['hero_image']) . '" alt="' . htmlspecialchars($recipe['recipe_name']) . '" loading="lazy"/>';
                }
                echo '<p>' . htmlspecialchars($recipe['description']) . '</p>';
            echo '</section>';
            // recipe ingredients: ingredients image, ingredient list
            echo '<section class="recipe-ingredients">';
                if (!empty($recipe['ingredients_image'])) {
                    echo '<img src="' . htmlspecialchars($recipe['ingredients_image']) . '" alt="ingredients for ' . htmlspecialchars($recipe['recipe_name']) . '">';
                }
                echo '<h3>Ingredients</h3>
                <ul>';
                    // separate ingredients by line
                    $ingredientList = explode("\n", $recipe['ingredients']);
                    foreach ($ingredientList as $ingredient) {
                        // trim extra spaces for consistency
                        $ingredient = htmlspecialchars(trim($ingredient)); 
                        if (!empty($ingredient)) {
                            echo '<li>' . $ingredient . '</li>';
                        }
                    }
                echo '</ul>
            </section>';
            // recipe steps: step image, step number, step description
            echo '<section class="recipe-steps">';
                // separate images by character '|'
                $stepImages = explode("|", $recipe['steps_images']);
                // display corresponding steps with images
                $steps = explode("*", $recipe['steps']);
                foreach ($steps as $index => $step) {
                    // fetch associated step image
                    if (isset($stepImages[$index])) {
                        echo '<img src="' . htmlspecialchars(trim($stepImages[$index])) . '" alt="step ' . ($index + 1) . ' image" loading="lazy"/>';
                    }
                    echo '<div>
                        <p>' . ($index + 1) . '</p>
                        <p>' . htmlspecialchars(trim($step)) . '</p>
                    </div>';
                }
            echo '</section>';
            // close the connection
            $connection->close();
        ?>
    </main>
</body>
</html>