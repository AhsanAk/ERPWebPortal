<?php
session_start();

if(isset($_SESSION['name'])||isset($_COOKIE['name'])||isset($_COOKIE['deo'])||isset($_SESSION['deo'])||isset($_SESSION['student'])||isset($_COOKIE['student'])){

    if(isset($_SESSION['name'])||isset($_COOKIE['name'])||isset($_COOKIE['deo'])||isset($_SESSION['deo'])){
        include_once 'header.php';
        include_once 'navbar.php';
        include_once 'includes/connection.php';
    }else if(isset($_SESSION['student'])||isset($_COOKIE['student'])){
        include_once 'includes/connection.php';
        include_once 'header.php';
        include_once 'navbar_student.php';
    }

        ?>


<div class="container-fluid profileHeading">
    <div class="row">
        <div class="col-sm-12">
            <h2 class="sub-header" id="sub-header">DUET Library</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">

            <table class="table table-responsive table-bordered">
                <tr>
                    <th>Department</th>
                </tr>
                <?php
                $queryDepart = 'SELECT * FROM department';
                $queryRunDepart = mysqli_query($connection, $queryDepart);
                while($row = mysqli_fetch_assoc($queryRunDepart)){
                    echo "<tr class='trId_".$row['dept_id']."'>";
                    echo "<td class='td_btn'><a class='btn' href='javascript:;'>".$row['dept_name']."</a> </td>";
                    echo "</tr>";
                }

                ?>
            </table>


        </div>

        <div class="col-lg-9" id="results">


        </div>
    </div>


</div>
    <div class="modal animated flipInX" id="myModalRequest" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">REQUEST FOR THIS BOOK</h4>
                </div>
                <div class="modal-body text-center">

                    <h3>Do you want to send request to librarian for book?</h3>
                    <input type="hidden" name="yesRequestId" id="yesRequestId">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" id="yesRequest">Yes</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal" id="deletedModalClose">No</button>
                </div>
            </div>
        </div>
    </div>


    <script src="scroll.js"></script>
    <div id="spinner">
    </div>

    <script src="spinnerLoading.js"></script>
    <script>

        $(document).ready(function(){


            $('#yesRequest').click(function(){

                var url, values;
                url = 'library_data.php';
                values = $('#yesRequestId').val();



                $.ajax({

                    type: 'POST',
                    url: url,
                    data: {'yesRequestId': values},
                    success:function(data){
                        data = data.trim();
                        if(data=='inserted'){
                            rowID = 'trId_'+rowID;
                           $('.'+rowID).find('.td_btn').click();
                        }
                    }


                });


            });

        var rowID;

            $('.td_btn').click(function(){



                var row = $(this).closest('tr');
                 rowID = row.attr('class').split('_')[1];


                $('#results').html('<i class="fa fa-2x fa-spinner fa-pulse animated flip"></i>');


                var url, values;
                url = 'library_data.php';
                values = rowID;



                $.ajax({

                    type: 'POST',
                    url: url,
                    data: {'id': values},
                    success:function(data){
                        data = data.trim();
                        $('#results').html(data);

                        $('.requestBtn').click(function(){

                            var row = $(this).closest('tr');
                            var book_id = row.find('.hidden').text();
                            $('#yesRequestId').val(book_id);
                            $('#myModalRequest').modal('show');
                            $('#yesRequest').focus();
                        });


                    }






                });



            });




        });

    </script>



    <?php

    if(isset($_SESSION['name'])||isset($_COOKIE['name'])||isset($_COOKIE['deo'])||isset($_SESSION['deo'])){
        include_once 'footer.php';
    }else if(isset($_SESSION['student'])||isset($_COOKIE['student'])){
        include_once 'footer_student.php';
    }



}else{
    header('Location: index.php');
}


?>