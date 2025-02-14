<?php
error_reporting(0);
session_start();
include_once('test/connection.php');

// Check if the user is logged in
if (!isset($_SESSION['name']) || !isset($_SESSION['username'])) {
    header('Location:test/login.php');
    exit();
}

// Assign the session variables to display the correct user name
$name = $_SESSION['name'];
$username = $_SESSION['username'];
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FORUMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap JS with Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <style>
        .jumbotron-custom {
            background-color: #f8f9fa;
            padding: 2rem;
            border-radius: .3rem;
            box-shadow: 0 .5rem 1rem rgba(0,0,0,.15);
            margin-bottom: 2rem;
        }
        .jumbotron-custom h1 {
            font-size: 3rem;
        }
        .media-object {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            margin-bottom: 1rem;
        }
        .media-object img {
            width: 54px;
            height: auto;
            border-radius: .25rem;
        }
        
        #ques {
            min-height: 433px;
        }
    </style>
</head>
<body>
    <?php @include '../partials/_header.php'; ?> 
    <?php @include '../partials/_dbconnect.php'; ?>

    <?php 
        $id = $_GET['threadid'];
        $sql = "SELECT * FROM threads WHERE thread_id=$id";
        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
            $title = htmlspecialchars($row['thread_title']);
            $desc = htmlspecialchars($row['thread_desc']);
        }
    ?>

    <div class="container my-3">
        <div class="jumbotron-custom text-center">
            <h1 class="display-4"><?php echo $title; ?></h1>
            <p class="lead"><?php echo $desc; ?></p>
            <p>Explore our categories and get the best tips and advice.</p>
            <p class="greeny-text"><b>Posted by <?= htmlspecialchars($name)?></b></p>
        </div>
    </div>

    <div class="container" id="ques">
        <h1 class="py-2">Comments</h1>

        <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
            <div class="form-group">
                <label for="comment" class="form-label">Type your comment</label>
                <textarea class="form-control" id="comment" name="comment" rows="3"></textarea><br>
            </div>
            <button class="btn btn-success" type="submit">Post Comment</button>
        </form>

        <?php 
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $comment_content = $_POST['comment'];
            $comment_content = mysqli_real_escape_string($conn, $comment_content);

            // Replace '1' with actual user_id, if you have a session implemented
            $sql = "INSERT INTO comments (comment_content, thread_id, comment_by, comment_time) 
                    VALUES ('$comment_content', '$id', 0, CURRENT_TIMESTAMP())";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                echo '<div class="alert alert-success" role="alert">
                        Your comment has been added successfully!
                      </div>';
            } else {
                echo '<div class="alert alert-danger" role="alert">
                        There was an error adding your comment. Please try again.
                      </div>';
            }
        }

        $sql = "SELECT * FROM comments WHERE thread_id=$id";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $content = htmlspecialchars($row['comment_content']);
                $comment_time=htmlspecialchars($row['comment_time']);
                $formatted_time = date('F j, Y \a\t g:i A', strtotime($comment_time));

                echo '<div class="media my-3">
                        <img src="https://www.gravatar.com/avatar?d=identicon&s=64" class="mr-3 rounded-circle" alt="...">

                        <div class="media-body">
                        <p class="font-weight-bold my-0">'.$formatted_time.'</p>
                            ' . $content . '
                        </div>
                      </div>';
            }
        } else {
            echo '<div class="jumbotron-custom text-center">
                    <h2>No Comments Found</h2>
                    <p>Be the first to comment!</p>
                  </div>';
        }
        ?>
    </div>

    <?php include '../partials/_footer.php'; ?> 
</body>
</html>
