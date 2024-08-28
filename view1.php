<?php
include 'connection.php';

// Construct the SQL query for retrieving the research papers based on search query
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Research Papers</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .modal-dialog {
            margin: 30px auto;
        }
        .truncate {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .modal-description {
            max-height: 80px;
            overflow-y: auto;
        }
        .table td, .table th {
            vertical-align: middle;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container-fluid mt-5">
    <form class="form-inline mb-3" method="get">
        <input class="form-control mr-sm-2" type="search" placeholder="Search by Title or Author Name" aria-label="Search" name="search" id="searchInput" value="<?php echo isset($search_query) ? htmlspecialchars($search_query) : ''; ?>">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
    <div class="table-responsive" id="tableContainer">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Paper Title</th>
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
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    <?php endif; ?>
</div>

<!-- Bootstrap and custom scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
$(document).ready(function() {
    $('#searchInput').keyup(function() {
        var query = $(this).val();
        $.ajax({
            url: 'search1.php',
            method: 'GET',
            data: {search: query},
            success: function(data) {
                $('#tableContainer').html($(data).find('#tableContainer').html());
                $('#modalContainer').html($(data).find('#modalContainer').html());
            }
        });
    });
});
</script>
</body>
</html>
