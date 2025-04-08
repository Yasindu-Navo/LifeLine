<?php
require 'db_connector(rev).php'; // Include the database connection file

// Review class to handle review-related operations
class Review {
    private $db;

    // Constructor to create a database connection
    public function __construct() {
        $this->db = new Database();
    }

    // Function to add a review to the database
    public function addReview($name, $comment, $rating) {
        $stmt = $this->db->conn->prepare("INSERT INTO reviews (name, comment, rating) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $name, $comment, $rating);
        $stmt->execute();
        $stmt->close();
    }
}

// Check the request method 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $comment = $_POST['comment'];
    $rating = $_POST['rating'];

    // Create a new  object and add the review
    $review = new Review();
    $review->addReview($name, $comment, $rating);

    // Redirect to the home page after submitting
    header("Location: /Project1/Afterindex.php");
}
?>
