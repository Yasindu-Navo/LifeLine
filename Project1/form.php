<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/pform.css">

    <title>News</title>
</head>
<body>

    <section>

        <div class="form-box">
            <div class="form-value">
                <form method="POST" action="pform.php" enctype="multipart/form-data">
                    <div class="col-md-12 text-center">
                        <br><br>
                        <h2>Past Story</h2>
                    </div>


                    <label class="label">Title</label>
                    <input type="text" class="form-control" id="title" name="title" required>


                    <label class="label">Content</label>
                    <textarea class="form-control" name="content" rows="4"></textarea>


                    <label class="label">Date</label>
                    <input type="text" class="form-control" id="date" name="date" required>



                    <label class="label">Image</label>
                    <input type="file" class="form-control" id="image" name="image" required>
                    <br>
                    <button>Submit</button>

                    <br>
                    <br>
                </form>
            </div>
        </div>
    </section>
</body>
</html>

