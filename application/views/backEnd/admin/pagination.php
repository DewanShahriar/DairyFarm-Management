<style>
.pagination {
  display: inline-block;
}
.curlink {
  display: inline-block;
}
.firstlink {
  display: inline-block;
}
.lastlink {
  display: inline-block;
}
.nextlink {
  display: inline-block;
}
.prevlink {
  display: inline-block;
}
.numlink {
  display: inline-block;
}



.pagination a {
  color: black;
  float: left;
  padding: 8px 16px;
  text-decoration: none;
  transition: background-color .3s;
  border: 1px solid #ddd;
}



.pagination .curlink {

    color: black;
    float: left;
    padding: 8px 16px;
    text-decoration: none;
    background-color: #4CAF50;
    transition: background-color .3s;
    border: 1px solid #ddd;
}

.pagination a.active {
  background-color: #4CAF50;
  color: white;
  border: 1px solid #4CAF50;
}

.pagination a:hover:not(.active) {background-color: #ddd;}

</style>

<div class="container">
            <h3 class="title is-3">CodeIgniter Database Pagination</h3>
            <div class="column">

                <!-- <div class="col-md-12">
                    <?php foreach ($authors as $author): ?>
                    <div class="col-md-3">
                        <p><?= $author->id ?></p>
                        <p><?= $author->first_name ?></p>
                        <p><?= $author->last_name ?></p>
                        <p><?= $author->email ?></p>
                        <p><?= $author->birthdate ?></p>
                        
                    </div>
                    <?php endforeach; ?>
                    <p><?php echo $links; ?></p>
                </div> -->
                <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Contact Name</th>
                            <th>Contact Number</th>
                            <th>Email</th>
                            <th>City</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($authors as $author): ?>
                            <tr>
                                <td><?= $author->id ?></td>
                                <td><?= $author->first_name ?></td>
                                <td><?= $author->last_name ?></td>
                                <td><?= $author->email ?></td>
                                <td><?= $author->birthdate ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <p><?php echo $links; ?></p>
            </div>
        </div>