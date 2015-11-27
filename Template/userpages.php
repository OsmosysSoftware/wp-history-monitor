<table id="userPages" class="table table-responsive">
    <caption><h2>Pages published</h2></caption>
    <thead>
    <th>Page author</th>
    <th>Page name</th>
    <th>Page title</th>
    <th>Page status</th>
    <th>Created on</th>
    <th>Modified on</th>
    </thead>
    <tbody>
        <?php 
        if(count($data) == 0) {}
        else {
            for($i=0; $i<count($data);$i++){
            ?>
                <tr>
                    <td><?php echo $data[$i]['author']; ?></td>
                    <td><?php echo $data[$i]['name']; ?></td>
                        <?php 
                        if($data[$i]['status'] === "publish") { 
                        ?>
                            <td><a target="_blank" href="<?php echo $data[$i]['link'];?>"><?php echo $data[$i]['title']; ?></a></td>
                        <?php
                        }
                        else {
                        ?>
                            <td><?php echo $data[$i]['title']; ?></td>
                        <?php
                        }
                        ?>
                    <td><?php echo $data[$i]['status']; ?></td>
                    <td><?php echo $data[$i]['date']; ?></td>
                    <td><?php echo $data[$i]['modified']; ?></td>
                </tr>
            <?php 
            }
        }
        ?>
    </tbody>
</table>
