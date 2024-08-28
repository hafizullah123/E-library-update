<?php
include 'connection.php';

$search_query = $_GET['search'] ?? '';

$sql = "SELECT * FROM research_papers";
if (!empty($search_query)) {
    $sql .= " WHERE title LIKE '%$search_query%' OR author_name LIKE '%$search_query%'";
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
                <th>Title</th>
                <th>Description</th>
                <th>Author</th>
                <th>Publication Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                        <td class="truncate"><?php echo htmlspecialchars(getFirstFiveWords($row['description'])); ?></td>
                        <td><?php echo htmlspecialchars($row['author_name']); ?></td>
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

<!-- Modals -->
<div id="modalContainer">
    <?php if ($result && $result->num_rows > 0): ?>
        <?php $result->data_seek(0); ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="modal fade" id="paperModal_<?php echo $row['paper_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="paperModalLabel_<?php echo $row['paper_id']; ?>" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="paperModalLabel_<?php echo $row['paper_id']; ?>"><?php echo htmlspecialchars($row['title']); ?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="modal-description"><?php echo htmlspecialchars($row['description']); ?></div>
                            <p><strong>Author:</strong> <?php echo htmlspecialchars($row['author_name']); ?></p>
                            <p><strong>Publication Date:</strong> <?php echo htmlspecialchars($row['publication_date']); ?></p>
                            <!-- Add more details here -->
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    <?php endif; ?>
</div>
