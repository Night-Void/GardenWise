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
        #ques{
            min-height: 433 px;
        }
        </style>
</head>
<body>
    <?php @include 'partials/_header.php'; ?> 
    <?php @include 'partials/_dbconnect.php'; ?>

    <div class="container my-3" id="ques">
        <h2 class="text-center">GardenWise Categories</h2>
        <div class="row my-4">
        
        <?php 
        $sql = "SELECT * FROM categories";
        $result = mysqli_query($conn, $sql);
        
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $catId = $row['category_id'];
                $catName = $row['category_name'];
                $catDescription = $row['category_description'];
                // Adjust the image source URL or use a default image
                $imgSrc = "partials/gw11.jpeg";

                echo '<div class="col-md-3 mb-4">
                        <div class="card" style="width: 18rem;">
                            <img src="' . $imgSrc . '" class="card-img-top" alt="' . htmlspecialchars($catName) . '">
                            <div class="card-body">
                                <h5 class="card-title"><a href="partials/threadlist.php?catid=' . $catId . '">' . htmlspecialchars($catName) . '</a></h5>
                                <p class="card-text">' . htmlspecialchars($catDescription) . '</p>
                            </div>
                        </div>
                    </div>';
            }
        } else {
            echo "Error: " . mysqli_error($conn);
        }

        ?>

    </div>
      </div>
</body>
</html>
