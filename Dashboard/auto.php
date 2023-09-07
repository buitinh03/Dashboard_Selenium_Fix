<?php include_once('inc/header.php');
    include_once('format/format.php');

?>
<?php
    $datee= getdate();
    if($datee['mday']==1){
        unset( $_SESSION['sotrang']);
        $_SESSION['sotrang']=0;
    }
    $start_time = time();
    $end_time = time() + 5*60;
    $_SESSION['sotrang']=$_SESSION['sotrang']+1;
    if($datee['mday']==3){
            ini_set('max_execution_time', (3600*24*7));
            ignore_user_abort(true);
            system('python ../backend/auto/run_chosithuoc.py');
            sleep(1);
    }else{
        while (time() < $end_time) {
        ini_set('max_execution_time', (3600*24*7));
        ignore_user_abort(true);
        // system('python ../backend/auto/thuocsi.py "'.$_SESSION['sotrang'].'"');
        // sleep(1);
        // system('python ../backend/auto/ankhang.py "'. (int)($_SESSION['sotrang'] / 10).'"');
        // sleep(1);
        // system('python ../backend/auto/pharex.py "'.$_SESSION['sotrang'].'"');
        // sleep(1);
        // system('python ../backend/auto/longchau.py "'. (int)($_SESSION['sotrang'] / 10).'"');
        // sleep(1);
        // system('python ../backend/auto/pharmacity.py "'. $_SESSION['sotrang'].'"');
        sleep(1);
        system('python ../backend/auto/medigoapp.py "'. $_SESSION['sotrang'].'"');
        $_SESSION['sotrang']=$_SESSION['sotrang']+10;
    }
    $_SESSION['sotrang']=$_SESSION['sotrang']-1;
    }
     

?>
<script>window.location.href='index.php';</script>