	<?php
    
    if (isset($_POST['spinnerapikey']) and isset($_POST['spinnerapipass'])) {
        update_option('spinnerapikey', $_POST['spinnerapikey']);
        update_option('spinnerapipass', $_POST['spinnerapipass']);
        $spinnerapikey  = $_POST['spinnerapikey'];
        $spinnerapipass = $_POST['spinnerapipass'];
    } else {
        $spinnerapikey  = get_option('spinnerapikey', 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx');
        $spinnerapipass = get_option('spinnerapipass', 'xxxxxxxxx');
    }

    ?>
    <div class="wrap">
		<h2>Welcome To Arabic Spinner</h2>
        <p>You can use arabic spinner of api throw this plugin.</p>
        <p>for buy a pakcge of api please visit this <a href="http://arabicspinner.com/" title="Arabic Spinner">site</a> </p>
    </div>
    
    
    <div class="wrap">
      <h3>Api informations</h3>
      <form method="post">
         <input type="hidden" name="action" value="save_arabicspinner_option" />
         <p>Api Key: </p>
         <input type="text"  style="min-width: 350px;" placeholder="Api Key" name="spinnerapikey" value="<?php echo $spinnerapikey; ?>"/>
         <br />
         <p>Api Password:</p>
          <input type="text" style="min-width: 350px;" placeholder="Api Password" name="spinnerapipass" value="<?php echo $spinnerapipass; ?>"/>
         <br />
         <p></p>
         <input type="submit" value="Save" class="button-primary"/>
      </form>
   </div>