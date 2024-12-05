<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FORK'D | recipes</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <header class="navigation">
        <div class="links">
            <a href="index.php"><i class="fa fa-cutlery logo"></i></a>
            <a href="index.php">HOME</a>
            <a class="active" href="#recipes">RECIPES</a>
            <a href="help.html">HELP</a>
        </div>
        <div class="search-box">
            <form action="no-results.html">
              <input class="search-text" type="text" placeholder="search..." name="search"><button type="submit"><i class="fa fa-search"></i></button>
            </form>
        </div>
    </header>

    <main>
        <section class="recipes-container">
            <?php
                // Database connection
                require_once 'database_connection.php';
                $connection = mysqli_connect($host, $user, $password, $database);

                // Check connection
                if ($connection->connect_error) {
                    die("Connection failed: " . $connection->connect_error);
                }

                // Fetch recipes from the database
                $sql = "SELECT id, recipe_name, cuisine, cook_time, servings, hero_image FROM recipes";
                $result = $connection->query($sql);

                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        // Use default image if dish_image is empty or file doesn't exist
                        $imagePath = (!empty($row['hero_image']) && file_exists($row['hero_image'])) 
                                    ? $row['hero_image'] 
                                    : '';
                        echo '<article class="recipe-card">';
                        echo '<a href="recipe.php?id=' . $row["id"] . '">'; // Link with recipe ID
                        echo '<img src="' . htmlspecialchars($imagePath) . '" alt="' . htmlspecialchars($row["recipe_name"]) . '">';
                        echo '<h3>' . htmlspecialchars($row["recipe_name"]) . '</h3>';
                        echo '</a>';
                        echo '<p>' . htmlspecialchars($row["cuisine"]) . ' | ' . $row["cook_time"] . ' min | ' . $row["servings"] . ' Servings</p>';
                        echo '</article>';
                    }
                } else {
                    echo "<p>No recipes found.</p>";
                }

                $connection->close();
            ?>
        </section>
    </main>

 </body>
</html>