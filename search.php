<?php
include 'connection.php';

// Construct the SQL query for retrieving the books based on search query
$search_query = $_GET['search'] ?? '';
$sql = "SELECT * FROM books";
if (!empty($search_query)) {
    $sql .= " WHERE book_name LIKE '%$search_query%' OR isbn_number LIKE '%$search_query%'";
}
$result = $conn->query($sql);

function getFirstFiveWords($text) {
    $words = explode(' ', $text);
    return implode(' ', array_slice($words, 0, 5));
}
?>

<div class="table-responsive" id="tableContainer">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Cover Image</th>
                <th>Book Name</th>
                <th>Description</th>
                <th>Genre</th>
                <th>Author</th>
                <th>ISBN</th>
                <th>Publication Date</th>
                <th>Publisher</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><img src="<?php echo htmlspecialchars($row['cover_image']); ?>" alt="Cover Image" class="modal-cover-image" data-toggle="modal" data-target="#bookModal_<?php echo $row['book_id']; ?>"></td>
                        <td><?php echo htmlspecialchars($row['book_name']); ?></td>
                        <td class="truncate"><?php echo htmlspecialchars(getFirstFiveWords($row['description'])); ?></td>
                        <td><?php echo htmlspecialchars($row['genre']); ?></td>
                        <td><?php echo htmlspecialchars($row['author_name'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($row['isbn_number']); ?></td>
                        <td><?php echo htmlspecialchars($row['publication_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['publisher']); ?></td>
                        <td class="icon-column"><a href="#" class="btn btn-info view-btn" data-toggle="modal" data-target="#bookModal_<?php echo $row['book_id']; ?>"><i class="fas fa-eye"></i> View</a></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="9">No books found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Modals -->
<div id="modalContainer">
    <?php if ($result && $result->num_rows > 0): ?>
        <?php $result->data_seek(0); ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="modal fade" id="bookModal_<?php echo $row['book_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="bookModalLabel_<?php echo $row['book_id']; ?>" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="bookModalLabel_<?php echo $row['book_id']; ?>"><?php echo htmlspecialchars($row['book_name']); ?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <img src="<?php echo htmlspecialchars($row['cover_image']); ?>" alt="Cover Image" class="modal-cover-image">
                            <div class="modal-description"><?php echo htmlspecialchars($row['description']); ?></div>
                            <p><strong>Genre:</strong> <?php echo htmlspecialchars($row['genre']); ?></p>
                            <p><strong>Author:</strong> <?php echo htmlspecialchars($row['author_name']); ?></p>
                            <p><strong>ISBN:</strong> <?php echo htmlspecialchars($row['isbn_number']); ?></p>
                            <p><strong>Publication Date:</strong> <?php echo htmlspecialchars($row['publication_date']); ?></p>
                            <p><strong>Publisher:</strong> <?php echo htmlspecialchars($row['publisher']); ?></p>
                            <a href="<?php echo htmlspecialchars($row['pdf']); ?>" target="_blank" class="btn btn-primary">Download PDF</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    <?php endif; ?>
</div>
