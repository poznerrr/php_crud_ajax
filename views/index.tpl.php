<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PHP CRUD wit AJAX, MySQL and BOOTSTRAP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="shortcut icon" href="assets/favicon.ico" type="image/x-icon">
    <style>
        #loader {
            background: rgba(255, 255, 255, 0.7);
            text-align: center;
            position: absolute;
            top: 150px;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 2;
            display: none;
        }

        #loader img {
            width: 100px;
        }

        #clear-search {
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center h2 my-3"> PHP CRUD wit AJAX, MySQL and BOOTSTRAP </h1>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-6">
                        <button class="btn btn-primary rounded-0 btn-add" data-bs-toggle="modal" data-bs-target="#addCity">
                            Add
                            city
                        </button>
                    </div>
                    <div class="col-6">
                        <div class="input-group mb-3">
                            <input type="text" id="search" class="form-control" placeholder="Search...">
                            <span class="input-group-text" id="clear-search">&times;</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div id="loader">
            <img src="assets/ripple.svg" alt="">
        </div>

        <div class="table-responsive my-3">
            <?php require_once 'views/index-content.tpl.php' ?>
        </div>
    </div>
</div>
</div>
<!-- Modal add city -->
<div class="modal fade" id="addCity" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add city</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" id="addCityForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="addName" class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" id="addName" placeholder="City name">
                    </div>
                    <div class="mb-3">
                        <label for="addPopulation" class="form-label">Population</label>
                        <input type="number" name="population" class="form-control" id="addPopulation"
                               placeholder="City population">
                        <input type="hidden" name="addCity">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="btn-add-submit">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal edit City -->
<div class="modal fade" id="editCity" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit city</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="editCityForm">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editName" class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" id="editName" placeholder="City name">
                        </div>
                        <div class="mb-3">
                            <label for="editPopulation" class="form-label">Population</label>
                            <input type="number" name="population" class="form-control" id="editPopulation"
                                   placeholder="City population">
                            <input type="hidden" name="editCity">
                            <input type="hidden" name="id" id="id">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="btn-edit-submit">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="/assets/mark.min.js"></script>
<script src="/assets/main.js"></script>
</body>
</html>
