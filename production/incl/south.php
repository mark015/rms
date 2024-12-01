 </div>
        </div>
        <!-- /page content -->

        <!-- footer content -->
       <?php include 'incl/footer.php';?>
        <!-- /footer content -->
      </div>
    </div>
	<?php include 'incl/script.php';?>
  <?php
    if($link == "dashboard"){
      include 'script/dashboard.php'; 
    }else if($link == "profile"){
      include 'script/profile.php'; 

    }else if($link == "documents"){
      include 'script/documents.php'; 

    }
  ?>
  </body>
</html>