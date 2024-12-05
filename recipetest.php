<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>forktest</title>
</head>
<body>
    <!-- Navigation -->
    <header>
        <div class="container">
            <h1><a href="index.php">Fork & Flavor</a></h1>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="recipe.php">Recipes</a></li>
                    <li><a href="help.php">Help</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <?php
        // Database connection
        require_once 'database_connection.php';

        $conn = new mysqli($db_server, $db_user, $db_pass, $db_name);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Get recipe ID from URL
        $recipeId = isset($_GET['id']) ? intval($_GET['id']) : 0;

        if ($recipeId > 0) {
            // Fetch recipe details
            $sql = "SELECT recipe_name, cuisine, cook_time, servings, description, ingredients, steps, hero_image 
                    FROM recipes WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $recipeId);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && $result->num_rows > 0) {
                $recipe = $result->fetch_assoc();

                // Display recipe details
                echo '<h1>' . htmlspecialchars($recipe['recipe_name']) . '</h1>';
                echo '<div class="recipe-image">';
                echo '<img src="' . htmlspecialchars($recipe['hero_image']) . '" alt="' . htmlspecialchars($recipe['recipe_name']) . '" />';
                echo '</div>';
                echo '<p><strong>Cuisine:</strong> ' . htmlspecialchars($recipe['cuisine']) . '</p>';
                echo '<p><strong>Cook Time:</strong> ' . htmlspecialchars($recipe['cook_time']) . ' min</p>';
                echo '<p><strong>Servings:</strong> ' . htmlspecialchars($recipe['servings']) . '</p>';
                echo '<p><strong>Description:</strong> ' . htmlspecialchars($recipe['description']) . '</p>';
                echo '<h2>Ingredients</h2>';

                // Split ingredients by '*' delimiter and display as list items
                $ingredients = explode('*', $recipe['ingredients']);
                echo '<ul>';
                foreach ($ingredients as $ingredient) {
                    if (!empty(trim($ingredient))) {
                        echo '<li>' . htmlspecialchars($ingredient) . '</li>';
                    }
                }
                echo '</ul>';

                echo '<h2>Steps</h2>';
                echo '<p>' . nl2br(htmlspecialchars($recipe['steps'])) . '</p>';
            } else {
                echo '<p>Recipe not found.</p>';
            }
            $stmt->close();
        } else {
            echo '<p>Invalid recipe ID.</p>';
        }

        $conn->close();
        ?>
    </main>
</body>
</html>