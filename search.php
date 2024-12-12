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
            <a href="help.php">HELP</a>
        </div>
    </header>
    <main>
        <section class="search-container">
            <h3>RECIPES</h3>
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
                
                // check for search form submission
                if (isset($_POST['search'])) {
                    // get query
                    $search = $_POST['search'];
                    // prevent sql injection
                    $search = $connection->real_escape_string($search);
                    // sql query to search recipes database
                    $sql = "SELECT * FROM recipes WHERE recipe_name LIKE '%$search%' OR recipe LIKE '%$search%' OR cuisine LIKE '%$search%'";
                    $result = $connection->query($sql);
                } else {
                    // default query if no search term is entered
                    $sql = "SELECT * FROM recipes";
                    $result = $connection->query($sql);
                }

                // display search results
                if ($result->num_rows > 0) {
                    // display recipes
                    while ($row = $result->fetch_assoc()) {
                        // get path to hero image from database, show default if no image exists
                        $imagePath = (!empty($row['hero_image']) && file_exists($row['hero_image'])) 
                                    ? $row['hero_image'] 
                                    : '';
                        echo '<article class="recipe-card">';
                            echo '<a href="recipe.php?id=' . $row['id'] . '">'; // link = recipe id
                                echo '<img src="' . htmlspecialchars($imagePath) . '" alt="' . htmlspecialchars($row['recipe_name']) . '">';
                                echo '<h4>' . htmlspecialchars($row['recipe_name']) . '</h4>';
                                echo '<p>' . htmlspecialchars($row['cuisine']) . ' | ' . $row['cook_time'] . ' | ' . $row['servings'] . '</p>';
                            echo '</a>';
                        echo '</article>';
                    }
                } else {
                    echo '<p>No recipes found. Try searching again.</p>';
                }
                // close the connection
                $connection->close();
            ?>
        </section>
    </main>
</body>
</html>