<?php
    session_start();

    if (!isset($_SESSION['id'])) {
        echo "<script>window.location.href = '/index.php';</script>";
    }else {
        $now = time(); // Checking the time now when home page starts.

		//echo gmdate("Y-m-d H:i:s ", $now).' hasta '.gmdate("Y-m-d H:i:s ", $_SESSION['expire']);

        if ($now > $_SESSION['expire']) {
            session_destroy();
            echo "<script>window.location.href = '/index.php?err=2';</script>";
        }else{
			// Ending a session in 15 minutes from the starting time.
    		$_SESSION['expire'] = $_SESSION['expire'] + (15 * 60);
		}
    }
?>