<!DOCTYPE html>
<html lang="<?php echo $lang; ?>" <?php echo ($lang == 'ps' || $lang == 'fa') ? 'dir="rtl"' : ''; ?>>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Books</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        <?php if ($lang == 'ps' || $lang == 'fa') : ?>
        body {
            direction: rtl;
            text-align: right;
        }
        <?php endif; ?>

        .container-box {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }
        .search-input, .search-btn {
            border-radius: 5px;
        }
        .modal-dialog {
            margin: 30px auto;
        }
        .modal-cover-image {
            max-width: 100px;
            height: auto;
        }
        .truncate {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .modal-description {
            max-height: 200px;
            overflow-y: auto;
        }
        .book-image {
            max-width: 100px;
            height: auto;
        }
        th, td {
            white-space: nowrap;
        }
        .navbar-nav {
            font-size: 14px;
        }
        .navbar-brand {
            font-size: 18px;
            font-weight: bold;
        }
        .navbar-toggler-icon {
            font-size: 16px;
        }
        .table th {
            background-color: #f2f2f2;
            color: #333;
            font-weight: bold;
        }
        .icon-column {
            width: 150px;
        }

        @media (max-width: 576px) {
            .search-input, .search-btn {
                font-size: 14px;
                padding: 10px;
            }
            table th, table td {
                font-size: 12px;
                padding: 8px;
            }
            .book-name-column, .author-column, .genre-column {
                display: none;
            }
            .icon-column {
                width: auto;
            }
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#"><?php echo getLocalizedText('books', $lang); ?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item"><a class="nav-link" href="index.php"><?php echo getLocalizedText('books', $lang); ?></a></li>
            <li class="nav-item"><a class="nav-link" href="downpaper.php"><?php echo getLocalizedText('papers', $lang); ?></a></li>
            <li class="nav-item"><a class="nav-link" href="logout.php"><?php echo getLocalizedText('logout', $lang); ?></a></li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="languageDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo getLocalizedText('language', $lang); ?></a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="languageDropdown">
                    <a class="dropdown-item" href="?lang=en"><?php echo getLocalizedText('english', $lang); ?></a>
                    <a class="dropdown-item" href="?lang=ps"><?php echo getLocalizedText('pashto', $lang); ?></a>
                    <a class="dropdown-item" href="?lang=fa"><?php echo getLocalizedText('dari', $lang); ?></a>
                </div>
            </li>
        </ul>
    </div>
</nav>

<div class="container container-box">
    <h2 class="text-center"><?php echo getLocalizedText('books', $lang); ?></h2>
    <form method="GET" action="" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control search-input" placeholder="<?php echo getLocalizedText('search_placeholder', $lang); ?>" value="<?php echo htmlspecialchars($search_query); ?>">
            <div class="input-group-append">
                <button class="btn btn-primary search-btn" type="submit"><?php echo getLocalizedText('search_button', $lang); ?></button>
            </div>
        </div>
    </form>

    <?php if ($result->num_rows > 0) : ?>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th><?php echo getLocalizedText('cover_image', $lang); ?></th>
                    <th class="book-name-column"><?php echo getLocalizedText('book_name', $lang); ?></th>
                    <th class="icon-column"><?php echo getLocalizedText('actions', $lang); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <td><img src="<?php echo $row['cover_image']; ?>" class="book-image" alt="Book Cover"></td>
                        <td class="book-name-column"><?php echo $row['book_name']; ?></td>
                        <td>
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#bookModal<?php echo $row['book_id']; ?>"><?php echo getLocalizedText('view_details', $lang); ?></button>
                            <a href="download.php?file=<?php echo $row['pdf']; ?>" class="btn btn-success"><?php echo getLocalizedText('download_pdf', $lang); ?></a>
                        </td>
                    </tr>

                    <div class="modal fade" id="bookModal<?php echo $row['book_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="bookModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="bookModalLabel"><?php echo $row['book_name']; ?></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <img src="<?php echo $row['cover_image']; ?>" class="modal-cover-image" alt="Cover Image">
                                    <p><strong><?php echo getLocalizedText('author_name', $lang); ?>:</strong> <?php echo $row['author_name']; ?></p>
                                    <p><strong><?php echo getLocalizedText('isbn_number', $lang); ?>:</strong> <?php echo $row['isbn_number']; ?></p>
                                    <p><strong><?php echo getLocalizedText('publication_date', $lang); ?>:</strong> <?php echo $row['publication_date']; ?></p>
                                    <p><strong><?php echo getLocalizedText('publisher', $lang); ?>:</strong> <?php echo $row['publisher']; ?></p>
                                    <p><strong><?php echo getLocalizedText('description', $lang); ?>:</strong> <?php echo $row['description']; ?></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo getLocalizedText('close', $lang); ?></button>
                                    <a href="download.php?file=<?php echo $row['pdf']; ?>" class="btn btn-primary"><?php echo getLocalizedText('download_pdf', $lang); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p><?php echo getLocalizedText('no_books_found', $lang); ?></p>
    <?php endif; ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>