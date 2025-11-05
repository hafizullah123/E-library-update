<?php
include 'header.php';

if(!isset($_GET['id'])) {
    echo "Book ID missing";
    exit;
}
$book_id = intval($_GET['id']);

// Fetch book
$stmt = $conn->prepare("SELECT * FROM books WHERE book_id=?");
$stmt->bind_param("i", $book_id);
$stmt->execute();
$result = $stmt->get_result();
$book = $result->fetch_assoc();

if(!$book){
    echo "Book not found";
    exit;
}

// Handle update
if($_SERVER['REQUEST_METHOD']=='POST'){
    $book_name = $_POST['book_name'];
    $author_name = $_POST['author_name'];
    $isbn_number = $_POST['isbn_number'];
    $genre = $_POST['genre'];
    $publisher = $_POST['publisher'];
    $description = $_POST['description'];
    $publication_date = $_POST['publication_date'];

    $cover_image = $book['cover_image'];
    $pdf = $book['pdf'];

    if(isset($_FILES['cover_image']) && $_FILES['cover_image']['name']!=""){
        $cover_image = "uploads/".basename($_FILES['cover_image']['name']);
        move_uploaded_file($_FILES['cover_image']['tmp_name'], $cover_image);
    }

    if(isset($_FILES['pdf']) && $_FILES['pdf']['name']!=""){
        $pdf = "uploads/".basename($_FILES['pdf']['name']);
        move_uploaded_file($_FILES['pdf']['tmp_name'], $pdf);
    }

    $stmt = $conn->prepare("UPDATE books SET book_name=?, author_name=?, isbn_number=?, genre=?, cover_image=?, pdf=?, publication_date=?, publisher=?, description=? WHERE book_id=?");
    $stmt->bind_param("sssssssssi", $book_name, $author_name, $isbn_number, $genre, $cover_image, $pdf, $publication_date, $publisher, $description, $book_id);
    if($stmt->execute()){
        echo "<div class='alert alert-success'>Book updated successfully!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: ".$conn->error."</div>";
    }
}
?>
<form method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label><?php echo t('book_name',$lang); ?></label>
        <input type="text" class="form-control" name="book_name" value="<?php echo htmlspecialchars($book['book_name']); ?>">
    </div>
    <div class="form-group">
        <label><?php echo t('author_name',$lang); ?></label>
        <input type="text" class="form-control" name="author_name" value="<?php echo htmlspecialchars($book['author_name']); ?>">
    </div>
    <div class="form-group">
        <label><?php echo t('isbn_number',$lang); ?></label>
        <input type="text" class="form-control" name="isbn_number" value="<?php echo htmlspecialchars($book['isbn_number']); ?>">
    </div>
    <div class="form-group">
        <label><?php echo t('genre',$lang); ?></label>
        <input type="text" class="form-control" name="genre" value="<?php echo htmlspecialchars($book['genre']); ?>">
    </div>
    <div class="form-group">
        <label><?php echo t('cover_image',$lang); ?></label>
        <input type="file" class="form-control" name="cover_image">
    </div>
    <div class="form-group">
        <label><?php echo t('pdf',$lang); ?></label>
        <input type="file" class="form-control" name="pdf">
    </div>
    <div class="form-group">
        <label><?php echo t('publication_date',$lang); ?></label>
        <input type="date" class="form-control" name="publication_date" value="<?php echo $book['publication_date']; ?>">
    </div>
    <div class="form-group">
        <label><?php echo t('publisher',$lang); ?></label>
        <input type="text" class="form-control" name="publisher" value="<?php echo htmlspecialchars($book['publisher']); ?>">
    </div>
    <div class="form-group">
        <label><?php echo t('description',$lang); ?></label>
        <textarea class="form-control" name="description"><?php echo htmlspecialchars($book['description']); ?></textarea>
    </div>
    <button class="btn btn-primary"><?php echo t('update',$lang); ?></button>
</form>
<?php include 'footer.php'; ?>
