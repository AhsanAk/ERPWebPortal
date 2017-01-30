<?php session_start(); ?>
<?php if(isset($_COOKIE['name'])||isset($_SESSION['name'])||isset($_COOKIE['deo'])||isset($_SESSION['deo'])){ ?>

    <?php include_once('header.php'); ?>
    <?php include_once('navbar.php'); ?>
    <?php include_once('includes/connection.php');?>




    <div class="container-fluid profileHeading">
        <div class="row">
            <div class="col-sm-12">
                <h2 class="sub-header" id="sub-header">About</h2>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-12">
                <button class="btn btn-primary btn-large aboutUni">About University</button>
                <button class="btn btn-success btn-large aboutPortal">About Portal</button>
                <br>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->



        <div class="row">
            <div class="col-lg-12 aboutPortalShow" style="display:none">
                <div class="col-lg-8">
                    <h2 class="sub-header" id="sub-header" style="margin-top:10px">The Portal</h2>
                <h2>Zindagi Rahi Aur ALLAH ne chaha TOu zaroor Likhenge FILHAL NECHE JO LIKHA HAI USSE KAM CHALAO</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Distinctio possimus quis voluptatem? Adipisci amet animi eveniet pariatur quia. Culpa cupiditate esse excepturi fugiat minima officiis ut? Dolore eligendi nobis velit.</p>
                </div>
            </div>
            <div class="col-lg-12 aboutUniShow" style="display:none">
                <div class="col-lg-8">
                <h2 class="sub-header" id="sub-header" style="margin-top:10px">The University</h2>

                        <p>The foundation stone of the Dawood College of Engineering &amp; Technology was laid by the former  President of Pakistan (Late) Field Marshal Muhammad Ayub Khan in 1962. The College  was  established by Dawood Foundation under the supervision of Seth Ahmed Dawood in 1964.</p>

                        <p>On March 2013 the Sindh Assembly passed the Sindh ACT No. XII of 2013, upgrading it to a University. Its academic and administrative control has been vested in the Syndicate, Senate and Academic Council as per ACT. The Vice- Chancellor is the Principal Executive and Academic Officer of the University.</p>

                        <p>The   University offers four year degree programs in the field of engineering and Five year in the Field of architecture.</p>

                        <p>The Engineering departments include Electronics, Chemical, Industrial &amp; Management and Metallurgy &amp; Materials. From the session 2010-2011, the University has introduced four new departments namely Energy &amp; Environment, Petroleum &amp; Gas, Telecommunication, and Computer System Engineering.</p>

                        <p>The University has two campuses, one located near Quaid-e-Azam Mausoleum and the other situated at Block-17 Gulshan-e-Iqbal, Karachi.  These campuses comprise various facilities including class rooms, state of the art lending and reference libraries, laboratories, workshops, drawing halls, Students cafeteria, auditorium, with a capacity of 650, seminar rooms girls common room etc.</p>

                        <p>The University has a fleet of seven buses for pick and drop facility to the students. DUET has well-equipped computer laboratories. We are situated in the heart of Karachi with an outreach to all the Industrial zones of the city. Our students have a regular opportunity to visit industries for practical training.</p>

                        <p>It shall be pertinent to note that with the assistance and support of the Higher education commission (HEC) a Video Conference room with state of the art facilities has been established under the PERN, which also provides access to Digital library.</p>

                        <p>Realizing the importance of Quality Assurance, DUET has established its Quality Enhancement Cell in November 2009 to implement quality improvement programs in all the departments and faculties of DUET under the supervision and guideline of the Higher Education Commission and QAA.</p>

                        <p>Since DUET is located in the largest industrial city of Pakistan, various Engineering department are directly involved in providing solutions/consultation to local industries. Students are assigned final year projects with the in plant training and internship in and outside Karachi under active supervision of experts in the industry.</p>

                        <p>In order to develop entrepreneurial qualities in our students and develop a base for impact based research DUET has recently established a center for innovation research creativity learning and entrepreneurship (CIRCLE). The Center is expected to be the hub of research and also act as an incubator for our students to enter into the world of industry and business.</p></div>

            <!-- /.col-lg-12 subjectShow -->
        <div class="col-lg-4">

            <img src="images/about.jpg" style="max-width:100%; max-height:100%;"/>
            <h3 class="text-center about">About</h3>
            <img src="images/auditorium.jpg" style="max-width:100%; max-height:100%;"/>
            <h3 class="text-center about">Auditorium</h3>
            <img src="images/library.jpg" style="max-width:100%; max-height:100%;"/>
            <h3 class="text-center about">Library</h3>
        </div></div></div>
        <!-- /.row -->


    </div>


    <?php include_once('footer.php'); ?>
    <div id="spinner">
    </div>

    <script src="spinnerLoading.js"></script>
    <script src="scroll.js"></script>
    <script>
        $(document).ready(function(){



            $('.aboutUni').click(function(){
                $('.aboutPortalShow').hide('slow');
                $('.aboutUniShow').show('slow');
            });


            $('.aboutPortal').click(function(){
                $('.aboutUniShow').hide('slow');
                $('.aboutPortalShow').show('slow');
            });


        });
    </script>
<?php }

else if(isset($_SESSION['student'])||isset($_COOKIE['student'])||isset($_SESSION['teacher'])||isset($_COOKIE['teacher'])){

include_once('includes/connection.php');
include_once('header.php');

    if(isset($_SESSION['student'])||isset($_COOKIE['student'])) {
        include_once('navbar_student.php');
    }elseif(isset($_SESSION['teacher'])||isset($_COOKIE['teacher'])){
        include_once('navbar_teacher.php');
    }

?>
    <div class="container-fluid profileHeading">
        <div class="row">
            <div class="col-sm-12">
                <h2 class="sub-header" id="sub-header">About Portal</h2>
            </div>
        </div>

            <p class="lead">An <b>ERP PORTAL</b>, also known as an <b>ENTERPRISE INFORMATION PORTAL (EIP)</b>, is a framework for integrating information, people and processes across organizational boundaries in manner similar to the more general web portal. Enterprise portals provide a secure unified access point, often in the form of a web-based user interface, and are designed to aggregate and personalize information through application-specific portlets.
                One hallmark of enterprise portals is the de-centralized content contribution and content management, which keeps the information always updated. Another distinguishing characteristic is that they cater for customers, vendors and others beyond an organization's boundaries. This contrasts with a corporate portal which is structured for roles within an organization.
            </p>




    </div>
    <div id="spinner">
    </div>

    <script src="spinnerLoading.js"></script>



<?php

    if(isset($_SESSION['student'])||isset($_COOKIE['student'])) {
        include_once 'footer_student.php';
    }elseif(isset($_SESSION['teacher'])||isset($_COOKIE['teacher'])){
        include_once 'footer_teacher.php';

    }
}


else{
    header('Location: index.php');
} ?>
