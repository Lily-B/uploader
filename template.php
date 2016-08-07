<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Upload files by Faibyshev</title>

    <!-- Bootstrap -->
    <link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="http://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css">
    <script type="text/javascript" src="http://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>

<div class="container">

    <div class="container-fluid">
        <hr>
        <div id="error">
            <?
            if ($ctrl->error)
            {
                    ?><div class="alert alert-danger" role="alert"><? echo$ctrl->error?> </div>
            <?
            }
            ?>
        </div>
        <div class="row">
            <div class="col-xs-6 col-md-4">
                <h2> Upload file</h2>

                <form action="index.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="hidden" name="MAX_FILE_SIZE" value="30000"/>
                        <input type="file" id="exampleInputFile" name="file">
                    </div>

                    <button type="submit" class="btn btn-success">Upload</button>
                </form>
            </div>
            <div class="col-xs-12 col-md-8">
                <div class="table-responsive">
                    <table id="myTable" class="display table" width="100%">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Size</th>
                            <th>Upload Date</th>
                            <th></th>
                        </tr>
                        </thead>

                        <tbody>
                        <?
                        foreach ($files as $key => $file) {
                            $link = $settings['uploadDir'] . $file['filename'];
                            if (is_file($link)) {

                                ?>
                                <tr id="file<? echo $file['id']; ?>">

                                    <td><? echo $file['filename']; ?></td>
                                    <td><? echo filesize($link); ?>b</td>
                                    <td><? echo date("Y-m-d H:i:s", $file['date']); ?></td>
                                    <td>
                                        <a type="button" class="btn btn-success"
                                           href="<? echo $link; ?>" target="_blank">Download</a>
                                        <button type="button" class="btn btn-info"
                                                onclick="deletefile('<? echo $file['id']; ?>')">Delete
                                        </button>
                                    </td>
                                </tr>
                                <?
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>


    </div>


</div>
<!-- /.container -->

<script>
    $(document).ready(function () {
        $('#myTable').dataTable();
    });
    function deletefile(id) {
        if (confirm("Are you sure?"+ id)) {
            $.ajax({
                type: "GET",
                processData: false,
                contentType: false,
                url: "delete.php?fileId=" + id
            })
                .done(function (result) {
                    json = JSON.parse(result);
                    if (json['success']) {
                        $('#error').html('<div class="alert alert-success" role="alert">The file has been successfully removed</div>');
                        $('#file' + id).html('');
                    } else {
                        $('#error').html('<div class="alert alert-danger" role="alert">' + json['error'] + '</div>');
                    }

                });
            return true;
        } else {
            alert("Deleting canceled");
            return false;
        }


        return false;

    }
</script>

</body>
</html>