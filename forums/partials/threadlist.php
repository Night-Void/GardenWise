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
        box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15);
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
        $id = $_GET['catid'];
        $sql = "SELECT * FROM categories WHERE category_id=$id";
        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
            $catName = htmlspecialchars($row['category_name']);
            $catDescription = htmlspecialchars($row['category_description']);
        }
    ?>

    <?php
    $method = $_SERVER['REQUEST_METHOD'];
    if($method == 'POST'){
        $th_title = $_POST['title'];
        $th_desc = $_POST['desc'];

        // Avoid SQL injection by escaping user inputs
        $th_title = mysqli_real_escape_string($conn, $th_title);
        $th_desc = mysqli_real_escape_string($conn, $th_desc);

        $sql = "INSERT INTO threads (thread_title, thread_desc, thread_cat_id, thread_user_id, timestamp) 
                VALUES ('$th_title', '$th_desc', '$id', 1, CURRENT_TIMESTAMP())";  // Replace '1' with actual user_id
        $result = mysqli_query($conn, $sql);

        if($result){
            echo '<div class="alert alert-success" role="alert">
                    Your thread has been added successfully!
                  </div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">
                    There was an error adding your thread. Please try again.
                  </div>';
        }
    }
    ?>

    <div class="container my-3">
        <div class="jumbotron-custom text-center">
            <h1 class="display-4">Welcome to <?php echo $catName;?></h1>
            <p class="lead"><?php echo $catDescription;?></p>
            <p>Explore our categories and get the best tips and advice.</p>
            <a class="btn btn-primary btn-lg" href="../index.php" role="button">Explore Now</a>
        </div>
    </div>

    <div class="container" id="ques">
        <h1 class="py-2">Browse Questions</h1>

        <?php 
        $sql = "SELECT * FROM threads WHERE thread_cat_id=$id";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $threadId = $row['thread_id'];
                $title = htmlspecialchars($row['thread_title']);
                $desc = htmlspecialchars($row['thread_desc']);

                echo '<div class="media my-3">
                        <img src="https://www.gravatar.com/avatar?d=identicon&s=64" class="mr-3" alt="...">
                        <div class="media-body">
                            <h5 class="mt-0"><a href="thread.php?threadid=' . $threadId . '">' . $title . '</a></h5>
                            ' . $desc . '
                        </div>
                      </div>';
            }
        } else {
            echo '<div class="jumbotron-custom text-center">
                    <h2>No Threads Found</h2>
                    <p>Be the first to ask a question!</p>
                  </div>';
        }
        ?>

        <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
            <h3>Post your concerns</h3>
            <div class="form-group">
                <label for="title" class="form-label">Post Title</label>
                <input type="text" class="form-control" id="title" name="title" aria-describedby="title"><br>
            </div>
            <div class="form-group">
                <label for="desc" class="form-label">Post Description</label>
                <textarea class="form-control" id="desc" name="desc" rows="3"></textarea><br>
            </div>
            <button class="btn btn-success" type="submit">Submit</button>
        </form>
    </div>

    <?php include '../partials/_footer.php'; ?>
</body>

</html>
