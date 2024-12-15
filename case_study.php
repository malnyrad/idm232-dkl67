<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FORK'D | case study</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <?php include_once 'header.php' ?>
    <main class="case-study">
        <section class="case-content">
            <h3>The Overview</h3>
            <p>This project, made for IDM 232 (Scripting for IDM II), was focused on serving as an introduction to PHP through creating an online recipe database. Using HTML, CSS, PHP, and MySQL, this project aimed to deliver a smooth browsing and searching experience for users, tying together an intuitive front-end with a custom back-end database. With a responsive interface and searchable content, the resulting website is an easy-to-navigate platform for users on their culinary journey.</p>
        </section>
        <section class="case-content">
            <h3>Context and Challenge</h3>
            <p>This project was created for IDM-232 Scripting for IDM II. Over the course of 10 weeks, the purpose of this solo project was to build a dynamic website for hosting recipes where the end goal was to create a fully functional platform for users to browse and search for desired content. While we were provided the raw data to be used as content in our websites, it was up to me as the developer to translate that into a comprehensive database that could be interfaced with using PHP and MySQL. Ultimately, the final project was a product of everything I learned over the course of the term, including server-side scripting, database implementation, and best practices for safe coding.</p>
        </section>
        <section class="case-content">
            <h3>Process and Insight</h3>
            <p>The design process began with analyzing existing online cookbooks and meal prep websites to help inform the design of my own website. I decided on a clean and casual minimalist style inspired by strong cutlery-themed iconography.
            <br><br>
            The code for the project began with building out static pages using HTML and CSS, focusing on creating a basic but responsive layout of the website in preparation for PHP implementation further into the term. With a base structure in place, the next step was building the database to store the nearly 40 recipes worth of text and images. While creating a spreadsheet in Excel with the of my classmates was already a time-consuming process, even more time was spent on figuring out PHPMyAdmin and successfully importing my database in a way that could be easily be fetched with PHP.</p>
        </section>
        <section class="case-content">
            <h3>The Results</h3>
            <p>I was pretty happy with the outcome of this project, especially as a first experience with a new coding language. The end result is a fully-functional, dynamic website that integrates a sizable database through server-side scripting- something that would have been nigh impossible to do statically. If I were to continue with this website, I'd like to implement filtering options and possibly functionality that would allow adding new recipes to the database.</p>
        </section>
    </main>
    <?php include_once 'footer.php' ?>
</body>
</html>