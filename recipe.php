<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FORK'D | a recipe</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <header class="navigation">
        <div class="links">
            <a href="index.php"><i class="fa fa-cutlery logo"></i></a>
            <a href="index.php">HOME</a>
            <a class="active" href="recipes.php">RECIPES</a>
            <a href="help.php">HELP</a>
        </div>
    </header>
    <main>
        <section>
            <?php
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

            <?php
                echo '<section class="recipe-stats">';
                    echo '<h3>' . htmlspecialchars($recipe['recipe']) . '</h3>';
                    echo '<h4>' . htmlspecialchars($recipe['subtitle']) . '</h4>';
                    echo '<div class="cook-time">';
                        echo '<i class="fa fa-clock-o"></i>';
                        echo '<p>' . htmlspecialchars($recipe['cook_time']) . '</p>';
                    echo '</div>';
                    echo '<p>' . htmlspecialchars($recipe['servings']) . '</p>';
                    if (!empty($recipe['hero_image'])) {
                        echo '<img src="' . htmlspecialchars($recipe['hero_image']) . '" alt="' . htmlspecialchars($recipe['recipe_name']) . '" />';
                    }
                    echo '<p>' . htmlspecialchars($recipe['description']) . '</p>';
                echo '</section>';
                echo '<section class="recipe-ingredients">';
                    if (!empty($recipe['ingredients_image'])) {
                        echo '<img src="' . htmlspecialchars($recipe['ingredients_image']) . '" alt="Ingredients for ' . htmlspecialchars($recipe['recipe_name']) . '">';
                    }
                    echo '<h3>Ingredients</h3>';
                    echo '<ul>';
                        $ingredientList = explode("\n", $recipe['ingredients']); // separate ingredients by line
                        foreach ($ingredientList as $ingredient) {
                            // trim extra spaces for consistency
                            $ingredient = htmlspecialchars(trim($ingredient)); 
                            if (!empty($ingredient)) {
                                echo '<li>' . $ingredient . '</li>';
                            }
                        }
                    echo '</ul>';
                echo '</section>';
            ?>

        </section>
    </main>
</body>
</html>