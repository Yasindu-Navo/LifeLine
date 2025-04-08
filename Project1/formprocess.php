<?php
class PastStory {
    private $title;
    private $content;
    private $date;
    private $image;

    function __construct($title, $content, $date, $image) {
        $this->title = $title;
        $this->content = $content;
        $this->date = $date;
        $this->image = $image;
    }

    public function validate() {
        if (empty($this->title) || empty($this->content) || empty($this->date) || empty($this->image)) {
            echo "All fields must be filled!";
            return false;
        }
        return true;
    }

    public function handleForm($con) {
        $query = "INSERT INTO paststory (`title`, `content`, `date`, `image`) VALUES (?,?,?,?)";
        try {
            $pstmt = $con->prepare($query);
            $pstmt->bindValue(1, $this->title);
            $pstmt->bindValue(2, $this->content);
            $pstmt->bindValue(3, $this->date);
            $pstmt->bindValue(4, $this->image);

            return $pstmt->execute();
        } catch (PDOException $exc) {
            echo "Error occurred: " . $exc->getMessage();
        }
    }
}



?>
