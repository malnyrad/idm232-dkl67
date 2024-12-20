<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
?>
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
    <?php include_once 'header.php' ?>
    <main>
        <section class="search-container">
            <h3>Recipes</h3>
            <form class="search-box" action="search.php" method="post">
              <input class="search-text" type="text" placeholder="search..." name="search">
              <button type="submit"><i class="fa fa-search"></i></button>
            </form>
        </section>
        <section class="recipes-container">
            <?php
                // connect to database
                require_once 'database_connection.php';
                $connection = mysqli_connect($host, $user, $password, $database);
                // check connection
                if ($connection->connect_error) {
                    die("Connection failed: " . $connection->connect_error);
                }

                // fetch recipes from database
                $sql = "SELECT id, recipe_name, cuisine, cook_time, servings, hero_image FROM recipes";
                $result = $connection->query($sql);

                if ($result && $result->num_rows > 0) {
                    // display recipes
                    while ($row = $result->fetch_assoc()) {
                        // get path to hero image from database, show default if no image exists
                        $imagePath = (!empty($row['hero_image']) && file_exists($row['hero_image'])) 
                                    ? $row['hero_image'] 
                                    : '';
                        echo '<article class="recipe-card">
                            <a href="recipe.php?id=' . $row['id'] . '">
                                <img src="' . htmlspecialchars($imagePath) . '" alt="' . htmlspecialchars($row['recipe_name']) . '" loading="lazy"/>
                                <div class="recipe-card-text">
                                    <h4>' . htmlspecialchars($row['recipe_name']) . '</h4>
                                    <p>' . htmlspecialchars($row['cuisine']) . ' | ' . $row['cook_time'] . ' | ' . $row['servings'] . '</p>
                                </div>
                            </a>
                        </article>';
                    }
                } else {
                    echo '<p>No recipes found. Try searching again.</p>';
                }
                // close the connection
                $connection->close();
            ?>
        </section>
    </main>
    <?php include_once 'footer.php' ?>
 </body>
</html>