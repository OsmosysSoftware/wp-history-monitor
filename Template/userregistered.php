<table id="userRegistered"  class="table table-responsive">
    <caption><h2>Users registered</h2></caption>
    <thead>
    <th>User id</th>
    <th>Username</th>
    <th>Nice name</th>
    <th>Email address</th>
    <th>Registered on</th>
    <th>Display name</th>
    <th>Role</th>
    </thead>
    <tbody><?php
        if(count($data) == 0) {} 
        else {
        for($i=0; $i<count($data);$i++){?>
        <tr>
            <td><?php echo $data[$i]['id'];?></td>
            <td><?php echo $data[$i]['username'];?></td>
            <td><?php echo $data[$i]['nicename'];?></td>
            <td><?php echo $data[$i]['email'];?></td>
            <td><?php echo $data[$i]['registered'];?></td>
            <td><?php echo $data[$i]['displayname'];?></td>
            <td><?php echo $data[$i]['userrole'];?></td>
        </tr>
        <?php }}
        ?>
    </tbody>
</table>
