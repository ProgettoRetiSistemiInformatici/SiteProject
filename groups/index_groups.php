<?php 
require '../initialization/dbconnection.php';
$current_user = $_SESSION['current_user'];
$queryforGroups = "SELECT groups.id, groups.name, groups.group_cover, groups.admin, groups.description FROM "
        . "(groups join membership on membership.group_id = groups.id) WHERE membership.member_id ='$current_user';";
if(!$groups = $mysqli->query($queryforGroups)){
    die($mysqli->error);
}



?>
<html>
<head><?php include '../shared/meta.php'; ?></head>
<body>
  <div class="container">
    <?php include '../shared/header.php'; ?>
    <?php include '../shared/menuProfile.php'; ?>
      <div class='panel panel-default'>
          <div class='panel-heading'>
              <h3 class='panel-title'>
                  Your Groups
              </h3>
          </div>
          <div class='panel-body'>
           <div class='row'>
            <?php if($groups->num_rows):?>
                <?php while($group = $groups->fetch_object()):?>
              <div class='col-sm-4'>
                <div class='panel panel-default'>
                    <div class='panel-body'>
                        <a href="group_page.php?group=<?php echo $group->id?>">
                          <img style="height:200px" class="center-block img-responsive img-rounded" src="<?php echo "group_covers/".$group->group_cover; ?>" alt="Immagine">
                        </a>
                    </div>
                    <table class='table'>
                        <ul class='list-group'>
                            <li class='list-group-item text-center'><b><?php echo $group->name; ?></b></li>
                            <li class='list-group-item'><b><?php echo $group->description; ?></b></li>
                        </ul>
                    </table>
                </div>
              </div>
               <?php endwhile;
               else: ?>
                <div class="col-sm-12">
                  <div class="panel panel-default">
                    <div class="panel-body">
                      <h4 class = 'text-center'>No groups to show</h4>
                    </div>
                  </div>
                </div>
            <?php endif;?>
          </div>
      </div>
  </div>
  </div>
</body>
</html>
