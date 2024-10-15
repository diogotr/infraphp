<?php

require_once '../include/db.php';

if (isset($_POST['action']) && htmlspecialchars($_POST['action'])  == 'view') {

    // Get all records from database
    $data = $db->query("SELECT id,username,created_at,usertype,status FROM users u
                               ORDER BY id DESC")->fetchAll();

    if (count($data)) {
        $output = '<table class="table table-stripped table-sm table-bordered table-hover">
        <thead>
            <tr class="text-center">
                <th>ID</th>
                <th>E-mail</th>
                <th>Created at</th>
                <th>Type</th>      
            </tr>
        </thead> 
        <tbody>';
        
        foreach ($data as $row) {
            $output .= '<tr class="text-center text-secondary">
                        <td>' . $row['id'] . '</td>
                        <td>' . $row['username'] . '</td>
                        <td>' . $row['created_at'] . '</td>
                        <td>' . ($row['usertype'] == 'A' ? 'Admin' : 'Regular')  . '</td>
                        </tr>';
        }   
        $output .= '</tbody></table>';   
        echo $output;    
    }
    else {
        echo '<h3 class="text-center text-secondary mt-5">No Users in database</h3>';
    }
}
