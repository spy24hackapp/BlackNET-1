<?php
include_once 'session.php';
include_once 'classes/Clients.php';

$clients = new Clients;
$logs = $clients->getLogs();
?>

<!DOCTYPE html>
<html>

<head>
  <?php include_once 'components/meta.php'; ?>
  <title>BlackNET - View Logs</title>
  <?php include_once 'components/css.php'; ?>
  <link href="asset/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
  <link href="asset/vendor/responsive/css/responsive.dataTables.css" rel="stylesheet">
  <link href="asset/vendor/responsive/css/responsive.bootstrap4.css" rel="stylesheet">
</head>

<body id="page-top">
  <?php include_once 'components/header.php'; ?>
  <div id="wrapper">
    <div id="content-wrapper">
      <div class="container-fluid">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">System Logs</a>
          </li>
        </ol>
        <div class="card mb-3">
          <form method="POST" action="includes/deleteLogs.php">
            <input type="text" name="csrf" hidden="" value="<?php echo ($utils->sanitize($_SESSION['csrf'])); ?>">
            <div class="card-header">
              <i class="fas fa-clipboard-check"></i>
              System Logs</div>
            <div class="card-body">
              <div class="container text-center">
                <?php if (isset($_GET['msg'])) : ?>
                  <?php if ($_GET['msg'] == "yes") : ?>
                    <div class="container container-special">
                      <div class="alert alert-success">
                        <span class="fas fa-check-circle"></span> Logs has been removed.
                      </div>
                    </div>
                  <?php elseif ($_GET['msg'] == "csrf") : ?>
                    <div class="alert alert-danger">
                      <span class="fa fa-times-circle"></span> CSRF Token is invalid.
                    </div>
                  <?php endif; ?>
                <?php endif; ?>
                <div class="table-responsive pt-4 pb-4">
                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                        <th><input <?php if (empty($logs)) {
                                      echo "disabled";
                                    } ?> type="checkbox" name="select-all" id="select-all"></th>
                        <th>Time</th>
                        <th>Victim ID</th>
                        <th>Message</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($logs as $log) : ?>
                        <tr>
                          <td><input type="checkbox" id="log[]" name="log[]" value="<?php echo $log->id; ?>"></td>
                          <td><?php echo $log->time; ?></td>

                          <td><?php echo $log->vicid; ?></td>

                          <td><?php echo $log->message; ?></td>

                          <?php if ($log->type == "Succ") : ?>
                            <td>
                              <div><span class="fas fa-check text-success"></span></div>
                            </td>
                          <?php else : ?>
                            <td>
                              <div><span class="fas fa-times text-danger"></span></div>
                            </td>
                          <?php endif; ?>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="card-footer">
              <button type="submit" class="btn btn-primary">Delete Logs</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <?php include_once 'components/footer.php'; ?>

  <?php include_once 'components/js.php'; ?>

  <script src="asset/vendor/datatables/jquery.dataTables.js"></script>
  <script src="asset/vendor/datatables/dataTables.bootstrap4.js"></script>
  <script src="asset/vendor/responsive/dataTables.responsive.js"></script>
  <script src="asset/vendor/responsive/responsive.bootstrap4.js"></script>
  <script src="asset/js/demo/datatables-demo.js"></script>
  <script type="text/javascript">
    $('#select-all').click(function(event) {
      if (this.checked) {
        $(':checkbox').each(function() {
          this.checked = true;
        });
      } else {
        $(':checkbox').each(function() {
          this.checked = false;
        });
      }
    });
  </script>
</body>

</html>