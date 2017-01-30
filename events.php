<?php session_start(); ?>

<?php if(isset($_COOKIE['name'])||isset($_SESSION['name'])||isset($_COOKIE['deo'])||isset($_SESSION['deo'])||isset($_COOKIE['student'])||isset($_SESSION['student'])||isset($_COOKIE['teacher'])||isset($_SESSION['teacher'])){ ?>
    <?php include_once('includes/connection.php') ?>
    <?php include_once('header.php');

    if(isset($_COOKIE['name'])||isset($_SESSION['name'])||isset($_COOKIE['deo'])||isset($_SESSION['deo'])){
        include_once('navbar.php'); }

    else if(isset($_COOKIE['student'])||isset($_SESSION['student'])){
    include_once('navbar_student.php'); }

    else if(isset($_COOKIE['teacher'])||isset($_SESSION['teacher'])){
        include_once('navbar_teacher.php'); }?>





<div class="container-fluid profileHeading">
    <div class="row">
        <div class="col-sm-12">
            <h2 class="sub-header" id="sub-header">EVENTS</h2>
            <?php if(isset($_COOKIE['name'])||isset($_SESSION['name'])||isset($_COOKIE['deo'])||isset($_SESSION['deo'])){ ?>
            <button class="btn btn-primary" id="addevent">Add New</button>

            <form action="<?php echo htmlentities('insert_event.php') ?>" id="insertEvent" name="insertEvent" method="post">

              <div class="row">
                  <div class="col-lg-3">
                      <div class="form-group">
                          <label for="eventTitle">Event Title</label>
                          <input type="text" name="eventTitle" id="eventTitle" maxlength="40" class="form-control" autofocus required>
                      </div>
                  </div>

                  <div class="col-lg-4">
                      <div class="form-group">
                          <label for="eventPlace">Event Place</label>
                          <input type="text" name="eventPlace" id="eventPlace"  maxlength="32" class="form-control" required>
                      </div>
                  </div>

                  <div class="col-lg-3">
                      <div class="form-group">
                          <label for="eventFor">Event For</label>
                          <select name="eventFor" id="eventFor" class="form-control" required>
                              <option value="all">All</option>
                              <option value="teachers">Teachers</option>
                              <option value="students">Students</option>
                          </select>
                      </div>
                  </div>
                  <div class="col-lg-2">
                      <div class="form-group">
                          <label for="eventDate">Event Date</label>
                          <input type="text" class="form-control" id="eventDate" name="eventDate" required>
                      </div>
                  </div>
                  <div class="col-lg-3">
                      <div class="form-group">
                          <label for="eventTime">Event Timing</label>
                          <select name="eventTime" id="eventTime" class="form-control" required>
                              <option value="">Please Select</option>
                              <option value="9to10">9:00 to 10:00</option>
                              <option value="10to11">10:00 to 11:00</option>
                              <option value="11to12">11:00 to 12:00</option>
                              <option value="12to12">12:00 to 13:00</option>
                              <option value="13to14">13:00 to 14:00</option>
                              <option value="14to15">14:00 to 15:00</option>
                              <option value="15to16">15:00 to 16:00</option>
                          </select>
                      </div>
                  </div>
                  <div class="col-lg-5">
                      <div class="form-group">
                          <label for="eventDesp">Event Description</label>
                          <textarea name="eventDesp" id="eventDesp" cols="30" rows="3" class="form-control" required></textarea>
                      </div>
                  </div>

              </div>
                <div id="submitEvent">
                    <button class="btn btn-primary" id="eventInsert" type="submit">Submit</button>
                    <span class="rono_err btn btn-danger pull-right"></span><i class="fa fa-spinner fa-pulse insert_loading pull-right"></i>
                </div>

                <div id="outputEvent"></div>

            </form>

            <!-- Modal View -->
            <div class="modal fade" id="myModalView" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h2 class="modal-title text-primary text-center" id="myModalLabelView"></h2>
                        </div>
                        <div class="modal-body">

                            <h3>Event Place</h3>
                            <p class="lead" id="viewEventPlace"></p>

                            <h3>Event For</h3>
                            <p class="lead" id="viewEventFor"></p>

                            <h3>Event Date</h3>
                            <p class="lead" id="viewEventDate"></p>

                            <h3>Event Description</h3>
                            <p class="lead" id="viewEventDesp"></p>
                            <h3>Event Timings</h3>
                            <p class="lead" id="viewEventTime"></p>


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal" >Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Edit -->
            <div class="modal fade" id="myModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h2 class="modal-title text-primary text-center" id="myModalLabelEdit">EDIT EVENT</h2>
                        </div>
                        <div class="modal-body">

                            <form action="<?php echo htmlentities('update_event.php') ?>" id="updateEvent" name="updateEvent" method="post">
                                        <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="updateEventTitle">Event Title</label>
                                            <input type="text"  name="updateEventTitle" id="updateEventTitle"  maxlength="40" class="form-control" autofocus required>
                                        </div></div>
                                        <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="updateEventPlace">Event Place</label>
                                            <input type="text" name="updateEventPlace" id="updateEventPlace"  maxlength="32" class="form-control" required>
                                        </div>
                                        </div>
                                <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="updateEventFor">Event For</label>
                                            <select name="updateEventFor" id="updateEventFor" class="form-control" required>
                                                <option value="all">All</option>
                                                <option value="teachers">Teachers</option>
                                                <option value="students">Students</option>
                                            </select>
                                        </div>
                                        </div>
                                <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="updateEventDate">Event Date</label>
                                            <input type="text" class="form-control" id="updateEventDate" name="updateEventDate" required>
                                        </div>
                                        </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="updateEventTime">Event Timings</label>
                                        <select name="updateEventTime" id="updateEventTime" class="form-control" required>
                                            <option value="">Please Select</option>
                                            <option value="9to10">9:00 to 10:00</option>
                                            <option value="10to11">10:00 to 11:00</option>
                                            <option value="11to12">11:00 to 12:00</option>
                                            <option value="12to12">12:00 to 13:00</option>
                                            <option value="13to14">13:00 to 14:00</option>
                                            <option value="14to15">14:00 to 15:00</option>
                                            <option value="15to16">15:00 to 16:00</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                        <div class="form-group">
                                            <label for="updateEventDesp">Event Description</label>
                                            <textarea name="updateEventDesp" id="updateEventDesp" cols="30" rows="3" class="form-control" required></textarea>

                                </div>
                                </div>

                        <div class="col-lg-12">
                        </div>

                                <input type="hidden" name="updateId" id="updateId">
                                <div id="submitEvent" style="visibility: hidden;">

                                    <div style="margin-bottom:2px">a</div>
                                </div>

                        </div>
                        <div class="modal-footer">

                            <span class="pull-left" id="outputEventUpdate"></span><button type="submit" class="btn btn-success" id="updateEventBtn" >Update</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>

                        </div>

                        </form></div>
                </div>
            </div>

            <!-- Modal CONFIRM DELETE-->
            <div class="modal animated flipInX" id="myModalDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title text-danger" id="myModalLabel">ALERT</h4>
                        </div>
                        <div class="modal-body  text-center">

                            <form action="<?php echo htmlentities('update_event.php'); ?>" method="post" id="submitDeleteEventForm">
                                <input type="hidden" name="submitDeleteEvent" id="submitDeleteEvent">
                            </form>

                            <h2 id="sureText">Are you sure?</h2>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" id="deleteYes">DELETE</button>
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Modal  DELETED-->
            <div class="modal animated flipInX" id="myModalDeleted" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title text-danger" id="myModalLabel">ALERT</h4>
                        </div>
                        <div class="modal-body  text-center">

                            <h1 class="text-danger">Event has been deleted successfully.</h1>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal" id="deletedModalClose">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <?php } ?>


            <table class="table table-responsive table-bordered eventTable">
                <tr>
                    <th>S.NO</th>
                    <th>Event Name</th>
                    <th>Event Place</th>
                    <th>For</th>
                    <th>Date</th>
                    <th>Event Description</th>
                    <th>Timing</th>
                    <?php if(isset($_COOKIE['name'])||isset($_SESSION['name'])||isset($_COOKIE['deo'])||isset($_SESSION['deo'])){ ?>
                    <th>Operations</th>
                    <?php } ?>
                </tr>
                <?php
                $counter=0;
                if(isset($_COOKIE['name'])||isset($_SESSION['name'])||isset($_COOKIE['deo'])||isset($_SESSION['deo'])) {
                    $eventquery = mysqli_query($connection, "Select * from events");
                }
                else if(isset($_COOKIE['student'])||isset($_SESSION['student'])){
                    $eventquery = mysqli_query($connection, "Select * from events where event_for='students' or event_for='all'");
                }
                else if(isset($_COOKIE['teacher'])||isset($_SESSION['teacher'])){
                    $eventquery = mysqli_query($connection, "Select * from events where event_for='teachers' or event_for='all'");
                }
                if(!mysqli_num_rows($eventquery) > 0){
                    echo "<tr>
                  <td colspan='8' class='animated flash text-info'>No upcoming events.</td>
                  </tr>";
                }else {
                while ($row = mysqli_fetch_assoc($eventquery)){
                $counter = $counter + 1;
                $id = $row['id'];
                $title = $row['event_title'];
                $place = $row['event_place'];
                $for = $row['event_for'];
                $date = $row['event_date'];
                $desp = $row['event_description'];
                $time = $row['event_time'];
                ?>
                <tbody>
                <?php echo "<tr class='trID_$id'>"; ?>
                <td><?php echo $counter; ?></td>
                <?php
                echo "<td class='td_title'>$title</td>";
                echo "<td class='td_place'>$place</td>";
                echo "<td class='td_for'>$for</td>";
                echo "<td class='td_date'>$date</td>";
                if(isset($_COOKIE['name'])||isset($_SESSION['name'])||isset($_COOKIE['deo'])||isset($_SESSION['deo'])) {
                    echo "<td class='td_desp'>" . substr($desp, 0, 10) . " ...</td>";
                }
                else{
                    echo "<td class='td_desp'>$desp</td>";
                }
                echo "<td class='td_despHidden'>$desp</td>";
                echo "<td class='td_time'>$time</td>";
                ?>
                <?php if(isset($_COOKIE['name'])||isset($_SESSION['name'])||isset($_COOKIE['deo'])||isset($_SESSION['deo'])){ ?>
                <td>
                    <button class="btn btn-primary btn-flat td_btnView" data-toggle="modal" title="view"><i
                            class="fa fa-eye"></i></button>
                    <button class="btn btn-info btn-flat td_btnEdit" data-toggle="modal" title="edit"><i
                            class="fa fa-pencil"></i></button>
                    <button class="btn btn-danger btn-flat td_btnDelete" title="remove"><i class="fa fa-trash-o"></i>
                    </button>
                </td>
                    <?php } ?>
                <?php
                echo "</tr>";

                }
                }?>

                </tbody>
            </table>

            </div>

            </div>
            </div>

    <div id="spinner">
    </div>

    <script src="spinnerLoading.js"></script>
    <script>

        $(document).ready(function(){

            $('#updateEvent').submit(function(){


                var url,values;

                url = $(this).attr('action');
                values = $(this).serialize();


                $('#outputEventUpdate').html('<i class="fa fa-2x fa-spinner fa-pulse animated flip"></i>');
                $('#updateEventBtn').prop('disabled', true);

                $.ajax({

                    type: 'POST',
                    url: url,
                    data: values,
                    success:function(data){
                        if(data.trim() == 'updated'){
                            $('#outputEventUpdate').html('<p class="animated bounceInLeft text-success lead">Updated successfully.</p>');
                            setTimeout(function(){
                                window.location.href = 'events.php';
                            }, 2500);
                        }
                    }

                });


                return false;

            });



            $('.td_btnView').click(function(){

                var row = $(this).closest('tr');
                var title =  row.find('.td_title').text();
                var place =  row.find('.td_place').text();
                var event_for =  row.find('.td_for').text();
                var date =  row.find('.td_date').text();
                var time =  row.find('.td_time').text();
                var desp =  row.find('.td_despHidden').text();


                $('#myModalLabelView').text(title.toUpperCase());
                $('#viewEventPlace').text(place);
                $('#viewEventFor').text(event_for);
                $('#viewEventDate').text(date);
                $('#viewEventDesp').text(desp);
                $('#viewEventTime').text(time);

                $('#myModalView').modal('show');
                $('#closeFooter').focus();

            });
            $('.td_btnEdit').click(function(){

                var row = $(this).closest('tr');
                var rowID = row.attr('class').split('_')[1];
                var title =  row.find('.td_title').text();
                var place =  row.find('.td_place').text();
                var event_for =  row.find('.td_for').text();
                var date =  row.find('.td_date').text();
                var desp =  row.find('.td_despHidden').text();
                var time =  row.find('.td_time').text();


                $('#updateId').val(rowID);
                $('#updateEventTitle').val(title);
                $('#updateEventPlace').val(place);
                $('#updateEventFor').val(event_for);
                $('#updateEventDate').val(date);
                $('#updateEventDesp').val(desp);
                $('#updateEventTime').val(time);

                $('#myModalEdit').modal('show');


            });



            $('.td_btnDelete').click(function(){
                var btnDelete = $(this);
                var deleteYes = $('#deleteYes');
                $('#myModalDelete').modal('show');
                deleteYes.focus();
                deleteYes.click(function(){
                    var row = btnDelete.closest('tr');
                    var rowID = row.attr('class').split('_')[1];
                    $('#submitDeleteEvent').val(rowID);
                    $('#submitDeleteEventForm').submit();
                });
            });

            $('#submitDeleteEventForm').submit(function(){

                var url, values;

                url = $(this).attr('action');
                values = $(this).serialize();

                $.ajax({

                    type: 'POST',
                    url: url,
                    data: values,
                    success:function(data) {
                        if (data.trim() == 'deleted') {
                            $('#myModalDelete').modal('hide');
                            $('#myModalDeleted').modal('show');
                            $('#deletedModalClose').focus();
                        }
                    }

                });

                return false;

            });


            $('#myModalDeleted').on('hidden.bs.modal', function () {
                      window.location.href = 'events.php';
            });

            $('#eventDate').datepicker();
            $('#updateEventDate').datepicker();

            $('#insertEvent').submit(function(){

                var url, values;

                url = $(this).attr('action');
                values = $(this).serialize();

                $('#outputEvent').html('<i class="fa fa-2x fa-spinner fa-pulse animated flip"></i>');
                $('#eventInsert').prop('disabled', true);

                $.ajax({

                    type: 'POST',
                    url: url,
                    data: values,
                    success:function(data){
                        if(data.trim() == 'inserted'){
                            $('#outputEvent').html('<h2 class="animated bounceInLeft text-success lead">Event has been inserted successfully.</h2>');
                            setTimeout(function(){
                                window.location.href = 'events.php';
                            }, 2000);
                        }

                    }


                });



                return false;

            });




            $('#addevent').click(function(){
                var link = $(this);
                $('#insertEvent').slideToggle('slow', function(){
                    if($(this).is(':visible')){
                        $('.eventTable').addClass('animated zoomOut').hide(200);
                        link.html("<span>&laquo; Back</span>");
                        scroll();
                        //           window.location.hash = '#insert';
                        $('#eventTitle').focus();

                    }else{
                        scroll();
                        //   window.location.hash = '';
                        $('.eventTable').show().removeClass('animated zoomOut').addClass('animated zoomIn');
                        link.html("<span class='glyphicon glyphicon-plus'></span> Add New");
                    }
                });
            });



        });

    </script>
<?php if(isset($_SESSION['name']) || isset($_COOKIE['name'])||isset($_COOKIE['deo'])||isset($_SESSION['deo'])){ ?>
    <?php include_once('footer.php');
}else if(isset($_SESSION['student']) || isset($_COOKIE['student'])){ ?>
<?php include_once('footer_student.php'); }
    else if(isset($_SESSION['teacher']) || isset($_COOKIE['teacher'])){ ?>
        <?php include_once('footer_teacher.php'); }
}

else{
    header('Location: index.php');

} ?>


<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="scroll.js"></script>

