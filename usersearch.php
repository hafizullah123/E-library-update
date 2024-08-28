<?php
include 'connection.php';

// Fetch category from URL parameters
$category = $_GET['category'] ?? '';

// Construct the SQL query for retrieving the research papers based on search query
$sql_papers = "SELECT * FROM research_papers";
$search_query = $_GET['search'] ?? '';
if (!empty($search_query)) {
    $sql_papers .= " WHERE title LIKE '%$search_query%' OR author_name LIKE '%$search_query%'";
}
$result_papers = $conn->query($sql_papers);

// Construct the SQL query for retrieving the books based on search query
$sql_books = "SELECT * FROM books";
if (!empty($search_query)) {
    $sql_books .= " WHERE book_name LIKE '%$search_query%' OR isbn_number LIKE '%$search_query%'";
}
$result_books = $conn->query($sql_books);

function getFirstFiveWords($text) {
    $words = explode(' ', $text);
    return implode(' ', array_slice($words, 0, 5));
}
?>

<!-- Research Papers Table -->
<div class="table-responsive" id="paperTableContainer">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Author</th>
                <th>Publication Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result_papers && $result_papers->num_rows > 0): ?>
                <?php while ($row = $result_papers->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                        <td class="truncate"><?php echo htmlspecialchars(getFirstFiveWords($row['description'])); ?></td>
                        <td><?php echo htmlspecialchars($row['author_name'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($row['publication_date']); ?></td>
                        <td class="icon-column"><a href="#" class="btn btn-info view-btn" data-toggle="modal" data-target="#paperModal_<?php echo $row['paper_id']; ?>"><i class="fas fa-eye"></i> View</a></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="5">No research papers found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Books Table -->
<div class="table-responsive" id="bookTableContainer">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Book Name</th>
                <th>Description</th>
                <th>Author</th>
                <th>ISBN</th>
                <th>Publication Date</th>
                <th>Publisher</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result_books && $result_books->num_rows > 0): ?>
                <?php while ($row = $result_books->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['book_name']); ?></td>
                        <td class="truncate"><?php echo htmlspecialchars(getFirstFiveWords($row['description'])); ?></td>
                        <td><?php echo htmlspecialchars($row['author_name'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($row['isbn_number']); ?></td>
                        <td><?php echo htmlspecialchars($row['publication_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['publisher']); ?></td>
                        <td class="icon-column"><a href="#" class="btn btn-info view-btn" data-toggle="modal" data-target="#bookModal_<?php echo $row['book_id']; ?>"><i class="fas fa-eye"></i> View</a></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="7">No books found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
