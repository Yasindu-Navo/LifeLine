<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">

    <title>News</title>
</head>

<body style="background-color: rgb(224, 232, 225);">

    <div class="container" style="margin-left: 320px;">
        <form method="POST" action="pform.php" enctype="multipart/form-data">
            <div class="col-md-12 " style="margin-left: 280px;">
                <br><br>
                <h2 style="margin-bottom: 25px;">Past Story</h2>
            </div>
            <?php
            if (isset($_GET['message'])) {
                if ($_GET['message'] == 1) {
                    echo "
        <div class='alert alert-success alert-dismissible fade show' role='alert'>
            <strong>Data updated successfully!</strong> 
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
                }
            }
            if (isset($_GET['message'])) {
                if ($_GET['message'] == 2) {
                    echo "
        <div class='alert alert-warning alert-dismissible fade show' role='alert'>
            <strong>Error updating data!</strong> 
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
                }
            }
            if (isset($_GET['message'])) {
                if ($_GET['message'] == 3) {
                    echo "
        <div class='alert alert-warning alert-dismissible fade show' role='alert'>
            <strong>Error updating image!</strong> 
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
                }
            }
            if (isset($_GET['message'])) {
                if ($_GET['message'] == 4) {
                    echo "
        <div class='alert alert-warning alert-dismissible fade show' role='alert'>
            <strong>Please enter valid data!</strong> 
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
                }
            }

            ?>

            <!-- <div class="col-12">
                <label class="">Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div> -->

            <div class="row mb-3">
                <label class="col-sm-1 col-form-label">Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="title" required>
                </div>
            </div>

            <!-- <div class="col-12">
                <label class="">Content</label>
                <textarea class="form-control" name="content" rows="4"></textarea>
            </div> -->

            <div class="row mb-3">
                <label class=" col-sm-1 col-form-label">Content</label>
                <div class="col-sm-6">
                    <textarea class="form-control" id="condition" style="height: 150px" name="content"  required></textarea>
                </div>
            </div>

            <!-- <div class="col-12">
                <label class="">Date</label>
                <input type="date" class="form-control" id="date" name="date" required>


            </div> -->

            <div class="row mb-3">
                <label class=" col-sm-1 col-form-label">Date</label>
                <div class="col-sm-6">
                    <input class="form-control" type="date" id="" name="date"  required>
                </div>
            </div>

            <!-- <div class="col-12">
                <label class="">Image</label>
                <input type="file" class="form-control" id="image" name="image" required>

            </div> -->
            <div class="row mb-3">
                <label class="col-sm-1 col-form-label">Image</label>
                <div class="col-sm-6">
                    <input class="form-control" type="file" id="image" name="image"  required>
                </div>
            </div>



            <br>
            <br>
            <!-- <div class="col-12">
                <button type="submit" class="btn btn-secondary">Submit</button>
                <button class="btn btn-secondary"><a href="../New_Admin_Pannel/past_story.php" style="text-decoration: none;">Cancel</a></button>
            </div> -->

            <div class=" row mb-3">

                <div class="offset-sm-3 col-sm-3 d-grid" style="margin-left: 30px; margin-right:60px;">
                    <button type="submit" class="btn btn-outline-success" name="resubmit">Submit</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a type="submit" class="btn btn-outline-success" href="../New_Admin_Pannel/past_story.php" role="button">Cancel</a>
                </div>
            </div>
        </form>

    </div>
</body>

</html>