<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FORK'D | a recipe</title>
    <link rel="stylesheet" href="styles.css">
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
                        echo "<p>Recipe not found.</p>";
                        exit;
                    }
                } else {
                    echo '<p>No recipe selected.</p>';
                    exit;
                }
            ?>


            <?php
                echo '<section>';
                echo '<h3>' . htmlspecialchars($recipe['recipe']) . '</h3>';
                echo '<h4>' . htmlspecialchars($recipe['title']) . '</h4>';
                echo '</section>';
            ?>

        </section>
    </main>
</body>
</html>